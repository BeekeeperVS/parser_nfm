<?php

namespace components\parser;

interface ParserStepInterface
{
    /**
     * @return void
     */
    public function run(): void;

    /**
     * @return bool
     */
    public function isSuccess(): bool;

}