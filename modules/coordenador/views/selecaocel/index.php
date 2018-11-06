<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\modules\coordenador\models\SelecaoCel;
use app\modules\inscricao\models\InscricaoModalidade;
use app\models\SituacaoSelecaoEnum;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\coordenador\models\SelecaoCelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Gerenciar Seleção Associada';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selecao-cel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Associar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
             [
                'label'=>'Seleção',
                'attribute'=>'SEL_ID',
                'format' => 'raw',
                'value' => function ($model) {
                    if($model->selecao){
                        return $model->selecao->SEL_TITULO;
                    }
                },
                'filter'=> Html::dropDownList("SelecaoCelSearch[SEL_ID]", $searchModel->SEL_ID, SelecaoCel::listar(), ['class'=>'form-control','prompt'=>'Selecione'])
            ],
            [
                'label'=>'Situação',
                'attribute'=>'SEL_SITUACAO',
                'format' => 'raw',
                'value' => function ($model) {
                    if($model->selecao){
                        return $model->selecao->getSituacaoText();
                    }
                },
                'filter'=> Html::dropDownList("SelecaoCelSearch[SEL_SITUACAO]", $searchModel->SEL_SITUACAO, SituacaoSelecaoEnum::listar(), ['class'=>'form-control','prompt'=>'Selecione'])
            ],
            ['class' => 'yii\grid\ActionColumn',
             'header'=>'Ações',
             'options'=>['width'=>'70px'],
             'template' => '{update} {gerenciarparecer}{view}',
             'buttons'  => [
               'gerenciarparecer'=> function ($url, $model) {
                    $url = Url::to('gerenciarparecer');
                    return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', $url, ['title'=>'Gerenciar Parecer']);
               }
            ],
            'visibleButtons' => [
                'update' => function ($model) {
                    if($model->selecao){
                        return $model->selecao->isCadastrado();
                    }
                },
                'gerenciarparecer' => function ($model) {
                    if($model->selecao){
                        return $model->selecao->isParecer();
                    }
                },
            ]
            ],
        ],
    ]); ?>
</div>
