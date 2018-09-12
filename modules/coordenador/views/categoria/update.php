<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Categoria */

$this->title = 'Alterar Categoria: #' . $model->CAT_ID;
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Categoria', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CAT_ID, 'url' => ['view', 'id' => $model->CAT_ID]];
?>
<div class="categoria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
