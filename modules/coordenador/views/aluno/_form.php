<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\SituacaoEnum;

/* @var $this yii\web\View */
/* @var $model app\modules\aluno\models\Aluno */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aluno-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php /*echo $this->render('@app/modules/inscricao/views/candidato/_form_dados_pessoais', [
                'form'=>$form,
                'model'=>$model,
                'candidato'=>$candidato
            ]);*/ ?>

    <div class="form-group">
        <?= $form->field($aluno, 'ALU_SITUACAO')->dropDownList(SituacaoEnum::listar(), ['prompt'=>'Selecione >>']) ?>
    </div>
    <div class="form-group">
        <?= $form->field($aluno, 'justificativa')->textArea() ?>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton($aluno->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $aluno->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
