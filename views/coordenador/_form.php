<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Coordenador */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="coordenador-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'crd_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'usu_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
