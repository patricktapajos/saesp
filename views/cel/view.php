<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cel */

$this->title = $model->CEL_ID;
$this->params['breadcrumbs'][] = ['label' => 'Cels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->CEL_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->CEL_ID], [
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
            'cel_nome',
            'cel_email:email',
            'cel_telefone',
            'cel_latitude',
            'cel_longitude',
            'cel_logradouro',
            'cel_cep',
            'cel_bairro',
            'cel_complemento_end',
            'cel_id',
            'crd_id',
            '',
        ],
    ]) ?>

</div>
