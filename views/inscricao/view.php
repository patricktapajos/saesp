<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Inscricao */

$this->title = $model->INS_ID;
$this->params['breadcrumbs'][] = ['label' => 'Inscricaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inscricao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->INS_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->INS_ID], [
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
            'CAND_ID',
            'INS_ID',
            'INS_PCD',
            'INS_SITUACAO',
            'INS_DT_CADASTRO',
            'SEL_ID',
            'INS_NUM_INSCRICAO',
        ],
    ]) ?>

</div>
