<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\inscricao\models\Candidato */

$this->title = $model->CAND_ID;
$this->params['breadcrumbs'][] = ['label' => 'Candidatos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidato-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->CAND_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->CAND_ID], [
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
            'CAND_ESTADO_CIVIL',
            'CAND_CPF',
            'CAND_LOGRADOURO',
            'CAND_COMPLEMENTO_END',
            'CAND_CEP',
            'CAND_BAIRRO',
            'CAND_ID',
            'USU_ID',
            'CAND_NOME_EMERGENCIA',
            'CAND_TEL_EMERGENCIA',
            'CAND_NOME_RESPONSAVEL',
            'CAND_TEM_COMORBIDADE',
            'CAND_COMORBIDADE_DESC',
            'CAND_TEM_MEDICACAO',
            'CAND_MEDICACAO_DESC',
            'CAND_OBSERVACOES',
        ],
    ]) ?>

</div>
