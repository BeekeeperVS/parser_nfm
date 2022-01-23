<?php
namespace components\parser\eParts\actions;

use components\parser\eParts\steps\Authorization;

final class ParserCatalogAction extends ePartsBaseAction
{

    public function run()
    {
        (new Authorization())->run();
    }
}