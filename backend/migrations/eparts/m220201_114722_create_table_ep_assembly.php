<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220201_114722_create_table_ep_assembly
 */
class m220201_114722_create_table_ep_assembly extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%ep_assembly}}', [
            'id' => $this->primaryKey(),
            'model_functional_group_id' => $this->integer()->notNull(),
            'ep_id' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),
            'name' => $this->string(),
            'has_note' => $this->boolean(),
            'image' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'details' => $this->json(),
            'status_parser' => $this->integer(10)->defaultValue(STATUS_PARSER_NEW),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
        ], $this->tableOptions);

        $this->createIndex('idx-ep_assembly-model_functional_group_id', '{{%ep_assembly}}', 'model_functional_group_id');
        $this->createIndex('idx-ep_assembly-ep_id', '{{%ep_assembly}}', 'ep_id');
        $this->createIndex('idx-ep_assembly-code', '{{%ep_assembly}}', 'code');
        $this->createIndex('idx-ep_assembly-name', '{{%ep_assembly}}', 'name');
        $this->createIndex('idx-ep_assembly-status_parser', '{{%ep_assembly}}', 'status_parser');

        $this->addForeignKey('fk-ep_assembly-model_functional_group_id',
            '{{%ep_assembly}}',
            'model_functional_group_id',
            '{{%ep_model_functional_group}}',
            'id',
            'CASCADE'
        );
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ep_assembly}}');
    }

}