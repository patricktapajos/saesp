var vue = new Vue({
	el:'#selecao',
	data:{
		situacao: '',
		show_data_inscricao: false,
		show_data_cadastro: false,
	},
	methods:{
		verificaSituacao: function() {
	        let sit = $('#situacao').val();
	        if(sit == 'INSCRICOES_ABERTAS'){
				this.show_data_inscricao = true;
	        	this.show_data_cadastro = false;				
				$('#sel_dt_inicio_cad').val('');
	        	$('#sel_dt_fim_cad').val('');
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
	    	setTimeout(()=>{
	    		var date2 = jQuery("#sel_dt_inicio").datepicker("getDate");
		    	jQuery("#sel_dt_fim").datepicker("option", "minDate", date2);
	    	},500);
		},
		atualizarDataCadastro: function(){
	    	setTimeout(()=>{
	    		var date2 = jQuery("#sel_dt_inicio_cad").datepicker("getDate");
		    	jQuery("#sel_dt_fim_cad").datepicker("option", "minDate", date2);
	    	},500);
	    },
	},
	mounted: function(){
		this.$nextTick(function () {  
			this.verificaSituacao();
			this.atualizarDataInscricao();
			this.atualizarDataCadastro();
	  	});
	},
});