<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    const SHOW = 1;
    const UNSHOW = 0;

    public function post()
    {
        return $this->hasOne(Post::class);
    }

    public function author()
    {
        return $this->hasOne(User::class);
    }

    public function allow()
    {
        $this->status = Comment::SHOW;
        $this->save();
    }

    public function disAllow()
    {
        $this->status = Comment::UNSHOW;
        $this->save();
    }

    public function toggleStatus()
    {
        if($this->status == 0)
        {
            $this->allow();
        }
        else
        {
            $this->disAllow();
        }
    }
}
