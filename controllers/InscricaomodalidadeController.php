<?php

namespace app\controllers;

use Yii;
use app\modules\inscricao\models\InscricaoModalidade;
use app\models\InscricaomodalidadeSearch;
use app\modules\coordenador\models\ModalidadeDataHora;
use app\modules\inscricao\models\Candidato;
use app\modules\coordenador\models\SelecaoModalidade;
use app\modules\coordenador\models\SelecaoCel;
use app\modules\inscricao\models\Inscricao;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InscricaomodalidadeController implements the CRUD actions for Inscricaomodalidade model.
 */
class InscricaomodalidadeController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Inscricaomodalidade models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InscricaomodalidadeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Inscricaomodalidade model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
      $smods = SelecaoModalidade::find()->innerJoinWith('modalidadedatahora')->where(['SEL_ID'=>$selecao->SEL_ID])->all();

      if (($model->load(Yii::$app->request->post()) && $model->validate())
          && ($candidato->load(Yii::$app->request->post()) && $candidato->validate())) {

          $trans = Yii::$app->db->beginTransaction();
          try{
              $model->save();
              $candidato->CAND_FOTO = UploadedFile::getInstance($candidato, 'CAND_FOTO');
              $candidato->USU_ID = $model->USU_ID;
              $candidato->upload();
              $candidato->save(false);
              $inscricao->CAND_ID = $candidato->CAND_ID;
              $inscricao->SEL_ID = $selecao->SEL_ID;
              $inscricao->save(false);
              foreach (explode(',',$candidato->modalidades) as $modalidade) {
                  $inscmod = new InscricaoModalidade();
                  $inscmod->MDT_ID = $modalidade;
                  $inscmod->INS_ID = $inscricao->INS_ID;
                  $inscmod->save();
              }
              $trans->commit();
              return $this->redirect(['view', 'id' => $candidato->CAND_ID]);
          }catch(\Exception $e){
              $trans->rollBack();
              throw $e;
          }
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'candidato' => $candidato,
            'smods' => $smods
        ]);
    }

    /**
     * Creates a new Inscricaomodalidade model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Inscricaomodalidade();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->IMO_ID]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Inscricaomodalidade model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if($app->request->IMO_STATUS == 'DESISTENCIA'){
            }
            return $this->redirect(['view', 'id' => $model->IMO_ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Inscricaomodalidade model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Inscricaomodalidade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Inscricaomodalidade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inscricaomodalidade::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
