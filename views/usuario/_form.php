<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\PermissaoEnum;
use app\models\SituacaoEnum;
use app\models\SexoEnum;
use yii\helpers\Url;
use app\assets\UsuarioAsset;
UsuarioAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-form" id="usuario">

    <?php $form = ActiveForm::begin([
        'id'=>'usuario-form',
        'options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="alert-danger">
            <?= $form->errorSummary([$model]); ?>
        </div>
    
        <?= $form->field($model, 'USU_NOME')->textInput(['maxlength' => true]) ?>

        <div class="row">
            <div class="col-lg-4">
                <?= $form->field($model, 'USU_CPF')->widget(\yii\widgets\MaskedInput::className(), ['mask'=>'999.999.999-99']) ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'USU_EMAIL')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'USU_DT_NASC')->widget(\yii\widgets\MaskedInput::className(), ['mask'=>'99/99/9999']) ?>
            </div>
        </div>
            
        <div class="row">
            <div class="col-lg-4">
                <?= $form->field($model, 'USU_SEXO')->radioList(SexoEnum::listar()) ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'USU_TELEFONE_1')->widget(\yii\widgets\MaskedInput::className(), ['mask'=>'(99)99999-9999']) ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'USU_TELEFONE_2')->widget(\yii\widgets\MaskedInput::className(), ['mask'=>'(99)99999-9999']) ?>
            </div>
        </div>

        <?php if(!$model->isNewRecord): ?>
            <?= $form->field($model, 'USU_SITUACAO')->dropDownList(SituacaoEnum::listar()) ?>
        <?php endif; ?>

        
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
           </div>
            
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

    <div class="img-usuario-cover">
            <img src="<?= $model->getUrlFoto(); ?>" id="foto-user" class="img-documentacao" />
        </div>
            <?= $form->field($model, 'USU_URL_FOTO')->fileInput(['class'=>'urlfoto','id'=>'user']); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>