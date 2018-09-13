<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\modules\coordenador\models\SelecaoCel;
use app\modules\inscricao\models\InscricaoModalidade;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\coordenador\models\SelecaoCelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selecao-cel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Novo', ['create'], ['class' => 'btn btn-success']) ?>
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
                     return $model->selecao->SEL_DESCRICAO;
                },
                'filter'=> Html::dropDownList("SelecaoCelSearch[SEL_ID]", $searchModel->SEL_ID, SelecaoCel::listar(), ['class'=>'form-control','prompt'=>'Selecione'])
            ],
            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view} {update} {delete} {parecer}',
             'buttons'  => [
               'parecer'   => function ($url, $model) {
                $url ='../selecaocel/parecer?celid='.$model->CEL_ID.'&selid='.$model->SEL_ID;
                return Html::a('<span class="fa fa-search"></span>', $url,
                              ['class'=>'glyphicon glyphicon-search']);
               }
             ]
            ],
        ],
    ]); ?>
</div>
