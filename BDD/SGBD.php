<?php
namespace BDD;

class SGBD {
    /** @var int Constant used by insert() method */
    const INSERT = 1;

    /** @var int Constant used by insert() method */
    const INSERT_IGNORE = 2;

    /** @var int Constant used by insert() method */
    const REPLACE = 3;

    /** @var int Constant used by insert() method */
    const ON_DUPLICATE_KEY = 4;
	
	public static $DB_USE_INSTANCE = false ;
	
	public static $DB_INSTANCE_NAME = "" ;
	public static $instance = null ;
	public static $is_instance_connected = false ;
	
	public static $DB_INSTANCE_SASKIT_NAME = "" ;
	public static $instanceSaskit = null ;
	public static $is_instanceSaskit_connected = false ;
	
	public $StoredProcedure = "";
	protected $_Server = "";
	protected $_Base = "";
	protected $_User = "";
	protected $_Password = "";
	protected $_Port = "";
	
	public $showQuery = 0;
	
	public static function setGlobal(){
		self::$DB_USE_INSTANCE = true ;
	}
	public static function unsetGlobal(){
		if (self::$DB_USE_INSTANCE == true && self::$instance !== null) {
			self::$instance->disconnect(true);
			self::$instance = null ;
			self::$DB_INSTANCE_NAME = "" ;
		}
		if (self::$DB_USE_INSTANCE == true && self::$instanceSaskit !== null) {
			self::$instanceSaskit->disconnect(true);
			self::$instanceSaskit = null ;
			self::$DB_INSTANCE_SASKIT_NAME = "" ;
		}
		self::$DB_USE_INSTANCE = false ;
	}
	public static function getItemsInstanceGeneric($bdd, $sp, $logexit = true, callable $callback = null, $arg = null) {
		$items = $bdd->getItems($sp,$logexit);
		
		if ($callback !== null && $items !== false) {
			foreach ($items as &$it) {
				if ($arg !== null) {
					$it = $callback($it,$arg) ;
				} else {
					$it = $callback($it) ;
				}
			}
		}
		return $items ;
	}
	public static function ExisteInstanceRowGeneric($bdd, $sp, $logexit = true) {
		$existe = false;
		$result = $bdd->Execute($sp,$logexit);
		if ($bdd->num_rows($result) == 1) {
			$row = $bdd->fetch_array($result);
			if ($row[0] > 0) {
				$existe = true;
			}
		}
		return $existe ;
	}
	public static function ExecuteInstanceGeneric($bdd, $sp, $logexit = true, $fetchRow = false, $assoc = true, $index = null) {
		$result = $bdd->Execute($sp,$logexit);
		if ($fetchRow) {
			if ($bdd->num_rows($result) != 0) {
				$row = ($assoc) ? $bdd->fetch_array_assoc($result) : $bdd->fetch_array($result) ;
				if (!$assoc && $index !== null) {
					return $row[$index] ;
				} else {
					return $row ;
				}
			} else {
				return null ;
			}
		} else {
			return $result ;
		}
	}
	public static function QueryInstanceGeneric($bdd, $sql, $logexit = true, $fetch = false, $assoc = true, $index = null) {
		$result = $bdd->query($sql,$logexit);
		if ($fetch) {
			if (!$result) {
				return false ;
			} else {
				if ($bdd->num_rows($result) != 0) {
					$row = ($assoc) ? $bdd->fetch_array_assoc($result) : $bdd->fetch_array($result) ;
					if (!$assoc && $index !== null) {
						return $row[$index] ;
					} else {
						return $row ;
					}
				} else {
					return null ;
				}
			}
		} else {
			return $result ;
		}
	}
	public static function getItemsInstance($sp, $logexit = true, callable $callback = null, $arg = null) {
		$bdd = self::GetInstance();
		return self::getItemsInstanceGeneric($bdd, $sp, $logexit, $callback, $arg) ;
	}
	public static function getItemsFieldInstance($sp, $logexit = true, $field = 0, $assoc = true) {
		$bdd = self::GetInstance();
		$items = $bdd->getItemsField($sp, $logexit, $field, $assoc);
		return $items ;
	}
	public static function ExecuteInstanceObject($sp, $logexit = true, callable $callback = null, $arg = null) {
		$bdd = self::GetInstance();
		$result = $bdd->Execute($sp,$logexit);
		$row = $bdd->fetch_array_assoc($result) ;
		if ($callback !== null) {
			if ($arg !== null) {
				$row = $callback($row,$arg) ;
			} else {
				$row = $callback($row) ;
			}
		}
		return $row ;
	}
	public static function QueriesInstance($sql, $logexit = true) {
		$bdd = self::GetInstance();
		$bdd->queries($sql,$logexit);
	}
	public static function QueryInstance($sql, $logexit = true, $fetchRow = false, $assoc = true, $index = null) {
		$bdd = self::GetInstance();
		return self::QueryInstanceGeneric($bdd, $sql, $logexit, $fetchRow, $assoc, $index) ;
	}
	public static function GetInstanceRow($sql) {
		$bdd = self::GetInstance();
		return $bdd->getRow($sql);
	}
	public static function GetInstanceValue($sql) {
		$bdd = self::GetInstance();
		return $bdd->getValue($sql);
	}
	public static function ExecuteInstanceRow($sp, $logexit = true, $assoc = true, $index = null) {
		$bdd = self::GetInstance();
		return self::ExecuteInstanceGeneric($bdd, $sp, $logexit, true, $assoc, $index);
	}
	public static function ExecuteInstance($sp, $logexit = true, $fetchRow = false, $assoc = true, $index = null) {
		$bdd = self::GetInstance();
		return self::ExecuteInstanceGeneric($bdd, $sp, $logexit, $fetchRow, $assoc, $index);
	}
	public static function ExisteInstanceRow($sp, $logexit = true) {
		$bdd = self::GetInstance();
		return self::ExisteInstanceRowGeneric($bdd, $sp, $logexit);
	}
	public static function InsertInstance($table, $data, $null_values = false, $use_cache = true, $type = SGBD::INSERT, $add_prefix = true) {
		$bdd = self::GetInstance();
		return $bdd->insert($table, $data, $null_values, $use_cache, $type, $add_prefix) ;
	}
	public static function UpdateInstance($table, $data, $where = '', $limit = 0, $null_values = false, $add_prefix = true) {
		$bdd = self::GetInstance();
		return $bdd->update($table, $data, $where, $limit, $null_values, $add_prefix) ;
	}
	public static function DeleteInstance($table, $prefix = _DB_PREFIX_, $where = '', $limit = 0, $add_prefix = true) {
		$bdd = self::GetInstance();
		return $bdd->delete($table, $prefix, $where, $limit, $add_prefix) ;
	}
	public static function real_escape_string($a){
		$bdd = self::GetInstance();
		return $bdd->mysqli_real_escape_string($a) ;
	}
	public static function GetInstance($connect = false) {
		if (self::$DB_USE_INSTANCE == true && self::$instance !== null) {
			return self::$instance ;
			
		} else if (self::$instance === null || self::$DB_USE_INSTANCE == false) {
			$dom = new \DomDocument();
			$dom->load(__DIR__ . "/../Config/".cst_BDD);
			$xpath = new \DOMXPath($dom);
			$root = $dom->documentElement;
			
			$sDriver = $root->getElementsByTagName("Driver")->item(0)->nodeValue;

			$sClassName = $sDriver;
			
			require_once $sClassName.'.php';
			$sClassName = '\BDD\\'.$sClassName ;
			$cnn = new $sClassName;
			
			$cnn->_Server = $root->getElementsByTagName("Server")->item(0)->nodeValue;
			$cnn->_Base = $root->getElementsByTagName("Base")->item(0)->nodeValue;
			$cnn->_User = $root->getElementsByTagName("User")->item(0)->nodeValue;
			$cnn->_Password = $root->getElementsByTagName("Password")->item(0)->nodeValue;
			try {
				if ($root->getElementsByTagName("Port") != null && $root->getElementsByTagName("Port")->item(0) != null) {
					$cnn->_Port = $root->getElementsByTagName("Port")->item(0)->nodeValue;
				}
			} catch(Exception $e) {
				
			}
			if ($connect) {
				$cnn->connect();
				if (self::$DB_USE_INSTANCE == true) {
					self::$is_instance_connected = true ;
				}
			}
			if (self::$DB_USE_INSTANCE == true) {
				self::$instance = $cnn ;
				self::$DB_INSTANCE_NAME = $cnn->_Base ;
			}
			return $cnn;
		}
		return null;
	}
	public static function GetInstanceParams($f) {
		$p = self::GetParams($f);
		
		$sClassName = $p["Driver"];
		require_once $sClassName.'.php';
		$sClassName = '\BDD\\'.$sClassName ;
		$bdd = new $sClassName;
		
		$bdd->_Server = $p["Server"];
		$bdd->_Base = $p["Base"];
		$bdd->_User = $p["User"];
		$bdd->_Password = $p["Password"];
		$bdd->_Port = $p["Port"];
		
		return $bdd;
	}
	public static function GetParams($f) {
		$dom = new \DomDocument();
		$dom->load($f);
		$xpath = new \DOMXPath($dom);
		$root = $dom->documentElement;
		$arr = array();
		$arr["Driver"] = $root->getElementsByTagName("Driver")->item(0)->nodeValue;
		$arr["Server"] = $root->getElementsByTagName("Server")->item(0)->nodeValue;
		$arr["Base"] = $root->getElementsByTagName("Base")->item(0)->nodeValue;
		$arr["User"] = $root->getElementsByTagName("User")->item(0)->nodeValue;
		$arr["Password"] = $root->getElementsByTagName("Password")->item(0)->nodeValue;
		try {
			if ($root->getElementsByTagName("Port") != null && $root->getElementsByTagName("Port")->item(0) != null) {
				$arr["Port"] = $root->getElementsByTagName("Port")->item(0)->nodeValue;
			}
		} catch(Exception $e) {
			
		}
	
		return $arr;
	}
	public static function GetTimeStampFromBDD($Date) {
		if ($Date == "") {
			return "" ;
		}
		return strtotime($Date);
	}
	public static function GetTimeStampFromView($Date) {
		if (strpos($Date, " ") === false) {
			$sDate = $Date;
			$Heure = 0;
			$Minute = 0;
		} else {
			list($sDate, $sTime) = explode(" ", $Date);
			list($Heure, $Minute) = explode(":", $sTime);
		}
		
		list($Jour, $Mois, $Annee) = explode("/", $sDate);
		
		return mktime($Heure, $Minute, 0, $Mois, $Jour, $Annee);
	}
	public static function GetBooleanFromBDD($Value) {
		return $Value;
	}
	public static function GetBooleanFromView($Value) {
		return $Value;
	}
}
?>