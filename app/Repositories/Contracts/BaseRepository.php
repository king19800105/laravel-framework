<?php


namespace App\Repositories\Contracts;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Mavinoo\Batch\Batch;

abstract class BaseRepository implements IRepository
{
    protected const ERROR_ENTITY = '模型实体不存在';

    protected const PAGE_NUM = 20;

    protected const CACHE_PREFIX = 'repository:';

    protected const DEFAULT_CACHE_TIME = 60;

    /**
     * 当前模型对象
     *
     * @var \Illuminate\Database\Eloquent\Model | \Illuminate\Database\Eloquent\Builder;
     */
    protected $model;

    protected $batch;

    /**
     * BaseRepository constructor.
     * @param Batch $batch
     * @throws \Throwable
     */
    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
        $this->resolveEntity();
        $this->boot();
    }

    /**
     * 初始化加载器，子类重写后使用
     */
    protected function boot()
    {
        if ('local' === config('app.env')) {
            DB::connection()->enableQueryLog();
        }
    }

    /**
     * 执行事务
     * 传入匿名函数就是自动，不传入就是手动
     *
     * @param callable|null $callback
     */
    public static function transaction(callable $callback = null)
    {
        if (is_null($callback)) {
            DB::beginTransaction();
            return;
        }

        DB::transaction($callback);
    }

    /**
     * 事务回滚
     */
    public static function rollBack()
    {
        DB::rollBack();
    }

    /**
     * 事务提交
     */
    public static function commit()
    {
        DB::commit();
    }

    /**
     * 获取当前的model对象
     *
     * @throws \Throwable
     */
    public function resolveEntity()
    {
        throw_if(
            !method_exists($this, 'entity'),
            new Exception(static::ERROR_ENTITY)
        );

        $this->model = app($this->entity());
    }

    /**
     * 批量处理
     *
     * @param array $data
     * @param string $index
     * @return bool|int
     */
    public function batchUpdate(array $data, string $index = 'id')
    {
        return $this->batch->update($this->model, $data, $index);
    }

    /**
     * 返回日志
     *
     * @return mixed
     */
    protected function sqlPrint()
    {
        return DB::getQueryLog();
    }

    /**
     * 使用缓存来记录数据
     *
     * @param $key
     * @param callable $callableOnMiss
     * @param null $tag
     * @param int $second
     * @return mixed
     */
    protected function getOrCache($key, callable $callableOnMiss, $tag = null, $second = self::DEFAULT_CACHE_TIME)
    {
        $key = static::CACHE_PREFIX . $key;
        return Cache::tags($tag)->remember($key, $second, $callableOnMiss);
    }

    /**
     * 根据标记删除并处理业务
     *
     * @param $tag
     * @param callable $callableOnMiss
     * @return bool
     */
    protected function cleanByTag($tag, callable $callableOnMiss)
    {
        $ok = $callableOnMiss();
        if ($ok) {
            Cache::tags($tag)->flush();
        }

        return $ok;
    }

}
