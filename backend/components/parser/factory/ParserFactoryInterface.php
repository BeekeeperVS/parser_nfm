<?php

namespace components\parser\factory;

use components\parser\exception\ParserException;
use components\parser\ParserInterface;

interface ParserFactoryInterface
{
    /**
     * @param string $parser
     * @return ParserInterface
     * @throws ParserException
     */
    public function make(string $parser): ParserInterface;
}