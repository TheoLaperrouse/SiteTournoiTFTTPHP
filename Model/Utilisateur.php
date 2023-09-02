<?php
class model_Utilisateur{
	public $Id = 0;
	public $Admin = false;
	public $row = null;

	function LoadUtilisateurByRecord($row)
	{
		$this->row = $row;
		$this->Id = $row["uti_id"];
	}
	public static function GetUtilisateurByRecord($row)
	{
		$utilisateur = new model_Utilisateur();
		$utilisateur->LoadUtilisateurByRecord($row);
		return $utilisateur;
	}
	public static function GetUtilisateurById($Id)
	{
		$sp = new \BDD\StoredProcedure("sp_GetUtilisateurById");
		$sp->AddParameters("Id", $Id);
		return \BDD\SGBD::ExecuteInstanceObject($sp,true,['model_Utilisateur','GetUtilisateurByRecord']);
	}
	public static function Liste()
	{
		$sql = "SELECT * FROM TFTT_UTILISATEUR ORDER BY uti_nom";
		$items = \BDD\SGBD::getItemsInstance($sql,true);
		
		$aUtilisateur = array();
		foreach ($items as $row) {
			$aUtilisateur[] = self::GetUtilisateurByRecord($row);
		}
		return $aUtilisateur;
	}
	
	public static function ListeBrute(){
		$sql = "SELECT * FROM TFTT_UTILISATEUR ORDER BY uti_nom";
		return \BDD\SGBD::getItemsInstance($sql,true);
	}
	public function Authentifie(){
		$pwd =  md5(_TFTT_COOKIE_KEY_ . utf8_decode($this->row["uti_mail"]) . $this->row["uti_password"]) ;
		$sql = "SELECT * FROM TFTT_UTILISATEUR WHERE uti_mail = '".utf8_decode($this->row["uti_mail"])."' AND uti_password = '" . $pwd ."'" ;
		$row = \BDD\SGBD::QueryInstance($sql,true,true);
		Tools::logToFile('connexion.log',$sql) ;
		$bAuthentifie = false;
		if ($row !== null)		{
			$bAuthentifie = true;
			$this->LoadUtilisateurByRecord($row);
		}
		
		return $bAuthentifie;
	}
	function getAvatar() {
		$urlAbsent = cst_SITE_URL."/assets/images/Absent.png";
		$f =  $this->getFileProfil("LOGO") ;
		if ($f != "") {
			$url = $this->getProfilURL() ;
			return $url.$f ;
		}
		return $urlAbsent ;
	}
	function getProfilURL() {
		$output_dir = $_SERVER["DOCUMENT_ROOT"].cst_Racine."/PJ/UTILISATEUR/";
		$a = str_split($this->row["uti_id"]);
		$domaine = "" ;
		for ($i =0;$i<count($a);$i++) {
			$domaine .= $a[$i] . "/" ;
			if (!is_dir($output_dir.$domaine)) {
				mkdir($output_dir.$domaine, 0777, true);
			}
		}		
		return cst_Racine."/PJ/UTILISATEUR/".$domaine ;
	}
	public static function getPathAvatar($id) {
		$a = str_split($id);
		$output_dir = $_SERVER["DOCUMENT_ROOT"].cst_Racine."/PJ/UTILISATEUR/";
		$logoPath = "./PJ/UTILISATEUR/";
		$domaine = "" ;
		for ($i =0;$i<count($a);$i++) {
			$domaine .= $a[$i] . DIRECTORY_SEPARATOR ;
			if (!is_dir($output_dir.$domaine)) {
				mkdir($output_dir.$domaine, 0777, true);
			}
		}
		$output_dir .= $domaine;
		$logoPath .= $domaine;
		$logo = "" ;
		
		$count = 0;
		$dossier = opendir($output_dir);
		while (false !== ($Fichier = readdir($dossier))) {
			if ($Fichier != "." AND $Fichier != ".." AND 
				(stristr($Fichier,'.gif') OR stristr($Fichier,'.jpg') OR stristr($Fichier,'.png') OR stristr($Fichier,'.bmp'))
				) {
				if (startsWith(strtoupper($Fichier),"LOGO")) {
					$count+=1;
					$logo = $logoPath . $Fichier ;
				}
			}
		}    
		closedir($dossier);
		return $logo ;
	}
	function getLogo() {
		$output_dir = $_SERVER["DOCUMENT_ROOT"].cst_Racine."/PJ/UTILISATEUR/";
		$a = str_split($this->row["uti_id"]);
		$domaine = "" ;
		for ($i =0;$i<count($a);$i++) {
			$domaine .= $a[$i] . DIRECTORY_SEPARATOR ;
			if (!is_dir($output_dir.$domaine)) {
				mkdir($output_dir.$domaine, 0777, true);
			}
		}		
		$output_dir .= $domaine;
		$logo = "" ;
		
		$count = 0;
		$dossier = opendir($output_dir);
		while (false !== ($Fichier = readdir($dossier))) {
			if ($Fichier != "." AND $Fichier != ".." AND 
				(stristr($Fichier,'.gif') OR stristr($Fichier,'.jpg') OR stristr($Fichier,'.png') OR stristr($Fichier,'.bmp'))
				) {
				if (startsWith(strtoupper($Fichier),"LOGO")) {
					$count+=1;
					$logo = $output_dir . $Fichier ;
				}
			}
		}    
		closedir($dossier);
		return $logo ;
	}
	function getLogoURL() {
		$output_dir = $_SERVER["DOCUMENT_ROOT"].cst_Racine."/PJ/UTILISATEUR/";
		$output_url = "ajax/foot/doPJ.php?mode=GET_PJ&type=UTILISATEUR&ID=".$this->row["uti_id"]."&fichier=";
		$a = str_split($this->row["uti_id"]);
		$domaine = "" ;
		for ($i =0;$i<count($a);$i++) {
			$domaine .= $a[$i] . "/" ;
			if (!is_dir($output_dir.$domaine)) {
				mkdir($output_dir.$domaine, 0777, true);
			}
		}		
		$output_dir .= $domaine;
		$logo = "" ;
		
		$count = 0;
		$dossier = opendir($output_dir);
		while (false !== ($Fichier = readdir($dossier))) {
			if ($Fichier != "." AND $Fichier != ".." AND 
				(stristr($Fichier,'.gif') OR stristr($Fichier,'.jpg') OR stristr($Fichier,'.png') OR stristr($Fichier,'.bmp'))
				) {
				if (startsWith(strtoupper($Fichier),"LOGO")) {
					$count+=1;
					$logo = $output_url . $Fichier ;
				}
			}
		}    
		closedir($dossier);
		return $logo ;
	}
	function getLogoWH($logo,$h_vign) {
		if ($logo == "") {
			$wh = array('w' => 0, 'h' => 0) ;
			return $wh ;
		}
		
		$taille = getimagesize($logo);
		$Largeur = $taille[0];
		$Hauteur = $taille[1];
		
		if($Largeur/$h_vign>$Hauteur/$h_vign) 
		{
			$Rapport = $Largeur/$h_vign;
			$L = $h_vign ;
			$H = floor($Hauteur/$Rapport) ;
		} 
		else 
		{
			$Rapport = $Hauteur/$h_vign;
			$H = $h_vign ;
			$L = floor($Largeur/$Rapport) ;
		}
		$wh = array('w' => $L, 'h' => $H) ;
		return $wh ;
	}
	
	function getProfilDirectory() {
		$output_dir = __DIR__ ."/../PJ/UTILISATEUR/";
		$a = str_split($this->row["uti_id"]);
		
		$domaine = "" ;
		for ($i =0;$i<count($a);$i++) {
			$domaine .= $a[$i] . "/" ;
			if (!is_dir($output_dir.$domaine)) {
				mkdir($output_dir.$domaine, 0777, true);
			}
		}		
		return $output_dir.$domaine;
	}
	function getAvatarAssetsUrl($h, $forced = false) {
		$file = $this->getAvatarAssets($h, $forced);
		return 'assets/images/' . $file ;
	}
	function getAvatarAssets($h, $forced = false) {
		$output_dir = __DIR__ ."/../assets/images/";
		$f = $this->getFileProfil("LOGO") ;
		if (trim($f) == "") {
			return 'AbsentSmall.png' ;
		}
		
		$d = $this->getProfilDirectory() ;
		$fOut = 'avatar'.$h.'_'.$this->row["uti_id"].'.png' ;
		if (!file_exists($output_dir . 'joueurs/'.$fOut) && file_exists($d.$f)) {
			if (exif_imagetype($d.$f) == IMAGETYPE_JPEG) {
				GestionImage::JPG2PNG($d.$f, $output_dir . 'joueurs/temp/'.$fOut) ;
			} else {
				copy($d.$f, $output_dir . 'joueurs/temp/'.$fOut) ;
			}
				
			GestionImage::CreateThumb($output_dir . 'joueurs/temp/'.$fOut, $output_dir . 'joueurs/'.$fOut,$h,$h,true) ;
		}
		if (file_exists($output_dir . 'joueurs/'.$fOut)) {
			return 'joueurs/'.$fOut ;
		} else {
			return 'AbsentSmall.png' ;
		}
	}		
	function getAvatarSized($h, $forced = false) {
		$f = $this->getFileProfil("LOGO") ;
		if ($f != "") {
			$d = $this->getProfilDirectory() ;
			$domaine = "Thumb/" ;
			if (!is_dir($d.$domaine)) {
				mkdir($d.$domaine, 0777, true);
			}
			$pathToThumb = $d.$domaine . "Thumb".$h.".jpg" ;
			if (!file_exists($pathToThumb) || $forced) {
				$size = GestionImage::getSize($d.$f,3/4*4*$h,4*$h) ;
				$new_width = $size["Width"];
				$new_height = $size["Height"];
				GestionImage::CreateThumb($d.$f, $pathToThumb,$new_width,$new_height,$replace = true) ;
			}
			$url = $this->getProfilURL() ;
			$url .= "Thumb/" ;
			return $url . "Thumb".$h.".jpg" ;
		}
		
		$urlAbsent = cst_SITE_URL."/assets/images/Absent.png";
		return $urlAbsent ;
	}
	function getFileProfil($f) {
		$output_dir = __DIR__ ."/../PJ/UTILISATEUR/";
		$a = str_split($this->row["uti_id"]);
		$domaine = "" ;
		for ($i =0;$i<count($a);$i++) {
			$domaine .= $a[$i] . DIRECTORY_SEPARATOR ;
			if (!is_dir($output_dir.$domaine)) {
				mkdir($output_dir.$domaine, 0777, true);
			}
		}		
		$output_dir .= $domaine;
		$logo = "" ;
		
		$count = 0;
		$dossier = opendir($output_dir);
		while (false !== ($Fichier = readdir($dossier))) {
			if ($Fichier != "." AND $Fichier != ".." AND 
				(stristr($Fichier,'.gif') OR stristr($Fichier,'.jpg') OR stristr($Fichier,'.png') OR stristr($Fichier,'.bmp'))
				) {
				if (startsWith(strtoupper($Fichier),strtoupper($f))) {
					$count+=1;
					$logo = $Fichier ;
				}
			}
		}    
		closedir($dossier);
		return $logo ;
	}
}
?>
