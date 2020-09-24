<?php


namespace App\Components\Local;


use App\Exceptions\SystemException;

/**
 * Class APCuLocalCache
 * @package App\Components
 */
class APCuLocalCache implements LocalCache
{

    /**
     * APCuLocalCache constructor.
     * @throws SystemException
     */
    public function __construct()
    {
        if (!extension_loaded('apcu')) {
            throw new SystemException(__('reason.core_load_fail', ['msg' => 'apc']));
        }
    }

    /**
     * 设置缓存
     *
     * @param $key
     * @param null $var
     * @param int $ttl
     *
     * @return array|bool
     */
    public function localSet($key, $var, $ttl = -1)
    {
        if (!is_string($key) || '' === $key) {
            return false;
        }

        if (-1 === $ttl) {
            $ttl = 0;
        }

        return apcu_store($key, $var, $ttl);
    }

    /**
     * 获取缓存
     *
     * @param $key
     *
     * @return mixed
     */
    public function localGet($key)
    {
        $result = apcu_fetch($key);
        if (is_bool($result)) {
            return intval($result) . '';
        }

        if (is_numeric($result)) {
            return $result . '';
        }

        return $result;
    }

    /**
     * key是否存在
     *
     * @param $key
     *
     * @return bool|string[]
     */
    public function localHas($key)
    {
        return apcu_exists($key);
    }

    /**
     * 删除本地缓存
     *
     * @param $key
     *
     * @return bool|string[]
     */
    public function localDel($key)
    {
        return apcu_delete($key);
    }

    /**
     * 清除所有本地缓存
     *
     * @return bool
     */
    public function localCleanAll()
    {
        return apcu_clear_cache();
    }
}
