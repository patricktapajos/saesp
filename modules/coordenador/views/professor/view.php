<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Professor */

$this->title = $model->PROF_ID;
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Professor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="professor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->PROF_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->PROF_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'usuario.USU_NOME',
            'usuario.USU_CPF',
            'usuario.USU_EMAIL',
            'usuario.USU_DT_NASC',
             [
                'label'=>'Sexo',
                'attribute'=>'usuario.USU_SEXO',
                'format' => 'raw',
                'value' => function ($model) {
                     return  $model->usuario->getSexoText();
                }
            ],
            [
                'label'=>'Situação',
                'attribute'=>'usuario.USU_SITUACAO',
                'format' => 'raw',
                'value' => function ($model) {
                     return  $model->usuario->getSituacaoText();
                }
            ],
            'usuario.USU_TELEFONE_1',
            'usuario.USU_TELEFONE_2',
        ],
    ]) ?>

</div>
