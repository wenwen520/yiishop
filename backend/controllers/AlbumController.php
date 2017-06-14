<?php
namespace backend\controllers;

use backend\models;

use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;

class AlbumController extends Controller{
        public function actionIndex(){
            $query =models\Album::find();
            $total = $query->count();
            $page = new Pagination([
                'totalCount'=>$total,
                'defaultPageSize'=>7,
            ]);
            $album = $query->offset($page->offset)->limit($page->limit)->all();
            return $this->render('index',['album'=>$album,'page'=>$page]);

        }

    public function actionAdd()
    {
        $model = new models\Album();
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $model->load($request->post());
            $model->imgFile = UploadedFile::getInstance($model, 'imgFile');
            if ($model->validate()) {
                if ($model->imgFile) {
                    //保存数据之前  获取图片路径和后缀名  并保存
                    $fileName = '/images/' . uniqid() . '.' . $model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias(('@webroot') . $fileName, false));
                    //给数据库的图片字段赋值
                    $model->photo = $fileName;
//                    var_dump($fileName);exit;
                    $model->save();
                    \Yii::$app->session->setFlash('success','添加图片成功');
//                    return $this->redirect(['album/index']);
                }
            }
        }
        return $this->render('add',['model'=>$model]);
    }

}