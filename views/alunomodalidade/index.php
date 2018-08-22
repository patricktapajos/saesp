<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlunoModalidadeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aluno Modalidades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-modalidade-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'AMO_ID',
            'ALU_ID',
            'SMOD_ID',
            'AMO_STATUS',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
