<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<head>
	<title>Les Tableaux</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="assets/css/main.css" />
	<link rel="icon" type="image/png" href="favicon.png">
</head>

<body>

	<!-- Wrapper -->
	<div id="wrapper" class="fade-in">

		<!-- Intro -->
		<div id="intro">
			<h1>Tableaux du Tournoi</h1>
			<p>Cliquez sur les tableaux pour voir les inscrits</p>
			<ul class="actions">
				<li><a href="#header" class="button icon solo fa-arrow-down scrolly">Les tableaux</a></li>
			</ul>
		</div>

		<!-- Header -->
		<header id="header">
			<a href="index.html" class="logo">Retourner au formulaire</a>
		</header>

		<!-- Main -->
		<div id="main">
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
					<td><a href="tableau.php?tab=tableauA" style="color:midnightblue;">A</a></td>
					<td><a href="tableau.php?tab=tableauA" style="color:midnightblue;">NC à 13(&lsaquo;1399)</a></td>
					<td>
						<?php
						$cnx = mysqli_connect();
						if (mysqli_connect_errno()) // on verifie si la connection a reussi
						{
							echo 'impossible de se connecter a mysql';
						}
						$sql = "SELECT count(*) as nbInscrits FROM tableauA";
						$result = mysqli_query($cnx, $sql);
						$row = mysqli_fetch_assoc($result);
						echo $row['nbInscrits'];
						?>/72
					</td>
					<td>10€</td>
					<td>15€</td>
					<td>30€</td>
					<td>60€</td>
					<td>8€</td>
					<td>Sam. 9H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauB" style="color:midnightblue;">B</a></td>
					<td><a href="tableau.php?tab=tableauB" style="color:midnightblue;">NC à 8(&lsaquo;899)</a></td>
					<td><?php
						$cnx = mysqli_connect();
						if (mysqli_connect_errno()) // on verifie si la connection a reussi
						{
							echo 'impossible de se connecter a mysql';
						}
						$sql = "SELECT count(*) as nbInscrits FROM tableauB";
						$result = mysqli_query($cnx, $sql);
						$row = mysqli_fetch_assoc($result);
						echo $row['nbInscrits'];
						?>/72</td>
					<td>5€</td>
					<td>10€</td>
					<td>20€</td>
					<td>40€</td>
					<td>7€</td>
					<td>Sam. 10H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauC" style="color:midnightblue;">C</a></td>
					<td><a href="tableau.php?tab=tableauC" style="color:midnightblue;">NC à 18(&lsaquo;1899)</a> </td>
					<td><?php
						$cnx = mysqli_connect();
						if (mysqli_connect_errno()) // on verifie si la connection a reussi
						{
							echo 'impossible de se connecter a mysql';
						}
						$sql = "SELECT count(*) as nbInscrits FROM tableauC";
						$result = mysqli_query($cnx, $sql);
						$row = mysqli_fetch_assoc($result);
						echo $row['nbInscrits'];
						?>
						/72</td>
					<td>10€</td>
					<td>20€</td>
					<td>40€</td>
					<td>80€</td>
					<td>8€</td>
					<td>Sam. 11H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauD" style="color:midnightblue;">D</a></td>
					<td><a href="tableau.php?tab=tableauD" style="color:midnightblue;">NC à 11(&lsaquo;1199)</a> </td>
					<td><?php
						$cnx = mysqli_connect();
						if (mysqli_connect_errno()) // on verifie si la connection a reussi
						{
							echo 'impossible de se connecter a mysql';
						}
						$sql = "SELECT count(*) as nbInscrits FROM tableauD";
						$result = mysqli_query($cnx, $sql);
						$row = mysqli_fetch_assoc($result);
						echo $row['nbInscrits'];
						?>/72</td>
					<td>5€</td>
					<td>10€</td>
					<td>20€</td>
					<td>40€</td>
					<td>7€</td>
					<td>Sam. 12H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauE" style="color:midnightblue;">E</a></td>
					<td><a href="tableau.php?tab=tableauE" style="color:midnightblue;">NC à 15(&lsaquo;1599)</a> </td>
					<td><?php
						$cnx = mysqli_connect();
						if (mysqli_connect_errno()) // on verifie si la connection a réussie
						{
							echo 'impossible de se connecter a mysql';
						}
						$sql = "SELECT count(*) as nbInscrits FROM tableauE";
						$result = mysqli_query($cnx, $sql);
						$row = mysqli_fetch_assoc($result);
						echo $row['nbInscrits'];
						?>/72</td>
					<td>10€</td>
					<td>15€</td>
					<td>30€</td>
					<td>60€</td>
					<td>8€</td>
					<td>Sam. 13H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauF" style="color:midnightblue;">F</a></td>
					<td><a href="tableau.php?tab=tableauF" style="color:midnightblue;">NC à n°1001</a></td>
					<td><?php
						$cnx = mysqli_connect();
						if (mysqli_connect_errno()) // on verifie si la connection a reussi
						{
							echo 'impossible de se connecter a mysql';
						}
						$sql = "SELECT count(*) as nbInscrits FROM tableauF";
						$result = mysqli_query($cnx, $sql);
						$row = mysqli_fetch_assoc($result);
						echo $row['nbInscrits'];
						?>/72</td>
					<td>15€</td>
					<td>25€</td>
					<td>50€</td>
					<td>100€</td>
					<td>8€</td>
					<td>Sam. 14H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauG" style="color:midnightblue;">G</a></td>
					<td><a href="tableau.php?tab=tableauG" style="color:midnightblue;">Benjamins et Minimes</a></td>
					<td><?php
						$cnx = mysqli_connect();
						if (mysqli_connect_errno()) // on verifie si la connection a reussi
						{
							echo 'impossible de se connecter a mysql';
						}
						$sql = "SELECT count(*) as nbInscrits FROM tableauG";
						$result = mysqli_query($cnx, $sql);
						$row = mysqli_fetch_assoc($result);
						echo $row['nbInscrits'];
						?>/36</td>
					<td>Lots</td>
					<td>Lots</td>
					<td>Lots</td>
					<td>Lots+Coupe</td>
					<td>5€</td>
					<td>Sam. 15H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauH" style="color:midnightblue;">H</a></td>
					<td><a href="tableau.php?tab=tableauH" style="color:midnightblue;">NC à 14(&lsaquo;1499)</a></td>
					<td><?php
						$cnx = mysqli_connect();
						if (mysqli_connect_errno()) // on verifie si la connection a reussi
						{
							echo 'impossible de se connecter a mysql';
						}
						$sql = "SELECT count(*) as nbInscrits FROM tableauH";
						$result = mysqli_query($cnx, $sql);
						$row = mysqli_fetch_assoc($result);
						echo $row['nbInscrits'];
						?>/72</td>
					<td>10€</td>
					<td>15€</td>
					<td>30€</td>
					<td>60€</td>
					<td>8€</td>
					<td>Dim. 9H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauI" style="color:midnightblue;">I</a></td>
					<td><a href="tableau.php?tab=tableauI" style="color:midnightblue;">NC à 9(&lsaquo;999)</a></td>
					<td><?php
						$cnx = mysqli_connect();
						if (mysqli_connect_errno()) // on verifie si la connection a reussi
						{
							echo 'impossible de se connecter a mysql';
						}
						$sql = "SELECT count(*) as nbInscrits FROM tableauI";
						$result = mysqli_query($cnx, $sql);
						$row = mysqli_fetch_assoc($result);
						echo $row['nbInscrits'];
						?>/72</td>
					<td>5€</td>
					<td>10€</td>
					<td>20€</td>
					<td>40€</td>
					<td>7€</td>
					<td>Dim. 10H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauJ" style="color:midnightblue;">J</a></td>
					<td><a href="tableau.php?tab=tableauJ" style="color:midnightblue;">NC à n°300</a></td>
					<td><?php
						$cnx = mysqli_connect();
						if (mysqli_connect_errno()) // on verifie si la connection a reussi
						{
							echo 'impossible de se connecter a mysql';
						}
						$sql = "SELECT count(*) as nbInscrits FROM tableauJ";
						$result = mysqli_query($cnx, $sql);
						$row = mysqli_fetch_assoc($result);
						echo $row['nbInscrits'];
						?>/72</td>
					<td>15€</td>
					<td>30€</td>
					<td>70€</td>
					<td>140€</td>
					<td>8€</td>
					<td>Dim. 11H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauK" style="color:midnightblue;">K</a></td>
					<td><a href="tableau.php?tab=tableauK" style="color:midnightblue;">NC à 12(&lsaquo;1299)</a></td>
					<td><?php
						$cnx = mysqli_connect();
						if (mysqli_connect_errno()) // on verifie si la connection a reussi
						{
							echo 'impossible de se connecter a mysql';
						}
						$sql = "SELECT count(*) as nbInscrits FROM tableauK";
						$result = mysqli_query($cnx, $sql);
						$row = mysqli_fetch_assoc($result);
						echo $row['nbInscrits'];
						?>/72</td>
					<td>10€</td>
					<td>20€</td>
					<td>40€</td>
					<td>80€</td>
					<td>8€</td>
					<td>Dim. 12H00</td>
				</tr>

				<tr>
					<td><a href="tableau.php?tab=tableauL" style="color:midnightblue;">L</a></td>
					<td><a href="tableau.php?tab=tableauL" style="color:midnightblue;">NC à 17(&lsaquo;1799)</a></td>
					<td><?php
						$cnx = mysqli_connect();
						if (mysqli_connect_errno()) // on verifie si la connection a reussi
						{
							echo 'impossible de se connecter a mysql';
						}
						$sql = "SELECT count(*) as nbInscrits FROM tableauL";
						$result = mysqli_query($cnx, $sql);
						$row = mysqli_fetch_assoc($result);
						echo $row['nbInscrits'];
						?>/72</td>
					<td>10€</td>
					<td>20€</td>
					<td>40€</td>
					<td>80€</td>
					<td>8€</td>
					<td>Dim. 13H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauM" style="color:midnightblue;">M</a></td>
					<td><a href="tableau.php?tab=tableauM" style="color:midnightblue;">Toutes Catégories Messieurs</a></td>
					<td><?php
						$cnx = mysqli_connect();
						if (mysqli_connect_errno()) // on verifie si la connection a reussi
						{
							echo 'impossible de se connecter a mysql';
						}
						$sql = "SELECT count(*) as nbInscrits FROM tableauM";
						$result = mysqli_query($cnx, $sql);
						$row = mysqli_fetch_assoc($result);
						echo $row['nbInscrits'];
						?>/72</td>
					<td>30€</td>
					<td>60€</td>
					<td>120€</td>
					<td>240€</td>
					<td>10€</td>
					<td>Dim. 14H00</td>
				</tr>
				<tr>
					<td><a href="tableau.php?tab=tableauN" style="color:midnightblue;">N</a></td>
					<td><a href="tableau.php?tab=tableauN" style="color:midnightblue;">Elite Dames TC</a></td>
					<td><?php
						$cnx = mysqli_connect();
						if (mysqli_connect_errno()) // on verifie si la connection a réussi
						{
							echo 'impossible de se connecter a mysql';
						}
						$sql = "SELECT count(*) as nbInscrits FROM tableauN";
						$result = mysqli_query($cnx, $sql);
						$row = mysqli_fetch_assoc($result);
						echo $row['nbInscrits'];
						?>/36</td>
					<td>10€</td>
					<td>20€</td>
					<td>40€</td>
					<td>80€</td>
					<td>8€</td>
					<td>Dim. 15H00</td>
				</tr>
			</table>

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