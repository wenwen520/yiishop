<?php

use yii\db\Migration;

class m170608_090201_article_category extends Migration
{
    public function up()
    {
        $this->createTable('article_category',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string(50),
            'intro'=>$this->text(),
            'sort'=>$this->integer(11),
            'status'=>$this->smallInteger(2),
            'is_help'=>$this->smallInteger(1),
        ]);

    }

    public function down()
    {
        echo "m170608_090201_article_category cannot be reverted.\n";

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
