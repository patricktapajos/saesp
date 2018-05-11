<?php

namespace app\controllers;
use app\modules\coordenador\models\Modalidade;
use app\modules\coordenador\models\SelecaoCel;
use app\modules\coordenador\models\SelecaoModalidade;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;

class RestController extends \yii\web\Controller
{
	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'modalidades' => ['GET'],
                ],
            ],
        ];
    }

	 public function actionModalidades(){
	 	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $modalidades = Modalidade::find()->andWhere('CEL_ID = :CEL_ID', [':CEL_ID'=>Yii::$app->user->identity->cel_id])->all();
        return $modalidades;
    }

     public function actionProfessores(){

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $listaUsuarios = [];
        $descricao = strtolower($_GET['term']);
    
        $sql = "SELECT U.USU_ID, USU_NOME FROM USUARIO U INNER JOIN PROFESSOR P ON U.USU_ID = P.USU_ID WHERE USU_SITUACAO = 'ATIVO' AND lower(USU_NOME) LIKE '%{$descricao}%'";
        $createCommand = Yii::$app->db->createCommand($sql);
        $usuarios = $createCommand->queryAll();
    
        foreach ($usuarios as $key=>$value) {
            $listaUsuarios[$key]['id'] = "{$value['USU_ID']}";
            $listaUsuarios[$key]['label'] = $value['USU_NOME'];
        }
    
        return $listaUsuarios;
    }

      public function actionSalvarCelSelecao(){

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $scel = new SelecaoCel();
        $scel->load(Yii::$app->request->post());
        
        /* Lista de objetos a serem validados */
        $retorno = array('success'=>1,'erros'=>null);

        if(!$scel->validate()){
            $retorno['erros']['plan'] = $scel->errors;
            $retorno['success'] = 0;
        }

        foreach ($scel->modalidades as $n=>$modalidade) {
            $selecaoModalidade = new SelecaoModalidade;
            $selecaoModalidade = $modalidade;
            $selecaoModalidade->complemento = $acao['complement'];

            if(!$novaacao->validate()){
                $retorno['erros']['actions'][$n] = $novaacao->errors;
                $retorno['success'] = 0;
            }

            foreach ($novaacao->complement as $o=>$comp) {
                $complemento = new complementoacao;
                $complemento->scenario = $scenario;
                $complemento->attributes = $comp;
                $novaacao->complement[] = $complemento;             

                if(!$complemento->validate()){
                    $retorno['erros']['actions'][$n]['complement'][$o] = $complemento->errors;
                    $retorno['success'] = 0;
                }
            }
        }
        return $retorno;
    }
}