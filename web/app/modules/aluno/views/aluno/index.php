<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\aluno\models\AlunoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alunos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Aluno', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ALU_ESTADO_CIVIL',
            'ALU_CPF',
            'ALU_LOGRADOURO',
            'ALU_COMPLEMENTO_END',
            'ALU_CEP',
            // 'ALU_BAIRRO',
            // 'CAND_ID',
            // 'ALU_NOME_EMERGENCIA',
            // 'ALU_TEL_EMERGENCIA',
            // 'ALU_NOME_RESPONSAVEL',
            // 'ALU_TEM_COMORBIDADE',
            // 'ALU_COMORBIDADE_DESC',
            // 'ALU_TEM_MEDICACAO',
            // 'ALU_MEDICACAO_DESC',
            // 'ALU_OBSERVACOES',
            // 'ALU_ID',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
