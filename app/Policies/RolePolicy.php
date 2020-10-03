<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
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
        return $admin->can('角色列表');
    }

    /**
     * @param Admin $admin
     * @return bool
     */
    public function view(Admin $admin)
    {
        return $admin->can('角色详情');
    }

    /**
     * @param Admin $admin
     * @return bool
     */
    public function create(Admin $admin)
    {
        return $admin->can('添加角色');
    }

    /**
     * @param Admin $admin
     * @return bool
     */
    public function update(Admin $admin)
    {
        return $admin->can('修改角色');
    }

    /**
     * @param Admin $admin
     * @return bool
     */
    public function delete(Admin $admin)
    {
        return $admin->can('删除角色');
    }

    /**
     * 分配权限给角色
     *
     * @param Admin $admin
     * @return bool
     */
    public function assign(Admin $admin)
    {
        return $admin->can('分配权限');
    }
}
