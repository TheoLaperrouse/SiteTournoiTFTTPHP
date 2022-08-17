<!DOCTYPE HTML>
<html>
<head>
	<title>Tableau</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="./assets/css/main.css" />
	<link rel="icon" type="image/png" href="./favicon.png">
</head>
<body class="is-loading">
	<div id="wrapper" class="fade-in">
		<div id="intro">
			<?php
				$tab = strip_tags($_GET["tab"]);
				$titre = substr_replace($tab, " ", 7, 0);
				echo "<h1> $titre </h1>";
   			?>
			<ul class="actions">
				<li><a href="#header" class="button icon solo fa-arrow-down scrolly">Voir les tableaux</a></li>
			</ul>
		</div>
		<header id="header">
			<a href="./tableaux.php" class="logo">Retournez aux tableaux</a>
		</header>
		<div id="main">
			<?php
				include "functions.php";
				printArrayPlayers($tab);
			?>
		</div>
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
	</div>

	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/jquery.scrollex.min.js"></script>
	<script src="assets/js/jquery.scrolly.min.js"></script>
	<script src="assets/js/skel.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>

</body>

</html>