<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gerenciar Centros';
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

            'cel_nome',
            'cel_email:email',
            'cel_telefone',
            'cel_latitude',
            'cel_longitude',
            // 'cel_logradouro',
            // 'cel_cep',
            // 'cel_bairro',
            // 'cel_complemento_end',
            // 'cel_id',
            // 'crd_id',
            // '',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
