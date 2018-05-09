<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\VueModalidadeAsset;

VueModalidadeAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\coordenador\models\SelecaoCel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="selecao-cel-form" id="selecaocel">
    <?php $form = ActiveForm::begin(); ?>

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
                <th>Selecionar</th>
    			<th>Modalidade</th>
    			<th>Professor</th>
    			<th>Dias da Semana</th>
    			<th>Horário</th>
    		</tr>
    	</thead>
    	<tbody>
    		<tr v-for="(mod, m) in modalidades">
                <td><input type="checkbox" :id="'check_'+m" :name="'selecaocel[modalidades]['+m+'][check]'"/></td>
    			<td>
    				<span class="text-left">{{ mod.MOD_DESCRICAO }}</span>
    				<div class="buttons text-right">
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
									<input type="text" class="form-control" v-model="com.hora_inicio" :name="'selecaocel[modalidades]['+m+'][complemento]['+c+'][hora_inicio]'" /> 
                                    a
                                    <input type="text" class="form-control" v-model="com.hora_fim" :name="'selecaocel[modalidades]['+m+'][complemento]['+c+'][hora_fim]'"/>
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