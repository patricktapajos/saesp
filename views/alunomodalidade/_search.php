<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AlunoModalidadeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aluno-modalidade-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'AMO_ID') ?>

    <?= $form->field($model, 'ALU_ID') ?>

    <?= $form->field($model, 'SMOD_ID') ?>

    <?= $form->field($model, 'AMO_STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
