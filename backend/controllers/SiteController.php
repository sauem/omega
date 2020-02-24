<?php
namespace backend\controllers;

use common\helper\HelperFunction;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends BaseController
{


    /**
     * Displays homepage.
     *
     * @return string
     */
    function unrequiredAuth()
    {
        return  [
            'login','error',  'index','logout','register'
        ];
    }
    function requiredAuth()
    {
        return [

        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegister()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new \common\models\User();
        $secretCode = Yii::$app->request->get('code');

        if ($secretCode != YII_ADMIN_REGISTER_CODE) {
            return false;
        }

        if ($model->load(Yii::$app->request->get(), '') && $model->save()) {
            return true;
        }
        return HelperFunction::getFirstErrorModel($model);
    }
}
