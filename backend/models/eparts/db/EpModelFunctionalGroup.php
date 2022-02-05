<?php

namespace app\models\eparts\db;

use Yii;

/**
 * This is the model class for table "ep_model_functional_group".
 *
 * @property int $id
 * @property int $product_model_id
 * @property int $functional_group_id
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EpAssembly[] $epAssemblies
 * @property EpFunctionalGroup $functionalGroup
 * @property EpProductModel $productModel
 */
class EpModelFunctionalGroup extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ep_model_functional_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_model_id', 'functional_group_id'], 'required'],
            [['product_model_id', 'functional_group_id', 'status_parser'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['functional_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => EpFunctionalGroup::className(), 'targetAttribute' => ['functional_group_id' => 'id']],
            [['product_model_id'], 'exist', 'skipOnError' => true, 'targetClass' => EpProductModel::className(), 'targetAttribute' => ['product_model_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_model_id' => 'Product Model ID',
            'functional_group_id' => 'Functional Group ID',
            'status_parser' => 'Status Parser',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[EpAssemblies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEpAssemblies()
    {
        return $this->hasMany(EpAssembly::className(), ['model_functional_group_id' => 'id']);
    }

    /**
     * Gets query for [[FunctionalGroup]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFunctionalGroup()
    {
        return $this->hasOne(EpFunctionalGroup::className(), ['id' => 'functional_group_id']);
    }

    /**
     * Gets query for [[ProductModel]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductModel()
    {
        return $this->hasOne(EpProductModel::className(), ['id' => 'product_model_id']);
    }
}
