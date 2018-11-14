<?php

namespace app\modules\inscricao\controllers;

use Yii;
use app\models\Usuario;
use app\modules\inscricao\models\Candidato;
use app\modules\coordenador\models\SelecaoModalidade;
use app\modules\coordenador\models\SelecaoCel;
use app\modules\inscricao\models\Inscricao;
use app\modules\inscricao\models\InscricaoModalidade;
use app\modules\inscricao\models\CandidatoDocumento;
use app\models\Selecao;
use app\models\SituacaoSelecaoEnum;
use app\models\PermissaoEnum;
use app\models\SituacaoEnum;
use app\modules\inscricao\models\CandidatoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;

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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'view','delete', 'findmodel','imprimir','alterarsenha'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'update', 'delete','imprimir', 'alterarsenha'],
                        'roles' => [PermissaoEnum::PERMISSAO_CANDIDATO],
                    ]
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
        $candidato = $this->findModel($id);
        /*$smods = InscricaoModalidade::find()
                ->select(['COUNT(*) AS cnt'])
                ->innerJoinWith('modalidadeDataHora')
                ->innerJoinWith('selecaoModalidade')
                ->innerJoinWith('modalidade')
                ->where(['INS_ID'=>$candidato->inscricao->INS_ID])
                ->groupBy(['modalidade.MOD_ID'])->all();*/

        $smods = InscricaoModalidade::find()->innerJoinWith('modalidadeDataHora')->where(['INS_ID'=>$candidato->inscricao->INS_ID])->all();

        //$smods = SelecaoModalidade::find()->innerJoinWith('modalidadeDataHora')->where(['SEL_ID'=>22])->all();

        return $this->render('view', [
            'model' => $candidato,
            'smods' => $smods,
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
        $model->setScenario(Usuario::SCENARIO_DEFAULT);
        $documento = new CandidatoDocumento();
        $model->USU_PERMISSAO = PermissaoEnum::PERMISSAO_CANDIDATO;
        $model->USU_SITUACAO = SituacaoEnum::ATIVO;
        $inscricao = new Inscricao();
        $candidato = new Candidato();
        $selecao = Selecao::inscricoesAbertas();
       
        if(!$selecao){
            throw new \yii\web\HttpException(403,"Não há processo seletivo aberto!");
        }

        //$smods = SelecaoModalidade::find()->innerJoinWith('modalidadeDataHora')->where(['SEL_ID'=>$selecao->SEL_ID])->all();
        $scels = SelecaoCel::find()->innerJoinWith('selecaoModalidade')->where(['SELECAO_MODALIDADE.SEL_ID'=>$selecao->SEL_ID])->all();

        /*if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }*/
    
        if ($model->load(Yii::$app->request->post())) {
            $candidato->load(Yii::$app->request->post());
            $candidato->setArquivo();
            $documento->load(Yii::$app->request->post());
            $documento->setArquivos();

            if ($model->validate() && $candidato->validate() && $documento->validate()) {
                $trans = Yii::$app->db->beginTransaction();
                try{
                    $model->save();
                    $candidato->USU_ID = $model->USU_ID;
                    $candidato->upload();
                    $candidato->save(false);
                    $inscricao->CAND_ID = $candidato->CAND_ID;
                    $inscricao->SEL_ID = $selecao->SEL_ID;
                    $inscricao->save(false);
                    $documento->upload();
                    $documento->CAND_ID = $candidato->CAND_ID;
                    $documento->save(false);
                    
                    foreach (explode(',',$candidato->modalidades) as $modalidade) {
                        $inscmod = new InscricaoModalidade();
                        $inscmod->MDT_ID = $modalidade;
                        $inscmod->INS_ID = $inscricao->INS_ID;
                        $inscmod->save();
                    }
                    $model->enviarSenhaEmail();
                    $trans->commit();
                    return $this->redirect(['view', 'id' => $candidato->CAND_ID]);
                }catch(\Exception $e){
                    $trans->rollBack();
                    throw $e;
                }
            }else{
                return $this->render('create', [
                    'model' => $model,
                    'candidato' => $candidato,
                    'scels' => $scels,
                    'documento'=>$documento
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'candidato' => $candidato,
                'scels' => $scels,
                'documento'=>$documento
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
        $model = Usuario::findOne($id);
        $model->setScenario(Usuario::SCENARIO_ALTERAR);
        $candidato = $model->candidato;
        $selecao = Selecao::inscricoesAbertas();
        $novaInscricao = false;

        if(!$selecao){
            throw new \yii\web\HttpException(403,"Não há processo seletivo aberto!");
        }

        /* Verifica se a inscrição já está relacionada 'a seleção em questão */
        $inscricaoAnterior = Inscricao::find()->where(['SEL_ID'=>$selecao->SEL_ID])->one();
        if(!$inscricaoAnterior){
            $novaInscricao = true;
        }

        $documento = CandidatoDocumento::find()->where(['CAND_ID'=>$candidato->CAND_ID])->one();
        if(!$documento){
            $documento = new CandidatoDocumento();
            $documento->CAND_ID = $candidato->CAND_ID;
        }
        $documento->scenario = CandidatoDocumento::SCENARIO_UPDATE;

        //$smods = SelecaoModalidade::find()->innerJoinWith('modalidadeDataHora')->where(['SEL_ID'=>$selecao->SEL_ID])->all();
        $scels = SelecaoCel::find()->innerJoinWith('selecaoModalidade')->where(['SELECAO_MODALIDADE.SEL_ID'=>$selecao->SEL_ID])->all();
        
        
        if($model->load(Yii::$app->request->post())){
            /*echo "<pre>";
            print_r(Yii::$app->request->post());
            echo "</pre>";
            die;*/
            $candidato->load(Yii::$app->request->post());
            $candidato->setArquivo();
            $documento->load(Yii::$app->request->post());
            $documento->setArquivos();
            if ($model->validate() && $candidato->validate() && $documento->validate()) {
                $trans = Yii::$app->db->beginTransaction();
                try{
                    $model->save(false);
                    $candidato->upload();    
                    $documento->upload();
                    $candidato->save(false);
                    $documento->save(false);

                    $insc_id = null;

                    if($novaInscricao){
                        $ni = new Inscricao();
                        $ni->CAND_ID = $candidato->CAND_ID;
                        $ni->SEL_ID = $selecao->SEL_ID;
                        $ni->save(false);
                        $insc_id = $ni->INS_ID;
                    }else{
                        $insc_id = $candidato->inscricao->INS_ID;

                    }

                    InscricaoModalidade::deleteAll('INS_ID =:INS_ID ',[':INS_ID'=>$insc_id]);
                    foreach (explode(',',$candidato->modalidades) as $modalidade) {
                        $inscmod = new InscricaoModalidade();
                        $inscmod->MDT_ID = $modalidade;
                        $inscmod->INS_ID = $insc_id;
                        $inscmod->save();
                    }
                    $trans->commit();
                    return $this->redirect(['view', 'id' => $candidato->CAND_ID]);
                }catch(\Exception $e){
                    $trans->rollBack();
                    throw $e;
                }
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'candidato' => $candidato,
                    'scels' => $scels,
                    'documento'=>$documento
    
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'candidato' => $candidato,
                'scels' => $scels,
                'documento'=>$documento

            ]);
        }
    }

    /*private function getFiles(){
        $this->CAND_FOTO = UploadedFile::getInstance($candidato, 'CAND_FOTO');
    }*/

    public function actionImprimir($id){
        
        $model = Candidato::findOne($id);
        $smods = InscricaoModalidade::find()->innerJoinWith('modalidadeDataHora')->where(['INS_ID'=>$model->inscricao->INS_ID])->all();

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

    public function actionAlterarsenha(){

        $model = Usuario::findOne(Yii::$app->user->identity->id);
        $model->setScenario(Usuario::SCENARIO_ALTERAR_SENHA);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect(['default/logout']);
        } else {
            return $this->render('@app/views/usuario/alterar_senha', [
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
