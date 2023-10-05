var controllerDesinscription = {
	currentItem: null,
	Entete: null,
	View:null,
	initialize: function() {
		var that = this ;
		$("<link/>", {rel: "stylesheet", type: "text/css", href: "./../assets/js/jquery-ui.min.css"}).appendTo("head");
		that.View = $("#desinscriptionView") ;
		that.Entete = $("#enteteDesinscription") ;
		
		$("#accueil",that.Entete).off('click').on('click',function(){
			document.location.href = "./admin.html";
		});
		
		$("#desinscription",that.View).off('click').on('click',function(){
			var numLicence = $("#numLicence",that.View).val() ;
			if (numLicence != "") {
				that.desinscrire(numLicence);
			}
		});
		$("#searchJoueur",that.View).autocomplete({
			source: "./../ajax/getSearchPlayer.php",
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert(textStatus);
			},
			select: function(event, ui) {
				that.currentItem = ui.item.item ;
				that.setItem() ;
				return false;
			},
			open: function(event, ui) {
				$(".ui-autocomplete").css("z-index", 9999);
			},
			delay: 500,
			minLength: 2
		});
	},
	desinscrire: function(numLicence){
		var that = this ;
		var form_data = {
			numLicence: numLicence,
			mode:'DESINSCRIPTION'
		};
		$.ajax({
			 type: "POST",
			 url: "./../ajax/doJoueur.php",
			 data: form_data,
			 success: function(data){
				if (data.status == "OK") {
					Messages.AddMessage('Modification du joueur','D&eacute;sinscription effectuée');
				} else {
					Messages.AddMessage('Modification du joueur',data.message);
				}
			 }
		});
	},
	setItem: function() {
		var that = this ;
		var item = that.currentItem ;
		if (item !== null) {
			$("#joueur").html(item.club + ' - ' + item.nom + ' ' + item.prenom + ' (' + item.numLicence + ')');
			var sModif = '<table style="width:90%;margin:auto;"><tr><td>club</td><td>nom</td><td>prenom</td><td>nombrePoints</td><td></td></tr><tr>' ;
			sModif += '<td><input type="text" id="club" style="width:200px;" value="'+item.club+'" /></td>';
			sModif += '<td><input type="text" id="nom" style="width:200px;" value="'+item.nom+'" /></td>';
			sModif += '<td><input type="text" id="prenom" style="width:200px;" value="'+item.prenom+'" /></td>';
			sModif += '<td><input type="text" id="nombrePoints" style="width:100px;" value="'+item.nombrePoints+'" /></td>';
			sModif += '<td><div class="btnValide" id="modifJoueur"><i class="menuIcon menuIconCheck"></i> Modifier</div></td></tr>';
			sModif += '</table>';
			var sTableaux = '' ;
			for (var i=0;i<item.aTableaux.length;i++) {
				var t = item.aTableaux[i] ;
				sTableaux+='<div class="rowField" style="margin-bottom:10px;font-size:1.25em;"> Tableau ' + t + ' <i data-tableau="'+t+'" class="deleteTableau menuIcon stretchIcon menuIconClose" title="Supprimer"></i></div>';
			}
			
			var sNotTableaux = '<div class="rowField"><div class="rowFieldLibelle">Ajouter le joueur à un tableau:</div><select id="TableauToAdd" style="width:300px;"><option value="'+t+'" selected="true">Choisir un tableau ...</option>' ;
			for (var i=0;i<item.aNotTableaux.length;i++) {
				var t = item.aNotTableaux[i] ;
				sNotTableaux+='<option value="'+t+'"> Tableau ' + t + ' </option>';
			}
			sNotTableaux+='</select>';
			sNotTableaux+='<div style="float:right;" class="btnValide" id="addJoueur"><i class="menuIcon menuIconAdd"></i> Ajouter au tableau</div>' ;
			
			$("#modif",that.View).html(sModif);
			$("#tableaux",that.View).html(sTableaux);
			$("#add",that.View).html(sNotTableaux);
			$("#licenceSearch",that.View).val(item.numLicence);
			$(this).val(item.nom) ;
			
			$("#modifJoueur",$("#modif",that.View)).off('click').on('click',function(){
				var row = $(this).closest("tr");
				var club = $("#club",row).val() ;
				var nom = $("#nom",row).val() ;
				var prenom = $("#prenom",row).val() ;
				var nombrePoints = $("#nombrePoints",row).val() ;
				that.modifJoueur(item.numLicence,club,nom,prenom,nombrePoints,row) ;
			});
			$(".deleteTableau",$("#tableaux",that.View)).off('click').on('click',function(){
				var t = $(this).data("tableau") ;
				that.deleteTableauJoueur(item.numLicence,t,$(this).parent()) ;
			});
			$("#addJoueur",$("#add",that.View)).off('click').on('click',function(){
				var t = $("#TableauToAdd > option:selected").val() ;
				that.addTableauJoueur(item.numLicence,t,$(this).parent()) ;
			});
		}
	},
	modifJoueur: function(numLicence,club,nom,prenom,nombrePoints,row) {
		var form_data = {
			numLicence: numLicence,
			club: club,
			nom: nom,
			prenom: prenom,
			nombrePoints: nombrePoints,
			mode:'MODIF'
		};
		$.ajax({
			 type: "POST",
			 url: "./../ajax/doJoueur.php",
			 data: form_data,
			 success: function(data){
				if (data.status == "OK") {
					Messages.AddMessage('Modification du joueur','Modification effectuée');
				} else {
					Messages.AddMessage('Modification du joueur',data.message);
				}
			 }
		});
	},
	deleteTableauJoueur: function(numLicence,lettre,row) {
		var form_data = {
			numLicence: numLicence,
			lettre: lettre,
			mode:'DELETE_TABLEAU'
		};
		$.ajax({
			 type: "POST",
			 url: "./../ajax/doJoueur.php",
			 data: form_data,
			 success: function(data){
				if (data.status == "OK") {
					row.remove();
				} else {
					Messages.AddMessage('Suppression du tableau',data.message);
				}
			 }
		});
	},
	addTableauJoueur: function(numLicence,lettre,row) {
		var that = this ;
		var form_data = {
			numLicence: numLicence,
			lettre: lettre,
			mode:'ADD_TABLEAU'
		};
		$.ajax({
			 type: "POST",
			 url: "./../ajax/doJoueur.php",
			 data: form_data,
			 success: function(data){
				if (data.status == "OK") {
					that.setItem(data.item) ;
				} else {
					Messages.AddMessage('Ajout du joueur',data.message);
				}
			 }
		});
	}
}