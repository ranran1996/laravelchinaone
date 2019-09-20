<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //微博表

    // 允许插入的字段
    protected $fillable = ['content'];

    // 一个微博对应一个用户
    public function user()
    {
        // 在一个目录下不用引入，直接User::class就行，不在一个目录下就要use引入或者写全路径
        // belongsTo是反向关联，一对一关系
        return $this->belongsTo(User::class);
    }
}
