<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

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

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        // 保存创建的用户信息，成功了会返回一个用户对象，并包含新注册用户的所有信息
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        // 让已经通过认证的用户，自动登陆的功能
        Auth::login($user);
        //成功后的提示信息
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        // 如果上一步成功了就重定向,[$user] = [$user->id]，相当于把用户信息全带过去，并直接跳转到/users/指定id地址
        return redirect()->route('users.show', [$user]);
    }
}
