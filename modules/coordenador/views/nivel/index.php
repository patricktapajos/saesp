<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\coordenador\models\NivelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gerenciar Nível';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nivel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Novo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'NIV_DESCRICAO',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Ações'
            ],
        ],
    ]); ?>
</div>
