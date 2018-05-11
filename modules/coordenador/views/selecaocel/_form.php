<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\VueModalidadeAsset;
//use yii\widgets\MaskedInputAsset;

//MaskedInputAsset::register($this);
VueModalidadeAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\coordenador\models\SelecaoCel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="selecao-cel-form" id="selecaocel">
    <?php $form = ActiveForm::begin(['id'=>'selecaocel-form']); ?>

    <tabela-modalidade></tabela-modalidade>	

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script type="x/template" id="tabela-modalidade-template">
 	<table class="table table-bordered table-centered">
    	<thead>
    		<tr>
    			<th colspan="2">Modalidade</th>
    			<th>Professor</th>
    			<th>Dias da Semana</th>
    			<th>Horário</th>
    		</tr>
    	</thead>
    	<tbody>
    		<tr v-for="(mod, m) in modalidades">
    			<td>
    				<span class="text-left">{{ mod.MOD_DESCRICAO }}</span>
    			</td>
                <td>
                    <div class="buttons">
                        <i title="Adicionar Ação" v-on:click="adicionarComplemento(m)" class="icones-plan-action add glyphicon glyphicon-plus"></i>
                    </div>
                </td>
    			<td colspan="4">
    				<table class="table">
    					<tbody>
    						<tr v-for="(com, c) in mod.complemento">
    							<td>
									<input type="text" class="form-control" v-on:click="setAutocomplete('professor_'+ m +'_'+ c, m, c)" :id="'professor_'+m+'_'+c" :name="'selecaocel[modalidades]['+m+'][complemento]['+c+'][professor]'" />
    							</td>
    							<td>
                                    <span v-for="(dia, d) in dias">
									   <input type="checkbox" v-on:click="adicionarDia(m, c, d)" :name="'selecaocel[modalidades]['+m+'][complemento]['+c+'][dias][]'" class="form-checkbox" />{{dia}}
                                    </span>
    							</td>
    							<td>
                                    <div class="col-lg-3">
									       <input type="text" class="form-control" v-model="com.hora_inicio" v-on:focus="setMascaraHorario" :id="'horario_inicio_'+m+'_'+c" :name="'selecaocel[modalidades]['+m+'][complemento]['+c+'][hora_inicio]'" /> 
                                    </div>
                                    <div class="col-lg-1">
                                        a
                                    </div>
                                    <div class="col-lg-3">
                                            <input type="text" class="form-control" v-model="com.hora_fim" v-on:focus="setMascaraHorario" :id="'horario_fim_'+m+'_'+c" :name="'selecaocel[modalidades]['+m+'][complemento]['+c+'][hora_fim]'"/>
                                    </div>
    							</td>
                                <td>
                                    <i title="Remover ação" v-on:click="removerComplemento(m, c)" class="icones-plan-action remove glyphicon glyphicon-trash"></i>
                                </td>
    						</tr>
    					</tbody>
    				</table>
    			</td>
    		</tr>
	    </tbody>
    </table>
</script>