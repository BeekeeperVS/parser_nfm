<?php

namespace components\parser\eParts\enum;

use components\parser\eParts\steps\Authorization;
use components\parser\eParts\steps\Brands;

final class StepEpartsEnum extends EPartsBaseEnum
{
    public const LOGIN_STEP = 'login';
    public const BRANDS_STEP = 'brands';
    public const PRODUCT_TYPES_STEP = 'product-types';
    public const PRODUCT_LINES_STEP = 'product-lines';
    public const PRODUCT_SERIES_STEP = 'product-series';
    public const PRODUCT_MODELS_STEP = 'product-models';
    public const MODEL_FUNCTIONAL_GROUPS_STEP = 'model-functional-groups';
    public const MODEL_ASSEMBLIES_STEP = 'model-assemblies';
    public const ASSEMBLY_DETAILS_STEP = 'assembly-details';
    public const ASSEMBLY_PARTS_STEP = 'assembly-parts';
    public const PARTS_DETAILS_STEP = 'parts-details';
    public const PARTS_SUBSTITUTIONS_STEP = 'parts-substitutions';
    public const PARTS_KITS_STEP = 'parts-kits';
    /**
     * @inheritDoc
     */
    public static function getList(): array
    {
        return [
            self::LOGIN_STEP => Authorization::class,
            self::BRANDS_STEP => Brands::class

        ];
    }
}