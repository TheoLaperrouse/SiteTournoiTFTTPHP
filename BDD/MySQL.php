<?php
namespace BDD;

require_once 'IBDD.php';
require_once 'DbQuery.php';

class MySQL extends \BDD\SGBD
{
	private $cnn;
	public static $lastSQL ;
	private $GUID = ""; 
	private $startTime = 0; 
	private $endTime = 0; 
	private $result = false; 
	function __destruct()
	{
		if ($this->cnn != null) {
			$this->disconnect(false);
		}
	}

	function connect()
	{
		if (\BDD\SGBD::$DB_USE_INSTANCE == true && 
				(
					(\BDD\SGBD::$is_instance_connected && \BDD\SGBD::$instance !== null && \BDD\SGBD::$DB_INSTANCE_NAME == $this->_Base) ||
					(\BDD\SGBD::$is_instanceSaskit_connected && \BDD\SGBD::$instanceSaskit !== null && \BDD\SGBD::$DB_INSTANCE_SASKIT_NAME == $this->_Base)
				)
		) {
			return true ;
		}
		
		if ($this->_Port != "") {
			$mysqli = new \mysqli($this->_Server, $this->_User,$this->_Password, $this->_Base, $this->_Port);
		} else {
			$mysqli = new \mysqli($this->_Server, $this->_User,$this->_Password, $this->_Base);
		}

		if ($mysqli->connect_error) {
// \Tools::logToFile("mysql.log","[MySQL::connect] : Error "."(" . $mysqli->connect_errno . ") " . $mysqli->connect_error." BASE ".$this->_Server." || ".$this->_User." || password || ".$this->_Base." || ".$this->_Port);
			die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error) ;
		}
		$this->cnn = $mysqli;
	}
	function getError() {
		if ($this->cnn != null)
			return \mysqli_error($this->cnn);
		return "Aucune connexion trouvée" ;
	}
	function mysqli_real_escape_string($s) {
		return \mysqli_real_escape_string($this->cnn, $s);
	}
	function disconnect($forced = false) {
		if (\BDD\SGBD::$DB_USE_INSTANCE == true && $forced == false && (
				\BDD\SGBD::$DB_INSTANCE_NAME == $this->_Base ||
				\BDD\SGBD::$DB_INSTANCE_SASKIT_NAME == $this->_Base
			)
		) {
			return false ;
		}
		
		if ($this->cnn != null) {
			$this->cnn->close();
			$this->cnn = null;
		}
	}
	
	function num_rows($result)
	{
	    return $result->num_rows;
	}
	
	function getValue($sql) {
        if ($sql instanceof DbQuery) {
            $sql = $sql->build();
        }
        if (!$result = $this->getRow($sql)) {
            return false;
        }

        return array_shift($result);
	}
    public function getRow($sql)
    {
		if ($sql instanceof StoredProcedure) {
			$sp = $sql ;
			$aQuery = $this->getQuery($sp);
			foreach ($aQuery as $query) {
				$sql = $this->fillQuery($sp,$query) ;
				break;
			}
		} else if ($sql instanceof DbQuery) {
            $sql = $sql->build();
        }

        $sql = rtrim($sql, " \t\n\r\0\x0B;").' LIMIT 1';
        $this->result = false;
        self::$lastSQL = $sql;

        $this->result = $this->query($sql);
        if (!$this->result) {
            $result = false;
        } else {
            $result = $this->fetch_array_assoc($this->result);
        }

        if (is_null($result)) {
            $result = false;
        }

        return $result;
    }
	function query($sql, $logexit = false) {
		if ($sql instanceof DbQuery) {
            $sql = $sql->build();
        }
		$result = $this->cnn->query($sql);
		self::$lastSQL = $sql ;
		if (!$result && $logexit) \Tools::logSqlError($this) ;
		return $result ;
	}
	function getItems($sql, $logexit = true) {
		$aItems = array();
		$result = false;
		
		if ($sql instanceof StoredProcedure) {
			$sp = $sql ;
			$aQuery = $this->getQuery($sp);
			if (count($aQuery)>1) {
				$result = $this->Execute($sp,$logexit);
				
			} else if (count($aQuery) == 1) {
				$sql = $this->fillQuery($sp,$aQuery[0]) ;
				$result = $this->cnn->query($sql); 
				self::$lastSQL = $sql ;
			}
		} else if ($sql instanceof DbQuery) {
			$sql = $sql->build();
			$result = $this->cnn->query($sql); 
			self::$lastSQL = $sql ;
		} else {
			$result = $this->cnn->query($sql);
			self::$lastSQL = $sql ;
		}
		
		if (!$result && $logexit) \Tools::logSqlError($this) ;
		if (!$result) return false;

		while ($row = $this->fetch_array_assoc($result))
			$aItems[] = $row;
		
		return $aItems;
	}
	function getItemsField($sql, $logexit = true, $field = 0, $assoc = true) {
		$aItems = array();
		$result = false;
		
		if ($sql instanceof StoredProcedure) {
			$sp = $sql ;
			$aQuery = $this->getQuery($sp);
			if (count($aQuery)>1) {
				$result = $this->Execute($sp,$logexit);
				
			} else if (count($aQuery) == 1) {
				$sql = $this->fillQuery($sp,$aQuery[0]) ;
				$result = $this->cnn->query($sql); 
				self::$lastSQL = $sql ;
			}
		} else if ($sql instanceof DbQuery) {
            $sql = $sql->build();
			$result = $this->cnn->query($sql); 	 
			self::$lastSQL = $sql ;
        } else {
			$result = $this->cnn->query($sql);
			self::$lastSQL = $sql ;
		}
		
		if (!$result && $logexit) \Tools::logSqlError($this) ;
		if (!$result) return false;
		
		if ($assoc) {
			while ($row = $this->fetch_array_assoc($result))
				$aItems[] = $row[$field];
		} else {
			while ($row = $this->fetch_array($result))
				$aItems[] = $row[$field];
		}
		return $aItems;
	}
	public function queries($aQuery, $logexit = false){
		self::$lastSQL = "";
		
		foreach ($aQuery as $query) {
		    $sSql = $query ;
		    self::$lastSQL .= $sSql  . ";";
			$result = $this->query($sSql, $logexit);
		}
		
		return $result;
	}
	function fetch_array($resultat){
		return $resultat->fetch_array();
	}
	function fetch_array_assoc($resultat)
	{
		return $resultat->fetch_array(MYSQLI_ASSOC);
	}
	public function Execute(StoredProcedure $sp, $logexit = false){
		self::$lastSQL = "";
		
		$aQuery = $this->getQuery($sp);
		foreach ($aQuery as $query) {
		    $sSql = $this->fillQuery($sp,$query) ;
			$trimedSql = trim($sSql) ;
			if ($trimedSql != "" && $trimedSql != ";") {
				self::$lastSQL .= $sSql  . ";";
				if ($this->showQuery == 1) echo $sSql  . "\n";
				$result = $this->query($sSql, $logexit);
			}
		}
		
		return $result;
	}
	public function Show(StoredProcedure $sp)
	{
		$aQuery = $this->getQuery($sp);
		$sSql = "";
		foreach ($aQuery as $query)
		{
		    echo $this->fillQuery($sp,$query)  . "/n";
		}
	}
	public function getSQL(StoredProcedure $sp)
	{
		$aQuery = $this->getQuery($sp);
		$sSql = "";
		foreach ($aQuery as $query)
		{
		    $sSql .= $this->fillQuery($sp,$query)  . ";";
		}
		return $sSql;
	}
	
	private function fillQuery(StoredProcedure $sp,$query)
	{
		$dom = new \DomDocument();
		$dom->load(__DIR__ . "/../Config/Descripteur/".$sp->ProcedureName.".xml");
		$xpath = new \DOMXPath($dom);
		$root = $dom->documentElement;
		$sCommand = $query;
		
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
							if (($sValue == "" || $sValue == null))
								$sValue = "NULL";
								
							break;
							
						case "N":
							if (($sValue == "" || $sValue == null))
								$sValue = "NULL";
								
							break;
							
						case "MAIL":
							$sValue = "'".$sValue."'";
							break;
							
						case "VA":
							$sValue = "'".urlencode(utf8_decode($sValue))."'";
							break;
							
						case "NOMVAR":
							//Pour passer un nom de variable ou un texte en paramètre
							//$sValue = $sValue;
							break;
							
						case "TEXT":
							$sValue = "'".urlencode(utf8_decode($sValue))."'";
							break;
							
						case "LOG":
							//pour éviter de scinder la requete
							$sValue = "'".str_replace(";\\","; \\",$this->mysqli_real_escape_string($sValue))."'";
							break;
							
						case "B":
							$sValue = ($sValue) ? 1 : 0;
							break;
							
						case "DT":
							$sValue = ($sValue == "") ? "NULL" : "'".date("Y-m-d H:i", $sValue)."'";
							break;
							
						case "DTSTR":
							$sValue = ($sValue == "") ? "NULL" : "'".$sValue."'";
							break;
					}
					
					$sCommand = str_replace("@$sParameterName", $sValue, $sCommand);
					//echo $sCommand ."\n" ;
				}
			}
		}

		//echo $sCommand."\n" ;

		return $sCommand;
	}
	
	private function getQuery(StoredProcedure $sp)
	{
		$dom = new \DomDocument();
		$dom->load(__DIR__ . "/../Config/Descripteur/".$sp->ProcedureName.".xml");
		$xpath = new \DOMXPath($dom);
		$root = $dom->documentElement;
		$sCommand = $dom->getElementsByTagName("Instruction")->item(0)->nodeValue;
		$aQuery = explode(";\\", $sCommand);
		$aQueryOut = array() ;
		foreach($aQuery as $sSql) {
			$trimedSql = trim($sSql) ;
			if ($trimedSql != "" && $trimedSql != ";") {
				$aQueryOut[] = $sSql ;
			}
		}
		return $aQueryOut ;
	}
	
	private function BuildQuery(StoredProcedure $sp)
	{
		$dom = new \DomDocument();
		$dom->load(__DIR__ . "/../Config/Descripteur/".$sp->ProcedureName.".xml");
		$xpath = new \DOMXPath($dom);
		$root = $dom->documentElement;
		$sCommand = $dom->getElementsByTagName("Instruction")->item(0)->nodeValue;
		
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
							if (($sValue == "" || $sValue == null))
								$sValue = "NULL";
								
							break;
							
						case "N":
							if (($sValue == "" || $sValue == null))
								$sValue = "NULL";
								
							break;
							
						case "MAIL":
							$sValue = "'".$sValue."'";
							break;
							
						case "VA":
							$sValue = "'".urlencode(utf8_decode($sValue))."'";
							break;
							
						case "NOMVAR":
							//Pour passer un nom de variable ou un texte en paramètre
							//$sValue = $sValue;
							break;
							
						case "TEXT":
							$sValue = "'".urlencode(utf8_decode($sValue))."'";
							break;
							
						case "LOG":
							$sValue = "'".str_replace(";\\","; \\",$this->mysqli_real_escape_string($sValue))."'";
							//echo $sValue ."\n" ;
							break;
							
						case "B":
							$sValue = ($sValue) ? 1 : 0;
							break;
							
						case "DT":
							$sValue = ($sValue == "") ? "NULL" : "'".date("Y-m-d H:i", $sValue)."'";
							break;
							
						case "DTSTR":
							$sValue = ($sValue == "") ? "NULL" : "'".$sValue."'";
							break;
					}
					
					$sCommand = str_replace("@$sParameterName", $sValue, $sCommand);
				}
			}
		}

		//echo $sCommand."\n" ;

		return $sCommand;
	}
	public function insert($table, $data, $null_values = false, $use_cache = true, $type = SGBD::INSERT, $add_prefix = true)
    {
        if (!$data && !$null_values) {
            return true;
        }

        if ($add_prefix) {
            $table = _DB_PREFIX_.$table;
        }

        if ($type == SGBD::INSERT) {
            $insert_keyword = 'INSERT';
        } elseif ($type == SGBD::INSERT_IGNORE) {
            $insert_keyword = 'INSERT IGNORE';
        } elseif ($type == SGBD::REPLACE) {
            $insert_keyword = 'REPLACE';
        } elseif ($type == SGBD::ON_DUPLICATE_KEY) {
            $insert_keyword = 'INSERT';
        } else {
            throw new Exception('Bad keyword, must be Db::INSERT or Db::INSERT_IGNORE or Db::REPLACE');
        }

        // Check if $data is a list of row
        $current = current($data);
        if (!is_array($current) || isset($current['type'])) {
            $data = array($data);
        }

        $keys = array();
        $values_stringified = array();
        $first_loop = true;
        $duplicate_key_stringified = '';
        foreach ($data as $row_data) {
            $values = array();
            foreach ($row_data as $key => $value) {
                if (!$first_loop) {
                    // Check if row array mapping are the same
                    if (!in_array("`$key`", $keys)) {
                        throw new Exception('Keys form $data subarray don\'t match');
                    }

                    if ($duplicate_key_stringified != '') {
                        throw new Exception('On duplicate key cannot be used on insert with more than 1 VALUE group');
                    }
                } else {
                    $keys[] = '`'.\Tools::bqSQL($key).'`';
                }

                if (!is_array($value)) {
                    $value = array('type' => 'text', 'value' => $value);
                }
                if ($value['type'] == 'sql') {
                    $values[] = $string_value = $value['value'];
                } else {
                    $values[] = $string_value = $null_values && ($value['value'] === '' || is_null($value['value'])) ? 'NULL' : "'{$value['value']}'";
                }

                if ($type == SGBD::ON_DUPLICATE_KEY) {
                    $duplicate_key_stringified .= '`'.\Tools::bqSQL($key).'` = '.$string_value.',';
                }
            }
            $first_loop = false;
            $values_stringified[] = '('.implode(', ', $values).')';
        }
        $keys_stringified = implode(', ', $keys);

        $sql = $insert_keyword.' INTO `'.$table.'` ('.$keys_stringified.') VALUES '.implode(', ', $values_stringified);
        if ($type == SGBD::ON_DUPLICATE_KEY) {
            $sql .= ' ON DUPLICATE KEY UPDATE '.substr($duplicate_key_stringified, 0, -1);
        }
		
        return (bool)$this->q($sql);
    }
	/**
     * Executes an UPDATE query
     *
     * @param string $table Table name without prefix
     * @param array $data Data to insert as associative array. If $data is a list of arrays, multiple insert will be done
     * @param string $where WHERE condition
     * @param int $limit
     * @param bool $null_values If we want to use NULL values instead of empty quotes
     * @param bool $use_cache
     * @param bool $add_prefix Add or not _DB_PREFIX_ before table name
     * @return bool
     */
    public function update($table, $data, $where = '', $limit = 0, $null_values = false, $add_prefix = true)
    {
        if (!$data) {
            return true;
        }

        if ($add_prefix) {
            $table = _DB_PREFIX_.$table;
        }

        $sql = 'UPDATE `'.\Tools::bqSQL($table).'` SET ';
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $value = array('type' => 'text', 'value' => $value);
            }
            if ($value['type'] == 'sql') {
                $sql .= '`'.\Tools::bqSQL($key)."` = {$value['value']},";
            } else {
                $sql .= ($null_values && ($value['value'] === '' || is_null($value['value']))) ? '`'.\Tools::bqSQL($key).'` = NULL,' : '`'.\Tools::bqSQL($key)."` = '{$value['value']}',";
            }
        }

        $sql = rtrim($sql, ',');
        if ($where) {
            $sql .= ' WHERE '.$where;
        }
        if ($limit) {
            $sql .= ' LIMIT '.(int)$limit;
        }

        return (bool)$this->q($sql);
    }

    /**
     * Executes a DELETE query
     *
     * @param string $table Name of the table to delete
     * @param string $where WHERE clause on query
     * @param int $limit Number max of rows to delete
     * @param bool $use_cache Use cache or not
     * @param bool $add_prefix Add or not _DB_PREFIX_ before table name
     * @return bool
     */
    public function delete($table, $prefix = _DB_PREFIX_, $where = '', $limit = 0, $add_prefix = true)
    {
        if ($prefix && !preg_match('#^'.$prefix.'#i', $table) && $add_prefix) {
            $table = $prefix.$table;
        }

        $this->result = false;
        $sql = 'DELETE FROM `'.\Tools::bqSQL($table).'`'.($where ? ' WHERE '.$where : '').($limit ? ' LIMIT '.(int)$limit : '');
        $res = $this->query($sql);

        return (bool)$res;
    }
	 protected function q($sql)
    {
        if ($sql instanceof DbQuery) {
            $sql = $sql->build();
        }

        $this->result = false;
        $result = $this->query($sql);
        
		self::$lastSQL = $sql ;
        return $result;
    }
}

?>