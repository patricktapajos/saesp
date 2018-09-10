<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AlunoModalidade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aluno-modalidade-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'AMO_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALU_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SMOD_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AMO_STATUS')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
