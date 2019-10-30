<?php

$params = require __DIR__ . '/params.php';

$config = [
    'id'         => 'basic',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request'    => [
            'cookieValidationKey' => 'sCvztNOshoGFzcITt-7lPnYoVFJIyYDc',
        ],
        'cache'      => [
            'class' => 'yii\caching\FileCache',
        ],
        'log'        => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
        ],
    ],
    'modules'    => [
        'doc' => [
            'class'      => 'miolae\yii2\doc\Module',
            'rootDocDir' => '@app/docs',
            'cache'      => false,
        ],
    ],
    'params'     => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
