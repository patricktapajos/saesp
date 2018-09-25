<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\aluno\models\Aluno */

$this->title = $model->ALU_ID;
$this->params['breadcrumbs'][] = ['label' => 'Alunos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ALU_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ALU_ID], [
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
            'ALU_ESTADO_CIVIL',
            'ALU_CPF',
            'ALU_LOGRADOURO',
            'ALU_COMPLEMENTO_END',
            'ALU_CEP',
            'ALU_BAIRRO',
            'CAND_ID',
            'ALU_NOME_EMERGENCIA',
            'ALU_TEL_EMERGENCIA',
            'ALU_NOME_RESPONSAVEL',
            'ALU_TEM_COMORBIDADE',
            'ALU_COMORBIDADE_DESC',
            'ALU_TEM_MEDICACAO',
            'ALU_MEDICACAO_DESC',
            'ALU_OBSERVACOES',
            'ALU_ID',
        ],
    ]) ?>

</div>
