<?php
/**
Author: Koumei Deng
Create Date: 25 Feb 2009
License: Commercial
Refered component: PHPExcel (LGPL)
Function:
Simply import Excel(2003) data to database

Note: This function is very simple. Please keep in mind that this component only for manipulating some datatables of simple data, it could not replace the database client. Only for import data.
It's administrator-oriented. Don't try it if you do NOT fully understand the function.
**/

defined( '_JEXEC' ) or die( 'Restricted access' );
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . DIRECTORY_SEPARATOR .'classes');
require_once( JApplicationHelper::getPath( 'html' ) );
require_once 'PHPExcel/IOFactory.php';   

switch($task)
{
	case 'save':
		saveKimport( $option );
		break;
	case 'view':
	default:
		showKimport( $option );
		break;
}
function showKimport( $option )
{
	$user =& JFactory::getUser();
	$firmId = $user->id;
	$db =& JFactory::getDBO();   
    $sql = 'SELECT distinct(sinavId) as id FROM  #__deneme WHERE firmaId = '.$firmId.' ORDER BY sinavId';
   	
    $results[] = JHTML::_('select.option',  '0',  JText::_( 'New' ) );
    $db->setQuery($sql);
    $data = $db->loadObjectList();
    
    $i = 1;
    foreach ($data as $row){
    	$results[] = JHTML::_('select.option',  "'".$i."'", JText::_( 'File' ).$i  );
    	$i++;
    }
   	//$results=array_merge( $results, $db->loadObjectList() );
    $default = "New";
   	$lists['id'] = JHTML::_('select.genericlist', $results, 'files', 'class="inputbox" size="1"', 'value','text', $default);

	HTML_kimport::showKimport($option,$lists );
}

function saveKimport( $option ){	
	if (isset($_FILES['uploadfile']) && is_array($_FILES['uploadfile'])) {
		$file = $_FILES['uploadfile'];
		upload ($option, $file, '');
	}
	
}

function upload($option, $file, $dest_dir) {
	global $mainframe;

	$format = substr( $file['name'], -3 );
	 
	$allowable = array (
	'xls'
	); //only support excel file (2003)

	$noMatch = 0;
	foreach( $allowable as $ext ) {
		if ( strcasecmp( $format, $ext ) == 0 ) {
			$noMatch = 1;
		}
	}
	if(!$noMatch){
		$mainframe->redirect('index.php?option='.$option, $format.' file type is not supported');
	}else{
		///////////////////////////////////////////
		$tableName = "#__deneme";
		$user =& JFactory::getUser();
		$firmId = $user->id;
		///////////////////////////////////////////
		
		if (JRequest::getInt('files') == 0){ // New File
			$examId = findExamId ($tableName, $firmId);
		}
		else{
			$examId = JRequest::getInt('files');
			deleteRecords ($tableName, $firmId, $examId);
		}
		
		$filename = "sinav_".$firmId."_".$examId; 

		$uf = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'tempdata' . DIRECTORY_SEPARATOR .$filename.'.'.$format; //uploaded file name
		$upTemp = move_uploaded_file($file['tmp_name'],$uf);
		chmod($uf, 0755);
		if ($upTemp){
			do_import($uf, $option,$firmId,$examId); //after upload file, proceed data import.
		}else{
			$mainframe->redirect('index.php?option='.$option, 'Fail to import data');
		}		
		
	}
}

//Exam id to save new exam of the firm to database 
function findExamId ($tableName, $firmId){
	$db =&JFactory::getDBO();
 	$sql = "SELECT MAX(sinavId) AS sid FROM `".$tableName."` WHERE `firmaId` = ".$firmId;
 	$db->setQuery( $sql );

 	$data = (int)$db->loadResult();
 
	return ($data+1);
}

function do_import($filename, $option, $firmId, $examId) {
	global $mainframe;
	$reader = PHPExcel_IOFactory::createReader('Excel5');
	$excelFile = $reader->load($filename);
	$sheet = $excelFile->getSheet(0);
	
	$sheet_name = $sheet->getTitle();
	$highestRow = $sheet->getHighestRow();
	$highestCol = PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn());
	
	//fetch header(field)
	$fields_key = '';
	for ($column = 0; $column < $highestCol-1; $column++) {  
		$val = $sheet->getCellByColumnAndRow($column, 1)->getValue();  
		$fields_key .= ',`'.$val.'`';
	}  
	$fields_key = substr($fields_key, 1);
	$fields_key = "`firmaId`,`sinavId`,".$fields_key;
	//echo "<br />";  	
	
	$succ_count = 0;
	$fail_to_import = '';
	
	for ($row = 2; $row <= $highestRow; $row++) {  	 
		$values = '';
		for ($column = 0; $column < $highestCol-1; $column++) { 
			$title =  $sheet->getCellByColumnAndRow($column, 1)->getValue();
			$cell = $sheet->getCellByColumnAndRow($column, $row);
			$val = ($cell->getValue() instanceof PHPExcel_RichText) ? $cell->getValue()->getPlainText() : $cell->getValue();
			
			if ($title == "Tarih" && date ("Y-m-d H:i:s", $val))
				$val = date ("Y-m-d H:i:s", $val);

			//echo 'val='.$val.'<br/>';
			if(!isset($val) && $val == '')
				$val = 'NULL';
			$val = str_replace("\'", " ", $val); 
			$val = str_replace("\n", "<br/>", $val);
			
			$values .= ',\''.$val.'\'';
		} 
		$values = substr($values, 1);
		$values = $firmId.",".$examId.",".$values; 
		
		$sql = "insert into $sheet_name ($fields_key) values ($values)";  	 
		//echo $sql . ';<br/>';

		$sql_err = executeSQL($sql);
		if($sql_err == "success"){
			$succ_count++;
		}else{
			$fail_to_import .= '[row='.$row.':'.$sql_err.']<br/>';
		}
	} 	
	$mainframe->redirect('index.php?option='.$option, JText::_('Imported ').$succ_count.' '.JText::_('rows').(empty($fail_to_import)?'':' reason: '.$fail_to_import));
}

function deleteRecords ($tableName, $firmId, $examId){
	$db =&JFactory::getDBO();
 	$sql = "SELECT id FROM `".$tableName."` WHERE `firmaId` =".$firmId." AND `sinavId` = ".$examId;
 	$db->setQuery( $sql );
 	
 	$data = $db->loadObjectList();
 	
 	foreach ($data as $row){
 		//Delete records one by one 
		$sql = "DELETE FROM `".$tableName."` WHERE `firmaId` =".$firmId." AND `sinavId` = ".$examId ." AND id = ".$row->id;
		$sql_err = executeSQL($sql);
		
 		if($sql_err == "success"){
			$succ_count++;
		}else{
			$fail_count++;
			$fail_to_delete .= '[row='.$row.':'.$sql_err.']<br/>';
		}
 	}
 	
 	if ($fail_count == 0)
 		return "success";
	else
		echo $fail_to_delete."<br/>";
}

/**
Execute data SQL
**/
function executeSQL($query, $name){
	$db =&JFactory::getDBO(); 
	$db->setQuery( $query );
	
	if (!$db->Query()) {
		//echo "<script> alert(\"".$db->getErrorMsg()."\"');window.history.go(-1); </script>\n";
		return $db->getErrorMsg();
	}	
	return "success";
}

?>
