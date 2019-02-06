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
use yii\helpers\Url;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
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
                        ['label' => 'Usuário', 'url' => ['/usuario/index'], 'visible'=>Yii::$app->user->can(PermissaoEnum::PERMISSAO_ADMIN)],
                        ['label' => 'Cadastros Básicos',
                                'url' => ['#'],
                                'visible'=>Yii::$app->user->can(PermissaoEnum::PERMISSAO_COORDENADOR) || Yii::$app->user->can(PermissaoEnum::PERMISSAO_ADMIN),
                                'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                                'items' => [
                                    ['label' => 'Nível', 'url' => ['/coordenador/nivel/index'],'visible'=>Yii::$app->user->can(PermissaoEnum::PERMISSAO_ADMIN)],
                                    ['label' => 'Categoria', 'url' => ['/coordenador/categoria/index']],
                                    ['label' => 'Modalidade', 'url' => ['/coordenador/modalidade/index']],
                                ],
                        ],
                        ['label' => 'CEL', 'url' => ['/cel/index'], 'visible'=>Yii::$app->user->can(PermissaoEnum::PERMISSAO_ADMIN)],
                        ['label' => 'Seleção', 'url' => ['/selecao/index'], 'visible'=>Yii::$app->user->can(PermissaoEnum::PERMISSAO_ADMIN)],       
                        ['label' => 'Seleção', 'url' => ['/coordenador/selecaocel/index'], 'visible'=>Yii::$app->user->can(PermissaoEnum::PERMISSAO_COORDENADOR)],
                        ['label' => 'Aluno', 'url' => ['/coordenador/aluno/index'], 'visible'=>Yii::$app->user->can(PermissaoEnum::PERMISSAO_COORDENADOR)],
                        ['label' => 'Horário', 'url' => ['/professor/default/visualizarhorario'], 'visible'=>Yii::$app->user->can(PermissaoEnum::PERMISSAO_PROFESSOR)],
                        ['label' => 'Alterar Senha', 'url' => ['/usuario/alterarsenha'], 'visible'=>!Yii::$app->user->isGuest],            
                        Yii::$app->user->isGuest ? (
                            ['label' => 'Login', 'url' => ['/site/login']]
                        ) : '',
                        ['label' => '<i class="glyphicon glyphicon-user"></i>', 
                                'url' => ['#'],
                                'items' => [
                                    '<li class="dropdown-header header-user-info">Informações</li>',
                                    '<li class="divider"></li>', 
                                    (Yii::$app->user->identity->cel_id != null) ?
                                    ['label' =>'<p>Usuário: '.Yii::$app->user->identity->name.'</p><p>CEL: '.Yii::$app->user->identity->cel_nome.'</p>']
                                    :
                                    ['label' =>'<p>Usuário: '.Yii::$app->user->identity->name.'</p>'],
                                    ['label' =>'<p>Permissão: '.Yii::$app->user->identity->rule.'</p>'],
                                    '<li class="divider"></li>',                         
                                    ['label' =>'Sair', 'url'=>['/site/logout']],
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

            <p class="pull-left">&copy; SUBTI & SEMJEL - Secretaria Municipal de Esporte e Lazer</p>

            <p class="pull-right powered"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
