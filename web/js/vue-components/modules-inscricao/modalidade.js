var vue2 = new Vue({
	el:'#modal',
	data:{
		urlModalidades: $().getUrl()+'/rest/inscricaomodalidades',
		urlModalidadesAquaticas: $().getUrl()+'/rest/inscricaomodalidadesaquaticas',
		modalidades: [],
		modalidadesAquaticas: [],
		contModalidadesAquaticas: 0,
		listagem: '',
		idUsuario: ''
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

		    $.get(this.urlModalidades, {id: this.idUsuario}).then((data) => {
		    	self.modalidades = data;
		      	$.each(data, function(id, value){
		      		$('#'+value).attr('checked',true);
		      	});
		    }).then(()=>{
				$.get(this.urlModalidadesAquaticas).then((data) => {
					self.modalidadesAquaticas = data;
					self.contadorAquatico();
				}).fail(function(error) {
					console.log(error);
				 });
			}).then(()=>{
				$().unblockScreen();
			});			 
		},

		contadorAquatico: function(){
			var self = this;
			$.each(self.modalidadesAquaticas, function(idx, value) {
				if ($.inArray(value, self.modalidades) != -1) {
					self.contModalidadesAquaticas++;
				}
			});
		}
	},
	mounted:function(){
		this.$nextTick(function(){
			this.idUsuario = $('#USU_ID').val();
			this.carregarModalidades();
		});
	}
});