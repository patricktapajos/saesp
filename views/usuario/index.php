<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
            'usu_nome',
            'usu_cpf',
            'usu_email:email',
            [
                'label'=>'Sexo',
                'attribute'=>'usu_sexo',
                'format' => 'raw',
                'value' => function ($model) {
                     return  $model->getSexoText();
                }
            ],
            [
                'label'=>'Permissão',
                'attribute'=>'usu_permissao',
                'format' => 'raw',
                'value' => function ($model) {
                     return  $model->getPermissaoText();
                }
            ],
            [
                'label'=>'Situação',
                'attribute'=>'usu_situacao',
                'format' => 'raw',
                'value' => function ($model) {
                     return  $model->getSituacaoText();
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
