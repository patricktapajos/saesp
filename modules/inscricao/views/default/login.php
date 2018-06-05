<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>
<div class="body-content">
    <div class="row">
        <div class="col-lg-12 text-center">
            <?= Html::img('@web/images/simbolo-logo.png', ['height'=>'200']); ?>
        </div>
    </div>
</div>

 <div class="jumbotron">
    <h2>Bem vindo ao SAESP - Sistema de Atividades Esportivas.</h2>
</div>

<div class="site-login col-lg-offset-3 col-lg-6 col-lg-offset-3">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
    ]); ?>
        <?= $form->field($model, 'username')->widget(\yii\widgets\MaskedInput::className(), [
                'mask'=>'999.999.999-99'
            ]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group text-center">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <?= Html::a('Esqueci a senha', ['usuario/esquecisenha'] ,['class' => 'btn btn-danger', 'name' => 'login-button']) ?>
        </div>
        <div class="form-group text-center">
            <?= Html::a('Realizar Cadastro', ['candidato/create'] ,['class' => 'btn btn-success', 'name' => 'login-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
