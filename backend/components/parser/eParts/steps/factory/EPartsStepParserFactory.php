<?php
namespace components\parser\eParts\steps\factory;

use components\parser\enum\ParserEnum;
use components\parser\eParts\enum\StepEpartsEnum;
use components\parser\eParts\steps\AssemblyDetails;
use components\parser\eParts\steps\AssemblyParts;
use components\parser\eParts\steps\Authorization;
use components\parser\eParts\steps\Brands;
use components\parser\eParts\steps\ModelAssemblies;
use components\parser\eParts\steps\ModelFunctionlGroups;
use components\parser\eParts\steps\PartDetails;
use components\parser\eParts\steps\PartKits;
use components\parser\eParts\steps\PartSubstitutions;
use components\parser\eParts\steps\ProductLines;
use components\parser\eParts\steps\ProductModels;
use components\parser\eParts\steps\ProductSeries;
use components\parser\eParts\steps\ProductTypes;
use components\parser\exception\ParserException;

class EPartsStepParserFactory implements EPartsStepParserFactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function makeStep(string $stepName, array $config = []): \components\parser\eParts\steps\EPartsStepInterface
    {
        $stepList = $this->stepList();
        if(isset($stepList[$stepName])) {
            $config['class'] = $stepList[$stepName];
            return \Yii::createObject($config);
        } else {
            ParserException::stepNotFound(ParserEnum::EPARTS_PARSER, 'unknown', $stepName);
        }
    }

    /**
     * @return string[]
     */
    private function stepList(): array
    {
        return [
            StepEpartsEnum::LOGIN_STEP => Authorization::class,
            StepEpartsEnum::BRANDS_STEP => Brands::class,
            StepEpartsEnum::PRODUCT_TYPES_STEP => ProductTypes::class,
            StepEpartsEnum::PRODUCT_LINES_STEP => ProductLines::class,
            StepEpartsEnum::PRODUCT_SERIES_STEP => ProductSeries::class,
            StepEpartsEnum::PRODUCT_MODELS_STEP => ProductModels::class,
            StepEpartsEnum::MODEL_FUNCTIONAL_GROUPS_STEP => ModelFunctionlGroups::class,
            StepEpartsEnum::MODEL_ASSEMBLIES_STEP => ModelAssemblies::class,
            StepEpartsEnum::ASSEMBLY_DETAILS_STEP => AssemblyDetails::class,
            StepEpartsEnum::ASSEMBLY_PARTS_STEP => AssemblyParts::class,
            StepEpartsEnum::PARTS_DETAILS_STEP => PartDetails::class,
            StepEpartsEnum::PARTS_SUBSTITUTIONS_STEP => PartSubstitutions::class,
            StepEpartsEnum::PARTS_KITS_STEP => PartKits::class
        ];
    }
}