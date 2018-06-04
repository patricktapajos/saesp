var vue2 = new Vue({
	el:'#modal',
	data:{
		modalidades: [],
	},
	methods:{
		adicionarModalidade:function(event){
			if($.inArray(event.target.value, this.modalidades) == -1){
				this.modalidades.push(event.target.value);
			}else{
				this.modalidades.splice(this.modalidades.find(item => item.id === event.target.value), 1);
			}
		},
	},
	mounted: function(){
		/*this.$nextTick(function () {  
			this.verificaRegra();
	  	});*/
	}
});