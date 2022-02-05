<?php
/**
 * Require helpers
 */
require_once(__DIR__ . '/helpers.php');

/**
 * Load application environment from .env file
 */

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

/**
 * Init application constants
 */
defined('YII_DEBUG') or define('YII_DEBUG', env('YII_DEBUG'));
defined('YII_ENV') or define('YII_ENV', env('YII_ENV', 'prod'));

defined('PARSER_STATUS') or define('PARSER_STATUS', env('PARSER_STATUS'));
/** Parser Statuses */
defined('STATUS_PARSER_NEW') or define('STATUS_PARSER_NEW', 0);
defined('STATUS_PARSER_ACTIVE') or define('STATUS_PARSER_ACTIVE', 100);
defined('STATUS_PARSER_COMPLETE') or define('STATUS_PARSER_COMPLETE', 200);
defined('STATUS_PARSER_ERROR') or define('STATUS_PARSER_ERROR', 300);
