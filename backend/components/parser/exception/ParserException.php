<?php

namespace components\parser\exception;

class ParserException extends \Exception
{
    /**
     * @param string $parser
     * @return void
     * @throws ParserException
     */
    public static function parserNotFound(string $parser): void
    {
        throw new self(sprintf(
            "Parser <%s> NotFonund",
            $parser
        ));
    }

    /**
     * @param string $parser
     * @param string $action
     * @return void
     * @throws ParserException
     */
    public static function actionNotFound(string $parser, string $action): void
    {
        throw new self(sprintf(
            "Action <%s> NotFound in parser <%s>",
            $action,
            $parser
        ));
    }


    /**
     * @param string $parser
     * @param string $action
     * @return void
     * @throws ParserException
     */
    public static function stepNotFound(string $parser, string $action, string $step): void
    {
        throw new self(sprintf(
            "Step <%s> NotFound in parser <%s>.<%s>",
            $step,
            $parser,
            $action
        ));
    }
}