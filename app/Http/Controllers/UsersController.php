<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    //
    public function create()
    {
        return view('users.create');
    }

    // User是对应的User模型，$user会匹配路由片段中的{user}，这样Laravel会自动注入与请求 URI 中传入的 ID 对应的用户模型实例
    // 路由地址是/users/{user}对应这个控制器
    // 如果数据库中找不到对应的模型实例，会自动生成 HTTP 404 响应
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}
