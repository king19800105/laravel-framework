<?php


namespace App\Listeners;


use App\Events\AdminLoginEvent;

class SendSMSNotice
{
    protected $smsService;

    public function __construct()
    {
        // todo... 可以依赖注入服务
    }

    public function handle(AdminLoginEvent $event)
    {
        $info = $event->getLoginInfo();
    }
}
