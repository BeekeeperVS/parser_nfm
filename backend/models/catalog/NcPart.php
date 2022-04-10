<?php

namespace app\models\catalog;

use Yii;

/**
 * This is the model class for table "nc_part".
 *
 * @property int $id
 * @property string $number
 * @property string $name
 * @property string $image
 * @property string $usage
 * @property string $description
 * @property float $weight
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property NcSchemePart[] $ncSchemeParts
 */
class NcPart extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nc_part';
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
            [['number', 'name', 'usage', 'description', 'weight'], 'required'],
            [['image', 'description'], 'string'],
            [['weight'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['number', 'name', 'usage'], 'string', 'max' => 191],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'name' => 'Name',
            'image' => 'Image',
            'usage' => 'Usage',
            'description' => 'Description',
            'weight' => 'Weight',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[NcSchemeParts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNcSchemeParts()
    {
        return $this->hasMany(NcSchemePart::className(), ['part_id' => 'id']);
    }
}
