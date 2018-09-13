<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Selecaomodalidade */

$this->title = 'Update Selecaomodalidade: ' . $model->SMOD_ID;
$this->params['breadcrumbs'][] = ['label' => 'Selecaomodalidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SMOD_ID, 'url' => ['view', 'id' => $model->SMOD_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="selecaomodalidade-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
