<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Coordenador;

/* @var $this yii\web\View */
/* @var $model app\models\Cel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cel-form">

    <?php $form = ActiveForm::begin(); ?>

     <div class="row">
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($model, 'CEL_NOME')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($model, 'CEL_EMAIL')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-4 col-sm-12">
            <?= $form->field($model, 'CEL_TELEFONE')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-4 col-sm-12">
            <?= $form->field($model, 'CEL_LATITUDE')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-4 col-sm-12">
            <?= $form->field($model, 'CEL_LONGITUDE')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'CEL_CEP')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-3 col-sm-12">

            <?= $form->field($model, 'CEL_LOGRADOURO')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'CEL_BAIRRO')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'CEL_COMPLEMENTO_END')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-4 col-sm-12">
            <?= $form->field($model, 'CRD_ID')->dropDownList(ArrayHelper::map(Coordenador::find()->with('usuario')->all(), 'CRD_ID','usuario.USU_NOME'),['prompt'=>'Selecione >>']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
