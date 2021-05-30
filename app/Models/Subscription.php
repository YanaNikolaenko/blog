<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    public static function add ($email)
    {
        $sub = new static();
        $sub->email = $email;
        $sub->token = substr(md5(rand ()),1,50);
        $sub->save();
    }

    public function remove()
    {
        $this->delete();
    }
}
