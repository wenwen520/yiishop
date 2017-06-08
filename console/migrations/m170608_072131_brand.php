<?php

use yii\db\Migration;

class m170608_072131_brand extends Migration
{
    public function up()
    {
        $this->createTable('brand',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string(50)->notNull(),
            'intro'=>$this->text()->notNull(),
            'logo'=>$this->string(255),
            'sort'=>$this->smallInteger(),
            'status'=>$this->smallInteger(3),

        ]);

    }

    public function down()
    {
        echo "m170608_072131_brand cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
