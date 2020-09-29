<?php


namespace App\Services;


use App\Exceptions\AccountException;
use App\Repositories\Contracts\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * 通用用户id获取用户信息
     *
     * @param $id
     * @return mixed
     */
    public function getUser($id)
    {
        return $this->userRepository->findById($id);
    }

    /**
     * 创建用户
     *
     * @param array $data
     * @throws \Throwable
     */
    public function storeUser(array $data)
    {
        throw_unless(
            $this->userRepository->create($data),
            new AccountException(__('reason.store_fail'))
        );
    }

    /**
     * 修改用户
     *
     * @param array $data
     * @param $id
     * @throws \Throwable
     */
    public function updateUser(array $data, $id)
    {
        throw_unless(
            $this->userRepository->update($data, $id),
            new AccountException(__('reason.update_fail'))
        );
    }

    /**
     * 根据手机号获取用户信息
     *
     * @param $mobile
     * @return mixed
     */
    public function getUserByMobile($mobile)
    {
        return $this->userRepository->findByMobile($mobile);
    }

    /**
     * 用户列表
     *
     * @return mixed
     */
    public function getUserList()
    {
        return $this->userRepository->findList();
    }

    /**
     * 删除用户（软删除）
     *
     * @param $id
     * @throws \Throwable
     */
    public function deleteUser($id)
    {
        throw_unless(
            $this->userRepository->delete($id),
            new AccountException(__('reason.delete_fail'))
        );
    }
}
