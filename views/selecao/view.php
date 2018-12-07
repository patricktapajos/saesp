<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Selecao */

$this->title = 'Visualizar Seleção #'.$model->SEL_ID;
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Seleção', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selecao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->SEL_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->SEL_ID], [
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
            'SEL_TITULO',
            'SEL_DESCRICAO',
            'SEL_DT_INICIO_CAD',
            'SEL_DT_FIM_CAD',
            'SEL_DT_INICIO',
            'SEL_DT_FIM',
            'SEL_DT_VR_INICIO',
            'SEL_DT_VR_FIM',
            [
                'label'=>'Situação',
                'attribute'=>'SEL_SITUACAO',
                'format' => 'raw',
                'value' => function ($model) {
                     return  $model->getSituacaoText();
                },
            ],
        ],
    ]) ?>
</div>
