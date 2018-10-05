<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\coordenador\models\Categoria;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Modalidade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modalidade-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="alert-danger">
        <?= $form->errorSummary([$model]); ?>
    </div>
    <?php if($model->isNewRecord): ?>
        <?= $form->field($model, 'MOD_NOME')->widget(\yii\jui\AutoComplete::classname(), [
            'clientOptions' => [
                'source' => Url::to(['/rest/modalidadescadastro']),
                'minLength'=>'3',
                'select'=>new yii\web\JsExpression("function(event, ui) {
                    $('#MOD_ID').val(ui.item.id);
                }"),
                'change'=>new yii\web\JsExpression("function(event, ui) {
                    $('#MOD_ID').val(ui.item? ui.item.id : '' );}"),
            ],
            'options'=>['class'=>'form-control']
        ]) ?>
        <?= $form->field($model,'MOD_ID')->hiddenInput(['id'=>'MOD_ID'])->label(false); ?>
    <?php else: ?>
        <?= $form->field($model,'MOD_NOME')->textInput(['id'=>'MOD_NOME']); ?>
    <?php endif; ?>
    
    <?= $form->field($model, 'MOD_DESCRICAO')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'CAT_ID')->dropDownList(Categoria::listar(),['prompt'=>'Selecione >>']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	     <?= Html::a('Cancelar', ['index'] ,['class' => 'btn btn-danger']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
