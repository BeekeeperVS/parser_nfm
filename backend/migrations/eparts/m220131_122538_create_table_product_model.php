<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220131_122538_create_table_product_model
 */
class m220131_122538_create_table_product_model extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%ep_product_model}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'line_id' => $this->integer()->notNull(),
            'series_id' => $this->integer()->notNull(),
            'ep_id' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'model_number' => $this->string(),
            'prod_end_date' => $this->string(),
            'prod_start_date' => $this->string(),
            'is_technical_type_driven' => $this->boolean()->defaultValue(false),
            'status_parser' => $this->integer(10)->defaultValue(STATUS_PARSER_NEW),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
        ], $this->tableOptions);


        $this->createIndex('idx-ep_product_model-type_id', '{{%ep_product_model}}', 'type_id');
        $this->createIndex('idx-ep_product_model-line_id', '{{%ep_product_model}}', 'line_id');
        $this->createIndex('idx-ep_product_model-series_id', '{{%ep_product_model}}', 'series_id');
        $this->createIndex('idx-ep_product_model-ep_id', '{{%ep_product_model}}', 'ep_id');
        $this->createIndex('idx-ep_product_model-description', '{{%ep_product_model}}', 'description');
        $this->createIndex('idx-ep_product_model-status_parser', '{{%ep_product_model}}', 'status_parser');

        $this->addForeignKey('fk-ep_product_model-type_id', '{{%ep_product_model}}', 'type_id', '{{%ep_product_type}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-ep_product_model-line_id', '{{%ep_product_model}}', 'line_id', '{{%ep_product_line}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-ep_product_model-series_id', '{{%ep_product_model}}', 'series_id', '{{%ep_product_series}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ep_product_model}}');
    }

}