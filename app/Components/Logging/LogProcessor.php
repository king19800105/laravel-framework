<?php


namespace App\Components\Logging;


class LogProcessor
{
    public function __invoke(array $record)
    {
        $request         = request();
        $record['extra'] = [
            'ip'         => $request->server('REMOTE_ADDR'),
            'origin'     => $request->headers->get('origin'),
            'user_id'    => auth()->user() ? auth()->user()->id : null,
            'user_agent' => $request->server('HTTP_USER_AGENT'),
            'params'     => $request->all(),
            'api'        => optional($request->route())->uri()
        ];

        return $record;
    }
}
