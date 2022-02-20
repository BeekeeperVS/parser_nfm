<?php

namespace app\service\fileGenerate;

/**
 * class PhpGenerateServiceInterface
 */
interface PhpGenerateServiceInterface
{
    /**
     * @param int|string $key
     * @param int|string|array $value
     * @return void
     */
    public function put(int|string $key, int|string|array $value): void;

    /**
     * @return void
     */
    public function convertOptions(): void;


    /**
     * @param string $filename
     * @param string $dir
     * @return bool
     */
    public function install(string $filename, string $dir = ''): bool;
}