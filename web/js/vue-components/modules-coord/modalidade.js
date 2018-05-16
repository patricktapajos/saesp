Vue.directive('input-mask', {
  bind: function(el) {
    $(el).inputmask();
  }
});

var tabelamodalidade = Vue.component('tabela-modalidade',{
	template: '#tabela-modalidade-template',
	props: {
		
	},
	data:function(){
		return {
			id:'',
			modalidades : [],
			dias : ['Seg','Ter','Qua','Qui','Sex','Sab'],
			erroForm: '',
		}
	},
	methods:{
		carregarModalidades: function(){
			$().blockScreen("Carregando Quadro");
			const url = '/../rest/modalidades';
		    $.get(url).then(data => {
		      	const items = data;
			    items.map((item) => {
			    	item['complemento'] = [];
			      	this.modalidades.push(item);
			    })
			    $().unblockScreen();
		    }).fail(function(error) {
		    	$().unblockScreen();
			    console.log(error);
			 });
		},

		setAutocomplete: function(input, c, i) {
			var self = this;
			$('#' + input).autocomplete({
				source: '/../rest/professores',
				showAnim: 'fold',
				minLength: 2,
				select: function(event, ui) {
					self.modalidades[c].complemento[i].PROF_ID = ui.item.id;
				},
				change: function(event, ui) {
					if(ui.item != null){
						self.modalidades[c].complemento[i].PROF_ID = ui.item.id
					}
					else{
						self.modalidades[c].complemento[i].PROF_ID = ''
					}
				}
			});
		},

		adicionarComplemento: function(id){
			this.modalidades[id].complemento.push({
				PROF_ID:'',
				dias:[],
				MDT_HORARIO_INICIO:'',
				MDT_HORARIO_FIM:'',
				MDT_QTDE_VAGAS:''
			});
		},

		adicionarDia: function(m, c, val){			
			if($.inArray(val, this.modalidades[m].complemento[c].dias) == -1){
				this.modalidades[m].complemento[c].dias.push(val);
			}else{
				this.modalidades[m].complemento[c].dias.splice($.inArray(val, this.modalidades[m].complemento[c].dias),1)
			}
		},

		removerComplemento: function(l, m){
			if (confirm('Deseja mesmo remover estes dados?') == false) {
				return false;
			}
			this.modalidades[l].complemento.splice(m, 1);
		},

		setValorHorarioInicioSemMascara($event, m, c){
			this.modalidades[m].complemento[c].MDT_HORARIO_INICIO = $event.target.value;
		},

		setValorHorarioFimSemMascara($event, m, c){
			this.modalidades[m].complemento[c].MDT_HORARIO_FIM = $event.target.value;
		},

		setValorHorarioSemMascara($event, m, c){
			this.modalidades[m].complemento[c].campo = $event.target.value;
		},

		salvar: function() {

			$().blockScreen("Validando Quadro");

			$(".errorMessage").each(function() {
				$(this).text('');
			});

			var self = this;

			$.ajax({
				url: '/../rest/salvarcelselecao',
				type: 'POST',
				data: {
					'SelecaoCel[SEL_ID]':self.id,
					'SelecaoCel[modalidades]': this.modalidades
				},
				dataType: 'json',
				success: function(dados, textStatus, jqXHR) {
					if (dados.success) {
						self.erroForm = false;
						$('#selecaocel-form').submit();
					} else {
						$().unblockScreen();
						if(dados.erros.selecaocel){
							self.$parent.erro = true;				
							self.$parent.msgerro = "Seleção é obrigatória";
						}
						$.each(dados.erros.modalidades, function(mod_id, complemento) {
							$.each(complemento, function(com_id, com_erros){
								$.each(com_erros, function(campo_id, campos){
									$.each(campos, function(erro_id, erro){
										$('#'+erro_id+'_'+mod_id+'_'+campo_id).css('border-color', '#da9391');
										$('#erro_'+erro_id+'_'+mod_id+'_'+campo_id).text(erro);
									});
								});
							});
						});
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log('ERRORS: ' + errorThrown);
				}
			});
		},
	},

	mounted:function(){
		this.$nextTick(function(){
			this.carregarModalidades();
		});
	}
})

var vue = new Vue({
	el:'#selecaocel',
	data:{
		id:'',
		erro:'',
		msgerro:''
	},
	components: { 'tabelamodalidade': tabelamodalidade },
	watch: {
		    id: function(currentValue) {
		    	if(currentValue != ''){
		    		this.$children[0].id = currentValue;
		    	}
		    },
		},
});