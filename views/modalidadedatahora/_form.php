<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Modalidadedatahora */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modalidadedatahora-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MDT_STATUS')->dropdownList(['ATIVO' => 'Ativo', 'INATIVO' => 'Inativo', 'VAGARESTANTE' => 'Vagas Restantes'], ['prompt' => '---Selecionae o Status---']) ?>


    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
