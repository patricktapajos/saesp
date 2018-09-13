<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Inscricaomodalidade */

$this->title = $model->IMO_ID;
$this->params['breadcrumbs'][] = ['label' => 'Inscrição Modalidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inscricaomodalidade-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Voltar', ['index', 'id' => $model->IMO_ID], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'IMO_ID',
            [
                'label'=>'Inscrição',
                'value' => function ($model) {
                     return $model->iNS->INS_NUM_INSCRICAO;
                }
            ],
            [
              'label'=>'Candidato',
              'value' => function ($model) {
                   return $model->iNS->cANDIDATO->uSU->USU_NOME;
              }
            ]
        ],
    ]) ?>

</div>
