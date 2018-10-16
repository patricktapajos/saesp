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
		}
	},
	methods:{
		carregarModalidades: function(){
			var self = this;
			$().blockScreen("Carregando Quadro");
			const url = $().getUrl()+'/rest/alterarmodalidades';
		    $.get(url).then(data => {
		    	this.$parent.id = data.SEL_ID;
		      	this.modalidades = data.modalidades;
			    $().unblockScreen();
		    }).fail(function(error) {
		    	$().unblockScreen();
			    console.log(error);
			 }).always(function(){
			 	setTimeout(()=>{
			 		self.setNomeProfessor();
			 		self.setCheckDias();
			 	},1000);
			 });
		},

		setNomeProfessor: function(){
			$.each(this.modalidades, function(id, modalidade){
				$.each(modalidade.complemento, function(cid, comp) {
					$('#professor_' + id + '_' + cid).val(comp._nome_professor);
				});
			});
		},

		setCheckDias(){
			var self = this;
			$.each(this.modalidades, function(id, modalidade){
				$.each(modalidade.complemento, function(cid, comp) {
					$.each(comp.dias, function(did, dia) {
						$('#'+dia+'_' + id + '_' + cid).prop('checked', true);					
					});	
				});
			});	
		},

		setAutocomplete: function(input, c, i) {
			var self = this;
			$('#' + input).autocomplete({
				source: $().getUrl()+'/rest/professores',
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
				MDT_ID:'',
				MDT_HORARIO_INICIO:'',
				MDT_HORARIO_FIM:'',
				MDT_QTDE_VAGAS:''
			});
		},

		adicionarDia: function(m, c, val){			
			if($.inArray(this.dias[val], this.modalidades[m].complemento[c].dias) == -1){
				this.modalidades[m].complemento[c].dias.push(this.dias[val]);
			}else{
				this.modalidades[m].complemento[c].dias.splice($.inArray(this.dias[val], this.modalidades[m].complemento[c].dias),1)
			}
		},

		removerComplemento: function(l, m){
			if (confirm('Deseja mesmo remover estes dados?') == false) {
				return false;
			}
			this.$parent.complementoexclusao.push(this.modalidades[l].complemento[m].MDT_ID);
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
				url: $().getUrl()+'/rest/salvarcelselecao',
				type: 'POST',
				data: {
					'SelecaoCel[SEL_ID]':self.id,
					'SelecaoCel[modalidades]': this.modalidades
				},
				dataType: 'json',
				success: function(dados, textStatus, jqXHR) {
					if (dados.success) {
						$('#selecaocel-form').submit();
					} else {
						$().unblockScreen();
						if(dados.erros.selecaocel){
							self.$parent.erroForm = true;				
							self.$parent.erros = dados.erros.selecaocel;
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
		erroForm: false,
		erros : [],
		complementoexclusao: []
	},
	components: { 'tabelamodalidade': tabelamodalidade },
	watch: {
		    id: function(currentValue) {
		    	this.$children[0].id = currentValue;
		    },
		},
});