<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\SituacaoSelecaoEnum;
use app\assets\SelecaoAsset;
use yii\bootstrap\ToggleButtonGroup;

SelecaoAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Selecao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="selecao-form" id="selecao">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'SEL_TITULO')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'SEL_DESCRICAO')->textarea() ?>

	<br>

	<div v-show="show_data_cadastro">
		<div class="col-sm-12 col-lg-12">
			<span class="text-danger"> Selecione as datas para que os coordenadores possam cadastrar seus respectivos CEL´s modalidades nesta seleção.</span>
		</div>
	    <div class="col-sm-12 col-lg-6">
		    <?= $form->field($model, 'SEL_DT_INICIO_CAD')->widget(\yii\jui\DatePicker::className(), [
		    	'language'=>'pt-BR',
		    	'dateFormat' => 'dd/MM/yyyy',
			    'options'=>['id'=>'sel_dt_inicio_cad','class'=>'form-control','v-on:blur'=>'atualizarDataCadastro()'],
			]) ?>
		</div>
	    <div class="col-sm-12 col-lg-6">
		    <?= $form->field($model, 'SEL_DT_FIM_CAD')->widget(\yii\jui\DatePicker::className(), [
		    	'language'=>'pt-BR',
		    	'dateFormat' => 'dd/MM/yyyy',
			    'options'=>['id'=>'sel_dt_fim_cad','class'=>'form-control'],
			]) ?>
		</div>
	</div>
	
	<?php if(!$model->isNewRecord): ?>
		
		<label class="control-label">Situação</label>
		<div class="form-group">
			<?= ToggleButtonGroup::widget(
					[
						'model'=>$model,
						'attribute'=>'SEL_SITUACAO',
						'type' => 'radio',
						'labelOptions'=>['class'=>'switch inscricao','disabled'=>!$model->isPreparadoInscricao()],
						'options'=>['id'=>'situacao','onchange'=>"vue.setSituacao()"],
						'items'=>SituacaoSelecaoEnum::listarInscricoes(),
					]
					) ?>

				<?= ToggleButtonGroup::widget(
				[
					'model'=>$model,
					'attribute'=>'SEL_SITUACAO',
					'type' => 'radio',
					'labelOptions'=>['class'=>'switch parecer','disabled'=>!$model->isPreparadoParecer()],
					'options'=>['id'=>'situacao','onchange'=>"vue.setSituacao()"],
					'items'=>SituacaoSelecaoEnum::listarParecer(),
				]
				) ?>
				<?= ToggleButtonGroup::widget(
				[
					'model'=>$model,
					'attribute'=>'SEL_SITUACAO',
					'type' => 'radio',
					'labelOptions'=>['class'=>'switch encerrar','disabled'=>!$model->isPreparadoEncerrar()],
					'options'=>['id'=>'situacao','onchange'=>"vue.setSituacao()"],
					'items'=>SituacaoSelecaoEnum::listarEncerrar(),
				]
				) ?>
		</div>


		<?= Html::hiddenInput('inscricao', $model->isPreparadoInscricao(), ['id'=>'inscricao']) ?>
		<?= Html::hiddenInput('parecer', $model->isPreparadoParecer(), ['id'=>'parecer']) ?>
		<?= Html::hiddenInput('encerrar', $model->isPreparadoEncerrar(), ['id'=>'encerrar']) ?>
		
		<?= $form->field($model, 'SEL_SITUACAO')->hiddenInput(['id'=>'SEL_SITUACAO'])->label(false); ?>
			

		<div v-show="show_data_inscricao" class="row">
			<div class="col-lg-6 col-md-6 col-sm-12">
				<?= $form->field($model, 'SEL_DT_INICIO')->widget(\yii\jui\DatePicker::className(), [
					'language'=>'pt-BR',
					'dateFormat' => 'dd/MM/yyyy',
					'options'=>['id'=>'sel_dt_inicio','class'=>'form-control','v-on:blur'=>'atualizarDataInscricao()'],
				]) ?>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 ">
				<?= $form->field($model, 'SEL_DT_FIM')->widget(\yii\jui\DatePicker::className(), [
					'language'=>'pt-BR',
					'dateFormat' => 'dd/MM/yyyy',
					'options'=>['id'=>'sel_dt_fim','class'=>'form-control'],
				]) ?>
			</div>
		</div>
	<?php else: ?>
		<?= Html::hiddenInput('SEL_SITUACAO','CADASTRADO',['id'=>'situacao']) ?>
	<?php endif; ?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
