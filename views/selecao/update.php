<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Selecao */

$this->title = 'Atualizar Seleção';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Seleção', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="selecao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
