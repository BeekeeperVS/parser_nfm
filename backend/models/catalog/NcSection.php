<?php

namespace app\models\catalog;

use Yii;

/**
 * This is the model class for table "nc_section".
 *
 * @property int $id
 * @property int $model_id
 * @property string $name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property NcModel $model
 * @property NcScheme[] $ncSchemes
 */
class NcSection extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nc_section';
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
            [['model_id', 'name'], 'required'],
            [['model_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 191],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => NcModel::className(), 'targetAttribute' => ['model_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => 'Model ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Model]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(NcModel::className(), ['id' => 'model_id']);
    }

    /**
     * Gets query for [[NcSchemes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNcSchemes()
    {
        return $this->hasMany(NcScheme::className(), ['section_id' => 'id']);
    }
}
