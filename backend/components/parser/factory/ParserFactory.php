<?php

namespace components\parser\factory;

use components\parser\ParserA;
use components\parser\ParserInterface;

class ParserFactory implements ParserFactoryInterface
{

    public function make(): ParserInterface
    {
        return new ParserA();
    }
}