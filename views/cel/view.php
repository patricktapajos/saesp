<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cel */

$this->title = 'Visualizar CEL';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar CEL', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->CEL_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->CEL_ID], [
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
            'CEL_NOME',
            'CEL_EMAIL',
            'CEL_TELEFONE',
            'CEL_LATITUDE',
            'CEL_LONGITUDE',
            'CEL_LOGRADOURO',
            'CEL_CEP',
            'CEL_BAIRRO',
            'CEL_COMPLEMENTO_END',
            [
                'label'=>'Coordenador',
                'value' => function ($model) {
                     return $model->coordenador->usuario->USU_NOME;
                }
            ],
        ],
    ]) ?>

</div>
