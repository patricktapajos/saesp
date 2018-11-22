var vue2 = new Vue({
	el:'#modal',
	data:{
		urlModalidades: $().getUrl()+'/rest/inscricaomodalidades',
		urlModalidadesAquaticas: $().getUrl()+'/rest/inscricaomodalidadesaquaticas',
		urlHorarioModalidades: $().getUrl()+'/rest/validarhorariomodalidade',
		modalidades: [],
		modalidadesAquaticas: [],
		contModalidadesAquaticas: 0,
		listagem: '',
		idUsuario: '',
		horariosComConflito: false,
		imagem: $().getUrl()+'/images/semdoc2.png'				
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
				if(this.contModalidadesAquaticas > 0 && $.inArray(mdh_codigo, this.modalidadesAquaticas) != -1){
					this.contModalidadesAquaticas--;
				}
			}
			this.verificaLaudoAquatico();
			this.verificarConflitoHorario();
		},
		carregarModalidades: function(){
			var self = this;
			$().blockScreen("Carregando Dados...");

		    $.get(this.urlModalidades, {id: this.idUsuario}).then((data) => {
		    	self.modalidades = data;
		      	$.each(data, function(id, value){
		      		$('#'+value).attr('checked',true);
				  });
				  self.verificarConflitoHorario();
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
			this.verificaLaudoAquatico();
		},

		verificarConflitoHorario:function(){
			var self = this;
			$.get(this.urlHorarioModalidades, {modalidades: this.modalidades}).then((data) => {
				self.horariosComConflito = data;
				if(data){
					$("#horariovalido").val(value);
				}else{
					$("#horariovalido").val('');
					
				}
			});
		},

		verificaLaudoAquatico:function(){
			var value = this.contModalidadesAquaticas;
	        if((value > 0 && value < 2) && ($('#laudo-dermatologico')[0].defaultValue == undefined || $('#laudo-dermatologico')[0].defaultValue == '')){
	        	$('#foto-laudo-dermatologico')[0].src = this.imagem;
	        	$('#DOC_LAUDO_DERMATO_URL').val('');
	        	$('#DOC_LAUDO_DERMATO_URL_AUX').val('');
			}
			$("#qtdaquatico").val(value);			
			$('#qtdaquatico').trigger('change');
		}
	},
	mounted:function(){
		this.$nextTick(function(){
			this.idUsuario = $('#USU_ID').val();
			this.carregarModalidades();
		});
	}
});