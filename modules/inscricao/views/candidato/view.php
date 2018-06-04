<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\inscricao\models\Candidato */

$this->title = 'Visualização de Dados do Inscrito';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidato-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!--<?= Html::a('Atualizar', ['update', 'id' => $model->CAND_ID], ['class' => 'btn btn-primary']) ?>-->
        <?= Html::a('Imprimir', ['imprimir', 'id' => $model->CAND_ID], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Sair', ['default/login'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'inscricao.INS_NUM_INSCRICAO',
        ],
    ]) ?>

    <!--<div class="col-lg-6 col-sm-12">-->
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
               'usuario.USU_NOME',
                'usuario.USU_CPF',
                'usuario.USU_EMAIL',
                'usuario.USU_DT_NASC',
                 [
                    'label'=>'Sexo',
                    'attribute'=>'USU_SEXO',
                    'format' => 'raw',
                    'value' => function ($model) {
                         return  $model->usuario->getSexoText();
                    }
                ],
                'usuario.USU_TELEFONE_1',
                'usuario.USU_TELEFONE_2',
            ],
        ]) ?>
    <!--</div>

    <div class="col-lg-6 col-sm-12">-->
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'CAND_ESTADO_CIVIL',
                'CAND_LOGRADOURO',
                'CAND_COMPLEMENTO_END',
                'CAND_CEP',
                'CAND_BAIRRO',
                'CAND_NOME_EMERGENCIA',
                'CAND_TEL_EMERGENCIA',
                'CAND_NOME_RESPONSAVEL',
                'CAND_TEM_COMORBIDADE',
                'CAND_COMORBIDADE_DESC',
                'CAND_TEM_MEDICACAO',
                'CAND_MEDICACAO_DESC',
                'CAND_OBSERVACOES',
            ],
        ]) ?>
    <!--</div>-->

</div>
