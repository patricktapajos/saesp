var vue = new Vue({
	el:'#selecao',
	data:{
		situacao: '',
		show_data_inscricao: false,
		show_data_cadastro: false,
	},
	methods:{
		setSituacao:function(){
			let sit = $("input[type='radio']:checked").val();
			$("#SEL_SITUACAO").val(sit);
			this.situacao = sit;
			if(sit == 'INSCRICOES_ABERTAS'){
				this.show_data_inscricao = true;
				this.show_data_cadastro = false;				
			}else if(sit == 'CADASTRADO'){
				this.show_data_inscricao = false;
				this.show_data_cadastro = true;
				$('#sel_dt_inicio').val('');
				$('#sel_dt_fim').val('');
			}else{
				this.show_data_inscricao = false;
				this.show_data_cadastro = false;				
			}
		},
	    atualizarDataInscricao: function(){
			var date2 = jQuery("#sel_dt_inicio").datepicker("getDate");
			jQuery("#sel_dt_fim").datepicker("option", "minDate", date2);
		},
		atualizarDataCadastro: function(){
			var date2 = jQuery("#sel_dt_inicio_cad").datepicker("getDate");
			jQuery("#sel_dt_fim_cad").datepicker("option", "minDate", date2);
		},

		verificarRadioHabilitado(){
			let radioInscricao = $("#inscricao").val();
			if(!radioInscricao || radioInscricao === null){
				$('.inscricao :radio').parent().parent().removeAttr('data-toggle');
				$.each($('.inscricao :radio'), function(){
					$(this).attr('disabled',true);
				});
			}

			let radioParecer = $("#parecer").val();
			if(!radioParecer || radioParecer === null){
				$('.parecer :radio').parent().parent().removeAttr('data-toggle');
				$.each($('.parecer :radio'), function(){
					$(this).attr('disabled',true);
				});
			}

			let radioEncerrar = $("#encerrar").val();
			if(!radioEncerrar || radioEncerrar === null){
				$('.encerrar :radio').parent().parent().removeAttr('data-toggle');
				$.each($('.encerrar :radio'), function(){
					$(this).attr('disabled',true);
				});
			}
		}
	},
	mounted: function(){
		this.$nextTick(function () {  
			var self = this;
			setTimeout(function(){
				self.setSituacao();
				self.atualizarDataInscricao();
				self.atualizarDataCadastro();
				self.verificarRadioHabilitado();
			},500);	 


			
	  	});
	},
});