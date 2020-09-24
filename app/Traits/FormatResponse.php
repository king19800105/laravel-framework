<?php


namespace App\Traits;


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Trait FormatResponse
 * @package App\Traits
 */
trait FormatResponse
{
    /**
     * 统一格式化相应
     *
     * @param array $data 结果集数据
     * @param int $code 响应码
     * @param string $message 提示
     * @return array
     */
    public function format($data = [], int $code = 0, string $message = 'success')
    {
        return self::formatResponse($data, $code, $message);
    }

    /**
     * 静态实现
     *
     * @param array $data
     * @param int $code
     * @param string $message
     * @return array
     */
    protected static function formatResponse($data = [], int $code = 0, string $message = 'success')
    {
        $ret = [
            'code' => $code,
            'msg'  => $message,
            'data' => '{}'
        ];
        if (
            is_array($data)
            || $data instanceof LengthAwarePaginator
            || $data instanceof Collection
        ) {
            $ret['data'] = $data;
            return $ret;
        }

        if (is_object($data)) {
            $ret['data'] = (array)$data;
        }

        return $ret;
    }
}
