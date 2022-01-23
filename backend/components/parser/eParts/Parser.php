<?php

namespace components\parser\eParts;

use components\parser\eParts\actions\ParserCatalogAction;
use components\parser\eParts\enum\ParserActionEnum;
use components\parser\exception\ParserException;
use components\parser\ParserActionInterface;

class Parser implements ePartsParserInterface
{
    public const PARSER_NAME = 'eParts';
    /**
     * {@inheritDoc}
     */
    public function run(string $action): void
    {
        $actionModel = $this->getAction($action);
        $actionModel->run();
    }

    /**
     * @param string $action
     * @return ParserActionInterface
     * @throws ParserException
     */
    private function getAction(string $action): ParserActionInterface
    {
        /** @var array $actionList */
        $actionList = [
            ParserActionEnum::PARSER_CATALOG_ACTION => new ParserCatalogAction(),
        ];
        if(isset($actionList[$action])) {
            return $actionList[$action];
        } else {
            ParserException::actionNotFound(self::PARSER_NAME, $action);
        }
    }
}