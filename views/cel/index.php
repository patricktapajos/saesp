<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gerenciar CEL';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cel-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Novo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'CEL_NOME',
            'CEL_EMAIL',
            'CEL_TELEFONE',
             [
                'label'=>'Responsável',
                'attribute'=>'coordenador.usuario.USU_NOME',
                'format' => 'raw',
                'value' => function ($model) {
                     return  $model->coordenador->usuario->USU_NOME;
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
