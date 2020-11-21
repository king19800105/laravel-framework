<?php


namespace App\Traits;


trait AtomicLock
{
    protected $lockOwner;

    protected $lockKey;

    protected $expire;

    protected $autoFree = true;

    /**
     * 上锁
     *
     * @param $lockKey
     * @param $owner
     * @param $expire
     * @return $this
     * @throws \Illuminate\Contracts\Cache\LockTimeoutException
     */
    public function addLock($lockKey, $owner, $expire)
    {
        $this->lockKey   = $lockKey;
        $this->expire    = $expire;
        $this->lockOwner = uniqid($owner);
        lock($this->lockKey, $expire, $this->lockOwner);
        return $this;
    }

    /**
     * 手动解锁
     */
    public function unLock()
    {
        if ($this->lockKey && $this->expire && $this->lockOwner) {
            unlock($this->lockKey, $this->expire, $this->lockOwner);
        }
    }

    /**
     * 是否释放锁
     *
     * @param bool $free
     * @return $this
     */
    public function setAutoFree(bool $free)
    {
        $this->autoFree = $free;
        return $this;
    }

    /**
     * 析构解锁
     */
    public function __destruct()
    {
        if ($this->autoFree && $this->lockOwner && $this->lockKey) {
            unlock($this->lockKey, $this->expire, $this->lockOwner);
        }
    }
}
