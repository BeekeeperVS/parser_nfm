<?php

namespace components\parser\eParts\enum;

final class ParserStepEnum extends ePartsBaseEnum
{
    public const LOGIN_STEP = 'login';

    /**
     * @inheritDoc
     */
    public static function getList(): array
    {
        return [
            self::LOGIN_STEP => self::LOGIN_STEP
        ];
    }
}