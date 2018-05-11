/*!
 * Created by Patrick Tapajós - patrick.tapajos@pmm.am.gov.br
 * Date: 10/05/2018
 * Description: File with a function for SAESP to set url by hostname to be consumed in vue components
 */

let nome_sistema = "saesp";

(function ($) {
	$.fn.getUrl = function(){
	
	    var url = document.location.hostname;

	    if(nome_sistema.indexOf(url) != -1){
	        url = "http://"+url;
	    }
	    else if("surubiu.manaus.am.gov.br".indexOf(url) != -1){
	        url = "http://"+url+"/saesp";
	    }
	    else{
	        url ="http://"+url;   
	    }
	    return url;
	};

	$.fn.blockScreen = function($text){
		 $.blockUI({
	           'message':'<br><img width="20%"/><h4>'+$text+'</h4><img src="'+$().getUrl()+'/js/constants/images/reload.gif" /><br>',
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

}(jQuery));