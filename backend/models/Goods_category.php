<?php
namespace backend\models;

use creocoder\nestedsets\NestedSetsBehavior;
use yii\db\ActiveRecord;

class Goods_category extends ActiveRecord{


    public function getParent(){
        return $this->hasOne(Goods_category::className(),['id'=>'parent_id']);
    }


        public function rules(){
             return [
                 [['name','parent_id'],'required'],
                 ['name','unique']//分类名称不能重复
             ];

        }

         public  function attributeLabels(){
             return [
                 'name'=>'名称',
                 'parent_id'=>'上级分类',
                 'intro'=>'简介',
             ];
         }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                 'treeAttribute' => 'tree', //必须打开  （才能有多个一级分类）
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }




}