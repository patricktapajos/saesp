<?php 

use app\models\SituacaoEnum;
use app\models\SexoEnum;
use app\models\SimNaoEnum;
use app\models\EstadoCivilEnum;
use app\assets\InscricaoAsset;
use yii\helpers\Html;
InscricaoAsset::register($this);

 ?>
<div id="candidato">
    <fieldset>
        <legend><i class="glyphicon glyphicon-triangle-right"></i>Dados Pessoais</legend>
        <div class="row">
            
            <div class="col-lg-6 col-sm-12 text-center">
                <img src="<?= $candidato->getUrlFoto(); ?>" id="foto-candidato" width="160" height="150" />
                <?= $form->field($candidato, 'CAND_FOTO')->fileInput(['id'=>'urlfoto']); ?>
            </div>

            <div class="col-lg-3 col-sm-12">
                <input type="checkbox" class="form-checkbox" v-model="show_responsavel" true-value="1" false-value="0" checked="<?= $candidato->CAND_MENOR_IDADE; ?>">
                    <label>Menor de Idade</label>
                <?= Html::hiddenInput('Candidato[CAND_MENOR_IDADE]', $candidato->CAND_MENOR_IDADE, ['id'=>'CAND_MENOR_IDADE']); ?>
            </div>

            <transition name="fade">
                <div class="col-lg-6 col-sm-12" v-show="show_responsavel == 1">
                    <?= $form->field($candidato, 'CAND_NOME_RESPONSAVEL')->textInput(['maxlength' => true]) ?>
                </div>
            </transition>

            <div class="col-lg-3 col-sm-12">
                <input type="checkbox" class="form-checkbox" v-model="show_pcd" true-value="1" false-value="0"  checked="<?= $candidato->CAND_PCD; ?>">
                    <label>PcD (Pessoa com deficiência)</label>
                <?= Html::hiddenInput('Candidato[CAND_PCD]', $candidato->CAND_PCD, ['id'=>'CAND_PCD']); ?>
            </div>


            <transition name="fade">
                <div class="col-lg-6 col-sm-12" v-show="show_pcd == 1">
                    <?= $form->field($candidato, 'CAND_PCD_DESC')->textInput(['maxlength' => true]) ?>
                </div>
            </transition>

            <div class="col-lg-6 col-sm-12">
                <?= $form->field($model, 'USU_NOME')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-lg-3 col-sm-12">
                <?= $form->field($model, 'USU_CPF')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask'=>'999.999.999-99'
                ]) ?>
                <span v-show="show_responsavel == 1" class="text-danger">CPF do responsável é obrigatório para menores de idade</span>
            </div>

             <div class="col-lg-3 col-sm-12">
                <?= $form->field($model, 'USU_DT_NASC')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask'=>'99/99/9999'
                ]) ?>
            </div>

            <div class="col-lg-6 col-sm-12">
                <?= $form->field($model, 'USU_EMAIL')->textInput(['maxlength' => true]) ?>
            </div>

             <div class="col-lg-2 col-sm-12">
                <?= $form->field($model, 'USU_TELEFONE_1')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask'=>'(99)99999-9999'
                ]) ?>
            </div>
            <div class="col-lg-2 col-sm-12">
                <?= $form->field($model, 'USU_TELEFONE_2')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask'=>'(99)99999-9999'
                ]) ?>
            </div>

             
            <div class="col-lg-3 col-sm-12">
                <?= $form->field($model, 'USU_SEXO')->radioList(SexoEnum::listar()) ?>
            </div>

            <div class="col-lg-5 col-sm-12">
                <?= $form->field($candidato, 'CAND_ESTADO_CIVIL')->radioList(EstadoCivilEnum::listar()) ?>
            </div>

            


        </div>
    </fieldset>
    <br>
    <fieldset>
        <legend><i class="glyphicon glyphicon-triangle-right"></i>Dados de Endereço</legend>
        <div class="row">
            <div class="col-lg-2 col-sm-12">
                <?= $form->field($candidato, 'CAND_CEP')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask'=>'99.999-999'
                ])  ?>
            </div>
            
            <div class="col-lg-4 col-sm-12">
                <?= $form->field($candidato, 'CAND_LOGRADOURO')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-4 col-sm-12">
                <?= $form->field($candidato, 'CAND_COMPLEMENTO_END')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-lg-2 col-sm-12">
                <?= $form->field($candidato, 'CAND_BAIRRO')->textInput(['maxlength' => true]) ?>
            </div>

        </div>
    </fieldset>
    <br>
    <fieldset>
        <legend><i class="glyphicon glyphicon-triangle-right"></i>Dados Complementares</legend>
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <input type="checkbox" v-model="show_comorbidade" true-value="1" false-value="0"  checked="<?= $candidato->CAND_TEM_COMORBIDADE; ?>">
                    <label>Possui alguma comorbidade?</label>
                <?= Html::hiddenInput('Candidato[CAND_TEM_COMORBIDADE]', $candidato->CAND_TEM_COMORBIDADE, ['id'=>'CAND_TEM_COMORBIDADE']); ?>
            </div>

            <transition name="fade">
                <div class="col-lg-6 col-sm-12" v-show="show_comorbidade == 1">
                    <?= $form->field($candidato, 'CAND_COMORBIDADE_DESC')->textInput(['maxlength' => true]) ?>
                </div>        
            </transition>

            <div class="col-lg-6 col-sm-12">
                <input type="checkbox" v-model="show_medicacao" true-value="1" false-value="0"  checked="<?= $candidato->CAND_TEM_MEDICACAO; ?>">
                    <label>Ingere algum medicamento?</label>
                <?= Html::hiddenInput('Candidato[CAND_TEM_MEDICACAO]', $candidato->CAND_TEM_MEDICACAO, ['id'=>'CAND_TEM_MEDICACAO']); ?>
            </div>

            
            <transition name="fade">
                <div class="col-lg-6 col-sm-12" v-show="show_medicacao == 1">
                    <?= $form->field($candidato, 'CAND_MEDICACAO_DESC')->textInput(['maxlength' => true]) ?>
                </div> 
            </transition>

            <div class="col-lg-6 col-sm-12">
                <?= $form->field($candidato, 'CAND_NOME_EMERGENCIA')->textInput(['maxlength' => true]) ?>
            </div>
            
            <div class="col-lg-6 col-sm-12">
                <?= $form->field($candidato, 'CAND_TEL_EMERGENCIA')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask'=>'(99)99999-9999'
                ]) ?>
            </div>

            <div class="col-lg-6 col-sm-12">
                <?= $form->field($candidato, 'CAND_OBSERVACOES')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

    </fieldset>
</div>