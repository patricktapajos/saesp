<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\coordenador\models\SelecaoCel */

$this->title = $model->SCEL_ID;
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Seleção/CEL', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selecao-cel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->SCEL_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->SCEL_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'CEL_ID',
            'SEL_ID',
        ],
    ]) ?>

</div>
