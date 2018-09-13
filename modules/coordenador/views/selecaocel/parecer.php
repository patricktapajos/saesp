<?php

use yii\helpers\Html;
use yii\grid\GridView;
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

            'USU_NOME',
            'USU_NOME',
            'USU_CPF',
            'INS_NUM_INSCRICAO',
            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view} {update}'
            ],
        ],
    ]); ?>
</div>
