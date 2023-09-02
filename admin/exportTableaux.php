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
    <link rel="stylesheet" href="./../assets/css/main.css" />
  </head>

  <body class="is-preload">
    <div id="wrapper" class="fade-in">
      <header id="header">
          <h2 class="center">Export des données</h2>
		  <a href="./connexion.php" class="logo">Retournez aux panneau d'admin</a>
      </header>
      <div id="main">
        <article>
<?php		
		echo Functions::exportTableau() ;
?>
        </article>
      </div>
      <div id="copyright">
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
<?php
	}
	\Technique\AutoLoad::exitTFTT();
?>