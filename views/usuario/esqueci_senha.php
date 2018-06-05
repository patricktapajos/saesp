<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Esqueci a Senha';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="usuario-create">

    <h1><?= Html::encode($this->title) ?></h1>

	<div class="usuario-form">

	    <?php $form = ActiveForm::begin(); ?>

	    <div class="row">
	        <div class="col-lg-3 col-sm-12">
	            <?= $form->field($model, 'USU_CPF')->widget(\yii\widgets\MaskedInput::className(), [
	                'mask'=>'999.999.999-99'
	            ]) ?>
	        </div>
	    </div>

	    <div class="form-group">
	        <?= Html::submitButton('Enviar',['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>
</div>
