<?php


namespace App\Listeners;


use App\Events\AdminLoginEvent;

class UpdateLoginStatus
{
    public function __construct()
    {
        // todo... 可以依赖注入服务
    }

    public function handle(AdminLoginEvent $event)
    {
        $info = $event->getLoginInfo();
    }
}
