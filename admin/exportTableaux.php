<?php session_start();
	require_once __DIR__ . "/../Technique/AutoLoad.php";
	\Technique\AutoLoad::loadTFTT();
	\Technique\AutoLoad::TryConnect(false);
	
	$auth = UserInfo::is_set('UserId');
	if (!$auth) {
		include('../index.php') ;
	} else {
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Export TFTT</title>
    <link rel="icon" type="image/png" href="./../favicon.png" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="./../assets/css/messages.css" />
    <link rel="stylesheet" href="./../assets/css/front.css" />
    <script src="./../assets/js/jquery.min.js"></script>
  </head>

  <body class="is-preload">
	<div id="enteteCSV" class="enteteController barre1">
		Export des données csv
		<div class="separateur" style="margin-bottom:1px;"></div>
		
		<div class="enteteBarre">
			<div id="accueil" class="btnValide" title="Retour au panneau d'administration"><i class="menuIcon menuIconHome"></i></div>
		</div>
	</div>
	
	<div id="csvView" class="listeSC ListeController barre1">
		<div style="clear:both;min-height:40px;"></div>
        <?php		
            echo Functions::exportTableau() ;
        ?>
	</div>
	<script language="javascript">
		$(document).ready(function() {
			var Entete = $("#enteteCSV") ;
		
			$("#accueil",Entete).off('click').on('click',function(){
				document.location.href = "./admin.html";
			});
		});
	</script>
  </body>
</html>
<?php
	}
	\Technique\AutoLoad::exitTFTT();
?>