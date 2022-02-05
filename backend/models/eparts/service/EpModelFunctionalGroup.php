<?php

namespace app\models\eparts\service;

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
class EpModelFunctionalGroup extends \app\models\eparts\db\EpModelFunctionalGroup
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ep_model_functional_group';
    }

    /**
     * @param int $modelId
     * @param int $functionalGroupId
     * @return void
     */
    public static function add(int $modelId, int $functionalGroupId): void
    {
        $model = self::findOne(['and', ['product_model_id' => $modelId], ['functional_group_id' => $functionalGroupId]]) ?: new self();
        if (empty($model->id)) {
            $model->product_model_id = $modelId;
            $model->functional_group_id = $functionalGroupId;
            $model->save();
        }
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
     * @return \yii\db\ActiveQuery|\app\models\eparts\query\EpAssemblyQuery
     */
    public function getEpAssemblies()
    {
        return $this->hasMany(EpAssembly::className(), ['model_functional_group_id' => 'id']);
    }

    /**
     * Gets query for [[FunctionalGroup]].
     *
     * @return \yii\db\ActiveQuery|\app\models\eparts\query\EpFunctionalGroupQuery
     */
    public function getFunctionalGroup()
    {
        return $this->hasOne(EpFunctionalGroup::className(), ['id' => 'functional_group_id']);
    }

    /**
     * Gets query for [[ProductModel]].
     *
     * @return \yii\db\ActiveQuery|\app\models\eparts\query\EpProductModelQuery
     */
    public function getProductModel()
    {
        return $this->hasOne(EpProductModel::className(), ['id' => 'product_model_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\eparts\query\EpModelFunctionalGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\eparts\query\EpModelFunctionalGroupQuery(get_called_class());
    }
}
