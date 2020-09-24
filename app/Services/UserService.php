<?php


namespace App\Services;


use App\Exceptions\AccountException;
use App\Exceptions\BusinessException;

class UserService
{
    public function showUserDetailById($id)
    {
        throw new AccountException(__('reason.core_load_fail', ['msg' => 'apcu']));
    }
}
