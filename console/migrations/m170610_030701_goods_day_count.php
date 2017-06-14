<?php

use yii\db\Migration;

class m170610_030701_goods_day_count extends Migration
{
    public function safeUp()
    {
        return $this->createTable('goods_day_count',[
            'day'=>$this->integer(),
            'count'=>$this->integer(),
        ]);

    }

    public function safeDown()
    {
        echo "m170610_030701_goods_day_count cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170610_030701_goods_day_count cannot be reverted.\n";

        return false;
    }
    */
}
