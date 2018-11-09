var vue2 = new Vue({
	el:'#modal',
	data:{
		urlModalidades: $().getUrl()+'/rest/inscricaomodalidades',
		urlModalidadesAquaticas: $().getUrl()+'/rest/inscricaomodalidadesaquaticas',
		modalidades: [],
		modalidadesAquaticas: [],
		contModalidadesAquaticas: 0,
		listagem: ''
	},
	methods:{
		adicionarModalidade:function(mdh_codigo){
			if($.inArray(mdh_codigo, this.modalidades) == -1){
				this.modalidades.push(mdh_codigo);
			}else{
				this.modalidades.splice($.inArray(mdh_codigo, this.modalidades),1);
			}

			if($.inArray(mdh_codigo, this.modalidades) != -1 && $.inArray(mdh_codigo, this.modalidadesAquaticas) != -1){
				this.contModalidadesAquaticas++;								
			}else{
				if(this.contModalidadesAquaticas > 0){
					this.contModalidadesAquaticas--;
				}
			}
		},
		carregarModalidades: function(){
			var self = this;
			$().blockScreen("Carregando Dados...");

		    $.get(this.urlModalidades).then((data) => {
		    	self.modalidades = data;
		      	$.each(data, function(id, value){
		      		$('#'+value).attr('checked',true);
		      	});
		    }).then(()=>{
				$.get(this.urlModalidadesAquaticas).then((data) => {
					self.modalidadesAquaticas = data;
				}).fail(function(error) {
					console.log(error);
				 });
			}).then(()=>{
				$().unblockScreen();
			});			 
		},

		/*validarModalidadeAquatica: function(){
			if(this.modalidades.length > 0){
				return $.get(this.urlValidarAquatico, {'modalidades': this.modalidades}).then((qtd)=>{
					if(qtd > 1){
						$('#validoaquatico').val('');
					}else{
						$('#validoaquatico').val('1');
					}
				});
			}
		}*/

	},
	mounted:function(){
		this.$nextTick(function(){
			this.carregarModalidades();
		});
	}
});