<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220331_142117_create_table_parts_book
 */
class m220331_142117_create_table_parts_book extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%parts_book}}', [
            'id' => $this->primaryKey(),
            'brand_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'key' => $this->string()->notNull(),
            'status_parser' => $this->integer(10)->defaultValue(STATUS_PARSER_NEW),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
        ], $this->tableOptions);


        $this->createIndex('idx-parts_book-brand_id', '{{%parts_book}}', 'brand_id');
        $this->createIndex('idx-parts_book-name', '{{%parts_book}}', 'name');
        $this->createIndex('idx-parts_book-key', '{{%parts_book}}', 'key');
        $this->createIndex('idx-parts_book-status_parser', '{{%parts_book}}', 'status_parser');

        $this->addForeignKey('fk-parts_book-brand_id', '{{%parts_book}}', 'brand_id','{{%brand}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%parts_book}}');
    }
}