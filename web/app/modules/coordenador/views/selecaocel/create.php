<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\coordenador\models\SelecaoCel */

$this->title = 'Create Selecao Cel';
$this->params['breadcrumbs'][] = ['label' => 'Selecao Cels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selecao-cel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
