<?php
namespace backend\models;
use yii\db\ActiveRecord;

//文章模型
class Article extends ActiveRecord{

    public $content;
    //建立文章和分类的一对一关系
    public function getArticle_category(){
        return $this->hasOne(Article_category::className(),['id'=>'article_category_id']);
    }
    //建立文章和详情表的一对一关系
    public function getArticle_detail(){
        return $this->hasOne(Article_detail::className(),['article_id'=>'id']);
    }

    //状态
    public static $status=['1'=>'正常','0'=>'隐藏','-1'=>'删除'];

    public function rules(){
        return[
            [['name','intro','article_category_id','sort','status'],'required'],
            ['sort','integer'],
        ];
    }

    public function attributeLabels(){
        return[
            'name'=>'文章名称',
            'intro'=>'文章简介',
            'article_category_id'=>'文章分类id',
            'sort'=>'排序',
            'status'=>'状态',
        ];
    }


}
