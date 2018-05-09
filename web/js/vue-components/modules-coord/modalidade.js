var modal = Vue.component('tabela-modalidade',{
	template: '#tabela-modalidade-template',
	props: {
		
	},
	data:function(){
		return {
			id:'',
			modalidades : [],
			dias : ['Seg','Ter','Qua','Qui','Sex','Sab']
		}
	},
	methods:{
		carregarModalidades: function(){
			const url = '/../rest/modalidades';
		    $.get(url).then(data => {
		      	const items = data;
			    items.map((item) => {
			    	item['complemento'] = [];
			      	this.modalidades.push(item);
			    })
		    }).fail(function() {
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
			/*this.modalidades[id].complemento.splice(
				this.modalidades[id].complemento.length+ 1, 0,{
						professor:'',
						dias:[],
						horario:''
				}
			);*/
			this.modalidades[id].complemento.push({
				professor:'',
				dias:[],
				hora_inicio:'',
				hora_fim:''
			});
		},

		removerComplemento: function(l, m){
			if (confirm('Deseja mesmo remover estes dados?') == false) {
				return false;
			}
			this.modalidades[l].complemento.splice(m, 1);
		},

		adicionarDia: function(m, c, val){			
			if($.inArray(val, this.modalidades[m].complemento[c].dias) == -1){
				this.modalidades[m].complemento[c].dias.push(val);
			}else{
				this.modalidades[m].complemento[c].dias.splice($.inArray(val, this.modalidades[m].complemento[c].dias),1)
			}
		}
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