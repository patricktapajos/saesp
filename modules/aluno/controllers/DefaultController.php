<?php

namespace app\modules\aluno\controllers;
use Yii;
use app\modules\aluno\models\LoginForm;
use app\models\PermissaoEnum;
use app\models\Selecao;
use app\models\Usuario;
use app\modules\aluno\models\Aluno;
use app\modules\inscricao\models\Inscricao;
use app\modules\inscricao\models\InscricaoModalidade;
use app\modules\inscricao\models\Candidato;
use app\modules\inscricao\models\CandidatoDocumento;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Default controller for the `Aluno` module
 */
class DefaultController extends Controller
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
                        'actions' => ['index','update', 'alterarsenha','view','imprimir'],
                        'roles' => [ PermissaoEnum::PERMISSAO_ALUNO],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['?'],
                    ]
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {	

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['index']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
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

        $documento = CandidatoDocumento::find()->where(['CAND_ID'=>$candidato->CAND_ID])->one();
        if(!$documento){
            $documento = new CandidatoDocumento();
            $documento->CAND_ID = $candidato->CAND_ID;
        }
        $documento->scenario = CandidatoDocumento::SCENARIO_UPDATE;

        
        if($model->load(Yii::$app->request->post())){
            
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

    public function actionEsquecisenha(){

        $model = new Usuario();
        $model->setScenario(Usuario::SCENARIO_ESQUECI_SENHA);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $usuario = Usuario::find()->where(['USU_CPF'=>$model->USU_CPF])->one();
            $senha = $usuario->gerarSenha();
            $usuario->setScenario(Usuario::SCENARIO_ESQUECI_SENHA);
            $trans = Yii::$app->db->beginTransaction();
            try{
                if($usuario->save() && $usuario->enviarSenhaEmail($senha)){
                    $trans->commit();
                    Yii::$app->session->setFlash('success', 'Senha enviada para o email cadastrado!');
                }else{
                    $trans->rollBack();
                    Yii::$app->session->setFlash('error', 'Atenção! Ocorreu um problema durante a requisição, tente novamente mais tarde!');
                }
            }catch(\Exception $e){
                $trans->rollBack();
                throw $e;                
            }
            
            return $this->redirect(['login']);
        } else {
            return $this->render('@app/views/usuario/esqueci_senha', [
                'model' => $model,
            ]);
        }
    }

    public function actionView($id)
    {
        $candidato = Candidato::findOne($id);
        $smods = InscricaoModalidade::find()->innerJoinWith('modalidadeDataHora')->where(['INS_ID'=>$candidato->inscricao->INS_ID])->all();

        return $this->render('view', [
            'model' => $candidato,
            'smods' => $smods,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['index']);
    }
}
