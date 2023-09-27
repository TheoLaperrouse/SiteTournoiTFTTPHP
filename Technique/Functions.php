<?php
class Functions {
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
}
?>
