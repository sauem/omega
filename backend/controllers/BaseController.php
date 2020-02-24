<?php


namespace backend\controllers;


use common\helper\HelperFunction;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BaseController extends Controller
{
    public static $BaseView = '@backend/views/';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => array_merge(['error'], $this->unrequiredAuth()),
                        'allow' => true,
                    ],
                    [
                        'actions' => $this->requiredAuth(),
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    function unrequiredAuth(){
        return [];
    }
    function requiredAuth(){
        return [];
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    public function getViewName($name)
    {
        return static::$BaseView . "/" . Yii::$app->controller->id . "/" . $name;
    }
    public function Success($t = '',$a = ''){
        Yii::$app->session->setFlash('success', sprintf("%s %s thành công", $t,$a));
    }

    public function Error($e , $msg = true){
        Yii::$app->session->setFlash('error', !$msg ? $e :  HelperFunction::getFirstErrorModel($e));
    }

    public function check($model){
        if(!$model){
            throw new NotFoundHttpException('not found.');
        }
    }

}