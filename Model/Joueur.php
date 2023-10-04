<?php
class model_Joueur{
	public $Id = 0;
	public $row = null;

	public static function ListeTableau($lettre, $prefixText,$numLicence){
		$sp = new \BDD\StoredProcedure("sp_ListeTableau");
		$sp->AddParameters("nomTable", "tableau".$lettre);
		$sp->AddParameters("prefixText", $prefixText);
		$sp->AddParameters("numLicence", $numLicence);
		
		return \BDD\SGBD::getItemsInstance($sp,true);
	}
	public static function ListeTableaux($prefixText,$numLicence){
		$aJoueurs = array() ;
		for ($i = 1; $i <= 14; $i++) {
			$lettre =  chr(64 + $i);
			$aTableau = self::ListeTableau($lettre, $prefixText,$numLicence) ;
			$aJoueurs = self::AddTableau($aJoueurs, $lettre, $aTableau) ;
		}
		foreach($aJoueurs as $j){
			$aNot = array() ;
			for ($i = 1; $i <= 14; $i++) {
				$lettre =  chr(64 + $i);
				if (!in_array($lettre,$j["tableaux"])) {
					$aNot[] = $lettre ;
				}
			}
			$aJoueurs[$j["numLicence"]]["NotTableaux"] = $aNot ;
		}
		return $aJoueurs ;
	}
	public static function AddTableau($aJoueurs, $lettre, $aTableau) {
		foreach ($aTableau as $t) {
			if (array_key_exists($t["numLicence"],$aJoueurs)) {
				$aJoueurs[$t["numLicence"]]["tableaux"][] = $lettre ;
			} else {
				$t["tableaux"] = array() ;
				$t["tableaux"][] = $lettre ;
				$aJoueurs[$t["numLicence"]] = $t ;
			}
		}
		return $aJoueurs ;
	}
	public static function DeleteTableau($numLicence, $lettre) {
		$sql = "DELETE FROM tableau".$lettre." WHERE numLicence = '".$numLicence."'";
		\BDD\SGBD::QueryInstance($sql,true);
	}
	public static function UpdateJoueur($numLicence, $club, $nom, $prenom, $nombrePoints, $aTableau) {
		$aModif = array() ;
		$aModif[] = "club='".\BDD\SGBD::real_escape_string(utf8_decode($club))."'" ;
		$aModif[] = "nom='".\BDD\SGBD::real_escape_string(utf8_decode($nom))."'" ;
		$aModif[] = "prenom='".\BDD\SGBD::real_escape_string(utf8_decode($prenom))."'" ;
		$aModif[] = "nombrePoints='".\BDD\SGBD::real_escape_string(utf8_decode($nombrePoints))."'" ;
		foreach ($aTableau as $lettre) {
			$sql = "UPDATE tableau".$lettre." SET ".implode(',',$aModif)." WHERE numLicence = '".$numLicence."'";
			Tools::l('update.log',$sql);
			\BDD\SGBD::QueryInstance($sql,true);
		}
	}
	public static function AddJoueur($prenom, $nom, $nombrePoints, $numLicence, $club, $lettresTableau) {
		$aValues = array() ;
		$aValues[] = "'".\BDD\SGBD::real_escape_string(utf8_decode($prenom))."'" ;
		$aValues[] = "'".\BDD\SGBD::real_escape_string(utf8_decode($nom))."'" ;
		$aValues[] = "'".\BDD\SGBD::real_escape_string(utf8_decode($nombrePoints))."'" ;
		$aValues[] = "'".\BDD\SGBD::real_escape_string(utf8_decode($numLicence))."'" ;
		$aValues[] = "'".\BDD\SGBD::real_escape_string(utf8_decode($club))."'" ;
		foreach ($lettresTableau as $lettre) {
			if ($lettre != "") {
				if (1000 < $numLicence && $numLicence < 9999999) {
					$sqlPlace = "SELECT count(*) as nbInscrits FROM tableau".$lettre;
					$nbInscrits = (int)\BDD\SGBD::GetInstanceValue($sqlPlace);
					$aParams = model_Tableau::getParamsTableau($lettre);
					$ptsMax = $aParams["PT"];
					$place = $aParams["NB"];
					if ($nbInscrits >= $place) {
						echo "<h2 class='center'>Le tableau $lettre est complet, inscription non validée pour ce tableau</h2>";
					} elseif ($nombrePoints < $ptsMax) {
						$sql = "INSERT INTO tableau{$lettre} (`prenom`, `nom`, `nombrePoints`, `numLicence`, `club`) VALUES (".implode(',',$aValues).")";
						\BDD\SGBD::QueryInstance($sql,true) ;
						echo "<h2 class='center'>Vous êtes inscrit au tableau $lettre</h2>";
					} else {
						echo "<h2 class='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau $lettre</h2>";
					}
				} else {
					echo "<h2 class='center'>Le numéro de Licence est incorrecte</h2>";
				}
			}
		}
	}
	public static function AddJoueurToTableau($prenom, $nom, $nombrePoints, $numLicence, $club, $lettre) {
		$aValues = array() ;
		$aValues[] = "'".\BDD\SGBD::real_escape_string(utf8_decode($prenom))."'" ;
		$aValues[] = "'".\BDD\SGBD::real_escape_string(utf8_decode($nom))."'" ;
		$aValues[] = "'".\BDD\SGBD::real_escape_string(utf8_decode($nombrePoints))."'" ;
		$aValues[] = "'".\BDD\SGBD::real_escape_string(utf8_decode($numLicence))."'" ;
		$aValues[] = "'".\BDD\SGBD::real_escape_string(utf8_decode($club))."'" ;
		$sqlPlace = "SELECT count(*) as nbInscrits FROM tableau".$lettre;
		$nbInscrits = (int)\BDD\SGBD::GetInstanceValue($sqlPlace);
		$aParams = model_Tableau::getParamsTableau($lettre);
		$ptsMax = $aParams["PT"];
		$place = $aParams["NB"];
		if ($nbInscrits >= $place) {
			return array("status"=>"KO","message"=>utf8_encode("Le tableau $lettre est complet, inscription non validée pour ce tableau"));
		} elseif ($nombrePoints < $ptsMax) {
			$sql = "INSERT INTO tableau{$lettre} (`prenom`, `nom`, `nombrePoints`, `numLicence`, `club`) VALUES (".implode(',',$aValues).")";
			\BDD\SGBD::QueryInstance($sql,true) ;
			//Tools::l('insert.log',$sql);
			return array("status"=>"OK","message"=>utf8_encode("Inscription au tableau $lettre"));
		} else {
			return array("status"=>"KO","message"=>utf8_encode("Vous n'avez pas le bon nombre de points pour participer au tableau $lettre"));
		}
	}
	public static function DeleteByLicence($numLicence) {
		$aOut = array() ;
		$liste = model_Joueur::ListeTableaux("",$numLicence);
		if (count($liste) == 1) {
			$item = $liste[$numLicence] ;
			$aTableau = $item["tableaux"] ;
			foreach ($aTableau as $lettre) {
				$sqlPlace = "SELECT count(*) as nbInscrits FROM tableau". $lettre . " Where numLicence='".$numLicence."'";
				$nbInscrits = (int)\BDD\SGBD::GetInstanceValue($sqlPlace);
				if ($nbInscrits == 1) {
					$aOut[] = "Désincription du tableau " . $lettre ;
					$sqlDelete = "DELETE FROM tableau". $lettre . " Where numLicence='".$numLicence."'";
					\BDD\SGBD::QueryInstance($sqlDelete,true);
				}
			}
		}
		if (count($aOut) == 0) {
			$aOut[] = "Aucun tableau trouvé pour le numéro de licence : " . $numLicence ;
		}
		return array("status"=>"OK","tableaux"=>$aOut);
	}
	public static function getTableauxLicence($numLicence) {
		$aOut = array() ;
		if (1000 < $numLicence && $numLicence < 9999999) {
			$liste = model_Joueur::ListeTableaux("",$numLicence);
			if (count($liste) == 1) {
				$item = $liste[$numLicence] ;
				$aTableau = $item["tableaux"] ;
				foreach ($aTableau as $lettre) {
					$sqlPlace = "SELECT count(*) as nbInscrits FROM tableau". $lettre . " WHERE numLicence='".$numLicence."'";
					$nbInscrits = (int)\BDD\SGBD::GetInstanceValue($sqlPlace);
					if ($nbInscrits == 1) {
						$aOut[] = "Vous êtes inscrit(e) au tableau " . $lettre ;
					}
				}
			}
			return array("status"=>"OK","tableaux"=>$aOut);
		}
		return array("status"=>"KO","message"=>"Le N° de licence est incorrect");
	}
}
?>
