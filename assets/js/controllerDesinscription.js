var controllerDesinscription = {
	currentItem: null,
	initialize: function() {
		var that = this ;
		
		$("<link/>", {rel: "stylesheet", type: "text/css", href: "./../assets/js/jquery-ui.min.css"}).appendTo("head");
		$("#searchJoueur").autocomplete({
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
			sModif += '<td><div style="float:right;font-weight:700;cursor:pointer;color:red;" id="modifJoueur"><i class="ui-icon ui-icon-check"></i> Modifier</div></td></tr>';
			sModif += '</table>';
			var sTableaux = '' ;
			for (var i=0;i<item.aTableaux.length;i++) {
				var t = item.aTableaux[i] ;
				sTableaux+='<div style="clear:both;width:300px;"> Tableau ' + t + ' <div style="float:right;font-weight:700;cursor:pointer;color:red;" class="deleteTableau" data-tableau="'+t+'"><i class="ui-icon ui-icon-circle-close"></i> Supprimer</div></div>';
			}
			
			var sNotTableaux = '<div class="field"><label for="TableauToAdd">Ajouter le joueur à un tableau:</label><select id="TableauToAdd" style="width:300px;"><option value="'+t+'" selected="true">Choisir un tableau ...</option>' ;
			for (var i=0;i<item.aNotTableaux.length;i++) {
				var t = item.aNotTableaux[i] ;
				sNotTableaux+='<option value="'+t+'"> Tableau ' + t + ' </option>';
			}
			sNotTableaux+='</select>';
			sNotTableaux+='<div style="float:right;font-weight:700;cursor:pointer;color:red;" id="addJoueur"><i class="ui-icon ui-icon-circle-plus"></i> Ajouter au tableau</div>' ;
			
			$("#modif").html(sModif);
			$("#tableaux").html(sTableaux);
			$("#add").html(sNotTableaux);
			$("#licenceSearch").val(item.numLicence);
			$(this).val(item.nom) ;
			
			$("#modifJoueur",$("#modif")).off('click').on('click',function(){
				var row = $(this).closest("tr");
				var club = $("#club",row).val() ;
				var nom = $("#nom",row).val() ;
				var prenom = $("#prenom",row).val() ;
				var nombrePoints = $("#nombrePoints",row).val() ;
				that.modifJoueur(item.numLicence,club,nom,prenom,nombrePoints,row) ;
			});
			$(".deleteTableau",$("#tableaux")).off('click').on('click',function(){
				var t = $(this).data("tableau") ;
				that.deleteTableauJoueur(item.numLicence,t,$(this).parent()) ;
			});
			$("#addJoueur",$("#add")).off('click').on('click',function(){
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