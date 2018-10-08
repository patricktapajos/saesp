<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Atualizar Usuário';
$this->params['breadcrumbs'][] = ['label' => 'Gerenicar Usuário', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="usuario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
