<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
// 邮件发送功能
use Mail;

class UsersController extends Controller
{
    // 权限设置
    public function __construct()
    {

        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index', 'confirmEmail']
        ]);
    }

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
        // Auth::login($user);
        // 替换上面的，换成激活成功方法
        $this->sendEmailConfirmationTo($user);
        //成功后的提示信息
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        // 如果上一步成功了就重定向,[$user] = [$user->id]，相当于把用户信息全带过去，并直接跳转到/users/指定id地址
        // return redirect()->route('users.show', [$user]);
        return redirect('/');
    }

    // 邮件发送方法
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }

    // 用户激活方法
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }
}
