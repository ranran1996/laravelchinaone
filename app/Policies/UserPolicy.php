<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    // 增加策略模式，自己不能管制自己
    public function follow(User $currentUser, User $user)
    {
        return $currentUser->id !== $user->id;
    }
}
