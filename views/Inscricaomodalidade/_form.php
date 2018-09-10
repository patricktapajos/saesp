<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Inscricaomodalidade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inscricaomodalidade-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'IMO_ID')->textInput(['maxlength' => true, 'readonly'=> true]) ?>

    <?= $form->field($model, 'INS_ID')->textInput(['maxlength' => true, 'readonly'=> true]) ?>

    <?= $form->field($model, 'MDT_ID')->textInput(['maxlength' => true, 'readonly'=> true]) ?>

    <?= $form->field($model, 'IMO_STATUS')->dropdownList(['ATIVO' => 'Ativo', 'INATIVO' => 'Inativo', 'DESISTENCIA' => 'Desistência'], ['prompt' => '---Selecionae o Status---']) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
