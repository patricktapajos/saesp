<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\PermissaoEnum;
use app\models\SituacaoEnum;
use app\models\SexoEnum;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-form" id="usuario">

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
        
        <?php if($model->isNewRecord): ?>
            <?= $form->field($model, 'USU_PERMISSAO')->dropDownList(PermissaoEnum::listar(), [
                    'id'=>'USU_PERMISSAO','prompt'=>'Selecione >>','v-on:change'=>'verificarPermissao()']) ?>

            <div v-show="estagiario">
                <span class="text-danger">> Inicie digitando no campo a seguir, uma lista deve aparecer com o nome do professor. Caso não apareça, você deve cadastrá-lo antes. </span>

                <?= $form->field($model, '_nome')->widget(\yii\jui\AutoComplete::classname(), [
                    'clientOptions' => [
                        'source' => Url::to(['/rest/professores']),
                        'minLength'=>'3',
                        'select'=>new yii\web\JsExpression("function(event, ui) {
                            $('#_prof_id').val(ui.item.id);
                        }"),
                        'change'=>new yii\web\JsExpression("function(event, ui) {
                            if(!ui.item){
                                $('#msgerro').text('Professor não encontrado');
                            }else{
                                $('#msgerro').text('');
                            }
                            $('#_prof_id').val(ui.item? ui.item.id : '' );}"),
                    ],
                    'options'=>['class'=>'form-control']
                ]) ?>

            <?= $form->field($model, '_prof_id')->hiddenInput(['id'=>'_prof_id'])->label(false); ?>
            <span class="text-danger" id="msgerro"></span>
            
        <?php  endif; ?>

        <?php if($model->isEstagiario() && !$model->isNewRecord): ?>
                
                <span class="text-danger">> Inicie digitando no campo a seguir, uma lista deve aparecer com o nome do professor. Caso não apareça, você deve cadastrá-lo antes. </span>
        
                <?= $form->field($model, '_nome')->widget(\yii\jui\AutoComplete::classname(), [
                    'clientOptions' => [
                        'source' => Url::to(['/rest/professores']),
                        'minLength'=>'3',
                        'select'=>new yii\web\JsExpression("function(event, ui) {
                            $('#_prof_id').val(ui.item.id);
                        }"),
                        'change'=>new yii\web\JsExpression("function(event, ui) {
                            if(!ui.item){
                                $('#msgerro').text('Professor não encontrado');
                            }else{
                                $('#msgerro').text('');
                            }
                            $('#_prof_id').val(ui.item? ui.item.id : '' );}"),
                    ],
                    'options'=>['class'=>'form-control']
                ]) ?>

            <?= $form->field($model, '_prof_id')->hiddenInput(['id'=>'_prof_id'])->label(false); ?>
            <span class="text-danger" id="msgerro"></span>
        <?php endif; ?>

       
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
