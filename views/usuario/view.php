<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Visualizar Usuário';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Usuário', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->USU_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->USU_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja excluir este usuário?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'USU_NOME',
            'USU_CPF',
            'USU_EMAIL',
            'USU_DT_NASC',
             [
                'label'=>'Sexo',
                'attribute'=>'USU_SEXO',
                'format' => 'raw',
                'value' => function ($model) {
                     return  $model->getSexoText();
                }
            ],
            [
                'label'=>'Permissão',
                'attribute'=>'USU_PERMISSAO',
                'format' => 'raw',
                'value' => function ($model) {
                     return  $model->getPermissaoText();
                }
            ],
            [
                'label'=>'Situação',
                'attribute'=>'USU_SITUACAO',
                'format' => 'raw',
                'value' => function ($model) {
                     return  $model->getSituacaoText();
                }
            ],
            'USU_TELEFONE_1',
            'USU_TELEFONE_2',
            [
                'label'=>'Foto',
                'attribute'=>'USU_URL_FOTO',
                'value' => function ($model) {
                    return  $model->getUrlFoto();
               },
                'format' => ['image'],
            ]
        ],
    ]) ?>
</div>
