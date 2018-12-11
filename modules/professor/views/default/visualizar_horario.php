<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\Selecao;
use app\modules\inscricao\models\InscricaoModalidade;
use app\models\SituacaoSelecaoEnum;
use Yii;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\coordenador\models\SelecaoCelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Visualizar Horário';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selecao-cel-index">

    <h1><?= Html::encode($this->title) ?></h1>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
             [
                'label'=>'Seleção',
                'attribute'=>'SEL_TITULO',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->SEL_TITULO;
                },
                'filter'=> Html::textInput("SelecaoSearch[SEL_TITULO]", $searchModel->SEL_TITULO, ['class'=>'form-control'])
            ],
            [
                'label'=>'Situação',
                'attribute'=>'SEL_SITUACAO',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getSituacaoText();
                },
                'filter'=> Html::dropDownList("SelecaoSearch[SEL_SITUACAO]", $searchModel->SEL_SITUACAO, SituacaoSelecaoEnum::listar(), ['class'=>'form-control','prompt'=>'Selecione'])
            ],
            ['class' => 'yii\grid\ActionColumn',
             'header'=>'Ações',
             'options'=>['width'=>'70px'],
             'template' => '{horariodetalhado}',
             'buttons'  => [
                'horariodetalhado'=> function ($url, $model) {
                        $url = Url::to('horariodetalhado?id='.$model->SEL_ID);
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title'=>'Visualizar Horário']);
                }
                ]
            ]
        ],
    ]); ?>
</div>
