<?php
class view_WP extends View
{
	function Display()
	{
		
	}
	public static function getHTMLLastCR() {
		$sqlCategories = "select * from TProACR order by DateMatch desc limit 1" ;
		$items = model_CR::ListeActifs();
		$s = self::getHTMLCR($items[0]);
		return $s ;
	}
	public static function getAllCR() {
		$items = model_CR::ListeActifs();
		$s = "" ;
		foreach($items as $row) {
			$s .= self::getHTMLCR($row);
		}
		return $s ;
	}
	public static function getHTMLCR($row) {
		$domext = ($row["Domicile"] == 1) ? "à domicile" : "à l'extérieur" ;
		$s = "	<div style='margin-bottom: 20px;'>
					<h2 class='partner-title'>Compte rendu du match du " . Tools::ensureDateFR($row["DateMatch"]) . "</h2>
					<h3 class='partner-title' style='font-weight:300;font-size:24px'>" . $domext . " contre " . utf8_encode($row["Adversaire"]) .  " (Journée n°".$row["NumJournee"].")</h3>
					<h3 class='partner-title' style='font-style:italic;font-weight:300;font-size:24px;'>Auteur : " . $row["Auteur"] . "</h3>
					<div class='partner-container'>	
					".utf8_encode($row["CR"])."
					</div>
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
			  <h2 class='partner-title'>Partenaires " . $Cat["Nom"] . "</h2>
			  <div class='partner-container'>";
		$sqlPartenaire = "select * from TPartenaires where IdCategorie = " . $Cat["IdCategorie"] ;
		$partenaires = \BDD\SGBD::getItemsInstance($sqlPartenaire,true);
		foreach($partenaires as $p) {
			$s .= self::getHTMLPartenaire($Cat, $p) ;
		}
		$s .= "</div></div>";
		return $s ;
	}
	public static function getHTMLPartenaire($Cat, $p) {
		return "<div class='partner'><a href='" . $p["URL"] . "' target=_BLANK title=\"". utf8_encode($p["Nom"])."\"><img src='" . $p["Image"] . "' width='256' height='256' /></a></div>" ;
	}
}
?>