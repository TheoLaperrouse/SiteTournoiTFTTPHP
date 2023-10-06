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
	$numLicence = $_REQUEST['numLicence'] ?? "";
	$club = $_REQUEST['club'] ?? "";
	$nom = $_REQUEST['nom'] ?? "";
	$prenom = $_REQUEST['prenom'] ?? "";
	$nombrePoints = $_REQUEST['nombrePoints'] ?? "";

	if ($mode == "ADD_TABLEAU") {
		$lettre = isset($_REQUEST['lettre']) ? $_REQUEST['lettre'] : "";
		$liste = model_Joueur::ListeTableaux("",$numLicence);
		if (count($liste) == 1) {
			$item = $liste[$numLicence] ;
			
			$arr = model_Joueur::AddJoueurToTableau(utf8_encode($item["prenom"]), $item["nom"], $item["nombrePoints"], $item["numLicence"], $item["club"], $lettre) ;
			
			$liste = model_Joueur::ListeTableaux("",$numLicence);
			$item = $liste[$numLicence] ;
			$item['aTableaux'] = $item["tableaux"] ;
			$item['aNotTableaux'] = $item["NotTableaux"] ;
			$item['tableaux'] = implode(',',$item["tableaux"]) ;
			array_walk_recursive($item,'encode_items') ;
			$arr["item"] = $item ;
		} else {
			$arr = array('status' => 'KO', 'message' => utf8_encode('Le numéro de licence ramène plusieurs lignes'));
		}
		header('Content-type: application/json');
		echo json_encode($arr);
		\Technique\AutoLoad::exitTFTT();
	}
	if ($mode == "DELETE_TABLEAU") {
		$lettre = isset($_REQUEST['lettre']) ? $_REQUEST['lettre'] : "";
		model_Joueur::DeleteTableau($numLicence, $lettre);
		$arr = array('status' => 'OK', 'message' => utf8_encode('Suppression du tableau ' . $lettre));
		header('Content-type: application/json');
		echo json_encode($arr);
		\Technique\AutoLoad::exitTFTT();
	}
	if ($mode == "MODIF") {
		$liste = model_Joueur::ListeTableaux("",$numLicence);
		if (count($liste) == 1) {
			$item = $liste[$numLicence] ;
			$aTableau = $item["tableaux"] ;
			model_Joueur::UpdateJoueur($numLicence, $club, $nom, $prenom, $nombrePoints, $aTableau);
			
			array_walk_recursive($liste,'encode_items') ;
			array_walk_recursive($item,'encode_items') ;
			$arr = array('status' => 'OK', 'message' => utf8_encode('un problème est survenu'),'tableaux' => $tableaux,'item' => $item);
			header('Content-type: application/json');
			echo json_encode($arr);
			\Technique\AutoLoad::exitTFTT();
		} else {
			array_walk_recursive($liste,'encode_items') ;
			$arr = array('status' => 'KO', 'message' => utf8_encode('un problème est survenu'),'liste' => $liste);
			header('Content-type: application/json');
			echo json_encode($arr);
			\Technique\AutoLoad::exitTFTT();
		}
		$arr = array('status' => 'OK', 'message' => utf8_encode('Modification du joueur ' . $nom));
		header('Content-type: application/json');
		echo json_encode($arr);
		\Technique\AutoLoad::exitTFTT();
	}
	if ($mode == "DESINSCRIPTION") {
		$arr = model_Joueur::DeleteByLicence($numLicence) ;
		$aTableaux = $arr["tableaux"] ;
		
		array_walk_recursive($aTableaux,'encode_items') ;
		$arr = array('status' => 'OK', 'tableaux' => $aTableaux);
		header('Content-type: application/json');
		echo json_encode($arr);
		\Technique\AutoLoad::exitTFTT();
	}
	\Technique\AutoLoad::exitTFTT();
?>