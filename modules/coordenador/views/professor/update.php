<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Professor */

$this->title = 'Atualizar Professor: #' . $model->USU_NOME;
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Professor', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->professor->PROF_ID, 'url' => ['view', 'id' => $model->professor->PROF_ID]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="professor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
