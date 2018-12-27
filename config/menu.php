<?php

return [
    [
        'name'     => '仪表盘',
        'path'     => 'dashboard',
        'icon'     => 'dashboard',
        'sort'     => 0,
        'children' => [
            [
                'name' => '工作台',
                'path' => 'workplace',
            ],
            [
                'name' => '数据分析',
                'path' => 'analysis',
            ],
            [
                'name' => '个人中心',
                'path' => 'user',
            ]
        ],
    ],
    [
        'name'     => '系统设置',
        'path'     => 'sciice',
        'icon'     => 'appstore',
        'sort'     => 1,
        'children' => [
            [
                'name'      => '账户管理',
                'path'      => 'user',
                'authorize' => 'sciice.user.index',
            ],
            [
                'name'      => '角色管理',
                'path'      => 'role',
                'authorize' => 'sciice.role.index',
            ],
            [
                'name'      => '权限管理',
                'path'      => 'authorize',
                'authorize' => 'sciice.authorize.index',
            ]
        ]
    ],
];
