<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\catalog\NcBrand;
use app\models\catalog\NcModel;
use app\models\catalog\NcProductGroup;
use app\models\catalog\NcProductType;
use app\models\catalog\NcSeries;
use app\models\common\service\ImportService;
use app\models\eparts\service\EpBrand;
use app\models\eparts\service\EpProductLine;
use app\models\eparts\service\EpProductModel;
use app\models\eparts\service\EpProductSeries;
use app\models\eparts\service\EpProductType;
use components\parser\enum\ParserEnum;
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
class ImportAgcController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
            ImportService::importDb(ParserEnum::AGCONET_PARSER);
    }

}
