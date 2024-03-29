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

    <?= $form->field($model, 'SEL_ID')->hiddenInput(['id'=>'id'])->label(false); ?>
      
    <span class="text-warning">Preencha o quadro a seguir com as modalidades que o CEL deseja oferecer aos candidatos desta seleção.</span>
    <br clear="left" />
    <br clear="left" />
    <div class="candidato-create">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Quadro de Modalidades</div>
            </div>
                <tabela-modalidade></tabela-modalidade> 
        </div>
    </div>

    <?php if(!$model->isNewRecord): ?>
        <?= Html::hiddenInput('SelecaoCel[complementoexclusao]', null, array('v-model'=>'complementoexclusao')); ?>
    <?php endif;  ?>

    <div class="form-group">
        <?= Html::button($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'required'=>'required','v-on:click'=>'$children[0].salvar()']) ?>
        <?= Html::a('Cancelar', ['index'] ,['class' => 'btn btn-danger']) ?>

    </div>
    <?php ActiveForm::end(); ?>
</div>

<script type="x/template" id="tabela-modalidade-template">
    <table class="table table-modalidade table-acao table-responsive">
        <thead>
            <tr>
                <th class="field_cross">Modalidade</th>
                <th class="field_cross">Professor</th>
                <th class="field_date">Dias da Semana</th>
                <th class="field_date">Horário</th>
                <th class="field_small">Nº de Vagas</th>
                <th class="field_x"><i class= "glyphicon glyphicon-trash"></i></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(mod, m) in modalidades">
                <td class="field_date">
                    <p>
                        <b>Descrição: </b> {{ mod.MOD_NOME }}
                    </p>
                    <p>
                        <b>Idade: </b> de {{ mod.MOD_IDADE_MIN }} a {{ mod.MOD_IDADE_MAX }}
                    </p>
                    <p>
                        <b>Nível:</b> {{ mod.nivel }}
                    </p>
                    <input type="hidden" v-model="mod.MOD_ID" :name="'SelecaoCel[modalidades]['+m+'][MOD_ID]'" />
                    <input type="hidden" v-model="mod.SMOD_ID" :name="'SelecaoCel[modalidades]['+m+'][SMOD_ID]'" />
                    <div class="buttons">
                        <i title="Adicionar Ação" v-on:click="adicionarComplemento(m)" class="icones-plan-action add glyphicon glyphicon-plus"></i> 
                    </div>
                </td>
                <td colspan="5">
                    <table class="table-complement">
                        <tbody>
                            <tr v-for="(com, c) in mod.complemento">
                                <td class="field">
                                    <input type="text" class="form-control" v-on:click="setAutocomplete('professor_'+ m +'_'+ c, m, c)" :id="'professor_'+m+'_'+c" />
                                    <input type="hidden" v-model="com.MDT_ID" :name="'SelecaoCel[modalidades]['+m+'][complemento]['+c+'][MDT_ID]'" />
                                    <input type="hidden" v-model="com.PROF_ID" :name="'SelecaoCel[modalidades]['+m+'][complemento]['+c+'][PROF_ID]'" />
                                    <div v-bind:id="'erro_PROF_ID_'+m+'_'+c" class="errorMessage text-danger"></div>
                                </td>
                                <td class="field_date">
                                    <div v-for="(dia, d) in dias">
                                        <span class="col-lg-4 col-sm-4">
                                           <input type="checkbox" v-on:click="adicionarDia(m, c, d)" :name="'SelecaoCel[modalidades]['+m+'][complemento]['+c+'][dias]['+dia+']'" class="form-checkbox" :id="dia+'_'+m+'_'+c"/>{{dia}}
                                        </span>
                                    </div>
                                    <div v-bind:id="'erro_dias_'+m+'_'+c" class="errorMessage text-danger"></div>
                                </td>
                                <td class="field_date">
                                    <span class="col-lg-6">
                                       <input type="text" v-model = "com.MDT_HORARIO_INICIO" class="form-control input-small" v-input-mask data-inputmask="'mask': '99:99'" 
                                       v-on:blur="setValorHorarioInicioSemMascara($event, m , c)"  :id="'horario_inicio_'+m+'_'+c" :name="'SelecaoCel[modalidades]['+m+'][complemento]['+c+'][MDT_HORARIO_INICIO]'" /> 
                                      <div v-bind:id="'erro_MDT_HORARIO_INICIO_'+m+'_'+c" class="errorMessage text-danger"></div>
                                    </span>
                                    <span class="col-lg-6">
                                        <input type="text" class="form-control input-small" v-input-mask data-inputmask="'mask': '99:99'" v-model = "com.MDT_HORARIO_FIM"
                                        v-on:blur="setValorHorarioFimSemMascara($event, m , c)"
                                        :id="'horario_fim_'+m+'_'+c" :name="'SelecaoCel[modalidades]['+m+'][complemento]['+c+'][MDT_HORARIO_FIM]'"/>
                                       <div v-bind:id="'erro_MDT_HORARIO_FIM_'+m+'_'+c" class="errorMessage text-danger"></div>
                                   </span>
                                </td>
                                <td class="field_small">
                                    <input type="text" class="form-control" v-model="com.MDT_QTDE_VAGAS" :name="'SelecaoCel[modalidades]['+m+'][complemento]['+c+'][MDT_QTDE_VAGAS]'" />
                                    <div v-bind:id="'erro_MDT_QTDE_VAGAS_'+m+'_'+c" class="errorMessage text-danger"></div>
                                </td>
                                <td class="field_x">
                                <i title="Remover Ação" v-on:click="removerComplemento(m, c)" class="icones-plan-action add glyphicon glyphicon-trash"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>    
</script>