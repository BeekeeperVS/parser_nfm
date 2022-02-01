<?php

use app\service\migration\MigrationService;
use yii\db\Expression;

/**
 * Class m220201_114755_create_table_ep_part
 */
class m220201_114755_create_table_ep_part extends MigrationService
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        try {
            $this->createTable('{{%ep_part}}', [
                'id' => $this->primaryKey(),
                'assembly_id' => $this->integer()->notNull(),
                'ep_id' => $this->string(),
                'number' => $this->string(),
                'description' => $this->string(),
                'quantity' => $this->string(),
                'reference_number' => $this->string(),
                'sequence_number' => $this->string(),
                'sku_global' => $this->string(),
                'substitution_code' => $this->string(),
                'substitution_type' => $this->string(),
                'technical_description' => $this->text(),
                'image' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
                'technical_image' => $this->text(),
                'ep_assembly_id' => $this->string(),
                'ep_assembly_part_list_id' => $this->string(),
                'details' => $this->json(),
                'substitutions' => $this->json(),
                'kits' => $this->json(),
                'alternative_indicator' => $this->boolean(),
                'component_indicator' => $this->boolean(),
                'is_in_working_list' => $this->boolean(),
                'kit_indicator' => $this->boolean(),
                'notes' => $this->boolean(),
                'reman_indicator' => $this->boolean(),
                'substitution_indicator' => $this->boolean(),
                'usage' => $this->string(),

                'status_parser' => $this->integer(10)->defaultValue(STATUS_PARSER_NEW),
                'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
                'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            ], $this->tableOptions);

            $this->createIndex('idx-ep_part-assembly_id', '{{%ep_part}}', 'assembly_id');
            $this->createIndex('idx-ep_part-ep_id', '{{%ep_part}}', 'ep_id');
            $this->createIndex('idx-ep_part-number', '{{%ep_part}}', 'number');
            $this->createIndex('idx-ep_part-description', '{{%ep_part}}', 'description');
            $this->createIndex('idx-ep_part-quantity', '{{%ep_part}}', 'quantity');
            $this->createIndex('idx-ep_part-reference_number', '{{%ep_part}}', 'reference_number');
            $this->createIndex('idx-ep_part-sequence_number', '{{%ep_part}}', 'sequence_number');
            $this->createIndex('idx-ep_part-sku_global', '{{%ep_part}}', 'sku_global');
            $this->createIndex('idx-ep_part-substitution_code', '{{%ep_part}}', 'substitution_code');
            $this->createIndex('idx-ep_part-substitution_type', '{{%ep_part}}', 'substitution_type');
            $this->createIndex('idx-ep_part-ep_assembly_id', '{{%ep_part}}', 'ep_assembly_id');
            $this->createIndex('idx-ep_part-ep_assembly_part_list_id', '{{%ep_part}}', 'ep_assembly_part_list_id');
            $this->createIndex('idx-ep_part-alternative_indicator', '{{%ep_part}}', 'alternative_indicator');
            $this->createIndex('idx-ep_part-component_indicator', '{{%ep_part}}', 'component_indicator');
            $this->createIndex('idx-ep_part-is_in_working_list', '{{%ep_part}}', 'is_in_working_list');
            $this->createIndex('idx-ep_part-kit_indicator', '{{%ep_part}}', 'kit_indicator');
            $this->createIndex('idx-ep_part-notes', '{{%ep_part}}', 'notes');
            $this->createIndex('idx-ep_part-reman_indicator', '{{%ep_part}}', 'reman_indicator');
            $this->createIndex('idx-ep_part-substitution_indicator', '{{%ep_part}}', 'substitution_indicator');

            $this->createIndex('idx-ep_part-status_parser', '{{%ep_part}}', 'status_parser');

            $this->addForeignKey('fk-ep_part-assembly_id',
                '{{%ep_part}}',
                'assembly_id',
                '{{%ep_assembly}}',
                'id',
                'CASCADE'
            );
        } catch (Exception $e) {
            $this->down();
            throw $e;
        }


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ep_part}}');
    }

}