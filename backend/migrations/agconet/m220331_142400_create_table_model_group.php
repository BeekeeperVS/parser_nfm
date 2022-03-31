<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220331_142400_create_table_model_group
 */
class m220331_142400_create_table_model_group extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%model_group}}', [
            'id' => $this->primaryKey(),
            'parts_book_id' =>  $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'key' => $this->string()->notNull(),
            'status_parser' => $this->integer(10)->defaultValue(STATUS_PARSER_NEW),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
        ], $this->tableOptions);

        $this->createIndex('idx-model_group-parts_book_id', '{{%model_group}}', 'parts_book_id');
        $this->createIndex('idx-model_group-name', '{{%model_group}}', 'name');
        $this->createIndex('idx-model_group-key', '{{%model_group}}', 'key');
        $this->createIndex('idx-model_group-status_parser', '{{%model_group}}', 'status_parser');

        $this->addForeignKey('fk-model_group-parts_book_id', '{{%model_group}}', 'parts_book_id','{{%parts_book}}', 'id', 'CASCADE');

    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%model_group}}');
    }

}