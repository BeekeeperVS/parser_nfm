<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220331_142412_create_table_scheme
 */
class m220331_142412_create_table_scheme extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%scheme}}', [
            'id' => $this->primaryKey(),
            'model_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'key' => $this->string()->notNull(),
            'parent_key' => $this->string(),
            'level' => $this->integer()->notNull(),
            'has_child' => $this->boolean(),
            'site_id' => $this->string(),
            'page_info' => $this->string(),
            'display' => $this->string(),
            'display_short' => $this->string(),
            'page_number' => $this->integer(),
            'image_url' => $this->string(),
            'image_data' => $this->json(),
            'status_parser' => $this->integer(10)->defaultValue(STATUS_PARSER_NEW),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
        ], $this->tableOptions);

        $this->createIndex('idx-scheme-model_id', '{{%scheme}}', 'model_id');
        $this->createIndex('idx-scheme-name', '{{%scheme}}', 'name');
        $this->createIndex('idx-scheme-key', '{{%scheme}}', 'key');
        $this->createIndex('idx-scheme-parent_key', '{{%scheme}}', 'parent_key');
        $this->createIndex('idx-scheme-level', '{{%scheme}}', 'level');
        $this->createIndex('idx-scheme-has_child', '{{%scheme}}', 'has_child');
        $this->createIndex('idx-scheme-status_parser', '{{%scheme}}', 'status_parser');

        $this->addForeignKey('fk-scheme-model_id', '{{%scheme}}', 'model_id', '{{%model}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-scheme-parent_key', '{{%scheme}}', 'parent_key', '{{%scheme}}', 'key', 'CASCADE');

    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%scheme}}');
    }
}