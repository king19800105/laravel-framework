<?php


namespace App\Services;


use App\Exceptions\AccountException;
use App\Exceptions\BusinessException;
use App\Exceptions\SystemException;
use App\Http\Requests\Role\AssignRequest;
use App\Repositories\Contracts\PermissionRepository;
use App\Repositories\Contracts\RoleRepository;

class PermissionService
{
    protected $roleRepository;

    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository, RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }


    /**
     * 保存权限
     *
     * @param array $data
     * @throws \Throwable
     */
    public function storePermission(array $data)
    {
        throw_unless(
            $this->permissionRepository->create($data),
            new AccountException(__('reason.store_fail'))
        );
    }

    /**
     * 修改权限
     *
     * @param array $data
     * @param $id
     * @throws \Throwable
     */
    public function updatePermission(array $data, $id)
    {
        throw_unless(
            $this->permissionRepository->update($data, $id),
            new AccountException(__('reason.store_fail'))
        );
    }

    /**
     * 删除管理员
     *
     * @param $id
     * @throws \Throwable
     */
    public function deletePermission($id)
    {
        throw_unless(
            $this->permissionRepository->delete($id),
            new AccountException(__('reason.delete_fail'))
        );
    }

    /**
     * 获取权限列表
     *
     * @return mixed
     */
    public function getPermissionList()
    {
        return $this->permissionRepository->findList();
    }

    /**
     * 添加角色
     *
     * @param array $data
     * @throws \Throwable
     */
    public function storeRole(array $data)
    {
        throw_unless(
            $this->roleRepository->create($data),
            new AccountException(__('reason.store_fail'))
        );
    }

    /**
     * 修改管理员
     *
     * @param array $data
     * @param $id
     * @throws \Throwable
     */
    public function updateRole(array $data, $id)
    {
        throw_unless(
            $this->roleRepository->update($data, $id),
            new AccountException(__('reason.store_fail'))
        );
    }

    /**
     * 删除角色
     * 如果角色下有权限，则不能删除
     *
     * @param $id
     * @throws \Throwable
     */
    public function deleteRole($id)
    {
        $result = $this->roleRepository->findById($id);
        if (null === $result) {
            throw new SystemException(__('reason.illegal_id'));
        }

        if ($result->name === config('manage.super_name')) {
            throw new SystemException(__('reason.super_delete'));
        }

        throw_unless(
            $this->roleRepository->delete($id),
            new AccountException(__('reason.delete_fail'))
        );
    }

    /**
     * 分配权限
     *
     * @param $roleId
     * @param $permissionIds
     * @throws \Throwable
     */
    public function assignPermissions($roleId, $permissionIds)
    {
        throw_unless(
            $this->roleRepository->assign($roleId, $permissionIds),
            new SystemException(__('reason.store_fail'))
        );
    }

    /**
     * 获取角色详情
     *
     * @param $id
     * @return mixed
     */
    public function getRole($id)
    {
        return $this->roleRepository->findById($id);
    }

    /**
     * 角色列表
     *
     * @return mixed
     */
    public function getRoleList()
    {
        return $this->roleRepository->findList();
    }
}
