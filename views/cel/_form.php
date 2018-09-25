<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Coordenador;
use app\models\SituacaoEnum;

/* @var $this yii\web\View */
/* @var $model app\models\Cel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cel-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'CEL_NOME')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'CEL_EMAIL')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'CEL_TELEFONE')->widget(\yii\widgets\MaskedInput::className(), [
            'mask'=>'(99)99999-9999'
        ]) ?>

        <div class="col-lg-6 col-sm-12">
            <?= $form->field($model, 'CEL_LATITUDE')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($model, 'CEL_LONGITUDE')->textInput(['maxlength' => true]) ?>
        </div>
        
        <?= $form->field($model, 'CEL_CEP')->widget(\yii\widgets\MaskedInput::className(), [
            'mask'=>'99999-999'
        ]) ?>
        
        <?= $form->field($model, 'CEL_LOGRADOURO')->textInput(['maxlength' => true]) ?>
       
        <?= $form->field($model, 'CEL_BAIRRO')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'CEL_COMPLEMENTO_END')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, '_nome_coordenador')->widget(\yii\jui\AutoComplete::classname(), [
            'clientOptions' => [
                'source' => '/rest/coordenadores',
                'minLength'=>'3',
                'select'=>new yii\web\JsExpression("function(event, ui) {
                    $('#CRD_ID').val(ui.item.id);
                }"),
                'change'=>new yii\web\JsExpression("function(event, ui) {
                    $('#CRD_ID').val(ui.item? ui.item.id : '' );}"),
            ],
            'options'=>['class'=>'form-control']
        ]) ?>

        <?= Html::activeHiddenInput($model,'CRD_ID', ['id'=>'CRD_ID']); ?>

        <?php if(!$model->isNewRecord): ?>
            <?= $form->field($model, 'CEL_STATUS')->dropdownList(SituacaoEnum::listar(), ['prompt' => 'Selecione >>']) ?>
        <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
