<?php


namespace App\Exceptions;

/**
 * 系统异常
 * Class SystemException
 * @package App\Exceptions
 */
class SystemException extends BaseException
{
    protected $code = 1001;

    protected $message = '系统发生异常，请稍后重试';
}
