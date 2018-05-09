<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\inscricao\models\Candidato */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="candidato-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CAND_ESTADO_CIVIL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAND_CPF')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAND_LOGRADOURO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAND_COMPLEMENTO_END')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAND_CEP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAND_BAIRRO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAND_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'USU_ID')->textInput() ?>

    <?= $form->field($model, 'CAND_NOME_EMERGENCIA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAND_TEL_EMERGENCIA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAND_NOME_RESPONSAVEL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAND_TEM_COMORBIDADE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAND_COMORBIDADE_DESC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAND_TEM_MEDICACAO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAND_MEDICACAO_DESC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAND_OBSERVACOES')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
