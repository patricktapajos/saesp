<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\aluno\models\AlunoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gerenciar Aluno';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'Nome',
                'attribute'=>'USU_NOME',
                'format' => 'raw',
                'value' => function ($model) {
                    if($model->candidato->usuario){
                        return $model->candidato->usuario->USU_NOME;
                    }
                },
                'filter'=> Html::textInput("AlunoSearch[USU_NOME]", $searchModel->USU_NOME, ['class'=>'form-control'])
            ],
            [
                'label'=>'CPF',
                'attribute'=>'USU_CPF',
                'format' => 'raw',
                'value' => function ($model) {
                    if($model->candidato->usuario){
                        return $model->candidato->usuario->USU_CPF;
                    }
                },
                'filter'=> Html::textInput("AlunoSearch[USU_CPF]", $searchModel->USU_CPF, ['class'=>'form-control'])
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Ações'
            ],
        ],
    ]); ?>
</div>
