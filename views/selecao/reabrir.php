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

$this->title = 'Reabrir Seleção';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Seleção', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="selecao-create">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="selecao-form" id="selecao">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'SEL_TITULO')->textInput(['maxlength' => true, 'disabled'=>true]) ?>

        <?= $form->field($model, 'SEL_DESCRICAO')->textarea(['disabled'=>true]) ?>

        <?= $form->field($model, 'justificativa')->textarea() ?>


        <div class="row">
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

        <div class="form-group">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>