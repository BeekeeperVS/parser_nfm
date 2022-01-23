<?php

namespace components\parser\factory;

use components\parser\enum\ParserEnum;
use components\parser\eParts\Parser;
use components\parser\exception\ParserException;
use components\parser\ParserInterface;

class ParserFactory implements ParserFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function make(string $parser): ParserInterface
    {
        return $this->getParser($parser);
    }

    /**
     * @param string $parser
     * @return ParserInterface
     * @throws ParserException
     */
    private function getParser(string $parser): ParserInterface
    {
        $parserlist = [
            ParserEnum::EPARTS_PARSER => new Parser(),
            ParserEnum::AGCOCORP_PARSER => new Parser(),
        ];

        if(isset($parserlist[$parser])) {
            return $parserlist[$parser];
        } else {
            ParserException::parserNotFound($parser);
        }
    }
}