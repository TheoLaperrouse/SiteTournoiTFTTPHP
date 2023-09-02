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
				<tr>
					<td><a href="tableau.php?tab=tableauA" class="link">A</a></td>
					<td><a href="tableau.php?tab=tableauA" class="link">NC à 13(&lsaquo;1399)</a></td>
					<td>
						<?php echo Functions::getPlaceRestantes("A"); ?>
					</td>
					<td>10€</td>
					<td>15€</td>
					<td>30€</td>
					<td>60€</td>
					<td><?php echo Functions::getPrixTableau("A"); ?>€</td>
					<td>Sam. 9H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauB" class="link">B</a></td>
					<td><a href="tableau.php?tab=tableauB" class="link">NC à 8(&lsaquo;899)</a></td>
					<td><?php echo Functions::getPlaceRestantes("B"); ?></td>
					<td>5€</td>
					<td>10€</td>
					<td>20€</td>
					<td>40€</td>
					<td><?php echo Functions::getPrixTableau("B"); ?>€</td>
					<td>Sam. 10H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauC" class="link">C</a></td>
					<td><a href="tableau.php?tab=tableauC" class="link">NC à 18(&lsaquo;1899)</a> </td>
					<td><?php echo Functions::getPlaceRestantes("C"); ?></td>
					<td>10€</td>
					<td>20€</td>
					<td>40€</td>
					<td>80€</td>
					<td><?php echo Functions::getPrixTableau("C"); ?>€</td>
					<td>Sam. 11H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauD" class="link">D</a></td>
					<td><a href="tableau.php?tab=tableauD" class="link">NC à 11(&lsaquo;1199)</a> </td>
					<td><?php echo Functions::getPlaceRestantes("D"); ?></td>
					<td>5€</td>
					<td>10€</td>
					<td>20€</td>
					<td>40€</td>
					<td><?php echo Functions::getPrixTableau("D"); ?>€</td>
					<td>Sam. 12H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauE" class="link">E</a></td>
					<td><a href="tableau.php?tab=tableauE" class="link">NC à 15(&lsaquo;1599)</a> </td>
					<td><?php echo Functions::getPlaceRestantes("E"); ?></td>
					<td>10€</td>
					<td>15€</td>
					<td>30€</td>
					<td>60€</td>
					<td><?php echo Functions::getPrixTableau("E"); ?>€</td>
					<td>Sam. 13H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauF" class="link">F</a></td>
					<td><a href="tableau.php?tab=tableauF" class="link">NC à n°1001</a></td>
					<td><?php echo Functions::getPlaceRestantes("F"); ?></td>
					<td>15€</td>
					<td>25€</td>
					<td>50€</td>
					<td>100€</td>
					<td><?php echo Functions::getPrixTableau("F"); ?>€</td>
					<td>Sam. 14H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauG" class="link">G</a></td>
					<td><a href="tableau.php?tab=tableauG" class="link">Benjamins et Minimes</a></td>
					<td><?php echo Functions::getPlaceRestantes("G"); ?></td>
					<td>Lots</td>
					<td>Lots</td>
					<td>Lots</td>
					<td>Lots+Coupe</td>
					<td><?php echo Functions::getPrixTableau("G"); ?>€</td>
					<td>Sam. 15H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauH" class="link">H</a></td>
					<td><a href="tableau.php?tab=tableauH" class="link">NC à 14(&lsaquo;1499)</a></td>
					<td><?php echo Functions::getPlaceRestantes("H"); ?></td>
					<td>10€</td>
					<td>15€</td>
					<td>30€</td>
					<td>60€</td>
					<td><?php echo Functions::getPrixTableau("H"); ?>€</td>
					<td>Dim. 9H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauI" class="link">I</a></td>
					<td><a href="tableau.php?tab=tableauI" class="link">NC à 9(&lsaquo;999)</a></td>
					<td><?php echo Functions::getPlaceRestantes("I"); ?></td>
					<td>5€</td>
					<td>10€</td>
					<td>20€</td>
					<td>40€</td>
					<td><?php echo Functions::getPrixTableau("I"); ?>€</td>
					<td>Dim. 10H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauJ" class="link">J</a></td>
					<td><a href="tableau.php?tab=tableauJ" class="link">NC à n°300</a></td>
					<td><?php echo Functions::getPlaceRestantes("J"); ?></td>
					<td>15€</td>
					<td>30€</td>
					<td>70€</td>
					<td>140€</td>
					<td><?php echo Functions::getPrixTableau("J"); ?>€</td>
					<td>Dim. 11H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauK" class="link">K</a></td>
					<td><a href="tableau.php?tab=tableauK" class="link">NC à 12(&lsaquo;1299)</a></td>
					<td><?php echo Functions::getPlaceRestantes("K"); ?></td>
					<td>5€</td>
					<td>10€</td>
					<td>20€</td>
					<td>40€</td>
					<td><?php echo Functions::getPrixTableau("K"); ?>€</td>
					<td>Dim. 12H00</td>
				</tr>

				<tr>
					<td><a href="tableau.php?tab=tableauL" class="link">L</a></td>
					<td><a href="tableau.php?tab=tableauL" class="link">NC à 17(&lsaquo;1799)</a></td>
					<td><?php echo Functions::getPlaceRestantes("L"); ?></td>
					<td>10€</td>
					<td>20€</td>
					<td>40€</td>
					<td>80€</td>
					<td><?php echo Functions::getPrixTableau("L"); ?>€</td>
					<td>Dim. 13H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauM" class="link">M</a></td>
					<td><a href="tableau.php?tab=tableauM" class="link">Toutes Catégories Messieurs</a></td>
					<td><?php echo Functions::getPlaceRestantes("M"); ?></td>
					<td>30€</td>
					<td>60€</td>
					<td>120€</td>
					<td>240€</td>
					<td><?php echo Functions::getPrixTableau("M"); ?>€</td>
					<td>Dim. 14H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauN" class="link">N</a></td>
					<td><a href="tableau.php?tab=tableauN" class="link">Elite Dames TC</a></td>
					<td><?php echo Functions::getPlaceRestantes("N"); ?></td>
					<td>10€</td>
					<td>20€</td>
					<td>40€</td>
					<td>80€</td>
					<td><?php echo Functions::getPrixTableau("N"); ?>€</td>
					<td>Dim. 15H00</td>
				</tr>
			</table>
			<h3 class="center">Nombre d'inscriptions : <?php echo Functions::execSqlFile("sql/getTotalInscriptions.sql"); ?>
			<br>Nombre de joueurs : <?php echo Functions::execSqlFile("sql/getAllDistinctPlayers.sql"); ?></h3>
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