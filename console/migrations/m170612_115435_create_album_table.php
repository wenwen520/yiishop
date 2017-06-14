<?php

use yii\db\Migration;

/**
 * Handles the creation of table `album`.
 */
class m170612_115435_create_album_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('album', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer(),
            'photo'=>$this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('album');
    }
}
