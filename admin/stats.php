<?php
	require_once __DIR__ . "./../Technique/AutoLoad.php";
	\Technique\AutoLoad::loadTFTT();
	\Technique\AutoLoad::TryConnect(false);
	$auth = UserInfo::is_set('UserId');
	if (!$auth) {
		\BDD\SGBD::unsetGlobal();
		header('Location: ./connexion.php');
	}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Les Stats du tournoi</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="./../assets/css/main.css" />
	<link rel="icon" type="image/png" href="./../favicon.png">
</head>
<body class="is-loading">
	<div id="wrapper" class="fade-in">
		<header id="header">
			<a href="./connexion.php" class="logo">Retournez aux panneau d'admin</a>
		</header>
		<div id="main">
			<?php
                $distinctPlayers = Functions::execSqlFile("./../sql/getAllDistinctPlayers.sql");
                $nbInscript = Functions::execSqlFile("./../sql/getTotalInscriptions.sql");
				$meanTab =  number_format($nbInscript / $distinctPlayers,2);
                $nbNumero = Functions::execSqlFile("./../sql/getTotalNumero.sql");
                $recipies = model_Tableau::getRecipies();
				echo "<h4 class='center'>Nombre d'inscriptions : $nbInscript<br>Nombre de joueurs différents : $distinctPlayers<br>Moyenne de tableau/joueur : $meanTab<br>Nombre de joueurs numérotés : $nbNumero<br>Recette des inscriptions : $recipies €</h4>";
				\Technique\AutoLoad::exitTFTT();
			?>
		</div>
		<div id="copyright">
			<ul>
          <li>
            <h3>
              Si vous avez un problème avec votre inscription, veuillez me
              contacter par mail (contact@migratio.fr) ou par Messenger(<a
                href="https://www.facebook.com/messages/t/stephane.lerouzic.5"
              >
                Stéphane Le Rouzic</a
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

	<script src="./../assets/js/jquery.min.js"></script>
	<script src="./../assets/js/jquery.scrollex.min.js"></script>
	<script src="./../assets/js/jquery.scrolly.min.js"></script>
	<script src="./../assets/js/skel.min.js"></script>
	<script src="./../assets/js/util.js"></script>
	<script src="./../assets/js/main.js"></script>

</body>

</html>