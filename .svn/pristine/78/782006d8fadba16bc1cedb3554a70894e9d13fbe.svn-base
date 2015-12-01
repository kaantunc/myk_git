<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . DIRECTORY_SEPARATOR .'classes');
require_once( JApplicationHelper::getPath( 'html' ) );
require_once 'PHPExcel/IOFactory.php';

switch($task)
{
	case 'download':
//		$user =& JFactory::getUser();
//		$firmId = $user->id;
//		$examId = JRequest::getInt('files');
//		$tableName = '#__deneme';
//		returnExcelFileById ($tableName,$firmId,$examId,$option);
		databaseToExcel ('#__deneme',0, 2,'components/com_kimport/tempdata/');
		break;
	default:
		showFiles( $option );
		break;
}

function showFiles( $option )
{
	$user =& JFactory::getUser();
	$firmId = $user->id;
	$db =& JFactory::getDBO();   
    $sql = 'SELECT distinct(sinavId) as id FROM  #__deneme WHERE firmaId = '.$firmId.' ORDER BY sinavId';
   	
    $results[] = JHTML::_('select.option',  '0', '-'.JText::_( 'Select File' ).'-' );
    $db->setQuery($sql);
    $data = $db->loadObjectList();
    
    $i = 1;
    foreach ($data as $row){
    	$results[] = JHTML::_('select.option',  "'".$i."'", JText::_( 'File' ).$i  );
    	$i++;
    }
    $default = "-Select File-";
   	$lists['id'] = JHTML::_('select.genericlist', $results, 'files', 'class="inputbox" size="1"', 'value','text', $default);

	HTML_kexport::showFiles ($option, $lists);
}

function returnExcelFileById ($tableName, $firmId, $examId, $option){
	global $mainframe;
	
	if ($examId != 0){
		$dir = pathinfo($_SERVER['SCRIPT_FILENAME']);
		$dirPath = $dir["dirname"]."/components/com_kimport/tempdata/";
	
		$trackDir=opendir($dirPath);
	 
		$lastFile="";
		while ($file = readdir($trackDir)) {
			if ($file != "." && $file != "..") {
				$parts = split ("_",$file);
				
				if (isset($parts[1]) && $parts[1] == $firmId){
					if (isset($parts[2]) && $parts[2] == $examId){
						$lastFile = $file;
						break;
					}
				}
			}	
		}
		
		closedir($trackDir); 
		
		if ($lastFile != ""){
			$redirect = JURI::base()."components/com_kimport/tempdata/".$lastFile;
			header( 'Location: '.$redirect ) ;
		}else{			
			// No files are found. Take data from database 
			//databaseToExcel ($tableName, $firmId, $examId, $dirPath);
			
		}
	}else{
		//No files are selected
		$mainframe->redirect('index.php?option='.$option, 'No files are selected!');
	}
}

function databaseToExcel ($tableName,$firmId, $examId, $dir){
	$filename = "sinav_".$firmId."_".$examId.".xls";
	$db =&JFactory::getDBO();
	$query = "SELECT * FROM ".$tableName." WHERE firmaId = ".$firmId." AND sinavId = ".$examId;
	$db->setQuery ($query);	
	$data = $db->loadRowList();
	
	$tableFields = getTableFields ($tableName ); 
	$columnNumber = getNumColumns ($tableName );
	
	$phpExcel = new PHPExcel (); 

	//Configure the sheet
	$sheet = $phpExcel->getActiveSheet();
	$sheet->setTitle("jos_deneme");
	
	//Header
	for ($i = 3; $i < $columnNumber; $i++ ){
		$value = $tableFields[$i];
		$sheet->setCellValueByColumnAndRow($i-3, 1, $value);
	}
	
	//Data
	$row = 2;
	foreach ($data as $rows){
		$column = 0;
		for ($i = 3; $i < $columnNumber; $i++){
			$sheet->setCellValueByColumnAndRow($column, $row, $rows[$i]);
			$column++;
		}
		$row++;
	}

	$writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
	$writer->save($dir.$filename);
	
	$redirect = JURI::base().$dir.$filename;
	header( 'Location: '.$redirect ) ;
}


function getTableFields ($tableName){
	$result = array();
	$db =&JFactory::getDBO();
	$query = "SHOW FIELDS FROM ".$tableName;
	$db->setQuery($query);
	
	$data = $db->loadObjectList();
	
	$i = 0;
	foreach ($data as $field) {
		$result[$i] = $field->Field;
		$i++;
	}
	
	return $result;
} 

function getNumColumns ($tableName ){
	$db =&JFactory::getDBO();
	$query = "DESCRIBE ".$tableName;
	$db->setQuery($query);
	
	$data = $db->loadRowList();
	$count = 0;
	
	foreach ($data as $row){
		$count++;
	}
	
	return $count;
}


////////////////////////////////////////////////////////////////////

//Search
function searchByTcId ($tcId){
	$db =&JFactory::getDBO();
	$query = "SELECT * FROM #__deneme WHERE `TC_Kimlik_No` = '".$tcId."'";
	$db->setQuery ($query);	
	
	$data = $db->loadObjectList();
	
	foreach ($data as $row) {
		echo "".$row->Ad."<br/>";
		echo "".$row->Soyad."<br/>";
		echo "".$row->EPosta."<br/>";
		echo "".$row->Tarih."<br/>";
		echo "".$row->Sinav_Sonucu."<br/>";
	}

}

?>