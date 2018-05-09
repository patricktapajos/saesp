<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\coordenador\models\SelecaoCelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="selecao-cel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'SCEL_ID') ?>

    <?= $form->field($model, 'CEL_ID') ?>

    <?= $form->field($model, 'SEL_ID') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
