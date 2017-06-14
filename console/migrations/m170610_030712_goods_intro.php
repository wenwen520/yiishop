<?php

use yii\db\Migration;

class m170610_030712_goods_intro extends Migration
{
    public function safeUp()
    {
        return $this->createTable('goods_intro',[
            'goods_id'=>$this->string(),
            'content'=>$this->text(),
        ]);

    }

    public function safeDown()
    {
        echo "m170610_030712_goods_intro cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170610_030712_goods_intro cannot be reverted.\n";

        return false;
    }
    */
}
