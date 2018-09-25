<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\aluno\models\AlunoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aluno-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ALU_ESTADO_CIVIL') ?>

    <?= $form->field($model, 'ALU_CPF') ?>

    <?= $form->field($model, 'ALU_LOGRADOURO') ?>

    <?= $form->field($model, 'ALU_COMPLEMENTO_END') ?>

    <?= $form->field($model, 'ALU_CEP') ?>

    <?php // echo $form->field($model, 'ALU_BAIRRO') ?>

    <?php // echo $form->field($model, 'CAND_ID') ?>

    <?php // echo $form->field($model, 'ALU_NOME_EMERGENCIA') ?>

    <?php // echo $form->field($model, 'ALU_TEL_EMERGENCIA') ?>

    <?php // echo $form->field($model, 'ALU_NOME_RESPONSAVEL') ?>

    <?php // echo $form->field($model, 'ALU_TEM_COMORBIDADE') ?>

    <?php // echo $form->field($model, 'ALU_COMORBIDADE_DESC') ?>

    <?php // echo $form->field($model, 'ALU_TEM_MEDICACAO') ?>

    <?php // echo $form->field($model, 'ALU_MEDICACAO_DESC') ?>

    <?php // echo $form->field($model, 'ALU_OBSERVACOES') ?>

    <?php // echo $form->field($model, 'ALU_ID') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
