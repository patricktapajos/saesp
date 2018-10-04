<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Modalidade */

$this->title = 'Atualizar Modalidade: #' . $model->MOD_NOME;
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Modalidade', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Atualizar Modalidade';
?>
<div class="modalidade-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
