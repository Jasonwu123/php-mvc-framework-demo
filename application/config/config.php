<?php

/**
 * 应用配置文件
 * 使用数组方式
 */
return [
    // 数据库的连接参数配置
    'db' => [
        'user'   => 'edu',
        'pass'   => '123456',
        'dbname' => 'edu',
    ],

    // 应用的整体配置
    'app' => [
        'default_platform' => 'home', // 默认模块
    ],

    // 前台配置
    'home' => [
        'default_controller' => 'Student', // 默认控制器
        'default_action'     => 'listAll', // 默认方法
    ],

    // 后台配置
    'admin' => [
        'default_controller' => '',  // 默认控制器
        'default_action'     => '',  // 默认方法
    ],
];
