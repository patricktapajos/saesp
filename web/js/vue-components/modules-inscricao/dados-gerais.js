var vue = new Vue({
	el:'#candidato',
	twoWay: true,
	data:{
		show_responsavel: '',
		show_pcd: '',
		show_comorbidade: '',
		show_medicacao: '',
	},
	methods:{
		verificaRegra: function() {
	        let comorb = $('#CAND_TEM_COMORBIDADE').val();
	        let medic = $('#CAND_TEM_MEDICACAO').val();
	        let menor = $('#CAND_MENOR_IDADE').val();
	        let pcd = $('#CAND_PCD').val();
	        if(comorb == 'SIM'){ this.show_comorbidade = 'SIM'; }
	        if(medic == 'SIM'){ this.show_medicacao = 'SIM'; }
	        if(menor == 'SIM'){ this.show_responsavel = 'SIM'; }
	        if(pcd == 'SIM'){ this.show_pcd = 'SIM'; }
	    },
	},
	mounted: function(){
		this.$nextTick(function () {  
			this.verificaRegra();

			$("#urlfoto").on('change', function(){
			    var reader = new FileReader();
			    reader.onload = function (e) {
			        $("#foto-candidato")[0].src = e.target.result;
			    };
			    reader.readAsDataURL(this.files[0]);
			});
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
		}
	}
});