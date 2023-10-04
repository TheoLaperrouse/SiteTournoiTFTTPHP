<?php
class view_WP extends View
{
	function Display()
	{
		
	}
	public static function getHTMLLastCR() {
		$sqlCategories = "select * from TProACR order by DateMatch desc limit 1" ;
		$items = \BDD\SGBD::getItemsInstance($sqlCategories,true);
		$row = $items[0] ;
		
		$s = self::getHTMLCR($items[0]);
			
		return $s ;
	}
	public static function getAllCR() {
		$sqlCategories = "select * from TProACR order by DateMatch desc limit 1" ;
		$items = \BDD\SGBD::getItemsInstance($sqlCategories,true);
		$s = "" ;
		foreach($items as $row) {
			$s .= self::getHTMLCR($row);
		}
		
		return $s ;
	}
	public static function getHTMLCR($row) {
		$s = "<div style='margin-bottom: 20px;'>
			  <h2 style='font-weight:700;font-size:48px;text-align:center;color:#ca9b52;'>Compte rendu du match du " . Tools::ensureDateFR($row["DateMatch"]) . " (Jounée n°".$row["NumJournee"].")</h2>
			  <h3 style='font-weight:300;font-size:24px;text-align:center;color:#ca9b52;'>" . utf8_encode($row["Lieu"]) . "</h3>
			  <h3 style='font-style:italic;font-weight:300;font-size:24px;text-align:center;color:#ca9b52;'>Auteur : " . $row["Auteur"] . "</h3>
				<div class='partner-container'>	
				".utf8_encode($row["CR"])."
				</div>
			" ;
			
		return $s ;
	}
	public static function getHTMLPartenaires() {
		$sqlCategories = "select * from TPartenairesCategorie" ;
		$items = \BDD\SGBD::getItemsInstance($sqlCategories,true);
		$s = "" ;
		foreach($items as $Cat) {
			$s .= self::getHTMLCategoriePartenaires($Cat) ;
		}
		return $s ;
	}
	public static function getHTMLCategoriePartenaires($Cat) {
		$s = "<div style='margin-bottom: 20px;'>
			  <h2 style='font-weight:700;font-size:48px;text-align:center;color:#ca9b52;'>Partenaires " . $Cat["Nom"] . "</h2>
				<div class='partner-container'>	
			" ;
		$sqlPartenaire = "select * from TPartenaires where IdCategorie = " . $Cat["IdCategorie"] ;
		$partenaires = \BDD\SGBD::getItemsInstance($sqlPartenaire,true);
		foreach($partenaires as $p) {
			$s .= self::getHTMLPartenaire($Cat, $p) ;
		}
		$s .= "</div>";
		$s .= "</div>";
		return $s ;
	}
	public static function getHTMLPartenaire($Cat, $p) {
		$s = "<div class='partner'><a href='" . $p["URL"] . "' target=_BLANK title=\"". utf8_encode($p["Nom"])."\"><img src='" . $p["Image"] . "' width='256' height='256' /></a></div>" ;
		return $s ;
		// $tp = new Template();
		// $tp->addTag("TAG-BLC LignesVersion", $sRows);
		// $tp->setFichier(__DIR__ . "/.." . cst_Template ."/Administration/Table_ListeVersions.htm");
	}
}
?>
