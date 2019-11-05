<?php

use miolae\yii2\doc\Module as DocModule;
use yii\debug\Module;
use yii\log\FileTarget;

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
            'class' => yii\caching\FileCache::class,
        ],
        'log'        => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '/<page:[\w\/-]+>' => 'doc/default/index',
                '/'                => 'doc/default/index',
            ],
        ],
    ],
    'modules'    => [
        'doc' => [
            'class'      => DocModule::class,
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
        'class' => Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
