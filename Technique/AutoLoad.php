<?php
namespace Technique;

class AutoLoad {
	public static $root = __DIR__ . "/../" ;
	
	public static function loadTFTT($isConfig = true, $isBDDGlobal = true) {
		if ($isConfig) {
			require_once self::$root . "Config.php";
		}
		self::UtilsAll();
		self::ModelAll();
		self::ViewAll();
		
		if ($isBDDGlobal) {
			\BDD\SGBD::setGlobal();
			\BDD\SGBD::GetInstance(true);
		}
	}
	public static function dieTFTT($message) {
		$arr = array('status' => 'KO','message' => utf8_encode($message));
		header('Content-type: application/json');
		echo json_encode($arr);
		self::exitTFTT();
	}
	public static function exitSession() {
		$arr = array('status' => 'KO','message' => utf8_encode("Vous avez perdu votre session, vous devez vous reconnecter"));
		header('Content-type: application/json');
		echo json_encode($arr);
		self::exitTFTT();
	}
	public static function exitGeneric() {
		self::exitTFTT();
	}
	public static function exitTFTT($exit = true) {
		\BDD\SGBD::unsetGlobal();
		if ($exit) exit();
	}
	public static function CheckSession() {
		$auth = \UserInfo::is_set('UserId');
		if (!$auth) {
			\Technique\AutoLoad::exitSession();
		}
	}
	public static function TryConnect($exit = true) {
		$auth = \UserInfo::is_set('UserId');
		if (!$auth) {
			\UserInfo::TryConnectFromCookie();
			$auth = \UserInfo::is_set('UserId');
			if (!$auth) {
				if ($exit) self::exitSession();
			}
		}
	}
	public static function ModelAll($except = '') {
		self::ModelDivers($except);
	}
	public static function UtilsAll($except = '') {
		self::UtilsCommon($except);
		self::UtilsBBD($except);
		self::UtilsTechnique($except);
	}
	public static function UtilsBBD($except = '') {
		require_once self::$root . "BDD/StoredProcedure.php";
		require_once self::$root . "BDD/Connection.php";
		require_once self::$root . "BDD/SGBD.php";
	}
	public static function UtilsTechnique($except = '') {
		if ($except != 'Tools') require_once self::$root . "Technique/Tools.php";
		if ($except != 'Template') require_once self::$root . "Technique/Template.php";
		if ($except != 'Tableaux') require_once self::$root . "Technique/Tableaux.php";
		if ($except != 'Functions') require_once self::$root . "Technique/Functions.php";
		require_once self::$root . "Technique/PHPMailer/vendor/autoload.php";
		//require_once self::$root . "Technique/Excel/vendor/autoload.php";
	}
	public static function UtilsCommon($except = '') {
		if ($except != 'Mail') require_once self::$root . "Common/Mail.php";
		if ($except != 'UserInfo') require_once self::$root . "Common/UserInfo.php";
	}
	public static function ModelDivers($except = '') {
		if ($except != 'Utilisateur') require_once self::$root . "Model/Utilisateur.php";
		if ($except != 'Joueur') require_once self::$root . "Model/Joueur.php";
		if ($except != 'Tableau') require_once self::$root . "Model/Tableau.php";
		if ($except != 'CR') require_once self::$root . "Model/CR.php";
	}
	public static function ViewAll() {
		require_once self::$root . "View/View.php";
		require_once self::$root . "View/WP.php";
		require_once self::$root . "View/CR.php";
	}
}
?>