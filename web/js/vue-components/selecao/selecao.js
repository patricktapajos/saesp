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
	        }else{
	        	this.show_data_inscricao = false;
	        }
	    },
	},
	mounted: function(){
		this.$nextTick(function () {  
			this.verificaSituacao();
	  	});
	},
	/*watch: {
		situacao: function(currentValue){
			if(currentValue == 'INSCRICOES_ABERTAS'){
				this.show_data_inscricao = true;
			}else{
				this.show_data_inscricao = false;
			}
		}
	}*/
});