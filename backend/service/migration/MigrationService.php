<?php

namespace app\service\migration;

class MigrationService extends \yii\db\Migration
{
    protected $tableOptions;

    protected $tableInitMigration;
    protected $tableMigration;

    public function init()
    {
        parent::init();

//        $this->tableInitMigration = \Yii::$app->controllerMap['init']['migrationTable'];
//        $this->tableMigration = \Yii::$app->controllerMap['migrate']['migrationTable'];

        $tableOptions = null;
        if ( $this->db->driverName === 'mysql' ) {
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }
    }
}