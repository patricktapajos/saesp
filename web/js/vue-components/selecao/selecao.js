var vue = new Vue({
	el:'#selecao',
	data:{
		show_data_inscricao: false,
	},
	methods:{
		setSituacao:function(){
			let sit = $("input[type='radio']:checked").val();
			if(sit){
				$("#SEL_SITUACAO").val(sit);
				if(sit == 'INSCRICOES_ABERTAS'){
					this.show_data_inscricao = true;
				}else {
					this.show_data_inscricao = false;
				}
			}
		},
	    atualizarDataInscricao: function(){	
			var self = this;
			var dateFormat = "dd/mm/yy";
			$("#sel_dt_inicio").on("change", function() {
				$("#sel_dt_fim").datepicker("option", "minDate", self.getDate(dateFormat, this));
			});
		},

		atualizarDataCadastro: function(){
			var self = this;
			var dateFormat = "dd/mm/yy";
			$("#sel_dt_inicio_cad").on("change", function() {
				$("#sel_dt_fim_cad").datepicker("option", "minDate", self.getDate(dateFormat, this));
			});
		},

		getDate: function(dateFormat, element) {
			var date;
			try {
				date = $.datepicker.parseDate(dateFormat, element.value);
			} catch (error) {
				date = null;
			}
	
			return date;
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