<?php

namespace app\models\catalog;

use Yii;

/**
 * This is the model class for table "nc_scheme_part".
 *
 * @property int $id
 * @property int $scheme_id
 * @property int $part_id
 * @property string $position
 * @property int $quantity
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property NcPart $part
 * @property NcScheme $scheme
 */
class NcSchemePart extends \app\service\db\ActiveRecordService
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nc_scheme_part';
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
            [['scheme_id', 'part_id', 'position', 'quantity'], 'required'],
            [['scheme_id', 'part_id', 'quantity'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['position'], 'string', 'max' => 191],
            [['part_id'], 'exist', 'skipOnError' => true, 'targetClass' => NcPart::className(), 'targetAttribute' => ['part_id' => 'id']],
            [['scheme_id'], 'exist', 'skipOnError' => true, 'targetClass' => NcScheme::className(), 'targetAttribute' => ['scheme_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scheme_id' => 'Scheme ID',
            'part_id' => 'Part ID',
            'position' => 'Position',
            'quantity' => 'Quantity',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Part]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPart()
    {
        return $this->hasOne(NcPart::className(), ['id' => 'part_id']);
    }

    /**
     * Gets query for [[Scheme]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getScheme()
    {
        return $this->hasOne(NcScheme::className(), ['id' => 'scheme_id']);
    }
}
