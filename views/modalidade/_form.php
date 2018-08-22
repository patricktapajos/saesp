<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Modalidade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modalidade-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MOD_NOME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MOD_DESCRICAO')->textInput(['maxlength' => true]) ?>

    <?=
      $form->field($model, 'CAT_ID')->dropDownList($listData=ArrayHelper::map($categorias = \app\models\Categoria::find()->all(),'CAT_ID','CAT_DESCRICAO'),['prompt'=>'Selecione a Categoria'])
    ?>
    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
