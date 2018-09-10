<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\inscricao\models\CandidatoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="candidato-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'CAND_ESTADO_CIVIL') ?>

    <?= $form->field($model, 'CAND_CPF') ?>

    <?= $form->field($model, 'CAND_LOGRADOURO') ?>

    <?= $form->field($model, 'CAND_COMPLEMENTO_END') ?>

    <?= $form->field($model, 'CAND_CEP') ?>

    <?php // echo $form->field($model, 'CAND_BAIRRO') ?>

    <?php // echo $form->field($model, 'CAND_ID') ?>

    <?php // echo $form->field($model, 'USU_ID') ?>

    <?php // echo $form->field($model, 'CAND_NOME_EMERGENCIA') ?>

    <?php // echo $form->field($model, 'CAND_TEL_EMERGENCIA') ?>

    <?php // echo $form->field($model, 'CAND_NOME_RESPONSAVEL') ?>

    <?php // echo $form->field($model, 'CAND_TEM_COMORBIDADE') ?>

    <?php // echo $form->field($model, 'CAND_COMORBIDADE_DESC') ?>

    <?php // echo $form->field($model, 'CAND_TEM_MEDICACAO') ?>

    <?php // echo $form->field($model, 'CAND_MEDICACAO_DESC') ?>

    <?php // echo $form->field($model, 'CAND_OBSERVACOES') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
