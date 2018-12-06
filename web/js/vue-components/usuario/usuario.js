var vue = new Vue({
	el:'#usuario',
	data:{
        estagiario: false
    },
    methods: {
        verificarPermissao: function(){
            var permissao = $('#USU_PERMISSAO').val() 
            if(permissao == 'ESTAGIARIO'){
                this.estagiario = true
            }else{
                this.estagiario = false                
            }
        }
    },
    mounted: function(){
		this.$nextTick(function () { 
            var permissao = $('#USU_PERMISSAO').val() 
            if(permissao == 'ESTAGIARIO'){
                this.estagiario = true
            }else{
                this.estagiario = false                
            }
	  	});
	},
});