<?php
// copy this file to the /config/autoload folder and override any settings as needed
return [
    'service_manager' => [
        'services' => [
            'logging-info' => [
                'dir'	  => realpath(__DIR__ . '/../../data/logs'),
            ],
        ],
    ],
];
