<?php


namespace App\Http\Middleware;


use App\Components\Logging\LogQueueHandler;
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
        $type     = $type ?? $request->method();
        $exec     = array_key_exists($type, self::OPERATE_MAPPING) ? self::OPERATE_MAPPING[$type] : null;
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
