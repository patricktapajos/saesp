<?php

namespace app\controllers;
use app\modules\coordenador\models\Modalidade;
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

        /*$descricao = strtolower($_GET['term']);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $professores = Professor::find()->with(['usuario'])->andWhere('CEL_ID = :CEL_ID and lower(USU_NOME) like %:USU_NOME%', [':CEL_ID'=>Yii::$app->user->identity->cel_id, ':USU_NOME'=>$descricao])->all();
        return $modalidades;*/
    }
}