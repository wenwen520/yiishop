<?php
namespace backend\models;

use yii\db\ActiveRecord;

class Article_detail extends ActiveRecord{

    //建立和文章表的一对一关系
    public function getArticle(){
        return $this->hasOne(Article::className(),['id'=>'article_id']);
    }
    public function rules(){
        return[
            [['article_id','content'],'required'],
        ];
    }
    public function attributeLabels(){
        return[
            'article_id'=>'文章名称',
            'content'=>'文章详情'
        ];
    }
}