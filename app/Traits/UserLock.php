<?php


namespace App\Traits;


trait UserLock
{
    protected $lockOwner;

    protected $lockKey;

    protected $expire;

    public function userLock($lockKey, $owner, $expire, $userId = null)
    {
        $userId          = $userId ?? auth()->id();
        $this->expire    = $expire;
        $this->lockOwner = uniqid($owner);
        $this->lockKey   = $lockKey . $userId;
        lock($this->lockKey, $expire, $this->lockOwner);
    }

    public function __destruct()
    {
        if ($this->lockOwner && $this->lockKey) {
            unlock($this->lockKey, $this->expire, $this->lockOwner);
        }
    }
}
