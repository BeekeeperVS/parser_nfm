<?php

namespace components\parser\agconet\enum;

final class ActionAgconetEnum extends AgconetBaseEnum
{
    public const PARSER_CATALOG_ACTION = 'catalog';

    /**
     * @return string[]
     */
    public static function getList(): array
    {
        return [
            self::PARSER_CATALOG_ACTION => self::PARSER_CATALOG_ACTION
        ];
    }
}