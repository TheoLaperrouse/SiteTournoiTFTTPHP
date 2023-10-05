var controllerAdmin = {
	currentItem: null,
	Entete: null,
	View:null,
	initialize: function() {
		var that = this ;
		$("<link/>", {rel: "stylesheet", type: "text/css", href: "./../assets/js/jquery-ui.min.css"}).appendTo("head");
		that.View = $("#adminView") ;
		that.Entete = $("#enteteAdmin") ;
		
		$("#accueil",that.Entete).off('click').on('click',function(){
			document.location.href = "../index.php";
		});
		$(".nav",that.View).off('click').on('click',function(){
			var link = $(this).data("nav") ;
			document.location.href = link;
		});
	}
}