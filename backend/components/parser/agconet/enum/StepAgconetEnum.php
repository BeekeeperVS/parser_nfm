<?php

namespace components\parser\agconet\enum;

final class StepAgconetEnum extends AgconetBaseEnum
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
    public const PART_DETAILS_STEP = 'part-details';
    public const PART_SUBSTITUTIONS_STEP = 'part-substitutions';
    public const PART_KITS_STEP = 'part-kits';
    /**
     * @inheritDoc
     */
    public static function getList(): array
    {
        return [
//            self::LOGIN_STEP => Authorization::class,
//            self::BRANDS_STEP => Brands::class

        ];
    }
}