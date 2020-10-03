<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
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
        return $admin->can('权限列表');
    }

    /**
     * @param Admin $admin
     * @return bool
     */
    public function view(Admin $admin)
    {
        return $admin->can('权限详情');
    }

    /**
     * @param Admin $admin
     * @return bool
     */
    public function create(Admin $admin)
    {
        return $admin->can('添加权限');
    }

    /**
     * @param Admin $admin
     * @return bool
     */
    public function update(Admin $admin)
    {
        return $admin->can('修改权限');
    }

    /**
     * @param Admin $admin
     * @return bool
     */
    public function delete(Admin $admin)
    {
        return $admin->can('删除权限');
    }
}
