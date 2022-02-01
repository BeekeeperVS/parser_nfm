<?php

namespace app\models\catalog;

use Yii;

/**
 * This is the model class for table "nc_series".
 *
 * @property int $id
 * @property string $external_id
 * @property int $product_group_id
 * @property string $name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property NcModel[] $ncModels
 * @property NcProductGroup $productGroup
 */
class NcSeries extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nc_series';
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
            [['external_id', 'product_group_id', 'name'], 'required'],
            [['product_group_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['external_id'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 191],
            [['external_id'], 'unique'],
            [['product_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => NcProductGroup::className(), 'targetAttribute' => ['product_group_id' => 'id']],
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
            'product_group_id' => 'Product Group ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[NcModels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNcModels()
    {
        return $this->hasMany(NcModel::className(), ['series_id' => 'id']);
    }

    /**
     * Gets query for [[ProductGroup]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductGroup()
    {
        return $this->hasOne(NcProductGroup::className(), ['id' => 'product_group_id']);
    }
}
