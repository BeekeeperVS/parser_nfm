<?php

namespace app\models\agconet\service;

use Yii;

/**
 * This is the model class for table "agc_parts_book".
 *
 * @property int $id
 * @property int $brand_id
 * @property string $name
 * @property string $key
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Brand $brand
 * @property ModelGroup[] $modelGroups
 */
class PartsBook extends \app\models\agconet\db\PartsBook
{
    /**
     * {@inheritdoc}
     * @return \app\models\agconet\query\PartsBookQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\agconet\query\PartsBookQuery(get_called_class());
    }
}
