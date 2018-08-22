<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InscricaoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inscricao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'CAND_ID') ?>

    <?= $form->field($model, 'INS_ID') ?>

    <?= $form->field($model, 'INS_PCD') ?>

    <?= $form->field($model, 'INS_SITUACAO') ?>

    <?= $form->field($model, 'INS_DT_CADASTRO') ?>

    <?php // echo $form->field($model, 'SEL_ID') ?>

    <?php // echo $form->field($model, 'INS_NUM_INSCRICAO') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
