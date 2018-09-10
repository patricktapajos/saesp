<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Selecaomodalidade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="selecaomodalidade-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'SMOD_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SEL_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MOD_ID')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
