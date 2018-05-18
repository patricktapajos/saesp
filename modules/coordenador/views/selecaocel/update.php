<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\coordenador\models\SelecaoCel */

$this->title = 'Atualizar CEL/Seleção';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar CEL/Seleção', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SCEL_ID, 'url' => ['view', 'id' => $model->SCEL_ID]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="selecao-cel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
