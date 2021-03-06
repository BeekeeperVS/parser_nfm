<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'container' => require __DIR__ . '/container/_console.php',
    'controllerNamespace' => 'app\commands',
    'controllerMap' => [
        'migrate-eparts' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => '@app/migrations/eparts',
            'templateFile' => '@app/service/migration/views/migrationTemplate.php',
            'migrationTable' => '{{%system_migration}}',
            'db' => 'db'
        ],
        'migrate-catalog' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => '@app/migrations/catalog',
            'templateFile' => '@app/service/migration/views/migrationTemplate.php',
            'migrationTable' => '{{%system_migration}}',
            'db' => 'db2'
        ],
        'migrate-agconet' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => '@app/migrations/agconet',
            'templateFile' => '@app/service/migration/views/migrationTemplate.php',
            'migrationTable' => '{{%system_migration}}',
            'db' => 'db3'
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
        '@config' => 'config'
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db['eparts'],
        'db2' => $db['catalog'],
        'db3' => $db['agconet']
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
