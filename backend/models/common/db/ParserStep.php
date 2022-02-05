<?php

namespace app\models\common\db;

use Yii;

/**
 * This is the model class for table "parser_step".
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
class ParserStep extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser_step';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parser_name', 'action', 'title', 'sort_order'], 'required'],
            [['sort_order', 'status', 'count_error'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['parent_step', 'parser_name', 'action', 'title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_step' => 'Parent Step',
            'parser_name' => 'Parser Name',
            'action' => 'Action',
            'title' => 'Title',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
            'count_error' => 'Count Error',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
