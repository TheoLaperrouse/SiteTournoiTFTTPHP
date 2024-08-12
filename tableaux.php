<?php session_start();
	require_once __DIR__ . "/Technique/AutoLoad.php";
	\Technique\AutoLoad::loadTFTT();
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Les Tableaux</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="./assets/css/main.css" />
	<link rel="icon" type="image/png" href="./favicon.png">
</head>
<body>
	<div id="wrapper" class="fade-in">
		<div id="intro">
			<h1>Tableaux du Tournoi</h1>
			<p>Cliquez sur les tableaux pour voir les inscrits</p>
			<ul class="actions">
				<li><a href="#header" class="button icon solo fa-arrow-down scrolly">Les tableaux</a></li>
			</ul>
		</div>
		<header id="header">
			<a href="index.php" class="logo">Retourner au formulaire</a>
		</header>
		<div id="main" style="overflow-y: scroll;">
			<table>
				<tr>
					<th>N°</th>
					<th>Tableau</th>
					<th>Places</th>
					<th>1/4 de Finalistes</th>
					<th>1/2 de Finalistes</th>
					<th>Finalistes</th>
					<th>Vainqueurs</th>
					<th>Engagements</th>
					<th>Jour et Heure</th>
				</tr>
				<?php echo model_Tableau::getRowTableau("A"); ?>
				<?php echo model_Tableau::getRowTableau("B"); ?>
				<?php echo model_Tableau::getRowTableau("C"); ?>
				<?php echo model_Tableau::getRowTableau("D"); ?>
				<?php echo model_Tableau::getRowTableau("E"); ?>
				<?php echo model_Tableau::getRowTableau("F"); ?>
				<?php echo model_Tableau::getRowTableau("G"); ?>
				<?php echo model_Tableau::getRowTableau("H"); ?>
				<?php echo model_Tableau::getRowTableau("I"); ?>
				<?php echo model_Tableau::getRowTableau("J"); ?>
				<?php echo model_Tableau::getRowTableau("K"); ?>
				<?php echo model_Tableau::getRowTableau("L"); ?>
				<?php echo model_Tableau::getRowTableau("M"); ?>
				<?php echo model_Tableau::getRowTableau("N"); ?>
			</table>
			<h3 class="center">Nombre d'inscriptions : <?php echo Functions::execSqlFile("sql/getTotalInscriptions.sql"); ?>
			<br>Nombre de joueurs : <?php echo Functions::execSqlFile("sql/getAllDistinctPlayers.sql"); ?></h3>
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

	</div>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/jquery.scrollex.min.js"></script>
	<script src="assets/js/jquery.scrolly.min.js"></script>
	<script src="assets/js/skel.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>
</body>

</html>