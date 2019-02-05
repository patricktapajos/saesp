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
        },
        configFotoListener: function(){
	    	$(".urlfoto").on('change', function(f){
	    		var input = $(this)[0];
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#foto-"+input.id)[0].src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
			});
	    }
    },
    mounted: function(){
		this.$nextTick(function () { 
            this.verificarPermissao();
            this.configFotoListener();
	  	});
	},
});