<?php session_start();
	require_once __DIR__ . "/../Technique/AutoLoad.php";
	\Technique\AutoLoad::loadTFTT();
	\Technique\AutoLoad::TryConnect(false);
	
	Tools::logToFile("session.log","SESSION : " . serialize($_SESSION)) ;
	Tools::logToFile("session.log","COOKIE : " . serialize($_COOKIE)) ;
	
	$auth = UserInfo::is_set('UserId');
	if (isset($_POST["mail"])) {
		if (!$auth) {
			$utilisateur = new model_Utilisateur();
			$utilisateur->row = array() ;
			$utilisateur->row["uti_mail"] = $_POST["mail"] ;
			$utilisateur->row["uti_password"] = $_POST["password"] ;
			if ($utilisateur->Authentifie()) {
				UserInfo::destroy();
				UserInfo::setCookie('TFTTId', md5(_TFTT_COOKIE_KEY_ . $utilisateur->row["uti_mail"] . $utilisateur->row["uti_password"]));
				UserInfo::setSessionUser($utilisateur);
				
		Tools::logToFile("session.log","CONNEXION : " . serialize($_SESSION)) ;
				include('admin.html');
			} else {
				include('echec.html');
			}
		} else {
			include('admin.html');
		}
	} else {
		if (!$auth) {
			include('connexion.html');
		} else {
			include('admin.html');
		}
	}
	\Technique\AutoLoad::exitTFTT();
?>
