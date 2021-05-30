<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ADMIN = 1;
    const NORMAL = 0;

    const IS_BAN = 1;
    const IS_ACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function add ($fields)
    {
        $user = new static();
        $user->fill($fields);
        $user->password = bcrypt($fields['password']);
        $user->save();

        return $user;
    }

    public function edit ($fields)
    {
        $this->fill($fields);
        $this->password = bcrypt($fields['password']);
        $this->save();
    }

    public function remove()
    {
        Storage::delete('uploads/' . $this->image);
        $this->delete();
    }

    public function uploadAvatar($image)
    {
        if ($image == null) { return; }
        Storage::delete('uploads/' . $this->image);//удалить из хранилища предыдущую картинку
        $filename = substr(md5(rand ()),4,10) . '.' . $image->extension();
        $image->saveAs('uploads', $filename);//по отношению к папке паблик
        $this->image = $filename;
        $this->save();
    }

    public function getAvatar()
    {
        if ($this->image == null)
        {
            return '/img/no-user-avatar.png';
        }
        return '/uploads/' . $this->image;
    }

    public function makeAdmin()
    {
        $this->is_admin = User::ADMIN;
        $this->save();
    }

    public function makeNormal()
    {
        $this->is_admin = User::NORMAL;
        $this->save();
    }

    public function toggleAdmin($value)
    {
        if ($value == null)
        {
            return $this->makeNormal();
        }
        return $this->makeAdmin();
    }

    public function ban()
    {
        $this->status = User::IS_BAN;
        $this->save();
    }

    public function unBan()
    {
        $this->status = User::IS_ACTIVE;
        $this->save();
    }

    public function toggleBan($value)
    {
        if ($value == null)
        {
            return $this->unBan();
        }
        return $this->ban();
    }
}
