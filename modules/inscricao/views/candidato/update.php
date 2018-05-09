<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\inscricao\models\Candidato */

$this->title = 'Update Candidato: ' . $model->CAND_ID;
$this->params['breadcrumbs'][] = ['label' => 'Candidatos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CAND_ID, 'url' => ['view', 'id' => $model->CAND_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="candidato-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
