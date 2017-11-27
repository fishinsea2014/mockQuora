<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public function add(){
        if (!user_ins())
        return 'add a comment';
    }
}
