<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InscricaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inscricaos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inscricao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Inscricao', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'CAND_ID',
            'INS_ID',
            'INS_PCD',
            'INS_SITUACAO',
            'INS_DT_CADASTRO',
            //'SEL_ID',
            //'INS_NUM_INSCRICAO',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
