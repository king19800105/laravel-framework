<?php


namespace App\Exceptions;

/**
 * 账户异常
 * Class AccountException
 * @package App\Exceptions
 */
class AccountException extends BaseException
{
    protected $code = 2001;

    protected $message = '账户信息错误';
}
