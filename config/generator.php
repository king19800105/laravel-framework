<?php

return [
    'temp_path'  => [
        'base'       => app_path('Console/Commands/stubs/'),
        'controller' => 'controller_full.stub',
        'request'    => ['destroy_request_full.stub', 'show_request_full.stub', 'store_request_full.stub', 'update_request_full.stub'],
        'responder'  => ['index_responder_full.stub', 'show_responder_full.stub', 'index_no_page_responder_full.stub'],
        'service'    => 'service_full.stub',
        'model'      => 'model_full.stub',
    ],
    'namespace'  => [
        'controller' => 'App\Http\Controllers\Backend',
        'request'    => 'App\Http\Requests',
        'responder'  => 'App\Http\Responders',
        'service'    => 'App\Services',
        'model'      => 'App\Models',
        'repository' => ['App\Repositories\Contracts', 'App\Repositories\Eloquent']
    ],
    'repository' => [
        'contract' => 'App\Repositories\Contracts',
        'eloquent' => 'App\Repositories\Eloquent',
        'provider' => 'App\Providers',
        'file'     => [
            'contract' => '%sRepository.php',
            'eloquent' => '%sRepositoryEloquent.php',
            'provider' => 'RepositoryServiceProvider.php',
        ]
    ]
];
