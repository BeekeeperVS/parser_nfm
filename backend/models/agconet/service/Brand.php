<?php

namespace app\models\agconet\service;

use Yii;

/**
 * This is the model class for table "agc_brand".
 *
 * @property int $id
 * @property string $name
 * @property string $parts_books_key
 * @property string $workshop_service_manuals_key
 * @property int|null $status_parser
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PartsBook[] $partsBooks
 */
class Brand extends \app\models\agconet\db\Brand
{

    /**
     * {@inheritdoc}
     * @return \app\models\agconet\query\BrandQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\agconet\query\BrandQuery(get_called_class());
    }
}
