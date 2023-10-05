<?php
	require_once __DIR__ . "./../Technique/AutoLoad.php";
	\Technique\AutoLoad::loadTFTT();
	\Technique\AutoLoad::TryConnect(false);
	$auth = UserInfo::is_set('UserId');
	if (!$auth) {
		\BDD\SGBD::unsetGlobal();
		header('Location: ./connexion.php');
	}
?>
<html>
  <head>
    <title>Désinscription</title>
    <link rel="icon" type="image/png" href="./../favicon.png" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="./../assets/css/front.css" />
    <script src="./../assets/js/jquery.3.1.1.min.js"></script>
	<script src="./../assets/js/jquery-ui.min.js"></script>
    <script src="./../assets/js/controllerDesinscription.js"></script>
    <script src="./../assets/js/Messages.js"></script>
    <script src="./../assets/js/MyDialog.js"></script>
  </head>

  <body class="is-preload">
	<div id="enteteDesinscription" class="enteteController barre1">
		Désinscription
		<div class="separateur" style="margin-bottom:1px;"></div>
		
		<div class="enteteBarre">
			<div id="accueil" class="btnValide" title="Retour au panneau d'administration"><i class="menuIcon menuIconHome"></i></div>
		</div>
	</div>
	<div id="desinscriptionView" class="listeSC ListeController barre1">
		<div style="clear:both;min-height:40px;"></div>
		<div class="rowField">
		  <div class="rowFieldLibelle">Rechercher (par nom ou n&deg; de licence) :</div>
		  <input type='text' id='searchJoueur' value='' placeholder='Rechercher un joueur ...' />
		</div>
		<div style="margin-bottom:10px;">
			<input type='hidden' id='licenceSearch' value="" />
			<span id="joueur" style='color:black;'></span>
			<span id="modif" style='color:#117176;'></span>
			<span id="tableaux" style='color:#117176;'></span>
			<span id="add" style='color:#117176;'></span>
		</div>
		<div style='clear:both;height:100px;'></div> 
		<div class="tabH">
			<h1>Désinscrire de tous les tableaux par Numéro de licence</h1>
			<div class="rowField">
				<div class="rowFieldLibelle">Numéro de licence :</div>
				<input type="text" id="numLicence" style='width:100px;' />
			</div>
			<div style='clear:both;height:40px;'></div>
			<div id='desinscription' class="btnValide" style='align:center;'>
				<i class="menuIcon menuIconClose"></i>
				Désinscrire
			</div>
		</div>
	</div>
	 <script language='javascript'>
		$(document).ready(function() {
			controllerDesinscription.initialize();
		});
	</script>
	
  </body>
</html>
<?php
	\Technique\AutoLoad::exitTFTT();
?>