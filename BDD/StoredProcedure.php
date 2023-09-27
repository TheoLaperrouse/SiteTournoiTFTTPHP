<?php
namespace BDD;

class StoredProcedure
{
	public $Connection = null;
	public $ProcedureName = "";
	private $_parameters = array();
	
	public function __construct($ProcedureName) {
		$this->ProcedureName = $ProcedureName;
	}
	public function AddParameters($key, $value) {
		$this->_parameters[$key] = $value;
	}
	public function GetParameterValue($key) {
		if (array_key_exists($key, $this->_parameters))
		{
			return $this->_parameters[$key];
		}
		else
		{
			echo $this->ProcedureName . " : Le paramètre '$key' n'existe pas dans le descripteur.";
			return false;
		}
	}
	public function logParams() {
		\Tools::logToFile('tunning.log',"logParams " . $this->ProcedureName . " || " . serialize($this->_parameters));
	}
}
?>