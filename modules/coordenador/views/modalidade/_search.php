<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ModalidadeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modalidade-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'MOD_NOME') ?>

    <?= $form->field($model, 'MOD_DESCRICAO') ?>

    <?= $form->field($model, 'MOD_ID') ?>

    <?= $form->field($model, 'CEL_ID') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
