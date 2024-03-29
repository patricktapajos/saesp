<?php

namespace app\modules\coordenador\controllers;
use Yii;
use app\models\Usuario;
use app\models\PermissaoEnum;
use app\models\Professor;
use app\models\ProfessorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfessorlController implements the CRUD actions for Professor model.
 */
class ProfessorController extends Controller
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
     * Lists all Professor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfessorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Professor model.
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
     * Creates a new Professor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuario();
        $model->scenario = Usuario::SCENARIO_PROFESSOR;
        $model->USU_PERMISSAO = PermissaoEnum::PERMISSAO_PROFESSOR;

        if($model->load(Yii::$app->request->post())){
            $trans = Yii::$app->db->beginTransaction();
            try {
                if ($model->save()) {
                    $professor = new Professor();
                    $professor->USU_ID = $model->USU_ID;
                    $professor->save();
                    $trans->commit();
                    return $this->redirect(['view', 'id' => $professor->PROF_ID]);
                }
            } catch (\Exception $e) {
                $trans->rollBack();
                throw $e;
            }
        }//else {
            return $this->render('create', [
                'model' => $model,
            ]);
       // }   
    }

    /**
     * Updates an existing Professor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $professor = $this->findModel($id);
        $model = $professor->usuario;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $professor->PROF_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Professor model.
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
     * Finds the Professor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Professor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Professor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
