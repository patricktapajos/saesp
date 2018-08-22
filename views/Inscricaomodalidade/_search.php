<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InscricaomodalidadeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inscricaomodalidade-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IMO_ID') ?>

    <?= $form->field($model, 'INS_ID') ?>

    <?= $form->field($model, 'MDT_ID') ?>

    <?= $form->field($model, 'IMO_STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
