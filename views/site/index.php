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
                <h1>Olá, <?= Yii::$app->user->identity->name != null?Yii::$app->user->identity->name:'Visitante' ?>!</h1>

                <h2>Bem vindo ao SAESP - Sistema de Atividades Esportivas</h2>
            </div>
        </div>
    </div>
    <?php if(Yii::$app->user->isGuest): ?>
         <div class="jumbotron">
            <div class="row">
                <div class="col-xs-6 col-md-6 col-lg-6 text-center wow pulse" data-wow-duration="0.5s" data-wow-delay="0.2s" style="visibility: visible; animation-duration: 0.5s; animation-delay: 0.2s; animation-name: pulse;">
                        <a class="icone-index" href="<?php echo Yii::$app->request->baseUrl;?>/inscricao/default/login"><img src="<?php echo Yii::$app->request->baseUrl;?>/images/inscricao.png" alt=""><p class="alias">Inscrições</p></a>      
                    </div>

                    <div class="ccol-xs-6 col-md-6 col-lg-6  text-center wow pulse" data-wow-duration="0.5s" data-wow-delay="0.2s" style="visibility: visible; animation-duration: 0.5s; animation-delay: 0.2s; animation-name: pulse;">
                        <a class="icone-index" href="<?php echo Yii::$app->request->baseUrl;?>/site/login"><img src="<?php echo Yii::$app->request->baseUrl;?>/images/config.png" alt=""><p class="alias">Sistema</p></a>      
                    </div>
            </div>
        </div>
    <?php endif; ?>
</div>

