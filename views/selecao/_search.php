<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SelecaoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="selecao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'SEL_ID') ?>

    <?= $form->field($model, 'SEL_DT_INICIO') ?>

    <?= $form->field($model, 'SEL_DT_FIM') ?>

    <?= $form->field($model, 'SEL_SITUACAO') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
