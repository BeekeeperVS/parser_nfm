<?php

namespace app\models\eparts;

use Yii;

/**
 * This is the model class for table "ep_assembly".
 *
 * @property int $id
 * @property int $model_functional_group_id
 * @property string $ep_id
 * @property string $code
 * @property string|null $name
 * @property int|null $has_note
 * @property string|null $image
 * @property string|null $details
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EpPart[] $epParts
 * @property EpModelFunctionalGroup $modelFunctionalGroup
 */
class EpAssembly extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ep_assembly';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_functional_group_id', 'ep_id', 'code'], 'required'],
            [['model_functional_group_id', 'status_parser'], 'integer'],
            [['image'], 'string'],
            ['has_note', 'boolean'],
            [['details', 'created_at', 'updated_at'], 'safe'],
            [['ep_id', 'code', 'name'], 'string', 'max' => 255],
            [['model_functional_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => EpModelFunctionalGroup::className(), 'targetAttribute' => ['model_functional_group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_functional_group_id' => 'Model Functional Group ID',
            'ep_id' => 'Ep ID',
            'code' => 'Code',
            'name' => 'Name',
            'has_note' => 'Has Note',
            'image' => 'Image',
            'details' => 'Details',
            'status_parser' => 'Status Parser',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[EpParts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEpParts()
    {
        return $this->hasMany(EpPart::className(), ['assembly_id' => 'id']);
    }

    /**
     * Gets query for [[ModelFunctionalGroup]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModelFunctionalGroup()
    {
        return $this->hasOne(EpModelFunctionalGroup::className(), ['id' => 'model_functional_group_id']);
    }
}
