<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\inscricao\models\CandidatoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Candidatos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidato-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Candidato', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'CAND_ESTADO_CIVIL',
            'CAND_CPF',
            'CAND_LOGRADOURO',
            'CAND_COMPLEMENTO_END',
            'CAND_CEP',
            // 'CAND_BAIRRO',
            // 'CAND_ID',
            // 'USU_ID',
            // 'CAND_NOME_EMERGENCIA',
            // 'CAND_TEL_EMERGENCIA',
            // 'CAND_NOME_RESPONSAVEL',
            // 'CAND_TEM_COMORBIDADE',
            // 'CAND_COMORBIDADE_DESC',
            // 'CAND_TEM_MEDICACAO',
            // 'CAND_MEDICACAO_DESC',
            // 'CAND_OBSERVACOES',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
