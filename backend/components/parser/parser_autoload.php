<?php

$namespaceReplace = [
    'components\\parser\\' => ''
];

spl_autoload_register(function ($class) use ($namespaceReplace) {
    $class = strtr($class, $namespaceReplace);
    $path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    require $path;
});