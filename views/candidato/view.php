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
        <?= Html::a('Imprimir', ['imprimir', 'id' => $model->CAND_ID], ['class' => 'btn btn-warning','target'=>'_blank']) ?>
        <?= Html::a('Sair', ['default/login'], ['class' => 'btn btn-danger']) ?>
    </p>

    <br>
    <div class="col-lg-3 col-sm-12 text-center">
        <img src="<?php echo $model->getUrlFoto();?>" width="160" height="150">
    </div>
    <div class="col-lg-9 col-sm-12">
     <?= DetailView::widget([
            'model' => $model,
            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '-'],
            'attributes' => [
               'inscricao.INS_NUM_INSCRICAO',
               'usuario.USU_NOME',
                'usuario.USU_CPF',
                'usuario.USU_EMAIL',
                'usuario.USU_DT_NASC',
           
            ],
        ]) ?>
    </div>
    <div class="col-lg-12 col-sm-12">
        <?= DetailView::widget([
            'model' => $model,
            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '-'],
            'attributes' => [
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
                [
                    'label'=>'Estado Civil',
                    'attribute'=>'CAND_ESTADO_CIVIL',
                    'format' => 'raw',
                    'value' => function ($model) {
                         return  $model->getEstadoCivilText();
                    }
                ],
                'CAND_LOGRADOURO',
                'CAND_COMPLEMENTO_END',
                'CAND_CEP',
                'CAND_BAIRRO',
                'CAND_NOME_EMERGENCIA',
                'CAND_TEL_EMERGENCIA',
                'CAND_NOME_RESPONSAVEL',
                [
                    'label'=>'PcD (Pessoa Com Deficiência)',
                    'attribute'=>'CAND_PCD',
                    'format' => 'raw',
                    'value' => function ($model) {
                         return  $model->getSimNaoText('CAND_PCD');
                    }
                ],
                'CAND_PCD_DESC',
                [
                    'label'=>'Possui alguma comorbidade?',
                    'attribute'=>'CAND_TEM_COMORBIDADE',
                    'format' => 'raw',
                    'value' => function ($model) {
                         return  $model->getSimNaoText('CAND_TEM_COMORBIDADE');
                    }
                ],
                'CAND_COMORBIDADE_DESC',
                [
                    'label'=>'ingere algum medicamento',
                    'attribute'=>'CAND_TEM_MEDICACAO',
                    'format' => 'raw',
                    'value' => function ($model) {
                         return  $model->getSimNaoText('CAND_TEM_MEDICACAO');
                    }
                ],
                'CAND_MEDICACAO_DESC',
                'CAND_OBSERVACOES',
            ],
        ]) ?>
    </div>
</div>