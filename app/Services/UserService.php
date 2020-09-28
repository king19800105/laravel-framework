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

    public function getUserByMobile($mobile)
    {
        return $this->userRepository->findByMobile($mobile);
    }
}
