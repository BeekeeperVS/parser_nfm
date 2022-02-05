<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220130_204336_create_table_ep_brand
 */
class m220130_204336_create_table_ep_brand extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ep_brand}}', [
            'id' => $this->primaryKey(),
            'ep_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),
            'status_parser' => $this->integer(10)->defaultValue(STATUS_PARSER_NEW),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
        ], $this->tableOptions);

        $this->createIndex('idx-ep_brand-ep_id', '{{%ep_brand}}', 'ep_id');
        $this->createIndex('idx-ep_brand-name', '{{%ep_brand}}', 'name');
        $this->createIndex('idx-ep_brand-code', '{{%ep_brand}}', 'code');
        $this->createIndex('idx-ep_brand-status_parser', '{{%ep_brand}}', 'status_parser');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ep_brand}}');
    }

}