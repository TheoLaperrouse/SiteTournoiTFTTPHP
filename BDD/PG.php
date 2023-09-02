<?php
namespace BDD;

require_once 'IBDD.php';

class PG extends \BDD\SGBD
{
	private $cnn;
	
	function __destruct()
	{
		if ($this->cnn != null)
			$this->disconnect();
	}

	function connect()
	{
		$this->cnn = pg_connect("host=".$this->_Server." dbname=".$this->_Base." user=".$this->_User." password=".$this->_Password);
	}
	
	function disconnect()
	{
		pg_close($this->cnn);
		$this->cnn = null;
	}
	
	function num_rows($result)
	{
		return pg_num_rows($result);
	}
	
	function query($sql)
	{
		$result = pg_query($this->cnn, $sql);
		if (!$result)
		{
			echo "Erreur : $sql<hr>";
			exit;
		} 
		return $result;
	}
	
	function fetch_array($resultat)
	{
		return pg_fetch_array($resultat);
	}
	
	public function Execute(StoredProcedure $sp)
	{
		$result = $this->query($this->BuildQuery($sp));
		if (!$result)
		{
			echo "ERREUR";
			exit;
		} 
		return $result;
	}
	
	private function BuildQuery(StoredProcedure $sp)
	{
		$sCommand = "select * from ".$sp->ProcedureName."(";
		
		$dom = new \DomDocument();
		$dom->load("Config/Descripteur/".$sp->ProcedureName.".xml");
		$xpath = new \DOMXPath($dom);
		$root = $dom->documentElement;
		$nodeInputParameters = $root->getElementsByTagName("Input")->item(0);
		if ($nodeInputParameters->hasChildNodes())
		{
			$nodesParameters = $root->getElementsByTagName("Input")->item(0)->childNodes;
			
			foreach ($nodesParameters as $node)
			{
				if ($node->nodeType == XML_ELEMENT_NODE)
				{
					$sParameterName = $node->getAttribute("Name");
					$sParameterType = $node->getAttribute("Type");
					$sValue = $sp->GetParameterValue($sParameterName);
					
					switch ($sParameterType)
					{
						case "I":
							if ($sValue === "" || $sValue === null)
								$sValue = "NULL";
							break;
						case "VA":
							$sValue = "'$sValue'";
							break;
						case "B":
							$sValue = ($sValue) ? "'t'" : "'f'";
							break;
						case "DT":
							$sValue = "'".date("Y-m-d", $sValue)."'";
							break;
					}
					
					$sCommand .= $sValue.", ";
				}
			}
			
			$sCommand = substr($sCommand, 0, -2);
		}
		$sCommand .= ")";
		return $sCommand;
	}
}
?>
