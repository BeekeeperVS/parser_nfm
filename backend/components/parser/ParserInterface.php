<?php

namespace components\parser;

interface ParserInterface
{
    /**
     * @param string $action
     * @return void
     */
    public function run(string $action): void;

}