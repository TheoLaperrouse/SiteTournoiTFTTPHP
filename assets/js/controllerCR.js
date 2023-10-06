var controllerCR = {
	currentItem: null,
	Entete: null,
	View:null,
	initialize: function() {
		var that = this ;
		$("<link/>", {rel: "stylesheet", type: "text/css", href: "./../assets/js/jquery-ui.min.css"}).appendTo("head");
		that.View = $("#crView") ;
		that.Entete = $("#enteteCR") ;
		
		$("#retour",that.Entete).off('click').on('click',function(){
			document.location.href = "./admin.html";
		});
		$(".journee",that.View).off('click').on('click',function(){
			var j = $(this).closest(".rowJournee").data("journee") ;
			var actif = $(this).closest(".rowJournee").data("actif") ;
			var locked = $(this).closest(".rowJournee").data("locked") ;
			that.edit(j,actif,locked,$(this).closest(".rowJournee"));
		});
	},
	edit: function(NumJournee,actif,locked,row) {
		var that = this ;
		var form_data = {
			NumJournee: NumJournee,
			mode:'EDIT'
		};
		$.ajax({
			 type: "POST",
			 url: "./../ajax/doCR.php",
			 data: form_data,
			 success: function(data){
				if (data.status == "OK") {
					var btns = {};
					if (locked == 0) {
						btns = $.extend({"Enregistrer": {'function': function() {controllerCR.Save(NumJournee,row);},'menuIcon':'Save'}},btns);
					}
					btns = $.extend({"Fermer": {'function': function() {Dialogs.Remove("dialogCR");},'menuIcon':'Close'}},btns);
					Dialogs.Open("dialogCR",{title:'Edition de la journée n°' + NumJournee,'message':data.html,'btns':btns,fullscreen:true});
					that.initializeEdit();
				} else {
					Messages.AddMessage('Modification du CR',data.message);
				}
			 }
		});
	},
	initializeEdit: function() {
		var that = this ;
		if ($("#CR",$("#dialogCR")).length>0) {
			controllerCR.setTinyMCE("#CR","100%",600,false,true,true) ;
		}
		if ($(".rowChecker.Locked",$("#dialogCR")).hasClass("checked")) {
			
		} else {
			$(".rowChecker",$("#dialogCR")).off('click').on('click',function(){
				if ($(this).hasClass("checked")) {
					$(this).removeClass("checked").removeClass("Active").addClass("InActive") ;
				} else {
					$(this).addClass("checked").addClass("Active").removeClass("InActive") ;
				}
			});
		}
	},
	Save: function(NumJournee,row){
		var that = this ;
		
		var data = [];
		data.push(that);
		data.push(NumJournee);
		data.push(row);
		if ($(".rowChecker.Locked",$("#dialogCR")).hasClass("checked")) {
			Dialogs.Confirm("dialogConfirmation",{title:'Compte-rendu','message':'Voulez-vous réellement verrouiller ce compte-rendu ?.<br/>Aucune modification ne pourra &ecirc;tre apportée ensuite.','callBack' : that.SaveSuite ,'args' : data});	
		} else {
			that.SaveSuite(that,NumJournee,row);
		}
	},
	SaveSuite: function(that,NumJournee,row) {
		var Auteur = $("#Auteur > option:selected",$("#dialogCR")).val();
		var DateMatch = $("#DateMatch",$("#dialogCR")).val();
		var CR = controllerCR.getTinyMCE("#CR",false);
		var Locked = $(".rowChecker.Locked",$("#dialogCR")).hasClass("checked") ? 1 : 0 ;
		var Actif = $(".rowChecker.Actif",$("#dialogCR")).hasClass("checked") ? 1 : 0 ;
		
		var form_data = {
			NumJournee: NumJournee,
			Auteur: Auteur,
			DateMatch: DateMatch,
			CR: CR,
			Locked: Locked,
			Actif: Actif,
			mode:'SAVE'
		};
		$.ajax({
			 type: "POST",
			 url: "./../ajax/doCR.php",
			 data: form_data,
			 success: function(data){
				if (data.status == "OK") {
					Messages.AddMessage('Modification du CR','Modification effectuée');
					Dialogs.Remove("dialogCR");
					document.location.href = './CR.php' ;
				} else {
					Messages.AddMessage('Modification du CR',data.message);
				}
			 }
		});
	}
}
controllerCR.setContentTinyMCE = function(selector,inline,html,isReplace) {
	isReplace = (typeof isReplace != 'undefined') ? isReplace : false ; 
	if (inline) {
		if (isReplace) {
			return $(selector).html(html) ;
		} else {
			var placeholder = $(selector).attr('placeholder') ;
			placeholder = "<div class=\"contentPlaceholder\">" + placeholder + "</div>" ;
			if ($(selector).html() == placeholder) {
				$(selector).html('') ;
			}
			return $(selector).append(html) ;
		}	
			
	} else {
		if (isReplace) {
			return tinyMCE.get(selector.substring(1)).setContent(html) ;
		} else {
			return tinyMCE.get(selector.substring(1)).selection.setContent(html) ;
		}	
	}
}
	
controllerCR.getTinyMCE = function(selector,inline,isRemove) {
	isRemove = (typeof isRemove !== 'undefined') ? isRemove : false ;
	var t = '' ;
	if (inline) {
		try {
			t = prepareTexteSQL($(selector).html()) ;
		} catch(err) {
			//console.log(err.message, $(selector).html());
			t = err.message + ' ' + $(selector).html() ;
		}
	} else {
		t = prepareTexteSQL(tinyMCE.get(selector.substring(1)).getContent()) ;
	}
	if (isRemove) $(selector).tinymce().remove();
	return t ;
}
controllerCR.removeTinyMCE = function(selector) {
	$(selector).tinymce().remove();
}
controllerCR.setTinyMCE = function(selector,w,h,inline,menubar,isSimple,isVerySimple) {
	isVerySimple = (typeof isVerySimple != 'undefined') ? isVerySimple : false ;
	isSimple = (typeof isSimple != 'undefined') ? isSimple : false ;
	w = (typeof w != 'undefined') ? w : 700 ;
	h = (typeof h != 'undefined') ? h : 200 ;
	menubar = (typeof menubar != 'undefined' || isSimple || isVerySimple) ? menubar : true ;
	inline = (typeof inline != 'undefined') ? inline : false ;
	statusbar = (isSimple || isVerySimple) ? false : true ;
	
	var plugs = [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak lineheight plusoptions',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern imagetools codesample importcss verticalspace'
		] ;
	var toolbar1 = 	'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify pagebreak | bullist numlist outdent indent |  plusoptions' ;
	var toolbar2 = 	'fontselect fontsizeselect lineheight verticalspace | print preview media | forecolor backcolor emoticons | link image codesample code' ;
	if (isVerySimple) {
		plugs = [
			'advlist autolink lists link pagebreak emoticons',
			'searchreplace visualchars',
			'nonbreaking directionality',
			'paste textpattern importcss verticalspace'
		] ;
		toolbar1 = 'bold italic alignleft aligncenter bullist emoticons' ;
		toolbar2 = null ;
	} else if (isSimple) {
		plugs = [
			'example advlist autolink lists link image charmap hr anchor pagebreak lineheight plusoptions',
			'searchreplace wordcount visualblocks visualchars code',
			'nonbreaking table contextmenu directionality',
			'paste textcolor colorpicker textpattern importcss verticalspace'
		] ;
		toolbar1 = 'undo redo code | bold italic | alignleft aligncenter alignright alignjustify pagebreak | bullist numlist outdent indent | plusoptions' ;
		toolbar2 = 'styleselect fontselect fontsizeselect lineheight verticalspace | forecolor backcolor | link image' ;
	}	
	try {
		tinymce.remove(selector);
	} catch (e) {
		//console.log(e) ;
	}
	tinymce.init({
		body_class: 'body',
		importcss_append: true,
		  importcss_groups: [
			{title: 'Table styles', filter: /^(table|td|tr)\./}, // td.class and tr.class
			{title: 'Block styles', filter: /^(div|p|ul)\./}, // div.class and p.class and ul.class
			{title: 'Other styles'} // The rest
		  ],
		menubar: menubar,
		forced_root_block : "",
		pagebreak_separator: "##SAUT_PAGE##",
		selector: selector,
		height: h,
		width: w,
		theme: 'modern',
		inline: inline,
		statusbar : statusbar,
		plugins: plugs,
		toolbar1: toolbar1,
		toolbar2: toolbar2,
		fontsize_formats: "7px 8px 9px 10px 11px 12px 14px 18px 24px 36px 48px",
		image_advtab: true,
		setup:function(ed) {
			ed.on('NodeChange', function(e){
			 });
			 ed.on('init', function() {
			});
		}
	});
}