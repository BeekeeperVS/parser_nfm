<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220331_142417_create_table_part
 */
class m220331_142417_create_table_part extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%part}}', [
            'id' => $this->primaryKey(),
            'scheme_id' =>  $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'key' => $this->string()->notNull(),
            'article' => $this->string()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'item_id' => $this->integer(),
            'specification' => $this->string(),
            'detail_parser' => $this->json(),
            'status_parser' => $this->integer(10)->defaultValue(STATUS_PARSER_NEW),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
        ], $this->tableOptions);

        $this->createIndex('idx-part-scheme_id', '{{%part}}', 'scheme_id');
        $this->createIndex('idx-part-name', '{{%part}}', 'name');
        $this->createIndex('idx-part-key', '{{%part}}', 'key');
        $this->createIndex('idx-part-article', '{{%part}}', 'article');
        $this->createIndex('idx-part-quantity', '{{%part}}', 'quantity');
        $this->createIndex('idx-part-specification', '{{%part}}', 'specification');
        $this->createIndex('idx-part-status_parser', '{{%part}}', 'status_parser');

        $this->addForeignKey('fk-part-scheme_id', '{{%part}}', 'scheme_id','{{%scheme}}', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%part}}');
    }


}