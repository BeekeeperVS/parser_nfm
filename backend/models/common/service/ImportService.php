<?php

namespace app\models\common\service;

use app\models\common\service\import\ImportAgconetSrvice;
use app\models\common\service\import\ImportEpartsService;
use app\models\common\service\import\ImportInterface;
use components\parser\enum\ParserEnum;

class ImportService
{

    public static function importDb(string $parserName)
    {
        $importObj = self::makeImportService($parserName);
        if (!empty($importObj)) {
            $importObj->import();
        }
    }

    /**
     * @param string $parserName
     * @return ImportInterface|null
     */
    private static function makeImportService(string $parserName): ?ImportInterface
    {
        $importServiceList = [
            ParserEnum::EPARTS_PARSER => new ImportEpartsService(),
            ParserEnum::AGCONET_PARSER => new ImportAgconetSrvice()
        ];

        return $importServiceList[$parserName] ?? null;
    }
}