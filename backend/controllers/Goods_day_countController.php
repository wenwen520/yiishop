<?php
namespace backend\controllers;

use backend\models\Goods_day_count;
use yii\web\Controller;

class Goods_day_countController extends Controller{

    public function actionIndex(){
        $count = Goods_day_count::find()->all();
        return $this->render('index',['count'=>$count]);
    }
}