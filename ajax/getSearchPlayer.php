<?php session_start();
	require_once __DIR__ . "/../Technique/AutoLoad.php";
	\Technique\AutoLoad::loadTFTT();
	\Technique\AutoLoad::TryConnect(false);
	$auth = UserInfo::is_set('UserId');
	if (!$auth) {
		echo json_encode(array());
		\Technique\AutoLoad::exitTFTT();
	}
	$mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : "";

	$term = isset($_GET['term']) ? $_GET['term'] : "";
	 
	$a_json_invalid = array(array("id" => "#", "value" => $term, "label" => "Only letters and digits are permitted..."));
	$json_invalid = json_encode($a_json_invalid);
	 
	// replace multiple spaces with one
	$term = preg_replace('/\s+/', ' ', $term);
	 
	// SECURITY HOLE ***************************************************************
	// allow space, any unicode letter and digit, underscore and dash
	if(preg_match("/[^\040\pL\pN_-]/u", $term)) {
		print $json_invalid;
		\Technique\AutoLoad::exitTFTT();
	}
	
	$numLicence = "";
	if (is_numeric($term)) {
		$numLicence = $term ;
		$term = "";
	}
	
	$liste = model_Joueur::ListeTableaux($term,$numLicence);
	header('Content-type: application/json');
	$a_json = array();
	$a_json_row = array();
	
	foreach($liste as $item) {
		$a_value = array('numLicence' => $item["numLicence"], 'nombrePoints' => $item["nombrePoints"], 'aTableaux' => $item["tableaux"], 'aNotTableaux' => $item["NotTableaux"], 'tableaux' => implode(',',$item["tableaux"]), 'prenom' => utf8_encode($item["prenom"]), 'nom' => utf8_encode($item["nom"]), 'club' => utf8_encode($item["club"]));
		$a_json_row["id"] = $item["numLicence"];
		$label = "(" . $item["numLicence"] . ") - " . $item["prenom"] . " " . $item["nom"] . " - " . $item["club"] . " (" . $item["nombrePoints"] .")" ;
		$a_json_row["value"] = utf8_encode($label) ;
		$a_json_row["label"] = utf8_encode($label) ;
		$a_json_row["item"] = $a_value ;
		array_push($a_json, $a_json_row);
	}
	
	echo json_encode($a_json);
	\Technique\AutoLoad::exitTFTT();
?>