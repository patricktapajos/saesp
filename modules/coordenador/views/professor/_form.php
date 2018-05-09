<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\PermissaoEnum;
use app\models\SituacaoEnum;
use app\models\SexoEnum;

/* @var $this yii\web\View */
/* @var $model app\models\Professor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="professor-form">

    <?php $form = ActiveForm::begin(); ?>

	<div class="row">
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($model, 'USU_NOME')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($model, 'USU_EMAIL')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'USU_CPF')->widget(\yii\widgets\MaskedInput::className(), [
                'mask'=>'999.999.999-99'
            ]) ?>
        </div>

         <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'USU_DT_NASC')->widget(\yii\widgets\MaskedInput::className(), [
                'mask'=>'99/99/9999'
            ]) ?>
        </div>

         <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'USU_TELEFONE_1')->widget(\yii\widgets\MaskedInput::className(), [
                'mask'=>'(99)\99999-9999'
            ]) ?>
        </div>
        <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'USU_TELEFONE_2')->widget(\yii\widgets\MaskedInput::className(), [
                'mask'=>'(99)\99999-9999'
            ]) ?>
        </div>
        
        <div class="col-lg-4 col-sm-12">
            <?= $form->field($model, 'USU_SITUACAO')->dropDownList(SituacaoEnum::listar()) ?>
        </div>

        <div class="col-lg-4 col-sm-12">
            <?= $form->field($model, 'USU_SEXO')->radioList(SexoEnum::listar()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
