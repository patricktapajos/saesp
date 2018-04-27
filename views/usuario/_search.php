<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'usu_id') ?>

    <?= $form->field($model, 'usu_nome') ?>

    <?= $form->field($model, 'usu_cpf') ?>

    <?= $form->field($model, 'usu_email') ?>

    <?= $form->field($model, 'usu_dt_nasc') ?>

    <?php // echo $form->field($model, 'usu_sexo') ?>

    <?php // echo $form->field($model, 'usu_telefone_1') ?>

    <?php // echo $form->field($model, 'usu_telefone_2') ?>

    <?php // echo $form->field($model, 'usu_senha') ?>

    <?php // echo $form->field($model, 'usu_situacao') ?>

    <?php // echo $form->field($model, 'usu_permissao') ?>

    <?php // echo $form->field($model, 'USU_ID') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
