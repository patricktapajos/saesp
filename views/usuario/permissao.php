<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\PermissaoEnum;
use yii\helpers\Url;
use app\assets\UsuarioAsset;
UsuarioAsset::register($this);


$this->title = 'Alterar Permissão';
$this->params['breadcrumbs'][] = ['label' => 'Gerenciar Usuário', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="usuario-create">
    
    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="usuario-form" id="usuario">

        <?php $form = ActiveForm::begin(); ?>

            <div class="alert-danger">
                <?= $form->errorSummary([$model]); ?>
            </div>
        
            <?= $form->field($model, 'USU_NOME')->textInput(['maxlength' => true, 'disabled'=>true]) ?>
            
            <?= $form->field($model, 'USU_PERMISSAO')->dropDownList(PermissaoEnum::listar(), [
                    'id'=>'USU_PERMISSAO','prompt'=>'Selecione >>','v-on:change'=>'verificarPermissao()']) ?>

            <div v-show="estagiario">
                <span class="text-danger">> Inicie digitando no campo a seguir, uma lista deve aparecer com o nome do professor. Caso não apareça, você deve cadastrá-lo antes. </span>

                <?= $form->field($model, '_nome')->widget(\yii\jui\AutoComplete::classname(), [
                    'clientOptions' => [
                        'source' => Url::to(['/rest/professores']),
                        'minLength'=>'3',
                        'select'=>new yii\web\JsExpression("function(event, ui) {
                            $('#_prof_id').val(ui.item.id);
                        }"),
                        'change'=>new yii\web\JsExpression("function(event, ui) {
                            if(!ui.item){
                                $('#msgerro').text('Professor não encontrado');
                            }else{
                                $('#msgerro').text('');
                            }
                            $('#_prof_id').val(ui.item? ui.item.id : '' );}"),
                    ],
                    'options'=>['class'=>'form-control']
                ]) ?>

            <?= $form->field($model, '_prof_id')->hiddenInput(['id'=>'_prof_id'])->label(false); ?>
            <span class="text-danger" id="msgerro"></span>

              
            
        </div>

        <?= $form->field($model, 'justificativa')->textarea() ?>

        <div class="form-group">
            <?= Html::submitButton('Atualizar', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>