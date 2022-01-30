<?php

namespace app\service\rest;

interface ResponseObjectInterface
{
    /**
     * @param array $response
     * @param ResponseObjectInterface|null $responseObject
     * @return static
     */
    public static function make(array $response, ResponseObjectInterface $responseObject = null): self;

    /**
     * @return array
     */
    public function resultToArray(): array;
}