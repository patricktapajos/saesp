<?php
    use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'SAESP';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12 text-center">
                <?= Html::img('@web/images/simbolo-logo.png', ['height'=>'200']); ?>
            </div>
        </div>
    </div>

     <div class="jumbotron">
        <h1>Olá, <?= Yii::$app->user->identity->name != null?Yii::$app->user->identity->name:'Visitante' ?>!</h1>

        <p class="lead">Bem vindo ao SAESP - Sistema de Atividades Esportivas.</p>
    </div>
</div>
