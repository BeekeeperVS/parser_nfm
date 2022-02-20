<?php

namespace components\parser\enum;

abstract class ParserEnum implements EnumInterface
{
    public const EPARTS_PARSER = 'e_parts';
    public const AGCONET_PARSER = 'agconet';

    /**
     * {@inheritDoc}
     */
    public static function getList(): array
    {
        return [
            self::EPARTS_PARSER => self::EPARTS_PARSER,
            self::AGCONET_PARSER => self::AGCONET_PARSER
        ];
    }

}