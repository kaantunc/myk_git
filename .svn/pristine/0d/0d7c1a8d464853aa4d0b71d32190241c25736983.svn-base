<?php
require_once('libraries/form/form_config.php');
require_once('libraries/form/form.php');

// Edit upload location here
$id = $_POST["id"];
$destination_path = getDestinationPath ();
clearstatcache (); //is_dir fonksiyonundan donen sonuclari cache'den sil

if ($destination_path == -1){
	$errorMessage = "Dizin Oluşturulamadı!";
	?>
<script language="javascript" type="text/javascript">window.top.window.stopUpload("<?php echo $_GET['id']?>", 0, "<?php echo $_GET['sira']?>","<?php echo "dosya alınamadı: $errorMessage";?>");</script>

<?php
die();
}

$sizeLimit= -1; // 5000 * 1024 - enter KB value or -1 for no setting
 
// if an extension is both allowed and denied it will be denied
$x = "organizasyonSemasi";
if(strpos($id, $x) === false){
	$allowedExts = array("txt","csv","htm","html","xml",
			   			"css","doc","docx","xls","rtf","ppt","pdf",
			    		"jpg","jpeg","gif","png"); // empty allows all
}else{
	$allowedExts = array("jpg","jpeg","gif","png","doc","docx","xls","xlsx","pdf"); // empty allows all
}
$deniedExts = array();  // enter forbidden extensions
$uploadedFilesName = "";
$errorMessage = "";
 
$result = 0;
$i = 0;
$errorArray = Array();

// daha güzel bir çözüm bulunabilir belki
 
$POST_MAX_SIZE = ini_get('post_max_size');
$mul = substr($POST_MAX_SIZE, -1);
$mul = ($mul == 'M' ? 1048576 : ($mul == 'K' ? 1024 : ($mul == 'G' ? 1073741824 : 1)));

if ($_SERVER['CONTENT_LENGTH'] > $mul*(int)$POST_MAX_SIZE && $POST_MAX_SIZE){

	$errorMessage = "Hata kodu: 251. Dosya boyutu büyük.";

	?>
	<script language="javascript" type="text/javascript">window.top.window.stopUpload("<?php echo $_GET['id']?>", 0, "<?php echo $_GET['sira']?>","<?php echo "dosya alınamadı: $errorMessage";?>");</script>
	<?php
die();
}
 
$fileCount = $_POST['file_count'];

for($i=1;$i <= $fileCount;$i++){

	$input_file_name = $id."_file_" . $i;

	//Unique Upload Filenames
	$uploadedFilesName = FormFactory::generateUniqueFilename (basename( $_FILES[$input_file_name]['name']));

	$target_path = EK_FOLDER . $destination_path . $uploadedFilesName;

	if(!isset($_FILES[$input_file_name]))
	continue;
	 
	$upload_max_filesize = ini_get('upload_max_filesize');
	$mul = substr($upload_max_filesize, -1);
	$mul = ($mul == 'M' ? 1048576 : ($mul == 'K' ? 1024 : ($mul == 'G' ? 1073741824 : 1)));
	
	if (($_FILES[$input_file_name]["size"] ==0)||($_FILES[$input_file_name]["size"] > $mul*(int)$upload_max_filesize &&
	$upload_max_filesize)){
		$errorMessage = "Hata kodu: 252. Dosya boyutu büyük.";
		break;
	}

	if($sizeLimit != -1){
		if(($_FILES[$input_file_name]["size"] / 1024) > $sizeLimit){
			$errorMessage = "Hata kodu: 253. Dosya boyutu büyük. İzin verilen, $sizeLimit KB.";
			break;
		}
	}

	if(!empty($allowedExts)){
		if (!in_array(end(explode(".",
		strtolower($uploadedFilesName))),
		$allowedExts)) {
			$errorMessage = "Hata kodu: 261. Dosya uzantısı hatalı.";
			break;
		}
	}

	if(!empty($deniedExts)){
		if (in_array(end(explode(".",
		strtolower($uploadedFilesName))),
		$deniedExts)) {
			$errorMessage = "Hata kodu: 262. Dosya uzantısı hatalı.";
			break;
		}
	}

	if ($_FILES[$input_file_name]["error"] > 0){
		$errorMessage = "Hata kodu: 259. Beklenmedik bir hata oluştu.";
		break;
	}

	if(@move_uploaded_file($_FILES[$input_file_name]['tmp_name'], $target_path)) {
		//echo "$target_path";
		$result = 1;
		?>
		<script language="javascript" type="text/javascript">window.top.window.stopUpload("<?php echo $id;?>", 1,<?php echo $i; ?>,"<?php echo $uploadedFilesName;?>","<?php echo FormFactory::normalizeVariable($destination_path);?>");</script>
		
		<?php
		break;
	}
	else{
		$errorArray[] = $input_file_name;
	}

}

// hatalı dosya adları veya sıraları da döndürülebilir
if(!$result){
	?>
	<script language="javascript" type="text/javascript">window.top.window.stopUpload("<?php echo $id;?>", 0,<?php echo $i; ?>,"<?php echo "$uploadedFilesName alınamadı: $errorMessage";?>");</script>
	<?php
}
?>

<?php

/* EK_FOLDER directory'sine Yıl, Ay, Gun seklinde directory'ler olusturur.
 * Olusan directory'nin path'ini dondurur.
 * Ornek ekler/2009/02/01 -> 1 Subat 2009 gunu icin.
 * Eger directory zaten mevcutsa sadece path dondurur.
*/
function getDestinationPath (){
	$db = &JFactory::getOracleDBO();
	$seperator = "/";

	$date = getdate ();
	$day 	= $date["mday"];
	$month 	= $date["mon"];
	$year	= $date["year"];
	 
	$pathName = $year;//$path.$year;
	$fullPath = EK_FOLDER.$pathName;
	if (!is_dir($fullPath)){
		// ekler/yil
		$result = mkdir ( $fullPath );
			
		if (!$result){
			// YIL dizini oluşturulamadı
			return -1;
		}else{
			//DYS uyumu icin pyton dosyasi
			$fileName = $fullPath.$seperator."__init__.py";
			touch($fileName);
		}
	}

	$pathName = $path.$year.$seperator.$month;
	$fullPath = EK_FOLDER.$pathName;
	if (!is_dir($fullPath)){
		// ekler/yil/ay
		$result = mkdir ( $fullPath );
			
		if (!$result){
			// YIL/AY dizini oluşturulamadı
			return -1;
		}else{
			//DYS uyumu icin pyton dosyasi
			$fileName = $fullPath.$seperator."__init__.py";
			touch($fileName);
		}
	}

	$pathName = $path.$year.$seperator.$month.$seperator.$day;
	$fullPath = EK_FOLDER.$pathName;
	if (!is_dir($fullPath)){
		// ekler/yil/ay/gun
		$result = mkdir ( $fullPath );
			
		if (!$result){
			// YIL/AY/GUN dizini oluşturulamadı
			return -1;
		}else{
			//DYS uyumu icin pyton dosyasi
			$fileName = $fullPath.$seperator."__init__.py";
			touch($fileName);
		}
	}

	return $pathName.$seperator;
}
?>