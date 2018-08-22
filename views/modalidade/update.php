<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Modalidade */

$this->title = 'Alterar Modalidade: ' . $model->MOD_ID;
$this->params['breadcrumbs'][] = ['label' => 'Modalidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MOD_ID, 'url' => ['view', 'id' => $model->MOD_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="modalidade-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
