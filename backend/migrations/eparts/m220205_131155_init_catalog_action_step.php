<?php

use app\service\migration\MigrationService;
use components\parser\enum\ParserEnum;
use components\parser\eParts\actions\ParserCatalogAction;
use components\parser\eParts\enum\StepEpartsEnum;

/**
 * Class m220205_131155_init_catalog_action_step
 */
class m220205_131155_init_catalog_action_step extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $catalogStepList = ParserCatalogAction::orderStepParser();
        $batchParams = array_map(function ($item) {
            return [$item['parentStep'], ParserEnum::EPARTS_PARSER, ParserCatalogAction::ACTION_TITLE, $item['step'], $item['sortOrder'], $item['step'] === StepEpartsEnum::LOGIN_STEP ? STATUS_PARSER_COMPLETE : STATUS_PARSER_NEW];
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