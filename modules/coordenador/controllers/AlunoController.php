<?php

namespace app\modules\coordenador\controllers;

use Yii;
use app\modules\aluno\models\Aluno;
use app\modules\aluno\models\AlunoModalidade;
use app\models\PermissaoEnum;
use app\modules\aluno\models\AlunoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;



/**
 * AlunoController implements the CRUD actions for Aluno model.
 */
class AlunoController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'view','delete', 'findmodel','imprimircarteirinha','atualizarsituacao'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create','view','update', 'delete', 'findmodel','imprimircarteirinha','atualizarsituacao'],
                        'roles' => [PermissaoEnum::PERMISSAO_COORDENADOR],
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all Aluno models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlunoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Aluno model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $smods = AlunoModalidade::find()->innerJoinWith('modalidadeDataHora')->where(['ALU_ID'=>$id])->all();
        
        return $this->render('view', [
            'model' => $model,
            'smods' => $smods
        ]);
    }

    /**
     * Creates a new Aluno model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $aluno = new Aluno();
        $candidato = $model->candidato;
        $model = $candidato->usuario;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ALU_ID]);
        } else {
            return $this->render('create', [
                'aluno' => $aluno,
                'model' => $model,
                'candidato'=>$candidato
            ]);
        }
    }

    /**
     * Updates an existing Aluno model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $aluno = $this->findModel($id);
        $aluno->setScenario(Aluno::SCENARIO_ALTERAR);
        $candidato = $aluno->candidato;
        $model = $candidato->usuario;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ALU_ID]);
        } else {
            return $this->render('update', [
                'aluno' => $aluno,
                'model' => $model,
                'candidato'=>$candidato
            ]);
        }
    }

    public function actionAtualizarsituacao($id)
    {
        $aluno = $this->findModel($id);
        $aluno->setScenario(Aluno::SCENARIO_ALTERAR);

        if ($aluno->load(Yii::$app->request->post()) && $aluno->save()) {
            Yii::$app->session->setFlash('success', "Registro atualizado com sucesso!");            
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'aluno' => $aluno,
            ]);
        }
    }

    /**
     * Deletes an existing Aluno model.
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
     * Finds the Aluno model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Aluno the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Aluno::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionImprimircarteirinha($id){
        $model = Aluno::findOne($id);
        $smods = AlunoModalidade::find()->innerJoinWith('modalidadeDataHora')->where(['ALU_ID'=>$id])->all();

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using  standard fonts
            'content' => $this->renderPartial('_impressao', ['model'=>$model,'smods'=>$smods]),
            'options' => [
                'title' => 'Sistema de Atividades Esportivas (SAESP)',
                'subject' => 'Carteirinha do Aluno'
            ],
            'methods' => [
                'SetHeader' => ['Sistema de Atividades Esportivas'],
                'SetFooter' => ['Gerado em: '.date("d/m/Y")],
            ]
        ]);
        //return $pdf->render();
        //$pdf = Yii::$app->pdf;
        $pdf->cssFile = '@app/web/css/impressao_inscricao.css';
        //$pdf->content = $this->renderPartial('_impressao', ['model'=>$model]);
        return $pdf->render();
    }
}
