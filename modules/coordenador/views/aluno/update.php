<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\aluno\models\Aluno */

$this->title = 'Atualizar Aluno';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Aluno', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Atualizar Aluno'];
?>
<div class="aluno-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
