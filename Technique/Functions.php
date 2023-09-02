<?php
class Functions {
	public static function inscriptTab($prenom, $nom, $nbrePts, $numLicence, $club, $lettresTableau) {
		foreach ($lettresTableau as $lettre) {
			if ($lettre != "") {
				if (1000 < $numLicence && $numLicence < 9999999) {
					$sqlPlace = "SELECT count(*) as nbInscrits FROM tableau".$lettre;
					$nbInscrits = (int)\BDD\SGBD::GetInstanceValue($sqlPlace);
					$aParams = self::getParamsTableau($lettre);
					$ptsMax = $aParams["PT"];
					$place = $aParams["NB"];
					if ($nbInscrits >= $place) {
						echo "<h2 class='center'>Le tableau $lettre est complet, inscription non validée pour ce tableau</h2>";
					} elseif ($nbrePts < $ptsMax) {
						$sql = "INSERT INTO tableau{$lettre} (`prenom`, `nom`, `nombrePoints`, `numLicence`, `club`) VALUES (\"$prenom\",\"$nom\",$nbrePts,$numLicence,\"$club\")";
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
	public static function getPlaceRestantes($lettre) {
		$aParams = self::getParamsTableau($lettre);
		$nb = self::getPlace($lettre);
		return $nb . " / " . $aParams["NB"] ;
	}
	public static function getPlace($lettre) {
		$sqlPlace = "SELECT count(*) as nbInscrits FROM tableau{$lettre}";
		$nbInscrits = (int)\BDD\SGBD::GetInstanceValue($sqlPlace);
		return $nbInscrits;
	}
	public static function printArrayPlayers($tab){
		$sql = "SELECT `prenom`, `nom`, `nombrePoints`, `club` FROM $tab ORDER BY `nombrePoints` DESC";
		$items = \BDD\SGBD::getItemsInstance($sql,true);
		echo "<table>";
		echo "<tr><th>Nom</th><th>Prénom</th><th>Nombre de Points</th><th>Club</th>";
		foreach($items as $data) {
			echo "<tr><td>" .
				$data["nom"] .
				"</td><td>" .
				$data["prenom"] .
				"</td><td>" .
				$data["nombrePoints"] .
				"</td><td>" .
				$data["club"] .
				"</td></tr>";
		}
		echo "</table>";
	}
	public static function execSqlFile($path) {
		$sql=file_get_contents($path);
		$row = \BDD\SGBD::QueryInstance($sql,true,true);
		return $row["total"];
	}
	public static function getRecipies(){
		$lettres = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N");
		$total  = 0 ;
		foreach ($lettres as $lettre) {
			$aParams = self::getParamsTableau($lettre);
			$sqlPlace = "SELECT count(*) as nbInscrits FROM tableau{$lettre}";
			$nbInscrits = (int)\BDD\SGBD::GetInstanceValue($sqlPlace);
			$total += $nbInscrits * (float)$aParams["PRIX"]; 
		}
		return $total;
	}
	public static function getPrixTableau($lettreTableau) {
		$aParams = self::getParamsTableau($lettreTableau);
		return $aParams["PRIX"] ;
	}
	public static function getParamsTableau($lettreTableau) {
		$nomNB = $lettreTableau."_NB" ;
		$nomPT = $lettreTableau."_PT" ;
		$nomPRIX = $lettreTableau."_PRIX" ;
		$rowNB = \BDD\SGBD::QueryInstance("select * from param_tournoi where Nom='{$nomNB}'",true,true);
		$rowPT = \BDD\SGBD::QueryInstance("select * from param_tournoi where Nom='{$nomPT}'",true,true);
		$rowPRIX = \BDD\SGBD::QueryInstance("select * from param_tournoi where Nom='{$nomPRIX}'",true,true);
		return array("NB"=>$rowNB["Valeur"],"PT"=>$rowPT["Valeur"],"PRIX"=>$rowPRIX["Valeur"]);
	}
	public static function exportTableau(){
		$lettres = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N");
		
		$aFields = array("Tableau","Licence","Prenom","Nom","Pts","Club") ;
		$csv = implode(";",$aFields) . "<br/>";
		
		foreach ($lettres as $lettre) {
			$sql = "SELECT * FROM tableau{$lettre}";
			$items = \BDD\SGBD::getItemsInstance($sql,true);
			foreach($items as $data) {
				$aValues = array();
				$aValues[] = $lettre ;
				$aValues[] = $data["numLicence"] ;
				$aValues[] = $data["prenom"] ;
				$aValues[] = $data["nom"] ;
				$aValues[] = $data["nombrePoints"] ;
				$aValues[] = $data["club"] ;
				$csv .= implode(";",$aValues) . "<br/>";
			}
		}
		return $csv;
	}
	public static function getTableauxLicence($numLicence) {
		$lettresTableau = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N");
		$aOut = array() ;
		if (1000 < $numLicence && $numLicence < 9999999) {
					
			foreach ($lettresTableau as $lettre) {
				if ($lettre != "") {
					$sqlPlace = "SELECT count(*) as nbInscrits FROM tableau". $lettre . " Where numLicence='".$numLicence."'";
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
