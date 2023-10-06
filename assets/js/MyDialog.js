function classeDialogs() {
	var that = this ;
	this.decaleIndex = 0;
	this.Dialogs = [];	
	
	$(window).on('resize',function() {
		//Redimensionnement des fen&ecirc;tres dynamique
		that.ResizeAll();
	});
}
classeDialogs.prototype.ResizeAll = function() {
	for (var i = 0; i<this.Dialogs.length;i++) {
		this.Dialogs[i].Resize();
	}
}
classeDialogs.prototype.Add = function(id,options) {
	var that = this ;
	if (!that.ExisteById(id)) {
		var n = that.getFreeN() ;
		options = $.extend({"n": n,"zIndex":n},options);
		var c = new classeDialog(id,options) ;
		c.parent = that ;
		that.Dialogs.push(c) ;
	}
	var d = that.GetById(id) ;
	var parentId = (typeof options["parentId"] != 'undefined') ? options["parentId"] : '' ;
	if (parentId != '' && that.ExisteById(parentId)) {
		var p = that.GetById(parentId) ;
		//console.log('parent found',parentId) ;
		d.parentDialog = p ;
	}
	return d ;
}
classeDialogs.prototype.Open = function(id,options) {
	var that = this ;
	var d = that.Add(id,options) ;
	d.Open();
}
classeDialogs.prototype.Confirm = function(id,options,callbackClose) {
	var that = this ;
	var callBackBeforeClose = options["callBackBeforeClose"] ;					   
	var callback = options["callBack"] ;
	var args = options["args"] ;
	var btns = {
		"Continuer": {'function' : function() {
			if (typeof callBackBeforeClose != 'undefined') {
				callBackBeforeClose();
				Dialogs.Remove(id);
				return true;
			}
			
			Dialogs.Remove(id);
			
			if (!args) {
				callback();
			} else if (args.length == 0) {
				callback();
			} else if (args.length == 1) {
				callback(args[0]);
			} else if (args.length == 2) {
				callback(args[0],args[1]);
			} else if (args.length == 3) {
				callback(args[0],args[1],args[2]);
			} else if (args.length == 4) {
				callback(args[0],args[1],args[2],args[3]);
			} else if (args.length == 5) {
				callback(args[0],args[1],args[2],args[3],args[4]);
			} else if (args.length == 6) {
				callback(args[0],args[1],args[2],args[3],args[4],args[5]);
			}
		},'menuIcon' : 'SlideRight'},
		'Fermer': {'function' : function() {
				Dialogs.Remove(id);
				if (typeof callbackClose != 'undefined') {
					callbackClose();
				}
		},'menuIcon' : 'Close'}
	};
	options["btns"] = btns ;
	options["callBack"] = null ;
	options["args"] = null ;
	var d = that.Add(id,options) ;
	d.Open();
}
classeDialogs.prototype.ConfirmPromise = function(id,options) {
	var that = this ;
	var deferred = $.Deferred();
	var args = options["args"] ;
	var callBackBeforeClose = options["callBackBeforeClose"] ;
	var callBackBeforeCloseClose = options["callBackBeforeCloseClose"] ;		
	var btns = {
		"Continuer": {'function' : function() {
			if (typeof callBackBeforeClose != 'undefined') {
				callBackBeforeClose();
			}
			Dialogs.Remove(id);
			deferred.resolve();
		},'menuIcon' : 'SlideRight'},
		'Fermer': {'function' : function() {
				if (typeof callBackBeforeCloseClose != 'undefined') {
					callBackBeforeCloseClose();
				}
				Dialogs.Remove(id);
				deferred.reject("");
		},'menuIcon' : 'Close'}
	};
	//console.log(btns) ;
	btns["Continuer"]["libelle"] = (typeof options.libelle != "undefined" && options.libelle.Continuer != "undefined") ? options.libelle.Continuer : "Continuer 2" ;
	btns["Fermer"]["libelle"] = (typeof options.libelle != "undefined" && options.libelle.Fermer != "undefined") ? options.libelle.Fermer : "Fermer 2" ;
	btns.Continuer.menuIcon = (typeof options.icon != "undefined" && options.icon.Continuer != "undefined") ? options.icon.Continuer : btns.Continuer.menuIcon ;
	btns.Fermer.menuIcon = (typeof options.icon != "undefined" && options.icon.Fermer != "undefined") ? options.icon.Fermer : btns.Fermer.menuIcon ;
	//console.log(btns) ;
	options["btns"] = btns ;
	options["callBack"] = null ;
	options["args"] = null ;
	var d = that.Add(id,options) ;
	d.Open();
	return deferred.promise();
}
classeDialogs.prototype.getArrayId = function() {
	var a=[] ;
	for (var i = 0; i<this.Dialogs.length;i++) {
		a.push(this.Dialogs[i].id);
	}
	return a ;
}
classeDialogs.prototype.Count = function() {
	return this.Dialogs.length ;
}
classeDialogs.prototype.getFreeN = function() {
	var a = 100 ;
	for (var i = 0; i<this.Dialogs.length;i++) {
		var n = this.Dialogs[i].settings["n"];
		if (a <= n) a = n+1;
	}
	$(".ListeController").each(function(){
		var i = parseInt($(this).css("z-index")) ;
		if (i>a) {
			a = i;
		}
	});
	
	a = a + this.decaleIndex ;
	return a ;
}
classeDialogs.prototype.getFreeController = function() {
	var a = 0 ;
	for (var i = 0; i<this.Dialogs.length;i++) {
		var n = this.Dialogs[i].settings["n"];
		if (a <= n) a = n+1;
	}
	$(".ListeController").each(function(){
		var i = parseInt($(this).css("z-index")) ;
		if (i>a) {
			a = i;
		}
	});
	
	a = a + this.decaleIndex ;
	return a ;
}
classeDialogs.prototype.ExisteById = function(id) {
	for (var i = 0; i<this.Dialogs.length;i++) {
		if (this.Dialogs[i].id == id) {
			return true ;
		} 
	}
	return false ;
}
classeDialogs.prototype.hasFullscreen = function(id) {
	for (var i = 0; i<this.Dialogs.length;i++) {
		if (this.Dialogs[i].settings["fullscreen"]) {
			return true ;
		} 
	}
	return false ;
}
classeDialogs.prototype.Item = function(id) {
	return this.GetById(id) ;
}
classeDialogs.prototype.GetById = function(id) {
	for (var i = 0; i<this.Dialogs.length;i++) {
		if (this.Dialogs[i].id == id) {
			return this.Dialogs[i] ;
		} 
	}
	return false ;
}
classeDialogs.prototype.Remove = function(id) {
	var that = this ;
	for (var i = 0; i<this.Dialogs.length;i++) {
		if (this.Dialogs[i].id == id) {
			this.Dialogs[i].Close();
			this.Dialogs[i].$element.remove();
			this.Dialogs.splice(i, 1);
			
			if (this.Dialogs.length == 0) {
				//console.log("Dialogs.Remove, Lancement de App.controller.decreaseZIndex");
				//App.controller.decreaseZIndex() ;
			}
		}
	}
}
classeDialogs.prototype.Clear = function() {
	var that = this ;
	for (var i = this.Dialogs.length-1; i>=0;i--) {
			//this.Indicateurs[i].Close();
			this.Dialogs[i].$element.remove();
			this.Dialogs.splice(i, 1);
	}
}

function classeDialog(id, config) {
	this.parent = null;	
	this.parentDialog = null;	
	this.id = id;
	this.$element = null ;
	this.options = {	
		btns : null,
		zIndex : 100,
		n : 100,
		title:'Dialog',
		message:'message',
		callBack: null,
		opacity:0.2,
		appendTo:'body',
		fullscreen:false
	};
	
	this.Initialize(config);
}
classeDialog.prototype.Initialize = function(config) {
	var that = this ;
	that.settings = $.extend(this.options, config);
	
}
classeDialog.prototype.GetElement = function() {
	var that = this ;
	return that.$element ;
}
classeDialog.prototype.Open = function() {
	var that = this ;
	var title = that.settings["title"] ;
	var message = that.settings["message"] ;
	var callBack = that.settings["callBack"] ;
	var n = that.settings["n"] ;
	var zIndex = that.settings["zIndex"] ;
	var btns = that.settings["btns"] ;
	var opacity = that.settings["opacity"] ;
	var appendTo = that.settings["appendTo"] ;
	var fullscreen = that.settings["fullscreen"] ;
	var bindEvents = that.settings["bindEvents"] ;
	Messages.AddMessage(title,message,callBack,n,zIndex,opacity,appendTo,btns,that.id,fullscreen) ;
	
	if (typeof bindEvents != 'undefined') {
		bindEvents();
	}
	if (Dialogs.hasFullscreen()) {
		$('#maincontainer').css("max-height","10%").css("overflow","hidden");
	}
	
	that.$element = $("#" + that.id) ;
	//navigation via les balises a
	$("a[data-nav='controller']",that.$element).off('click').on('click',function(e){
		e.preventDefault();
		var tab = $(this).data("tab-menu") ;
		var c = $(this).data("controller") ;
		//App.controller.renderGenericView(tab,c);
	}) ;
			
	if (that.parentDialog != null) {
		that.parentDialog.Hide() ;
	}
}
classeDialog.prototype.AddButton = function(btn) {
	var that = this ;
	var btns = that.settings["btns"] ;
	btns = $.extend(btns,btn);
	that.settings["btns"] = btns ;
	Messages.SetButtons(that.id,btns) ;
}
classeDialog.prototype.SetButtons = function(btns) {
	var that = this ;
	that.settings["btns"] = btns ;
	Messages.SetButtons(that.id,btns) ;
}
classeDialog.prototype.Resize = function() {
	var that = this ;
	var btns = that.settings["btns"] ;
	var isFullscreen = that.settings["fullscreen"] ;
	Messages.ResizeDialog(that.id,btns,isFullscreen) ;
}
classeDialog.prototype.Show = function() {
	var that = this ;
	if (that.$element != null) {
		that.$element.show();
		that.Resize();
	}
}
classeDialog.prototype.Hide = function() {
	var that = this ;
	//console.log('Hide', that.$element) ;
	if (that.$element != null) {
		//console.log('Hide 2', that.$element) ;
		that.$element.hide();
	}
}
classeDialog.prototype.Close = function() {
	var that = this ;
	Messages.CloseMessage(that.settings["n"],that.id,that.settings["fullscreen"]);
	
	if (!Dialogs.hasFullscreen()) {
		$('#maincontainer').css("max-height","").css("overflow","");
	}
	
	if (that.parentDialog != null) {
		that.parentDialog.Show() ;
	}
}
var Dialogs = new classeDialogs ;