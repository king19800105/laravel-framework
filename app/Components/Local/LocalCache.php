<?php


namespace App\Components\Local;

/**
 * Interface LocalCache
 * @package App\Components\Contract
 */
interface LocalCache
{
    public function localSet($key, $var, $ttl = 60);

    public function localGet($key);

    public function localHas($key);

    public function localDel($key);

    public function localCleanAll();
}
