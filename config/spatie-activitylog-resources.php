<?php
return [
    'datetime_format' => 'd/m/Y H:i:s',
    'date_format' => 'd/m/Y',

    'activity_resource' => Marwanosama8\SpatieActivitylogResources\Resources\ActivityResource::class,

    'resources' => [
        'enabled' => false,
        'log_name' => 'Resource',
        'models' => true,
        'logger' => \Marwanosama8\SpatieActivitylogResources\Loggers\ResourceLogger::class,
        'color' => 'success',
        'exclude' => [
            //App\Filament\Resources\UserResource::class,
        ],
    ],

    'access' => [
        'enabled' => true,
        'logger' => \Marwanosama8\SpatieActivitylogResources\Loggers\AccessLogger::class,
        'color' => 'danger',
        'log_name' => 'Access',
    ],

    'notifications' => [
        'enabled' => true,
        'logger' => \Marwanosama8\SpatieActivitylogResources\Loggers\NotificationLogger::class,
        'color' => null,
        'log_name' => 'Notification',
    ],

    'models' => [
        'enabled' => true,
        'log_name' => 'Model',
        'color' => 'warning',
        'logger' => \Marwanosama8\SpatieActivitylogResources\Loggers\ModelLogger::class,
        'register' => [
            // App\Models\SalesBw::class,
        ],
    ],

    'custom' => [
        [
            'log_name' => 'default',
            'color' => 'primary',
        ]
    ],

    'nav' => [
        'group' => 'Admin'
    ]
];
