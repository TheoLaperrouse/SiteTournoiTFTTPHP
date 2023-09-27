var Messages = {
	isBlockOpen : false,
	isBlockOnOpen : false,
	pileNotif : [],
	timerId: null,
	blockActualites : function() {
		var that = this;
		$("#galleryActualite",$("#actualites")).show() ;
		$("#galleryActualitePJ",$("#actualites")).show() ;
		$("#myActuToolbar").show();
		$(".editMode",$("#actualites")).show() ;
		$("#divComposeActu",$("#actualites")).hide() ;
		that.showBlockAround($("#actualites"));
		$(".blockDiv").off('click');
		$(".blockDiv").on('click',function(){
			that.unblockActualites();
		});
	},
	unblockActualites : function() {
		var that = this;
		that.hideBlockAround();
		$(".editMode",$("#actualites")).hide() ;
		$("#myActuToolbar").hide();
		$("#divComposeActu",$("#actualites")).show() ;
		$("#galleryActualite",$("#actualites")).hide() ;
		$("#galleryActualitePJ",$("#actualites")).hide() ;
		$("#divAddActu",$("#actualites")).hide() ;
	},
	showBlockAround : function($el) {
		var that = this ;
		if (!that.isBlockOpen) {
			$(".blockDiv").remove() ;
			$("body").addClass("dialog-open") ;
		}
		var p = $el.offset() ;
		var w = $el.width(); 
		var h = $el.height(); 
		//var wMain = $('body').width();
		//var hMain = $('body').height();
		var wMain = $(window).innerWidth();
		var hMain = $(window).innerHeight();
		var hMenu = $("#myActuToolbar").height() ;
		
		$el.css("max-height",Math.floor(hMain-2*p.top).toString() + "px") ;
		
		if (!that.isBlockOpen) {
			$("#myActuToolbar").css("top", p.top - hMenu).css("left",p.left).css("zIndex", 65000) ;
			$("body").append("<div class='blockDiv topDiv' style='left:0;top:0;height:"+p.top+"px;width:"+wMain+"px;'></div>") ;
			$("body").append("<div class='blockDiv leftDiv' style='left:0;top:"+p.top+"px;height:"+(hMain-p.top)+"px;width:"+p.left+"px;'></div>") ;
			$("body").append("<div class='blockDiv rightDiv' style='left:"+(p.left+w)+"px;top:"+p.top+"px;height:"+(hMain-p.top)+"px;width:"+(wMain-p.left-w)+"px;'></div>") ;
			$("body").append("<div class='blockDiv bottomDiv' style='left:"+(p.left)+"px;top:"+(p.top+h)+"px;height:"+(hMain-p.top-h)+"px;width:"+w+"px;'></div>") ;
			$(".blockDiv").css("opacity",0).fadeTo( "fast" , 0.2, function() {
					// Animation complete.
					//console.log("fade over") ;
			});
		} else {
			$(".blockDiv.topDiv").css("height",p.top+"px").css("width",wMain+"px");
			$(".blockDiv.leftDiv").css("top",p.top+"px").css("width",p.left+"px").css("height",(hMain-p.top)+"px");
			$(".blockDiv.rightDiv").css("left",(p.left+w)+"px").css("top",p.top+"px").css("width",(wMain-p.left-w)+"px").css("height",(hMain-p.top)+"px");
			$(".blockDiv.bottomDiv").css("left",(p.left)+"px").css("top",(p.top+h)+"px").css("width",w+"px").css("height",(hMain-p.top-h)+"px");
		}
		that.isBlockOpen = true ;
	},
	updateBlockAround : function($el) {
		var that = this ;
		if (!that.isBlockOpen) return ;
		
		var p = $el.offset() ;
		var w = $el.width(); 
		var h = $el.height(); 
		//var wMain = $('body').width();
		//var hMain = $('body').height();
		var wMain = $(window).innerWidth();
		var hMain = $(window).innerHeight();
		
		$(".blockDiv.bottomDiv").css("top",(p.top+h)+"px").css("height",(hMain-p.top-h)+"px")
	},
	hideBlockAround : function() {
		var that = this ;
		if (!that.isBlockOpen) return ;
		var that = this ;
		$("body").removeClass("dialog-open") ;
		$(".blockDiv").off('click') ;
		$(".blockDiv").remove() ;
		that.isBlockOpen = false ;
	},
	showBlockOn : function($el,opacity,zIndex) {
		opacity = (typeof opacity != 'undefined') ? opacity : 0.2 ;
		zIndex = (typeof zIndex != 'undefined') ? zIndex : 10 ;
		var that = this ;
		if (!that.isBlockOnOpen) {
			$(".blockDiv.onDiv:not(.nDiv)").remove() ;
		}
		var p = $el.offset() ;
		var w = $el.width(); 
		var h = $el.height(); 
		
		if (!that.isBlockOnOpen) {
			$("body").append("<div class='blockDiv onDiv' style='left:"+p.left+"px;top:"+p.top+"px;height:"+h+"px;width:"+w+"px;z-index:"+zIndex+";'></div>") ;
			var styleAnim = "height: 40px;width: 40px;animation-duration: 1s;animation-fill-mode: both;animation-iteration-count: infinite;animation-name: spin;animation-timing-function: linear;" ;
			styleAnim += "border-radius: 100%;border-style: solid;border-width: 4px;box-shadow: 0 0 40px 0 #fff;content: '';border-color: rgba(0,182,186,100) white white;" ;
			styleAnim += "left: calc(50% - 20px);top: calc(50% - 20px);position: relative;z-index: 11001;" ;
			$(".blockDiv.onDiv:not(.nDiv)").append('<div style="'+styleAnim+'"></div>') ;
			$(".blockDiv.onDiv:not(.nDiv)").css("opacity",0).fadeTo( "fast" , opacity, function() {
					// Animation complete.
					//console.log("fade over") ;
			});
			
		} else {
			$(".blockDiv.onDiv:not(.nDiv)").css("left",p.left+"px").css("top",p.top+"px").css("width",w+"px").css("height",h+"px");
		}
		that.isBlockOnOpen = true ;
	},
	hideBlockOn : function() {
		var that = this ;
		if (!that.isBlockOnOpen) return ;
		var that = this ;
		$(".blockDiv.onDiv:not(.nDiv)").remove() ;
		that.isBlockOnOpen = false ;
	},
	showBlockOnN : function(n,$el,opacity,zIndex) {
		opacity = (typeof opacity != 'undefined') ? opacity : 0.2 ;
		zIndex = (typeof zIndex != 'undefined') ? zIndex : 10 ;
		var that = this ;
		if ($("#blockOnDiv" + n.toString()).length>0) {
			$("#blockOnDiv" + n.toString()).remove() ;
		}
		var p = $el.offset() ;
		var w = $el.width(); 
		var h = $el.height(); 
		
		if ($("#blockOnDiv" + n.toString()).length == 0) {
			$("body").append("<div id='blockOnDiv" + n.toString()+"' class='blockDiv onDiv nDiv' style='left:"+p.left+"px;top:"+p.top+"px;height:"+h+"px;width:"+w+"px;z-index:"+zIndex+";'></div>") ;
			var styleAnim = "height: 40px;width: 40px;animation-duration: 1s;animation-fill-mode: both;animation-iteration-count: infinite;animation-name: spin;animation-timing-function: linear;" ;
			styleAnim += "border-radius: 100%;border-style: solid;border-width: 4px;box-shadow: 0 0 40px 0 #fff;content: '';border-color: rgba(0,182,186,100) white white;" ;
			styleAnim += "left: calc(50% - 20px);top: calc(50% - 20px);position: relative;z-index: 11001;" ;
			$("#blockOnDiv" + n.toString()).append('<div style="'+styleAnim+'"></div>') ;
			$("#blockOnDiv" + n.toString()).css("opacity",0).fadeTo( "fast" , opacity, function() {
					// Animation complete.
					//console.log("fade over") ;
			});
			
		} else {
			$("#blockOnDiv" + n.toString()).css("left",p.left+"px").css("top",p.top+"px").css("width",w+"px").css("height",h+"px");
		}
		that.isBlockOnOpen = true ;
	},
	hideBlockOnN : function(n) {
		var that = this ;
		if ($("#blockOnDiv" + n.toString()).length == 0) return ;
		var that = this ;
		$("#blockOnDiv" + n.toString()).remove() ;
	},
	showBlockDiv : function(zIndex) {
		var z = (typeof zIndex != 'undefined') ? zIndex : 10 ;
		if($("#blockDiv").length >0) return ;
		$("body").append("<div id='blockDiv'></div>") ;
		$("#blockDiv").css("z-index",zIndex);
	},
	hideBlockDiv : function() {
		$("#blockDiv").remove() ;
	},
	showBlockDiv2 : function(zIndex) {
		var z = (typeof zIndex != 'undefined') ? zIndex : 1004 ;
		if($("#blockDiv2").length >0) return ;
		$("body").append("<div id='blockDiv2'></div>") ;
		$("#blockDiv2").css("z-index",zIndex);
	},
	hideBlockDiv2 : function() {
		$("#blockDiv2").remove() ;
	},
	showBlockDivn : function(n,zIndex,opacity,appendTo) {
		var a = (typeof appendTo != 'undefined') ? appendTo : 'body' ;
		var z = (typeof zIndex != 'undefined') ? zIndex : 10 ;
		opacity = (typeof opacity != 'undefined') ? opacity : 0.2 ;
		if($("#blockDiv" + n.toString()).length >0) return ;
		$(a).append("<div id='blockDiv" + n.toString() + "' class='blockDiv'></div>") ;
		$("#blockDiv" + n.toString()).css("z-index",zIndex).css("opacity",0);
		$("#blockDiv" + n.toString()).fadeTo( "slow" , opacity, function() {
			// Animation complete.
		  });
	},
	hideBlockDivn : function(n) {
		$("#blockDiv" + n.toString()).remove() ;
	},
	AddMessageWait: function(type,msg,modal,decaleIndex,nbSecondesMax,callbackSafe) {
		if ($("#mesMessages").length == 0) {
			$('body').append('<div id="mesMessages" class="vignetteMessage MyDialog"><div class="vignetteMessageTitle"><div class="mapspinner" style="float:left;"></div> Traitement en cours ...</div><div id="msgBox" class="vignetteMessagecontent"></div></div>');
		}
		modal = (typeof modal != 'undefined') ? modal : false ;
		decaleIndex = (typeof decaleIndex != 'undefined') ? decaleIndex : 0 ;
		nbSecondesMax = (typeof nbSecondesMax != 'undefined') ? 1000*nbSecondesMax : 20000 ;
		var maxzIndex = Dialogs.getFreeN() + decaleIndex;
		
		if (modal) {
			Messages.showBlockDivn("WAIT",maxzIndex);
		}
		
		$("#mesMessages").css("z-index",maxzIndex+1).show();
		
		//Timeout
		if (Messages.timerId != null) clearTimeout(Messages.timerId) ;
		Messages.timerId = setTimeout(function(maConv) {
			var msgAdd = "<br/><br/><div style='color:#117176;font-style:italic;font-weight:700;'>La proc&eacute;dure prend plus de temps que pr&eacute;vu, si vous pensez qu'il s'agit d'un bug, vous pouvez contacter le service informatique<br/>Avant de relancer l'action, v&eacute;rifiez qu'elle ne s'est pas d&eacute;roul&eacute;e correctement en rafraichissant l'onglet</div>" ;
			msgAdd += "<div id='closeMessageWait' class='btnValide'><i class='menuIcon menuIconClose'></i> Fermer la fen&ecirc;tre</div>" ;
			$(".msg"+type,$("#mesMessages")).append(msgAdd);
			$("#closeMessageWait",$(".msg"+type,$("#mesMessages"))).off('click').on('click',function(){
				if (typeof callbackSafe == 'function') {
					callbackSafe();
				}
				Messages.RemoveMessageWait(type,modal);
			});
		},nbSecondesMax);

		if ($(".msg"+type,$("#mesMessages")).length == 0) {
			$('#msgBox',$("#mesMessages")).append('<div class="msg'+type+'" style="text-align:center;clear:both;"></div>');
		}
		$(".msg"+type,$("#mesMessages")).html(msg);
	},
	RemoveMessageWait: function(type,modal) {
		//return;
		modal = (typeof modal != 'undefined') ? modal : false ;
		if (modal) {
			Messages.hideBlockDivn("WAIT");
		}
		if (Messages.timerId != null) clearTimeout(Messages.timerId) ;
		if ($(".msg"+type,$("#mesMessages")).length > 0) {
			if ($("div",$("#msgBox",$("#mesMessages"))).length == 1) {
				$(".mapspinner",$("#mesMessages")).remove();
			}
			$(".msg"+type,$("#mesMessages")).fadeToggle( "slow", "linear", function() {
				// Animation complete.
				$( this ).remove();
				if ($("div",$("#msgBox",$("#mesMessages"))).length == 0) {
					$("#mesMessages").fadeOut( "slow", function() {
						// Animation complete.
						$( this ).remove();
					});
				}
			});
		}
	},
	AddMessage: function(title,message,callBack,n,zIndex,opacity,appendTo,btns,id,isFullScreen) {
			id = (typeof id != 'undefined' && id != null) ? id : 'vignetteMessage' ;
			isFullScreen = (typeof isFullScreen != 'undefined') ? isFullScreen : false ;
			appendTo = (typeof appendTo != 'undefined' && appendTo != null) ? appendTo : 'body' ;
			
			var maxzIndex = Dialogs.getFreeN() ;
			zIndex = (typeof zIndex != 'undefined' && zIndex != null) ? zIndex : 91 ;
			if (zIndex<maxzIndex) zIndex = maxzIndex ;
			
			n = (typeof n != 'undefined' && n != null) ? n : 99 ;
			opacity = (typeof opacity != 'undefined' && opacity != null) ? opacity : 0.1 ;
			
			var that = this ;
			that.showBlockDivn(n,zIndex,opacity,appendTo) ;
			$("#"+id).remove();
			if ($("#"+id).length == 0) {
				$(appendTo).append('<div id="'+id+'" class="vignetteMessage MyDialog"><div class="closeBlock fa fa-window-close" title="Fermer"></div><div class="vignetteMessageTitle"></div><div class="vignetteMessagecontent"></div></div>'); 
			} else {
				$("#"+id).appendTo(appendTo) ;
			}
			if (isFullScreen && !$("#"+id).hasClass("fullscreenDialog")) $("#"+id).addClass("fullscreenDialog") ; 
			$("#"+id).css("z-index",zIndex).css("opacity",0);
			$("#"+id).fadeTo( "slow" , 1, function() {
				// Animation complete.
			});
			
			$("#"+id+" > .vignetteMessageTitle").html(title);
			$("#"+id+" > .vignetteMessagecontent").html(message);
			
			Messages.SetButtons(id,btns,isFullScreen);
			
			var $div = $("#"+id) ;
	
			$div.fadeIn("fast", function() {
				if (isFullScreen) {
					var h = $(window).innerHeight() ;
					var htitle = $("#"+id+" > .vignetteMessageTitle").height() ;
					if ($("#"+id+" > .vignetteBtns").length > 0) {
						htitle += $("#"+id+" > .vignetteBtns").height() ;
					}
					$("#"+id+" > .vignetteMessagecontent").css("height",(h-htitle-40)+"px");
				} else {
					var w = $("#"+id+" > .vignetteMessagecontent").width() + 30 ;
					$("#"+id).css("width",w) ;
					var w2 = $(window).innerWidth() ;
					$("#"+id+" > .vignetteMessagecontent").css("max-width",w2) ;
					$("#"+id).css("max-width",w2) ;
				}
				
				$(".closeBlock",$div).off("click");
				
				$(".closeBlock",$div).on("click",function() {
					that.CloseMessage(n,id);
					if (typeof callBack != 'undefined' && callBack != null) {
						callBack();
					}
					if (Dialogs.ExisteById(id)) {
						Dialogs.Remove(id);
					}
				});
			});
	},
	ResizeDialog : function(id,btns,isFullScreen) {
		var that = this ;
		isFullScreen = (typeof isFullScreen != 'undefined') ? isFullScreen : false ;
		//if ($("#"+id).is(":visible")) return false ;
		
		if (typeof btns != 'undefined' && btns != null) {
			var nbBouton = 0 ;
			for (var bt in btns) {
				nbBouton += 1 ;
			}
			var clItem = "" ;
			clItem = (nbBouton>6 && nbBouton<9) ? " small" : "" ;
			clItem = (nbBouton>8) ? " smallsmall" : "" ;
			if ($(window).innerHeight()<600 || $(window).innerWidth()<800) {
				if ( nbBouton<9) {
					clItem = "small";
				} else {
					clItem = "smallsmall";
				}
			}
			if ($(window).innerHeight()<400 || $(window).innerWidth()<400) {
				clItem = "smallsmall";
			}
			$("#"+id+" > .vignetteBtns > .vignetteMessageBtn").removeClass("small").removeClass("smallsmall").addClass(clItem);
		}
		
		var titleH = ($("#"+id+" > .vignetteMessageTitle").length>0) ? Math.round($("#"+id+" > .vignetteMessageTitle").height()) : 0 ;
		var contentH = ($("#"+id+" > .vignetteMessagecontent").length>0) ? Math.round($("#"+id+" > .vignetteMessagecontent").height()) : 0 ;
		var totalH = Math.round($("#"+id).height());
		var btnH = Math.round(totalH - contentH - titleH) ;
		var h = ($(window).innerHeight()<600) ? Math.round($(window).innerHeight() - btnH - titleH) : Math.round($(window).innerHeight() - btnH - titleH -20) ;
		var w = ($(window).innerWidth()<800) ? $(window).innerWidth(): $(window).innerWidth() ;
		
		//var wall = Math.round($("#"+id).width()) ;
		if (isFullScreen) {
			var h = $(window).innerHeight() ;
			var htitle = $("#"+id+" > .vignetteMessageTitle").height() ;
			if ($("#"+id+" > .vignetteBtns").length > 0) {
				htitle += $("#"+id+" > .vignetteBtns").height() ;
			}
			$("#"+id+" > .vignetteMessagecontent").css("height",(h-htitle-40)+"px");
		} else {
			//console.log('ResizeDialog',h);
			$("#"+id+" > .vignetteMessagecontent").css("max-height",h).css("max-width",w) ;
			$("#"+id).css("max-width",w) ;
		}
		return true ;
	},
	SetButtons: function(id,btns,isFullScreen) {
			if ($("#"+id+" > .vignetteBtns").length > 0) {
				$("#"+id+" > .vignetteBtns > .vignetteMessageBtn").off('mouseenter');
				$("#"+id+" > .vignetteBtns > .vignetteMessageBtn").off('mouseout');
				$("#"+id+" > .vignetteBtns > .vignetteMessageBtn").off('click');
				$("#"+id+" > .vignetteBtns").remove();
			}
			if (typeof btns != 'undefined' && btns != null) {
				var nbBouton = 0 ;
				for (var bt in btns) {
					nbBouton += 1 ;
				}
				var clItem = "vignetteMessageBtn btnWindow" ;
				clItem += (nbBouton>6 && nbBouton<9) ? " small" : "" ;
				clItem += (nbBouton>8) ? " smallsmall" : "" ;
				
				if ($("#"+id+" > .vignetteBtns").length == 0) {
					$("#"+id).append('<div class="vignetteBtns"></div>'); 
				}
			
				for (var bt in btns) {
					var before = '' ;
					var libelle = bt ; 
					var btnId = '' ;
					if (typeof btns[bt] == 'object') {
						var a = btns[bt] ;
						if (typeof a["menuIcon"] != 'undefined' && a["menuIcon"] != "") {
							before = '<i class="menuIcon menuIcon' + a["menuIcon"] + '"></i>&nbsp;';
						} else {
							before = '<i class="fa fa-' + a["icon"] + '"></i>&nbsp;';
						}
						btnId = (typeof a["id"] != 'undefined' && a["id"] != "") ? 'id="' + a["id"] + '"' : btnId ;
						libelle = (typeof a["libelle"] != 'undefined' && a["libelle"] != "") ? a["libelle"] : libelle ;
					} 
					var $bt = "<div "+btnId+" class=\""+clItem+"\" data-id=\""+bt+"\" style=\"float:right;\">"+before + libelle+"</div>" ;
					$("#"+id+" > .vignetteBtns").append($bt);
				}	
				$("#"+id+" > .vignetteBtns > .vignetteMessageBtn").on('mouseenter',function(){$(this).addClass("actif") ;});
				$("#"+id+" > .vignetteBtns > .vignetteMessageBtn").on('mouseout',function(){$(this).removeClass("actif") ;});
				$("#"+id+" > .vignetteBtns > .vignetteMessageBtn").on('click',function(){
					var id = $(this).attr("data-id") ;
					if (typeof btns[id] == 'function') {
						btns[id]();
					} else if (typeof btns[id] == 'object') {
						var a = btns[id] ;
						a["function"]();
					} 
				});
			}	
			isFullScreen = (typeof isFullScreen != 'undefined') ? isFullScreen : false ;
			Messages.ResizeDialog(id,btns,isFullScreen);
	},
	CloseMessage: function(n,id) {
			id = (typeof id != 'undefined') ? id : 'vignetteMessage' ;
			n = (typeof n != 'undefined') ? n : 99 ;
			var that = this ;
			//console.log('CloseMessage', n) ;
			that.hideBlockDivn(n) ;
			
			var $div = $("#"+id) ;
			$(".closeBlock",$div).off("click");
			$div.hide();
			$("#"+id+" > .vignetteMessagecontent").html("");
	},
	MessageChoix: function(title,msg,listeChoix,listeCallback,args,n,zIndex,closeCallback) {
		zIndex = (typeof zIndex != 'undefined') ? zIndex : 91 ;
		n = (typeof n != 'undefined') ? n : 99 ;
			
		var message = '<h3>Choisissez une option dans la liste</h3>' ;
		if (msg) {
			message += '<div class="alert alert-success">' ;
			//message += '	<p>';
			//message += '		<span class="ui-icon ui-icon-info" style="float:left;margin-right:.3em;"/>' ;
			message += msg ;
			//message += '	</p>';
			message += '</div>' ;
		}
		
		message += '<div id="listeChoix">' ;
		for (var j = 0; j < listeChoix.length; j++) {
			message += '	<div class="btnValide separateur tr" style="margin:auto;width:500px;min-height:30px;"><i class="menuIcon menuIconSlideRight"></i>' ;
			message += '		<input type="hidden" value="' + j + '" class="chkVal" />' ;
			//message += '		<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="button" role="button" aria-disabled="false">' ;
			//message += '		<span class="ui-button-text" style="min-width:'+(width-60)+'px;">' ;
			message += listeChoix[j] ;
			//message += '		</span>' ;
			//message += '		</button>' ;
			message += '	</div>' ;
			message += '<div class="separateur" style="min-height:10px;"></div>' ;
		}
		message += '</div>' ;
		
		var btns = {};
		btns = $.extend({"Fermer": function() {
										Messages.CloseMessage(n,"dialogChoix");
										if (typeof closeCallback != 'undefined') {
											closeCallback();
										}
									}},btns);
		Messages.AddMessage(title,message,null,n,zIndex,0.2,'body',btns,"dialogChoix") ;
			
		$(".tr",$("#dialogChoix")).on('click', function(event){
			var choix = parseInt($(".chkVal",$(this)).val());
			var callback = listeCallback[choix];
			//$("#dialogChoix").hide();
			if (!args) {
				callback();
			} else if (!args[choix]) {
				callback();
			} else if (args[choix].length == 0) {
				callback();
			} else if (args[choix].length == 1) {
				callback(args[choix][0]);
			} else if (args[choix].length == 2) {
				callback(args[choix][0],args[choix][1]);
			} else if (args[choix].length == 3) {
				callback(args[choix][0],args[choix][1],args[choix][2]);
			} else if (args[choix].length == 4) {
				callback(args[choix][0],args[choix][1],args[choix][2],args[choix][3]);
			} else if (args[choix].length == 5) {
				callback(args[choix][0],args[choix][1],args[choix][2],args[choix][3],args[choix][4]);
			} else if (args[choix].length == 6) {
				callback(args[choix][0],args[choix][1],args[choix][2],args[choix][3],args[choix][4],args[choix][5]);
			}
			Messages.CloseMessage(15,"dialogChoix");
		});
	
	},
	AddMessageImage: function($img,n,zIndex,opacity,appendTo) {
			appendTo = (typeof appendTo != 'undefined') ? appendTo : 'body' ;
			zIndex = (typeof zIndex != 'undefined') ? zIndex : 10 ;
			n = (typeof n != 'undefined') ? n : 99 ;
			opacity = (typeof opacity != 'undefined') ? opacity : 0.1 ;
			
			$("body").addClass("dialog-open") ;
			
			var that = this ;
			that.showBlockDivn(n,zIndex,opacity,appendTo) ;
			var s = '<div id="vignetteImage" style="z-index:'+(zIndex+1)+'">' ;
			s += '	<div class="imageBlock btnStandard zoomplus" title="zoom +"><i class="menuIcon menuIconZoomPlus"></i></div>' ;
			s += '	<div class="imageBlock btnStandard zoomminus" title="zoom -"><i class="menuIcon menuIconZoomMoins"></i></div>' ;
			s += '	<div class="imageBlock rotate180Block fa fa-refresh" title="rotation +180"></div>' ;
			s += '	<div class="imageBlock rotate90Block fa fa-reply" title="rotation -90"></div>' ;
			s += '	<div class="imageBlock rotateminus90Block fa fa-share" title="rotation +90"></div>' ;
			s += '	<div class="imageBlock btnStandard closeBlock" title="Fermer"><i class="menuIcon menuIconCancel"></i></div>' ;
			s += '	<div id="containerImage">' ;
			s += '		<img id="vignetteImagecontent" src="'+$img.attr('src')+'&full=1"></img>' ;
			s += '	</div>' ;
			s += '</div>' ;
			$(appendTo).append(s); 
		
			var $div = $("#vignetteImage") ;
			var $divImage = $("#vignetteImagecontent") ;
			
			var h = $(window).innerHeight() ;
			var w = $(window).innerWidth() ;
			
			$div.css("height",h) ;
			$div.css("width",w) ;
			
			var wImg = $img.width() ;
			var hImg = $img.height() ;
			var newW = wImg ;
			var newH = hImg ;
			if (w/wImg > h/hImg) {
				newW = wImg * (h-80)/hImg;
				newH = h-80;
			} else {
				newW = w-80;
				newH =hImg * (w-80)/wImg;
			}
			
			$divImage.css("width",newW);
			$divImage.css("height",newH);
			
			$div.fadeIn("fast", function() {
				$(".closeBlock",$div).off("click");
				$(".rotate90Block",$div).off("click");
				
				$(".closeBlock",$div).on("click",function() {
					that.CloseMessageImage(n);
				});
				
				function rotate(a,oldClass) {
					if (a == 90 || a == 270) {
						if (h/wImg > w/hImg) {
							newH = wImg * (w-80)/hImg;
							newW = w-80;
						} else {
							newH = h-80;
							newW =hImg * (h-80)/wImg;
						}
					
						$divImage.css("width",newH);
						$divImage.css("height",newW);
						console.log(a,newW,newH,w,h) ;
					} else if (a == 0 || a == 180) {
						if (w/wImg > h/hImg) {
							newW = wImg * (h-80)/hImg;
							newH = h-80;
						} else {
							newW = w-80;
							newH =hImg * (w-80)/wImg;
						}
						$divImage.css("width",newW);
						$divImage.css("height",newH);
					}
					
					$("#containerImage").removeClass(oldClass).addClass("rotate" + a);
				}
				
				var angle = 0;
				var isZoom = false ;
				var zoomLevel = 1 ;
				var typingTimer = null;
				var doneTypingInterval = 500;
				
				function reinitImage(z) {
					if (typingTimer != null) {
						clearTimeout(typingTimer);
					}
					
					$divImage.removeClass("drag");
					if ($divImage.hasClass("ui-draggable")) {
						$divImage.draggable('destroy');
					}
					zoomLevel = z;
					
					$divImage.css({
							'left': '50%',
							'top': '50%'
					});
				}
				$(".rotate90Block",$div).on("click",function() {
					reinitImage(1);
					
					var oldClass = "rotate" + angle ;
					angle = (angle + 270) % 360;
					rotate(angle,oldClass);
				});
				$(".rotateminus90Block",$div).on("click",function() {
					reinitImage(1);
					
					var oldClass = "rotate" + angle ;
					angle = (angle + 90) % 360;
					rotate(angle,oldClass);
				});
				$(".rotate180Block",$div).on("click",function() {
					reinitImage(1);
					
					var oldClass = "rotate" + angle ;
					angle = (angle + 180) % 360;
					rotate(angle,oldClass);
				});
				$(".zoomplus",$div).on("click",function() {
					zoomLevel = zoomLevel * 1.25 ;
					reinitImage(zoomLevel);
					
					if (zoomLevel == 1) {
						var oldClass = "rotate" + angle ;
						rotate(angle,oldClass);
					} else {
						$divImage.css("width",1.25*$divImage.width());
						$divImage.css("height",1.25*$divImage.height());
						if (zoomLevel > 1) {
							if (typingTimer != null) {
								clearTimeout(typingTimer);
							}
							
							typingTimer = setTimeout(function() {
									$divImage.draggable();
									$divImage.addClass("drag");
								}, doneTypingInterval
							);
						}
					}
					//isZoom = !isZoom ;
				});
				$(".zoomminus",$div).on("click",function() {
					zoomLevel = zoomLevel / 1.25 ;
					reinitImage(zoomLevel);
					
					if (zoomLevel == 1) {
						var oldClass = "rotate" + angle ;
						rotate(angle,oldClass);
					} else {
						$divImage.css("width",$divImage.width()/1.25);
						$divImage.css("height",$divImage.height()/1.25);					
						if (zoomLevel > 1) {
							if (typingTimer != null) {
								clearTimeout(typingTimer);
							}
							
							typingTimer = setTimeout(function() {
									$divImage.draggable();
									$divImage.addClass("drag");
								}, doneTypingInterval
							);
						}
					}
					//isZoom = !isZoom ;
				});
			});
	},
	CloseMessageImage: function(n) {
			n = (typeof n != 'undefined') ? n : 99 ;
			var that = this ;
			//console.log('CloseMessage', n) ;
			that.hideBlockDivn(n) ;
			
			$("body").removeClass("dialog-open") ;
			var $div = $("#vignetteImage") ;
			$(".closeBlock",$div).off("click");
			$div.remove();
	},
	getFreeVignetteNotifNumber: function() {
		var n = 1 ;
		while ($("#vignetteMessageNotif" + n.toString()).length>0) {
			n+=1 ;
		}
		return n ;
	},
	getLeftVignetteNotif: function() {
		var left = 10 ;
		$(".vignetteMessageNotif").each(function() {
			var w = $(this).width() ;
			left += w + 10 ;
		}) ;
		
		return left ;
	},
	getMaxWidthVignetteNotif: function() {
		var w = 10 ;
		$(".vignetteMessageNotif").each(function() {
			w = ($(this).width() > w) ? $(this).width() : w ;
		}) ;
		
		return w ;
	},
	rePositionneVignetteNotif: function() {
		var that = this ;
		var left = 10 ;
		$(".vignetteMessageNotif").each(function() {
			var w = $(this).width() ;
				//$(this).css("left", ($(this).offset().left - w - 10).toString() + "px");
			$(this).animate({left: left}, 500, function() {
				//console.log('repositionne direct', $(".vignetteMessageNotif").length);
			});
			left += w + 10 ;
		}) ;
	},
	AddMessageNotifNew: function(title,message, config) {
		var that = this ;
		var options = {binding:null,timeout:4000,callBack:null};
		var config = (typeof config != "undefined") ? config : {} ;
		options = $.extend(options, config);
		that.AddMessageNotif(title,message,options.binding,options.timeout, options.callBack, options.width) ;
	},
	AddMessageNotif: function(title,message, binding, timeout, callBack, width) {
			var that = this ;
			
			timeout = (typeof timeout != 'undefined') ? timeout : 4000 ;
			var n = that.getFreeVignetteNotifNumber() ;
			var left = that.getLeftVignetteNotif() ;
			var w = (typeof width != 'undefined' && width != null) ? width : that.getMaxWidthVignetteNotif() ;
			var inner = $(window).innerWidth() ;
			//that.showBlockDivn(99,1004,0.1) ;
			var id = 'vignetteMessageNotif'+n.toString() ;
			if (left + w + 10 > inner) { //($(".vignetteMessageNotif").length>2) {
				//console.log('AddMessageNotif',left,w,inner, left + w) ;
				that.pileNotif.push(function(){
					that.AddMessageNotif(title,message, binding, timeout, callBack, width) ;
				}) ;
				return ;
			}
			$('body').append('<div id="'+id+'" class="vignetteMessageNotif" style="left:'+left.toString()+'px;"><div class="closeBlock fa fa-window-close" title="Fermer"></div><div class="vignetteMessageNotifTitle"></div><div class="vignetteMessageNotifcontent"></div></div>'); 
			
			$("#"+id+" > .vignetteMessageNotifTitle").html(title);
			$("#"+id+" > .vignetteMessageNotifcontent").html(message);
			
			if (typeof binding != 'undefined' && binding != null && typeof binding == 'function') {
				binding();
			}
					
			var h = $(window).innerHeight() -40 ;
			$("#"+id+" > .vignetteMessageNotifcontent").css("max-height",h) ;
			
			var $div = $("#"+id) ;
			var w = (typeof width != 'undefined' && width != null) ? width + 30 : $div.width() + 30 ;
			if (typeof width != 'undefined' && width != null) $("#"+id+" > .vignetteMessageNotifcontent").css("max-width","none") ;
			$div.css("width",w) ;
	
			$div.fadeIn("slow", function() {
				$(".closeBlock",$div).off("click");
				
				$(".closeBlock",$div).on("click",function() {
					that.CloseMessageNotif($div);
					if (typeof callBack != 'undefined' && callBack != null) {
						callBack();
					}
				});
				
				setTimeout(function() {
					that.CloseMessageNotif($div);
				},timeout);
			});
	},
	CloseMessageNotif: function($div) {
			var that = this ;
			
			$(".closeBlock",$div).off("click");
			
			$div.fadeOut("slow", function() {
				var wDiv = $div.width() ;
				$div.remove();
				that.rePositionneVignetteNotif();
				
				if (that.pileNotif.length>0) {
					that.pileNotif[0]() ;
					that.pileNotif = that.pileNotif.slice(1);
				}
			});
	}
};
