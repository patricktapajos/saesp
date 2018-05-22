<?php 
use app\models\SituacaoEnum;
use app\models\SexoEnum;
use app\models\EstadoCivilEnum;
 ?>

<fieldset>
    <legend>Dados Pessoais</legend>
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($model, 'USU_NOME')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($model, 'USU_EMAIL')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'USU_CPF')->widget(\yii\widgets\MaskedInput::className(), [
                'mask'=>'999.999.999-99'
            ]) ?>
        </div>

         <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'USU_DT_NASC')->widget(\yii\widgets\MaskedInput::className(), [
                'mask'=>'99/99/9999'
            ]) ?>
        </div>

         <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'USU_TELEFONE_1')->widget(\yii\widgets\MaskedInput::className(), [
                'mask'=>'(99)\99999-9999'
            ]) ?>
        </div>
        <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'USU_TELEFONE_2')->widget(\yii\widgets\MaskedInput::className(), [
                'mask'=>'(99)\99999-9999'
            ]) ?>
        </div>
        
        <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'USU_SITUACAO')->dropDownList(SituacaoEnum::listar()) ?>
        </div>

        <div class="col-lg-3 col-sm-12">
            <?= $form->field($model, 'USU_SEXO')->radioList(SexoEnum::listar()) ?>
        </div>

        <div class="col-lg-6 col-sm-12">
            <?= $form->field($candidato, 'CAND_ESTADO_CIVIL')->radioList(EstadoCivilEnum::listar()) ?>
        </div>

    </div>
</fieldset>

<fieldset>
    <legend>Dados de Endereço</legend>
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($candidato, 'CAND_LOGRADOURO')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($candidato, 'CAND_COMPLEMENTO_END')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-3 col-sm-12">
            <?= $form->field($candidato, 'CAND_CEP')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-3 col-sm-12">
            <?= $form->field($candidato, 'CAND_BAIRRO')->textInput(['maxlength' => true]) ?>
        </div>

    </div>
</fieldset>

<fieldset>
    <legend>Dados Complementares</legend>
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($candidato, 'CAND_NOME_EMERGENCIA')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($candidato, 'CAND_TEL_EMERGENCIA')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($candidato, 'CAND_NOME_RESPONSAVEL')->textInput(['maxlength' => true]) ?>
        </div>
        
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($candidato, 'CAND_TEM_COMORBIDADE')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($candidato, 'CAND_COMORBIDADE_DESC')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($candidato, 'CAND_TEM_MEDICACAO')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($candidato, 'CAND_MEDICACAO_DESC')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6 col-sm-12">
            <?= $form->field($candidato, 'CAND_OBSERVACOES')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

</fieldset>
