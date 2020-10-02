<?php


namespace App\Services;


use App\Exceptions\AccountException;
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
}
