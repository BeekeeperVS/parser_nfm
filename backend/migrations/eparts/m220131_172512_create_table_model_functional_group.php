<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220131_172512_create_table_model_functional_group
 */
class m220131_172512_create_table_model_functional_group extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ep_model_functional_group}}', [
            'id' => $this->primaryKey(),
            'product_model_id' => $this->integer()->notNull(),
            'functional_group_id' => $this->integer()->notNull(),
            'status_parser' => $this->integer(10)->defaultValue(STATUS_PARSER_NEW),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
        ], $this->tableOptions);


        $this->createIndex('idx-ep_model_functional_group-product_model_id', '{{%ep_model_functional_group}}', 'product_model_id');
        $this->createIndex('idx-ep_model_functional_group-functional_group_id', '{{%ep_model_functional_group}}', 'functional_group_id');
        $this->createIndex('idx-ep_model_functional_group-status_parser', '{{%ep_model_functional_group}}', 'status_parser');

        $this->addForeignKey('fk-ep_model_functional_group-functional_group_id',
            '{{%ep_model_functional_group}}',
            'functional_group_id',
            '{{%ep_functional_group}}',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-ep_model_functional_group-product_model_id',
            '{{%ep_model_functional_group}}',
            'product_model_id',
            '{{%ep_product_model}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ep_model_functional_group}}');
    }

}