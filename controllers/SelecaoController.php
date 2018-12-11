<?php

namespace app\controllers;

use Yii;
use app\models\Selecao;
use app\models\SelecaoSearch;
use app\models\SituacaoSelecaoEnum;
use app\modules\inscricao\models\InscricaoModalidade;
use app\models\InscricaomodalidadeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PermissaoEnum;
use yii\filters\AccessControl;

/**
 * SelecaoController implements the CRUD actions for Selecao model.
 */
class SelecaoController extends Controller
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
                    'index' => ['GET']
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'view','delete', 'findmodel','reabrir'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create','view','update', 'delete', 'findmodel','reabrir'],
                        'roles' => [PermissaoEnum::PERMISSAO_ADMIN],
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all Selecao models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SelecaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Selecao model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Selecao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Selecao::find()->andWhere("SEL_SITUACAO <> :SEL_SITUACAO", [':SEL_SITUACAO'=>SituacaoSelecaoEnum::CONCLUIDO])->one()){
            throw new \yii\web\HttpException(403,"Já existe um Processo Seletivo em andamento.");
        }

        $model = new Selecao();
        $model->SEL_SITUACAO = SituacaoSelecaoEnum::CADASTRADO;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Seleção cadastrada com sucesso!");
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Selecao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if($model->isEncerrado()){
            throw new \yii\web\HttpException(403,"Seleção encerrada.");
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Seleção atualizada com sucesso!");
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Selecao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Selecao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Selecao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Selecao::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionReabrir($id){
        
        $model = $this->findModel($id);  
        $model->setScenario(Selecao::SCENARIO_REABRIR_SELECAO);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Seleção atualizada com sucesso!");
            return $this->redirect(['index']);
        } else {
            return $this->render('reabrir', [
                'model' => $model,
            ]);
        }
    }
}
