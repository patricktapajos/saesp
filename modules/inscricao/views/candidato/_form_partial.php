<?php 

use app\models\SituacaoEnum;
use app\models\SexoEnum;
use app\models\SimNaoEnum;
use app\models\EstadoCivilEnum;
use yii\helpers\Html;

$this->registerJs("

    function menorIdade (attribute, value) {
        return $('#CAND_MENOR_IDADE').val() == 'SIM';
    };

    function pcd (attribute, value) {
        return $('#CAND_PCD').val() == 'SIM';
    };

    function medicacao (attribute, value) {
        return $('#CAND_TEM_MEDICACAO').val() == 'SIM';
    };

    function comorbidade (attribute, value) {
        return $('#CAND_TEM_COMORBIDADE').val() == 'SIM';
    };
");

 ?>
<div class="form-tab" id="candidato">
    <fieldset>
        <legend><i class="glyphicon glyphicon-triangle-right"></i>Dados Pessoais</legend>
        <div class="row">
            <div>
                <?= Html::hiddenInput('Candidato[CAND_MENOR_IDADE]', $candidato->CAND_MENOR_IDADE, ['id'=>'CAND_MENOR_IDADE']); ?>
                <?= Html::hiddenInput('Candidato[CAND_IDOSO]', $candidato->CAND_IDOSO, ['id'=>'CAND_IDOSO']); ?>
            </div>

            <div class="form-group">
                <div class="col-lg-12 col-sm-12">
                    <input type="checkbox" class="form-checkbox" id="pcd-checkbox" v-model="show_pcd" true-value="SIM" false-value="NAO"  checked="<?= $candidato->CAND_PCD; ?>">
                        <label>PcD (Pessoa com deficiência)</label>
                    <?= Html::hiddenInput('Candidato[CAND_PCD]', $candidato->CAND_PCD, ['id'=>'CAND_PCD']); ?>
                </div>

                <div class="col-lg-6 col-sm-12">
                    <?= $form->field($model, 'USU_NOME')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-lg-3 col-sm-12">
                    <?= $form->field($model, 'USU_CPF')->widget(\yii\widgets\MaskedInput::className(), [
                        'mask'=>'999.999.999-99'
                    ]) ?>
                    <p v-show="show_responsavel == 'SIM'" class="text-danger">CPF do responsável obrigatório</p>
                </div>
            </div>

             <div class="col-lg-3 col-sm-12">
                <?= $form->field($model, 'USU_DT_NASC')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask'=>'99/99/9999',
                    'options'=>['class'=>'form-control','id'=>'USU_DT_NASC']
                ]) ?>
            </div>
            <div class="form-group">
                 <div class="col-lg-6 col-sm-12">
                    <?= $form->field($model, 'USU_SEXO')->radioList(SexoEnum::listar()) ?>
                </div>

                <div class="col-lg-6 col-sm-12">
                    <?= $form->field($candidato, 'CAND_ESTADO_CIVIL')->radioList(EstadoCivilEnum::listar()) ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-6 col-sm-12">
                    <?= $form->field($model, 'USU_EMAIL')->textInput(['maxlength' => true]) ?>
                </div>

                 <div class="col-lg-3 col-sm-12">
                    <?= $form->field($model, 'USU_TELEFONE_1')->widget(\yii\widgets\MaskedInput::className(), [
                        'mask'=>'(99)99999-9999'
                    ]) ?>
                </div>
                <div class="col-lg-3 col-sm-12">
                    <?= $form->field($model, 'USU_TELEFONE_2')->widget(\yii\widgets\MaskedInput::className(), [
                        'mask'=>'(99)99999-9999'
                    ]) ?>
                </div>
            </div>
            <div class="form-group">
                <transition name="fade">
                    <div class="col-lg-6 col-sm-12" v-show="show_pcd == 'SIM'">
                        <?= $form->field($candidato, 'CAND_PCD_DESC')->textInput(['id'=>'CAND_PCD_DESC','maxlength' => true]) ?>
                    </div>
                </transition>
                
                 <transition name="fade">
                    <div class="col-lg-6 col-sm-12" v-show="show_responsavel == 'SIM'">
                        <?= $form->field($candidato, 'CAND_NOME_RESPONSAVEL')->textInput(['id'=>'CAND_NOME_RESPONSAVEL','maxlength' => true]) ?>
                    </div>
                </transition>
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
                <?= $form->field($candidato, 'CAND_NOME_EMERGENCIA')->textInput(['maxlength' => true]) ?>
            </div>
            
            <div class="col-lg-6 col-sm-12">
                <?= $form->field($candidato, 'CAND_TEL_EMERGENCIA')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask'=>'(99)99999-9999'
                ]) ?>
            </div>

           

            <div class="col-lg-6 col-sm-12">
                <input type="checkbox" class="form-checkbox" v-model="show_comorbidade" id="comorbidade-checkbox" true-value="SIM" false-value="NAO"  checked="<?= $candidato->CAND_TEM_COMORBIDADE; ?>">
                    <label>Possui alguma comorbidade?</label>
                <?= Html::hiddenInput('Candidato[CAND_TEM_COMORBIDADE]', $candidato->CAND_TEM_COMORBIDADE, ['id'=>'CAND_TEM_COMORBIDADE']); ?>
            </div>

            <div class="col-lg-6 col-sm-12">
                <input type="checkbox" class="form-checkbox" v-model="show_medicacao" id="medicamento-checkbox" true-value="SIM" false-value="NAO"  checked="<?= $candidato->CAND_TEM_MEDICACAO; ?>">
                    <label>Ingere algum medicamento?</label>
                <?= Html::hiddenInput('Candidato[CAND_TEM_MEDICACAO]', $candidato->CAND_TEM_MEDICACAO, ['id'=>'CAND_TEM_MEDICACAO']); ?>
            </div>

            <transition name="fade">
                <div class="col-lg-6 col-sm-12" v-show="show_comorbidade == 'SIM'">
                    <?= $form->field($candidato, 'CAND_COMORBIDADE_DESC')->textInput(['id'=>'CAND_COMORBIDADE_DESC','maxlength' => true]) ?>
                </div>        
            </transition>

            <transition name="fade">
                <div class="col-lg-6 col-sm-12" v-show="show_medicacao == 'SIM'">
                    <?= $form->field($candidato, 'CAND_MEDICACAO_DESC')->textInput(['id'=>'CAND_MEDICACAO_DESC','maxlength' => true]) ?>
                </div> 
            </transition>

             <div class="col-lg-12 col-sm-12">
                <?= $form->field($candidato, 'CAND_OBSERVACOES')->textInput(['maxlength' => true]) ?>
            </div>

        </div>

    </fieldset>
</div>