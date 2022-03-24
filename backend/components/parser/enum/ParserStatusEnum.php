<?php

namespace components\parser\enum;

abstract class ParserStatusEnum implements EnumInterface
{
    public const NEW = 0;
    public const IN_ACTIVE = 1;
    public const COMPLETE = 2;
    public const ERROR = 3;
    /**
     * @inheritDoc
     */
    public static function getList(): array
    {
        return [];// TODO: Implement getList() method.
    }
}