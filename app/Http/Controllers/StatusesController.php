<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    //对微博的创建和删除必须要先经过登陆认证
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 创建微博的方法
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);

        // Auth::user()表示指定用户模型，可以保证创建的微博和用户一一对应
        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);
        session()->flash('success', '发布成功！');
        return redirect()->back();
    }
}
