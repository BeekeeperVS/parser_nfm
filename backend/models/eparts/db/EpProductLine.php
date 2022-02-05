<?php

namespace app\models\eparts\db;

use Yii;

/**
 * This is the model class for table "ep_product_line".
 *
 * @property int $id
 * @property int $type_id
 * @property string $ep_id
 * @property string $description
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EpProductModel[] $epProductModels
 * @property EpProductSeries[] $epProductSeries
 * @property EpProductType $type
 */
class EpProductLine extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ep_product_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'ep_id', 'description'], 'required'],
            [['type_id', 'status_parser'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['ep_id', 'description'], 'string', 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EpProductType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'ep_id' => 'Ep ID',
            'description' => 'Description',
            'status_parser' => 'Status Parser',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[EpProductModels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEpProductModels()
    {
        return $this->hasMany(EpProductModel::className(), ['line_id' => 'id']);
    }

    /**
     * Gets query for [[EpProductSeries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEpProductSeries()
    {
        return $this->hasMany(EpProductSeries::className(), ['line_id' => 'id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(EpProductType::className(), ['id' => 'type_id']);
    }
}
