<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cel */

$this->title = 'Atualizar CEL';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar CEL', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="cel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
