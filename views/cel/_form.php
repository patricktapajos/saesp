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
            <?= $form->field($model, 'cel_nome')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($model, 'cel_email')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-4 col-sm-12">
            <?= $form->field($model, 'cel_telefone')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-4 col-sm-12">
            <?= $form->field($model, 'cel_latitude')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-4 col-sm-12">
            <?= $form->field($model, 'cel_longitude')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'cel_cep')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-3 col-sm-12">

            <?= $form->field($model, 'cel_logradouro')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'cel_bairro')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'cel_complemento_end')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-4 col-sm-12">
            <?= $form->field($model, 'crd_id')->dropDownList(ArrayHelper::map(Coordenador::find()->all(), 'crd_id','crd_nome'),['prompt'=>'Selecione >>']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
