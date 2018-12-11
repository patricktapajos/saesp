<?php

namespace app\modules\professor\controllers;
use app\models\SelecaoSearch;
use app\modules\coordenador\models\ModalidadeDataHora;
use app\modules\coordenador\models\SelecaoModalidade;
use yii\web\Controller;
use Yii;

/**
 * Default controller for the `professor` module
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

    public function actionVisualizarhorario(){
        $searchModel = new SelecaoSearch();
        $searchModel->USU_ID = Yii::$app->user->identity->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('visualizar_horario',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionHorariodetalhado($id){
        
        $smods = SelecaoModalidade::find()->joinWith(['selecao','modalidadeDataHora.professor'])->where('PROFESSOR.USU_ID =:USU_ID and SELECAO.SEL_ID =:SEL_ID', [
                ':USU_ID'=>Yii::$app->user->identity->id, ':SEL_ID'=>$id])->all();

        return $this->render('horario_detalhe',['smods'=>$smods]);
    }
}
