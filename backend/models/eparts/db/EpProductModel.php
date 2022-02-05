<?php

namespace app\models\eparts\db;

use Yii;

/**
 * This is the model class for table "ep_product_model".
 *
 * @property int $id
 * @property int $type_id
 * @property int $line_id
 * @property int $series_id
 * @property string $ep_id
 * @property string $description
 * @property string|null $model_number
 * @property string|null $prod_end_date
 * @property string|null $prod_start_date
 * @property int|null $is_technical_type_driven
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EpModelFunctionalGroup[] $epModelFunctionalGroups
 * @property EpProductLine $line
 * @property EpProductSeries $series
 * @property EpProductType $type
 */
class EpProductModel extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ep_product_model';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'line_id', 'series_id', 'ep_id', 'description'], 'required'],
            [['type_id', 'line_id', 'series_id', 'is_technical_type_driven', 'status_parser'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['ep_id', 'description', 'model_number', 'prod_end_date', 'prod_start_date'], 'string', 'max' => 255],
            [['line_id'], 'exist', 'skipOnError' => true, 'targetClass' => EpProductLine::className(), 'targetAttribute' => ['line_id' => 'id']],
            [['series_id'], 'exist', 'skipOnError' => true, 'targetClass' => EpProductSeries::className(), 'targetAttribute' => ['series_id' => 'id']],
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
            'line_id' => 'Line ID',
            'series_id' => 'Series ID',
            'ep_id' => 'Ep ID',
            'description' => 'Description',
            'model_number' => 'Model Number',
            'prod_end_date' => 'Prod End Date',
            'prod_start_date' => 'Prod Start Date',
            'is_technical_type_driven' => 'Is Technical Type Driven',
            'status_parser' => 'Status Parser',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[EpModelFunctionalGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEpModelFunctionalGroups()
    {
        return $this->hasMany(EpModelFunctionalGroup::className(), ['product_model_id' => 'id']);
    }

    /**
     * Gets query for [[Line]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLine()
    {
        return $this->hasOne(EpProductLine::className(), ['id' => 'line_id']);
    }

    /**
     * Gets query for [[Series]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeries()
    {
        return $this->hasOne(EpProductSeries::className(), ['id' => 'series_id']);
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
