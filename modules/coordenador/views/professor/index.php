<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\SexoEnum;
use app\models\PermissaoEnum;
use app\models\SituacaoEnum;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProfessorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gerenciar Professor';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="professor-index">

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
            'usuario.USU_NOME',
            'usuario.USU_CPF',
            [
                'label'=>'Sexo',
                'attribute'=>'usuario.USU_SEXO',
                'format' => 'raw',
                'value' => function ($model) {
                     return  ($model->usuario!=null)?$model->usuario->getSexoText():'';
                },
                'filter'=> Html::dropDownList("UsuarioSearch[USU_SEXO]", $model->usuario->USU_SEXO, SexoEnum::listar(), ['class'=>'form-control','prompt'=>'Selecione'])
            ],
            [
                'label'=>'Situação',
                'attribute'=>'usuario.USU_SITUACAO',
                'format' => 'raw',
                'value' => function ($model) {
                     return  ($model->usuario!=null)?$model->usuario->getSituacaoText():'';
                },
                'filter'=> Html::dropDownList("UsuarioSearch[USU_SITUACAO]", $model->usuario->USU_SITUACAO, SituacaoEnum::listar(), ['class'=>'form-control','prompt'=>'Selecione'])
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
