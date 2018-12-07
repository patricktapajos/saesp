<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
            'SEL_TITULO',
            'SEL_DT_INICIO_CAD',
            'SEL_DT_FIM_CAD',
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
            'header'=>'Ações',
            'template'=>'{view} {update} {delete} {reabrir}',
            'options'=>['width'=>'70px'],
            'buttons'  => [
                'reabrir'=> function ($url, $model) {
                     $url = Url::to('reabrir?id='.$model->SEL_ID);
                     return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title'=>'Reabrir Seleção']);
                }
            ],
            'visibleButtons' => [
                'view' => function ($model) {
                    return true;
                },
                'update' => function ($model) {
                    return !$model->isEncerrado();
                },
                'delete' => function ($model) {
                    return !$model->isEncerrado();
                },
                'reabrir' => function ($model) {
                    return $model->isEncerrado() && $model->isUltimaCadastrada();
                },
            ]
            ],
        ],
    ]); ?>
</div>
