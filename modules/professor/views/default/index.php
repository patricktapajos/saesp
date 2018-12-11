<?php
    use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'SAESP';
?>
<div class="site-index">
    <div class="vertical-center">
        <?php if(Yii::$app->user->isGuest): ?>
             <div class="body-content">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <?= Html::img('@web/images/simbolo-logo.png', ['class'=>'logo-central']); ?>
                        <h1>Bem vindo ao SAESP - Sistema de Atividades Esportivas</h1>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="body-content">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <?= Html::img('@web/images/simbolo-logo.png', ['class'=>'logo-central']); ?>
                        <h1>Olá, professor(a) <?= Yii::$app->user->identity->name != null?Yii::$app->user->identity->name:'Visitante' ?>!</h1>
                        <h2>Bem vindo ao SAESP</h2>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

