<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\PermissaoEnum;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => '<div class="pull-left navbar-logo"></div><span class="navbar-sys-name"></span>',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'sys-navbar navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'encodeLabels' => false,
            'items' => [
                ['label' => 'Início', 'url' => ['default/index']],
                ['label' => 'Alterar Senha', 'url' => ['candidato/alterarsenha'], 'visible'=>!Yii::$app->user->isGuest],
                ['label' => 'Alterar Dados', 'url' => ['candidato/update?id='.Yii::$app->user->identity->id], 'visible'=>!Yii::$app->user->isGuest],
                Yii::$app->user->isGuest ? (
                    ['label' => 'Login', 'url' => ['default/login']]
                ) : '',
                ['label' => '<i class="glyphicon glyphicon-user"></i>',             
                    'url' => ['#'],
                    'items' => [
                        '<li class="dropdown-header header-user-info">Informações</li>',
                        '<li class="divider"></li>', 
                        ['label' =>'<p>Usuário: '.Yii::$app->user->identity->name.'</p>'],
                        '<li class="divider"></li>',                     
                        ['label' =>'Sair', 'url'=>['default/logout']],                        
                    ],
                    'visible'=>!Yii::$app->user->isGuest
                ]
            ],
        ]);
        NavBar::end();
        ?>
        
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; SUBTI <?= date('Y') ?></p>

            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
