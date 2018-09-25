<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\aluno\models\Aluno */

$this->title = 'Update Aluno: ' . $model->ALU_ID;
$this->params['breadcrumbs'][] = ['label' => 'Alunos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ALU_ID, 'url' => ['view', 'id' => $model->ALU_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aluno-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
