<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220131_122530_create_table_product_series
 */
class m220131_122530_create_table_product_series extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ep_product_series}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'line_id' => $this->integer()->notNull(),
            'ep_id' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'status_parser' => $this->integer(10)->defaultValue(STATUS_PARSER_NEW),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
        ],$this->tableOptions);


        $this->createIndex('idx-ep_product_series-type_id', '{{%ep_product_series}}', 'type_id');
        $this->createIndex('idx-ep_product_series-line_id', '{{%ep_product_series}}', 'line_id');
        $this->createIndex('idx-ep_product_series-ep_id', '{{%ep_product_series}}', 'ep_id');
        $this->createIndex('idx-ep_product_series-description', '{{%ep_product_series}}', 'description');
        $this->createIndex('idx-ep_product_series-status_parser', '{{%ep_product_series}}', 'status_parser');

        $this->addForeignKey('fk-ep_product_series-type_id', '{{%ep_product_series}}', 'type_id','{{%ep_product_type}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-ep_product_series-line_id', '{{%ep_product_series}}', 'line_id','{{%ep_product_line}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ep_product_series}}');
    }

}