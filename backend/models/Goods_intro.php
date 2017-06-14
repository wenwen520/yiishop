<?php
namespace backend\models;

use yii\db\ActiveRecord;

class Goods_intro extends ActiveRecord{

    //建立和商品表一对一关系
    public function getGoods(){
        return $this->hasOne(Goods::className(),['id'=>'goods_id']);
    }

    public function rules(){
        return[
            ['content','required'],
        ];
    }
    public function attributeLabels(){
        return[
            'goods_id'=>'商品id',
            'content'=>'商品详情',
        ];
    }

}