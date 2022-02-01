<?php

namespace app\models\catalog;

use Yii;

/**
 * This is the model class for table "nc_product_type".
 *
 * @property int $id
 * @property string $external_id
 * @property int $brand_id
 * @property string $name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property NcBrand $brand
 * @property NcProductGroup[] $ncProductGroups
 */
class NcProductType extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nc_product_type';
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
            [['external_id', 'brand_id', 'name'], 'required'],
            [['brand_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['external_id'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 191],
            [['external_id'], 'unique'],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => NcBrand::className(), 'targetAttribute' => ['brand_id' => 'id']],
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
            'brand_id' => 'Brand ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Brand]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(NcBrand::className(), ['id' => 'brand_id']);
    }

    /**
     * Gets query for [[NcProductGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNcProductGroups()
    {
        return $this->hasMany(NcProductGroup::className(), ['product_type_id' => 'id']);
    }
}
