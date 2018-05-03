<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Selecao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="selecao-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-sm-12 col-lg-12">
	    <?= $form->field($model, 'SEL_DESCRICAO')->textInput(['maxlength' => true]) ?>
	</div>

    <div class="col-sm-12 col-lg-6">
	    <?= $form->field($model, 'SEL_DT_INICIO')->widget(\yii\jui\DatePicker::class, [
		    'options'=>['id'=>'sel_dt_inicio','class'=>'form-control'],
		    'clientEvents' => [
			    'bind' => 'function () { alert("eitcha"); var date2 = $("#sel_dt_inicio").datepicker("getDate");
	    			$("#sel_dt_fim").datepicker("option", "minDate", date2);}'
			],
		]) ?>
	</div>
    <div class="col-sm-12 col-lg-6">
	    <?= $form->field($model, 'SEL_DT_FIM')->widget(\yii\jui\DatePicker::class, [
		    'options'=>['id'=>'sel_dt_fim','class'=>'form-control']
		]) ?>
	</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
