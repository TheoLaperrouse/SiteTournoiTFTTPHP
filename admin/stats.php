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
<!DOCTYPE HTML>
<html>
<head>
	<title>Les Stats du tournoi</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="./../assets/css/front.css" />
    <script src="./../assets/js/jquery.min.js"></script>
	<link rel="icon" type="image/png" href="./../favicon.png">
</head>
<body class="is-loading">
	<div id="enteteStats" class="enteteController barre1">
		Stats du tournoi
		<div class="separateur" style="margin-bottom:1px;"></div>
		
		<div class="enteteBarre">
			<div id="accueil" class="btnValide" title="Retour au panneau d'administration"><i class="menuIcon menuIconHome"></i></div>
		</div>
	</div>
	
	<div id="statsView" class="listeSC ListeController barre1">
		<div style="clear:both;min-height:40px;"></div>
		<?php
			$distinctPlayers = Functions::execSqlFile("./../sql/getAllDistinctPlayers.sql");
			$nbInscript = Functions::execSqlFile("./../sql/getTotalInscriptions.sql");
			$meanTab =  number_format($nbInscript / $distinctPlayers,2);
			$nbNumero = Functions::execSqlFile("./../sql/getTotalNumero.sql");
			$recipies = model_Tableau::getRecipies();
			echo "<h4 class='center'>Nombre d'inscriptions : $nbInscript<br>Nombre de joueurs différents : $distinctPlayers<br>Moyenne de tableau/joueur : $meanTab<br>Nombre de joueurs numérotés : $nbNumero<br>Recette des inscriptions : $recipies €</h4>";
		?>	
	</div>
	<script language="javascript">
		$(document).ready(function() {
			var Entete = $("#enteteStats") ;
		
			$("#accueil",Entete).off('click').on('click',function(){
				document.location.href = "./admin.html";
			});
		});
	</script>
</body>

</html>
<?php
	\Technique\AutoLoad::exitTFTT();
?>