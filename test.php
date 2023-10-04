<?php
	require_once __DIR__ . "/Technique/AutoLoad.php";
	\Technique\AutoLoad::loadTFTT();
	$html = view_WP::getHTMLPartenaires();
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
<?php 
	echo $html ;
?>

</body>

</html>