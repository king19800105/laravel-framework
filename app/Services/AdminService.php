<?php


namespace App\Services;


use App\Exceptions\AccountException;
use App\Repositories\Contracts\AdminRepository;

class AdminService
{
    protected $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * 添加管理员
     *
     * @param array $data
     * @throws \Throwable
     */
    public function storeAdmin(array $data)
    {
        $roleIds = $data['role_ids'] ?? [];
        throw_unless(
            $this->adminRepository->create($data, $roleIds),
            new AccountException(__('reason.store_fail'))
        );
    }

    /**
     * 管理员列表
     *
     * @return mixed
     */
    public function getAdminList()
    {
        return $this->adminRepository->findList();
    }

    /**
     * 获取管理员
     *
     * @param $id
     * @return mixed
     */
    public function getAdmin($id)
    {
        return $this->adminRepository->findById($id);
    }

    /**
     * 修改管理员
     *
     * @param array $data
     * @param $id
     * @throws \Throwable
     */
    public function updateAdmin(array $data, $id)
    {
        $roleIds = $data['role_ids'] ?? [];
        throw_unless(
            $this->adminRepository->update($data, $id, $roleIds),
            new AccountException(__('reason.update_fail'))
        );
    }

    /**
     * 删除管理员
     *
     * @param $id
     * @throws \Throwable
     */
    public function deleteAdmin($id)
    {
        throw_unless(
            $this->adminRepository->delete($id),
            new AccountException(__('reason.delete_fail'))
        );
    }

}
