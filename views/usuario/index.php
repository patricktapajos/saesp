<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\SexoEnum;
use app\models\PermissaoEnum;
use app\models\SituacaoEnum;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gerenciar Usuário';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Novo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'USU_NOME',
            'USU_CPF',
            [
                'label'=>'Sexo',
                'attribute'=>'USU_SEXO',
                'format' => 'raw',
                'value' => function ($model) {
                     return  $model->getSexoText();
                },
                'filter'=> Html::dropDownList("UsuarioSearch[USU_SEXO]", $searchModel->USU_SEXO, SexoEnum::listar(), ['class'=>'form-control','prompt'=>'Selecione'])
            ],
            [
                'label'=>'Permissão',
                'attribute'=>'USU_PERMISSAO',
                'format' => 'raw',
                'value' => function ($model) {
                     return  $model->getPermissaoText();
                },
                 'filter'=> Html::dropDownList("UsuarioSearch[USU_PERMISSAO]", $searchModel->USU_PERMISSAO, PermissaoEnum::listar(), ['class'=>'form-control','prompt'=>'Selecione'])
            ],
            [
                'label'=>'Situação',
                'attribute'=>'USU_SITUACAO',
                'format' => 'raw',
                'value' => function ($model) {
                     return  $model->getSituacaoText();
                },
                'filter'=> Html::dropDownList("UsuarioSearch[USU_SITUACAO]", $searchModel->USU_SITUACAO, SituacaoEnum::listar(), ['class'=>'form-control','prompt'=>'Selecione'])
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
