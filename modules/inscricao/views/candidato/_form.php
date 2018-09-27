<?php

use yii\helpers\Html;
use yii\helpers\BaseHtml;
use yii\widgets\ActiveForm;
use kartik\tabs\TabsX;
use app\assets\InscricaoAsset;
InscricaoAsset::register($this);

/* @var $this yii\web\View */
/* @var $candidato app\modules\inscricao\candidatos\Candidato */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
        'id'=>'candidato-form',
        //'enableAjaxValidation' => true,
        //'enableClientValidation'=>false, 
        'options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="candidato-form">
    <div class="alert-danger">
        <?= $form->errorSummary([$model,$candidato,$documento]); ?>
    </div>

    <?php echo TabsX::widget([
            //'position'=>TabsX::POS_LEFT,
            'encodeLabels'=>false,
            'bordered'=>true,
            'items'=>[
                [
                'label'=>'<i class="glyphicon glyphicon-user"></i> Dados Gerais',
                'content'=>$this->render('_form_dados_pessoais', [
                    'form'=>$form,
                    'model'=>$model,
                    'candidato'=>$candidato
                ]), 
                'active'=>true,
                ],
                [
                'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Documentação',
                'content'=>$this->render('_form_documentacao_partial', [
                    'form'=>$form,
                    'documento'=>$documento,
                    'candidato'=>$candidato
                    ]), 
                'active'=>false,
                ],
                [
                'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Modalidade',
                'content'=>$this->render('_form_modalidade_partial', [
                    'form'=>$form,
                    'smods'=>$smods,
                    'candidato'=>$candidato
                    ]), 
                'active'=>false,
                ]
            ]
    ]); ?>

    
</div>
<br>
<div class="form-group">
    <?= Html::submitButton($candidato->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $candidato->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php if(!$candidato->isNewRecord): ?>
        <?= Html::a('Visualizar', ['view', 'id' => $candidato->CAND_ID], ['class' => 'btn btn-success']) ?>
    <?php  endif; ?>
    <?= Html::a('Cancelar', ['/inscricao/default'] ,['class' => 'btn btn-danger']) ?>
</div>

<?php ActiveForm::end(); ?>


