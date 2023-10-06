<?php
	require_once __DIR__ . "/../Technique/AutoLoad.php";
	\Technique\AutoLoad::loadTFTT();
	$items = model_CR::Liste();
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Compte-rendus</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="./../assets/css/messages.css" />
    <link rel="stylesheet" href="./../assets/css/front.css" />
	<script src="./../assets/js/jquery.min.js"></script>
    <script src="./../assets/js/controllerCR.js"></script>
    <script src="./../assets/js/Messages.js"></script>
    <script src="./../assets/js/MyDialog.js"></script>
    <script src="./../assets/js/texteSQL.js"></script>
	<script src="./../assets/js/tinymce/tinymce.min.js"></script>
	<link rel="icon" type="image/png" href="./../favicon.png">
	<style>
		table tbody tr:nth-child(2n + 1) {
			background-color: rgba(220, 220, 220, 0.25);
		}
		.partner-title {
		  font-weight: 700;
		  font-size: 48px;
		  text-align: center;
		  color: #ca9b52 !important;
		  margin: 20px !important;
		}
		.partner-container {
		  display: flex;
		  flex-wrap: wrap;
		  justify-content: center;
		  border: 1px solid #000000;
		  border-radius: 10px;
		  background-color: #BBD2E1;
		}
	</style>
</head>
<body class="is-loading">
	<div id="enteteCR" class="enteteController barre1">
		Compte-rendus des matchs
		<div class="separateur" style="margin-bottom:1px;"></div>
		
		<div class="enteteBarre">
			<div id="retour" class="btnValide" title="Retour au panneau d'administration"><i class="menuIcon menuIconHome"></i></div>
		</div>
	</div>

	<div id="crView" class="listeSC ListeController barre1">
		<div style="clear:both;min-height:40px;"></div>
		<div id="tableauCR" class="tabH">
			<h1>Liste des matchs</h1>
			<table style='width:90%;margin:auto;'>
					<tr class="aqua-header">	
						<td class='titreFacture2'></td>
						<td class='titreFacture2'>Journée</td>
						<td class='titreFacture2'>Date prévisionnelle</td>
						<td class='titreFacture2'>Lieu</td>
						<td class='titreFacture2'>Adversaire</td>
						<td class='titreFacture2'>Auteur</td>
						<td class='titreFacture2'>CR</td>
						<td class='titreFacture2'>En ligne</td>
						<td class='titreFacture2'>Verrou</td>
					</tr>
				<?php
					foreach($items as $cr) {
						$style = ($cr["Actif"] == 1) ? " style='font-weight:700;color:#117176;' " : "" ; 
						$style = ($cr["Actif"] == 1 && $cr["Locked"] == 1) ? " style='font-weight:700;color:red;' " : $style ; 
						$Content = preg_replace("/&#?[a-z0-9]+;/i","",$cr["CR"]); 
						$compteRendu = ($cr["CR"] != "") ? substr($Content,0,50) ." ..." : "" ;
						$auteur = ($cr["Auteur"] != "") ? utf8_decode($cr["Auteur"]) : "" ;
						$adversaire = utf8_decode($cr["Adversaire"]) ;
						$domicile = ($cr["Domicile"] == 1) ? "à domicile" : "à l'extérieur" ;
						echo "<tr class='rowJournee' data-journee='".$cr["NumJournee"]."' ".$style." data-actif='".$cr["Actif"]."' data-locked='".$cr["Locked"]."'>
								<td><i class='journee menuIcon stretchIcon menuIconPencil'></i></td>
								<td>".$cr["NumJournee"]."</td>
								<td>".$cr["DateMatch"]."</td>
								<td>{$domicile}</td>
								<td>{$adversaire}</td>
								<td>{$auteur}</td>
								<td>{$compteRendu}</td>
								<td>" . (($cr["Actif"] == 1) ? "<i class='activer menuIcon stretchIcon menuIconCheck'></i> Actif" : " à activer") ."</td>
								<td>" . (($cr["Locked"] == 1) ? "<i class='verrouiller menuIcon stretchIcon menuIconLock'></i> Verrouillé" : "à verrouiller") ."</td>
							</tr>";
					}
                ?>
			</table>
		</div>
	</div> 
	<script language="javascript">
		$(document).ready(function() {
			controllerCR.initialize();
		});
	</script>
</body>

</html>
<?php
	\Technique\AutoLoad::exitTFTT();
?>