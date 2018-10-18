<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\PermissaoEnum;
use app\models\SituacaoEnum;
use app\models\SexoEnum;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

        <div class="alert-danger">
            <?= $form->errorSummary([$model]); ?>
        </div>
    
        <?= $form->field($model, 'USU_NOME')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'USU_EMAIL')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'USU_CPF')->widget(\yii\widgets\MaskedInput::className(), [
            'mask'=>'999.999.999-99'
        ]) ?>

        <?= $form->field($model, 'USU_DT_NASC')->widget(\yii\widgets\MaskedInput::className(), [
            'mask'=>'99/99/9999'
        ]) ?>

        <?= $form->field($model, 'USU_TELEFONE_1')->widget(\yii\widgets\MaskedInput::className(), [
            'mask'=>'(99)99999-9999'
        ]) ?>
        <?= $form->field($model, 'USU_TELEFONE_2')->widget(\yii\widgets\MaskedInput::className(), [
            'mask'=>'(99)99999-9999'
        ]) ?>

        <?php if(!$model->isNewRecord): ?>
            <?= $form->field($model, 'USU_SITUACAO')->dropDownList(SituacaoEnum::listar()) ?>
        <?php endif; ?>

        <?= $form->field($model, 'USU_SEXO')->radioList(SexoEnum::listar()) ?>
        
        <?php  if($model->isNewRecord): ?>
            <?= $form->field($model, 'USU_PERMISSAO')->radioList(PermissaoEnum::listar()) ?>
        <?php  endif; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
