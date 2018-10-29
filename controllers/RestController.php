<?php

namespace app\controllers;
use app\models\Selecao;
use app\modules\inscricao\models\Candidato;
use app\modules\inscricao\models\Inscricao;
use app\modules\inscricao\models\InscricaoModalidade;
use app\models\SituacaoSelecaoEnum;
use app\modules\coordenador\models\Modalidade;
use app\modules\coordenador\models\SelecaoCel;
use app\modules\coordenador\models\SelecaoModalidade;
use app\modules\coordenador\models\ModalidadeDataHora;
use app\modules\coordenador\models\ModalidadeDiaSemana;
use app\modules\coordenador\models\Categoria;
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
                    'inscricaomodalidades' => ['GET'],
                    'categorias' => ['GET'],
                    'modalidadescadastro' => ['GET'],
                    'salvarcelselecao' => ['POST'],
                ],
            ],
        ];
    }

	 public function actionModalidades(){
	 	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $modalidades = Modalidade::find()->andWhere('CEL_ID = :CEL_ID', [':CEL_ID'=>Yii::$app->user->identity->cel_id])
            ->orderBy(['MOD_NOME'=>SORT_ASC])->all();
        return $modalidades;
    }

    public function actionAlterarmodalidades(){

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $selecao = Selecao::getSelecaoAtiva();
        
        // verifica se modalidades deste cel foram cadastradas nesta seleção
        $sm = SelecaoModalidade::find()->innerJoinWith(['modalidadeDataHora','modalidade'])->where(['SEL_ID'=>$selecao->SEL_ID,'MODALIDADE.CEL_ID'=>Yii::$app->user->identity->cel_id])->all();
        if(count($sm) == 0){
            return [];
        }

        $scel = SelecaoCel::find()->where(['SEL_ID'=>$selecao->SEL_ID, 'CEL_ID'=>Yii::$app->user->identity->cel_id])->one();
        $modalidades = ['SEL_ID'=>$selecao->SEL_ID];

        foreach ($scel->cel->modalidades as $o=>$modalidade) {
            $modalidades['modalidades'][$o]['MOD_ID'] = $modalidade->MOD_ID;
            $modalidades['modalidades'][$o]['MOD_NOME'] = $modalidade->MOD_NOME;
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


     public function actionInscricaomodalidades(){

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $modalidades = [];
        $selecao = Selecao::find()->where(['SEL_SITUACAO'=>SituacaoSelecaoEnum::INSCRICOES_ABERTAS])->one();
        $inscricao = Inscricao::find()->where(['SEL_ID'=>$selecao->SEL_ID])->one();

        if($inscricao){
            $smods = InscricaoModalidade::find()->innerJoinWith('modalidadeDataHora')->where(['INS_ID'=>$inscricao->INS_ID])->all();

            foreach ($smods as $o=>$smod) {
                foreach ($smod->modalidadeDataHora as $n=>$mdh) {
                    $modalidades[] = $mdh->MDT_ID;
                }
            }
        }
        return $modalidades;
    }

    public function actionCoordenadores(){

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $listaUsuarios = [];
        $descricao = strtolower($_GET['term']);
    
        $sql = "SELECT C.CRD_ID, U.USU_ID, USU_NOME FROM USUARIO U INNER JOIN COORDENADOR C ON U.USU_ID = C.USU_ID LEFT OUTER JOIN CEL ON C.CRD_ID = CEL.CRD_ID WHERE lower(USU_NOME) LIKE '%{$descricao}%'";
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

        $listaModalidades = [];
        foreach ($scel->getModalidades() as $n=>$modalidade) {
            $listaModalidades[] = $modalidade['complemento'];
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
                $mdatahora->quadro_modalidades = $listaModalidades;

                if(!$mdatahora->validate()){
                    $retorno['erros']['modalidades'][$n]['complemento'][$o] = $mdatahora->errors;
                    $retorno['success'] = 0;
                }
            }
        }
        return $retorno;
    }

    public function actionCategorias(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $listaCategorias = [];
        $descricao = strtolower($_GET['term']);
        $categorias = Categoria::find()->andWhere(['like','CAT_DESCRICAO', '%'.$descricao.'%', false])->all();
    
        foreach ($categorias as $key=>$value) {
            $listaCategorias[$key]['id'] = "{$value['CAT_ID']}";
            $listaCategorias[$key]['label'] = $value['CAT_DESCRICAO'];
        }
        return $listaCategorias;
    }


    public function actionModalidadescadastro(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $listaModalidades = [];
        $descricao = strtolower($_GET['term']);
        $categorias = Modalidade::find()->andWhere(['like','MOD_NOME', '%'.$descricao.'%', false])->all();
    
        foreach ($categorias as $key=>$value) {
            $listaCategorias[$key]['id'] = "{$value['MOD_ID']}";
            $listaCategorias[$key]['label'] = $value['MOD_NOME'];
        }
    
        return $listaCategorias;
    }
}