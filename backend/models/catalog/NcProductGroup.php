<?php

namespace app\models\catalog;

use Yii;

/**
 * This is the model class for table "nc_product_group".
 *
 * @property int $id
 * @property string $external_id
 * @property int $product_type_id
 * @property string $name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property NcSeries[] $ncSeries
 * @property NcProductType $productType
 */
class NcProductGroup extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nc_product_group';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['external_id', 'product_type_id', 'name'], 'required'],
            [['product_type_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['external_id'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 191],
            [['external_id'], 'unique'],
            [['product_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => NcProductType::className(), 'targetAttribute' => ['product_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'external_id' => 'External ID',
            'product_type_id' => 'Product Type ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[NcSeries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNcSeries()
    {
        return $this->hasMany(NcSeries::className(), ['product_group_id' => 'id']);
    }

    /**
     * Gets query for [[ProductType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(NcProductType::className(), ['id' => 'product_type_id']);
    }
}
