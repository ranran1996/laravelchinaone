<?php

namespace App\Models;

// 消息通知相关
use Illuminate\Notifications\Notifiable;
//邮件相关
use Illuminate\Contracts\Auth\MustVerifyEmail;
//授权相关
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //Notifiable 是消息通知相关功能引用
    use Notifiable;

    /**
     * 可分配的属性。
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Gravatar 头像和侧边栏
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
}
