<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\service\fileGenerate\PhpConfigFileGenerateService;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        $phpGenerate = new PhpConfigFileGenerateService();
        $phpGenerate->put('cookies', [
            'test22' => 'value test 2',
            'test1' => ['item1'=> 150, 'item2' => 'url', 'test1' => ['item1'=> 150, 'item2' => 'url']],
            'test2' => 'value test 2',
        ]);
        $phpGenerate->put('cookies2', [
            'test22' => 'value test 2',
            'test1' => ['item1'=> 150, 'item2' => 'url', 'test1' => ['item1'=> 150, 'item2' => 'url']],
            'test2' => 'value test 2',
        ]);
        $phpGenerate->install('parserConfig.php', \Yii::getAlias("@config"));
    }
}
