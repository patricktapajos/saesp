<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Alterar Senha';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="usuario-create">

    <h1><?= Html::encode($this->title) ?></h1>

	<div class="usuario-form">

	    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, '_senha_atual')->passwordInput(); ?>

        <?= $form->field($model, '_nova_senha')->passwordInput(); ?>

        <?= $form->field($model, '_nova_senha_confirmacao')->passwordInput(); ?>

	    <div class="form-group">
	        <?= Html::submitButton('Salvar',['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>
</div>
