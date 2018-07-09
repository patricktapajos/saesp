<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\PermissaoEnum;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            /*'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $this->redirecionarPorPermissao();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function redirecionarPorPermissao(){
        
        /* Permissão default, de admin*/
        $endpoint = $this->goBack();

        /*Permissão de coordenador*/
        if(Yii::$app->user->can(PermissaoEnum::PERMISSAO_COORDENADOR)){
           $endpoint = $this->redirect(['/coordenador/default']);
        
        }
        /*Permissão de professor*/
        else if(Yii::$app->user->can(PermissaoEnum::PERMISSAO_PROFESSOR)){
            $endpoint = $this->redirect(['/professor/default']);
        }

        /* Candidato não poderá se logar por aqui */
        else if(Yii::$app->user->can(PermissaoEnum::PERMISSAO_CANDIDATO)){
            $endpoint = $this->redirect(['logout']);
        }
        return $endpoint;
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}