<?php
class view_CR extends View
{
	var $_CR ;
	function Display()
	{
		
	}
	public function getHTML() {
		$f = ($this->_CR->row["Locked"] == 1) ? "CR_VIEW.htm" : "CR_EDIT.htm" ;
		$tp = new Template();
		
		$tp->addTag("TAG-CHP Id", $this->_CR->row["Id"]);
		$tp->addTag("TAG-CHP NumJournee", $this->_CR->row["NumJournee"]);
		$tp->addTag("TAG-CHP DateMatch", $this->_CR->row["DateMatch"]);
		$tp->addTag("TAG-CHP Auteur", $this->_CR->row["Auteur"]);
		$tp->addTag("TAG-CHP Adversaire", $this->_CR->row["Adversaire"]);
		$tp->addTag("TAG-CHP CR", $this->_CR->row["CR"]);
		$tp->addTag("TAG-CHP Actif", $this->_CR->row["Actif"]);
		$tp->addTag("TAG-CHP Locked", $this->_CR->row["Locked"]);
		$tp->addTag("TAG-CHP chkActif", ($this->_CR->row["Actif"]==1) ? "Active checked" : "InActive");
		$tp->addTag("TAG-CHP chkLocked", ($this->_CR->row["Locked"]==1) ? "Active checked" : "InActive");
		
		$title = $this->getHTMLTitle($this->_CR->row);
		$tp->addTag("TAG-CHP title", $title);
		$tp->addTag("TAG-CHP Auteur", $this->getHTMLSelectAuteur($this->_CR->row));
		
		$tp->setFichier(__DIR__."/..".cst_Template."/CR/".$f);
		return $tp->getContenu();
	}
	public function getHTMLSelectAuteur($row) {
		$s = "" ;
		if ($row["Locked"] == 1) {
			$s .= " <h3 class='partner-title' style='font-style:italic;font-weight:300;font-size:24px;'>Auteur : " . $row["Auteur"] . "</h3><input type='hidden' id='Auteur' value='" . $row["Auteur"] . "' />" ;
		} else {
			$s .= " <div class='rowField'>
						<div class='rowFieldLibelle' style='width:150px;'>Auteur : </div>
						<select id='Auteur' style='width:200px;'>
						<option value='Laurent Calvez' ".(($row["Auteur"] == "Laurent Calvez") ? "selected" : "").">Laurent Calvez</option>
						<option value='Gervais Rolland' ".(($row["Auteur"] == "Gervais Rolland") ? "selected" : "").">Gervais Rolland</option>
					</select>
				</div>" ;
		}
		return $s ;
	}
	public function getHTMLTitle($row) {
		$domext = ($row["Domicile"] == 1) ? utf8_decode("à domicile") :  utf8_decode("à l'extérieur") ;
		$s = "<div style='margin-bottom: 20px;'>
			  <h2 class='partner-title'>Compte rendu du match du " . Tools::ensureDateFR($row["DateMatch"]) . "</h2>
			  <h3 class='partner-title' style='font-weight:300;font-size:24px'>" . $domext . " contre " . utf8_decode($row["Adversaire"]." (Jounée n°").$row["NumJournee"].")</h3>";
		
		$s .= "</div>" ;
			
		return $s ;
	}
}
?>