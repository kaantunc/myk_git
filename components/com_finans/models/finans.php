<?php
defined('_JEXEC') or die('Restricted access');

require_once('libraries/form/functions.php');

class FinansModelFinans extends JModel {

	function ajaxDekontEkle()
	{
		$user = & JFactory::getUser();
		$sektorSorumlusununIdsi = $user->getOracleUserId();
		
		$db = JFactory::getOracleDBO();
		$dekontTarihi = $_POST['dekontEklePopup_Tarih'];
		$dekontNo = $_POST['dekontEklePopup_DekontNo'];
		$dekontTutari = $_POST['dekontEklePopup_Tutar'];
		$dekontTipi = $_POST['dekontEklePopup_DekontTipi'];
		$dekontAciklama = $_POST['dekontEklePopup_Aciklama'];
		
		$dekontunEklendigiID = $_POST['dekontEklePopup_DekontEklenenID'];
		if($dekontunEklendigiID=='')
			ajax_error_response('Lütfen dekont eklemeden önce verileri kaydediniz');
		
		$dekontID = $db->getNextVal(FINANS_DEKONT_SEQ);
			
			$sql = "INSERT INTO M_FINANS_DEKONT 
					(DEKONT_ID, DEKONT_TARIHI, DEKONT_UCRETI, DEKONT_ACIKLAMA, DEKONT_NO, DEKONTU_KAYDEDENIN_IDSI) 
					VALUES (?,TO_DATE(?, 'dd.mm.yyyy'),?,?,?,?) ";
			
			$result1 = $db->prep_exec_insert($sql, array($dekontID,$dekontTarihi,$dekontTutari,$dekontAciklama, $dekontNo, $sektorSorumlusununIdsi));
		
		if($dekontTipi == "belgeMasrafi")
		{
			
			$sql = 'INSERT INTO M_FINANS_KRLS_BLG_MS_DEKONT
					(BELGE_MASRAFI_ID, DEKONT_ID)
					VALUES (?,?)';
			$result2 = $db->prep_exec_insert($sql, array($dekontunEklendigiID, $dekontID));
			
		}
		else if ($dekontTipi=="denetimDekontu")
		{
			$sql = 'INSERT INTO M_FINANS_KRLS_DENETIM_DEKONT
			(DENETIM_ID, DEKONT_ID)
			VALUES (?,?)';
			$result2 = $db->prep_exec_insert($sql, array($dekontunEklendigiID, $dekontID));
		}
		else if ($dekontTipi=="yillikAidatDekont")
		{
			$sql = 'INSERT INTO M_FINANS_KRLS_YILLIK_AIDAT_DK
			(YILLIK_AIDAT_ID, DEKONT_ID)
			VALUES (?,?)';
			$result2 = $db->prep_exec_insert($sql, array($dekontunEklendigiID, $dekontID));
		}
		
		
		if($result1 && $result2)
			ajax_success_response('Başarıyla Kaydedildi');
		else
			ajax_error_response('Hatayla karşılaşıldı');
		
	}
	function ajaxDekontSil()
	{
		$db = JFactory::getOracleDBO();
		$sql = 'DELETE FROM M_FINANS_DEKONT WHERE DEKONT_ID=?';
		$result = $db->prep_exec_insert($sql, array($_GET['dekont_id']));
		
		if($result)
			ajax_success_response('Başarıyla Kaydedildi');
		else
			ajax_error_response('Hatayla karşılaşıldı');
	}
	function getSessiondakiKurulusunAdi()
	{
		$user = & JFactory::getUser();
		$oracleID = $user->getOracleUserId();
		
		$db = JFactory::getOracleDBO();
		$sql = 'SELECT * FROM M_KURULUS WHERE USER_ID=?';
		$result = $db->prep_exec($sql, array($oracleID));
		
		if(count($result)>0)
			return $result[0]['KURULUS_ADI'];
		else 
			return '';
		
		
		
	}
	
	function ajaxKurulusFinansalBilgileriGetir ($user_id){
		$user = &JFactory::getUser();
    	$isSektorSorumlusu = FormFactory::buIDDenetlemedenSorumluSSMu($user->id);
    	$adminMi = FormFactory::checkAclGroupId ($user->id, YONETICI_GROUP_ID);
    	
    	if(!$isSektorSorumlusu && !$adminMi)//SS veya Admin Değilse
    		$silDegistirGoster = false; 
		else
			$silDegistirGoster = true;
		
    	$sessiondakiUser = & JFactory::getUser();
    	if($sessiondakiUser!=null);
    		$sessiondakiUserID = $sessiondakiUser->getOracleUserId();
    	
    	if($this->userIdKurulusMu($sessiondakiUserID)==true && $sessiondakiUserID!=$user_id)
    	{
    		ajax_error_response('Başka kuruluşun bilgilerini göremezsiniz');
    	}
    	else
    	{
    		
    		$db = JFactory::getOracleDBO();
    		$result = array();
    		if($sessiondakiUserID!=null && $this->userIdKurulusMu($sessiondakiUserID)==true)//oracle idsi bu o yuzden sadece kuruluslar
    			$result['KURULUS_MU'] = true;
    		
    		$sql = "SELECT *
    		FROM 	M_FINANS_TARIFE_DONEMI
    		FULL JOIN (SELECT * FROM M_FINANS_KRLS_BELGE_MASRAF
    		WHERE (USER_ID=? OR USER_ID IS NULL)) USING (TARIFE_DONEMI_ID)
    		ORDER BY TARIFE_BASLANGICI";
    		
    		$belgeMasraf = $db->prep_exec($sql, array($user_id));
    		
    		for($i=0; $i<count($belgeMasraf); $i++)
    		{
    		$belgeMasraf[$i]['DONEM_OPTIONS'] = $this->getDonemlerOptions($belgeMasraf[$i]['TARIFE_DONEMI_ID']);
    		$verilenBelgeSayilari = $this->getKurulusunVerdigiBelgeSayisiByKurulusIDAndDenetimTarihi($user_id, $belgeMasraf[$i]['TARIFE_BASLANGICI'], $belgeMasraf[$i]['TARIFE_BITISI']);
    				$buDonemdeVerilmisBelgeSayisi = (count($verilenBelgeSayilari)>0) ? $verilenBelgeSayilari[0]['HESAPLANAN_BELGE_SAYISI'] : 0;
    				$belgeMasraf[$i]['HESAPLANAN_BELGE_SAYISI'] = $buDonemdeVerilmisBelgeSayisi;
    				
    				$belgeMasraflarininDekontlari = $this->getBelgeMasrafiDekontByBelgeMasrafiID($belgeMasraf[$i]['BELGE_MASRAFI_ID'], $silDegistirGoster);
    						if(count($belgeMasraflarininDekontlari)>0)
    						$result['BelgeMasraflariDekontlari'][$i]= $belgeMasraflarininDekontlari;
    		}
    		
    		
    		$sql = "SELECT * FROM M_FINANS_TARIFE_DONEMI ORDER BY TARIFE_BASLANGICI";
    		$tumTarifeDonemleri = $db->prep_exec($sql, array());
    		$result['TARIFE_DONEMLERI'] = $tumTarifeDonemleri;
    		$result['DENETIM'] = $tumTarifeDonemleri;
    		for($i=0; $i<count($tumTarifeDonemleri); $i++)
	    	{
	    		$tarifeDonemiID = $tumTarifeDonemleri[$i]['TARIFE_DONEMI_ID'];
	    		$buDonemdekiDenetimler = $this->getKurulusunTumDenetimleriByKurulusIDAndDenetimTarihi($user_id, $tumTarifeDonemleri[$i]['TARIFE_BASLANGICI'], $tumTarifeDonemleri[$i]['TARIFE_BITISI']);
	    		for($j=0; $j<count($buDonemdekiDenetimler); $j++)
	    		{
		    		$denetimIdsi = $buDonemdekiDenetimler[$j]['DENETIM_ID'];
		    		
		    		$sql = "SELECT * FROM M_FINANS_KRLS_DENETIM WHERE DENETIM_ID=?";
		    		$ilaveDenetimUcretleri = $db->prep_exec($sql, array($denetimIdsi));
		    		$result['DENETIM_ILAVE_UCRETLERI'][$denetimIdsi] = $ilaveDenetimUcretleri;
		    		
		    		
		    		$sql = "SELECT * FROM M_FINANS_KRLS_DENETIM_DEKONT JOIN M_FINANS_DEKONT USING (DEKONT_ID) WHERE DENETIM_ID=? ORDER BY DEKONT_ID DESC";
		    		$dekontlari = $db->prep_exec($sql, array($denetimIdsi));
		    		for($k=0; $k<count($dekontlari); $k++)
		    			$dekontlari[$k]['DEKONT_UPLOADER_TD'] = $this->getNushaBelgesiTDData($dekontlari[$k]['DEKONT_PATH'], $dekontlari[$k]['DEKONT_ID'],  $silDegistirGoster);
		    		
		    		$result['DENETIM_DEKONTLARI'][$denetimIdsi] = $dekontlari;
	    		
	    		}
	    		$result['DENETIM'][$i]['DONEMIN_DENETIMLERI'] = $buDonemdekiDenetimler;
	    		$result['DENETIM'][$i]['DONEM_OPTIONS'] = $this->getDonemlerOptions($tarifeDonemiID);
	    		
	    			
	    		$verilenBelgeSayilari = $this->getKurulusunVerdigiBelgeSayisiByKurulusIDAndDenetimTarihi($user_id, $tumTarifeDonemleri[$i]['TARIFE_BASLANGICI'], $tumTarifeDonemleri[$i]['TARIFE_BITISI']);
	    		$buDonemdeVerilmisBelgeSayisi = (count($verilenBelgeSayilari)>0 && $verilenBelgeSayilari[0]['HESAPLANAN_BELGE_SAYISI']!='') ? $verilenBelgeSayilari[0]['HESAPLANAN_BELGE_SAYISI'] : 0;
	    		$result['TARIFE_DONEMLERI'][$i]['HESAPLANAN_BELGE_SAYISI'] = $buDonemdeVerilmisBelgeSayisi;
	    		$result['TARIFE_DONEMLERI'][$i]['DONEM_OPTIONS'] = $this->getDonemlerOptions($tarifeDonemiID);
	    			
	    		//// YILLIK AIDAT ICIN
	    		$buDoneminYillikAidataTabiGunleri = $this->getYillikAidataTabiGunler($user_id, $tarifeDonemiID);
	    		$buDoneminBelgeParalari = $this->getYillikAidatTutari_BelgeyeGore($user_id, $tarifeDonemiID, $belgeMasraf[$i]['VERILEN_BELGE_SAYISI']);// $buDonemdeVerilmisBelgeSayisi
	    		
	    		$buDoneminAkrediteKurulusSayisi = $this->getAkrediteKurulusSayisi($user_id, $tarifeDonemiID);
	    		$buDonemimAkrediteKurulusAidati = $this->getYillikAidatTutari_AkrediteKurulusaGore($user_id, $tarifeDonemiID, $buDoneminAkrediteKurulusSayisi);
	    		
	    		$result['TARIFE_DONEMLERI'][$i]['YILLIK_AIDAT'] = $buDoneminYillikAidataTabiGunleri[0];
	    		$result['TARIFE_DONEMLERI'][$i]['YILLIK_AIDAT_AKREDITE_KURULUSTAN'] = $buDonemimAkrediteKurulusAidati;
	    		$result['TARIFE_DONEMLERI'][$i]['BIRIM_FIYAT'] = $buDoneminBelgeParalari[0]['FIYAT'];
	    		$result['TARIFE_DONEMLERI'][$i]['BU_DONEMDE_AKREDITE_EDILMIS_KURULUS'] = $buDoneminAkrediteKurulusSayisi;
	    		
	    		$aidatID = $this->getYillikAidatIDByKurulusIDAndDonemID($user_id, $tarifeDonemiID);
	    		$aidatDekontlari = $this->getYillikAidatDekontByYillikAidatID($aidatID, $silDegistirGoster);
	    		$result['AIDAT_DEKONTLARI'][$aidatID] = $aidatDekontlari;
	    		///// YILLIK AIDAT ICIN
	    			
    			
    		}
    		
    		
    		
    		$result['BelgeMasraf']=$belgeMasraf;
    		ajax_success_response_with_array('success', $result);
    	}
    		
    	
	}

	function userIdKurulusMu($userID)
	{
		$db = JFactory::getOracleDBO();
		$sql = 'SELECT * FROM M_KURULUS WHERE USER_ID=?';
		$result = $db->prep_exec($sql, array($userID));
	
		if(count($result)>0)
			return true;
		else
			return false;
	}
	
	function getYillikAidatIDByKurulusIDAndDonemID($user_id, $tarifeDonemiID)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = 'SELECT * FROM M_FINANS_KRLS_YILLIK_AIDAT WHERE USER_ID=? AND TARIFE_DONEMI_ID=?';
		$params = array($user_id, $tarifeDonemiID);
		$result = $db->prep_exec($sql, $params);
		return $result[0]['YILLIK_AIDAT_ID'];
	}
	
	function getYillikAidatTutari_BelgeyeGore($user_id, $tarifeDonemiID, $buDonemdeVerilmisBelgeSayisi)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = '	SELECT FIYAT
	FROM 	 M_FINANS_TARIFE_DONEMI
	JOIN M_FINANS_ARALIKLI_TARIFE USING (TARIFE_DONEMI_ID)
	WHERE TARIFE_DONEMI_ID = ?
	AND BASLANGIC <= ?
	AND BITIS >= ?
	AND TIP_ID = 1
	';
		$params = array($tarifeDonemiID, $buDonemdeVerilmisBelgeSayisi,$buDonemdeVerilmisBelgeSayisi);
		return $db->prep_exec($sql, $params);
		
	}
	
	
	function getAkrediteKurulusSayisi($user_id, $tarifeDonemiID)
	{
		$db  = &JFactory::getOracleDBO();
		if($tarifeDonemiID!='')
		{
			$sql = 'SELECT * FROM M_AKREDITE_KURULUS_YETKI 
			JOIN M_FINANS_TARIFE_DONEMI ON 
						(	M_AKREDITE_KURULUS_YETKI.AKREDITASYON_TARIHI >= M_FINANS_TARIFE_DONEMI.TARIFE_BASLANGICI 
						AND M_AKREDITE_KURULUS_YETKI.AKREDITASYON_TARIHI <= M_FINANS_TARIFE_DONEMI.TARIFE_BITISI 
						)
			 WHERE DENETCI_KURULUS_ID=? AND TARIFE_DONEMI_ID=?';
			$params = array($user_id, $tarifeDonemiID);
		}
		else
		{
			$sql = 'SELECT * FROM M_AKREDITE_KURULUS_YETKI WHERE DENETCI_KURULUS_ID=?';
			$params = array($user_id);
		}
		$result = $db->prep_exec($sql, $params);
		return count($result);
	}
	
	function getYillikAidatTutari_AkrediteKurulusaGore($user_id, $tarifeDonemiID, $akrediteEdilmisKurulusSayisi)
	{
		$db  = &JFactory::getOracleDBO();
		$sql = '	SELECT FIYAT
		FROM 	 M_FINANS_TARIFE_DONEMI
		JOIN M_FINANS_ARALIKLI_TARIFE USING (TARIFE_DONEMI_ID)
		WHERE TARIFE_DONEMI_ID = ?
		AND BASLANGIC <= ?
		AND BITIS >= ?
		AND TIP_ID = 2
		';//tip_id = 2 yani akredite kurulus sayisi
		$params = array($tarifeDonemiID, $akrediteEdilmisKurulusSayisi,$akrediteEdilmisKurulusSayisi);
		$result = $db->prep_exec($sql, $params);
		
		if(count($result)==0)
			return 0;
		else
			return $result[0]['FIYAT'];
			
	}
	
	function getYillikAidataTabiGunler($user_id, $tarifeDonemiID)
	{
		$db  = &JFactory::getOracleDBO();
		$params = array();
		if(strlen($tarifeDonemiID)!=0)
		{
			$sqlPart = ' AND TARIFE_DONEMI_ID=? ';
			$params[1]= $tarifeDonemiID;
		}
		
		$sql = 'SELECT * FROM M_FINANS_KRLS_YILLIK_AIDAT WHERE USER_ID=? '.$sqlPart;
		$params[0]=$user_id;
		$result = $db->prep_exec($sql, $params);
		
		/*if(count($result)!=0)
			return $result;
		else
			return $db->prep_exec('SELECT * FROM M_FINANS_KRLS_YILLIK_AIDAT WHERE USER_ID IS NULL AND USER_ID IS NOT NULL', array());//dummy table
		*/	
		return $result;
	}
	
	function getDekontlar($user_id)
	{
		$db  = &JFactory::getOracleDBO();
		if($user_id!='')
		{	
			$userIdPart = ' WHERE  USER_ID=? ';
			$params = array($user_id);
		}
		else
		{	
			$userIdPart = ' ';
			$params = array();
		}
		
		$sql = 'SELECT * FROM M_FINANS_KRLS_BELGE_MASRAF 
		JOIN M_FINANS_KRLS_BLG_MS_DEKONT USING (BELGE_MASRAFI_ID)
		JOIN M_FINANS_DEKONT USING (DEKONT_ID)
		JOIN M_KURULUS USING (USER_ID)
		'.$userIdPart.'
		ORDER BY BELGE_MASRAFI_ID,DEKONT_ID';
		$belgeMasrafDekontlari = $db->prep_exec($sql, $params);
		$result['BELGE_MASRAF'] = $belgeMasrafDekontlari;
		
		$sql = 'SELECT * FROM M_FINANS_KRLS_DENETIM 
		JOIN M_FINANS_KRLS_DENETIM_DEKONT USING (DENETIM_ID)
		JOIN M_FINANS_DEKONT USING (DEKONT_ID)
		JOIN M_KURULUS USING (USER_ID)
		'.$userIdPart.'
		ORDER BY DENETIM_ID, DEKONT_ID';
		$denetimDekontlari = $db->prep_exec($sql, $params);
		$result['DENETIM'] = $denetimDekontlari;
		
		$sql = 'SELECT * FROM M_FINANS_KRLS_YILLIK_AIDAT 
		JOIN M_FINANS_KRLS_YILLIK_AIDAT_DK USING (YILLIK_AIDAT_ID) 
		JOIN M_FINANS_DEKONT USING (DEKONT_ID)
		JOIN M_KURULUS USING (USER_ID)
		'.$userIdPart.' 
		ORDER BY YILLIK_AIDAT_ID, DEKONT_ID';
		$yillikAidatDekontlari = $db->prep_exec($sql, $params);
		$result['YILLIK_AIDAT'] = $yillikAidatDekontlari;
		 
		return $result;
	}
	function getKurulusunTumDenetimleriByKurulusIDAndDenetimTarihi($user_id, $tarifeDonemiBaslangic, $tarifeDonemiBitis)
	{
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
	
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT * 
				FROM M_DENETIM FULL JOIN (SELECT denetim_id, COUNT(*) 
FROM m_denetim_ekip
GROUP BY denetim_id) USING (DENETIM_ID)
				WHERE DENETIM_KURULUS_ID = ?
				AND to_date(?, 'dd.mm.yy') <= denetim_tarihi_baslangic
				AND to_date(?, 'dd.mm.yy') >= denetim_tarihi_baslangic";
	
		return $db->prep_exec($sql, array($user_id, $tarifeDonemiBaslangic, $tarifeDonemiBitis));
	
	
	}
	
	function getKurulusunVerdigiBelgeSayisiByKurulusIDAndDenetimTarihi($user_id, $tarifeDonemiBaslangic, $tarifeDonemiBitis)
	{
		$user = & JFactory::getUser();
		$userId = $user->getOracleUserId();
	
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT SUM(VERILEN_BELGE) AS HESAPLANAN_BELGE_SAYISI
		FROM M_BELGELENDIRME_YET_TALEBI JOIN M_BASVURU USING (EVRAK_ID)
		WHERE USER_ID = ?
		AND to_date(?, 'dd.mm.yy') <= basvuru_tarihi
		AND to_date(?, 'dd.mm.yy') >= basvuru_tarihi";
		
		return $db->prep_exec($sql, array($user_id, $tarifeDonemiBaslangic, $tarifeDonemiBitis));
	
	}
	
	
	function getBelgeMasrafiDekontByBelgeMasrafiID($belgeMasrafiID,  $silDegistirGoster=true)
	{
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT *
				FROM 	M_FINANS_KRLS_BLG_MS_DEKONT JOIN M_FINANS_DEKONT USING (DEKONT_ID)
				WHERE BELGE_MASRAFI_ID=?
				ORDER BY DEKONT_ID DESC";
		
		$result = $db->prep_exec($sql, array($belgeMasrafiID));
		for($i=0; $i<count($result); $i++)
			$result[$i]['DEKONT_UPLOADER_TD'] = $this->getNushaBelgesiTDData($result[$i]['DEKONT_PATH'], $result[$i]['DEKONT_ID'],  $silDegistirGoster);
		
		return $result;
	}
	
	function getYillikAidatDekontByYillikAidatID($yillikAidatID,  $silDegistirGoster=true)
	{
		$db = JFactory::getOracleDBO();
	
		$sql = "SELECT *
		FROM 	M_FINANS_KRLS_YILLIK_AIDAT_DK 
		JOIN M_FINANS_KRLS_YILLIK_AIDAT USING (YILLIK_AIDAT_ID)
		JOIN M_FINANS_DEKONT USING (DEKONT_ID)
		WHERE YILLIK_AIDAT_ID=?
		ORDER BY DEKONT_ID DESC";
	
		$result = $db->prep_exec($sql, array($yillikAidatID));
		for($i=0; $i<count($result); $i++)
			$result[$i]['DEKONT_UPLOADER_TD'] = $this->getNushaBelgesiTDData($result[$i]['DEKONT_PATH'], $result[$i]['DEKONT_ID'],  $silDegistirGoster);
		
		return $result;
	}
	
	function getTarifeDonemleri()
	{
		$db = JFactory::getOracleDBO();
	
		$sql = "SELECT * FROM M_FINANS_TARIFE_DONEMI ORDER BY TARIFE_BASLANGICI";
	
		return $db->prep_exec($sql, array());
	}
	
	function getDonemlerOptions($selectedDonemID)
	{
		$db = JFactory::getOracleDBO();
		$sql = "SELECT * FROM M_FINANS_TARIFE_DONEMI ORDER BY TARIFE_BASLANGICI";
		
		$tumDonemler = $db->prep_exec($sql, array());
		
		$optText = '';
		for($i=0; $i<count($tumDonemler); $i++)
		{
			$selected = ($tumDonemler[$i]['TARIFE_DONEMI_ID']==$selectedDonemID) ? ' selected ' : '';
			$optText .= '<option '.$selected.' value="'.$tumDonemler[$i]['TARIFE_DONEMI_ID'].'">'.$tumDonemler[$i]['TARIFE_BASLANGICI'].' - '.$tumDonemler[$i]['TARIFE_BITISI'].'</option>';
		}
		
		return $optText;
	}
	
	function getFinansBilgi (){
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT FINANS_ID,
						DEKONT,
						MASRAF,
						TUR,
						TARIH,
						SURE
				FROM M_FINANS ";
		
		return $db->prep_exec($sql, array());
	}
	
	function getKuruluslar (){
		$db = JFactory::getOracleDBO();
	
		$sql = "SELECT *
		FROM M_KURULUS ORDER BY KURULUS_ADI ";
	
		return $db->prep_exec($sql, array());
	}
	
	function tarifeDonemiKaydet()
	{
		$db = JFactory::getOracleDBO();
		
		$tarifeID = $db->getNextVal(TARIFE_ID_SEQ);
		$tarifeBaslangici = $_POST['tarifeBaslangici'];
		$tarifeBitisi = $_POST['tarifeBitisi'];
		$belgeMasrafi = $_POST['belgeMasrafi'];
		$yetkilendirmeBasvuruMasrafi = $_POST['yetkilendirmeBasvuruMasrafi'];
		$denetimBedeli = $_POST['denetimBedeli'];
		
		$sql = "INSERT INTO M_FINANS_TARIFE_DONEMI (TARIFE_DONEMI_ID, TARIFE_BASLANGICI, TARIFE_BITISI, BELGE_MASRAFI, YETKILENDIRME_BASVURU_MASRAFI, DENETIM_BEDELI_ADAM_UCRET) VALUES (?,TO_DATE(?, 'dd.mm.yyyy'),TO_DATE(?, 'dd.mm.yyyy'),?,?,?) ";
		
		$result = $db->prep_exec_insert($sql, array($tarifeID, $tarifeBaslangici, $tarifeBitisi, $belgeMasrafi, $yetkilendirmeBasvuruMasrafi, $denetimBedeli));
		
		for($tabloNo=1; $tabloNo<=2; $tabloNo++)
		{
			for($i=0; $i<count($_POST['aralikBaslangiclari'][$tabloNo]); $i++)
			{
				$baslangic = $_POST['aralikBaslangiclari'][$tabloNo][$i];
				$bitis = $_POST['aralikBitisleri'][$tabloNo][$i];
				$parasi = $_POST['aralikFiyatlari'][$tabloNo][$i];
				
				
				$sql = "INSERT INTO M_FINANS_ARALIKLI_TARIFE (BASLANGIC, BITIS, FIYAT, TIP_ID, TARIFE_DONEMI_ID) VALUES (?,?,?,?,?) ";
				
				$result = $db->prep_exec_insert($sql, array($baslangic,
															$bitis,
															$parasi,
															$tabloNo,
															$tarifeID
															));
				
			}
		}
		
		
		
	}
	
	function getTarifeDonemiByID($donem_id)
	{
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_FINANS_TARIFE_DONEMI WHERE TARIFE_DONEMI_ID=?";
		
		$result = $db->prep_exec($sql, array($donem_id));
		if(count($result)!=0)
			return $result[0];
		else
			return null;
	}
	function getTarifeDonemiAralikliTablosuByDonemID($donem_id, $tabloNo)
	{
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_FINANS_ARALIKLI_TARIFE WHERE TARIFE_DONEMI_ID=? AND TIP_ID=? ORDER BY BASLANGIC";
		
		return $db->prep_exec($sql, array($donem_id, $tabloNo));
	}
	
	
	function tarifeDonemiDuzenle($tarifeID)
	{
		$db = JFactory::getOracleDBO();
	
		$tarifeBaslangici = $_POST['tarifeBaslangici'];
		$tarifeBitisi = $_POST['tarifeBitisi'];
		$belgeMasrafi = $_POST['belgeMasrafi'];
		$yetkilendirmeBasvuruMasrafi = $_POST['yetkilendirmeBasvuruMasrafi'];
		$denetimBedeli = $_POST['denetimBedeli'];
	
		$sql = "UPDATE M_FINANS_TARIFE_DONEMI 
				SET TARIFE_BASLANGICI=?, 
					TARIFE_BITISI=?, 
					BELGE_MASRAFI=?, 
					YETKILENDIRME_BASVURU_MASRAFI=?, 
					DENETIM_BEDELI_ADAM_UCRET=?
				WHERE TARIFE_DONEMI_ID=?";
	
		$result = $db->prep_exec_insert($sql, array($tarifeBaslangici, $tarifeBitisi, $belgeMasrafi, $yetkilendirmeBasvuruMasrafi, $denetimBedeli, $tarifeID));
	

		$sql = "DELETE FROM M_FINANS_ARALIKLI_TARIFE WHERE TARIFE_DONEMI_ID=?";		
		$result = $db->prep_exec_insert($sql, array($tarifeID));
		
		
		for($tabloNo=1; $tabloNo<=2; $tabloNo++)
		{
			for($i=0; $i<count($_POST['aralikBaslangiclari'][$tabloNo]); $i++)
			{
			$baslangic = $_POST['aralikBaslangiclari'][$tabloNo][$i];
			$bitis = $_POST['aralikBitisleri'][$tabloNo][$i];
			$parasi = $_POST['aralikFiyatlari'][$tabloNo][$i];
		
		
			$sql = "INSERT INTO M_FINANS_ARALIKLI_TARIFE (BASLANGIC, BITIS, FIYAT, TIP_ID, TARIFE_DONEMI_ID) VALUES (?,?,?,?,?) ";
		
			$result = $db->prep_exec_insert($sql, array($baslangic,
					$bitis,
					$parasi,
					$tabloNo,
					$tarifeID
			));
		
			}
		}
	
	
	
		}


	function getYetkiDurumuByKurulusID($user_id)
	{
		$db = JFactory::getOracleDBO();
		$sql = 'SELECT DURUM FROM (SELECT * FROM M_BASVURU WHERE USER_ID=?) 
		JOIN M_BELGELENDIRME_DURUM USING (EVRAK_ID) 
		JOIN PM_BELGELENDIRME_DURUM USING (DURUM_ID)
		ORDER BY EVRAK_ID';
		$result = $db->prep_exec($sql,array($user_id));
		
		return $result[0]['DURUM'];
		
	}
	
	function getYetkilendirmeTarihiByKurulusID($user_id)
	{
		$db = JFactory::getOracleDBO();
		$sql = 'SELECT BASVURU_TARIHI FROM (SELECT * FROM M_BASVURU WHERE USER_ID=?) 
		JOIN M_BELGELENDIRME_DURUM USING (EVRAK_ID) 
		JOIN PM_BELGELENDIRME_DURUM USING (DURUM_ID)
		
		ORDER BY EVRAK_ID';
		$result = $db->prep_exec($sql,array($user_id));
		
		return substr($result[count($result)-1]['BASVURU_TARIHI'], 0, 10);
		//return $user_id;
	}
		
	function kurulusFinansalBilgileriKaydet(&$errorText)
	{
		$resultToReturn = true;
		$db = JFactory::getOracleDBO();
		
		$ilaveDenetimBedelleri = $_POST['kaydetmeyeIlaveDenetimBedelleri'];
		$user_id = $_POST['user_id'];
		
		
		$tarifeDonemiIDleri = $_POST['kaydedilecekTarifeDonemiID'];
		$tarifeDonemindeVerilmisBelgeSayisi = $_POST['tarifeDonemindeVerilmisBelgeSayisi'];
		
		for($i=0; $i<count($tarifeDonemindeVerilmisBelgeSayisi); $i++)
		{
			$sql = 'SELECT * FROM M_FINANS_KRLS_BELGE_MASRAF WHERE USER_ID=? AND TARIFE_DONEMI_ID=?';
			$result = $db->prep_exec($sql, array($user_id, $tarifeDonemiIDleri[$i]));
				
			if($user_id != '' && $tarifeDonemiIDleri[$i]!= '' && $tarifeDonemindeVerilmisBelgeSayisi[$i]!='')
			{
				if(count($result)==0)
				{
					$yeniBelgeSayisiID = $db->getNextVal(FINANS_BELGE_MASRAFI_ID_SEQ);
					$sql = 'INSERT INTO M_FINANS_KRLS_BELGE_MASRAF
					(USER_ID, TARIFE_DONEMI_ID, VERILEN_BELGE_SAYISI, BELGE_MASRAFI_ID )
					VALUES (?,?,?,?)';
					$result = $db->prep_exec_insert($sql, array($user_id, $tarifeDonemiIDleri[$i], $tarifeDonemindeVerilmisBelgeSayisi[$i], $yeniBelgeSayisiID ));
					$resultToReturn = $resultToReturn && $result;
					if($result==false) $errorText = "Kuruluş Belge Masrafı Eklenemedi";
				}
				else
				{
					$sql = 'UPDATE M_FINANS_KRLS_BELGE_MASRAF
					SET
					VERILEN_BELGE_SAYISI=?
					WHERE
					USER_ID=? AND TARIFE_DONEMI_ID=?
					';
					$result = $db->prep_exec_insert($sql, array($tarifeDonemindeVerilmisBelgeSayisi[$i], $result[0]['USER_ID'], $result[0]['TARIFE_DONEMI_ID']));
					$resultToReturn = $resultToReturn && $result;
					if($result==false) $errorText = "Kuruluş Belge Masrafı Düzenlenemedi";
						
				}	
			}				
		}
		
		
		$tarifeDonemiIDleri = $_POST['kaydedilecekYillikAidatlarinTarifeDonemiIDleri'];
		$tarifeDonemineTabiGunler = $_POST['kaydedilecekYillikAidataTabiGunler'];
		$tarifeDonemineTabiGunler2 = $_POST['kaydedilecekYillikAidataTabiGunler2'];
		
		for($i=0; $i<count($tarifeDonemineTabiGunler); $i++)
		{
			$sql = 'SELECT * FROM M_FINANS_KRLS_YILLIK_AIDAT WHERE USER_ID=? AND TARIFE_DONEMI_ID=?';
			$result = $db->prep_exec($sql, array($user_id, $tarifeDonemiIDleri[$i]));
			
			if(count($result)==0)
			{
				$yeniYillikAidatID = $db->getNextVal(FINANS_YILLIK_AIDAT_ID_SEQ);
				$sql = 'INSERT INTO M_FINANS_KRLS_YILLIK_AIDAT
				(USER_ID, TARIFE_DONEMI_ID, YILLIK_AIDATA_TABI_GUN, YILLIK_AIDAT_ID, YILLIK_AIDATA_TABI_GUN_AKRDT )
				VALUES (?,?,?,?,?)';
				$result = $db->prep_exec_insert($sql, array($user_id, $tarifeDonemiIDleri[$i], $tarifeDonemineTabiGunler[$i], $yeniYillikAidatID, $tarifeDonemineTabiGunler2[$i] ));
				$resultToReturn = $resultToReturn && $result;
				if($result==false) $errorText = "Yıllık Aidat Masrafı Eklenemedi";
				
			}
			else
			{
				$sql = 'UPDATE M_FINANS_KRLS_YILLIK_AIDAT
				SET
				YILLIK_AIDATA_TABI_GUN=?,
				YILLIK_AIDATA_TABI_GUN_AKRDT=?
				WHERE
				USER_ID=? AND TARIFE_DONEMI_ID=?
				';
				$result = $db->prep_exec_insert($sql, array($tarifeDonemineTabiGunler[$i],$tarifeDonemineTabiGunler2[$i], $result[0]['USER_ID'], $result[0]['TARIFE_DONEMI_ID']));
				$resultToReturn = $resultToReturn && $result;
				if($result==false) $errorText = "Kuruluş Belge Masrafı Düzenlenemedi";
				
			}
		
		}
		
		
		for($i=0; $i<count($ilaveDenetimBedelleri); $i++)
		{
			$ilaveDenetimBedeliID = $ilaveDenetimBedelleri[$i];
			$denetimID = $_POST['kaydetmeyeDenetimIDleri'][$i];
			
			$sql = 'SELECT * FROM M_FINANS_KRLS_DENETIM WHERE USER_ID=? AND DENETIM_ID=?';
			$result = $db->prep_exec($sql, array($user_id, $denetimID));
			
			if(count($result)==0)
			{
				$sql = 'INSERT INTO M_FINANS_KRLS_DENETIM (USER_ID, DENETIM_ID, ILAVE_DENETIM_UCRETI ) VALUES (?,?,?)';
				$result = $db->prep_exec_insert($sql, array($user_id, $denetimID, $ilaveDenetimBedelleri[$i] ));
				$resultToReturn = $resultToReturn && $result;
				if($result==false) $errorText = "Denetim Masrafı Eklenemedi";
				
			}
			else
			{
				$sql = 'UPDATE M_FINANS_KRLS_DENETIM SET ILAVE_DENETIM_UCRETI=? WHERE USER_ID=? AND DENETIM_ID=?';
				$result = $db->prep_exec_insert($sql, array($ilaveDenetimBedelleri[$i], $user_id, $denetimID));
				$resultToReturn = $resultToReturn && $result;	
				if($result==false) $errorText = "Denetim Masrafı Düzenlenemedi";		
			}	
			
		}
		
		for($i=0; $i<count($_POST['nushaIcinDekontIDleri']); $i++)
		{
			$dekontID = $_POST['nushaIcinDekontIDleri'][$i];
			$result = $this->dekontNushasiKaydet($dekontID);
			$resultToReturn = $resultToReturn && $result;
		}
		
		
		return $resultToReturn;
		
		
	}
	
	function getNushaBelgesiTDData($raporPath, $dekontID, $silDegistirGoster)
	{
	
		$resultToReturn = '';
	
		if($silDegistirGoster==true)
			$uploaderContent = '<input type="hidden" name="nushaIcinDekontIDleri[]" value="'.$dekontID.'">
			<input type="file" name="dosya['.$dekontID.'][]" class="required" id="dosya" style="width: 210px;"  />';
	
		if(strlen($raporPath) > 0)
		{
			$resultToReturn .= '<div style="width:97%; float:left; border-top:3px solid green; border-bottom:3px solid green; padding:4px; background-color: #EEFFEE; color:green;">
			<div style="float:left;">
			Nüsha Eklenmiş.
			<br>
			<a style="color:green; text-decoration:underline;" href="index.php?dl=dekontNushalari/'.$dekontID.'/'.$raporPath.'">İndir</a>';
			if($silDegistirGoster==true)
			{
				$resultToReturn .= '&nbsp;&nbsp;&nbsp;
				|
				&nbsp;&nbsp;&nbsp;
				<a style="color:green; text-decoration:underline;" href="#" class="formGosterButton" id="formGosterButton-'.$dekontID.'">Değiştir</a>
				<input type="hidden" id="degistirFieldSelected-'.$dekontID.'" name="degistirFieldSelected-'.$dekontID.'" value="0">
				&nbsp;&nbsp;&nbsp;
				|
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" id="raporSilCheckbox-'.$dekontID.'" name="raporSilCheckbox-'.$dekontID.'" value="1">
				&nbsp;&nbsp;
				<a onclick="if(jQuery(\'#raporSilCheckbox-'.$dekontID.'\').attr(\'checked\')==\'checked\') jQuery(\'#raporSilCheckbox-'.$dekontID.'\').removeAttr(\'checked\'); else jQuery(\'#raporSilCheckbox-'.$dekontID.'\').attr(\'checked\', \'checked\')" style="color:green; text-decoration:underline;" href="#">Sil</a>
				&nbsp;&nbsp;&nbsp;';
			}
			
			$resultToReturn .= '</div>
			</div>';
	
			$resultToReturn .= '<div id="toggleableDiv-'.$dekontID.'" style="width:100%; float:left; display:none;">'.$uploaderContent.'</div>';
	
			//$resultToReturn .= '<div style="padding-top:10px; width:100%; float:left;"><input type="button" onclick="window.location=\'index.php?option=com_denetim&layout=denetim_listele\';" value="GERİ" ></div>';
	
	
		}
		else
		{
			$resultToReturn .= $uploaderContent;
		}
	
	
		return $resultToReturn;
	}
	
	
	function dekontNushasiKaydet($dekont_id)
	{
		$db  = &JFactory::getOracleDBO();
	
		$sql = "SELECT DEKONT_PATH FROM M_FINANS_DEKONT WHERE DEKONT_ID = ?";
		$data = $db->prep_exec($sql, array($dekont_id));
		$previouslySavedRaporPath = $data[0]['DEKONT_PATH'];
	
	
		//if(strlen($previouslySavedRaporPath)==0)
		//{
		//RAPOR UPDATE
		if ($_POST['raporSilCheckbox-'.$dekont_id]=='1' )
		{
			global $mainframe;
			$directory = EK_FOLDER."dekontNushalari/".$dekont_id."/";
			$sildir=EK_FOLDER."dekontNushalari/".$dekont_id."/";
			foreach(glob($sildir . '/*') as $file) {
				if(is_dir($file))
					rrmdir($file);
				else
					unlink($file);
			}
			rmdir($sildir);
				
			$sql = "UPDATE M_FINANS_DEKONT SET DEKONT_PATH = '' WHERE DEKONT_ID = ?";
			return $db->prep_exec_insert($sql, array($dekont_id));
		}
		else
		{
	
			if($previouslySavedRaporPath=='' || $_POST['degistirFieldSelected-'.$dekont_id]=='1')
			{
	
				global $mainframe;
				$directory = EK_FOLDER."dekontNushalari/".$dekont_id."/";
				$sildir=EK_FOLDER."dekontNushalari/".$dekont_id."/";
				foreach(glob($sildir . '/*') as $file) {
					if(is_dir($file))
						rrmdir($file);
					else
						unlink($file);
				}
				rmdir($sildir);
	
	
				if($_FILES[dosya][size][$dekontUploaderSirasi]>5500000)
				{
					$mainframe->redirect("index.php?option=com_finans&layout=kurulus_finansal_bilgileri&uid=".$_POST['user_id'], "Gönderilen dosyanın boyutu 5MB dan büyük olamaz", 'error');
				}
				else
				{
					if (!file_exists($directory)){
						mkdir($directory, 0700,true);
					}
					$normalFile = FormFactory::formatFilename ($_FILES[dosya][name][$dekont_id][0]);
					$_FILES[dosya][name][$dekont_id][0]=	$directory . $normalFile;
					move_uploaded_file($_FILES[dosya][tmp_name][$dekont_id][0], $_FILES[dosya][name][$dekont_id][0]);
						
					$sql = "UPDATE M_FINANS_DEKONT SET DEKONT_PATH = ? WHERE DEKONT_ID = ?";
					return $db->prep_exec_insert($sql, array($normalFile, $dekont_id));
	
				}
	
	
			}
		}
	
	
		return true;
	
	}

}
?>	
