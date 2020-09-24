<?php


namespace App\Exceptions;


class NoneException extends BaseException
{
    protected $code = 0;

    protected $message = 'success';
}
