<?php

namespace components\parser;

class ParserA implements ParserInterface
{
    public function run()
    {
        return self::class;
    }
}