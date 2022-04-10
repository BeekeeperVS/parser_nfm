<?php

namespace app\models\common\service\import;

use app\models\eparts\service\EpModelFunctionalGroup;

/**
 * 1) Brands            => Brands
 * 2) ProductTypes      => ProductTypes
 * 3) ProductLines      => ProductGroups
 * 4) ProductSeries     => Series
 * 5) ProductModels     => Models
 * 6) FunctionalGroup   => Section
 * 7) Assemblies        => Scheme
 *    ModelFunctionalGroup
 * 8) Parts             => Part
 * 9) Assemblies && Parts => SchemePart
 */
class ImportEpartsService implements ImportInterface
{

    public function import()
    {
        $modelFunctionalGroupObj = EpModelFunctionalGroup::findOne(1);
        
        $productModelObj  = $modelFunctionalGroupObj->productModel;
        $functionalGroupObj = $modelFunctionalGroupObj->functionalGroup;

        $schemeObjs = $modelFunctionalGroupObj->epAssemblies;
    }
}