<?php

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

jimport('joomla.error.log');

final class MyOracleDB
{
	protected static $_log;

	protected static $_instance;
	protected static $_pdo;

	protected  function log($message) {

		$this->_log->addEntry(array('LEVEL' => '1',
				'STATUS' => 'ERROR:',
				'COMMENT' =>$message));
	}
	
	public function isError() {
		$errorInfo = $this->getErrorInfo();
		return $errorInfo[1] != null;
	}
	
	public function getErrorCode(){
		$errorInfo = $this->getErrorInfo();
		return $errorInfo[1];
	}
	
	public function getErrorInfo() {
		return $this->_pdo->errorInfo();
	}

	protected function __construct() # we don't permit an explicit call of the constructor! (like $v = new Singleton())
	{
		$this->_log = &JLog::getInstance('db.error.php');

		$conf =& JFactory::getConfig();
			
		$host = $conf->getValue('config.oracleHost');
		$port = $conf->getValue('config.oraclePort');
		$service = $conf->getValue('config.oracleServiceName');
		$db_username = $conf->getValue('config.oracleUser');
		$db_password = $conf->getValue('config.oraclePassword');
			
		$tns = "
			(DESCRIPTION =
				(ADDRESS_LIST =
					(ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port))
				)
				(CONNECT_DATA =
					(SERVICE_NAME = $service)
				)
			)
			";
			
		try{
			$this->_pdo = new PDO("oci:dbname=".$tns.";charset=TR8MSWIN1254",$db_username,$db_password);
			// hatalar� g�rmek i�in a�a��daki sat�r� uncomment yap
			$this->_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		}catch(Exception $e){
			$this->log ($e->getMessage());
			print_r("Oracle'a bağlanılamadı: ".$e->getMessage());
			exit;
		}

	}

	public function getPDO(){
		return $this->_pdo;
	}

	protected function __clone() # we don't permit cloning the singleton (like $x = clone $v)
	{ }

	public static function getInstance()
	{
		if( self::$_instance === NULL ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}


	/**
	 * Sonuclari dondurur, array icinde array seklinde
	 *
	 * sonuclar[$sonuc_index]['ID'] veya
	 * sonuclar[$sonuc_index][1] �eklinde kullan�l�r
	 *
	 *
	 * */

	public function loadList($sql)
	{

		$sql= $this->convertToIso($sql);
		$results = array();

		$data = $this->_pdo->query($sql);
		if($data != null && isset($data)){
			foreach( $data as $row)
			$results[] = $row;
		}
		$results = $sql= $this->convertToUtf8($results);
		return $results;
	}

	/**
	 * belirtilen dizinin sonraki de�erini d�nd�r�r.
	 * Hata olu�tuysa FALSE d�nd�r�r.
	 *
	 *
	 * */
	public function getNextVal($sequenceName){

		$sql = "Select \"".$sequenceName."\".nextval from dual";

		$results=$this->loadList($sql);
		if($results !== FALSE)
		return $results[0][0];
		return FALSE;
	}
	public function getNextValDYS($sequenceName){
	
		$sql = "Select ".DB_PREFIX.".\"".$sequenceName."\".nextval from dual";
	
		$results=$this->loadList($sql);
		if($results !== FALSE)
			return $results[0][0];
		return FALSE;
	}
	public function getNextVal2($sequenceName){

		$sql = "Select ".$sequenceName.".nextval from dual";

		$results=$this->loadList($sql);
		if($results !== FALSE)
		return $results[0][0];
		return FALSE;
	}

	/**
	 * select calstirmaz
	 *
	 * Ornek:
	 *  //Delete all rows from the FRUIT table
	 *	$count = $dbh->exec("DELETE FROM fruit WHERE colour = 'red'");
	 *
	 *	//Return number of rows that were deleted
	 *	print("Deleted $count rows.\n");
	 *
	 * */

	public function exec($sql){
		$sql= $this->convertToIso($sql);
		// Check if an instance is ceated
		if( self::$_instance === NULL ) {
			self::$_instance = new self();
		}

		return $this->_pdo->exec($sql);
	}


	// @todo �imdiki hali tek prepare e tek sorgu imkan� verir,
	// normalde tek prepare ile birden fazla sorgu �al��t�r�larak h�z kazan�labilir
	/**
	 * Kullan�c�dan al�nan veriler sorguya eklenecekse bu fonksiyon
	 * tercih edilmelidir. SQL injection� engeller.
	 *
	 * Ornek kullan�mlar:
	 *
	 * $sql = 'SELECT name, colour, calories
	 * 		FROM fruit
	 * 		WHERE calories < :calories AND colour = :colour';
	 *
	 * $param = array(':calories' => 150, ':colour' => 'red')
	 *
	 *
	 * veya
	 *
	 *
	 * $sql = 'SELECT name, colour, calories
	 * FROM fruit
	 * WHERE calories < ? AND colour = ?'
	 *
	 * $param = array(150, 'red')
	 *
	 *
	 *
	 * $fetch_style:
	 * 		PDO::FETCH_ASSOC -> kolon ad�n� index olarak kullan�r ['FORM_ID']
	 * 		PDO::FETCH_BOTH  -> hem sayilari hem kolon ad�n� kullan�r
	 * 		PDO::FETCH_NUM   -> sayilari kullan�r [0]
	 *
	 * digerleri icin:
	 * http://www.php.net/manual/en/pdostatement.fetch.php
	 *
	 */

	public function prep_exec($sql, $param, $fetch_style = PDO::FETCH_ASSOC){ 
		$param = $this->CleanSqlInjection($param);
		try {

// 			Her durumda silinen kayıtların logu tutlması için parametre kaldırıldı
// 			if($log <> null && $log == true){
				$db 		= &JFactory::getOracleDBO();
				$user 	 	= &JFactory::getUser();
				$user_id	= $user->getOracleUserId ();
				
				$check = explode(" ",$sql);
				$type = "";
				if (strpos($sql,"DELETE") !== false && in_array("DELETE",$check)) {
					$type = "DELETE";
				}
				if($type == "DELETEX"){ 
					$tablename = trim($this->getInBetweenStrings("FROM","WHERE",$this->parms($sql,$param)));
					$conditionsLine   = trim($this->getInBetweenStrings("WHERE","",$this->parms($sql,$param)));
				
					$i = 0;
					$conditionsArray = explode('AND',$conditionsLine);
					foreach($conditionsArray as $condition){
						$conditionColAndVal = explode("=",trim($condition));
						if(substr($conditionColAndVal[1],0,1) == "'" && substr($conditionColAndVal[1],(strlen($id[1])-1),1) == "'"){
							$conditionColAndVal[1] = substr($conditionColAndVal[1],1,-1);
						}
						$idColumns[$i] = $conditionColAndVal[0];
						$idColumnValues[$i] = $conditionColAndVal[1];
						$i++;
					}
					
					$deletedRowsSql = "SELECT * FROM ".$tablename." WHERE ".$conditionsLine;
					$deletedRows = $db->prep_exec($deletedRowsSql, array());
					
					foreach($deletedRows as $deletedRow){
						$columnKeys = array();
						$columnValues =array();
						$i = 0;
						foreach($deletedRow as $columnKey => $columnValue){
							$columnKeys[$i] = $columnKey;
							$columnValues[$i] = $columnValue;
							$i++;
						}
						
						$backupQuery = "INSERT INTO ".$tablename.' ("'.implode('","',$columnKeys).') VALUES("'.implode('","',$columnValues).'")';
						$sqlForHistory = "INSERT INTO M_HISTORY (DELETED_TABLENAME,DELETED_IDCOLUMN,DELETED_ID,DELETED_VALUES,BACKUP,USER_ID,DELETED_DATE) VALUES(?,?,?,?,?,?,SYSTIMESTAMP)";
				
						if(count($deletedRows) < 2){
							$oldKey   = key($deletedRow);
							$oldValue = $deletedRow[key($deletedRow)];
						}else{
							$oldKey   = json_encode($idColumn);
							$oldValue = json_encode($idColumnValue);
						}
						$paramsForHistory = array($tablename,$oldKey,$oldValue,json_encode($deletedRows),$backupQuery,$user_id);
						$this->parms($sqlForHistory, $paramsForHistory);
// 						$db->prep_exec_insert($sqlForHistory, array($paramsForHistory));
						$db->prep_exec_insert($this->parms($sqlForHistory, $paramsForHistory), array());
					}
				}
// 			}
			
			$param = $this->convertToIso($param);
			
			$s = $this->_pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$s->execute($param);
			
			$results = array();
			
			
			while ($r = $s->fetch($fetch_style)) {
				$results[] = $r;
			}
			
			$results = $this->convertToUtf8($results);
			
		}catch(Exception $e ){
			$this->log ($e->getMessage());
		}
		
		for($i = 0 ; $i < count($results) ; $i++){
			foreach ($results[$i] as $key => $val){
				$results[$i][$key] = stripslashes($val);
				$results[$i][$key] = str_replace('"', '&quot;', $results[$i][$key]);
			}
		}
		return $results;
	}

	private function convertToIso($params){

		for($i=0;$i<count($params);$i++){

			$params[$i] = iconv("UTF-8", "ISO-8859-9//TRANSLIT", $params[$i]);
		}
		return $params;
	}

	private function convertToHex($params){

		for($i=0;$i<count($params);$i++){
			$unpacked = unpack("H*",$params[$i]);
			$params[$i] = $unpacked[1];
		}

		return $params;
	}

	private function convertToUtf8($results){

		$i =0;
		foreach($results as $var=>$val){
			foreach($val as $var2=>$val2){
				$results[$i][$var2] = iconv("ISO-8859-9","UTF-8//TRANSLIT", $results[$i][$var2]);
			}
			$i++;
		}

		//for($i=0;$i<count($results);$i++){
		//for($j=0;$j<count($results[$i])/2;$j++){
		//echo 'res: ' . $results[$i][$j] . '-->';
		//$results[$i][$j] = iconv("ISO-8859-9","UTF-8", $results[$i][$j]);
		//echo $results[$i][$j] . '<br />';
		//}
			
		//}

		return $results;

	}

	private function convertArrayToUtf8($results){

		//$i =0;
		// foreach($results as $var=>$val){
		// foreach($val as $var2=>$val2){
		// $results[$i][$var2] = iconv("ISO-8859-9","UTF-8//TRANSLIT", $results[$i][$var2]);
		// }
		// $i++;
		// }

		foreach($results as $var2=>$val2){
			$results[$var2] = iconv("ISO-8859-9","UTF-8//TRANSLIT", $results[$var2]);
		}


		return $results;

	}

	private function processError() {
		$errorInfo = $this->_pdo->errorInfo();
		$this->log("err: ".print_r($errorInfo,true));

		if($errorInfo[1] == "1"){
			JError::raiseWarning( 500, "Aynı veri(ler) daha önce kaydedilmiş." );
			//JError::raiseWarning( 500, "Hata Kodu: " . $errorInfo[2]. ". (Biriciklik hatası.)" );
			//else if($errorInfo[1] != "1502")
		} else {
			JError::raiseWarning( 500, "Hata Kodu: " . $errorInfo[2] );
		}
	}

	private function processError_WithErrorText(&$errorText) {
		$errorInfo = $this->_pdo->errorInfo();
		$this->log("err: ".print_r($errorInfo,true));
	
		$errorText = $errorInfo[2];
		
		if($errorInfo[1] == "1"){
			JError::raiseWarning( 500, "Hata Kodu: " . $errorInfo[2]. ". (Biriciklik hatası.)" );
			//else if($errorInfo[1] != "1502")
		} else {
			JError::raiseWarning( 500, "Hata Kodu: " . $errorInfo[2] );
		}
	}
	/**
	 * Insert sorgular� i�in kullan�labilir, sat�r d�nd�rmez sorgunun �al���p
	 * �al��mad���n� belirten boolean de�er d�nd�r�r
	 *
	 * parametereler
	 * $sql = Sql İfadesi
	 * $param = Sqlde ? ile replace edilecek değerler(array)
	 * $log = Opsiyonel Parametre(true:log tutmasını sağlar)
	 * dönüş değeleri
	 * true : başarılı
	 * false: başarısız
	 *
	 * */
	public function prep_exec_insert($sql, $param , $log = null){
		$param = $this->CleanSqlInjection($param);
		try {
			for ($i = 0 ; $i < count($param) ; $i++){
				$param[$i] = addslashes($param[$i]);
			}
			if($log <> null && $log == true && 1==2){ 
				$db 		= &JFactory::getOracleDBO();
				$user 	 	= &JFactory::getUser();
				$user_id	= $user->getOracleUserId ();
				
				$check = explode(" ",$sql);
				if (strpos($sql,"INSERT") !== false && in_array("INSERT",$check)) {
					$type = "INSERT";
				}else if(strpos($sql,"UPDATE") !== false && in_array("UPDATE",$check)) {
					$type = "UPDATE";
				} 
				$conditionsLine = $this->getInBetweenStrings("WHERE","",$sql);
			
				$i = 0;
				$conditionsArray = explode('AND',$conditionsLine);
				foreach($conditionsArray as $condition){
					$conditionColAndVal = explode("=",trim($condition));
					if(substr($conditionColAndVal[1],0,1) == "'" && substr($conditionColAndVal[1],(strlen($id[1])-1),1) == "'"){
						$conditionColAndVal[1] = substr($conditionColAndVal[1],1,-1);
					}
					$idColumns[$i] = $conditionColAndVal[0];
					$idColumnValues[$i] = $conditionColAndVal[1];
					$i++;
				}
				
				switch ($type){
					case "INSERT":
						// print_r(getInBetweenStrings("SET","WHERE",$sql));
						break;
					case "UPDATE":
						
						$line= $this->getInBetweenStrings("SET","WHERE",$sql);
						$tablename= trim($this->getInBetweenStrings("UPDATE","SET",$sql));
						$id = $this->getInBetweenStrings("WHERE","",$sql);
						$columns = explode(',',trim($line));
						$i = 0;
						foreach($columns as $column){
							$data = explode("=",trim($column));
							$data[0] = trim($data[0]);
							$data[1] = trim($data[1]);
							$changedColumns[$i]['COLUMN'] = $data[0];
							if(substr($data[1],0,1) == "'" && substr($data[1],(strlen($data[1])-1),1) == "'"){
								$data[1] = substr($data[1],1,-1);
							}
							$changedColumns[$i]['VALUE'] = $data[1];
							$i++;
						}
						
						foreach($changedColumns as $changedColumn){
							$sqlForOldValues = "SELECT * FROM ".$tablename." WHERE ".$conditionsLine;
				
							$oldValues = $db->prep_exec($sqlForOldValues, array());
							if(count($oldValues) < 2){
								$idColumn   = key(current($oldValues));
								$temp = current($oldValues);
								$idColumnValue = $temp[$idColumn];
								
								$oldKey = $changedColumn['COLUMN'];
								$oldValue = $temp[$changedColumn['COLUMN']];
								
								if($oldValue <> $changedColumn['VALUE']){
									$sqlForLog = "INSERT INTO M_LOG (TABLENAME,TABLE_IDCOLUMN,TABLE_ID,COLUMNNAME,OLDVALUE,NEWVALUE,USER_ID,LOG_DATE) VALUES(?,?,?,?,?,?,?,SYSTIMESTAMP)";
									$sqlForLogParams = array($tablename,$idColumn,$idColumnValue,$oldKey,$oldValue,$changedColumn['VALUE'],$user_id);
									$status = $db->prep_exec_insert($sqlForLog, $sqlForLogParams);
									if(!$status){
										return false;
									}
								}
								
							}else{
								$idColumn   = current($idColumns);
								$idColumnValue = current($idColumnValues);
								$oldKey = $changedColumn['COLUMN'];
								$temps = $oldValues;
								foreach ($temps as $temp){
									$oldValue = $temp[$changedColumn['COLUMN']];
									if($oldValue <> $changedColumn['VALUE']){
										$sqlForLog = "INSERT INTO M_LOG (TABLENAME,TABLE_IDCOLUMN,TABLE_ID,COLUMNNAME,OLDVALUE,NEWVALUE,USER_ID,LOG_DATE) VALUES(?,?,?,?,?,?,?,SYSTIMESTAMP)";
										$sqlForLogParams = array($tablename,$idColumn,$idColumnValue,$oldKey,$oldValue,$changedColumn['VALUE'],$user_id);
										$status = $db->prep_exec_insert($sqlForLog, $sqlForLogParams);
									}
								}
								if(!$status){
									return false;
								}
							}
							
						}
						break;
				}
			}
			
			$param= $this->convertToIso($param);
			$s = $this->_pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$this->bindParams ($s, $param);
			$this->_pdo->beginTransaction();
			$r = $s->execute();
			$this->_pdo->commit();
			
			if(!$r) $this->processError();
			
			return $r;

		}catch(Exception $e ){
			$this->log ($e->getMessage());
			return false;
		}
	}
	
	function getInBetweenStrings($start, $end, $str){
		$matches = array();
		$regex = "/(?<=".$start.")(.*)(?=".$end.")/";
		preg_match($regex, $str, $matches);
		return $matches[1];
	}
	
	function CleanSqlInjection($value){
		$sqlInjection = array('/insert/i','/update/i','/delete/i','/union/i','/select/i','/drop/i','/exec/i');
		foreach($value as $key=>$val){
			if(!is_numeric($val)){
				$value[$key] = preg_replace($sqlInjection, '', $val );
			}
		}
		return $value;
	}
	
	function parms($string,$data) {
		$indexed=$data==array_values($data);
		foreach($data as $k=>$v) {
			if(is_string($v)) $v="'$v'";
			if($indexed) $string=preg_replace('/\?/',$v,$string,1);
			else $string=str_replace(":$k",$v,$string);
		}
		return $string;
	}

	public function prep_exec_insert_with_error_text($sql, $param, &$errorText){
		try {
			$param= $this->convertToIso($param);
			$s = $this->_pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$this->bindParams ($s, $param);
			$this->_pdo->beginTransaction();
			$r = $s->execute();
			$this->_pdo->commit();
	
			if(!$r) $this->processError_WithErrorText($errorText);
	
			return $r;
	
		}catch(Exception $e ){
			$this->log ($e->getMessage());
			return false;
		}
	}
	
	private function bindParams ($stmt, $params){
		for($i = 0; $i < count($params); $i++){
			$stmt->bindParam(($i+1), $params[$i], PDO::PARAM_STR, strlen($params[$i]));
		}
	}

	/**
	 * Insert sorgular� i�in kullan�labilir, sat�r d�nd�rmez sorgunun �al���p
	 * �al��mad���n� belirten boolean de�er d�nd�r�r
	 *
	 * d�n�� de�erleri
	 * true : ba�ar�l�
	 * false: ba�ar�s�z
	 *
	 * */
	public function prep_exec_blob_insert($sql, $param){
		$param = $this->convertToHex($param);
		$s = $this->_pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		return $s->execute($param);
	}

	/**
	 * tek bir alan isteniyorsa kullan�labilir, de�erler bir array olarak d�ner.
	 *
	 * */
	public function prep_exec_array($sql, $param){
		$param = $this->CleanSqlInjection($param);
		//$param= $this->convertToIso($param);
		$s = $this->_pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$s->execute($param);

		$results = array();

		try {
			while ($r = $s->fetch(PDO::FETCH_NUM)) {
				$results[] = $r[0];
			}
		}catch(Exception $e ){
			$this->log ($e->getMessage());
		}

		$results = $this->convertArrayToUtf8($results);

		return $results;
	}

	/**
	 * tek bir alan istendi�inde, alanlar� dizi �eklinde d�nd�r�r
	 *
	 * �rnek:
	 *
	 * $sql = "select name from people";
	 *
	 * D�n�� de�eri:
	 *
	 * Array
	 *	(
	 *	    [0] => ahmet
	 *	    [1] => mehmet
	 *	    [2] => hasan
	 *	)
	 *
	 *
	 * */

	public function loadResultArray($sql){
		$sql= $this->convertToIso($sql);
		$results = array();

		foreach ($this->_pdo->query($sql) as $row){
			$results[] = $row[0];
		}
		return $results;
	}

	public function getSystemDate ($format = "DD.MM.YY HH24:MI:SS"){
		$sql = "SELECT TO_CHAR(SYSTIMESTAMP, '".$format."') FROM DUAL";
		$arr = $this->prep_exec_array($sql, null);
		return  $arr[0];
	}

	public function prep_exec_clob($sql, $param, $colName){

		$s = $this->_pdo->prepare($sql);
		$s->execute($param);

		$s->bindColumn($colName, $lob, PDO::PARAM_LOB);

		$rv = $s->fetch(PDO::FETCH_BOUND);
		if ($lob)
		$result = stream_get_contents($lob);
		else
		$result = $lob;

		$results = $this->convertArrayToUtf8(array($result));
		return $results[0];
	}

	public function prep_exec_blob($sql, $param, $colName){

		$s = $this->_pdo->prepare($sql);
		$s->execute($param);

		$s->bindColumn($colName, $lob, PDO::PARAM_LOB);

		$rv = $s->fetch(PDO::FETCH_BOUND);
		$result = fgets($lob);

		return $result;
	}

}
?>