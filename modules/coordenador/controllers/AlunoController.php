<?php

namespace app\modules\coordenador\controllers;

use Yii;
use app\modules\aluno\models\Aluno;
use app\modules\aluno\models\AlunoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Aluno model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Aluno();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ALU_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ALU_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
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

    public function actionImprimirCarteirinha($id){
        $model = Aluno::findOne($id);
        $smods = AlunoModalidade::find()->innerJoinWith('inscricaoModalidade')->where(['INS_ID'=>$model->inscricao->INS_ID])->all();

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using  standard fonts
            'content' => $this->renderPartial('_impressao', ['model'=>$model,'smods'=>$smods]),
            'options' => [
                'title' => 'Sistema de Atividades Esportivas (SAESP)',
                'subject' => 'Comprovante de Inscrição'
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
