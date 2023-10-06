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
	$NumJournee = $_REQUEST['NumJournee'] ?? "";
	$Auteur = $_REQUEST['Auteur'] ?? "";
	$CR = $_REQUEST['CR'] ?? "";
	$Locked = $_REQUEST['Locked'] ?? 0;
	$Actif = $_REQUEST['Actif'] ?? 0;
	$DateMatch = $_REQUEST['DateMatch'] ?? '';

	if ($mode == "SAVE") {
		model_CR::Update($NumJournee, $Auteur, $CR, $DateMatch, $Actif, $Locked);
		$arr = array('status' => 'OK', 'message' => utf8_encode('Le compte-rendu est sauvegardé'));
		
		header('Content-type: application/json');
		echo json_encode($arr);
		\Technique\AutoLoad::exitTFTT();
	}
	if ($mode == "EDIT") {
		$cr = model_CR::GetCRByNumJournee($_REQUEST["NumJournee"]);
		$view = new view_CR();
		$view->_CR = $cr ;
		$html = $view->getHTML();
		array_walk_recursive($cr->row,'encode_items');
		$arr = array('status' => 'OK', 'html' => utf8_encode($html), 'row' => $cr->row);
		header('Content-type: application/json');
		echo json_encode($arr);
		\Technique\AutoLoad::exitTFTT();
	}
	
	\Technique\AutoLoad::exitTFTT();
?>