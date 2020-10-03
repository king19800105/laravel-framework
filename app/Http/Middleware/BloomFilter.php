<?php


namespace App\Http\Middleware;


use App\Exceptions\NoneException;
use Illuminate\Http\Request;
use Illuminate\Redis\RedisManager;
use Illuminate\Support\Facades\DB;

/**
 * 布隆过滤器
 * Class BloomFilter
 * @package App\Http\Middleware
 */
class BloomFilter
{
    protected $redis;

    protected $execType;

    protected const KEY_PREFIX = 'bloom:filter:id:';

    protected const
        GET_HANDLER = 'get', CREATE_HANDLER = 'create', DELETE_HANDLER = 'delete';

    protected const OPERATE_MAPPING = [
        'DELETE' => self::DELETE_HANDLER,
        'POST'   => self::CREATE_HANDLER,
        'GET'    => self::GET_HANDLER
    ];

    public function __construct(RedisManager $redis)
    {
        $this->redis = $redis;
    }

    public function handle(Request $request, \Closure $next, $name, $opt = null)
    {
        $this->execType = null === $opt
            ? (self::OPERATE_MAPPING[$request->method()] ?? null)
            : $this->execType = strtolower($opt);
        if (!empty($this->execType) && self::GET_HANDLER === $this->execType) {
            $this->getHandler($name);
        }

        $response = $next($request);
        if (
            empty($response->exception)
            && !empty($this->execType)
            && in_array($this->execType, [self::DELETE_HANDLER, self::CREATE_HANDLER])
            && $method = $this->execType . 'Handler') {
            $this->{$method}($name);
        }

        return $response;
    }

    protected function getHandler($name)
    {
        $key = self::KEY_PREFIX . $name;
        $id  = request($name) ?? null;
        if (!$id) {
            return;
        }

        $id += 0;
        if (!$this->redis->getBit($key, $id)) {
            throw new NoneException();
        }
    }

    protected function deleteHandler($name)
    {
        if ($id  = request($name)) {
            $this->run(self::DELETE_HANDLER, $name, $id);
        }
    }

    protected function createHandler($name)
    {
        if ($id = optional(DB::getPdo())->lastInsertId()) {
            $this->run(self::CREATE_HANDLER, $name, $id);
        }
    }

    protected function run($type, $name, $id)
    {
        $key = self::KEY_PREFIX . $name;
        $id  += 0;
        if ($type === self::CREATE_HANDLER) {
            $this->redis->setBit($key, $id, 1);
            return;
        }

        $this->redis->setBit($key, $id, 0);
        return;
    }
}
