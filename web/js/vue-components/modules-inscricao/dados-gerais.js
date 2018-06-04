var vue = new Vue({
	el:'#candidato',
	data:{
		show_responsavel: '',
		show_pcd: '',
		show_comorbidade: '',
		show_medicacao: '',
	},
	methods:{
		verificaRegra: function() {
	        let menor = $('#menor').val();
	        if(menor == 1){
	        	this.show_responsavel = 1;
	        }
	    },
	},
	mounted: function(){
		this.$nextTick(function () {  
			this.verificaRegra();
	  	});
	},
	/*watch:*/

});