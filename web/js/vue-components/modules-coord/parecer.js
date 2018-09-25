var vue2 = new Vue({
	el:'#parecer',
	data:{
		url: $().getUrl()+'/rest/inscricaomodalidades',
		modalidades: [],
	},
	methods:{
		adicionarModalidade:function(mdh_codigo){
			if($.inArray(mdh_codigo, this.modalidades) == -1){
				this.modalidades.push(mdh_codigo);
			}else{
				this.modalidades.splice($.inArray(mdh_codigo, this.modalidades),1);
			}
		},
		carregarModalidades: function(){
			var self = this;
			$.each($('.modclass'), function(){
                var val = $(this).val();
                self.modalidades.push(val);
                $(this).prop('checked', true);
            });
		},
	},
	mounted:function(){
		this.$nextTick(function(){
			if ( !$("input[type='radio']:checked").val()){
				$('#divObs').hide();
			}else{
				$('#INS_SITUACAO :radio').trigger('change');
			}
            this.carregarModalidades();
            $('#INS_SITUACAO :radio').change(function(){
				var valor = $(this).val();
                if(valor == 'INDEFERIDA'){
                	$('#divObs').show();
                }else{
					$('#divObs').hide();
				}
			});
		});
	}
});