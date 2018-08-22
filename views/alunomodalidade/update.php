<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AlunoModalidade */

$this->title = 'Update Aluno Modalidade: ' . $model->AMO_ID;
$this->params['breadcrumbs'][] = ['label' => 'Aluno Modalidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->AMO_ID, 'url' => ['view', 'id' => $model->AMO_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aluno-modalidade-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
