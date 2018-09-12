<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Categoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="alert-danger">
        <?= $form->errorSummary([$model]); ?>
    </div>

    <?= $form->field($model, 'CAT_DESCRICAO')->widget(\yii\jui\AutoComplete::classname(), [
        'clientOptions' => [
            'source' => '/rest/categorias',
            'minLength'=>'3',
            'select'=>new yii\web\JsExpression("function(event, ui) {
                $('#CAT_ID').val(ui.item.id);
            }"),
            'change'=>new yii\web\JsExpression("function(event, ui) {
                $('#CAT_ID').val(ui.item? ui.item.id : '' );}"),
        ],
        'options'=>['class'=>'form-control']
    ]) ?>

    <?= Html::activeHiddenInput($model,'CAT_ID', ['id'=>'CAT_ID']); ?>


    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
