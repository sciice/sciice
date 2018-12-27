<?php

return [
    // 后台路径
    'path'       => 'sciice',

    // 中间件
    'middleware' => ['web'],

    // 是否开启多字段登录
    'many'       => false,

    // 样式
    'style'      => [
        'antd'      => 'https://unpkg.com/antd@3.11.6/dist/antd.min.css',
        //'umi'       => 'http://localhost:8000/umi.css',
    ],

    // 脚本
    'script'     => [
        'react'     => 'https://unpkg.com/react@16.7.0/umd/react.development.js',
        'react-dom' => 'https://unpkg.com/react-dom@16.7.0/umd/react-dom.development.js',
        'dva'       => 'https://unpkg.com/dva@2.4.1/dist/dva.js',
        'moment'    => 'https://unpkg.com/moment@2.23.0/min/moment.min.js',
        'antd'      => 'https://unpkg.com/antd@3.11.6/dist/antd.min.js',
        //'umi'       => 'http://localhost:8000/umi.js',
    ],
];
