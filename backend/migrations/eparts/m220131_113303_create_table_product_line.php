<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220131_113303_create_table_product_line
 */
class m220131_113303_create_table_product_line extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//        productLineDescription: "ANKARA ENGINES - TTF"
//productLineId: "EU_B_M_03_ANK"
        $this->createTable('{{%ep_product_line}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'ep_id' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'status_parser' => $this->integer(10)->defaultValue(STATUS_PARSER_NEW),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
        ], $this->tableOptions);


        $this->createIndex('idx-ep_product_line-type_id', '{{%ep_product_line}}', 'type_id');
        $this->createIndex('idx-ep_product_line-ep_id', '{{%ep_product_line}}', 'ep_id');
        $this->createIndex('idx-ep_product_line-description', '{{%ep_product_line}}', 'description');
        $this->createIndex('idx-ep_product_line-status_parser', '{{%ep_product_line}}', 'status_parser');

        $this->addForeignKey('fk-ep_product_line-type_id', '{{%ep_product_line}}', 'type_id','{{%ep_product_type}}', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ep_product_line}}');
    }

}