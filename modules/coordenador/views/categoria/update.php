<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Categoria */

$this->title = 'Atualizar Categoria';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Categoria', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Atualizar Categoria', 'url' => ['view', 'id' => $model->CAT_ID]];
?>
<div class="categoria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
