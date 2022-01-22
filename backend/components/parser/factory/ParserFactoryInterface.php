<?php

namespace components\parser\factory;

use components\parser\ParserInterface;

interface ParserFactoryInterface
{
    public function make(): ParserInterface;
}