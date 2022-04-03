<?php

use components\parser\factory\ParserFactoryInterface;

return [
    'singletons' => [
        ParserFactoryInterface::class => \components\parser\factory\ParserFactory::class
    ]
];
