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
    <!--<img class="text-left" height="50" src="<?php echo $app->request->baseUrl; ?>/images/brasao.png">
    <img class="text-right" height="50" src="<?php echo $app->request->baseUrl; ?>/images/simbolo-logo.png">-->
    <?php
    NavBar::begin([
        'brandLabel' => '<div class="pull-left navbar-logo"></div><span class="navbar-sys-name">'.Yii::$app->name.'</span>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'sys-navbar navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => [
            ['label' => 'Usuário', 'url' => ['/usuario/index'], 'visible'=>Yii::$app->user->can(PermissaoEnum::PERMISSAO_ADMIN)],
            ['label' => 'CEL', 'url' => ['/cel/index'], 'visible'=>Yii::$app->user->can(PermissaoEnum::PERMISSAO_ADMIN)],
            ['label' => 'Cadastros Básicos',
                    'url' => ['#'],
                    'visible'=>Yii::$app->user->can(PermissaoEnum::PERMISSAO_COORDENADOR),
                    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label' => 'Categoria', 'url' => ['/coordenador/categoria/index']],
                        ['label' => 'Modalidade', 'url' => ['/coordenador/modalidade/index']],
                    ],
            ],
            ['label' => 'Seleção', 'url' => ['/selecao/index'], 'visible'=>Yii::$app->user->can(PermissaoEnum::PERMISSAO_ADMIN)],       
            ['label' => 'Seleção', 'url' => ['/coordenador/selecaocel/index'], 'visible'=>Yii::$app->user->can(PermissaoEnum::PERMISSAO_COORDENADOR)],
            ['label' => 'Aluno', 'url' => ['/coordenador/aluno/index'], 'visible'=>Yii::$app->user->can(PermissaoEnum::PERMISSAO_COORDENADOR)],
            ['label' => 'Alterar Senha', 'url' => ['/usuario/alterarsenha'], 'visible'=>!Yii::$app->user->isGuest],            
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
                ),
            ['label' => '<i class="glyphicon glyphicon-user"></i>', 
                    'url' => ['#'],
                    'items' => [
                        '<li class="dropdown-header header-user-info">Informações</li>',
                        '<li class="divider"></li>', 
                        (Yii::$app->user->identity->cel_id != null) ?
                        ['label' =>'<p>Usuário: '.Yii::$app->user->identity->name.'</p><p>CEL: '.Yii::$app->user->identity->cel_nome.'</p>']
                        :
                        ['label' =>'<p>Usuário: '.Yii::$app->user->identity->name.'</p>'],
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
