<?php

use yii\db\Migration;

class m170608_154913_goods_category extends Migration
{
    public function up()
    {
         $this->createTable('goods_category',[
            'id'=>$this->primaryKey(),
             'tree'=>$this->integer()->comment('树id'),
             'lft'=>$this->integer()->comment('左值'),
             'rgt'=>$this->integer()->comment('右值'),
             'depth'=>$this->integer()->comment('层级'),
             'name'=>$this->string()->comment('名称'),
             'parent_id'=>$this->integer()->comment('上级分类id'),
             'intro'=>$this->text()->comment('简介'),

         ]);
    }

    public function down()
    {
        echo "m170608_154913_goods_category cannot be reverted.\n";

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
