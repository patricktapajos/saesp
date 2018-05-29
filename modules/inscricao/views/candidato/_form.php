<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $candidato app\modules\inscricao\candidatos\Candidato */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<div class="candidato-form">

    <?php echo TabsX::widget([
            //'position'=>TabsX::POS_LEFT,
            'encodeLabels'=>false,
            'bordered'=>true,
            'items'=>[
                [
                'label'=>'<i class="glyphicon glyphicon-user"></i> Dados Gerais',
                'content'=>$this->render('_form_partial', [
                    'form'=>$form,
                    'model'=>$model,
                    'candidato'=>$candidato]), 
                'active'=>true,
                ],
                [
                'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Modalidade',
                'content'=>$this->render('_form_modalidade_partial', [
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
</div>

<?php ActiveForm::end(); ?>


