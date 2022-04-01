<?php

namespace app\models\agconet\service;

use Yii;

/**
 * This is the model class for table "agc_parser_step".
 *
 * @property int $id
 * @property string|null $parent_step
 * @property string $parser_name
 * @property string $action
 * @property string $title
 * @property int $sort_order
 * @property int|null $status
 * @property int|null $count_error
 * @property string $created_at
 * @property string $updated_at
 */
class ParserStep extends \app\models\common\service\ParserStep
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agc_parser_step';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db3');
    }

}
