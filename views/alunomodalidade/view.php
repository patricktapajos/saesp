<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AlunoModalidade */

$this->title = $model->AMO_ID;
$this->params['breadcrumbs'][] = ['label' => 'Aluno Modalidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-modalidade-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->AMO_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->AMO_ID], [
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
            'AMO_ID',
            'ALU_ID',
            'SMOD_ID',
            [
                'label'=>'Aluno',
                'value' => function ($model) {
                     return $model->Aluno->ALU_CPF;
                }
            ],
            [
                'label'=>'Modalidade Selecionada',
                'value' => function ($model) {
                     return $model->Selecaomodalidade->Nodalidade->MOD_DESCRICAO;
                }
            ],
            'AMO_STATUS',
        ],
    ]) ?>

</div>
