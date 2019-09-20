<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    //显示登陆页面
    public function create()
    {
        return view('sessions.create');
    }

    //登陆操作
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        // Auth::attempt() 方法可接收两个参数，第一个参数为需要进行用户身份认证的数组，第二个参数为是否为用户开启『记住我』功能的布尔值，true表示开启，false表示不开启
        if (Auth::attempt($credentials, $request->has('remember'))) {
            // 登陆成功相关操作
            session()->flash('success', '欢迎回来！');
            // Auth::user() 获取当前登陆用户的信息,相当于把用户信息全带过去，并直接跳转到/users/指定id地址
            // dd(Auth::user());
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            // 登陆失败相关操作
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');

            return redirect()->back()->withInput();
        }
    }

    // 退出
    public function destroy()
    {
        // laravel默认退出功能
        Auth::logout();

        session()->flash('success', '您已成功退出！');

        return redirect('login');
    }
}
