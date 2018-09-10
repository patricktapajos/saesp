<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Selecaomodalidade */

$this->title = $model->SMOD_ID;
$this->params['breadcrumbs'][] = ['label' => 'Selecaomodalidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selecaomodalidade-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->SMOD_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->SMOD_ID], [
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
            'SMOD_ID',
            'SEL_ID',
            'MOD_ID',
        ],
    ]) ?>

</div>
