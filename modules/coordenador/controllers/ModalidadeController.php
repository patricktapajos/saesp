<?php

namespace app\modules\coordenador\controllers;

use Yii;
use app\modules\coordenador\models\Modalidade;
use app\models\PermissaoEnum;
use app\modules\coordenador\models\ModalidadeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ModalidadeController implements the CRUD actions for Modalidade model.
 */
class ModalidadeController extends Controller
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
                'only' => ['index', 'create', 'update', 'view','delete', 'findmodel'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create','view','update', 'delete', 'findmodel'],
                        'roles' => [PermissaoEnum::PERMISSAO_COORDENADOR],
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all Modalidade models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ModalidadeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Modalidade model.
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
     * Creates a new Modalidade model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Modalidade();
        $model->CEL_ID = Yii::$app->user->identity->cel_id;    

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Modalidade cadastrada com sucesso!");
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Modalidade model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Modalidade atualizada com sucesso!");
            return $this->redirect(['view', 'id' => $model->MOD_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Modalidade model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try{
            $this->findModel($id)->delete();
        }catch(\Exception $e){
            Yii::$app->session->setFlash('danger', "Modalidade está referenciada em alguma seleção");
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Modalidade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Modalidade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Modalidade::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
