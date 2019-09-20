<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
// 用户模型
use App\Models\User;
// 微博模型
use App\Models\Status;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // 如果当前用户的 id 与要删除的微博作者 id 相同时，验证才能通过
    public function destroy(User $user, Status $status)
    {
        return $user->id === $status->user_id;
    }
}
