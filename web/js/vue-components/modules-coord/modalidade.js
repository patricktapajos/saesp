var modal = Vue.component('tabela-modalidade',{
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
			$().blockScreen("Carregando");
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

		setMascaraHorario: function(event){
			$('#'+event.target.id).inputmask({"mask": "99:99", "clearIncomplete" : true});
		},
		setAutocomplete: function(input, c, i) {
			var self = this;
			$('#' + input).autocomplete({
				source: '/../rest/professores',
				showAnim: 'fold',
				minLength: 2,
				select: function(event, ui) {
					self.modalidades[c].complemento[i].professor = ui.item.id;
				},
				change: function(event, ui) {
					if(ui.item != null){
						self.modalidades[c].complemento[i].professor = ui.item.id
					}
					else{
						self.modalidades[c].complemento[i].professor = ''
					}
				}
			});
		},

		adicionarComplemento: function(id){
			this.modalidades[id].complemento.push({
				professor:'',
				dias:[],
				hora_inicio:'',
				hora_fim:''
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

		validate: function() {

			$(".errorMessage").each(function() {
				$(this).text('');
			});

			var self = this;

			$.ajax({
				url: '/../rest/salvarCelSelecao',
				type: 'POST',
				data: {
					'modalidades': this.modalidades
				},
				dataType: 'json',
				success: function(dados, textStatus, jqXHR) {
					if (dados.success) {
						self.erroForm = false;
						$('#selecaocel-form').submit();
					} else {
						$().unblockScreen();
						if(dados.erros.plan){
							$.each(dados.erros.plan, function(name, msg) {
								jQuery('#'+name).css('border-color', '#da9391');
								jQuery('#erro_'+name).text(msg);
							});
						}
						self.erroForm = true;
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
	data:{}
});