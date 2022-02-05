<?php

namespace app\models\common\service;

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
 *
 * @property ParserStep[] $childSteps
 */
class ParserStep extends \app\models\common\db\ParserStep
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser_step';
    }

    public static function complete(string $parserName, string $action, string $step)
    {
        self::updateAll(['status' => STATUS_PARSER_COMPLETE], ['and', ['title' => $step], ['parser_name' => $parserName], ['action' => $action]]);
    }

    public static function active(string $parserName, string $action, string $step)
    {
        self::updateAll(['status' => STATUS_PARSER_ACTIVE], ['and', ['title' => $step], ['parser_name' => $parserName], ['action' => $action]]);
    }

    public static function error(string $parserName, string $action, string $step)
    {
        self::updateAll(['status' => STATUS_PARSER_ERROR], ['and', ['title' => $step], ['parser_name' => $parserName], ['action' => $action]]);
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

    /**
     * {@inheritdoc}
     * @return \app\models\common\query\ParserStepQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\common\query\ParserStepQuery(get_called_class());
    }

    /**
     * Gets query for [[EpProductModels]].
     *
     * @return self[]
     */
    public function getChildSteps(): array
    {
        return $this::find()->where(['parent_step' => $this->title])->all();
    }
}
