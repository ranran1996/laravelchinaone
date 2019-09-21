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
        // 关联的表是status,默认第二个参数就是这个本控制器名ser加上_id为外键，就是user_id，如果在xxx模型中定义关联
        // 就是第二个默认值就是xxx_id了
        return $this->hasMany(Status::class);
        // 当然你也可以自己写清楚外键，不用默认外键
        // foreign_key 是指App\Comment模型中的外键user_id，local_key是指User模型的主键值,默认是id,如果user模型主键字段不是id，就需要自己定义了
        // return $this->hasMany('App\Comment', 'foreign_key', 'local_key');
    }

    // 获取当前登陆用户的发布的所有微博
    public function feed()
    {
        return $this->statuses()
            ->orderBy('created_at', 'desc');
    }

    // 我的粉丝模型表，多对对，因为关注和粉丝都是用一个用户表，所以是自己关联自己，默认关系表名称是user_user，索引要指定第二个参数修改默认表名，用自己定义的表名followers做关系表
    public function followers()
    {
        return $this->belongsToMany(User::Class, 'followers', 'user_id', 'follower_id');
    }

    // 我的关注模型表，反向多对多
    public function followings()
    {
        return $this->belongsToMany(User::Class, 'followers', 'follower_id', 'user_id');
    }

    // 关注逻辑
    public function follow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);
    }

    // 取消关注逻辑
    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    // 判断当前登陆用户，是否关注了某个用户
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }
}
