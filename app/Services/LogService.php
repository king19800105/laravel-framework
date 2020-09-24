<?php


namespace App\Services;


use App\Repositories\Contracts\ErrorLogRepository;
use App\Repositories\Contracts\OperateLogRepository;

class LogService
{
    protected $errorLog;

    protected $operateLog;

    public function __construct(ErrorLogRepository $errorLog, OperateLogRepository $operateLog)
    {
        $this->errorLog   = $errorLog;
        $this->operateLog = $operateLog;
    }

    public function createOperateLog($data)
    {
        return $this
            ->operateLog
            ->create($data);
    }

    public function createErrorLog($data)
    {
        return $this
            ->errorLog
            ->create($data);
    }
}
