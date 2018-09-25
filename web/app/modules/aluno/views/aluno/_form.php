<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\aluno\models\Aluno */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aluno-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ALU_ESTADO_CIVIL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALU_CPF')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALU_LOGRADOURO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALU_COMPLEMENTO_END')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALU_CEP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALU_BAIRRO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAND_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALU_NOME_EMERGENCIA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALU_TEL_EMERGENCIA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALU_NOME_RESPONSAVEL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALU_TEM_COMORBIDADE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALU_COMORBIDADE_DESC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALU_TEM_MEDICACAO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALU_MEDICACAO_DESC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALU_OBSERVACOES')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALU_ID')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
