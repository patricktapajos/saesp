<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Modalidade */

$this->title = 'Visualizar Modalidade';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Modalidade', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modalidade-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->MOD_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->MOD_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Deseja exluir este registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'MOD_NOME',
            'MOD_DESCRICAO',
            [
                'label'=>'CEL',
                'value' => function ($model) {
                     return  $model->cel->CEL_NOME;
                }
            ],
            [
                'label'=>'Ícone',
                'attribute'=>'MOD_URL_FOTO',
                'value' => function ($model) {
                    return  $model->getUrlFoto();
               },
                'format' => ['image'],
            ]
        ],
    ]) ?>

</div>
