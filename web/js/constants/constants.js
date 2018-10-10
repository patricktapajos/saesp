/*!
 * Created by Patrick Tapajós - patrick.tapajos@pmm.am.gov.br
 * Date: 08/05/2017
 * Description: File with a function for SGM to set url by hostname to be consumed in vue components
 */

let nome_sistema = "saesp";

(function ($) {
	$.fn.getUrl = function(){
	
	    var url = document.location.hostname;

	    if(nome_sistema.indexOf(url) != -1){
	        url = "http://"+url;
	    }
	    else if("chibarro.manaus.am.gov.br".indexOf(url) != -1){
	        url = "http://"+url+"/saesp/web";
	    }
	    else{
	        url ="http://"+url;   
	    }
	    return url;
	};

	$.fn.blockScreen = function($text){
		 $.blockUI({
	           'message':'<br><img width="20%"/><h4>'+$text+'</h4><img src="/js/constants/images/reload.gif" /><br>',
	            css: {
	                border: 'none',
	                padding: '15px',
	                backgroundColor: '#000',
	                '-webkit-border-radius': '10px',
	                '-moz-border-radius': '10px',
	                opacity: .8,
	                color: '#fff'
	        	} 
	    });
	};

	$.fn.unblockScreen = function(){
		setTimeout($.unblockUI, 1000);
	};

	$.fn.fullScreen = function(){
	    $('.ui-expandable').toggleClass('fullscreen'); 
	    $('.wrapper').toggleClass('expanded'); 
	};

}(jQuery));

