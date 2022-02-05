<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220130_203649_create_table_parser_step
 */
class m220130_203649_create_table_parser_step extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%parser_step}}', [
            'id' => $this->primaryKey(),
            'parent_step' => $this->string(100)->null(),
            'parser_name' => $this->string(100)->notNull(),
            'action' => $this->string(100)->notNull(),
            'title' => $this->string(100)->notNull(),
            'sort_order' => $this->integer(100)->notNull(),
            'status' => $this->integer(10)->defaultValue(0),
            'count_error' => $this->integer()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
        ], $this->tableOptions);

        $this->createIndex('idx-parser_step-parent_step', '{{%parser_step}}', 'parent_step');
        $this->createIndex('idx-parser_step-parser_name', '{{%parser_step}}', 'parser_name');
        $this->createIndex('idx-parser_step-action', '{{%parser_step}}', 'action');
        $this->createIndex('idx-parser_step-title', '{{%parser_step}}', 'title');
        $this->createIndex('idx-parser_step-sort_order', '{{%parser_step}}', 'sort_order');
        $this->createIndex('idx-parser_step-status', '{{%parser_step}}', 'status');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("{{%parser_step}}");
    }

}