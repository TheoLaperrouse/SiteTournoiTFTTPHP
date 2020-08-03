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
	<link rel="stylesheet" href="assets/css/main.css" />
	<link rel="icon" type="image/png" href="favicon.png">
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
				$cnx = mysqli_connect("", "", "", "");
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

				if (1000 < $numLic && $numLic < 9999999) {
					$sql = "INSERT INTO $tab1 (`prenom`, `nom`, `nombrePoints`, `numLicence`, `club`) VALUES (\"$prenom\",\"$nom\",$nbrePts,$numLic,\"$club\")";
					$place = "SELECT count(*) as nbInscrits FROM $tab1";

					switch ($tab1) {
						case "tableauA":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau A est complet</h2>";
							} else if ($nbrePts < 1400) {
								$res = $cnx->query($sql);
								echo $row['nbInscrits'] >= 72;
								echo "<h2 align='center'>Vous êtes inscrit au tableau A</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau A</h2>";
							}
							break;
						case "tableauB":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau B est complet</h2>";
							} else if ($nbrePts < 900) {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau B</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau B</h2>";
							}
							break;
						case "tableauC":
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau C est complet</h2>";
							} else if ($nbrePts < 1900) {
								$result = mysqli_query($cnx, $place);
								$row = mysqli_fetch_assoc($result);
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau C</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau C</h2>";
							}
							break;
						case "tableauD":
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau D est complet</h2>";
							} else if ($nbrePts < 1200) {
								$result = mysqli_query($cnx, $place);
								$row = mysqli_fetch_assoc($result);
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau D</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau D</h2>";
							}
							break;
						case "tableauE":
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau E est complet</h2>";
							} else if ($nbrePts < 1600) {
								$result = mysqli_query($cnx, $place);
								$row = mysqli_fetch_assoc($result);
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau E</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau E</h2>";
							}
							break;
						case "tableauF":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau F est complet</h2>";
							} else if ($nbrePts < 2200) {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau F</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau F</h2>";
							}
							break;
						case "tableauG":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 36) {
								echo "<h2 align='center'>Le tableau G est complet</h2>";
							} else {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau G</p>";
							}
							break;
						default:
							break;
					}


					$sql = "INSERT INTO $tab2 (`prenom`, `nom`, `nombrePoints`, `numLicence`, `club`) VALUES (\"$prenom\",\"$nom\",$nbrePts,$numLic,\"$club\")";
					$place = "SELECT count(*) as nbInscrits FROM $tab2";
					switch ($tab2) {
						case "tableauA":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau A est complet</h2>";
							} else if ($nbrePts < 1400) {
								$res = $cnx->query($sql);
								echo $row['nbInscrits'] >= 72;
								echo "<h2 align='center'>Vous êtes inscrit au tableau A</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau A</h2>";
							}
							break;
						case "tableauB":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau B est complet</h2>";
							} else if ($nbrePts < 900) {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau B</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau B</h2>";
							}
							break;
						case "tableauC":
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau C est complet</h2>";
							} else if ($nbrePts < 1900) {
								$result = mysqli_query($cnx, $place);
								$row = mysqli_fetch_assoc($result);
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau C</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau C</h2>";
							}
							break;
						case "tableauD":
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau D est complet</h2>";
							} else if ($nbrePts < 1200) {
								$result = mysqli_query($cnx, $place);
								$row = mysqli_fetch_assoc($result);
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau D</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau D</h2>";
							}
							break;
						case "tableauE":
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau E est complet</h2>";
							} else if ($nbrePts < 1600) {
								$result = mysqli_query($cnx, $place);
								$row = mysqli_fetch_assoc($result);
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau E</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau E</h2>";
							}
							break;
						case "tableauF":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau F est complet</h2>";
							} else if ($nbrePts < 2200) {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau F</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau F</h2>";
							}
							break;
						case "tableauG":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 36) {
								echo "<h2 align='center'>Le tableau G est complet</h2>";
							} else {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau G</p>";
							}
							break;
						default:
							break;
					}

					$sql = "INSERT INTO $tab3 (`prenom`, `nom`, `nombrePoints`, `numLicence`, `club`) VALUES (\"$prenom\",\"$nom\",$nbrePts,$numLic,\"$club\")";
					$place = "SELECT count(*) as nbInscrits FROM $tab3";
					switch ($tab3) {
						case "tableauH":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($nbrePts < 1500) {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau H</h2>";
							} else if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau H est complet</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau H</h2>";
							}
							break;
						case "tableauI":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($nbrePts < 1000) {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau I</h2>";
							} else if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau I est complet</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau I</h2>";
							}
							break;
						case "tableauJ":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($nbrePts < 2899) {

								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau J</h2>";
							} else if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau J est complet</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau J</h2>";
							}
							break;
						case "tableauK":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($nbrePts < 1300) {
								$res = $cnx->query($sql);

								echo "<h2 align='center'>Vous êtes inscrit au tableau K</h2>";
							} else if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau K est complet</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau K</h2>";
							}
							break;
						case "tableauL":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($nbrePts < 1800) {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau L</h2>";
							} else if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau L est complet</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau L</h2>";
							}
							break;
						case "tableauM":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($nbrePts > 1500) {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau M</h2>";
							} else if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau M est complet</h2>";
							} else {
								echo "<h2 align='center'>Il vous faut plus de 1500 points pour participer au tableau M</h2>";
							}
							break;
						case "tableauN":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 36) {
								echo "<h2 align='center'>Le tableau H est complet</h2>";
							} else {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau N</h2>";
							}
							break;
						default:
							break;
					}

					$sql = "INSERT INTO $tab4 (`prenom`, `nom`, `nombrePoints`, `numLicence`, `club`) VALUES (\"$prenom\",\"$nom\",$nbrePts,$numLic,\"$club\")";
					$place = "SELECT count(*) as nbInscrits FROM $tab4";
					switch ($tab4) {
						case "tableauH":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau H est complet</h2>";
							} else if ($nbrePts < 1500) {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau H</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau H</h2>";
							}
							break;
						case "tableauI":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau I est complet</h2>";
							} else if ($nbrePts < 1000) {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau I</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau I</h2>";
							}
							break;
						case "tableauJ":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau J est complet</h2>";
							} else if ($nbrePts < 2899) {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau J</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau J</h2>";
							}
							break;
						case "tableauK":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau K est complet</h2>";
							} else if ($nbrePts < 1300) {
								$res = $cnx->query($sql);

								echo "<h2 align='center'>Vous êtes inscrit au tableau K</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau K</h2>";
							}
							break;
						case "tableauL":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 72) {
								echo "<h2 align='center'>Le tableau L est complet</h2>";
							} else if ($nbrePts < 1800) {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau L</h2>";
							} else {
								echo "<h2 align='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau L</h2>";
							}
							break;
						case "tableauM":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 72) {

								echo "<h2 align='center'>Le tableau M est complet</h2>";
							} else if ($nbrePts > 1500) {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau M</h2>";
							} else {
								echo "<h2 align='center'>Il vous faut plus de 1500 points pour participer au tableau M</h2>";
							}
							break;
						case "tableauN":
							$result = mysqli_query($cnx, $place);
							$row = mysqli_fetch_assoc($result);
							if ($row['nbInscrits'] >= 36) {
								echo "<h2 align='center'>Le tableau H est complet</h2>";
							} else {
								$res = $cnx->query($sql);
								echo "<h2 align='center'>Vous êtes inscrit au tableau N</h2>";
							}
							break;
						default:
							break;
					}
				} else {
					echo "<h2 align='center'>Le numéro de Licence est incorrecte</h2>";
				}
				mysqli_close($cnx);
				?>
				<br>
				<h2 style="color:indigo;"><a href="tableaux.php">Voir les tableaux</a></h2>
		</div>

		<!-- Footer -->
		<div id="copyright">
			<ul>
				<li>
					<h3>Si vous avez un problème avec votre inscription, veuillez me contacter par mail (theo.laperrouse@laposte.net) ou par Messenger(<a href="https://www.facebook.com/messages/t/theo.laperrouse"> Théo Laperrouse</a>)</h3>
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