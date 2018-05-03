<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Modalidade */

$this->title = 'Atualizar Modalidade: #' . $model->MOD_NOME;
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Modalidade', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MOD_ID, 'url' => ['view', 'id' => $model->MOD_ID]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="modalidade-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
