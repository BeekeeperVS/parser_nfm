<?php
$ip = env('IP_SERVER');
return [
    //ePart
    'eparts' => [
        'class' => 'yii\db\Connection',
        'dsn' => "mysql:host=$ip;dbname=nfm_eparts",
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        // Schema cache options (for production environment)
        //'enableSchemaCache' => true,
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
    ],

    // NfmCatalog
    'catalog' => [
        'class' => 'yii\db\Connection',
        'dsn' => "mysql:host=$ip;dbname=nfm_catalog",
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8'
        // Schema cache options (for production environment)
        //'enableSchemaCache' => true,
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
    ],

    // Agconet
    'agconet' => [
        'class' => 'yii\db\Connection',
        'dsn' => "mysql:host=$ip;dbname=nfm_agconet",
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'tablePrefix' => 'agc_',
        // Schema cache options (for production environment)
        //'enableSchemaCache' => true,
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
    ],
];
