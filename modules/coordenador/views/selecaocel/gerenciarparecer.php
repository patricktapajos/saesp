<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\modules\coordenador\models\SelecaoCel;
use app\modules\inscricao\models\InscricaoModalidade;
use app\modules\inscricao\models\Inscricao;
use app\models\SituacaoInscricaoEnum;
use app\modules\inscricao\models\CandidatoDocumento;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InscricaomodalidadeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gerenciar Parecer #'.$selecaocel->selecao->SEL_TITULO;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selecao-cel-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'INS_NUM_INSCRICAO',
            [
                'label'=>'Nome',
                'format' => 'raw',
                'value' => function ($model) {
                     return $model->candidato->usuario->USU_NOME;
                },
                'filter'=> Html::textInput("InscricaoParecerSearch[USU_NOME]", $searchModel->USU_NOME,['class'=>'form-control'])
            ],
            [
                'label'=>'CPF',
                'format' => 'raw',
                'value' => function ($model) {
                     return $model->candidato->usuario->USU_CPF;
                },
                'filter'=> Html::textInput("InscricaoParecerSearch[USU_CPF]", $searchModel->USU_CPF,['class'=>'form-control'])
            ],
            [
                'label'=>'Situação',
                'format' => 'raw',
                'value' => function ($model) {
                     return $model->getSituacaoText();
                },
                'filter'=> Html::dropDownList("InscricaoParecerSearch[INS_SITUACAO]",$searchModel->INS_SITUACAO ,SituacaoInscricaoEnum::listar(),['prompt'=>'Selecione','class'=>'form-control'])
            ],

            ['class' => 'yii\grid\ActionColumn',
              'header'=>'Ações',
             'template' => '{parecer} {visualizar} {impressaocarteira}',
             'buttons'  => [
               'parecer'   => function ($url, $model) {
                    $url ='../selecaocel/parecer?id='.$model->INS_ID;
                    return $model->isAguardando() ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,['title'=>'Parecer']):'';
                },
                'visualizar'   => function ($url, $model) {
                    $url ='../selecaocel/visualizaraluno?id='.$model->INS_ID;
                    return $model->isDeferido() ? Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,['title'=>'Visualizar Aluno']): '';
                },
                'impressaocarteira'   => function ($url, $model) {
                    $url ='../aluno/imprimircarteirinha?id='.$model->INS_ID;
                    return $model->isDeferido() ? Html::a('<span class="glyphicon glyphicon-print"></span>', $url,['title'=>'Impressão Carteirinha']): '';
                }
             ]
            ],

        ],
    ]); ?>
</div>
