<?php
return [
    'guards' => [
        'sciice' => [
            'driver'   => 'session',
            'provider' => 'sciice',
        ]
    ],

    'providers' => [
        'sciice' => [
            'driver' => 'eloquent',
            'model'  => \Sciice\Model\Sciice::class,
        ],
    ]
];
