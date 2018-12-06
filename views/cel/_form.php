<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Coordenador;
use app\models\SituacaoEnum;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Cel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cel-form">

    <?php $form = ActiveForm::begin(); ?>

        <div class="alert-danger">
            <?= $form->errorSummary([$model]); ?>
        </div>

        <?= $form->field($model, 'CEL_NOME')->textInput(['maxlength' => true]) ?>

		<span class="text-danger">> Inicie digitando no campo a seguir, uma lista deve aparecer com o nome do coordenador. Caso não apareça, entre em contato com o administrador. </span>

        <?= $form->field($model, '_nome_coordenador')->widget(\yii\jui\AutoComplete::classname(), [
            'clientOptions' => [
                'source' => Url::to(['/rest/coordenadores']),
                'minLength'=>'3',
                'select'=>new yii\web\JsExpression("function(event, ui) {
                    $('#CRD_ID').val(ui.item.id);
                }"),
                'change'=>new yii\web\JsExpression("function(event, ui) {
                    if(!ui.item){
                        $('#msgerro').text('Coordenador não encontrado');
                    }else{
                        $('#msgerro').text('');
                    }
                    $('#CRD_ID').val(ui.item? ui.item.id : '' );}"),
            ],
            'options'=>['class'=>'form-control']
        ]) ?>

        <?= $form->field($model, 'CRD_ID')->hiddenInput(['id'=>'CRD_ID'])->label(false); ?>
        <span class="text-danger" id="msgerro"></span>

        
        <?= $form->field($model, 'CEL_EMAIL')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'CEL_TELEFONE')->widget(\yii\widgets\MaskedInput::className(), [
            'mask'=>'(99)99999-9999'
        ]) ?>

        <!--
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($model, 'CEL_LATITUDE')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($model, 'CEL_LONGITUDE')->textInput(['maxlength' => true]) ?>
        </div>
        -->
        <?= $form->field($model, 'CEL_CEP')->widget(\yii\widgets\MaskedInput::className(), [
            'mask'=>'99999-999'
        ]) ?>
        
        <?= $form->field($model, 'CEL_LOGRADOURO')->textInput(['maxlength' => true]) ?>
       
        <?= $form->field($model, 'CEL_BAIRRO')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'CEL_COMPLEMENTO_END')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'CEL_STATUS')->dropdownList(SituacaoEnum::listar(), ['prompt' => 'Selecione >>']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
