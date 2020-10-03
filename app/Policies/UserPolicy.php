<?php

namespace App\Policies;


use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
    }

    /**
     * 模拟视频播放
     *
     * @param User $user
     * @return bool
     */
    public function playVideo(User $user)
    {
        return $user->can('视频播放');
    }

    /**
     * 模拟文档浏览
     *
     * @param User $user
     * @return bool
     */
    public function viewDoc(User $user)
    {
        return $user->can('文档浏览');
    }

    /**
     * 修改用户信息
     *
     * @param Admin $admin
     * @return bool
     */
    public function update(Admin $admin)
    {
        return $admin->can('修改用户');
    }
}
