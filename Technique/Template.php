<?php
class Template {
	public static $aAccessedFile = array() ;
	var $fichier = "";
	
	function __construct() {
		$this->a_TagVal = array();
	}
	public function setFichier($s_Fichier) {
		$this->fichier = str_replace("\\\\","\\",$s_Fichier);
		$this->fichier = str_replace("/","\\",$this->fichier);
		$this->fichier = str_replace("\\","/",$this->fichier);
		
		if (!file_exists($this->fichier)) {
			echo "Fichier introuvable : ".$this->fichier."<br>";
			exit();
		}
	}
	public function getContenu() {
		$this->fusion();
		return $this->contenu;
	}
	public function SaveAs($f) {
		$myfile = fopen($f, "w") or false;
		if (!($myfile == false)) {
			fwrite($myfile, $this->getContenu());
			fclose($myfile);
		} else {
			return false;
		}
		return true;
	}
	public function affiche() {
		$this->fusion();
		echo $this->contenu;
	}
	
	public function addTag($s_Tag, $s_Val) {
		$this->a_TagVal[$s_Tag] = $s_Val;
	}
	
	private function fusion() {
		$id_file = fopen($this->fichier,"r");
		$i_TailleFichier = filesize($this->fichier);
		$this->contenu = fread($id_file,$i_TailleFichier);
		if (is_array($this->a_TagVal)) {
			foreach ($this->a_TagVal as $key => $value) {
				$value = ($value != null) ? $value : "" ;
				if (!is_array($value)) {
					$this->contenu = str_replace("<!--$key-->",$value,$this->contenu);
				}
			}
		}
		$this->contenu = str_replace("##SAUT_PAGE##","<div class=\"beforeBreak\" style=\"page-break-after: always;\"></div><div style=\"min-height:50px;clear:both;\"><div class=\"hrBreak\">Saut de page</div></div>",$this->contenu);
		$this->contenu = str_replace("##SAUT_PAGE_ENTETE##","<div class=\"beforeBreak\" style=\"page-break-after: always;\"></div><div style=\"min-height:100px;clear:both;\"><div class=\"hrBreak\">Saut de page</div></div>",$this->contenu);
		fclose($id_file);
	}
	
	public static function GetNumero($Numero)
	{
		return ($Numero == 1) ? $Numero."er" : $Numero."ème"; 
	}
	
	public static function GetLink($Name, $Link)
	{
		return "<a href=\"$Link\">$Name</a>";
	}
	
	public static function GetButton($Name, $Text, $Action)
	{
		return "<input type=\"button\" value=\"$Text\" id=\"$Name\" onClick=\"$Action\">";
	}
	
	public static function GetOption($Text, $Value)
	{
		$sSelected = "";

		if (func_num_args() == 3)
			$sSelected = (func_get_arg(2)) ? " selected" : "";

		$sClass = (func_num_args() == 4) ? " class=\"" . func_get_arg(3)."\"" : "";
			
		return "<option value=\"$Value\"$sSelected $sClass>$Text</option>";
	}
	public static function GetOptionWithData($Text, $Value, $selected = false, $dataName = "", $dataVal = "", $dataArray = array())
	{
		$sSelected = ($selected) ? " selected" : "";
		$sData = ($dataName != "") ? " data-".$dataName."='".$dataVal."'" : "";
		foreach ($dataArray as $k => $v) {
			$sData .= ($k != "") ? " data-".$k."='".$v."'" : "";
		}
			
		return "<option value=\"$Value\"$sSelected$sData>$Text</option>";
	}
}
?>