<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\coordenador\models\SelecaoCel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="selecao-cel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'SCEL_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CEL_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SEL_ID')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
