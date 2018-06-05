<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param  $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuario();


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $trans = Yii::$app->db->beginTransaction();
            try{
                $model->save();
                $trans->commit();
                return $this->redirect(['view', 'id' => $model->USU_ID]);    
            }catch(\Exception $e){
                $trans->rollBack();
                throw $e;
                
            }
            
        } else {
            //var_dump($model->errors);
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param  $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->USU_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionEsquecisenha(){
        
        $model = new Usuario();
        $model->setScenario(Usuario::SCENARIO_ESQUECI_SENHA);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $usuario = Usuario::find()->where(['USU_CPF'=>$model->USU_CPF])->one();
            $senha = $usuario->gerarSenha();
            $usuario->setScenario(Usuario::SCENARIO_ESQUECI_SENHA);
            
            if($usuario->save() && $usuario->enviarSenhaEmail($senha)){
                /*Yii::app()->user->setFlash('success', 'Senha enviada para o email cadastrado!');
            }else{
                Yii::app()->user->setFlash('error', 'Atenção! O email com a sua nova senha não foi enviado!');*/
            }         
            return $this->redirect(['site/login']);
        } else {
            return $this->render('esqueci_senha', [
                'model' => $model,
            ]);
        }
    }

    public function actionAlterarsenha(){

        $model = Usuario::findOne(Yii::$app->user->identity->id);
        $model->setScenario(Usuario::SCENARIO_ALTERAR_SENHA);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect(['site/logout']);
        } else {
            return $this->render('alterar_senha', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}