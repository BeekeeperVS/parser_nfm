<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parser_step".
 *
 * @property int $id
 * @property string $parser_name
 * @property string $action
 * @property string $step
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
            [['parser_name', 'action', 'step'], 'required'],
            [['status', 'count_error'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['parser_name', 'action', 'step'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parser_name' => 'Parser Name',
            'action' => 'Action',
            'step' => 'Step',
            'status' => 'Status',
            'count_error' => 'Count Error',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
