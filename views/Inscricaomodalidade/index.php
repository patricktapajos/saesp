<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InscricaomodalidadeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inscrição modalidades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inscricaomodalidade-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'IMO_ID',
            [
              'attribute'=>'INS_ID',
              'value' => function ($model) {
                   return $model->iNS->INS_NUM_INSCRICAO;
              }
            ],
            [
              'attribute'=>'MDT_ID',
              'value' => function ($model) {
                   return $model->mOD_DT_HR->sMOD->mODALIDADE->MOD_DESCRICAO;
              }
            ],
            'IMO_STATUS',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view} {update}'
            ],
        ],
    ]); ?>
</div>
