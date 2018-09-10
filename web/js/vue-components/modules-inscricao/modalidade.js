var vue2 = new Vue({
	el:'#modal',
	data:{
		url: $().getUrl()+'/rest/inscricaomodalidades',
		modalidades: [],
		listagem: ''
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
			$().blockScreen("Carregando Dados...");
		    $.get(this.url).then((data) => {
		    	self.modalidades = data;
		      	$.each(data, function(id, value){
		      		$('#'+value).attr('checked',true);
		      	});
			    $().unblockScreen();
		    }).fail(function(error) {
		    	$().unblockScreen();
			    console.log(error);
			 });
		},

	},
	mounted:function(){
		this.$nextTick(function(){
			this.carregarModalidades();
		});
	}
});