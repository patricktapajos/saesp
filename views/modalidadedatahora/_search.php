<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ModalidadedatahoraSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modalidadedatahora-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'SMOD_ID') ?>

    <?= $form->field($model, 'MDT_HORARIO_INICIO') ?>

    <?= $form->field($model, 'MDT_HORARIO_FIM') ?>

    <?= $form->field($model, 'MDT_QTDE_VAGAS') ?>

    <?= $form->field($model, 'SMOD_status') ?>

    <?= $form->field($model, 'PROF_ID') ?>

    <?= $form->field($model, 'PROF_ID') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
