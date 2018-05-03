<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Selecao */

$this->title = 'Cadastrar Seleção';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Seleção', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selecao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
