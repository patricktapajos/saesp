var vue2 = new Vue({
	el:'#modal',
	data:{
		modalidades: [],
	},
	methods:{
		adicionarModalidade:function(value){
			if($.inArray(value, this.modalidades) == -1){
				this.modalidades.push(value);
			}else{
				this.modalidades.splice($.inArray(value, this.modalidades), 1);
			}
		},
		carregarModalidades: function(){
			var self = this;
			$().blockScreen("Carregando Modalidades");
			const url = '/../rest/inscricaomodalidades';
		    $.get(url).then((data) => {
		      	this.modalidades = data;
		      	console.log(data);
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