<?php


namespace App\Exceptions;


/**
 * 资金异常
 * Class FundException
 * @package App\Exceptions
 */
class FundException extends BaseException
{
    protected $code = 3001;

    protected $message = '资金相关操作失败';
}
