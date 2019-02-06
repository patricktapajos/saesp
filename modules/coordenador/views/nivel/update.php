<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\coordenador\models\Nivel */

$this->title = 'Atualizar Nivel';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Nível', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="nivel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
