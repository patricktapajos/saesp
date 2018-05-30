<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\SituacaoSelecaoEnum;
use app\assets\SelecaoAsset;

SelecaoAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Selecao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="selecao-form" id="selecao">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-sm-12 col-lg-12">
	    <?= $form->field($model, 'SEL_DESCRICAO')->textInput(['maxlength' => true]) ?>
	</div>

	<?php if(!$model->isNewRecord): ?>
    <div class="col-sm-12 col-lg-12">
		<?= $form->field($model, 'SEL_SITUACAO')->dropDownList(SituacaoSelecaoEnum::listar(),['prompt'=>'Selecione >>','id'=>'situacao', 'v-on:change'=>'verificaSituacao()']) ?>
	</div>
	<?php endif; ?>
    <div v-show="show_data_inscricao">
	    <div class="col-sm-12 col-lg-6">
		    <?= $form->field($model, 'SEL_DT_INICIO')->widget(\yii\jui\DatePicker::className(), [
		    	'language'=>'pt-BR',
		    	'dateFormat' => 'dd/MM/yyyy',
			    'options'=>['id'=>'sel_dt_inicio','class'=>'form-control','v-on:blur'=>'atualizarData()'],
			]) ?>
		</div>
	    <div class="col-sm-12 col-lg-6">
		    <?= $form->field($model, 'SEL_DT_FIM')->widget(\yii\jui\DatePicker::className(), [
		    	'language'=>'pt-BR',
		    	'dateFormat' => 'dd/MM/yyyy',
			    'options'=>['id'=>'sel_dt_fim','class'=>'form-control'],
			]) ?>
		</div>
	</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
