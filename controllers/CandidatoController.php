<?php

namespace app\controllers;

use Yii;
use app\modules\inscricao\models\Candidato;
use app\modules\inscricao\models\CandidatoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Usuario;
use app\modules\coordenador\models\SelecaoModalidade;
use app\modules\coordenador\models\SelecaoCel;
use app\modules\inscricao\models\Inscricao;
use app\modules\inscricao\models\InscricaoModalidade;
use app\models\Selecao;
use app\models\SituacaoSelecaoEnum;
use app\models\PermissaoEnum;
use app\models\SituacaoEnum;

/**
 * CandidatoController implements the CRUD actions for Candidato model.
 */
class CandidatoController extends Controller
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
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
      //if(!$selecao){
      //    throw new \yii\web\HttpException(403,"Não há processo seletivo aberto!");
      //}

      $smods = SelecaoModalidade::find()->innerJoinWith('modalidadeDataHora')->where(['SEL_ID'=>$selecao->SEL_ID])->all();
      //$inscricao = Inscricao::find()->where(['SEL_ID'=>$selecao->SEL_ID]);

       if (($model->load(Yii::$app->request->post()) && $model->validate())
          && ($candidato->load(Yii::$app->request->post()) && $candidato->validate())) {

          //var_dump(Yii::$app->request->post());die;

          $trans = Yii::$app->db->beginTransaction();
          try{
              $model->save();

              $candidato->CAND_FOTO = UploadedFile::getInstance($candidato, 'CAND_FOTO');
              if($candidato->CAND_FOTO){
                  $candidato->upload();
              }


              $candidato->save(false);

              //InscricaoModalidade::find()->where(['INS_ID'=>$candidato->inscricao->INS_ID])->deleteAll();
              InscricaoModalidade::deleteAll('INS_ID =:INS_ID ',[':INS_ID'=>$candidato->inscricao->INS_ID]);

              foreach (explode(',',$candidato->modalidades) as $modalidade) {
                  $inscmod = new InscricaoModalidade();
                  $inscmod->MDT_ID = $modalidade;
                  $inscmod->INS_ID = $candidato->inscricao->INS_ID;
                  $inscmod->save();
              }
              $trans->commit();
              return $this->redirect(['view', 'id' => $candidato->CAND_ID]);
          }catch(\Exception $e){
              $trans->rollBack();
              throw $e;
          }
        }
        ///print_r(Yii::$app->request->queryParams);die;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'candidato' => $candidato,
            'smods' => $smods

        ]);
    }

    /**
     * Creates a new Candidato model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Candidato();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->CAND_ID]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Candidato model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->CAND_ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Candidato model.
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
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
