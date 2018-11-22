<?php

namespace app\controllers;
use app\models\Selecao;
use app\models\Usuario;
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
                    'inscricaomodalidadesaquaticas' => ['GET'],
                    'validarhorariomodalidade' => ['GET']
                ],
            ],
        ];
    }

    /*public function actionQtdmodalidadeaquatica(){
        
        $lista = $_GET['modalidades'];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $mods = ModalidadeDataHora::find()->where(['in','MDT_ID', $lista])->all();
        $contAquatico = 0;

        foreach ($mods as $mod) {
            if($mod->selecaoModalidade->modalidade->CAT_ID == Categoria::CATEGORIA_AQUATICA){
                $contAquatico++;
            }
        }

        return $contAquatico;
    }*/

	 public function actionModalidades(){
	 	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $modalidades = Modalidade::find()->orderBy(['MOD_NOME'=>SORT_ASC])->all();
        return $modalidades;
    }

    public function actionAlterarmodalidades(){

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $selecao = Selecao::getSelecaoAtiva();
        
        // verifica se modalidades deste cel foram cadastradas nesta seleção
        $sm = SelecaoModalidade::find()->innerJoinWith(['modalidadeDataHora','modalidade'])
            ->where(['SEL_ID'=>$selecao->SEL_ID])->orderBy(['MOD_NOME'=>SORT_ASC])->all();
         
        if(count($sm) == 0){
            return [];
        }


        $modalidades = ['SEL_ID'=>$selecao->SEL_ID];

        $ms = Modalidade::find()->orderBy(['MOD_NOME'=>SORT_ASC])->all();
        
        $modalidades['modalidades'] = [];

        foreach($ms as $mod){
            $modalidades['modalidades'][$mod->MOD_ID]['MOD_ID'] = $mod->MOD_ID;
            $modalidades['modalidades'][$mod->MOD_ID]['MOD_NOME'] = $mod->MOD_NOME;
            $modalidades['modalidades'][$mod->MOD_ID]['complemento'] = [];
        }

        //print_r($modalidades['modalidades']);die;

        foreach ($sm as $selecaomod) {
            $modalidades['modalidades'][$selecaomod->MOD_ID]['SMOD_ID'] = $selecaomod->SMOD_ID;
            $modalidades['modalidades'][$selecaomod->MOD_ID]['MOD_ID'] = $selecaomod->modalidade->MOD_ID;
            $modalidades['modalidades'][$selecaomod->MOD_ID]['MOD_NOME'] = $selecaomod->modalidade->MOD_NOME;
            $modalidades['modalidades'][$selecaomod->MOD_ID]['complemento'] = [];

            foreach ($selecaomod->modalidadeDataHora as $n=>$mdh) {
                $modalidades['modalidades'][$selecaomod->MOD_ID]['complemento'][$n]['MDT_ID'] = $mdh->MDT_ID;
                $modalidades['modalidades'][$selecaomod->MOD_ID]['complemento'][$n]['MDT_HORARIO_INICIO'] = $mdh->MDT_HORARIO_INICIO;
                $modalidades['modalidades'][$selecaomod->MOD_ID]['complemento'][$n]['MDT_HORARIO_FIM'] = $mdh->MDT_HORARIO_FIM;
                $modalidades['modalidades'][$selecaomod->MOD_ID]['complemento'][$n]['MDT_QTDE_VAGAS'] = $mdh->MDT_QTDE_VAGAS;
                $modalidades['modalidades'][$selecaomod->MOD_ID]['complemento'][$n]['PROF_ID'] = $mdh->PROF_ID;
                $modalidades['modalidades'][$selecaomod->MOD_ID]['complemento'][$n]['_nome_professor'] = $mdh->professor->usuario->USU_NOME;
                $modalidades['modalidades'][$selecaomod->MOD_ID]['complemento'][$n]['dias'] = [];
                foreach ($mdh->modalidadeDiaSemana as $p=>$mds) {
                    $modalidades['modalidades'][$selecaomod->MOD_ID]['complemento'][$n]['dias'][$p] = $mds->MDS_DESCRICAO; 
                }
            }
        }

        return $modalidades;
    }


    public function actionValidarhorariomodalidade(){
        
        $modalidades = implode(',', $_GET['modalidades']);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $resultado = (new \yii\db\Query())
            ->select(['MDS_DESCRICAO', 'MDT_HORARIO_INICIO', 'QTDE'=>'count(MODALIDADE_DATAHORA.MDT_ID)'])
            ->from('MODALIDADE_DATAHORA')
            ->innerJoin('MODALIDADE_DIASEMANA', 'MODALIDADE_DIASEMANA.MDT_ID = MODALIDADE_DATAHORA.MDT_ID')
            ->where(['MODALIDADE_DATAHORA.MDT_ID'=> $_GET['modalidades']])
            ->groupBy(['MDS_DESCRICAO', 'MDT_HORARIO_INICIO'])->all();

        foreach ($resultado as $reg) {
            if($reg['QTDE'] > 1){
                return true;
            }
        }
        return false;
    }


    public function actionInscricaomodalidadesaquaticas(){
        
        $selecao = Selecao::inscricoesAbertas();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $mods = ModalidadeDataHora::find()->innerJoinWith(['selecaoModalidade','selecaoModalidade.selecao'])->where(['SELECAO.SEL_ID'=>$selecao->SEL_ID])->all();
        
        $modalidades = [];
        foreach ($mods as $mod) {
            if($mod->selecaoModalidade->modalidade->CAT_ID == Categoria::CATEGORIA_AQUATICA){
                $modalidades[] = $mod->MDT_ID;
            }
        }

        return $modalidades;
    }

     public function actionInscricaomodalidades(){

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = $_GET['id']==null?Yii::$app->user->identity->id:$_GET['id'];
        $modalidades = [];
        $usuario = Usuario::findOne($id);
        $selecao = Selecao::find()->where(['SEL_SITUACAO'=>SituacaoSelecaoEnum::INSCRICOES_ABERTAS])->one();
        $inscricao = Inscricao::find()->where(['SEL_ID'=>$selecao->SEL_ID, 'CAND_ID'=> $usuario->candidato->CAND_ID])->one();

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