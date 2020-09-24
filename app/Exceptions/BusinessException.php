<?php


namespace App\Exceptions;

/**
 * 业务处理异常
 * Class BusinessException
 * @package App\Exceptions
 */
class BusinessException extends BaseException
{
    protected $code = 9001;

    protected $message = '业务处理失败';
}
