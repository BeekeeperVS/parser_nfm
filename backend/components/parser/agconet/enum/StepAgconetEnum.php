<?php

namespace components\parser\agconet\enum;

final class StepAgconetEnum extends AgconetBaseEnum
{
    public const LOGIN_STEP = 'login';
    public const BRANDS_STEP = 'brands';
    public const BRAND_ITEM_STEP = 'brand-item';
    public const CATALOG_PATS_STEP = 'catalog-pats';
    public const MODEL_GROUPS_STEP = 'model-groups';
    public const MODELS_STEP = 'models';
    public const MODEL_SCHEMES_STEP = 'model-schemes';
    public const SCHEMES_STEP = 'schemes';
    public const SCHEME_DETAIL_STEP = 'scheme-detail';

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