<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\coordenador\models\SelecaoCel */

$this->title = 'Update Selecao Cel: ' . $model->SCEL_ID;
$this->params['breadcrumbs'][] = ['label' => 'Selecao Cels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SCEL_ID, 'url' => ['view', 'id' => $model->SCEL_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="selecao-cel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
