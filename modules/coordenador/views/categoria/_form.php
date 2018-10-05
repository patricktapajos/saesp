<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Categoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="alert-danger">
        <?= $form->errorSummary([$model]); ?>
    </div>
    <?php if($model->isNewRecord): ?>
        <?= $form->field($model, 'CAT_DESCRICAO')->widget(\yii\jui\AutoComplete::classname(), [
            'clientOptions' => [
                'source' => Url::to(['/rest/categorias']),
                'minLength'=>'3',
                'select'=>new yii\web\JsExpression("function(event, ui) {
                    $('#CAT_ID').val(ui.item.id);
                }"),
                'change'=>new yii\web\JsExpression("function(event, ui) {
                    $('#CAT_ID').val(ui.item? ui.item.id : '' );}"),
            ],
            'options'=>['class'=>'form-control']
        ]) ?>

        <?= $form->field($model,'CAT_ID')->hiddenInput(['id'=>'CAT_ID'])->label(false); ?>
    <?php else: ?>
        <?= $form->field($model,'CAT_DESCRICAO')->textInput(['id'=>'CAT_DESCRICAO']); ?>
    <?php endif; ?>


    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
