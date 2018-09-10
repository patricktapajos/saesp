<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Inscricaomodalidade */

$this->title = 'Alterar Inscrição modalidade: ' . $model->iNS->INS_NUM_INSCRICAO;
$this->params['breadcrumbs'][] = ['label' => 'Inscricaomodalidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IMO_ID, 'url' => ['view', 'id' => $model->IMO_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="inscricaomodalidade-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
