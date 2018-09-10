<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Inscricao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inscricao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CAND_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'INS_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'INS_PCD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'INS_SITUACAO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'INS_DT_CADASTRO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SEL_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'INS_NUM_INSCRICAO')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
