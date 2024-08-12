<?php
	require_once __DIR__ . "/Technique/AutoLoad.php";
	\Technique\AutoLoad::loadTFTT();
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Votre Inscription</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="./assets/css/main.css" />
	<link rel="icon" type="image/png" href="./favicon.png">
</head>
<body class="is-loading">
	<div id="wrapper" class="fade-in">
		<div id="intro">
			<h1>Formulaire d'inscription</h1>
			<p>au tournoi de Tennis de Table de Thorigné Fouillard</p>
			<ul class="actions">
				<li><a href="#header" class="button icon solo fa-arrow-down scrolly">S'inscrire</a></li>
			</ul>
		</div>
		<header id="header">
			<a href="index.php" class="center logo">Inscription</a>
		</header>
		<div id="main">
			<article>
				<?php
                    $nom = strip_tags($_POST["nom"]);
                    $prenom = strip_tags($_POST["prenom"]);
                    $club = strip_tags($_POST["club"]);
                    $nbrePts = strip_tags($_POST["nbrePts"]);
                    $tab1 = strip_tags($_POST["tabSam1"]);
                    $tab2 = strip_tags($_POST["tabSam2"]);
                    $tab3 = strip_tags($_POST["tabDim1"]);
                    $tab4 = strip_tags($_POST["tabDim2"]);
                    $numLic = strip_tags($_POST["numLic"]);

                    model_Joueur::AddJoueur($prenom,$nom,$nbrePts,$numLic,$club,[$tab1, $tab2, $tab3, $tab4]);
                ?>
				<br>
				<h2 class="center" style="color:indigo;"><a href="./tableaux.php">Voir les tableaux</a></h2>
		</div>
		<div id="copyright">
			<ul>
          <li>
            <h3>
              Si vous avez un problème avec votre inscription, veuillez me
              contacter par mail (theolaperrouse@gmail.com) ou par Messenger(<a
                href="https://www.facebook.com/messages/t/100000464042474"
              >
                Théo Laperrouse</a
              >)
            </h3>
          </li>
        </ul>
			<ul>
				<li>&copy; Thorigné Fouillard Tennis de Table</li>
				<li>Design: <a href="https://html5up.net">HTML5 UP</a></li>
			</ul>
		</div>
		</article>
	</div>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/jquery.scrollex.min.js"></script>
	<script src="assets/js/jquery.scrolly.min.js"></script>
	<script src="assets/js/skel.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>

</body>

</html>
