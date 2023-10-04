<?php
class Tools {
	public static $starttime = null ;
	public static $elapsed = array() ;
	
	public static function ResetTunning() {
		self::$starttime = null;
	}
	public static function Tunning($action) {
		$elapsed = 0 ;
		if (self::$starttime !== null) {
			$endTime = microtime(true);
			$elapsed = round(1000*($endTime - self::$starttime))/1000;
		}
		self::$starttime = microtime(true);
		file_put_contents(__DIR__ ."/../PJ/tunning.log", $action." || " . $elapsed . "\n", FILE_APPEND | LOCK_EX);
	}
	public static function logMail($appli,$from,$to,$sujet,$message) {
		file_put_contents(__DIR__ ."/../logs/mail-".$appli.".log", date("Y-m-d H:i:s") . " FROM " . $from . " TO " . implode(',',$to) . " - " . $sujet . " *** ". $message. " || " . UserInfo::get('UserId') . "\n", FILE_APPEND | LOCK_EX);
	}
	public static function l($filename,$message) {
		self::logToFile($filename,$message) ;
	}
	public static function logToFile($filename,$message) {
		file_put_contents(__DIR__ ."/../logs/".$filename, date("Y-m-d H:i:s") . " - ".$message." || " . UserInfo::get('UserId') . "\n", FILE_APPEND | LOCK_EX);
	}
	public static function logCodeError($e, $message = '', $exit = true) {
		$codeErreur = rand();
		$s = nl2br($e->getTraceAsString()) ;
		$ProcId = md5($s) ;
		file_put_contents(__DIR__ ."/../logs/codeerror.log", date("Y-m-d H:i:s") . " - [".$codeErreur." - Id " .$ProcId. "]". $e->getCode() . " - " . $e->getMessage()." || " . UserInfo::get('UserId') . "\n", FILE_APPEND | LOCK_EX);
		file_put_contents(__DIR__ ."/../logs/codeerror.log", $s. "\n", FILE_APPEND | LOCK_EX);
		
		if ($exit) {
			$arr = array('status' => 'KO', 'message' => utf8_encode('Un problème est survenu, contactez le service informatique en indiquant le code erreur : ' . $codeErreur));
			header('Content-type: application/json');
			echo json_encode($arr);
			\Technique\AutoLoad::exitGeneric();
		}
	}
	public static function logSqlError(&$bdd, $message = '', $exit = true, $showSql = true) {
		$codeErreur = rand();
		$trace = debug_backtrace();
		//$trace = array_reverse($trace);
		// array_shift($trace); // remove {main}
		// array_pop($trace); // remove call to this method
		$aT = array() ;
		if ($trace != null) {
			foreach($trace as $t) {
				$aT[]= \addslashes($t["file"] . "(" . $t["line"] . ")" . " : " . $t["class"] . $t["type"] . $t["function"]) ;
			}
		} 
		$s = implode(PHP_EOL,$aT);
		$ProcId = md5($s) ;
		file_put_contents(__DIR__ ."/../logs/sqlerror.log", date("Y-m-d H:i:s") . " - [".$codeErreur." - Id " .$ProcId. "]".$message." || " . UserInfo::get('UserId') . "\n", FILE_APPEND | LOCK_EX);
		file_put_contents(__DIR__ ."/../logs/sqlerror.log", $s. "\n", FILE_APPEND | LOCK_EX);
		
		if ($showSql) {
			file_put_contents(__DIR__ ."/../logs/sqlerror.log", date("Y-m-d H:i:s") . " - " . $bdd->getError(). "\n", FILE_APPEND | LOCK_EX);
			file_put_contents(__DIR__ ."/../logs/sqlerror.log", date("Y-m-d H:i:s") . " - ". \BDD\MySQL::$lastSQL. "\n", FILE_APPEND | LOCK_EX);
		}
		if ($exit) {
			$arr = array('status' => 'KO', 'message' => utf8_encode('Un problème est survenu, contactez le service informatique en indiquant le code erreur : ' . $codeErreur));
			header('Content-type: application/json');
			echo json_encode($arr);
			\Technique\AutoLoad::exitGeneric();
		}
	}
	public static function logWarning($errno, $errstr, $trace) {
		file_put_contents(__DIR__ ."/../logs/warning.log", date("Y-m-d H:i:s") . " - My WARNING [$errno] $errstr || " . $trace . "\n", FILE_APPEND | LOCK_EX);
	}
	public static function logDeprecated($errno, $errstr, $trace) {
		file_put_contents(__DIR__ ."/../logs/deprecated.log", date("Y-m-d H:i:s") . " - My WARNING [$errno] $errstr || " . $trace . "\n", FILE_APPEND | LOCK_EX);
	}
	public static function cleanHTML($html) {
		$html = self::removeAttributesHTML($html);
		$html = self::replaceImageHTML($html);
		$html = self::replaceHtmlBody($html);
		return $html ;
	}
	public static function replaceHtmlBody($html) {
		$dom = new DOMDocument;
		libxml_use_internal_errors(true);
		$dom->loadHTML($html,LIBXML_HTML_NODEFDTD);//// # remove <!DOCTYPE 
		$dom->removeChild($dom->doctype);
		$output = substr($dom->saveHTML(), 12, -15) ;
		return $output ;
	}
	public static function addSpanNunitoMPDF($html) {
		$lidot = "<li><span class='divLiDot'><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAYAAAAGCAYAAADgzO9IAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsIAAA7CARUoSoAAAABYSURBVBhXY/x5k0GBgYGhBIijgPgfEC8B4j6QxBQgIwOImYEYBP4A8SSQxDsgQxAshADPmYAESDs6+A+SAJkJ0g4Dv4F4CcgoOSAjH4gjgfg/SJCBgWESADcmFzkKfD9ZAAAAAElFTkSuQmCC' />&nbsp;&nbsp;</span>";
		$lidot .= "<span class='spannunito' style='float:left;'>" ;
		$liend = "</span></li>" ;
		
		$html = str_replace("<li>",$lidot,$html);
		$html = str_replace("</li>",$liend,$html);
		return $html ;
	}
	public static function removeTableLiDotsMPDF($html) {
		$dom = new DOMDocument();
		libxml_use_internal_errors(true);
		$dom->loadHTML($html); // loads your html
		$xpath = new DOMXPath($dom);
		$nodes = $xpath->query('//table//*[@class="divLiDot"]'); // find your image
		foreach ($nodes as $node) {   // Iterate over found elements		
			$node->parentNode->removeChild($node);
		}
		$output = $dom->saveHTML();                  
		return $output ;
	}
	public static function replaceImageHTML($html) {
		$dom = new DOMDocument();
		libxml_use_internal_errors(true);
		$dom->loadHTML($html); // loads your html
		$xpath = new DOMXPath($dom);
		$nodes = $xpath->query("//img"); // find your image
		foreach ($nodes as $node) {   // Iterate over found elements		
			$value = $node->attributes->getNamedItem('src')->nodeValue;
			
			$domaine = "www.factornet.aqua.local" ;
			$domaine = (cst_MODE == "REC") ? "www.recette.factornet.jardins-assainissement.fr" : $domaine ;
			$domaine = (cst_MODE == "PROD") ? "www.factornet.jardins-assainissement.fr" : $domaine ;
				
			$protocole = "http://" ;
			$protocole = (cst_MODE == "REC") ? "https://" : $protocole ;
			$protocole = (cst_MODE == "PROD") ? "https://" : $protocole ;
				
			$domainePJ = $protocole . $domaine . '/PJ/' ;
			if (self::startsWith($value,$domainePJ)) {
				$value = str_replace($domainePJ,'PJ/', $value) ;
			}
			$domaineAssets = $protocole . $domaine . '/assets/' ;
			if (self::startsWith($value,$domaineAssets)) {
				$value = str_replace($domaineAssets,'assets/', $value) ;
			}
			
			if (!self::startsWith($value,'data:image') && !self::startsWith($value,'blob:') && !self::startsWith($value,'PJ') && !self::startsWith($value,'assets')) {
				//echo "src toto =$value ". self::startsWith($value,'PJ') ." new startsWith " . strpos($value, 'PJ') . " \n";
				//$contents = file_get_contents($value);
				//echo "contents=$contents\n";
				if ($value === null || trim($value) == "") {
					$uri = GestionImage::data_uri(__DIR__ . "/../assets/images/vide.png") ;
				} else {
					$uri = GestionImage::data_uri($value) ;
					//file_put_contents(__DIR__ . "/../PJ/imagesConversion.log",'FROM URL' . $value . ' => ' . $uri. "\n", FILE_APPEND | LOCK_EX) ;
					if ($uri === false) {
						$uri = GestionImage::data_uri(__DIR__ . "/../assets/images/vide.png") ;
					}
				}
				$node->attributes->getNamedItem('src')->nodeValue = $uri ;
				//echo "uri=$uri\n";
			} else if (self::startsWith($value,'PJ')) {
				$value = __DIR__ . "/../" . $value ;
				if (file_exists($value)) {
					$uri = GestionImage::data_uri($value) ;
					$node->attributes->getNamedItem('src')->nodeValue = $uri ;
				
				} else {
					//echo "file not exists = $value\n";
				}
			} else if (self::startsWith($value,'assets')) {
				$value = __DIR__ . "/../" . $value ;
				if (file_exists($value)) {
					$uri = GestionImage::data_uri($value) ;
					$node->attributes->getNamedItem('src')->nodeValue = $uri ;
				
				} else {
					//echo "file not exists = $value\n";
				}
				
			} else if ($value === null && $value == "") {
				$node->parentNode->removeChild($node);
				
			} else { 
			}
		}
		$output = $dom->saveHTML();                  
		return $output ;
	}
	public static function url_get_contents($Url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $Url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	public static function removeAttributesHTML($html) {
		$aExclude = array('img','td','br') ; // 'br'
		$html = str_replace('float:left;','display:inline-block;',$html);
		$html = str_replace('float: left;','display:inline-block;',$html);
		$html = str_replace('calc(100% - 30px);','90%;',$html);
		$dom = new DOMDocument;                 // init new DOMDocument
		libxml_use_internal_errors(true);
		$dom->loadHTML($html);
		$xpath = new DOMXPath($dom);                  // load HTML into it
		$nodes = $xpath->query('//*');  // Find elements with a style attribute
		foreach ($nodes as $node) {              // on enleve les balises vides
			if (trim($node->nodeValue) == '' && !in_array($node->nodeName,$aExclude)) {
				//echo $node->nodeName ."\n";
				$node->parentNode->removeChild($node);
			}
		}
		// while (($node_list = $xpath->query('//*[not(node())]')) && $node_list->length) { //'//*[not(node())]'
			// foreach ($node_list as $node) {
				// echo $node->nodeName ."\n";
				// $node->parentNode->removeChild($node); //remove empty tags
			// }
		// }
		// $nodes = $xpath->query('//*[@style]');  // Find elements with a style attribute
		// foreach ($nodes as $node) {              // Iterate over found elements
			// $node->removeAttribute('style');    // Remove style attribute
		// }
		$nodes = $xpath->query('//*[@data-mce-src]');  // Find elements with a style attribute
		foreach ($nodes as $node) {              // Iterate over found elements
			$node->removeAttribute('data-mce-src');    // Remove style attribute
		}
		$nodes = $xpath->query('//*[@data-mce-style]');  // Find elements with a style attribute
		foreach ($nodes as $node) {              // Iterate over found elements
			$node->removeAttribute('data-mce-style');    // Remove style attribute
		}
		$nodes = $xpath->query('//li[@style]');  // remove display:inline-block pour la balise LI
		foreach ($nodes as $node) {              
			$node->removeAttribute('style');
		}
		$nodes = $xpath->query('//ul/li');  // add class nunito to UL
		foreach ($nodes as $node){
			$node->removeAttribute('style'); 
			$node->setAttribute('class', 'linunito');
		}
		$nodes = $xpath->query('//ul/li/span[@style]');  // add class nunito to UL
		foreach ($nodes as $node){
			$node->removeAttribute('style'); 
			$node->setAttribute('class', 'spannunito');
		}
		$nodes = $xpath->query('//ul/li/div[@style]');  // add class nunito to UL
		foreach ($nodes as $node){
			$node->removeAttribute('style'); 
			$node->setAttribute('class', 'spannunito');
		}
		$nodes = $xpath->query('//ul/li/div/span[@style]');  // add class nunito to UL
		foreach ($nodes as $node){
			$node->removeAttribute('style'); 
		}
		$nodes = $xpath->query('//ul');  // add class nunito to UL
		foreach ($nodes as $node){
			$node->setAttribute('class', 'nunito black');
		}
		
		$output = $dom->saveHTML() ;
		return $output ;
	}
	public static function getLastStringBetween($message, $start, $toFindBegin, $toFindEnd) {
		$compteur = 1 ;
		$len = strlen($toFindBegin) ;
		$endlen = strlen($toFindEnd) ;
		$position = $start+$len ;
		$end = $start+$len ;
		while ($compteur > 0) {
			$next = strpos($message,$toFindBegin,$position) ;
			$end = strpos($message,$toFindEnd,$position) ;
			if ($next>0 && $next < $end) {
				$compteur += 1 ;
				$position = $next + $len ;
			} else {
				$compteur -= 1 ;
				$position = $end + $endlen ;
			}
			if ($compteur == 0) {
				break ;
			}
		}
		return $end ;
	}
	public static function strip_tags_content($string) { 
		// ----- remove HTML TAGs ----- 
		$string = preg_replace ('/<[^>]*>/', ' ', $string); 
		// ----- remove control characters ----- 
		$string = str_replace("\r", '', $string);
		$string = str_replace("\n", ' ', $string);
		$string = str_replace("\t", ' ', $string);
		// ----- remove multiple spaces ----- 
		$string = trim(preg_replace('/ {2,}/', ' ', $string));
		return $string;
	}
	public static function getFirstStringBetweenInfo($message, $start, $toFindBegin, $toFindEnd) {
		$aFind = array("deb" => -1) ;
		if (strpos(strtolower($message),strtolower($toFindBegin),$start)>-1) {
			$deb = strpos(strtolower($message),strtolower($toFindBegin),$start) ;
			$debLen = strlen($toFindBegin) ;
			$fin = self::getLastStringBetween($message, $deb, $toFindBegin, $toFindEnd) ;
			//$fin = strpos($message,$toFindEnd,$deb + $debLen) ;
			$content = substr($message,$deb+$debLen,$fin - $deb - $debLen);
			
			$aFind["deb"] = $deb ;
			$aFind["debLen"] = $debLen ;
			$aFind["fin"] = $fin ;
			$aFind["content"] = $content ;
		}
		return $aFind ;
	}
	public static function sanitize_digitaleo( $name) {
		$name = self::remove_accents($name) ;
		$special_chars = array('?', '[', ']', '/', '\\', '=', '<', '>', ':', ';', ',', "'", '"', '&', '$', '#', '*', '(', ')', '|', '~', '`', '!', '{', '}', '%', '+', '-', chr( 0 ) );
		$name = str_replace( $special_chars, '', $name );
		$name = str_replace('-', ' ', $name );
		return $name ;
	}
	public static function slugify( $name) {
		$name = strtolower($name) ;
		$name = self::remove_accents($name) ;
		$special_chars = array( '?', '[', ']', '/', '\\', '=', '<', '>', ':', ';', ',', "'", '"', '&', '$', '#', '*', '(', ')', '|', '~', '`', '!', '{', '}', '%', '+', chr( 0 ) );
		/**
		 * Filters the list of characters to remove from a filename.
		 *
		 * @since 2.8.0
		 *
		 * @param array  $special_chars Characters to remove.
		 * @param string $filename_raw  Filename as it was passed into sanitize_file_name().
		 */
		$name      = preg_replace( "#\x{00a0}#siu", ' ', $name );
		$name      = str_replace( $special_chars, '', $name );
		$name      = str_replace( array( '%20', '+' ), '-', $name );
		$name      = preg_replace( '/[\r\n\t -]+/', '-', $name );
		$name      = trim( $name, '.-_' );

		return $name ;
	}
	public static function sanitize_filename($filename) {
		$t = explode('.',$filename) ;
		$name = $t[0] ;
		for ($i=1;$i<count($t)-1;$i++) {
			$name .= $t[$i] ;
		}
		if (count($t)>1) {
			$ext = $t[count($t)-1] ;
		}
		$filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', self::strToNoAccent($name)) . "." . $ext;
		return $filename ;
	}
	public static function sanitize_field($field) {
		$field = str_replace(" ","_",$field) ;
		$field = preg_replace('/[^A-Za-z0-9_]/', '_', self::strToNoAccent($field));
		return $field ;
	}
	public static function stripAccents_new($string){
		return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	}
	public static function strToNoAccent($var) {
		$var = str_replace(
			array(
				'à', 'â', 'ä', 'á', 'ã', 'å',
				'î', 'ï', 'ì', 'í', 
				'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 
				'ù', 'û', 'ü', 'ú', 
				'é', 'è', 'ê', 'ë', 
				'ç', 'ÿ', 'ñ',
				'À', 'Â', 'Ä', 'Á', 'Ã', 'Å',
				'Î', 'Ï', 'Ì', 'Í', 
				'Ô', 'Ö', 'Ò', 'Ó', 'Õ', 'Ø', 
				'Ù', 'Û', 'Ü', 'Ú', 
				'É', 'È', 'Ê', 'Ë', 
				'Ç', 'Ÿ', 'Ñ', 
			),
			array(
				'a', 'a', 'a', 'a', 'a', 'a', 
				'i', 'i', 'i', 'i', 
				'o', 'o', 'o', 'o', 'o', 'o', 
				'u', 'u', 'u', 'u', 
				'e', 'e', 'e', 'e', 
				'c', 'y', 'n', 
				'A', 'A', 'A', 'A', 'A', 'A', 
				'I', 'I', 'I', 'I', 
				'O', 'O', 'O', 'O', 'O', 'O', 
				'U', 'U', 'U', 'U', 
				'E', 'E', 'E', 'E', 
				'C', 'Y', 'N', 
			),$var);
		return $var;
	}
	public static function remove_accents( $string ) {
		if ( ! preg_match( '/[\x80-\xff]/', $string ) ) {
			return $string;
		}

		if (self::seems_utf8( $string ) ) {
			$chars = array(
				// Decompositions for Latin-1 Supplement
				'ª' => 'a',
				'º' => 'o',
				'À' => 'A',
				'Á' => 'A',
				'Â' => 'A',
				'Ã' => 'A',
				'Ä' => 'A',
				'Å' => 'A',
				'Æ' => 'AE',
				'Ç' => 'C',
				'È' => 'E',
				'É' => 'E',
				'Ê' => 'E',
				'Ë' => 'E',
				'Ì' => 'I',
				'Í' => 'I',
				'Î' => 'I',
				'Ï' => 'I',
				'Ð' => 'D',
				'Ñ' => 'N',
				'Ò' => 'O',
				'Ó' => 'O',
				'Ô' => 'O',
				'Õ' => 'O',
				'Ö' => 'O',
				'Ù' => 'U',
				'Ú' => 'U',
				'Û' => 'U',
				'Ü' => 'U',
				'Ý' => 'Y',
				'Þ' => 'TH',
				'ß' => 's',
				'à' => 'a',
				'á' => 'a',
				'â' => 'a',
				'ã' => 'a',
				'ä' => 'a',
				'å' => 'a',
				'æ' => 'ae',
				'ç' => 'c',
				'è' => 'e',
				'é' => 'e',
				'ê' => 'e',
				'ë' => 'e',
				'ì' => 'i',
				'í' => 'i',
				'î' => 'i',
				'ï' => 'i',
				'ð' => 'd',
				'ñ' => 'n',
				'ò' => 'o',
				'ó' => 'o',
				'ô' => 'o',
				'õ' => 'o',
				'ö' => 'o',
				'ø' => 'o',
				'ù' => 'u',
				'ú' => 'u',
				'û' => 'u',
				'ü' => 'u',
				'ý' => 'y',
				'þ' => 'th',
				'ÿ' => 'y',
				'Ø' => 'O',
				// Decompositions for Latin Extended-A
				'A' => 'A',
				'a' => 'a',
				'A' => 'A',
				'a' => 'a',
				'A' => 'A',
				'a' => 'a',
				'C' => 'C',
				'c' => 'c',
				'C' => 'C',
				'c' => 'c',
				'C' => 'C',
				'c' => 'c',
				'C' => 'C',
				'c' => 'c',
				'D' => 'D',
				'd' => 'd',
				'Ð' => 'D',
				'd' => 'd',
				'E' => 'E',
				'e' => 'e',
				'E' => 'E',
				'e' => 'e',
				'E' => 'E',
				'e' => 'e',
				'E' => 'E',
				'e' => 'e',
				'E' => 'E',
				'e' => 'e',
				'G' => 'G',
				'g' => 'g',
				'G' => 'G',
				'g' => 'g',
				'G' => 'G',
				'g' => 'g',
				'G' => 'G',
				'g' => 'g',
				'H' => 'H',
				'h' => 'h',
				'H' => 'H',
				'h' => 'h',
				'I' => 'I',
				'i' => 'i',
				'I' => 'I',
				'i' => 'i',
				'I' => 'I',
				'i' => 'i',
				'I' => 'I',
				'i' => 'i',
				'I' => 'I',
				'i' => 'i',
				'?' => 'IJ',
				'?' => 'ij',
				'J' => 'J',
				'j' => 'j',
				'K' => 'K',
				'k' => 'k',
				'?' => 'k',
				'L' => 'L',
				'l' => 'l',
				'L' => 'L',
				'l' => 'l',
				'L' => 'L',
				'l' => 'l',
				'?' => 'L',
				'?' => 'l',
				'L' => 'L',
				'l' => 'l',
				'N' => 'N',
				'n' => 'n',
				'N' => 'N',
				'n' => 'n',
				'N' => 'N',
				'n' => 'n',
				'?' => 'n',
				'?' => 'N',
				'?' => 'n',
				'O' => 'O',
				'o' => 'o',
				'O' => 'O',
				'o' => 'o',
				'O' => 'O',
				'o' => 'o',
				'Œ' => 'OE',
				'œ' => 'oe',
				'R' => 'R',
				'r' => 'r',
				'R' => 'R',
				'r' => 'r',
				'R' => 'R',
				'r' => 'r',
				'S' => 'S',
				's' => 's',
				'S' => 'S',
				's' => 's',
				'S' => 'S',
				's' => 's',
				'Š' => 'S',
				'š' => 's',
				'T' => 'T',
				't' => 't',
				'T' => 'T',
				't' => 't',
				'T' => 'T',
				't' => 't',
				'U' => 'U',
				'u' => 'u',
				'U' => 'U',
				'u' => 'u',
				'U' => 'U',
				'u' => 'u',
				'U' => 'U',
				'u' => 'u',
				'U' => 'U',
				'u' => 'u',
				'U' => 'U',
				'u' => 'u',
				'W' => 'W',
				'w' => 'w',
				'Y' => 'Y',
				'y' => 'y',
				'Ÿ' => 'Y',
				'Z' => 'Z',
				'z' => 'z',
				'Z' => 'Z',
				'z' => 'z',
				'Ž' => 'Z',
				'ž' => 'z',
				'?' => 's',
				// Decompositions for Latin Extended-B
				'?' => 'S',
				'?' => 's',
				'?' => 'T',
				'?' => 't',
				// Euro Sign
				'€' => 'E',
				// GBP (Pound) Sign
				'£' => '',
				// Vowels with diacritic (Vietnamese)
				// unmarked
				'O' => 'O',
				'o' => 'o',
				'U' => 'U',
				'u' => 'u',
				// grave accent
				'?' => 'A',
				'?' => 'a',
				'?' => 'A',
				'?' => 'a',
				'?' => 'E',
				'?' => 'e',
				'?' => 'O',
				'?' => 'o',
				'?' => 'O',
				'?' => 'o',
				'?' => 'U',
				'?' => 'u',
				'?' => 'Y',
				'?' => 'y',
				// hook
				'?' => 'A',
				'?' => 'a',
				'?' => 'A',
				'?' => 'a',
				'?' => 'A',
				'?' => 'a',
				'?' => 'E',
				'?' => 'e',
				'?' => 'E',
				'?' => 'e',
				'?' => 'I',
				'?' => 'i',
				'?' => 'O',
				'?' => 'o',
				'?' => 'O',
				'?' => 'o',
				'?' => 'O',
				'?' => 'o',
				'?' => 'U',
				'?' => 'u',
				'?' => 'U',
				'?' => 'u',
				'?' => 'Y',
				'?' => 'y',
				// tilde
				'?' => 'A',
				'?' => 'a',
				'?' => 'A',
				'?' => 'a',
				'?' => 'E',
				'?' => 'e',
				'?' => 'E',
				'?' => 'e',
				'?' => 'O',
				'?' => 'o',
				'?' => 'O',
				'?' => 'o',
				'?' => 'U',
				'?' => 'u',
				'?' => 'Y',
				'?' => 'y',
				// acute accent
				'?' => 'A',
				'?' => 'a',
				'?' => 'A',
				'?' => 'a',
				'?' => 'E',
				'?' => 'e',
				'?' => 'O',
				'?' => 'o',
				'?' => 'O',
				'?' => 'o',
				'?' => 'U',
				'?' => 'u',
				// dot below
				'?' => 'A',
				'?' => 'a',
				'?' => 'A',
				'?' => 'a',
				'?' => 'A',
				'?' => 'a',
				'?' => 'E',
				'?' => 'e',
				'?' => 'E',
				'?' => 'e',
				'?' => 'I',
				'?' => 'i',
				'?' => 'O',
				'?' => 'o',
				'?' => 'O',
				'?' => 'o',
				'?' => 'O',
				'?' => 'o',
				'?' => 'U',
				'?' => 'u',
				'?' => 'U',
				'?' => 'u',
				'?' => 'Y',
				'?' => 'y',
				// Vowels with diacritic (Chinese, Hanyu Pinyin)
				'?' => 'a',
				// macron
				'U' => 'U',
				'u' => 'u',
				// acute accent
				'U' => 'U',
				'u' => 'u',
				// caron
				'A' => 'A',
				'a' => 'a',
				'I' => 'I',
				'i' => 'i',
				'O' => 'O',
				'o' => 'o',
				'U' => 'U',
				'u' => 'u',
				'U' => 'U',
				'u' => 'u',
				// grave accent
				'U' => 'U',
				'u' => 'u',
			);
			
		} else {
			$chars = array();
			// Assume ISO-8859-1 if not UTF-8
			$chars['in'] = "\x80\x83\x8a\x8e\x9a\x9e"
				. "\x9f\xa2\xa5\xb5\xc0\xc1\xc2"
				. "\xc3\xc4\xc5\xc7\xc8\xc9\xca"
				. "\xcb\xcc\xcd\xce\xcf\xd1\xd2"
				. "\xd3\xd4\xd5\xd6\xd8\xd9\xda"
				. "\xdb\xdc\xdd\xe0\xe1\xe2\xe3"
				. "\xe4\xe5\xe7\xe8\xe9\xea\xeb"
				. "\xec\xed\xee\xef\xf1\xf2\xf3"
				. "\xf4\xf5\xf6\xf8\xf9\xfa\xfb"
				. "\xfc\xfd\xff";

			$chars['out'] = 'EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy';

			$string              = strtr( $string, $chars['in'], $chars['out'] );
			$double_chars        = array();
			$double_chars['in']  = array( "\x8c", "\x9c", "\xc6", "\xd0", "\xde", "\xdf", "\xe6", "\xf0", "\xfe" );
			$double_chars['out'] = array( 'OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th' );
			$string              = str_replace( $double_chars['in'], $double_chars['out'], $string );
		}

		return $string;
	}
	public static function seems_utf8( $str ) {
		self::mbstring_binary_safe_encoding();
		$length = strlen( $str );
		self::reset_mbstring_encoding();
		for ( $i = 0; $i < $length; $i++ ) {
			$c = ord( $str[ $i ] );
			if ( $c < 0x80 ) {
				$n = 0; // 0bbbbbbb
			} elseif ( ( $c & 0xE0 ) == 0xC0 ) {
				$n = 1; // 110bbbbb
			} elseif ( ( $c & 0xF0 ) == 0xE0 ) {
				$n = 2; // 1110bbbb
			} elseif ( ( $c & 0xF8 ) == 0xF0 ) {
				$n = 3; // 11110bbb
			} elseif ( ( $c & 0xFC ) == 0xF8 ) {
				$n = 4; // 111110bb
			} elseif ( ( $c & 0xFE ) == 0xFC ) {
				$n = 5; // 1111110b
			} else {
				return false; // Does not match any model
			}
			for ( $j = 0; $j < $n; $j++ ) { // n bytes matching 10bbbbbb follow ?
				if ( ( ++$i == $length ) || ( ( ord( $str[ $i ] ) & 0xC0 ) != 0x80 ) ) {
					return false;
				}
			}
		}
		return true;
	}
	
	public static function mbstring_binary_safe_encoding( $reset = false ) {
		static $encodings  = array();
		static $overloaded = null;

		if ( is_null( $overloaded ) ) {
			$overloaded = function_exists( 'mb_internal_encoding' ) && ( ini_get( 'mbstring.func_overload' ) & 2 );
		}

		if ( false === $overloaded ) {
			return;
		}

		if ( ! $reset ) {
			$encoding = mb_internal_encoding();
			array_push( $encodings, $encoding );
			mb_internal_encoding( 'ISO-8859-1' );
		}

		if ( $reset && $encodings ) {
			$encoding = array_pop( $encodings );
			mb_internal_encoding( $encoding );
		}
	}
	public static function reset_mbstring_encoding() {
		self::mbstring_binary_safe_encoding(true);
	}
	
	public static function my_json_encode($arr) {
		if (!isset($arr["Profil"])) {
			$arr["Profil"] = UserInfo::get('Profil') ;
		}
		return json_encode($arr) ;
	}
	public static function money_format_sc($n) {
		$s = "";
		if (is_numeric($n)) {
			$n = $n+0; 
			$s = "";
			if (round($n,0) == $n) {
				$s =  $n.",00" ;
			} else if (round($n,1) == $n) {
				$s =  str_replace(".",",",$n."0") ;
			} else {
				$s =  str_replace(".",",",round($n,2)) ;
			}
		}
		return $s;
	}
	public static function money_format_new($n,$euro = false, $ndigit = 2) {
		$s = "";
		if (is_numeric($n)) {
			$n = $n+0; 
			if (round($n,0) == $n) {
				$s =  $n.",00" ;
			} else if (round($n,1) == $n) {
				$s =  str_replace(".",",",$n."0") ;
			} else {
				$s =  str_replace(".",",",round($n,$ndigit)) ;
			}
			
			if ($euro) {
				$s .= " &euro;" ;
			}
		}
		return $s;
	}
	public static function euro_to_money($n,$monnaie) {
		$s = "" ;
		if (is_numeric($n)) {
			$n = $n+0;
			if ($monnaie["TauxChange"] != 1) {
				$n = $n*$monnaie["TauxChange"];
			}
			$s =  str_replace(",",".",$n) ;
		}
		return $s;
	}
	public static function money_to_euro($n,$monnaie) {
		$s = "" ;
		if (is_numeric($n)) {
			$n = $n+0;
			if ($monnaie["TauxChange"] != 1) {
				$n = $n/$monnaie["TauxChange"];
			}
			$s =  str_replace(",",".",$n) ;
		}
		return $s;
	}
	public static function money_format_new_taux($n,$euro,$monnaie) {
		$s = "" ;
		if (is_numeric($n)) {
			$n = $n+0;
			if ($monnaie["TauxChange"] != 1) {
				$n = $n*$monnaie["TauxChange"];
			}
			$s = "";
			if (round($n,0) == $n) {
				$s =  $n.",00" ;
			} else if (round($n,1) == $n) {
				$s =  str_replace(".",",",$n."0") ;
			} else {
				$s =  str_replace(".",",",round($n,2)) ;
			}
			
			if ($euro) {
				$s .= " " . $monnaie["LibelleMonnaie"] ;
			}
		}
		return $s;
	}
	public static function ToNumberSQL($mnt) {
		$s =  str_replace(".",",",$mnt) ;
	}
	public static function startsWith($haystack, $needle)
	{
		return $needle === "" || strpos($haystack, $needle) === 0;
	}
	public static function VerifierAdresseMail($adresse)  
	{  
		$Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';  
		if(preg_match($Syntaxe,$adresse))  
			return true;  
		else  
			return false;  
	}
	public static function endsWith($haystack, $needle)
	{
		return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
	}
	public static function ConvertDateFR($date) {
		if (substr($date,4,1)=="-" && strlen($date) == 10) {
			$date = substr($date,8,2)."/".substr($date,5,2)."/".substr($date,0,4);
		}
		return $date ;
	}
	public static function pSQL($string, $html_ok = false, $bq_sql = false){
		if (!is_numeric($string)) {
			$string = self::escape($string);

			if (!$html_ok) {
				$string = strip_tags(nl2br($string));
			}

			if ($bq_sql === true) {
				$string = str_replace('`', '\`', $string);
			}
		}

		return $string;
	}
	public static function escape($str){
		$search = array("\\", "\0", "\n", "\r", "\x1a", "'", '"');
		$replace = array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"');
		return str_replace($search, $replace, $str);
	}
	public static function bqSQL($string){
		return str_replace('`', '\`', self::pSQL($string));
	}
	public static function GetNombreCA($nb) {
		if ($nb>0 || $nb<0) return $nb;
		return "";
	}
	public static function GetNombreStat($nb) {
		if (is_numeric($nb)) return $nb;
		return 0;
	}
	public static function GetNombreStat1($nb) {
		if ($nb>0) return $nb;
		return 0;
	}
	public static function datefr($date, $sep = '-') {
		$date = explode('-', $date);
		$date = array_reverse($date);
		$date = implode($sep, $date);
		
		return $date;
	}
	public static function ensureDateMySQL($d){
		if ($d == "") return $d ;
		if (strpos($d,"-") == 4) return $d ;
		if (strpos($d,"/") == 2) return self::reverse_date($d) ;
		if (strpos($d,"/") == 4) return str_replace('/','-',$d) ;
		if (strpos($d,"-") == 2) return self::datefr($d) ;
		return "" ;
	}
	public static function ensureDateFR($d){
		if ($d == "") return $d ;
		if (strpos($d,"-") == 4) return self::reverse_date($d,'-','/') ;
		if (strpos($d,"/") == 2) return $d ;
		if (strpos($d,"/") == 4) return self::reverse_date($d,'/','/') ;
		if (strpos($d,"-") == 2) return str_replace('-','/',$d) ;
		return "" ;
	}
	public static function reverse_date($date, $fromsep = '/', $tosep = '-') {
		$date = explode($fromsep, $date);
		$date = array_reverse($date);
		$date = implode($tosep, $date);
		
		return $date;
	}
	// on récupère le libellé du mois en fonction d'un numéro 
	public static function getNomMois($mois) {
		switch($mois)
		{
			case 1 : return "Janvier";
					break;
			case 2 : return "Février";
					break;
			case 3 : return "Mars";
					break;
			case 4 : return "Avril";
					break;
			case 5 : return "Mai";
					break;
			case 6 : return "Juin";
					break;
			case 7 : return "Juillet";
					break;
			case 8 : return "Août";
					break;
			case 9 : return "Septembre";
					break;
			case 10 : return "Octobre";
					break;
			case 11 : return "Novembre";
					break;
			case 12 : return "Décembre";
					break;
			default : return "Incorrect";
		}
	}
	public static function formatPrixRond2($P) {
	  if ($P>0 || $P<0) {
	    return number_format($P,0,',',' ');
	  }  else {
	    return "";
	  }
	}
	public static function ToCSVGeneric($liste, $aFields) {
		$csv = implode(";",$aFields) . "\n";
		foreach($liste as $row)  {
			$aValues = array() ;
			foreach($aFields as $field) {
				$aValues[] = "\"" . stripslashes($row[$field]) . "\"" ;
			}
			$csv .= implode(";",$aValues) . "\n";
		}
		return $csv;
	}
	public static function getLibelleEcheance($echeance = 2){
		if ($echeance == 1) {//à réception
			return "à réception";
		} else if ($echeance == 2) {//1 mois
			return "à 30 jours";
		} else if ($echeance == 3) {//3 mois
			return "à 90 jours";
		} else if ($echeance == 4) {//2 mois
			return "à 60 jours";
		} else if ($echeance == 5) {//45 jours
			return "à 45 jours";
		} else if ($echeance == 6) {
			return "à 30 jours fin de mois";
		}
		return "à 30 jours";
	}	
	public static function getYMDEcheance($echeance = 1){
		if ($echeance == 1) {//à réception
			return date('Y-m-d',strtotime('+1 day'));
		} else if ($echeance == 2) {//1 mois
			return date('Y-m-d',strtotime('+1 month'));
		} else if ($echeance == 3) {//3 mois
			return date('Y-m-d',strtotime('+3 month'));
		} else if ($echeance == 4) {//2 mois
			return date('Y-m-d',strtotime('+2 month'));
		} else if ($echeance == 5) {//45 jours
			return date('Y-m-d',strtotime('+45 days'));
		} else if ($echeance == 6) {
			return self::getYMD30JoursFinDeMois();
		}
		return date('Y-m-d',strtotime('+1 month'));
	}
	public static function getYMD30JoursFinDeMois(){
		$m = date('m',strtotime(date('Y-m-d') . ' +2 month'));
		$y = date('Y',strtotime(date('Y-m-d') . ' +2 month'));
		$d = date('Y-m-d',strtotime($y.'-'.$m.'-01' . ' -1 day'));
		return $d ;
	}
	public static function getYMDJourFinDeMoisPrecedent(){
		$m = date('m');
		$y = date('Y');
		$d = date('Y-m-d',strtotime($y.'-'.$m.'-01' . ' -1 day'));
		return $d ;
	}
}