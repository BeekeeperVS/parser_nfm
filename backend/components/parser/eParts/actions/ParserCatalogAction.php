<?php
namespace components\parser\eParts\actions;

use components\parser\eParts\steps\Authorization;
use components\parser\eParts\steps\GetBrands;

final class ParserCatalogAction extends ePartsBaseAction
{

    public function run()
    {
        (new GetBrands())->run();
    }
}