<?php

use app\service\migration\MigrationService;
use components\parser\agconet\actions\ParserCatalogAction;
use components\parser\enum\ParserEnum;
use components\parser\eParts\enum\StepEpartsEnum;
use yii\db\Expression;

/**
 * Class m220331_142612_init_table_parser_step
 */
class m220331_142612_init_table_parser_step extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $catalogStepList = ParserCatalogAction::orderStepParser();
        $batchParams = array_map(function ($item) {
            return [$item['parentStep'], ParserEnum::AGCONET_PARSER, ParserCatalogAction::ACTION_TITLE, $item['step'], $item['sortOrder'], STATUS_PARSER_NEW];
        }, $catalogStepList);
        $this->db->createCommand()->batchInsert('{{%parser_step}}',
            ['parent_step', 'parser_name', 'action', 'title', 'sort_order', 'status'],
            $batchParams
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%parser_step}}');
    }
}