<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<head>
	<title>Votre Inscription</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="./assets/css/main.css" />
	<link rel="icon" type="image/png" href="./favicon.png">
</head>

<body class="is-loading">

	<!-- Wrapper -->
	<div id="wrapper" class="fade-in">

		<!-- Intro -->
		<div id="intro">
			<h1>Formulaire d'inscription</h1>
			<p>au tournoi de Tennis de Table de Thorigné Fouillard</p>
			<ul class="actions">
				<li><a href="#header" class="button icon solo fa-arrow-down scrolly">S'inscrire</a></li>
			</ul>
		</div>

		<!-- Header -->
		<header id="header">
			<a href="index.html" align='center' class="logo">Inscription</a>
		</header>

		<!-- Main -->
		<div id="main">
			<article>
				<?php

				$tabValues = array(
					"tableauA" => array("place" => 72, "ptsMax" => 1400),
					"tableauB" => array("place" => 72, "ptsMax" => 900),
					"tableauC" => array("place" => 72, "ptsMax" => 1900),
					"tableauD" => array("place" => 72, "ptsMax" => 1200),
					"tableauE" => array("place" => 72, "ptsMax" => 1600),
					"tableauF" => array("place" => 72, "ptsMax" => 2200),
					"tableauG" => array("place" => 36, "ptsMax" => 3500),
					"tableauH" => array("place" => 72, "ptsMax" => 1500),
					"tableauI" => array("place" => 72, "ptsMax" => 1000),
					"tableauJ" => array("place" => 72, "ptsMax" => 2900),
					"tableauK" => array("place" => 72, "ptsMax" => 1300),
					"tableauL" => array("place" => 72, "ptsMax" => 1800),
					"tableauM" => array("place" => 72, "ptsMax" => 3500),
					"tableauN" => array("place" => 36, "ptsMax" => 3500),
				);
				
				function inscriptTab($prenom, $nom, $nbrePts, $numLicence, $club, $tableau, $cnx,$tabValues)
				{
					if($tableau != ''){
						if (1000 < $numLicence && $numLicence < 9999999) {
							
								$sql = "INSERT INTO $tableau (`prenom`, `nom`, `nombrePoints`, `numLicence`, `club`) VALUES (\"$prenom\",\"$nom\",$nbrePts,$numLicence,\"$club\")";
								$place = "SELECT count(*) as nbInscrits FROM $tableau";
								$result = mysqli_query($cnx, $place);
								$row = mysqli_fetch_assoc($result);
								$nameTab = substr($tableau,-1);
								$ptsMax = $tabValues[$tableau]["ptsMax"];
								$place = $tabValues[$tableau]["place"];
								if ($row['nbInscrits'] >= $place) {
									echo "<h2 align='center'>Le tableau $nameTab est complet</h2>";
								} else if ($nbrePts < $ptsMax) {
									$res = $cnx->query($sql);
									echo "<h2 align='center'>Vous êtes inscrit au tableau $nameTab</h2>";
								} else {
									echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau $nameTab</h2>";
								}			
						}
						else {
							echo "<h2 align='center'>Le numéro de Licence est incorrecte</h2>";
						}
					}
				}

				$cnx = mysqli_connect("db", "user", "test", "myDb");
				if (!$cnx) {
					die("Connection error: " . mysqli_connect_errno());
				}
				$nom = strip_tags($_POST['nom']);
				$prenom = strip_tags($_POST['prenom']);
				$club = strip_tags($_POST['nomClub']);
				$nbrePts = $_POST['nbrePts'];
				$tab1 = $_POST['tabSam1'];
				$tab2 = $_POST['tabSam2'];
				$tab3 = $_POST['tabDim1'];
				$tab4 = $_POST['tabDim2'];
				$numLic = $_POST['numLic'];

				$result = mysqli_query($cnx, $place);
				$row = mysqli_fetch_assoc($result);

				inscriptTab($prenom, $nom, $nbrePts, $numLic, $club, $tab1, $cnx, $tabValues);
				inscriptTab($prenom, $nom, $nbrePts, $numLic, $club, $tab2, $cnx, $tabValues);
				inscriptTab($prenom, $nom, $nbrePts, $numLic, $club, $tab3, $cnx, $tabValues);
				inscriptTab($prenom, $nom, $nbrePts, $numLic, $club, $tab4, $cnx, $tabValues);
	
				mysqli_close($cnx);
				?>
				<br>
				<h2 class="center" style="color:indigo;"><a href="tableaux.php">Voir les tableaux</a></h2>
		</div>

		<!-- Footer -->
		<div id="copyright">
			<ul>
				<li>
					<h3>Si vous avez un problème avec votre inscription, veuillez me contacter par mail (theolaperrouse@gmail.com) ou par Messenger(<a href="https://www.facebook.com/messages/t/theo.laperrouse"> Théo Laperrouse</a>)</h3>
				</li>
			</ul>
			<ul>
				<li>&copy; Thorigné Fouillard Tennis de Table</li>
				<li>Design: <a href="https://html5up.net">HTML5 UP</a></li>
			</ul>
		</div>
		</article>
	</div>

	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/jquery.scrollex.min.js"></script>
	<script src="assets/js/jquery.scrolly.min.js"></script>
	<script src="assets/js/skel.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>

</body>

</html>