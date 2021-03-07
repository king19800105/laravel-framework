<?php


namespace App\Traits;


use GuzzleHttp\Client;

trait BatchRequest
{

    public function multiHttp(array $reqInfo)
    {
        if (0 === count($reqInfo)) {
            return null;
        }

        $defaultOpts = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ],
            'json'    => [],
            'options' => [],
            // 'body' => [],
            // 'query' => [], get时使用
            'connect_timeout' => 3.12,
//            'timeout' => 3.0 可以在client里面同一设置，也可以单个设置
        // 'version' => 1.0
        ];
        $client      = new Client($this->setClient($reqInfo));
        $requests    = function ($reqInfo) use ($client, $defaultOpts) {
            foreach ($reqInfo as $item) {
                yield function () use ($client, $item, $defaultOpts) {
                    $method = strtolower($item['method'] ?? 'get');
                    return $client->{$method . 'Async'}($item['url'], $defaultOpts);
                };
            }
        };
    }

    /**
     * 设置
     *
     * @param $reqInfo
     * @return array
     */
    protected function setClient($reqInfo): array
    {
        $clientSettings = [];
        if (!empty($reqInfo['base_uri'])) {
            $clientSettings['base_uri'] = $reqInfo['base_uri'];
        }

        if (!empty($reqInfo['timeout'])) {
            $clientSettings['timeout'] = $reqInfo['timeout'];
        }

        return $clientSettings;
    }
}
