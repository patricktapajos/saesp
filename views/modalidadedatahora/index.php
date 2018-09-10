<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ModalidadedatahoraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Modalidades e Horas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modalidadedatahora-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'MDT_HORARIO_INICIO',
            'MDT_HORARIO_FIM',
            [
              'attribute'=>'SMOD_ID',
              'value' => function ($model) {
                   return $model->sMOD->mODALIDADE->MOD_DESCRICAO;
              }
            ],
            'MDT_QTDE_VAGAS',
            [
              'attribute'=>'PROF_ID',
              'value' => function ($model) {
                   return $model->pROFESSOR->usuario->USU_NOME;
              }
            ],
            'MDT_STATUS',
            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view} {update}'],
        ],
    ]); ?>
</div>
