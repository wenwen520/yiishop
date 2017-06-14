<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language'=>'zh-CN',//��������
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'backend\models\AdminPwd',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [//��ַ��̬��
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'qiniu'=>[
            'class'=>\backend\components\Qiniu::className(),
            'up_host'=>'http://up.qiniu.com',
            'accessKey'=>'sWBj7OeAUrGYTz1s8xEKdPMMHQjRWZYw6_8eWIg5',
            'secretKey'=>'nBJF3chS_rNmQbroplwS54SkP6S5UCPv5R-2IfeB',
            'bucket'=>'yiishop',
            'domain'=>'http://or9ry3af8.bkt.clouddn.com/',
        ],
        'ueditor' => [
            'class' => \crazyfd\ueditor\Ueditor::className(),
            'config'=>[
                'uploadDir'=>date('Y/m/d'),
                'imagePathFormat'=>"/Upload/album/{yyyy}{mm}{dd}/{time}{rand:6}"//上传保存路径
            ]
            ],
        'upload' => [
            'class' => 'kucha\ueditor\UEditorAction',
            'config' => [
//                "imageUrlPrefix"  => "http://www.baidu.com",//图片访问路径前缀
                "imagePathFormat" => "/upload/album/{yyyy}{mm}{dd}/{time}{rand:6}",//上传保存路径
//                "imageRoot"=> Yii::getAlias("@webroot"),
            ],
        ]

    ],
    'params' => $params,
];
