<?php

namespace app\modules\aluno\controllers;
use Yii;
use app\modules\aluno\models\LoginForm;
use app\models\PermissaoEnum;
use app\models\Selecao;
use app\models\Usuario;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Default controller for the `Aluno` module
 */
class DefaultController extends Controller
{
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

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['index']);
    }
}
