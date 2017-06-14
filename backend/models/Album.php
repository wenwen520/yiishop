<?php
namespace backend\models;

use yii\db\ActiveRecord;

class Album extends ActiveRecord{
    public $imgFile;


    //关联商品表
    public function getGoods(){
        return $this->hasOne(Goods::className(),['id'=>'goods_id']);
    }
    public function rules()
    {
        return [
            [['imgFile','goods_id'], 'required'],
//            [['imgFile'], 'string'],
        ['imgFile','file'],
        ];
    }
    public function attributeLabels()
    {
        return [
           'goods_id'=>'商品名',
           'photo'=>'图片',
        ];
    }

}