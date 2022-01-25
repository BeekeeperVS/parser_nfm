<?php

namespace components\parser\enum;

abstract class ParserEnum implements EnumInterface
{
    public const EPARTS_PARSER = 'e_parts';
    public const AGCOCORP_PARSER = 'agcocorp';

    /**
     * {@inheritDoc}
     */
    public static function getList(): array
    {
        return [
            self::EPARTS_PARSER => self::EPARTS_PARSER,
            self::AGCOCORP_PARSER => self::AGCOCORP_PARSER
        ];
    }

}