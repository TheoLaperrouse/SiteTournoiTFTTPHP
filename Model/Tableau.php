<?php
class model_Tableau{
	public $Id = 0;
	public $row = null;

	public static function getPlaceRestantes($lettre) {
		$aParams = self::getParamsTableau($lettre);
		$nb = self::getPlace($lettre);
		return $nb . "/" . $aParams["NB"] ;
	}
	public static function getPrixTableau($lettreTableau) {
		$aParams = self::getParamsTableau($lettreTableau);
		return $aParams["PRIX"] ;
	}
	public static function getLibelleTableau($lettreTableau) {
		$aParams = self::getParamsTableau($lettreTableau);
		return $aParams["LIBELLE"] ;
	}
	public static function getLibelleLongTableau($lettreTableau) {
		$aParams = self::getParamsTableau($lettreTableau);
		return $aParams["LIBELLE_LONG"] ;
	}
	public static function getHeureTableau($lettreTableau) {
		$aParams = self::getParamsTableau($lettreTableau);
		return $aParams["HEURE"] ;
	}
	public static function getJourTableau($lettreTableau) {
		$aParams = self::getParamsTableau($lettreTableau);
		return $aParams["JOUR"] ;
	}
	public static function getPlace($lettre) {
		$sqlPlace = "SELECT count(*) as nbInscrits FROM tableau{$lettre}";
		$nbInscrits = (int)\BDD\SGBD::GetInstanceValue($sqlPlace);
		return $nbInscrits;
	}
	public static function getParamsTableau($lettreTableau) {
		$nomNB = $lettreTableau."_NB" ;
		$nomPT = $lettreTableau."_PT" ;
		$nomPRIX = $lettreTableau."_PRIX" ;
		$nomLIB = $lettreTableau."_LIB" ;
		$nomLIBLONG = $lettreTableau."_LIBLONG" ;
		$nomJOUR = $lettreTableau."_JOUR" ;
		$nomHEURE = $lettreTableau."_HEURE" ;
		
		$nomQUART = $lettreTableau."_QUART" ;
		$nomDEMI= $lettreTableau."_DEMI" ;
		$nomFINALE = $lettreTableau."_FINALE" ;
		$nomVAINQUEUR = $lettreTableau."_VAINQUEUR" ;
		
		$sql = "Select NB.Valeur as NB, 
					 PT.Valeur as PT,  
					 PRIX.Valeur as PRIX,  
					 LIB.Valeur as LIB,  
					 LIBLONG.Valeur as LIBLONG,  
					 JOUR.Valeur as JOUR,  
					 HEURE.Valeur as HEURE,  
					 QUART.Valeur as QUART,  
					 DEMI.Valeur as DEMI,  
					 FINALE.Valeur as FINALE,  
					 VAINQUEUR.Valeur as VAINQUEUR
			FROM param_tournoi as NB  
			INNER JOIN param_tournoi as PT on PT.Nom='{$nomPT}'
			INNER JOIN param_tournoi as PRIX on PRIX.Nom='{$nomPRIX}' 
			INNER JOIN param_tournoi as LIB on LIB.Nom='{$nomLIB}' 
			INNER JOIN param_tournoi as LIBLONG on LIBLONG.Nom='{$nomLIBLONG}' 
			INNER JOIN param_tournoi as JOUR on JOUR.Nom='{$nomJOUR}' 
			INNER JOIN param_tournoi as HEURE on HEURE.Nom='{$nomHEURE}' 
			INNER JOIN param_tournoi as QUART on QUART.Nom='{$nomQUART}' 
			INNER JOIN param_tournoi as DEMI on DEMI.Nom='{$nomDEMI}' 
			INNER JOIN param_tournoi as FINALE on FINALE.Nom='{$nomFINALE}' 
			INNER JOIN param_tournoi as VAINQUEUR on VAINQUEUR.Nom='{$nomVAINQUEUR}' 
			where NB.Nom='{$nomNB}'
			" ;
		$row = \BDD\SGBD::QueryInstance($sql,true,true);
		array_walk_recursive($row,'encode_items');
		return $row ;	
	}
	public static function formatPrice($price) {
		if (strpos($price, 'Lots') === false) {
			return $price . ' €';
		} 
		return $price;
	}
	public static function getRowTableau($lettreTableau) {
		$row = self::getParamsTableau($lettreTableau) ;
		$s= '
				<tr>
					<td><a href="tableau.php?tab=tableau'.$lettreTableau.'" class="link">'.$lettreTableau.'</a></td>
					<td><a href="tableau.php?tab=tableau'.$lettreTableau.'" class="link">'.$row["LIBLONG"].'</a></td>
					<td>'.self::getPlaceRestantes($lettreTableau) . '</td>
					<td>'.self::formatPrice($row["QUART"]).'</td>
					<td>'.self::formatPrice($row["DEMI"]).'</td>
					<td>'.self::formatPrice($row["FINALE"]).'</td>
					<td>'.self::formatPrice($row["VAINQUEUR"]).'</td>
					<td>'.$row["PRIX"].'€</td>
					<td>'.substr($row["JOUR"],0,3).'. '.$row["HEURE"].'</td>
				</tr>';
		return $s ;		
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
}
?>
