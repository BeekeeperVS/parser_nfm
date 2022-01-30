<?php

namespace components\parser\eParts\enum;

use components\parser\enum\EnumInterface;
use JetBrains\PhpStorm\ArrayShape;

final class ActionEPartsEnum extends EPartsBaseEnum
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