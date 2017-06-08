<?php

use yii\db\Migration;

class m170608_101527_article extends Migration
{
    public function up()
    {
        $this->createTable('article',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string(50)->notNull(),
            'intro'=>$this->text()->notNull(),
            'article_category_id'=>$this->integer(11)->notNull(),
            'sort'=>$this->integer(11)->notNull(),
            'status'=>$this->smallInteger(2)->notNull(),
            'create_time'=>$this->integer(11),
        ]);

    }

    public function down()
    {
        echo "m170608_101527_article cannot be reverted.\n";

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
