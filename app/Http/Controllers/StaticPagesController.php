<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class StaticPagesController extends Controller
{
    //
    public function home()
    {
        $feed_items = [];
        // 判断是否登陆了
        if (Auth::check()) {
            // 登陆了，从当前用户信息Auth::user()的feed方法每页取出30条
            $feed_items = Auth::user()->feed()->paginate(30);
        }

        return view('static_pages/home', compact('feed_items'));
    }

    public function help()
    {
        return view('static_pages/help');
    }

    public function about()
    {
        return view('static_pages/about');
    }
}
