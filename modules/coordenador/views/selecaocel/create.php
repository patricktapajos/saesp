<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\coordenador\models\SelecaoCel */

$this->title = 'Associar CEL/Seleção';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar CEL/Seleção', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selecao-cel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
