<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cel */

$this->title = 'Update Cel: ' . $model->CEL_ID;
$this->params['breadcrumbs'][] = ['label' => 'Cels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CEL_ID, 'url' => ['view', 'id' => $model->CEL_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
