<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Selecaomodalidade */

$this->title = 'Create Selecaomodalidade';
$this->params['breadcrumbs'][] = ['label' => 'Selecaomodalidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selecaomodalidade-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
