<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cel */

$this->title = 'Cadastrar CEL';
$this->params['breadcrumbs'][] = ['label' => 'Cels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
