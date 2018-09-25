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

             <div class="jumbotron">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                            <a class="icone-index" href="<?php echo Yii::$app->request->baseUrl;?>/inscricao/default/login"><img class="logo-central" src="<?php echo Yii::$app->request->baseUrl;?>/images/inscricao.png" alt=""><p class="alias">Inscrições</p></a>      
                        </div>

                        <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                            <a class="icone-index" href="<?php echo Yii::$app->request->baseUrl;?>/site/login"><img class="logo-central" src="<?php echo Yii::$app->request->baseUrl;?>/images/config.png" alt=""><p class="alias">Sistema</p></a>      
                        </div>
                </div>
            </div>
        <?php else: ?>
            <div class="body-content">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <?= Html::img('@web/images/simbolo-logo.png', ['height'=>'200']); ?>
                        <h1>Olá, <?= Yii::$app->user->identity->name != null?Yii::$app->user->identity->name:'Visitante' ?>!</h1>
                        <h2>Bem vindo ao módulo de Coordenação do CEL - "<?= Yii::$app->user->identity->cel_nome; ?>"</h2>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

