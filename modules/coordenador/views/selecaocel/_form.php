<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\coordenador\models\SelecaoCel;
use app\assets\VueModalidadeAsset;
use app\assets\VueModalidadeAlteracaoAsset;

if($model->isNewRecord){
    VueModalidadeAsset::register($this);    
}else{
    VueModalidadeAlteracaoAsset::register($this);
}

/* @var $this yii\web\View */
/* @var $model app\modules\coordenador\models\SelecaoCel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="selecao-cel-form" id="selecaocel">
    <?php $form = ActiveForm::begin(['id'=>'selecaocel-form']); ?>

    <div class="alert alert-danger" v-show="erroForm">
        <ul v-for="e in erros">
            <li>{{ e }}</li>
    </div>

     <div class="col-lg-12 col-sm-12">
        <?= $form->field($model, 'SEL_ID')->dropDownList(SelecaoCel::selecoesAtivas(),['prompt'=>'Selecione >>','v-model'=>'id']) ?>
    </div>
    <br clear="left" />
    <fieldset>
        <legend>Quadro de Modalidades</legend>
        <tabela-modalidade></tabela-modalidade> 
    </fieldset>

    <?php if(!$model->isNewRecord): ?>
        <?= Html::hiddenInput('SelecaoCel[complementoexclusao]', null, array('v-model'=>'complementoexclusao')); ?>
    <?php endif;  ?>

    <div class="form-group">
        <?= Html::button($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'required'=>'required','v-on:click'=>'$children[0].salvar()']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script type="x/template" id="tabela-modalidade-template">
    <div>
        <div class="row text-center div-header">
            <div class="col-lg-3">Modalidade</div>
            <div class="col-lg-3">Professor</div>
            <div class="col-lg-2">Dias da Semana</div>
            <div class="col-lg-2">Horário</div>
            <div class="col-lg-2">Qtde. de Vagas</div>
        </div>
        <div class="row div-body" v-for="(mod, m) in modalidades">
            <div class="col-lg-3">
                <span>{{ mod.MOD_DESCRICAO }}</span>
                <input type="hidden" v-model="mod.MOD_ID" :name="'SelecaoCel[modalidades]['+m+'][MOD_ID]'" />
                <input type="hidden" v-model="mod.SMOD_ID" :name="'SelecaoCel[modalidades]['+m+'][SMOD_ID]'" />
                <i title="Adicionar Ação" v-on:click="adicionarComplemento(m)" class="icon-add glyphicon glyphicon-plus"></i>                
            </div>
            <div class="col-lg-9">
                <div class="col-lg-12 div-complemento" v-for="(com, c) in mod.complemento">
                    <div class="col-lg-4">
                        <input type="text" class="form-control" v-on:click="setAutocomplete('professor_'+ m +'_'+ c, m, c)" :id="'professor_'+m+'_'+c" />
                        <input type="hidden" v-model="com.MDT_ID" :name="'SelecaoCel[modalidades]['+m+'][complemento]['+c+'][MDT_ID]'" />
                        <input type="hidden" v-model="com.PROF_ID" :name="'SelecaoCel[modalidades]['+m+'][complemento]['+c+'][PROF_ID]'" />
                        <div v-bind:id="'erro_PROF_ID_'+m+'_'+c" class="errorMessage text-danger"></div>
                    </div>
                    <div class="col-lg-3">
                        <div v-for="(dia, d) in dias">
                            <span class="col-lg-6">
                               <input type="checkbox" v-on:click="adicionarDia(m, c, d)" :name="'SelecaoCel[modalidades]['+m+'][complemento]['+c+'][dias]['+dia+']'" class="form-checkbox" :id="dia+'_'+m+'_'+c"/>{{dia}}
                            </span>
                        </div>
                        <div v-bind:id="'erro_dias_'+m+'_'+c" class="errorMessage text-danger"></div>
                    </div>
                    <div class="col-lg-3">
                        <span class="col-lg-6">
                           <input type="text" v-model = "com.MDT_HORARIO_INICIO" class="form-control" v-input-mask data-inputmask="'mask': '99:99'" 
                           v-on:blur="setValorHorarioInicioSemMascara($event, m , c)"  :id="'horario_inicio_'+m+'_'+c" :name="'SelecaoCel[modalidades]['+m+'][complemento]['+c+'][MDT_HORARIO_INICIO]'" /> 
                          <div v-bind:id="'erro_MDT_HORARIO_INICIO_'+m+'_'+c" class="errorMessage text-danger"></div>
                        </span>
                        <span class="col-lg-6">
                            <input type="text" class="form-control" v-input-mask data-inputmask="'mask': '99:99'" v-model = "com.MDT_HORARIO_FIM"
                            v-on:blur="setValorHorarioFimSemMascara($event, m , c)"
                            :id="'horario_fim_'+m+'_'+c" :name="'SelecaoCel[modalidades]['+m+'][complemento]['+c+'][MDT_HORARIO_FIM]'"/>
                           <div v-bind:id="'erro_MDT_HORARIO_FIM_'+m+'_'+c" class="errorMessage text-danger"></div>
                       </span>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" v-model="com.MDT_QTDE_VAGAS" :name="'SelecaoCel[modalidades]['+m+'][complemento]['+c+'][MDT_QTDE_VAGAS]'" />
                        <div v-bind:id="'erro_MDT_QTDE_VAGAS_'+m+'_'+c" class="errorMessage text-danger"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</script>