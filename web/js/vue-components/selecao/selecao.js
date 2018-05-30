var vue = new Vue({
	el:'#selecao',
	data:{
		situacao: '',
		show_data_inscricao: false,
	},
	methods:{
		verificaSituacao: function() {
	        let sit = $('#situacao').val();
	        if(sit == 'INSCRICOES_ABERTAS'){
	        	this.show_data_inscricao = true;
	        }else if(sit == 'CADASTRADO'){
	        	this.show_data_inscricao = false;
	        	$('#sel_dt_inicio').val('');
	        	$('#sel_dt_fim').val('');
	        }else{
	        	this.show_data_inscricao = false;
	        }
	    },

	    atualizarData: function(){
	    	setTimeout(()=>{
	    		var date2 = jQuery("#sel_dt_inicio").datepicker("getDate");
		    	jQuery("#sel_dt_fim").datepicker("option", "minDate", date2);
	    	},500);
	    },
	},
	mounted: function(){
		this.$nextTick(function () {  
			this.verificaSituacao();
			this.atualizarData();
	  	});
	},
});