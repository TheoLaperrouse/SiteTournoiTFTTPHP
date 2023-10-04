<?php
class view_WP extends View
{
	function Display()
	{
		
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
	}
}
?>