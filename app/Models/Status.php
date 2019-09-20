<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //微博表

    // 一个用户可以创建多个微博，是一对多关系，关联的模型是user模型
    public function user()
    {
        // 在一个目录下不用引入，直接User::class就行，不在一个目录下就要use引入或者写全路径
        return $this->belongsTo(User::class);
    }
}
