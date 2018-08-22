<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Modalidadedatahora */

$this->title = $model->MDT_ID;
$this->params['breadcrumbs'][] = ['label' => 'Modalidadedatahoras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modalidadedatahora-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Voltar', ['index', 'id' => $model->MDT_ID], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'MDT_ID',
            'MDT_HORARIO_INICIO',
            'MDT_HORARIO_FIM',
            'MDT_QTDE_VAGAS',
            [
                'label'=>'Seleção Modalidade',
                'value' => function ($model) {
                     return $model->sMOD->mODALIDADE->MOD_DESCRICAO;
                }
            ],
            'MDT_QTDE_VAGAS',
            [
                'label'=>'Professor',
                'value' => function ($model) {
                     return $model->pROFESSOR->usuario->USU_NOME;
                }
            ],
        ],
    ]) ?>

</div>
