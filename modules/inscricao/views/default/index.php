<?php
    use yii\helpers\Html;
?>

<div class="body-content">
    <div class="row">
        <div class="col-lg-12 text-center">
            <?= Html::img('@web/images/simbolo-logo.png', ['height'=>'200']); ?>
            <h1>Olá, <?= Yii::$app->user->identity->name != null?Yii::$app->user->identity->name:'Visitante' ?>!</h1>
            <h2>Bem vindo ao SAESP - Sistema de Atividades Esportivas</h2>
        </div>
    </div>
</div>