<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220130_204718_create_table_ep_product_type
 */
class m220130_204718_create_table_ep_product_type extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ep_product_type}}', [
            'id' => $this->primaryKey(),
            'brand_id' => $this->integer()->notNull(),
            'ep_id' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'status_parser' => $this->integer(10)->defaultValue(STATUS_PARSER_NEW),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
        ], $this->tableOptions);

        $this->createIndex('idx-ep_product_type-brand_id', '{{%ep_product_type}}', 'brand_id');
        $this->createIndex('idx-ep_product_type-ep_id', '{{%ep_product_type}}', 'ep_id');
        $this->createIndex('idx-ep_product_type-description', '{{%ep_product_type}}', 'description');
        $this->createIndex('idx-ep_product_type-status_parser', '{{%ep_product_type}}', 'status_parser');

        $this->addForeignKey('fk-ep_product_type-brand_id', '{{%ep_product_type}}', 'brand_id','{{%ep_brand}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ep_product_type}}');
    }

}