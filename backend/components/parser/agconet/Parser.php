<?php

namespace components\parser\agconet;

use components\parser\agconet\actions\ParserCatalogAction;
use components\parser\agconet\enum\ActionAgconetEnum;
use components\parser\exception\ParserException;
use components\parser\ParserActionInterface;

class Parser implements AgconetParserInterface
{
    public const PARSER_NAME = 'agconet';
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
            ActionAgconetEnum::PARSER_CATALOG_ACTION => new ParserCatalogAction(),
        ];
        if(isset($actionList[$action])) {
            return $actionList[$action];
        } else {
            ParserException::actionNotFound(self::PARSER_NAME, $action);
        }
    }
}