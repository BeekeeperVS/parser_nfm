<?php

namespace app\models\catalog;

use Yii;

/**
 * This is the model class for table "nc_scheme".
 *
 * @property int $id
 * @property string $external_id
 * @property int $model_id
 * @property int $section_id
 * @property string $name
 * @property string $assembly_image
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property NcModel $model
 * @property NcSchemePart[] $ncSchemeParts
 * @property NcSection $section
 */
class NcScheme extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nc_scheme';
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
            [['external_id', 'model_id', 'section_id', 'name', 'assembly_image'], 'required'],
            [['model_id', 'section_id'], 'integer'],
            [['assembly_image'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['external_id'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 191],
            [['external_id'], 'unique'],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => NcModel::className(), 'targetAttribute' => ['model_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => NcSection::className(), 'targetAttribute' => ['section_id' => 'id']],
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
            'model_id' => 'Model ID',
            'section_id' => 'Section ID',
            'name' => 'Name',
            'assembly_image' => 'Assembly Image',
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
     * Gets query for [[NcSchemeParts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNcSchemeParts()
    {
        return $this->hasMany(NcSchemePart::className(), ['scheme_id' => 'id']);
    }

    /**
     * Gets query for [[Section]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(NcSection::className(), ['id' => 'section_id']);
    }
}
