<?php
namespace backend\models;

use yii\db\ActiveRecord;

class Brand extends ActiveRecord{
    public $imgFile; //定义一个字段保存图片
    public $code;//验证码
    //自定义状态
    public static $status=['-1'=>'删除','0'=>'隐藏','1'=>'正常'];


    //验证规则
    public function rules(){
        return [
            [['name','intro','sort','status'],'required'],
            ['imgFile','file','extensions'=>['jpg','png','gif']],
            ['sort','integer'],
        ];
    }

    //标签属性
    public function attributeLabels(){
        return[
            'name'=>'品牌名称',
            'intro'=>'品牌简介',
            'imgFile'=>'品牌LOGO',
            'sort'=>'排序',
            'status'=>'状态',
            'code'=>'验证码',

        ];
    }

}