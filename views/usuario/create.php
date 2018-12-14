<?php

use yii\helpers\Html;
use app\assets\UsuarioAsset;
UsuarioAsset::register($this);


/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Cadastrar Usuário';
$this->params['breadcrumbs'][] = ['label' => 'Usuário', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
