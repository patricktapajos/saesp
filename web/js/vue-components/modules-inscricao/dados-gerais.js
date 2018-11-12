var vue = new Vue({
	el:'#candidato',
	twoWay: true,
	data:{
		show_responsavel: '0',
		show_pcd: '0',
		show_comorbidade: '0',
		show_medicacao: '0',
		imagem: $().getUrl()+'/images/semdoc2.png'
	},
	methods:{
		verificaRegra: function() {
			let comorb = $('#CAND_TEM_COMORBIDADE').val();
	        let medic = $('#CAND_TEM_MEDICACAO').val();
			let pcd = $('#CAND_PCD').val();
			if(comorb == '1'){ this.show_comorbidade = '1'; }
	        if(medic == '1'){ this.show_medicacao = '1'; }
			if(pcd == '1'){ this.show_pcd = '1'; }
			this.verificarIdade();
		},
		
	     calcularIdade: function(){
	    	var partes = $('#USU_DT_NASC').val().split("/");
    		var junta = partes[2]+"-"+partes[1]+"-"+partes[0];
 			var idade = new Date(junta);
		    var d = new Date,
	        ano_atual = d.getFullYear(),
	        mes_atual = d.getMonth() + 1,
	        dia_atual = d.getDate(),

	        ano_aniversario = +idade.getFullYear(),
	        mes_aniversario = +idade.getMonth(),
	        dia_aniversario = +idade.getDate(),

	        quantos_anos = ano_atual - ano_aniversario;

		    if (mes_atual < mes_aniversario || mes_atual == mes_aniversario && dia_atual < dia_aniversario) {
		        quantos_anos--;
		    }
		    return quantos_anos < 0 ? 0 : quantos_anos;
	    },

	    verificarIdade: function(){
			let idade = this.calcularIdade();
			if(!idade) return;
			if(idade < 18){
				this.show_responsavel = '1';
				this.show_idoso = '0';
	        	$('#foto-idoso')[0].src = this.imagem;
	        	$('#DOC_ATESTADO_IDOSO_AUX').val('');
				$('#DOC_ATESTADO_IDOSO').val('');	
				$('#CAND_MENOR_IDADE').val('1');	
				$('#CAND_MENOR_IDADE').trigger('change');

			}else if(idade > 18 && idade <= 50){
				$('#CAND_IDOSO').val('0');
				$('#CAND_MENOR_IDADE').val('0');	
				$('#CAND_NOME_RESPONSAVEL').val('');
				$('#DOC_DECLARACAO_MENOR').val('');	
				$('#DOC_ATESTADO_IDOSO').val('');	
				$('#CAND_IDOSO').trigger('change');
				$('#CAND_MENOR_IDADE').trigger('change');
				this.show_responsavel = '0';
				this.show_idoso = '0'; 
	        	$('#foto-idoso')[0].src = this.imagem;
	        	$('#foto-menor')[0].src = this.imagem;
	        	$('#DOC_DECLARACAO_MENOR_AUX').val('');
	        	$('#DOC_ATESTADO_IDOSO_AUX').val('');

			}else {
				this.show_responsavel = '0';
				$('#foto-menor')[0].src = this.imagem;
				$('#DOC_DECLARACAO_MENOR').val('');	
	        	$('#DOC_DECLARACAO_MENOR_AUX').val('');
				$('#CAND_IDOSO').val('1');
				$('#CAND_IDOSO').trigger('change');		
			}
			
	    }
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
			var self = this;
			$("#USU_DT_NASC").change(function(){
				self.verificarIdade();
			});
		});
	},
	watch: {
		show_comorbidade: function(value){
	        $('#CAND_TEM_COMORBIDADE').val(value);
	        if(value == '0'){
	        	$('#CAND_COMORBIDADE_DESC').val('');
			}
		},

		show_medicacao: function(value){
	        $('#CAND_TEM_MEDICACAO').val(value);
	        if(value == '0'){
	        	$('#CAND_MEDICACAO_DESC').val('');
			}
		},
		show_pcd: function(value){
	        $('#CAND_PCD').val(value);
	        if(value == '0'){
	        	$('#foto-laudo-pcd')[0].src = this.imagem;
	        	$('#DOC_LAUDO_PCD_URL').val('');
	        	$('#DOC_LAUDO_PCD_URL_AUX').val('');
	        	$('#DOC_LAUDO_PCD_URL_AUX').trigger('change');
	        	$('#CAND_PCD_DESC').val('');
			}
		}
	}
});