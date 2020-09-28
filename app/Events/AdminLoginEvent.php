<?php

namespace App\Events;


use Illuminate\Queue\SerializesModels;

class AdminLoginEvent
{
    use SerializesModels;

    protected $loginInfo;

    /**
     * AdminLoginEvent constructor.
     * @param $loginInfo
     */
    public function __construct($loginInfo)
    {
        $this->loginInfo = $loginInfo;
    }

    /**
     * 获取登入信息
     *
     * @return mixed
     */
    public function getLoginInfo()
    {
        return $this->loginInfo;
    }

}
