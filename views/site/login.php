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
     <h2>Olá, <?= Yii::$app->user->identity->name != null?Yii::$app->user->identity->name:'Visitante' ?>!</h2>
    <h3>Bem vindo ao SAESP - Sistema de Atividades Esportivas.</h3>
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

         <?= $form->field($model, 'rememberMe')->checkbox() ?>
         <?= Html::a('Esqueci a senha', ['usuario/esquecisenha'])?>

        <div class="form-group text-center">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>

