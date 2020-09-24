<?php


namespace App\Http\Middleware;


use App\Components\Logging\LogQueueHandler;
use App\Components\Queue\QueueClient;
use Illuminate\Http\Request;

/**
 * 操作日志
 * Class OperateSave
 * @package App\Http\Middleware
 */
class OperateSave
{
    protected const OPERATE_MAPPING = [
        'DELETE'   => 'delete',
        'PATCH'    => 'update',
        'PUT'      => 'update',
        'POST'     => 'create',
        'ASSIGN'   => 'assign',
        'UPLOAD'   => 'upload',
        'DOWNLOAD' => 'download',
    ];

    public function handle(Request $request, \Closure $next, $module, $type = null)
    {
        $method   = $request->method();
        $type     = $type ?? $method;
        $exec     = array_key_exists($type, static::OPERATE_MAPPING) ? static::OPERATE_MAPPING[$type] : null;
        $response = $next($request);
        if ($exec && empty($response->exception) && optional($request->user())->id) {
            log_info([
                'module' => $module,
                'exec'   => $exec,
            ], LogQueueHandler::OPERATE_LOG_QUEUE_KEY);
        }

        return $response;
    }
}
