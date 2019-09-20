<?php

namespace App\Models;

// 消息通知相关
use Illuminate\Notifications\Notifiable;
//邮件相关
use Illuminate\Contracts\Auth\MustVerifyEmail;
//授权相关
use Illuminate\Foundation\Auth\User as Authenticatable;
// 监听事件相关
use Illuminate\Support\Str;

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

    // 事件监听，boot 方法会在用户模型类完成初始化之后进行加载，因此我们对事件的监听需要放在该方法中。
    public static function boot()
    {
        parent::boot();
        // creating 用于监听模型被创建之前的事件，created 用于监听模型被创建之后的事件。
        static::creating(function ($user) {
            $user->activation_token = Str::random(10);
        });
    }

    // 定义一对多关联，一对多一般方法用复数形式比较好
    // 一个用户对应可以发布多个微博
    public function statuses()
    {
        // 关联的表是status
        return $this->hasMany(Status::class);
    }
}
