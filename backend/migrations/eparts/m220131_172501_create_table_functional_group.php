<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220131_172501_create_table_functional_group
 */
class m220131_172501_create_table_functional_group extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ep_functional_group}}', [
            'id' => $this->primaryKey(),
            'ep_id' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
        ],$this->tableOptions);

        $this->createIndex('idx-ep_functional_group-ep_id', '{{%ep_functional_group}}', 'ep_id');
        $this->createIndex('idx-ep_functional_group-code', '{{%ep_functional_group}}', 'code');
        $this->createIndex('idx-ep_functional_group-description', '{{%ep_functional_group}}', 'description');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ep_functional_group}}');
    }

}