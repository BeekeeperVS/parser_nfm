<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220331_135926_create_table_brand
 */
class m220331_135926_create_table_brand extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%brand}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'parts_books_key' => $this->string()->null(),
            'workshop_service_manuals_key' => $this->string()->null(),
            'status_parser' => $this->integer(10)->defaultValue(STATUS_PARSER_NEW),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
        ], $this->tableOptions);

        $this->createIndex('idx-brand-id', '{{%brand}}', 'id');
        $this->createIndex('idx-brand-name', '{{%brand}}', 'name');
        $this->createIndex('idx-brand-parts_books_key', '{{%brand}}', 'parts_books_key');
        $this->createIndex('idx-brand-workshop_service_manuals_key', '{{%brand}}', 'workshop_service_manuals_key');
        $this->createIndex('idx-brand-status_parser', '{{%brand}}', 'status_parser');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%brand}}');
    }

}