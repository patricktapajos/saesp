<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\coordenador\models\SelecaoCelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gerenciar CEL/Seleção';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selecao-cel-index">

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
             [
                'label'=>'Seleção',
                'attribute'=>'SEL_ID',
                'format' => 'raw',
                'value' => function ($model) {
                     return  $model->selecao->SEL_DESCRICAO;
                },
                'filter'=> Html::dropDownList("SelecaoCelSearch[SEL_ID]", $model->SEL_ID, [], ['class'=>'form-control','prompt'=>'Selecione'])
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
