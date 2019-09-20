<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

//创建授权策略
//php artisan make:policy UserPolicy
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

    //第一个参数默认为当前登录用户实例，第二个参数则为要进行授权的用户实例。
    public function update(User $currentUser, User $user)
    {
        //当两个 id 相同时，则代表两个用户是相同用户，用户通过授权
        return $currentUser->id === $user->id;
    }
}
