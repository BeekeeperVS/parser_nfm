<?php

namespace app\models\agconet\service;

use Yii;

/**
 * This is the model class for table "agc_part".
 *
 * @property int $id
 * @property int $scheme_id
 * @property string $name
 * @property string $key
 * @property string $article
 * @property int $quantity
 * @property int|null $item_id
 * @property string|null $specification
 * @property string|null $detail_parser
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Scheme $scheme
 */
class Part extends \app\models\agconet\db\Part
{
    /**
     * {@inheritdoc}
     * @return \app\models\agconet\query\PartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\agconet\query\PartQuery(get_called_class());
    }
}
