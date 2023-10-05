<?php
class model_CR{
	public $Id = 0;
	public $row = null;
	
	function LoadByRecord($row) {
		$this->row = $row;
		$this->Id = $row["Id"];
	}
	public static function GetByRecord($row) {
		$cr = new model_CR();
		$cr->LoadByRecord($row);
		return $cr;
	}
	public static function GetCRByNumJournee($NumJournee) {
		$sql = "select * from TProACR Where NumJournee = " .$NumJournee ;
		$row = \BDD\SGBD::QueryInstance($sql,true,true);
		return self::GetByRecord($row);
	}
	public static function ListeActifs(){
		$sql = "select * from TProACR Where Actif = 1 order by DateMatch desc" ;
		return \BDD\SGBD::getItemsInstance($sql,true);
	}
	public static function Liste(){
		$sql = "select * from TProACR order by NumJournee" ;
		return \BDD\SGBD::getItemsInstance($sql,true);
	}
	public static function Update($NumJournee, $Auteur, $CR, $DateMatch, $Actif, $Locked) {
		$aModif = array() ;
		$aModif[] = "NumJournee=".$NumJournee ;
		$aModif[] = "Auteur='".\BDD\SGBD::real_escape_string(utf8_decode($Auteur))."'" ;
		$aModif[] = "CR='".\BDD\SGBD::real_escape_string(utf8_decode($CR))."'" ;
		$aModif[] = "DateMatch='".$DateMatch."'" ;
		$aModif[] = "Actif=".$Actif ;
		$aModif[] = "Locked=".$Locked ;
		$sql = "UPDATE TProACR SET ".implode(',',$aModif)." WHERE Locked = 0 and NumJournee = ".$NumJournee;
		\BDD\SGBD::QueryInstance($sql,true);
	}
}
?>
