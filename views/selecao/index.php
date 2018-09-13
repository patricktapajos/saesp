<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\SituacaoSelecaoEnum;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SelecaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gerenciar Seleção';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selecao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Novo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'SEL_DESCRICAO',
            'SEL_DT_INICIO',
            'SEL_DT_FIM',
            [
                'label'=>'Situação',
                'attribute'=>'SEL_SITUACAO',
                'format' => 'raw',
                'value' => function ($model) {
                     return  $model->getSituacaoText();
                },
                'filter'=> Html::dropDownList("SelecaoSearch[SEL_SITUACAO]", $searchModel->SEL_SITUACAO, SituacaoSelecaoEnum::listar(), ['class'=>'form-control','prompt'=>'Selecione'])
            ],

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view} {update}'
            ],
        ],
    ]); ?>
</div>
