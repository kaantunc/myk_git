<?php
defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/functions.php');

class ItembankModelSorugirisi extends JModel {
	var $title 		= "MYK Portal Itembank"; 
	
	function getSoruDetay(){
		$db = JFactory::getOracleDBO();
		$user=JFactory::getUser();
		$sektorSorumlusu= FormFactory::checkAuthorization  ($user, YET_SEKTOR_SORUMLUSU_GROUP_ID);
		if (!$sektorSorumlusu){
			$itembank_user_id=$user->id;
			$sql = "SELECT *
			FROM m_itembank_sorular
			FULL JOIN m_itembank_soru_BO using(soru_id)
			FULL JOIN m_itembank_soru_beceri_yetk USING (soru_id)
			WHERE itembank_user_id=".$itembank_user_id."
			AND soru_id=".$_GET["soru_id"]."
			AND (durum_id=1 or durum_id=7)"; // 1->Yeni kaydedilmiş soru (sstem sorumlusunun incelenmesinde), 7->Düzeltme yapılıyor
		} else {
			$sql = "SELECT *
			FROM m_itembank_sorular
			FULL Join m_itembank_soru_BO using(soru_id)
			FULL JOIN m_itembank_soru_beceri_yetk USING (soru_id)
			WHERE soru_id=".$_GET["soru_id"]."
			AND (durum_id=1 or durum_id=7)"; // 1->Yeni kaydedilmiş soru (sstem sorumlusunun incelenmesinde), 7->Düzeltme yapılıyor
					
		}
			
	
		$soru = $db->prep_exec($sql, array());
		if ($soru){
			
			$sql="select sektor_id,seviye_id, yeni_mi from m_yeterlilik where yeterlilik_id=".$soru[0]["YETERLILIK_ID"];
			$seviyeSektor = $db->prep_exec($sql, array());
		
			$sql = "SELECT *
			FROM m_itembank_cevaplar
			WHERE soru_id=".$_GET["soru_id"]." ORDER BY cevap_index"; 
			$cevap = $db->prep_exec($sql, array());		
			
			if($seviyeSektor[0]["YENI_MI"]=='1')
			{
				$sql = "SELECT BASARIM_OLCUTU_ID
				FROM m_itembank_soru_bo
				WHERE soru_id=".$_GET["soru_id"];
				$basarim_olcutu = $db->prep_exec_array($sql, array());
			}	
			else
			{
				$sql = "SELECT BECERI_YETKINLIK_ID
				FROM m_itembank_soru_beceri_yetk
				WHERE soru_id=".$_GET["soru_id"];
				$beceri_yetkinlik = $db->prep_exec_array($sql, array());
			}
			
			return array ("soru"=>$soru[0],"cevap"=>$cevap,"sektor"=>$seviyeSektor[0]["SEKTOR_ID"],"seviye"=>$seviyeSektor[0]["SEVIYE_ID"], "yeterlilik_yeni_mi"=>$seviyeSektor[0]["YENI_MI"], "beceri_yetkinlik"=>$beceri_yetkinlik, "basarim_olcutu" => $basarim_olcutu);		
		}
		return false;
	}
	
	
    function getSektorler(){
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT sektor_id,sektor_adi
				FROM pm_sektorler
                WHERE sektor_durum=1
                ORDER BY sektor_adi";
		
		return $db->prep_exec($sql, array());
    }
    
	function getSoruTipi(){
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT soru_tipi_id,soru_tipi_adi
				FROM pm_itembank_soru_tipi
                ORDER BY soru_tipi_id";
		
		return $db->prep_exec($sql, array());
    }
    
     function getZorlukDerecesi(){
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT zorluk_derecesi_id,zorluk_derecesi_adi
				FROM pm_itembank_zorluk_derecesi
                ORDER BY zorluk_derecesi_id";
		
		return $db->prep_exec($sql, array());
    }
    
     function getTeorikSoruSekli(){
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT soru_sekli_id,soru_sekli_adi
				FROM pm_itembank_teorik_soru_sekli
                ORDER BY soru_sekli_id";
		
		return $db->prep_exec($sql, array());
    }
    
    
     function getPerformansSoruSekli(){
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT soru_sekli_id,soru_sekli_adi
				FROM pm_itembank_pratik_soru_sekli
                ORDER BY soru_sekli_id";
		
		return $db->prep_exec($sql, array());
    }
    
    function getSeviye(){
    	$db = JFactory::getOracleDBO();
    
    	$sql = "SELECT DISTINCT seviye_id 
    			FROM m_yeterlilik 
    			WHERE sektor_id=? 
    			AND yeterlilik_durum_id=?
    			ORDER BY seviye_id";
    
    	$result= $db->prep_exec($sql, array($_POST["sektor_id"],PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK));
    	if(count($result) > 0)
    		ajax_success_response_with_array('Sorgu başarılı', $result);
    	else
    		ajax_error_response();
    	 
    }
    
    function getYeterlililer(){
    	$db = JFactory::getOracleDBO();
    
    	$sql = "SELECT yeterlilik_id,yeterlilik_adi,yeni_mi
    	FROM m_yeterlilik
    	WHERE seviye_id=?
    	AND sektor_id=?
    	AND yeterlilik_durum_id=?";
    
    	$result= $db->prep_exec($sql, array($_POST["seviye_id"],$_POST["sektor_id"],PM_YETERLILIK_DURUMU__ULUSAL_YETERLILIK));
    	if(count($result) > 0)
    		ajax_success_response_with_array('Sorgu başarılı', $result);
    	else
    		ajax_error_response();
    
    }
    
    
    function getBirimler(){
    	$db = JFactory::getOracleDBO();
    	 
    		$sql="SELECT birim_id, birim_adi
    		FROM m_birim
    		JOIN m_yeterlilik_birim USING (birim_id)
    		WHERE yeterlilik_id=?";
    	 
    
    
    
    	 
    	$result= $db->prep_exec($sql, array($_POST["yeterlilik_id"]));
    	if(count($result) > 0)
    		ajax_success_response_with_array('Sorgu basarili', $result);
    	else
    		ajax_error_response();
    
    }
    
    function getBilgiBeceriYetkinlik($tip){
    	$db = JFactory::getOracleDBO();
    	     	
   		$sql="SELECT beceri_yetkinlik_id, beceri_yetkinlik_adi 
    			FROM m_yeter_beceri_yetkinlik
    			WHERE yeterlilik_id=? and beceri_yetkinlik_tipi=?";
    	
    
    
    
     
    	$result= $db->prep_exec($sql, array($_POST["yeterlilik_id"],$tip));
   	if(count($result) > 0)
    		ajax_success_response_with_array('Sorgu basarili', $result);
    	else
    		ajax_error_response();
    
    }
    function getOgrenmeCiktisi (){
    	$db = JFactory::getOracleDBO();
    
    	$sql = "SELECT ogrenme_ciktisi_id,ogrenme_ciktisi_yazisi
    	FROM m_ogrenme_ciktisi
    	JOIN m_birim__ogrenme_ciktisi USING (ogrenme_ciktisi_id)
    	WHERE birim_id=?";
    
    	$result= $db->prep_exec($sql, array($_POST["birim_id"]));
    	if(count($result) > 0)
    		ajax_success_response_with_array('Sorgu başarılı', $result);
    	else
    		ajax_error_response();
    
    }
    function getBasarimOlcutu (){
    	$db = JFactory::getOracleDBO();
    
    	$sql = "SELECT basarim_olcutu_id,basarim_olcutu_adi
    	FROM m_basarim_olcutu
    	JOIN m_ogrenme_ciktisi__basarim_olc USING (basarim_olcutu_id)
    	WHERE ogrenme_ciktisi_id in (".implode(",",$_POST["birim_id"]).")";
    
    	$result= $db->prep_exec($sql);
    	if(count($result) > 0)
    		ajax_success_response_with_array('Sorgu başarılı', $result);
    	else
    		ajax_error_response();
    
    }
    function soruKaydet(){
    	$db = JFactory::getOracleDBO();
    	$user=JFactory::getUser();
    	$itembank_user_id=$user->id;
    	
    	$sql="select kurulus_id from m_itembank_kurulus_users where user_id=".$itembank_user_id;
    	$result= $db->prep_exec_array($sql);
    	$kurulus_user_id=$result[0];
    	
    	$yeterlilik_id=explode("-",$_POST["yeterlilik_id"]);
		
    	$soru_id= $db->getNextVal('SORU_ID_SEQ');
    	
    	
    	$path="itembank/";
 		$soruGorseli	= $this->dosyaUpload($_FILES["soru_gorsel"], $path);
		$soruDosyasi	= $this->dosyaUpload($_FILES["soru_dosya"], $path);
		$cevapFiles		= $this->dosyaUpload($_FILES["cevap_file"], $path);
		$soruDosyasiP	= $this->dosyaUpload($_FILES["soru_dosya_p"], $path);
		$cevapDosyasiP	= $this->dosyaUpload($_FILES["cevap_dosya_p"], $path);
		
    	if ($_POST["soru_grubu_id"]==1){
			$soru_metni=$_POST["soru_metni"];
			if ($_POST["esit_puanli"]==1){
				$soru_puani=0;
			} else {
				$soru_puani=$_POST["soru_puani"];
			}
			$soru_dosyasi=$soruDosyasi;
			$soru_sekli_id=$_POST["soru_tipi_id"];
		}
		
		if ($_POST["soru_grubu_id"]==2){
			$soru_metni=$_POST["soru_metni_p"];
			if ($_POST["esit_puanli_p"]==1){
				$soru_puani=0;
			} else {
				$soru_puani=$_POST["soru_puani_p"];
			}
			$soru_dosyasi=$soruDosyasiP;
			$soru_sekli_id=$_POST["soru_tipi_id_p"];
		}
		
		//BU KISIM M_ITEMBANK_SORU_BECERI_YETK ICIN
		$bilgiBeceriYetkinlikIDleri = $_POST['bilgiBeceriYetkinlik_id'];
		for($i=0; $i<count($bilgiBeceriYetkinlikIDleri); $i++)
		{
			$sql = 'INSERT INTO M_ITEMBANK_SORU_BECERI_YETK (SORU_ID, BECERI_YETKINLIK_ID) VALUES (?,?)';
			$params = array($soru_id, $bilgiBeceriYetkinlikIDleri[$i]);
			$result= $db->prep_exec_insert($sql, $params);
		}
		//-----------------------------------------
		
		//BU KISIM M_ITEMBANK_SORU_BO ICIN
		$basarimOlcutuIDleri = $_POST['basarim_olcutu_id'];
		for($i=0; $i<count($basarimOlcutuIDleri); $i++)
		{
			$sql = 'INSERT INTO M_ITEMBANK_SORU_BO (SORU_ID, BASARIM_OLCUTU_ID) VALUES (?,?)';
			$params = array($soru_id, $basarimOlcutuIDleri[$i]);
			$result= $db->prep_exec_insert($sql, $params);
		}
		//-----------------------------------------
		
		
		$sql="insert into M_ITEMBANK_SORULAR (
			SORU_ID,
			YETERLILIK_ID,
			OLUSTURAN,
			ONAYLAYAN,
			OLUSTURMA_TARIHI,
			SORU_TIPI_ID,
			TURKAK_ONAYLI_MI,
			ZORLUK_DERECESI_ID,
			SORU_SEKLI_ID,
			PUANI,
			SORU_METNI,
			SORU_DOKUMANI_PATH,
			KURULUS_USER_ID,
			ITEMBANK_USER_ID,
			KAYIT_TARIHI,
			SORU_GORSELI_PATH,
			DIGER_ACIKLAMA,
			KURULUS_SORU_KODU			
			) VALUES (
			?,?,?,?,?,   ?,?,?,?,?,  ?,?,?,?,?,  ?,?,?
			)";
		$array=array(
				$soru_id,
				$yeterlilik_id[0],
				$_POST["olusturan"],
				$_POST["onaylayan"],
				$_POST["olusturma_tarihi"],
				$_POST["soru_grubu_id"],
				$_POST["turkak_onayli_mi"],
				$_POST["zorluk_derecesi_id"],
				$soru_sekli_id,
				$soru_puani,
				$soru_metni,
				$soru_dosyasi,
				$kurulus_user_id,
				$itembank_user_id,
				time(),
				$soruGorseli,
				$_POST["diger_aciklama"],
				$_POST["kurulus_soru_kodu"]
		);
		
		$result= $db->prep_exec_insert($sql, $array);
		for ($i=0;$i<count($_POST["birim_id"]);$i++){
			$sql="insert into M_ITEMBANK_SORU_BO (		
					SORU_ID,
					BASARIM_OLCUTU_ID) VALUES (?,?)";
			$array=array(
				$soru_id,
				$_POST["basarim_olcutu_id"][$i]
				);
			$result= $db->prep_exec_insert($sql, $array);
		}
		
		
		
        if ($_POST["soru_grubu_id"]==1){
			foreach ($_POST["cevap_metni"] as $num=>$val){
				$cevap_id= $db->getNextVal('CEVAP_ID_SEQ');
				$sql="insert into M_ITEMBANK_CEVAPLAR (
				CEVAP_ID,
				SORU_ID,
				CEVAP_METNI,
				CEVAP_DOSYA_PATH,
				DOGRU_MU,
				CEVAP_INDEX
				) values (?,?,?,?,?,?)";
				$array=array(
						$cevap_id,
						$soru_id,
						$_POST["cevap_metni"][$num],
						$cevapFiles[$num],
						$_POST["dogrucevap"][$num],
						$num
				);
				$result= $db->prep_exec_insert($sql, $array);
				
			}
    	}
		
    	if ($_POST["soru_grubu_id"]==2 and ($_POST["cevap_metni_p"]!="" or $cevapDosyasiP)){
    			$cevap_id= $db->getNextVal('CEVAP_ID_SEQ');
    			$sql="insert into M_ITEMBANK_CEVAPLAR (
    			CEVAP_ID,
    			SORU_ID,
    			CEVAP_METNI,
    			CEVAP_DOSYA_PATH,
    			DOGRU_MU,
				CEVAP_INDEX
    			) values (?,?,?,?,?,?)";
    			$array=array(
    					$cevap_id,
    					$soru_id,
    					$_POST["cevap_metni_p"],
    					$cevapDosyasiP,
    					$_POST["dogrucevap"],
						1
    			);
    			$result= $db->prep_exec_insert($sql, $array);
    	
    	}
    	
    	 
		// echo "<pre>";
		// print_r($_POST);
		// echo "\n\r=========\n\rDOSYALAR\n\r";
		// print_r($_FILES);
		// echo"</pre>";
		echo $soru_id;
    }
    
    function dosyaUpload($dosya,$path){
    	if (!file_exists(EK_FOLDER.$path)){
    		mkdir(EK_FOLDER.$path, 0700,true);;
    	}
    	if($dosya["name"]){
	    	if (is_array($dosya["name"])){
		    	foreach ($dosya["name"] as $dsy=>$deg){
		    		if ($dosya[name][$dsy]){
				    	$normalFile = time()."-".FormFactory::formatFilename ($dosya[name][$dsy]);
				    	$yeniDosyaAdi[$dsy]=	$path . $normalFile;
				    	move_uploaded_file($dosya[tmp_name][$dsy],EK_FOLDER.$yeniDosyaAdi[$dsy]);
			    	}
		    	}
	    	} else {
	    		$normalFile = time()."-".FormFactory::formatFilename ($dosya[name]);
	    		$yeniDosyaAdi=	$path . $normalFile;
	    		move_uploaded_file($dosya[tmp_name],EK_FOLDER.$yeniDosyaAdi);    		
	    	}
    	}
    	return $yeniDosyaAdi;
    	 
    }
    
    function soruGuncelle(){
    	$db = JFactory::getOracleDBO();
    	$user=JFactory::getUser();
    	$sektorSorumlusu= FormFactory::checkAuthorization  ($user, YET_SEKTOR_SORUMLUSU_GROUP_ID);
    	$son_guncelleyen_id=$user->id;
    	
    	if (!$sektorSorumlusu){
	    	$sql="select kurulus_id from m_itembank_kurulus_users where user_id=".$son_guncelleyen_id;
	    	$result= $db->prep_exec_array($sql);
	    	$sqlPart = " and KURULUS_USER_ID=".$result[0];
    	}
    	
    	 
    	
    	$yeterlilik_id=explode("-",$_POST["yeterlilik_id"]);
    
    	$soru_id=$_POST["soru_id"];    	

    	$sql="select * from m_itembank_sorular where soru_id=".$soru_id;
    	$result= $db->prep_exec($sql);
    	$dbsoruGorseli=$result[0]["SORU_GORSELI_PATH"];
    	$dbsoruDosyasi=$result[0]["SORU_DOKUMANI_PATH"];
    	$dbsoruDosyasiP=$result[0]["SORU_DOKUMANI_PATH"];

    	$sql="select * from m_itembank_cevaplar where soru_id=".$soru_id;
    	$result= $db->prep_exec($sql);
    	foreach($result as $arr){
    		$i=$arr["CEVAP_INDEX"];
    		if ($i==1){
    			$dbcevapDosyasiP=$arr["CEVAP_DOSYA_PATH"];
    		}
    		$dbCevapFile[$i]=$arr["CEVAP_DOSYA_PATH"];
    	}
    	 
    	$path="itembank/";
    	$soruGorseli	= $this->dosyaUpload($_FILES["soru_gorsel"], $path);
    	$soruDosyasi	= $this->dosyaUpload($_FILES["soru_dosya"], $path);
    	$cevapFiles		= $this->dosyaUpload($_FILES["cevap_file"], $path);
    	$soruDosyasiP	= $this->dosyaUpload($_FILES["soru_dosya_p"], $path);
    	$cevapDosyasiP	= $this->dosyaUpload($_FILES["cevap_dosya_p"], $path);
    	
    	
    	if ($soruGorseli=="" and $_POST["soru_gorseli_degisti"]==0){
    		$soruGorseli=$dbsoruGorseli;
    	}
    	if ($soruDosyasi=="" and $_POST["soru_grubu_id"]==1 and $_POST["soru_dosyasi_degisti"]==0){    	
    		$soruDosyasi=$dbsoruDosyasi;
    	}    		
    	foreach($_POST["cevap_dosyasi_p_degisti"] as $key=>$val){
    		if ($val==0 and $cevapFiles[$key]==""){$cevapFiles[$key]=$dbCevapFile[$key];}
    	}    	
    	if ($soruDosyasiP=="" and $_POST["soru_grubu_id"]==2 and $_POST["soru_dosyasi_p_degisti"]==0){    	
    		$soruDosyasiP=$dbsoruDosyasiP;
    	}
    	if ($cevapDosyasiP=="" and $_POST["cevap_dosyasi_p_degisti"]==0){    	
    		$cevapDosyasiP=$dbcevapDosyasiP;
    	}
    	
    	
        if ($_POST["soru_gorseli_silindi"]==1){
    		$soruGorseli	= "";
    	}
    	if ($_POST["soru_grubu_id"]==1 and $_POST["soru_dosyasi_silindi"]==1){    	
    		$soruDosyasi	= "";
    	}    	
    	foreach($_POST["cevap_dosyasi_p_silindi"] as $key=>$val){
    		if ($val==1){
    			$cevapFiles[$key]="";
    		}
    	}
    	if ($_POST["soru_grubu_id"]==2 and $_POST["soru_dosyasi_p_silindi"]==1){
    		$soruDosyasiP	= "";
    	}
    	if ($_POST["cevap_dosyasi_p_silindi"]==1){
    		$cevapDosyasiP	= "";
    	}
    	 
    	 
    	 
    	if ($_POST["soru_grubu_id"]==1){
    		$soru_metni=$_POST["soru_metni"];
    		if ($_POST["esit_puanli"]==1){
    			$soru_puani=0;
    		} else {
    			$soru_puani=$_POST["soru_puani"];
    		}
    		$soru_dosyasi=$soruDosyasi;
    		$soru_sekli_id=$_POST["soru_tipi_id"];
    	}
    
    	if ($_POST["soru_grubu_id"]==2){
    		$soru_metni=$_POST["soru_metni_p"];
    		if ($_POST["esit_puanli_p"]==1){
    			$soru_puani=0;
    		} else {
    			$soru_puani=$_POST["soru_puani_p"];
    		}
    		$soru_dosyasi=$soruDosyasiP;
    		$soru_sekli_id=$_POST["soru_tipi_id_p"];
    	}
    
    
    	$sql="update M_ITEMBANK_SORULAR set
    	YETERLILIK_ID=?,
    	OLUSTURAN=?,
    	ONAYLAYAN=?,
    	OLUSTURMA_TARIHI=?,
    	SORU_TIPI_ID=?,
    	TURKAK_ONAYLI_MI=?,
    	ZORLUK_DERECESI_ID=?,
    	SORU_SEKLI_ID=?,
    	PUANI=?,
    	SORU_METNI=?,
    	SORU_DOKUMANI_PATH=?,
    	SON_GUNCELLEYEN_ID=?,
    	SON_GUNCELLEME_TARIHI=?,
    	SORU_GORSELI_PATH=?,
    	DIGER_ACIKLAMA=?,
    	KURULUS_SORU_KODU=?
		where SORU_ID=?".$sqlPart;
    	$array=array(
    			$yeterlilik_id[0],
    			$_POST["olusturan"],
    			$_POST["onaylayan"],
    			$_POST["olusturma_tarihi"],
    			$_POST["soru_grubu_id"],
    			$_POST["turkak_onayli_mi"],
    			$_POST["zorluk_derecesi_id"],
    			$soru_sekli_id,
    			$soru_puani,
    			$soru_metni,
    			$soru_dosyasi,
    			$son_guncelleyen_id,
    			time(),
    			$soruGorseli,
    			$_POST["diger_aciklama"],
    			$_POST["kurulus_soru_kodu"],
    			$soru_id    			 
    	);
    
    	$result= $db->prep_exec_insert($sql, $array);

    	// BU KISIM M_ITEMBAK_SORU_BO ICIN -----------------
    	$sql="delete from M_ITEMBANK_SORU_BO
    	    	where SORU_ID=?";
    	$array=array($soru_id);
    	$result= $db->prep_exec_insert($sql, $array);
    	
		for ($i=0;$i<count($_POST["basarim_olcutu_id"]);$i++){//burda $_POST['birim_id'] diyodu ama???
			$sql="insert into M_ITEMBANK_SORU_BO (		
					BASARIM_OLCUTU_ID,
					soru_id
			) values (
			?,?)";
			$array=array(				
				$_POST["basarim_olcutu_id"][$i],
				$soru_id
				);
			$result= $db->prep_exec_insert($sql, $array);
		}
		//----------------------------------------------------

		// BU KISIM M_ITEMBAK_SORU_BECERI_YETK ICIN -----------------
		$sql="delete from M_ITEMBANK_SORU_BECERI_YETK
		where SORU_ID=?";
		$array=array($soru_id);
		$result= $db->prep_exec_insert($sql, $array);
		 
		for ($i=0;$i<count($_POST["bilgiBeceriYetkinlik_id"]);$i++){
			$sql="insert into M_ITEMBANK_SORU_BECERI_YETK (
			BECERI_YETKINLIK_ID,
			soru_id
			) values (
			?,?)";
			$array=array(
					$_POST["bilgiBeceriYetkinlik_id"][$i],
					$soru_id
			);
			$result= $db->prep_exec_insert($sql, $array);
		}
		//----------------------------------------------------
		
		

    	$sql="delete from M_ITEMBANK_CEVAPLAR 
    	where SORU_ID=?";
    	$array=array($soru_id);
    	$result= $db->prep_exec_insert($sql, $array);
    	 
    	if ($_POST["soru_grubu_id"]==1){
    		foreach ($_POST["cevap_metni"] as $num=>$val){
    			$cevap_id= $db->getNextVal('CEVAP_ID_SEQ');
    			$sql="insert into M_ITEMBANK_CEVAPLAR (
    			CEVAP_ID,
    			SORU_ID,
    			CEVAP_METNI,
    			CEVAP_DOSYA_PATH,
    			DOGRU_MU,
    			CEVAP_INDEX
    			) values (?,?,?,?,?,?)";
    			$array=array(
    					$cevap_id,
    					$soru_id,
    					$_POST["cevap_metni"][$num],
    					$cevapFiles[$num],
    					$_POST["dogrucevap"][$num],
    					$num
    			);
    			$result= $db->prep_exec_insert($sql, $array);
    
    		}
    	}
    
    	if ($_POST["soru_grubu_id"]==2 and ($_POST["cevap_metni_p"]!="" or $cevapDosyasiP)){
    		$cevap_id= $db->getNextVal('CEVAP_ID_SEQ');
    		$sql="insert into M_ITEMBANK_CEVAPLAR (
    		CEVAP_ID,
    		SORU_ID,
    		CEVAP_METNI,
    		CEVAP_DOSYA_PATH,
    		DOGRU_MU,
    		CEVAP_INDEX
    		) values (?,?,?,?,?,?)";
    		$array=array(
    				$cevap_id,
    				$soru_id,
    				$_POST["cevap_metni_p"],
    				$cevapDosyasiP,
    				$_POST["dogrucevap"],
    				1
    		);
    		$result= $db->prep_exec_insert($sql, $array);
    		 
    	}
    	 
    
    	// echo "<pre>";
    	// print_r($_POST);
    	// echo "\n\r=========\n\rDOSYALAR\n\r";
    	// print_r($_FILES);
    	// echo"</pre>";
    	echo 0;
    }
    
    
    
}


?>