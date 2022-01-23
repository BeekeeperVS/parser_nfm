<?php

namespace components\parser\eParts\enum;

use components\parser\enum\EnumInterface;
use JetBrains\PhpStorm\ArrayShape;

final class ParserActionEnum extends ePartsBaseEnum
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