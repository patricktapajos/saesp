<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Modalidadedatahora */

$this->title = 'Alterar Modalidade data hora: ' . $model->MDT_ID;
$this->params['breadcrumbs'][] = ['label' => 'Modalidadedatahoras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MDT_ID, 'url' => ['view', 'id' => $model->MDT_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="modalidadedatahora-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
