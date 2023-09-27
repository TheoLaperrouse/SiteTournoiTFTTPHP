<?php
	require_once __DIR__ . "/../Technique/AutoLoad.php";
	\Technique\AutoLoad::loadTFTT();
	
	if (!isset($_POST["numLicence"])) {
		include('./../Template/desinscription.html');
	} else {
		$arr = model_Joueur::DeleteByLicence($_POST["numLicence"]) ;
		$aTableaux = $arr["tableaux"] ;
		?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Désinscription</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="./../assets/css/main.css" />
	<link rel="icon" type="image/png" href="./../favicon.png">
</head>
<body class="is-loading">
	<div id="wrapper" class="fade-in">
		<header id="header">
			<a href="admin.html" class="center logo">Accueil</a>
		</header>
		<div id="main">
			<article>
				<?php
                    foreach($aTableaux as $t) {
						echo "<h2>".$t."</h2>";
					}
                ?>
		</div>
		</article>
	</div>
	<script src="./../assets/js/jquery.min.js"></script>
	<script src="./../assets/js/jquery.scrollex.min.js"></script>
	<script src="./../assets/js/jquery.scrolly.min.js"></script>
	<script src="./../assets/js/skel.min.js"></script>
	<script src="./../assets/js/util.js"></script>
	<script src="./../assets/js/main.js"></script>

</body>

</html>
<?php
	}
	
	\Technique\AutoLoad::exitTFTT();
?>