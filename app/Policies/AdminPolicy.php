<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
    }

    /**
     * @param Admin $admin
     * @return bool
     */
    public function viewAny(Admin $admin)
    {
        return $admin->can('管理员列表');
    }

    /**
     * @param Admin $admin
     * @return bool
     */
    public function view(Admin $admin)
    {
        return $admin->can('管理员详情');
    }

    /**
     * @param Admin $admin
     * @return bool
     */
    public function create(Admin $admin)
    {
        return $admin->can('添加管理员');
    }

    /**
     * @param Admin $admin
     * @return bool
     */
    public function update(Admin $admin)
    {
        return $admin->can('修改管理员');
    }

    /**
     * @param Admin $admin
     * @return bool
     */
    public function delete(Admin $admin)
    {
        return $admin->can('删除管理员');
    }
}
