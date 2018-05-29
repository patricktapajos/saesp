<?php

namespace app\modules\inscricao\controllers;

use Yii;
use app\models\Usuario;
use app\modules\inscricao\models\Candidato;
use app\modules\coordenador\models\SelecaoModalidade;
use app\modules\coordenador\models\SelecaoCel;
use app\models\Selecao;
use app\models\SituacaoSelecaoEnum;
use app\modules\inscricao\models\CandidatoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CandidatolController implements the CRUD actions for Candidato model.
 */
class CandidatoController extends Controller
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
     * Lists all Candidato models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CandidatoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Candidato model.
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
     * Creates a new Candidato model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuario();
        $candidato = new Candidato();
        $selecao = Selecao::inscricoesAbertas();
       
        if(!$selecao){
            throw new \yii\web\HttpException(403,"Não há processo seletivo aberto!");
        }

        $smods = SelecaoModalidade::find()->innerJoinWith('modalidadeDataHora')->where(['SEL_ID'=>$selecao->SEL_ID])->all();

        //var_dump($scels[0]->cels[0]);die;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $candidato->CAND_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'candidato' => $candidato,
                'smods' => $smods
            ]);
        }
    }

    /**
     * Updates an existing Candidato model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->CAND_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Candidato model.
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
     * Finds the Candidato model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Candidato the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Candidato::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
