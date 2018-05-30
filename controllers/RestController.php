<?php

namespace app\controllers;
use app\models\Selecao;
use app\models\SituacaoSelecaoEnum;
use app\modules\coordenador\models\Modalidade;
use app\modules\coordenador\models\SelecaoCel;
use app\modules\coordenador\models\SelecaoModalidade;
use app\modules\coordenador\models\ModalidadeDataHora;
use app\modules\coordenador\models\ModalidadeDiaSemana;
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
                    'coordenadores' => ['GET'],
                    'alterarmodalidades' => ['GET'],
                    'salvarcelselecao' => ['POST'],
                ],
            ],
        ];
    }

	 public function actionModalidades(){
	 	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $modalidades = Modalidade::find()->andWhere('CEL_ID = :CEL_ID', [':CEL_ID'=>Yii::$app->user->identity->cel_id])->all();
        return $modalidades;
    }

    public function actionAlterarmodalidades(){

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $selecao = Selecao::find()->where(['SEL_SITUACAO'=>SituacaoSelecaoEnum::CADASTRADO])->one();
        $scel = SelecaoCel::find()->where(['SEL_ID'=>$selecao->SEL_ID, 'CEL_ID'=>Yii::$app->user->identity->cel_id])->one();

        $modalidades = ['SEL_ID'=>$selecao->SEL_ID];

        foreach ($scel->cel->modalidades as $o=>$modalidade) {
            $modalidades['modalidades'][$o]['MOD_ID'] = $modalidade->MOD_ID;
            $modalidades['modalidades'][$o]['MOD_DESCRICAO'] = $modalidade->MOD_DESCRICAO;
            $modalidades['modalidades'][$o]['complemento'] = [];

            foreach ($modalidade->selecaoModalidades as $smod) {
                $modalidades['modalidades'][$o]['SMOD_ID'] = $smod->SMOD_ID;
                foreach ($smod->modalidadeDataHora as $n=>$mdh) {
                    $modalidades['modalidades'][$o]['complemento'][$n]['MDT_ID'] = $mdh->MDT_ID;
                    $modalidades['modalidades'][$o]['complemento'][$n]['MDT_HORARIO_INICIO'] = $mdh->MDT_HORARIO_INICIO;
                    $modalidades['modalidades'][$o]['complemento'][$n]['MDT_HORARIO_FIM'] = $mdh->MDT_HORARIO_FIM;
                    $modalidades['modalidades'][$o]['complemento'][$n]['MDT_QTDE_VAGAS'] = $mdh->MDT_QTDE_VAGAS;
                    $modalidades['modalidades'][$o]['complemento'][$n]['PROF_ID'] = $mdh->PROF_ID;
                    $modalidades['modalidades'][$o]['complemento'][$n]['_nome_professor'] = $mdh->professor->usuario->USU_NOME;
                    $modalidades['modalidades'][$o]['complemento'][$n]['dias'] = [];
                    foreach ($mdh->modalidadeDiaSemana as $p=>$mds) {
                        $modalidades['modalidades'][$o]['complemento'][$n]['dias'][$p] = $mds->MDS_DESCRICAO; 
                    }
                }
            }
        }

        return $modalidades;
    }

    public function actionCoordenadores(){

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $listaUsuarios = [];
        $descricao = strtolower($_GET['term']);
    
        $sql = "SELECT C.CRD_ID, U.USU_ID, USU_NOME FROM USUARIO U INNER JOIN COORDENADOR C ON U.USU_ID = C.USU_ID LEFT OUTER JOIN CEL ON C.CRD_ID = CEL.CRD_ID WHERE CEL.CRD_ID is null AND lower(USU_NOME) LIKE '%{$descricao}%'";
        $createCommand = Yii::$app->db->createCommand($sql);
        $usuarios = $createCommand->queryAll();
    
        foreach ($usuarios as $key=>$value) {
            $listaUsuarios[$key]['id'] = "{$value['CRD_ID']}";
            $listaUsuarios[$key]['label'] = $value['USU_NOME'];
        }
    
        return $listaUsuarios;
    }

     public function actionProfessores(){

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $listaUsuarios = [];
        $descricao = strtolower($_GET['term']);
    
        $sql = "SELECT P.PROF_ID, U.USU_ID, USU_NOME FROM USUARIO U INNER JOIN PROFESSOR P ON U.USU_ID = P.USU_ID WHERE USU_SITUACAO = 'ATIVO' AND lower(USU_NOME) LIKE '%{$descricao}%'";
        $createCommand = Yii::$app->db->createCommand($sql);
        $usuarios = $createCommand->queryAll();
    
        foreach ($usuarios as $key=>$value) {
            $listaUsuarios[$key]['id'] = "{$value['PROF_ID']}";
            $listaUsuarios[$key]['label'] = $value['USU_NOME'];
        }
    
        return $listaUsuarios;
    }

      public function actionSalvarcelselecao(){

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $scel = new SelecaoCel();
        $scel->setScenario(SelecaoCel::SCENARIO_VALIDACAO);

        $scel->load(Yii::$app->request->post());

        /* Lista de objetos a serem validados */
        $retorno = array('success'=>1,'erros'=>null);

        if(!$scel->validate()){
            foreach($scel->getErrors() as $n=>$erro){
                $retorno['erros']['selecaocel'][$n] = implode(',',$erro);
            }
            //$retorno['erros']['selecaocel'] = $scel->errors;
            $retorno['success'] = 0;
        }

        foreach ($scel->getModalidades() as $n=>$modalidade) {

            $selecaoModalidade = new SelecaoModalidade;
            $selecaoModalidade->setScenario(SelecaoModalidade::SCENARIO_VALIDACAO);
            $selecaoModalidade->SEL_ID = $scel->SEL_ID;
            $selecaoModalidade->MOD_ID = $modalidade['MOD_ID'];
            $selecaoModalidade->setComplemento($modalidade['complemento']);
            
            if(!$selecaoModalidade->validate()){
                $retorno['erros']['modalidades'][$n]['complemento'] = $selecaoModalidade->errors;
                $retorno['success'] = 0;
            }

            foreach ($selecaoModalidade->getComplemento() as $o=>$com) {
                $mdatahora = new ModalidadeDataHora;
                $mdatahora->setAttributes($com);
                $mdatahora->setDias($com['dias']);
                $mdatahora->SMOD_ID = $selecaoModalidade->MOD_ID;

                if(!$mdatahora->validate()){
                    $retorno['erros']['modalidades'][$n]['complemento'][$o] = $mdatahora->errors;
                    $retorno['success'] = 0;
                }
            }
        }
        return $retorno;
    }
}