var vue3 = new Vue({
	el:'#documentacao',
	twoWay: true,
	data:{
		show_responsavel: '0',
		show_pcd: '0',
		show_comorbidade: '0',
		show_medicacao: '0',
		show_idoso: '0',
		imagempdf: '/images/pdf.png'
	},
	methods:{
		verificaRegra: function() {
	        let comorb = $('#CAND_TEM_COMORBIDADE').val();
	        let medic = $('#CAND_TEM_MEDICACAO').val();
	        let menor = $('#CAND_MENOR_IDADE').val();
	        let idoso = $('#CAND_IDOSO').val();
	        let pcd = $('#CAND_PCD').val();
	        if(comorb == '1'){ this.show_comorbidade = '1'; }
	        if(medic == '1'){ this.show_medicacao = '1'; }
	        if(menor == '1'){ this.show_responsavel = '1'; }
	        if(idoso == '1'){ this.show_idoso = '1'; }
	        if(pcd == '1'){ this.show_pcd = '1'; }
	    },

	    configCheckListener(){
	    	
	    	var self = this;
			$('#pcd-checkbox').change(function(){
				self.show_pcd = $(this)[0].checked?'1':'0';
			});
			$('#CAND_MENOR_IDADE').change(function(){
				self.show_responsavel = $(this).val();
			});

			$('#CAND_IDOSO').change(function(){
				self.show_idoso = $(this).val();
			});

			$('#medicamento-checkbox').change(function(){
				self.show_medicacao = $(this)[0].checked?'1':'0';
			});

			$('#comorbidade-checkbox').change(function(){
				self.show_comorbidade = $(this)[0].checked?'1':'0';
			});
	    },

	    configFotoListener(){
	    	var self = this;
	    	$(".urlfoto").on('change', function(f){
	    		var input = $(this)[0];
	    		if(f.target.files[0].type == 'application/pdf'){
		        	$("#foto-"+input.id)[0].src = self.imagempdf;
		        }else{
		        	var reader = new FileReader();
				    reader.onload = function (e) {
							$("#foto-"+input.id)[0].src = e.target.result;
				    };
				    reader.readAsDataURL(this.files[0]);
		        }
			});
	    }

	},
	mounted: function(){
		var self = this;
		this.$nextTick(function () {  
			this.verificaRegra();
			this.configCheckListener();
			this.configFotoListener();
		});
	},
	watch: {
		show_comorbidade: function(value){
	        	$('#CAND_TEM_COMORBIDADE').val(value);
		},
		show_medicacao: function(value){
	        	$('#CAND_TEM_MEDICACAO').val(value);
		},
		show_responsavel: function(value){
	        	$('#CAND_MENOR_IDADE').val(value);
		},
		show_pcd: function(value){
	        	$('#CAND_PCD').val(value);
		},
	}
});