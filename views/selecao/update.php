<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Selecao */

$this->title = 'Atualizar Seleção: #' . $model->SEL_DESCRICAO;
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Seleção', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SEL_ID, 'url' => ['view', 'id' => $model->SEL_ID]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="selecao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
