<?php

namespace app\modules\coordenador\controllers;

use Yii;
use app\modules\coordenador\models\SelecaoCel;
use app\modules\coordenador\models\SelecaoCelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SelecaoCelController implements the CRUD actions for SelecaoCel model.
 */
class SelecaocelController extends Controller
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
     * Lists all SelecaoCel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SelecaoCelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SelecaoCel model.
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
     * Creates a new SelecaoCel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SelecaoCel();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $trans = Yii::$app->db->beginTransaction();
            try{
                if ($model->save()){
                    foreach ($model->getModalidades() as $n=>$modalidade) {
                        $selecaoModalidade = new SelecaoModalidade;
                        $selecaoModalidade->SEL_ID = $model->SEL_ID;
                        $selecaoModalidade->MOD_ID = $modalidade['MOD_ID'];
                        $selecaoModalidade->setComplemento($modalidade['complemento']);

                        if (!$selecaoModalidade->save()) die($selecaoModalidade->errors);

                        foreach ($selecaoModalidade->getComplemento() as $o=>$com) {
                            
                            $mdatahora = new ModalidadeDataHora;
                            $mdatahora->setAttributes($com);
                            $mdatahora->setDias($com['dias']);
                            $mdatahora->SMOD_ID = $selecaoModalidade->MOD_ID;

                            if (!$mdatahora->save()) die($mdatahora->errors);
                            
                            foreach ($com['dias'] as $dia) {
                                
                                $mdiasemana = new ModalidadeDiaSemana;
                                $mdiasemana->MDS_DESCRICAO = $dia;
                                $mdiasemana->MDT_ID = $mdatahora->MDT_ID;

                                if (!$mdiasemana->save()) die($mdiasemana->errors);
                            }
                        }
                    }


                    $trans->commit();
                    return $this->redirect(['view', 'id' => $model->SCEL_ID]);
                }
            }catch(\Exception $e){
                $trans->rollBack();
                throw $e;
            }        
        } else {
            return $this->render('create', [
                'model' => $model                
            ]);
        }
    }
    /**
     * Updates an existing SelecaoCel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->SCEL_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SelecaoCel model.
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
     * Finds the SelecaoCel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SelecaoCel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SelecaoCel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
