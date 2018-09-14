<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\modules\coordenador\models\SelecaoCel;
use app\modules\inscricao\models\InscricaoModalidade;
use app\modules\inscricao\models\Inscricao;
use app\modules\inscricao\models\InscricaoDocumento;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InscricaomodalidadeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gerenciar Parecer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="selecao-cel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'ID',
            'INSCRICAO',
            'NOME',
            'CPF',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{parecer}',
             'buttons'  => [
               'parecer'   => function ($url, $model) {
                $url ='../selecaocel/parecer?insid='.$model['ID'];
                return Html::a('<span class="fa fa-search"></span>', $url,
                              ['class'=>'glyphicon glyphicon-search']);
               }
             ]
            ],

        ],
    ]); ?>
</div>
