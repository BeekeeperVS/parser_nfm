<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220331_142405_create_table_model
 */
class m220331_142405_create_table_model extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%model}}', [
            'id' => $this->primaryKey(),
            'model_id' =>  $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'site_id' => $this->string()->notNull(),
            'book_id' => $this->integer()->notNull(),
            'first_page_id' => $this->string(),
            'key' => $this->string(),
            'status' => $this->integer()->null(),
            'status_parser' => $this->integer(10)->defaultValue(STATUS_PARSER_NEW),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
        ], $this->tableOptions);

        $this->createIndex('idx-model-model_id', '{{%model}}', 'model_id');
        $this->createIndex('idx-model-name', '{{%model}}', 'name');
        $this->createIndex('idx-model-key', '{{%model}}', 'key');
        $this->createIndex('idx-model-site_id', '{{%model}}', 'site_id');
        $this->createIndex('idx-model-book_id', '{{%model}}', 'book_id');
        $this->createIndex('idx-model-status', '{{%model}}', 'status');
        $this->createIndex('idx-model-status_parser', '{{%model}}', 'status_parser');

        $this->addForeignKey('fk-model-model_id', '{{%model}}', 'model_id','{{%model_group}}', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%model}}');
    }

}