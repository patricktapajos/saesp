<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\modules\coordenador\models\SelecaoCel;
use app\modules\inscricao\models\InscricaoModalidade;


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
                     return $model->selecao->SEL_DESCRICAO;
                },
                'filter'=> Html::dropDownList("SelecaoCelSearch[SEL_ID]", $searchModel->SEL_ID, SelecaoCel::listar(), ['class'=>'form-control','prompt'=>'Selecione'])
            ],
            ['class' => 'yii\grid\ActionColumn',
             'template' => '{update} {gerenciarparecer}',
             'buttons'  => [
               'gerenciarparecer'=> function ($url, $model) {
                    $url = Url::to('gerenciarparecer');
                    return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', $url, ['title'=>'Gerenciar Parecer']);
               }
            ],
            'visibleButtons' => [
                'update' => function ($model) {
                    return $model->selecao->isCadastrado();
                },
                'gerenciarparecer' => function ($model) {
                    return $model->selecao->isParecer();
                },
            ]
            ],
        ],
    ]); ?>
</div>
