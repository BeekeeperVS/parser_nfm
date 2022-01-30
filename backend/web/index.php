<?php

// comment out the following two lines when deployed to production

require __DIR__ . '/../vendor/autoload.php';

// Environment
require(__DIR__ . '/../service/env/env.php');

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
