<?php

namespace app\modules\coordenador\controllers;

use Yii;
use app\modules\coordenador\models\SelecaoCel;
use app\models\Selecao;
use app\modules\inscricao\models\Candidato;
use app\modules\coordenador\models\SelecaoModalidade;
use app\modules\coordenador\models\ModalidadeDataHora;
use app\modules\coordenador\models\ModalidadeDiaSemana;
use app\modules\coordenador\models\SelecaoCelSearch;
use app\modules\inscricao\models\InscricaoModalidade;
use app\modules\inscricao\models\Inscricao;
use app\modules\inscricao\models\InscricaoParecerSearch;
use app\modules\inscricao\models\CandidatoDocumento;
use app\modules\coordenador\models\Aluno;
use app\modules\coordenador\models\Alunomodalidade;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;

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

     /**
      * Lists all SelecaoCel models.
      * @return mixed
      */
     public function actionGerenciarparecer()
     {
        $selecao = SelecaoCel::find()->where(['CEL_ID'=>Yii::$app->user->identity->cel_id])->one();
        $searchModel = new InscricaoParecerSearch();
        $searchModel->SEL_ID = $selecao->SEL_ID;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         return $this->render('gerenciarparecer', [
             'dataProvider' => $dataProvider,
             'searchModel'  => $searchModel,
         ]);
     }

     /**
      * Displays a single SelecaoCel model.
      * @param string $id
      * @return mixed
      */
    public function actionParecer($id)
    {
        $inscricao           = Inscricao::findOne($id);
        $inscricao->scenario = Inscricao::CENARIO_PARECER;
        $smods               = InscricaoModalidade::find()->innerJoinWith('modalidadeDataHora')->where(['INS_ID'=>$id])->all();
        
        //var_dump(Yii::$app->request->post());
        if ($inscricao->load(Yii::$app->request->post()) && $inscricao->validate()){
            $trans = Yii::$app->db->beginTransaction();
            try{
                $inscricao->save();
                $trans->commit();
                return $this->redirect(['aluno/view','id'=>$inscricao->aluno->ALU_ID]);
            }catch(\Exception $e){
                $trans->rollBack();
                throw $e;
            }
        }
        return $this->render('parecer', [
            'model' => $inscricao,
            'smods' => $smods,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        $smods = SelecaoModalidade::find()
                    ->joinWith(['modalidadeDataHora','cel'])
                    ->where(['SELECAO_MODALIDADE.SEL_ID'=>$model->SEL_ID,'CEL.CEL_ID'=>Yii::$app->user->identity->cel_id])->all();

        return $this->render('view', [
            'model' => $model,
            'smods' =>$smods
        ]);
    }

    /**
     * Creates a new SelecaoCel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        if(!Selecao::cadastroCEL()){
           throw new \yii\web\HttpException(403,"Não há seleções abertas para cadastro de modalidades!");
        }

        $selecao = SelecaoCel::find()->where(['CEL_ID'=>Yii::$app->user->identity->cel_id])->one();
        $scel = SelecaoCel::find()->where(['SEL_ID'=>Selecao::getSelecaoAtiva()->SEL_ID, 'CEL_ID'=>Yii::$app->user->identity->cel_id])->one();

        if($scel){
            throw new MethodNotAllowedHttpException ('CEL já possui modalidades cadastradas no processo seletivo vigente.');
        }
       
        $model = new SelecaoCel();
        $model->SEL_ID = Selecao::getSelecaoAtiva()->SEL_ID;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $trans = Yii::$app->db->beginTransaction();
            try{
                if ($model->save()){
                    foreach ($model->getModalidades() as $n=>$modalidade) {
                        $selecaoModalidade = new SelecaoModalidade;
                        $selecaoModalidade->SEL_ID = $model->SEL_ID;
                        $selecaoModalidade->MOD_ID = $modalidade['MOD_ID'];
                        $selecaoModalidade->CEL_ID = Yii::$app->user->identity->cel_id;                        
                        $selecaoModalidade->SCEL_ID = $model->SCEL_ID;                        
                        $selecaoModalidade->setComplemento($modalidade['complemento']);
                        if($modalidade['complemento']){
                            $selecaoModalidade->save();
                        }

                        foreach ($selecaoModalidade->getComplemento() as $o=>$com) {
                            $mdatahora = new ModalidadeDataHora;
                            $mdatahora->setAttributes($com);
                            $mdatahora->setDias($com['dias']);
                            $mdatahora->SMOD_ID = $selecaoModalidade->SMOD_ID;
                            $mdatahora->save();

                            foreach ($mdatahora->getDias() as $dia=>$checked) {
                                $mdiasemana = new ModalidadeDiaSemana;
                                $mdiasemana->MDS_DESCRICAO = $dia;
                                $mdiasemana->MDT_ID = $mdatahora->MDT_ID;
                                $mdiasemana->save();
                            }
                        }
                    }


                    $trans->commit();
                    Yii::$app->session->setFlash('success', "Modalidades relacionadas com sucesso!");
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
        if(Selecao::cadastrarNaSelecao()){
            throw new \yii\web\HttpException(403,"Processo seletivo com inscrições abertas não pode mais ser alterado!");
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $trans = Yii::$app->db->beginTransaction();
            try{
                if ($model->save()){
                    if($model->complementoexclusao){
                        foreach (explode(',', $model->complementoexclusao) as $codigo) {
                            $complemento = ModalidadeDataHora::findOne($codigo);
                            foreach ($complemento->modalidadeDiaSemana as $dia) {
                                $dia->delete();
                            }
                            $complemento->delete();
                        }
                    }

                    foreach ($model->getModalidades() as $n=>$modalidade) {

                        $selecaoModalidade = new SelecaoModalidade;

                        if($modalidade['SMOD_ID'] != null){
                            $selecaoModalidade->isNewRecord = false;
                        }
                        
                        $selecaoModalidade->SMOD_ID = $modalidade['SMOD_ID'];
                        $selecaoModalidade->SEL_ID = $model->SEL_ID;
                        $selecaoModalidade->MOD_ID = $modalidade['MOD_ID'];
                        $selecaoModalidade->CEL_ID = Yii::$app->user->identity->cel_id;
                        $selecaoModalidade->SCEL_ID = $model->SCEL_ID;                                                                        
                        $selecaoModalidade->setComplemento($modalidade['complemento']);

                        if($modalidade['complemento']){
                            $selecaoModalidade->save();
                        }

                        foreach ($selecaoModalidade->getComplemento() as $o=>$com) {
                            $mdatahora = new ModalidadeDataHora;
                            $mdatahora->setAttributes($com);

                            if($com['MDT_ID'] != null){
                                $mdatahora->isNewRecord = false;
                            }

                            $mdatahora->MDT_ID = $com['MDT_ID'];
                            $mdatahora->setDias($com['dias']);
                            $mdatahora->SMOD_ID = $selecaoModalidade->SMOD_ID;
                            $mdatahora->save();

                            foreach ($mdatahora->modalidadeDiaSemana as $d) {
                                $d->delete();
                            }

                            foreach ($mdatahora->getDias() as $dia=>$checked) {
                                $mdiasemana = new ModalidadeDiaSemana;
                                $mdiasemana->MDS_DESCRICAO = $dia;
                                $mdiasemana->MDT_ID = $mdatahora->MDT_ID;
                                $mdiasemana->save();
                            }
                        }
                    }


                    $trans->commit();
                    Yii::$app->session->setFlash('success', "Modalidades atualizadas com sucesso!");
                    return $this->redirect(['view', 'id' => $model->SCEL_ID]);
                }
            }catch(\Exception $e){
                $trans->rollBack();
                throw $e;
            }
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
        if(Selecao::cadastrarNaSelecao()){
            throw new \yii\web\HttpException(403,"Processo seletivo com inscrições abertas não pode mais ser alterado!");
        }
        $trans = Yii::$app->db->beginTransaction();

        try{
            $model = $this->findModel($id);
            $sms = SelecaoModalidade::find()->where(['SEL_ID'=>$model->SEL_ID])->all();
            foreach ($sms as $sm) {
                foreach ($sm->modalidadeDataHora as $md) {
                    foreach ($md->modalidadeDiaSemana as $mds) {
                        $mds->delete();                        
                    }
                    $md->delete();
                }
                $sm->delete();
            }
            
            $model->delete();
            Yii::$app->session->setFlash('success', "Seleção desassociada.");
            
            $trans->commit();
        }catch(\Exception $e){
            $trans->rollBack();
            Yii::$app->session->setFlash('danger', "Não é possível modificar o quadro quando alguma(s) modalidade(s) já está(ão) relacionada(s) a uma inscrição.");
        }

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
