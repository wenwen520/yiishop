<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m170611_095432_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(),
            'password'=>$this->string(99),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}
