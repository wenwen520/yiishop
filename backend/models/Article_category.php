<?php
namespace backend\models;

use yii\db\ActiveRecord;

class Article_category extends ActiveRecord{



    //状态
    public static $status=['1'=>'正常','0'=>'隐藏'];
    //帮助文章
    public static $is_help=['1'=>'帮助','2'=>'文章'];

    public function rules(){
        return[
            [['name','intro','sort','status','is_help'],'required'],
            ['sort','integer'],
        ];
    }

    public function attributeLabels(){
        return[
            'name'=>'分类名称',
            'intro'=>'分类简介',
            'sort'=>'排序',
            'status'=>'状态',
            'is_help'=>'类型',
        ];
    }



}