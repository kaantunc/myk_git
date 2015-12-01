<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once('libraries/form/functions.php');
require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');
require_once('libraries/PHPExcel-develop/Classes/PHPExcel/IOFactory.php');
include ('libraries/phpqrcode/qrlib.php');

class BelgelendirmeModelBelgelendirme_Islemleri extends JModel {
	
	function tcKayitlimi($post){
		$_db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		
		$tcno = $post['tcno'];
		
		$sql = "SELECT * FROM M_BELGELENDIRME_DEGERLENDIRICI WHERE TC_KIMLIK=?";
		
		$returns = $_db->prep_exec($sql, array($tcno));
		
		$sqlYet="SELECT DISTINCT M_YETERLILIK.YETERLILIK_ID, M_YETERLILIK.YETERLILIK_ADI, M_YETERLILIK.YETERLILIK_KODU,M_YETERLILIK_REVIZYON.REVIZYON_NO,M_YETERLILIK_REVIZYON.REVIZYON_DURUMU,M_YETERLILIK_REVIZYON.YETERLILIK_KODU AS YETERLILIK_REV_KOD
	FROM M_BASVURU
	JOIN M_BELGELENDIRME_YET_TALEBI ON M_BASVURU.EVRAK_ID =  M_BELGELENDIRME_YET_TALEBI.EVRAK_ID
	JOIN M_YETERLILIK_ALT_BIRIM ON M_BELGELENDIRME_YET_TALEBI.YETERLILIK_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ID
	JOIN M_YETERLILIK ON M_BELGELENDIRME_YET_TALEBI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
  LEFT JOIN M_YETERLILIK_REVIZYON ON M_BELGELENDIRME_YET_TALEBI.YETERLILIK_ID = M_YETERLILIK_REVIZYON.YETERLILIK_ID
  JOIN m_denetim_yetki on m_denetim_yetki.birim_id=M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
	WHERE M_BASVURU.BASVURU_DURUM_ID = 6 AND
	M_BASVURU.BASVURU_TIP_ID=3 AND
	M_BASVURU.USER_ID=".$user_id." AND
	M_YETERLILIK.YENI_MI=0
	 
  AND M_YETERLILIK.YETERLILIK_ID NOT IN(SELECT YETERLILIK_ID FROM M_BELGELENDIRME_DGRLNDRC_KRLS WHERE KURULUS_ID=? AND TC_KIMLIK=?)
	
UNION
	
	SELECT DISTINCT M_YETERLILIK.YETERLILIK_ID, M_YETERLILIK.YETERLILIK_ADI, M_YETERLILIK.YETERLILIK_KODU,M_YETERLILIK_REVIZYON.REVIZYON_NO,M_YETERLILIK_REVIZYON.REVIZYON_DURUMU,M_YETERLILIK_REVIZYON.YETERLILIK_KODU AS YETERLILIK_REV_KOD
	FROM M_BASVURU
	JOIN M_BELGELENDIRME_YET_TALEBI ON M_BASVURU.EVRAK_ID =  M_BELGELENDIRME_YET_TALEBI.EVRAK_ID
	JOIN M_YETERLILIK_BIRIM ON M_BELGELENDIRME_YET_TALEBI.YETERLILIK_ID = M_YETERLILIK_BIRIM.YETERLILIK_ID
	JOIN M_YETERLILIK ON M_BELGELENDIRME_YET_TALEBI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
  LEFT JOIN M_YETERLILIK_REVIZYON ON M_BELGELENDIRME_YET_TALEBI.YETERLILIK_ID = M_YETERLILIK_REVIZYON.YETERLILIK_ID
	JOIN m_denetim_yetki on m_denetim_yetki.birim_id=M_YETERLILIK_BIRIM.BIRIM_ID
	WHERE M_BASVURU.BASVURU_DURUM_ID = 6 AND
	M_BASVURU.BASVURU_TIP_ID=3 AND
	M_BASVURU.USER_ID=".$user_id." AND
	M_YETERLILIK.YENI_MI=1
	
  AND M_YETERLILIK.YETERLILIK_ID NOT IN(SELECT YETERLILIK_ID FROM M_BELGELENDIRME_DGRLNDRC_KRLS WHERE KURULUS_ID=? AND TC_KIMLIK=?)
  
ORDER BY YETERLILIK_ADI";
		
		$yets = $_db->prep_exec($sqlYet, array($user_id,$tcno,$user_id,$tcno));
		
		return array(0=>$returns,1=>$yets);
	}
	
	function getDeger($user_id){
		$_db = JFactory::getOracleDBO ();
		
		$sql = "SELECT M_BELGELENDIRME_DGRLNDRC_KRLS.*,M_BELGELENDIRME_DEGERLENDIRICI.*, M_YETERLILIK.*,M_YETERLILIK_REVIZYON.REVIZYON_NO,M_YETERLILIK_REVIZYON.REVIZYON_DURUMU,M_YETERLILIK_REVIZYON.YETERLILIK_KODU AS YETERLILIK_REV_KOD
				FROM M_BELGELENDIRME_DGRLNDRC_KRLS 
				JOIN M_BELGELENDIRME_DEGERLENDIRICI ON M_BELGELENDIRME_DGRLNDRC_KRLS.TC_KIMLIK = M_BELGELENDIRME_DEGERLENDIRICI.TC_KIMLIK
				JOIN M_YETERLILIK ON M_BELGELENDIRME_DGRLNDRC_KRLS.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
				LEFT JOIN M_YETERLILIK_REVIZYON ON M_YETERLILIK.YETERLILIK_ID = M_YETERLILIK_REVIZYON.YETERLILIK_ID
				WHERE M_BELGELENDIRME_DGRLNDRC_KRLS.KURULUS_ID=?  ORDER BY M_BELGELENDIRME_DGRLNDRC_KRLS.ETKIN DESC, M_BELGELENDIRME_DGRLNDRC_KRLS.ID DESC";
		
		$returns = $_db->prep_exec($sql, array($user_id));
		
		$degs = array();
		foreach ($returns as $row){
			$degs[$row['TC_KIMLIK']][] = $row; 
		}
		
		return $degs;
	}
	
	function getYeterlilik($user_id){
		$_db = JFactory::getOracleDBO ();
	
		$sql = "SELECT DISTINCT M_YETERLILIK.YETERLILIK_ID, M_YETERLILIK.YETERLILIK_ADI, M_YETERLILIK.YETERLILIK_KODU,M_YETERLILIK_REVIZYON.REVIZYON_NO,M_YETERLILIK_REVIZYON.REVIZYON_DURUMU,M_YETERLILIK_REVIZYON.YETERLILIK_KODU AS YETERLILIK_REV_KOD
	FROM M_BASVURU
	JOIN M_BELGELENDIRME_YET_TALEBI ON M_BASVURU.EVRAK_ID =  M_BELGELENDIRME_YET_TALEBI.EVRAK_ID
	JOIN M_YETERLILIK_ALT_BIRIM ON M_BELGELENDIRME_YET_TALEBI.YETERLILIK_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ID
	JOIN M_YETERLILIK ON M_BELGELENDIRME_YET_TALEBI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
  LEFT JOIN M_YETERLILIK_REVIZYON ON M_BELGELENDIRME_YET_TALEBI.YETERLILIK_ID = M_YETERLILIK_REVIZYON.YETERLILIK_ID
  JOIN M_DENETIM ON M_BASVURU.USER_ID = M_DENETIM.DENETIM_KURULUS_ID
  JOIN M_DENETIM_YETKI ON (M_DENETIM.DENETIM_ID = M_DENETIM_YETKI.DENETIM_ID AND M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID = M_DENETIM_YETKI.BIRIM_ID)
	WHERE BASVURU_DURUM_ID = 6 AND
	BASVURU_TIP_ID=3 AND
	USER_ID=".$user_id." AND
	YENI_MI=0
  AND m_denetim_yetki.ESKI_YET_ALTBIRIMINE_YETKI_MI = 1
	 
UNION
	
	SELECT DISTINCT M_YETERLILIK.YETERLILIK_ID, M_YETERLILIK.YETERLILIK_ADI, M_YETERLILIK.YETERLILIK_KODU,M_YETERLILIK_REVIZYON.REVIZYON_NO,M_YETERLILIK_REVIZYON.REVIZYON_DURUMU,M_YETERLILIK_REVIZYON.YETERLILIK_KODU AS YETERLILIK_REV_KOD
	FROM M_BASVURU
	JOIN M_BELGELENDIRME_YET_TALEBI ON M_BASVURU.EVRAK_ID =  M_BELGELENDIRME_YET_TALEBI.EVRAK_ID
	JOIN M_YETERLILIK_BIRIM ON M_BELGELENDIRME_YET_TALEBI.YETERLILIK_ID = M_YETERLILIK_BIRIM.YETERLILIK_ID
	JOIN M_YETERLILIK ON M_BELGELENDIRME_YET_TALEBI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
  LEFT JOIN M_YETERLILIK_REVIZYON ON M_BELGELENDIRME_YET_TALEBI.YETERLILIK_ID = M_YETERLILIK_REVIZYON.YETERLILIK_ID
  JOIN M_DENETIM ON M_BASVURU.USER_ID = M_DENETIM.DENETIM_KURULUS_ID
	JOIN M_DENETIM_YETKI ON (M_DENETIM.DENETIM_ID = M_DENETIM_YETKI.DENETIM_ID AND M_YETERLILIK_BIRIM.BIRIM_ID = M_DENETIM_YETKI.BIRIM_ID)
	WHERE BASVURU_DURUM_ID = 6 AND
	BASVURU_TIP_ID=3 AND
	USER_ID=".$user_id." AND
	YENI_MI=1
  AND m_denetim_yetki.ESKI_YET_ALTBIRIMINE_YETKI_MI = 0
   
ORDER BY YETERLILIK_ADI";
	
		$params = array ();
	
		return $_db->prep_exec($sql, $params);
	}
	
	function DegerlendiriciSinavKaydet ($post){
		$_db = JFactory::getOracleDBO ();
		
		$yeterlilik_id = $post['yets'];
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		$tcno = $post['tcno'];
		$uyrukDiger = $post['uyrukDiger'];
		$isim = $post['isim'];
		$soyisim = $post['soyisim'];
		$yeniDeg = $post['yeniDeg'];
		$uyruk = $post['uyruk'];
		if($uyruk == 1){
			$tcno = $uyrukDiger;
		}
		
		if($yeniDeg == 1){
			$sql = "INSERT INTO M_BELGELENDIRME_DEGERLENDIRICI (TC_KIMLIK,ADI,SOYADI,UYRUK,USER_ID) VALUES(?,?,?,?,?)";
			
			$_db->prep_exec_insert($sql, array($tcno,$isim,$soyisim,$uyruk,$user_id));
			
			$beyan = $_FILES['beyan'];
			$cv = $_FILES['cv'];
			

			if($beyan['size'] > 0 && $beyan['error']==0 && $beyan['size']<30000000){
				$directory = EK_FOLDER."degerlendiriciler/".$tcno;
				$path = "degerlendiriciler/".$tcno;
				if (!file_exists($directory)){
					mkdir($directory, 0700,true);
				}
				$normalFile = FormFactory::formatFilename ($beyan['name']);
				$path = "degerlendiriciler/".$tcno."/".$normalFile;
				if(move_uploaded_file($beyan['tmp_name'], $directory.'/'.$normalFile)){
					$sql = "UPDATE M_BELGELENDIRME_DEGERLENDIRICI SET BEYAN=? WHERE TC_KIMLIK=?";
					
					$_db->prep_exec_insert($sql, array($path,$tcno));
				}
				else{
					return "Değerlendiricinin Kişisel Beyanı 30MB'dan büyük olamaz.";
				}
			}
			else{
				return "Değerlendiricinin Kişisel Beyanı 30MB'dan büyük olamaz.";
			}
				
			if($cv['size'] > 0 && $cv['error']==0 && $cv['size']<30000000){
				$directory = EK_FOLDER."degerlendiriciler/".$tcno;
				$path = "degerlendiriciler/".$tcno;
				if (!file_exists($directory)){
					mkdir($directory, 0700,true);
				}
			
				$normalFile = FormFactory::formatFilename ($cv['name']);
				$path = "degerlendiriciler/".$tcno."/".$normalFile;
				if(move_uploaded_file($cv['tmp_name'], $directory.'/'.$normalFile)){
					$sql = "UPDATE M_BELGELENDIRME_DEGERLENDIRICI SET CV=? WHERE TC_KIMLIK=?";
					
					$_db->prep_exec_insert($sql, array($path,$tcno));
				}
				else{
					return "Değerlendiricinin Özgeçmişi 30MB'dan büyük olamaz.";
				}
			}else{
				return "Değerlendiricinin Özgeçmişi 30MB'dan büyük olamaz.";
			}
		}else{
			$isim=$post['getAd'];
			$soyisim = $post['getSoyAd'];
			
			$sql = "UPDATE M_BELGELENDIRME_DEGERLENDIRICI SET ADI=?,SOYADI=?,USER_ID=? WHERE TC_KIMLIK=?";
				
			$_db->prep_exec_insert($sql, array($isim,$soyisim,$user_id,$tcno));
			
			$beyan = $_FILES['gunBeyan'];
			$cv = $_FILES['gunCV'];
			
			if($beyan['size'] > 0 && $beyan['error']==0 && $beyan['size']<30000000){
				$directory = EK_FOLDER."degerlendiriciler/".$tcno;
				$path = "degerlendiriciler/".$tcno;
				if (!file_exists($directory)){
					mkdir($directory, 0700,true);
				}
				$normalFile = FormFactory::formatFilename ($beyan['name']);
				$path = "degerlendiriciler/".$tcno."/".$normalFile;
				if(move_uploaded_file($beyan['tmp_name'], $directory.'/'.$normalFile)){
					$sql = "UPDATE M_BELGELENDIRME_DEGERLENDIRICI SET BEYAN=? WHERE TC_KIMLIK=?";
					
					$_db->prep_exec_insert($sql, array($path,$tcno));
				}
				else{
					return "Değerlendiricinin Kişisel Beyanı 30MB'dan büyük olamaz.";
				}
			}else if($beyan['error']!=4){
				return "Değerlendiricinin Kişisel Beyanı 30MB'dan büyük olamaz.";
			}
			
			
			if($cv['size'] > 0 && $cv['error']==0 && $cv['size']<30000000){
				$directory = EK_FOLDER."degerlendiriciler/".$tcno;
				
				if (!file_exists($directory)){
					mkdir($directory, 0700,true);
				}
				
				$normalFile = FormFactory::formatFilename ($cv['name']);
				$path = "degerlendiriciler/".$tcno."/".$normalFile;
			if(move_uploaded_file($cv['tmp_name'], $directory.'/'.$normalFile)){
					$sql = "UPDATE M_BELGELENDIRME_DEGERLENDIRICI SET CV=? WHERE TC_KIMLIK=?";
					
					$_db->prep_exec_insert($sql, array($path,$tcno));
				}
				else{
					return "Değerlendiricinin Özgeçmişi 30MB'dan büyük olamaz.";
				}
			}else if($cv['error']!=4){
				return "Değerlendiricinin Kişisel Öz Geçmişi 30MB'dan büyük olamaz.";
			}
		}
		
		
		if(count($yeterlilik_id)>0){
			$hata = 0;
			foreach($yeterlilik_id as $tow){
				$sql = "INSERT INTO M_BELGELENDIRME_DGRLNDRC_KRLS (TC_KIMLIK, YETERLILIK_ID, KURULUS_ID) VALUES(?,?,?)";
				if(!$_db->prep_exec_insert($sql, array($tcno,$tow,$user_id))){
					$hata++;
				}
			}
			if($hata == 0){
				return 'Değerlendirici Ekleme İşlemi Başarılı.';
			}else{
				return 'Değerlendiriciye Yeterlilik atamasında bir hata meydana geldi. Lütfen tekrar deneyiniz.';
			}
			
		}else{
			return 'Değerlendirici Başarılı Bir Şekilde Güncellendi.';
		}
	}
	
	function ProgramKaydet($post){
		$_db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		$yeterlilik_id = $post['yets'];
		$date = $post['bastar'];
		$ilId = $post['il'];
	
		$sql = "INSERT INTO M_BELGELENDIRME_SINAV (KURULUS_ID,YETERLILIK_ID,BASLANGIC_TARIHI,SINAV_ILI)
				VALUES (?,?,TO_DATE(?, 'dd.mm.yyyy'),?)";
	
		$params = array(
				$user_id,$yeterlilik_id,$date,$ilId
		);
	
		if($_db->prep_exec_insert($sql, $params)){
			return 'Başarılı';
		}
		else{
			return 'Başarısız';
		}
	}
	
	function getGelecekProgram($user_id,$post){
		$_db = JFactory::getOracleDBO ();
                if(count($post)>0){
                    $sql = "SELECT M_BELGELENDIRME_SINAV.*, M_YETERLILIK.*, 
                    		M_YETERLILIK_REVIZYON.REVIZYON_NO,M_YETERLILIK_REVIZYON.REVIZYON_DURUMU,M_YETERLILIK_REVIZYON.YETERLILIK_KODU AS YETERLILIK_REV_KOD  FROM M_BELGELENDIRME_SINAV
							  JOIN M_YETERLILIK ON M_BELGELENDIRME_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
							  LEFT JOIN M_YETERLILIK_REVIZYON ON M_YETERLILIK.YETERLILIK_ID = M_YETERLILIK_REVIZYON.YETERLILIK_ID
							  WHERE M_BELGELENDIRME_SINAV.KURULUS_ID=?  AND M_BELGELENDIRME_SINAV.GECERLILIK_DURUMU = 1 AND M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI > (Select TRUNC(SYSDATE) from DUAL)";
                    $param = array($user_id);
                    if(isset($post['yeter']) && $post['yeter'] != ''){
                        $sql .= " AND M_BELGELENDIRME_SINAV.YETERLILIK_ID=?";
                        $param[] = $post['yeter'];
                    }
                    if(isset($post['tartar']) && $post['tartar'] !=''){
                     $sql .= " AND M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI > TO_DATE(?, 'dd.mm.yyyy')";
                     $param[] = $post['tartar'];
                    }
                    if(isset($post['sontar']) && $post['sontar'] !=''){
                     $sql .= " AND M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI < TO_DATE(?, 'dd.mm.yyyy')";
                     $param[] = $post['sontar'];
                    }
                    $sql .= " ORDER BY M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI ASC, M_BELGELENDIRME_SINAV.BILDIRIM_DURUMU ASC";
                }else{
                    $sql = "SELECT M_BELGELENDIRME_SINAV.*, M_YETERLILIK.*, 
                    		M_YETERLILIK_REVIZYON.REVIZYON_NO,M_YETERLILIK_REVIZYON.REVIZYON_DURUMU,M_YETERLILIK_REVIZYON.YETERLILIK_KODU AS YETERLILIK_REV_KOD  FROM M_BELGELENDIRME_SINAV
							  JOIN M_YETERLILIK ON M_BELGELENDIRME_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
							  LEFT JOIN M_YETERLILIK_REVIZYON ON M_YETERLILIK.YETERLILIK_ID = M_YETERLILIK_REVIZYON.YETERLILIK_ID
                                    WHERE M_BELGELENDIRME_SINAV.KURULUS_ID=?  AND M_BELGELENDIRME_SINAV.GECERLILIK_DURUMU = 1 AND M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI > (Select TRUNC(SYSDATE) from DUAL) ORDER BY M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI ASC, M_BELGELENDIRME_SINAV.BILDIRIM_DURUMU ASC";
                    $param = array($user_id);
                }
		return $_db->prep_exec($sql, $param);
	}
	
	function getGecmisProgram($user_id,$post){
		$_db = JFactory::getOracleDBO ();
	
                if(count($post)>0){
                    $sql = "SELECT M_BELGELENDIRME_SINAV.*, M_YETERLILIK.*, 
                    		M_YETERLILIK_REVIZYON.REVIZYON_NO,M_YETERLILIK_REVIZYON.REVIZYON_DURUMU,M_YETERLILIK_REVIZYON.YETERLILIK_KODU AS YETERLILIK_REV_KOD  FROM M_BELGELENDIRME_SINAV
							  JOIN M_YETERLILIK ON M_BELGELENDIRME_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
							  LEFT JOIN M_YETERLILIK_REVIZYON ON M_YETERLILIK.YETERLILIK_ID = M_YETERLILIK_REVIZYON.YETERLILIK_ID
                                    WHERE M_BELGELENDIRME_SINAV.SINAV_ID IN (SELECT DISTINCT SINAV_ID FROM M_BELGELENDIRME_ADAY_BILDIRIM) 
                                    AND M_BELGELENDIRME_SINAV.KURULUS_ID=?  AND M_BELGELENDIRME_SINAV.GECERLILIK_DURUMU = 1 AND M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI <= (Select TRUNC(SYSDATE) from DUAL)";
                    $param = array($user_id);
                    if(isset($post['yeter']) && $post['yeter'] != ''){
                        $sql .= " AND M_BELGELENDIRME_SINAV.YETERLILIK_ID=?";
                        $param[] = $post['yeter'];
                    }
                    if(isset($post['tartar']) && $post['tartar'] !=''){
                     $sql .= " AND M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI >= TO_DATE(?, 'dd.mm.yyyy')";
                     $param[] = $post['tartar'];
                    }
                    if(isset($post['sontar']) && $post['sontar'] !=''){
                     $sql .= " AND M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI <= TO_DATE(?, 'dd.mm.yyyy')";
                     $param[] = $post['sontar'];
                    }
                    $sql .= " ORDER BY M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI DESC, BILDIRIM_DURUMU ASC";
                }else{
                    $sql = "SELECT M_BELGELENDIRME_SINAV.*, M_YETERLILIK.*, 
                    		M_YETERLILIK_REVIZYON.REVIZYON_NO,M_YETERLILIK_REVIZYON.REVIZYON_DURUMU,M_YETERLILIK_REVIZYON.YETERLILIK_KODU AS YETERLILIK_REV_KOD  FROM M_BELGELENDIRME_SINAV
							  JOIN M_YETERLILIK ON M_BELGELENDIRME_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
							  LEFT JOIN M_YETERLILIK_REVIZYON ON M_YETERLILIK.YETERLILIK_ID = M_YETERLILIK_REVIZYON.YETERLILIK_ID
                                    WHERE M_BELGELENDIRME_SINAV.SINAV_ID IN (SELECT DISTINCT SINAV_ID FROM M_BELGELENDIRME_ADAY_BILDIRIM) 
                                    AND M_BELGELENDIRME_SINAV.KURULUS_ID=?  AND M_BELGELENDIRME_SINAV.GECERLILIK_DURUMU = 1 AND M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI <= (Select TRUNC(SYSDATE) from DUAL) ORDER BY M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI DESC, M_BELGELENDIRME_SINAV.BILDIRIM_DURUMU ASC";
                    $param = array($user_id);
                }
		return $_db->prep_exec($sql, $param);
	}
        
        function getYapilmayanProgram($user_id,$post){
            $_db = JFactory::getOracleDBO ();
	
                if(count($post)>0){
                    $sql = "SELECT M_BELGELENDIRME_SINAV.*, M_YETERLILIK.*, 
                    		M_YETERLILIK_REVIZYON.REVIZYON_NO,M_YETERLILIK_REVIZYON.REVIZYON_DURUMU,M_YETERLILIK_REVIZYON.YETERLILIK_KODU AS YETERLILIK_REV_KOD  FROM M_BELGELENDIRME_SINAV
							  JOIN M_YETERLILIK ON M_BELGELENDIRME_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
							  LEFT JOIN M_YETERLILIK_REVIZYON ON M_YETERLILIK.YETERLILIK_ID = M_YETERLILIK_REVIZYON.YETERLILIK_ID
                                WHERE (M_BELGELENDIRME_SINAV.SINAV_ID NOT IN (SELECT DISTINCT SINAV_ID FROM M_BELGELENDIRME_ADAY_BILDIRIM) AND M_BELGELENDIRME_SINAV.SONUC_DURUMU = 1  
                                AND M_BELGELENDIRME_SINAV.KURULUS_ID=?  AND M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI <= (Select TRUNC(SYSDATE) from DUAL)";
                    $param = array($user_id,$user_id);
                    if(isset($post['yeter']) && $post['yeter'] != ''){
                        $sql .= " AND M_BELGELENDIRME_SINAV.YETERLILIK_ID=?";
                        $param[] = $post['yeter'];
                    }
                    if(isset($post['tartar']) && $post['tartar'] !=''){
                     $sql .= " AND M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI >= TO_DATE(?, 'dd.mm.yyyy')";
                     $param[] = $post['tartar'];
                    }
                    if(isset($post['sontar']) && $post['sontar'] !=''){
                     $sql .= " AND M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI <= TO_DATE(?, 'dd.mm.yyyy')";
                     $param[] = $post['sontar'];
                    }
                    $sql .= ") OR (M_BELGELENDIRME_SINAV.GECERLILIK_DURUMU=2 AND M_BELGELENDIRME_SINAV.KURULUS_ID = ?) ORDER BY M_BELGELENDIRME_SINAV.GECERLILIK_DURUMU DESC, M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI DESC, M_BELGELENDIRME_SINAV.BILDIRIM_DURUMU ASC";
                }else{
                    $sql = "SELECT M_BELGELENDIRME_SINAV.*, M_YETERLILIK.*, 
                    		M_YETERLILIK_REVIZYON.REVIZYON_NO,M_YETERLILIK_REVIZYON.REVIZYON_DURUMU,M_YETERLILIK_REVIZYON.YETERLILIK_KODU AS YETERLILIK_REV_KOD  FROM M_BELGELENDIRME_SINAV
							  JOIN M_YETERLILIK ON M_BELGELENDIRME_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
							  LEFT JOIN M_YETERLILIK_REVIZYON ON M_YETERLILIK.YETERLILIK_ID = M_YETERLILIK_REVIZYON.YETERLILIK_ID
                                WHERE (M_BELGELENDIRME_SINAV.SINAV_ID NOT IN (SELECT DISTINCT SINAV_ID FROM M_BELGELENDIRME_ADAY_BILDIRIM) AND M_BELGELENDIRME_SINAV.SONUC_DURUMU = 1  
                                AND M_BELGELENDIRME_SINAV.KURULUS_ID=?  AND M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI <= (Select TRUNC(SYSDATE) from DUAL))  OR (M_BELGELENDIRME_SINAV.GECERLILIK_DURUMU=2 AND M_BELGELENDIRME_SINAV.KURULUS_ID = ?)
                                ORDER BY M_BELGELENDIRME_SINAV.GECERLILIK_DURUMU DESC, M_BELGELENDIRME_SINAV.BASLANGIC_TARIHI DESC, M_BELGELENDIRME_SINAV.BILDIRIM_DURUMU ASC";
                    $param = array($user_id,$user_id);
                }
		return $_db->prep_exec($sql, $param);
        }
	
	function ProgramBildir($post){
		$_db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
	
		$id = $post['id'];
	
		$sql = "UPDATE M_BELGELENDIRME_SINAV SET BILDIRIM_DURUMU = 1, BILDIRIM_TARIHI = (Select TRUNC(SYSDATE) from DUAL) WHERE SINAV_ID = ?";
		$params = array($id);
		if($_db->prep_exec_insert($sql, $params)){
			
			$sqlSinav = "SELECT * FROM M_BELGELENDIRME_SINAV 
					JOIN M_KURULUS ON M_BELGELENDIRME_SINAV.KURULUS_ID = M_KURULUS.USER_ID 
					JOIN M_YETERLILIK ON M_BELGELENDIRME_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
					WHERE SINAV_ID = ?";
			
			$data = $_db->prep_exec($sqlSinav, array($id));
			
			$aciklamaText = $data[0]['KURULUS_ADI'].', '.$data[0]['YETERLILIK_KODU'].' '.$data[0]['YETERLILIK_ADI'].' yeterliliğinden '.$data[0]['BASLANGIC_TARIHI'].' tarihinde sınav yapacağını bildirdi.';
			
			//Görevlendirilen Userlar
			$sqlGorevli = "SELECT * FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
			$gorevli = $_db->prep_exec($sqlGorevli, array($user_id));
			
			$mysqlDB = &JFactory::getDBO();
			$mailGorevli = array('mordukaya@myk.gov.tr','ktunc@myk.gov.tr');
			foreach($gorevli as $tow){
				$sqlMatbaa= "SELECT email FROM #__users as users
					WHERE tgUserId = ".$tow['TGUSERID'];
				$mysqlDB->setQuery($sqlMatbaa);
				$matbaaUser = $mysqlDB->loadObjectList();
				$mailGorevli[] = $matbaaUser[0]->email;
			}
			
			
			//Görevlendirilen Userlar
			$baslik = $data[0]['KURULUS_ADI'].' Sınav Programı Bildirildi.';
			$icerik = $aciklamaText.'  http://portal.myk.gov.tr/index.php?option=com_belgelendirme&view=belge_olusturma&layout=gelecek_sinavlar';
			$to = $mailGorevli;
			
			FormFactory::sentEmail($baslik,$icerik,$to);
			
// 			$recipient = $mailGorevli;
			
// 			$mailer =& JFactory::getMailer();
			
// 			$config =& JFactory::getConfig();
// 			$sender = array(
// 					$config->getValue( 'config.mailfrom' ),
// 					$config->getValue( 'config.fromname' ) );
// 			$mailer->setSender($sender);
			
// 			//$recipient = 'bim@myk.gov.tr';
// 			$mailer->addRecipient($recipient);
			
// 			$mailer->setSubject($data[0]['KURULUS_ADI'].' Sınav Programı Bildirildi.');
// 			$mailer->setBody($aciklamaText.'  http://portal.myk.gov.tr/index.php?option=com_belgelendirme&view=belge_olusturma&layout=gelecek_sinavlar');
			
// 			$send =& $mailer->Send();
			return true;
		}
		
	}
	
	function ProgramIlKaydet($post){
		$_db = JFactory::getOracleDBO ();
	
		$id = $post['id'];
		$il = $post['ilId'];
	
		$sql = "UPDATE M_BELGELENDIRME_SINAV SET SINAV_ILI = ? WHERE SINAV_ID = ?";
		$params = array($il,$id);
	
		return $_db->prep_exec_insert($sql, $params);
	}
	
	function ProgramSil($post){
		$_db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
		
		$user_id = $user->getOracleUserId ();
		
		$id = $post['id'];
		$adaySil = $post['adaySil'];
		
		$sql="SELECT * FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID=? AND KURULUS_ID=?";
		$data = $_db->prep_exec($sql, array($id,$user_id));
		if(count($data)>0){
			$returns = array();
			if($adaySil == 1){
// 				$sql = "DELETE FROM M_BELGELENDIRME_SINAV WHERE
//     			SINAV_ID = ?";
				$sql = "UPDATE M_BELGELENDIRME_SINAV SET GECERLILIK_DURUMU = 2 WHERE SINAV_ID = ?";
				
// 				if($_db->prep_exec_insert($sql, array($id))){
				if($_db->prep_exec_insert($sql, array($id))){
					$returns[] = 1;
				}
				$sql = "DELETE FROM M_BELGELENDIRME_ADAY_BILDIRIM WHERE
    			SINAV_ID = ?";
				if($_db->prep_exec_insert($sql, array($id))){
					$returns[] = 1;
				}
				
				if(count($returns) == 2){
					return true;
				}
				else{
					return false;
				}
			}
			else{
// 				$sql = "DELETE FROM M_BELGELENDIRME_SINAV WHERE
//     			SINAV_ID = ?";
					
// 				return $_db->prep_exec_insert($sql, array($id));

				$sql = "UPDATE M_BELGELENDIRME_SINAV SET GECERLILIK_DURUMU = 2 WHERE SINAV_ID = ?";
				return $_db->prep_exec_insert($sql, array($id));
			}	
		}
		else{
			return false;
		}
		
		
	}
	
	function SinavYeriKaydet($post){
		$_db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
	
		$user_id = $user->getOracleUserId ();
		$yeterlilik_id = $post['yets'];
		$yerAd = $post['yerAd'];
		$adress = $post['adress'];
		$temin = $post['temin'];
		$yerId = $_db->getNextVal('SEQ_SINAVYERI');
		
		$sql = "INSERT INTO M_BELGELENDIRME_SINAV_YERI (SINAV_YERI_ID,KURULUS_ID,YER_ADI,ADRES,TEMIN_DURUMU,YETERLILIK_ID,BILDIRIM_DURUMU)
				VALUES (?,?,?,?,?,?,1)";
		
		$hata = 0;
		foreach ($yeterlilik_id as $row){
			$params = array(
					$yerId,$user_id,$yerAd,$adress,$temin,$row
			);
			
			if(!$_db->prep_exec_insert($sql, $params)){
				$hata++;
			}
		}
		
		if($hata>0){
			$sqlDel = "DELETE FROM M_BELGELENDIRME_SINAV_YERI WHERE SINAV_YERI_ID=?";
			$_db->prep_exec($sql, array($yerId));
			return 'Sınav Merkezi ekleme işlemi bir hata nedeniyle başarısız olmuştur. Tekrar deneyin.';
		}
		else{
			return 'Sınav Merkezi ekleme işlemi başarılı olmuştur.';
		}
	
		
	}
	
	function sinavYeriNotYets($post){
		$_db = JFactory::getOracleDBO();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		$yerId = $post['yerId'];
		$yeterlilik = $this->getYeterlilik($user_id);
		
		$sql = "SELECT YETERLILIK_ID FROM M_BELGELENDIRME_SINAV_YERI WHERE SINAV_YERI_ID = ?";
		$data = $_db->prep_exec_array($sql, array($yerId));
		
		$yets = array();
		foreach($yeterlilik as $row){
			if(!in_array($row['YETERLILIK_ID'], $data)){
				$yets[] = $row;
			}
		}
		
		if(count($yets)>0){
			return $yets;
		}
		else{
			return false;
		}
	}
	
	function SinavYeriUpdate($post){
		$_db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
	
		$user_id = $user->getOracleUserId ();
		$yeterlilik_id = $post['yets'];
		$yerId = $post['yerId'];
		
		$sqlYer = "SELECT * FROM M_BELGELENDIRME_SINAV_YERI WHERE SINAV_YERI_ID = ? AND ROWNUM = 1";
		
		$data = $_db->prep_exec($sqlYer, array($yerId));
	
		$sql = "INSERT INTO M_BELGELENDIRME_SINAV_YERI (SINAV_YERI_ID,KURULUS_ID,YER_ADI,ADRES,TEMIN_DURUMU,YETERLILIK_ID,BILDIRIM_DURUMU)
				VALUES (?,?,?,?,?,?,1)";
	
		$hata = 0;
		foreach ($yeterlilik_id as $row){
			$params = array(
					$yerId,$user_id,$data[0]['YER_ADI'],$data[0]['ADRES'],$data[0]['TEMIN_DURUMU'],$row
			);
				
			if(!$_db->prep_exec_insert($sql, $params)){
				$hata++;
			}
		}
	
		if($hata>0){
			$sqlDel = "DELETE FROM M_BELGELENDIRME_SINAV_YERI WHERE SINAV_YERI_ID=?";
			$_db->prep_exec($sql, array($yerId));
			return 'Sınav Merkezi ekleme işlemi bir hata nedeniyle başarısız olmuştur. Tekrar deneyin.';
		}
		else{
			return 'Sınav Merkezine yeterlilik ekleme işlemi başarılı olmuştur.';
		}
	
	
	}
	
	function sinavYeriBildirimIptal($post){
		$_db = JFactory::getOracleDBO ();
		
		$yerId = $post['yerId'];
		$yetId = $post['yetId'];
		
		$sql="UPDATE M_BELGELENDIRME_SINAV_YERI SET BILDIRIM_DURUMU = 0 WHERE SINAV_YERI_ID = ? AND YETERLILIK_ID=?";
		if($_db->prep_exec_insert($sql, array($yerId,$yetId))){
			return true;
		}else{
			return false;
		}
	}
	
	function sinavYeriBildirim($post){
		$_db = JFactory::getOracleDBO ();
	
		$yerId = $post['yerId'];
		$yetId = $post['yetId'];
	
		$sql="UPDATE M_BELGELENDIRME_SINAV_YERI SET BILDIRIM_DURUMU = 1 WHERE SINAV_YERI_ID = ? AND YETERLILIK_ID=?";
		if($_db->prep_exec_insert($sql, array($yerId,$yetId))){
			return true;
		}else{
			return false;
		}
	}
	
	function getProgramSinavYeri($user_id){
		$_db = JFactory::getOracleDBO ();
	
		$sqlYerId = "SELECT SINAV_YERI_ID FROM M_BELGELENDIRME_SINAV_YERI WHERE KURULUS_ID = ? ORDER BY OLUSTURMA_TARIHI ASC, BILDIRIM_DURUMU ASC";
		$data = $_db->prep_exec($sqlYerId, array($user_id));

		$yers = array();
		foreach ($data as $row){
			$sql = "SELECT M_BELGELENDIRME_SINAV_YERI.*, M_YETERLILIK.*,
					M_YETERLILIK_REVIZYON.REVIZYON_NO,M_YETERLILIK_REVIZYON.YETERLILIK_KODU AS YETERLILIK_REV_KOD
					FROM M_BELGELENDIRME_SINAV_YERI
				JOIN M_YETERLILIK ON M_BELGELENDIRME_SINAV_YERI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
				LEFT JOIN M_YETERLILIK_REVIZYON ON M_YETERLILIK.YETERLILIK_ID = M_YETERLILIK_REVIZYON.YETERLILIK_ID
				WHERE M_BELGELENDIRME_SINAV_YERI.SINAV_YERI_ID=?  ORDER BY M_BELGELENDIRME_SINAV_YERI.BILDIRIM_DURUMU DESC, M_YETERLILIK.YETERLILIK_KODU ASC,M_YETERLILIK.YETERLILIK_ADI ASC ";
			$param = array($row['SINAV_YERI_ID']);
			
			$yers[$row['SINAV_YERI_ID']] = $_db->prep_exec($sql, $param);
		}
		
		return $yers;
	}

	function sinavKurulusKontrol($sinav_id, $user_id) {
		$_db = JFactory::getOracleDBO ();
		$sql="select * from m_belgelendirme_sinav where sinav_id=? and kurulus_id=?";
		$param = array($sinav_id,$user_id);
		
		return $_db->prep_exec($sql, $param);
	}
	
	function sinavTarihKontrol($sinav_id) {
		$_db = JFactory::getOracleDBO ();
		$sql="select * from m_belgelendirme_sinav where sinav_id=?";
		$param = array($sinav_id);
		$cow=$_db->prep_exec($sql, $param);
		$datecon = date('d-m-Y',mktime(0,0,0,date("m"),date("d")+2,date("Y")));
		$basdate = str_replace('/','-',$cow[0]['BASLANGIC_TARIHI']);
		if(strtotime($datecon) <= strtotime($basdate)){
			return true;
		} else {
			return false;
		}
	}
	
	function sinavYeriKontrol($kurulus_id,$yeterlilik_id) {
		$_db = JFactory::getOracleDBO ();
		$sql="select sinav_yeri_id from m_belgelendirme_sinav_yeri where kurulus_id=? and yeterlilik_id=? and bildirim_durumu=1";
		$param = array($kurulus_id,$yeterlilik_id);
		return $_db->prep_exec_array($sql, $param);		
	}
	
	function sinavDegerlendiriciKontrol($kurulus_id,$yeterlilik_id) {
		$_db = JFactory::getOracleDBO ();
		$sql="select tc_kimlik from m_belgelendirme_dgrlndrc_krls where kurulus_id=? and yeterlilik_id=? and etkin=1";
		$param = array($kurulus_id,$yeterlilik_id);
		return $_db->prep_exec_array($sql, $param);
	}
	
	function getSinavTarihi($sinav_id) {
		$_db = JFactory::getOracleDBO ();
		$sql="select * from m_belgelendirme_sinav where sinav_id=?";
		$param = array($sinav_id);
		$cow=$_db->prep_exec($sql, $param);
		//$basdate =strtotime();
			return ereg_replace("/","-",$cow[0]['BASLANGIC_TARIHI']);
		}
	
	
	function getAdayExcel ($post, $get, $files, $canEdit){
		$_db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
		if($canEdit){
			$sqlKurs = "SELECT KURULUS_ID FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID = ?";
			$kurs = $_db->prep_exec($sqlKurs, array($_GET['sinav']));
			$user_id = $kurs[0]['KURULUS_ID'];
		}else{		
			$user_id = $user->getOracleUserId ();
		}

		if($post['bildirim'] == 2){
			$sql = "DELETE FROM M_BELGELENDIRME_ADAY_BILDIRIM WHERE SINAV_ID=?";
			$_db->prep_exec_insert($sql, array($get['sinav']));
			
			$sql = "DELETE FROM M_BELGELENDIRME_SINAV_DOSYA WHERE SINAV_ID=?";
			$_db->prep_exec_insert($sql, array($get['sinav']));
		}
		
		if($files['upload']['size'] > 0){
			if($files['upload']['type'] == 'application/vnd.ms-excel'){
				$objPHPExcel = PHPExcel_IOFactory::load($files['upload']['tmp_name']);
		
			}
			else if($files['upload']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $files['upload']['type'] == "application/octet-stream"){
				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$objReader->setReadDataOnly(true);
		
				$objPHPExcel = $objReader->load($files['upload']['tmp_name']);
			}
			else{
				print 'dosya formatı yanlış';
				exit();
			}
		
		
			$objWorksheet = $objPHPExcel->getActiveSheet();
		
			$highestRow = $objWorksheet->getHighestRow();
//			if ($highestRow>400){
//				$highestRow=400;
//			}
			$highestColumn = $objWorksheet->getHighestColumn();
		
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			$data = array();
			for ($col = 0; $col <= $highestColumnIndex-1; ++$col) {
				$key[] = $objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
			}
			
			$bossatir = 0;
			for ($row = 4; $row <= $highestRow; ++$row) {
		
				for ($col = 0; $col <= $highestColumnIndex-1; ++$col) {
				
					if ($key[$col]=="dogumtarihi"){
						if($objWorksheet->getCellByColumnAndRow($col, $row)->getValue() != ''){
							$timestamp = trim($objWorksheet->getCellByColumnAndRow($col, $row)->getValue());
							$mysqlDate = date('d/m/Y',strtotime('1899-12-31+'.($timestamp-1).' days'));
							if(strpos($timestamp, ".") || strpos($timestamp, "/")){
								$data[$row][$key[$col]] = str_replace('.', '/', $timestamp);
							}else{
								$data[$row][$key[$col]] = $mysqlDate;
							}
							//$mysqlDate = date('d/m/Y',strtotime($timestamp));
							//$data[$row][$key[$col]] = $mysqlDate;
						}
					} 
					else if ($key[$col]=="sinavtarihi"){
						if($objWorksheet->getCellByColumnAndRow($col, $row)->getValue() != ''){
							$timestamp = trim($objWorksheet->getCellByColumnAndRow($col, $row)->getValue());
							$mysqlDate = date('d/m/Y',strtotime('1899-12-31+'.($timestamp-1).' days'));
							if(strpos($timestamp, ".") || strpos($timestamp, "/")){
								$data[$row][$key[$col]] = str_replace('.', '/', $timestamp);
							}else{
								$data[$row][$key[$col]] = $mysqlDate;
							}
							//$mysqlDate = date('d/m/Y',strtotime($timestamp));
							//$data[$row][$key[$col]] = $mysqlDate;
						}
					}
					else if($key[$col]=="sinavsaati"){
						if($objWorksheet->getCellByColumnAndRow($col, $row)->getValue() != ''){
							//$timestamp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() ;
							$mysqlDate = PHPExcel_Style_NumberFormat::toFormattedString(trim($objWorksheet->getCellByColumnAndRow($col, $row)->getCalculatedValue()), 'hh:mm');
							$data[$row][$key[$col]] = $mysqlDate;
						}
					}
					else if($key[$col]=="tckn" && $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() == ''){
						$bossatir++;
						break;
					}
					else {
						if($objWorksheet->getCellByColumnAndRow($col, $row)->getValue() != '' ){
							$data[$row][$key[$col]] = trim($objWorksheet->getCellByColumnAndRow($col, $row)->getValue());
						}
					}
				}
				if($bossatir>0){
					break;
				}
			}
			
			
			$sql= "select yeterlilik_id from m_belgelendirme_sinav where sinav_id=".$get["sinav"];
			$yeterlilik_id=$_db->prep_exec($sql, array());
			$yeterlilik_id=$yeterlilik_id[0]["YETERLILIK_ID"];
			
			$sql= "select yeni_mi from m_yeterlilik where yeterlilik_id=".$yeterlilik_id;
			$yeni_mi=$_db->prep_exec($sql, array());
			$yeni_mi=$yeni_mi[0]["YENI_MI"];
			
			$yeterlilik=array();
			
			if ($yeni_mi=="1"){
				$sql= "select birim_id, birim_kodu from m_birim join M_YETERLILIK_BIRIM using (birim_id)  where yeterlilik_id=".$yeterlilik_id;
				$birimler=$_db->prep_exec($sql, array());
				
				foreach ($birimler as $row){
					$sql="select OLC_DEG_HARF, OLC_DEG_NUMARA from M_BIRIM_OLCME_DEGERLENDIRME where BIRIM_ID=".$row["BIRIM_ID"];
					$sinav_kodlari=$_db->prep_exec($sql, array());
					foreach ($sinav_kodlari as $row2){
						if ($row2["OLC_DEG_HARF"]!="D"){
							$yeterlilik[]=array("ID"=>$row["BIRIM_ID"],"KODU"=>$row["BIRIM_KODU"],"TUR"=>$row2["OLC_DEG_HARF"].$row2["OLC_DEG_NUMARA"]);
						}
					}
				}
				
			} else {
				$sql="select yeterlilik_alt_birim_id as birim_id,yeterlilik_alt_birim_no as birim_kodu, yeterlilik_kodu from m_yeterlilik_alt_birim join m_yeterlilik using(yeterlilik_id) where yeterlilik_id=".$yeterlilik_id;
				$birimler=$_db->prep_exec($sql, array());
				
				foreach ($birimler as $row){
					$sql="select TUR_KODU from M_YETERLILIK_ALT_BIRIM_TUR WHERE BIRIM_ID=".$row["BIRIM_ID"];
					$sinav_kodlari=$_db->prep_exec($sql, array());
					foreach ($sinav_kodlari as $row2){
							$yeterlilik[]=array("ID"=>$row["BIRIM_ID"],"KODU"=>$row["YETERLILIK_KODU"].'/'.$row["BIRIM_KODU"],"TUR"=>$row2["TUR_KODU"]);
					}
				}
// 				foreach ($birimler as $row){
// 					$yeterlilik[]=array("ID"=>$row["BIRIM_ID"],"KODU"=>$row["YETERLILIK_KODU"].'/'.$row["BIRIM_KODU"],"TUR"=>"T1");
// 					$yeterlilik[]=array("ID"=>$row["BIRIM_ID"],"KODU"=>$row["YETERLILIK_KODU"].'/'.$row["BIRIM_KODU"],"TUR"=>"P1");
// 				}
			}
			
			$sinavTarihi = $this->getSinavTarihi($get['sinav']);
			$sinavYerleri= $this->sinavYeriKontrol($user_id,$yeterlilik_id);
			$degerlendiriciler=$this->sinavDegerlendiriciKontrol($user_id, $yeterlilik_id);
			
			$return=array();
			foreach ($data as $key=>$satir){	
				if (!$satir['tckn'][0]){
					$satir['tckn']=strval($satir['tckn']);
				}
				
				if($satir['uyruk'] == 'T.C.'){
					$uyruk = 0;
					$tckontrol = $this->tckimlik($satir['tckn']);
				}else if($satir['uyruk'] == 'Diğer'){
					$uyruk = 1;
					$tckontrol = true;
				}
				else{
					return $return["hataMesaji"][1]="Aşağıdaki TC Kimlik Numaraları hatalıdır. Lütfen kontrol edip dosyanızı tekrar yükleyiniz.";
				}
////////////// TC KIMLIK NO KURALLARA UYGUN MU KONTROLÜ ///////////////			
				if ($tckontrol===FALSE){
					$return['hatalıTckimlik'][] = array($key,$satir['tckn']);	
					$return["hataMesaji"][1]="Aşağıdaki TC Kimlik Numaraları hatalıdır. Lütfen kontrol edip dosyanızı tekrar yükleyiniz.";
				} else {

////////////// EXCEL'DEN GELEN KULLANICILAR DB DE KAITLI MI DEĞİL Mİ? HATA VAR MI YOK MU KONRTROLÜ ///////////////
				

				$sql = "SELECT* FROM M_BELGELENDIRME_OGRENCI WHERE TC_KIMLIK=? AND UYRUK = ?";
				$kayitliaday = $_db->prep_exec($sql, array($satir['tckn'],$uyruk));
				
                $cinsiyeti = FormFactory::toUpperCase($satir['cinsiyeti']);
				if($cinsiyeti == 'ERKEK'){
					$Cins=1;
				} else if($cinsiyeti == 'KADIN'){
					$Cins=2;
				} else if($cinsiyeti == 'BELİRTİLMEMİŞ'){
					$Cins=3;
				}else{
					$return['hataliCins'][] = array($key);
					$return["hataMesaji"][10]="Lütfen Aşağıdaki Satırlardaki Cinsiyet Bilgilerini Düzeltiniz. (Excel Dosyasında Yer Alan Cinsiyet Bilgilerinden Seçiniz)";
				}
				
				$egitimm = FormFactory::toUpperCase(trim(str_replace(' ', '',$satir['egitimi'])));
				if($egitimm == 'OKURYAZARDEĞİL'){
					$egitimi = 1;	
				} else if($egitimm == 'OKURYAZAR'){
					$egitimi = 2;
				} else if($egitimm == 'İLKOKUL'){
					$egitimi = 3;
				} else if($egitimm == 'ORTAOKUL'){
					$egitimi = 4;
				} else if($egitimm == 'MESLEKLİSESİ'){
					$egitimi = 5;
				} else if($egitimm == 'GENELLİSE'){
					$egitimi = 6;
				} else if($egitimm == 'MESLEKYÜKSEKOKULU'){
					$egitimi = 7;
				} else if($egitimm == 'LİSANS'){
					$egitimi = 8;
				} else if($egitimm == 'YÜKSEKLİSANS'){
					$egitimi = 9;
				} else if($egitimm == 'DOKTORA'){
					$egitimi = 10;
				} else{
					$return['hataliEgitim'][] = array($key);
					$return["hataMesaji"][10]="Lütfen Aşağıdaki Satırlardaki Eğitim Bilgilerini Düzeltiniz. (Excel Dosyasında Yer Alan Eğitim Bilgilerinden Seçiniz)";
				} 
				
                $calisDurum = FormFactory::toUpperCase(trim(str_replace(' ', '',$satir['calismadurumu'])));
				if($calisDurum == 'ÇALIŞIYOR'){
					$calismaDurum = 1;	
				} else if($calisDurum == 'ÇALIŞMIYOR'){
					$calismaDurum = 2;
				} else if($calisDurum == 'STAJYAPIYOR'){
					$calismaDurum = 3;
				}else{
					$return['hataliCalisma'][] = array($key);
					$return["hataMesaji"][10]="Lütfen Aşağıdaki Satırlardaki Çalışma Bilgilerini Düzeltiniz. (Excel Dosyasında Yer Alan Çalışma Bilgilerinden Seçiniz)";
				}
				
				if(array_key_exists('hataliCalisma', $return) || array_key_exists('hataliEgitim',$return) || array_key_exists('hataliCins',$return)){
					return $return;
				}
				
				if(count($kayitliaday)>0){
// 					if($kayitliaday[0]['ADI'] != trim(FormFactory::ucWordsTR($satir['adi'])) || $kayitliaday[0]['SOYADI'] != trim(FormFactory::toUpperCase($satir['soyadi'])) || $kayitliaday[0]['DOGUM_TARIHI'] != trim($satir['dogumtarihi']) || $kayitliaday[0]['DOGUM_YERI'] != trim(FormFactory::ucWordsTR($satir['dogumyeri'])) || $kayitliaday[0]['BABA_ADI'] != trim(FormFactory::ucWordsTR($satir['babaadi'])) || $kayitliaday[0]['CINSIYETI'] != $Cins || $kayitliaday[0]['EGITIMI'] != $egitimi || $kayitliaday[0]['CALISMA_DURUMU'] != $calismaDurum){
					if($kayitliaday[0]['ADI'] != trim(FormFactory::ucWordsTR($satir['adi'])) || $kayitliaday[0]['SOYADI'] != trim(FormFactory::toUpperCase($satir['soyadi'])) || $kayitliaday[0]['DOGUM_TARIHI'] != trim($satir['dogumtarihi']) || $kayitliaday[0]['CINSIYETI'] != $Cins || $kayitliaday[0]['EGITIMI'] != $egitimi || $kayitliaday[0]['CALISMA_DURUMU'] != $calismaDurum){
						$return['tckimlik'][] = array($key,$satir['tckn']);
						$return["hataMesaji"][2]="Aşağıda TC Kimlik numaraları verilen kişilerin gönderdiğiniz bilgileri ile sistemde kayıtlı bilgiler farklılık göstermektedir. Sistemdeki bilgileri güncel ise dosyanızı güncelleyiniz, dosyanızdaki verileriniz güncel ise lütfen önce sistemdeki verileri düzenleyiniz ve dosyanızı tekrar yükleyiniz.";		
					}
					
				} else {
					$params = array(
							$satir['tckn'],
							FormFactory::ucWordsTR($satir['adi']),
							FormFactory::toUpperCase($satir['soyadi']),
							$satir['dogumtarihi'],							
							$Cins,
							$egitimi,
							$calismaDurum,
							$user_id,
							$uyruk
					);
					
					$sql = "INSERT INTO M_BELGELENDIRME_OGRENCI
						(TC_KIMLIK, ADI, SOYADI, DOGUM_TARIHI, DOGUM_YERI, BABA_ADI, CINSIYETI, EGITIMI, CALISMA_DURUMU,SON_DUZENLEYEN_KURULUS_ID,UYRUK)
						VALUES(?,?,?,TO_DATE(?, 'dd.mm.yyyy'),null,null,?,?,?,?,?)";
					
					$ogr = $_db->prep_exec_insert($sql, $params);
				}
				
				}
				
				////////////// EXCEL'DEN GELEN BIRIMLERIN VE SINAV TURLERININ KONRTROLÜ ///////////////	
				$hatayok=false;
				foreach ($yeterlilik as $yetrow){
					if (ucwords(trim(str_replace(' ', '',$yetrow['KODU']))) == ucwords(trim(str_replace(' ', '',$satir["birimkodu"]))) and ucwords(trim(str_replace(' ', '',$yetrow['TUR']))) == ucwords(trim(str_replace(' ', '',$satir["sinavturukodu"])))){					
						$hatayok=true;
					}	
				}
				if (!$hatayok){
					$return["hataMesaji"][3]="Aşağıdaki satırlarda Birim Kodu veya Sınav türü kodu hatalıdır ya da yeterliliğe ait değildir. Hataları giderip tekrar dosyayı yükleyiniz.";
					$return["sinavTuruKoduSatir"][]=$key;
				}
				
				////////////// EXCEL'DEN GELEN SINAV TARİHİ KONTROLÜ ///////////////
				if(!$canEdit){
					if (strtotime($sinavTarihi)>strtotime(ereg_replace("/","-",$satir["sinavtarihi"]))){
						$return["hataMesaji"][4]="Aşağıdaki satırlarda verilen Sınav Tarihleri, Sınav Programınızda belirttiğiniz Başlangıç Tarihinden (".$sinavTarihi.") öncedir. Düzeltip dosyanızı yeniden yükleyiniz.";
						$return["sinavTarihi"][]=array($key,$satir["sinavtarihi"]);
					}
				}
				
				////////////// EXCEL'DEN GELEN SINAV TARİHİ 360 GÜN KONTROLÜ ///////////////
				
				if (strtotime('+360 days',strtotime($sinavTarihi))<strtotime(ereg_replace("/","-",$satir["sinavtarihi"]))){
					$return["hataMesaji"][9]="Aşağıdaki satırlarda verilen Sınav Tarihleri, Sınav Programınızda belirttiğiniz Başlangıç Tarihinden (".$sinavTarihi.") 1 yıl içinde olmalıdır. Düzeltip dosyanızı yeniden yükleyiniz.";
					$return["sinavTarihi360"][]=array($key,$satir["sinavtarihi"]);
				}
				
				////////////// EXCEL'DEN GELEN SINAV YERİ KONTROLÜ ///////////////
				
				if (!in_array($satir["sinavyeri"], $sinavYerleri)){
					$return["hataMesaji"][5]="Aşağıdaki satırlarda Verdiğiniz Sınav Yeri ID'leri, <a href='index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_sinav_yeri'  style='color:red;'>Sınav Yerleriniz</a> arasında yoktur yada Aktif halde değildir. Düzeltip dosyanızı yeniden yükleyiniz.";
					$return["sinavYeri"][]=array($key,$satir["sinavyeri"]);
				}
				
				////////////// EXCEL'DEN GELEN DEĞERLENDİRİCİLERİN KONTROLÜ ///////////////
				$degTcKimliks=explode(",",trim(str_replace(' ', '',$satir["degerlendirici"])));
				foreach ($degTcKimliks as $degTcKimlik){
					if (!in_array(trim($degTcKimlik), $degerlendiriciler)){
						$return["hataMesaji"][6]="Aşağıdaki satırlarda verdiğiniz Değerlendirici/Gözetmen'ler, <a href='index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_degerlendirici' style='color:red;'>Değerlendiriciler</a> arasında yoktur yada Aktif halde değildir. Düzeltip dosyanızı yeniden yükleyiniz.";
						$return["degerlendirici"][]=array($key,$degTcKimlik);
					}
				}
	
			}
                        if(count($return)>0){
                            return $return;
                        }
			$i=0;
			foreach ($data as $key=>$satir){
				foreach ($yeterlilik as $yetrow){
					if (ucwords(trim(str_replace(' ', '',$yetrow['KODU']))) == ucwords(trim(str_replace(' ', '',$satir["birimkodu"])))){
						$birimId=$yetrow['ID'];
						
					}
				}
				$param = array(
						$satir["tckn"],
						$get['sinav'],
						$birimId,
						$satir["sinavturukodu"],
				);
				$sql="SELECT * FROM M_BELGELENDIRME_ADAY_BILDIRIM 
						WHERE TC_KIMLIK=? AND SINAV_ID=? AND BIRIM_ID=? AND SINAV_TURU_KODU=?";
				
				if($_db->prep_exec($sql, $param)){					
					$return["hataMesaji"][7]="Aşağıdaki satırlardaki adayın bu sınavda aynı birim ve aynı sınav türü ile kaydı bulunmaktadır. Bu dosyadaki hiç bir veri kaydedilmemiştir. Düzeltip dosyanızı yeniden yükleyiniz.";
					$return["mukerrer"][]=$key;
				}
				
				$sql = "INSERT INTO M_BELGELENDIRME_ADAY_BILDIRIM (TC_KIMLIK,SINAV_ID,BIRIM_ID,SINAV_TURU_KODU,SINAV_TARIHI,SINAV_SAATI,SINAV_YERI_ID,DEGERLENDIRICI_TC_KIMLIK,YETERLILIK_ID,KURULUS_ID)
						VALUES(?,?,?,?,TO_DATE(?, 'dd.mm.yyyy'),?,?,?,?,?)";
				$param = array(
						$satir["tckn"],
						$get['sinav'],
						$birimId,
						ucwords(trim(str_replace(' ', '',$satir["sinavturukodu"]))),
						$satir["sinavtarihi"],
						$satir["sinavsaati"],
						$satir["sinavyeri"],
						$satir["degerlendirici"],
						$yeterlilik_id,
						$user_id
				);
				$kayit=$_db->prep_exec_insert($sql, $param);
				if ($kayit){
					$i++;
				}
			}
			
			if ($i==0){
				$return["hataMesaji"][8]="Dosyada boş ya da hatalıdır Kontrol edip tekrar yükleyiniz..";				
			}
			
			if (count($return)>0){
				$sql = "DELETE FROM M_BELGELENDIRME_ADAY_BILDIRIM WHERE SINAV_ID=? AND PAKET_ID=-1";
				$_db->prep_exec_insert($sql, array($get['sinav']));
				return $return;
				
			}
			
			

			$paket_id = $_db->getNextVal('SEQ_SINAV_DOSYA');
			
			$sql="INSERT INTO M_BELGELENDIRME_SINAV_DOSYA (PAKET_ID,SINAV_ID) VALUES(?,?)";
			$_db->prep_exec_insert($sql, array($paket_id,$get['sinav']));
			
			$sql = "UPDATE M_BELGELENDIRME_ADAY_BILDIRIM SET PAKET_ID = ? WHERE SINAV_ID=? AND PAKET_ID=-1";
			$_db->prep_exec_insert($sql, array($paket_id,$get['sinav']));
			
			move_uploaded_file($files['upload']['tmp_name'], EK_FOLDER."sinav_bildirimleri/".$user_id."_".$get["sinav"]."_".$paket_id.".xlsx");
			
			// Kaydetme işleminde sorun yoksa dosyayı m_belgelendirme_sinav_dosya'ya kaydet ve paket_id'yi al 
			// excel dosyasını [kuruluş_id]-[sınav_id]-[paket_id].xlsx ismiyle kaydet
			// sonra m_belgelendirme_aday_bildirimieki sinav idsi bizinm sınavımız ve paket_id si -1 olanları yeni paket id sini update et. 
		
		} else{
			$return["hataMesaji"]="Gönderdiğiniz dosya hatalı.";
			return $return;
		}
		
		
	}
	
	function tckimlik($tckimlik){
		
		$olmaz=array('11111111110','22222222220','33333333330','44444444440','55555555550','66666666660','7777777770','88888888880','99999999990');
		if($tckimlik[0]==0 or !ctype_digit($tckimlik) or strlen($tckimlik)!=11){ return false;  }
		else{
			for($a=0;$a<9;$a=$a+2){ $ilkt=$ilkt+$tckimlik[$a]; }
			for($a=1;$a<9;$a=$a+2){ $sont=$sont+$tckimlik[$a]; }
			for($a=0;$a<10;$a=$a+1){ $tumt=$tumt+$tckimlik[$a]; }
			if(($ilkt*7-$sont)%10!=$tckimlik[9] or $tumt%10!=$tckimlik[10]){ return false; }
			else{
				foreach($olmaz as $olurmu){ if($tckimlik==$olurmu){ return false; } }
				return true;
			}
		}
	}
	
	

	
	function tcKayitliAday($post){
		$_db = JFactory::getOracleDBO ();
		
		$tcNo = $post['tcno'];
		
		$sql = "SELECT * FROM M_BELGELENDIRME_OGRENCI WHERE TC_KIMLIK=?";
		
		$data = $_db->prep_exec($sql, array($tcNo)); 
		return $data;
	}
	
	function AdayUpdate($post){
		$_db = JFactory::getOracleDBO ();
		
		$user 	 = &JFactory::getUser ();
		
		$user_id = $user->getOracleUserId ();
		
		$tc = $post['tcno'];
		$ad = FormFactory::ucWordsTR($post['ad']);
		$soyad = FormFactory::toUpperCase($post['soyad']);
		$Dtarih = $post['dtarih'];
// 		$Dyer = $post['dyer'];
// 		$Bad = FormFactory::ucWordsTR($post['Bisim']);
		$cins = $post['cins'];
		$egitim = $post['egitim'];
		$Cdurum = $post['Cdurum'];
		
		$sql = "UPDATE M_BELGELENDIRME_OGRENCI 
				SET ADI=?, SOYADI=?, DOGUM_TARIHI=TO_DATE(?, 'dd.mm.yyyy'), CINSIYETI=?, EGITIMI=?, CALISMA_DURUMU=?, SON_DUZENLEYEN_KURULUS_ID=?
				WHERE TC_KIMLIK=?";
		
		$param = array(
				$ad,
				$soyad,
				$Dtarih,
				$cins,
				$egitim,
				$Cdurum,
				$user_id,
				$tc
		);
		return $_db->prep_exec_insert($sql, $param);
	}
	
	function geriAdayExcel($user_id=0,$sinav_id){
		$_db = JFactory::getOracleDBO ();
		
		$sql="SELECT PAKET_ID,TARIH,TIP FROM M_BELGELENDIRME_SINAV_DOSYA WHERE SINAV_ID=?";
		$data = $_db->prep_exec($sql, array($sinav_id));
		
			$sql = "SELECT KURULUS_ID FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID =?";
			$kurulus = $_db->prep_exec($sql, array($sinav_id));
			$user_id = $kurulus[0]['KURULUS_ID'];
		
		$veri = array();
		$say=0;
		foreach ($data as $cow){
                        $sql="SELECT COUNT(DISTINCT TC_KIMLIK) FROM M_BELGELENDIRME_ADAY_BILDIRIM WHERE PAKET_ID=?";
                        $paketCount = $_db->prep_exec_array($sql, array($cow["PAKET_ID"]));
                        if($cow["TIP"] == 1){
                            $veri['bildirim'][$say]['paket_Id'] = $cow["PAKET_ID"];
                            $veri['bildirim'][$say]['paket_Adi'] = $user_id.'_'.$sinav_id.'_'.$cow["PAKET_ID"].'.xlsx';
                            $veri['bildirim'][$say]['paket_Tarih']=$cow["TARIH"];
                            $veri['bildirim'][$say]['paket_Tip']=$cow["TIP"];
                            $veri['bildirim'][$say]['adayCount']=$paketCount[0];
                            $say++;
                        }
                        else{
                            $veri['sonuc'][$say]['paket_Id'] = $cow["PAKET_ID"];
                            $veri['sonuc'][$say]['paket_Adi'] = $user_id.'_'.$sinav_id.'_'.$cow["PAKET_ID"].'.xlsx';
                            $veri['sonuc'][$say]['paket_Tarih']=$cow["TARIH"];
                            $veri['sonuc'][$say]['paket_Tip']=$cow["TIP"];
                            $veri['sonuc'][$say]['adayCount']=$paketCount[0];
                            $say++;
                        }
                        
		}
		return $veri;
	}
	
	function getAdayVarmi($user_id){
		$_db = JFactory::getOracleDBO ();
		
		$sql = "SELECT DISTINCT SINAV_ID FROM M_BELGELENDIRME_ADAY_BILDIRIM 
				 JOIN M_BELGELENDIRME_SINAV USING(SINAV_ID) WHERE KURULUS_ID=?";
		
		$data = $_db->prep_exec_array($sql, array($user_id));
		return $data;
	}
	
	function sonucBildirExcel($post,$get,$files){
		$_db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		
		if($files['upload']['size'] > 0){
			if($files['upload']['type'] == 'application/vnd.ms-excel'){
				$objPHPExcel = PHPExcel_IOFactory::load($files['upload']['tmp_name']);
		
			}
			else if($files['upload']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){
				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$objReader->setReadDataOnly(true);
		
				$objPHPExcel = $objReader->load($files['upload']['tmp_name']);
			}
			else{
				print 'dosya formatı yanlış';
				exit();
			}
		
		
			$objWorksheet = $objPHPExcel->getActiveSheet();
		
			$highestRow = $objWorksheet->getHighestRow();
// 			if ($highestRow>400){
// 				$highestRow=400;
// 			}
			$highestColumn = $objWorksheet->getHighestColumn();
		
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			$data = array();
			for ($col = 0; $col <= $highestColumnIndex-1; ++$col) {
				$key[] = $objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
			}
		
			for ($row = 4; $row <= $highestRow; ++$row) {
		
				for ($col = 0; $col <= $highestColumnIndex-1; ++$col) {
		
					if ($key[$col]=="dogumtarihi"){
						if($objWorksheet->getCellByColumnAndRow($col, $row)->getValue() != ''){
							$timestamp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() ;
							$mysqlDate = date('d/m/Y',strtotime('1899-12-31+'.($timestamp-1).' days'));
							$data[$row][$key[$col]] = $mysqlDate;
						}
					}
					else if ($key[$col]=="sinavtarihi"){
						if($objWorksheet->getCellByColumnAndRow($col, $row)->getValue() != ''){
							$timestamp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() ;
							$mysqlDate = date('d/m/Y',strtotime('1899-12-31+'.($timestamp-1).' days'));
							$data[$row][$key[$col]] = $mysqlDate;
						}
					}
					else if($key[$col]=="sinavsaati"){
						if($objWorksheet->getCellByColumnAndRow($col, $row)->getValue() != ''){
							//$timestamp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() ;
							$mysqlDate = PHPExcel_Style_NumberFormat::toFormattedString($objWorksheet->getCellByColumnAndRow($col, $row)->getCalculatedValue(), 'hh:mm');
							$data[$row][$key[$col]] = $mysqlDate;
						}
					}
					else {
						if($objWorksheet->getCellByColumnAndRow($col, $row)->getValue() != '' ){
							$data[$row][$key[$col]] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
						}
					}
				}
			}
				
				
			$sql= "select yeterlilik_id from m_belgelendirme_sinav where sinav_id=".$get["sinav"];
			$yeterlilik_id=$_db->prep_exec($sql, array());
			$yeterlilik_id=$yeterlilik_id[0]["YETERLILIK_ID"];
				
			$sql= "select yeni_mi from m_yeterlilik where yeterlilik_id=".$yeterlilik_id;
			$yeni_mi=$_db->prep_exec($sql, array());
			$yeni_mi=$yeni_mi[0]["YENI_MI"];
				
			$yeterlilik=array();
				
			if ($yeni_mi=="1"){
				$sql= "select birim_id, birim_kodu from m_birim join M_YETERLILIK_BIRIM using (birim_id)  where yeterlilik_id=".$yeterlilik_id;
				$birimler=$_db->prep_exec($sql, array());
		
				foreach ($birimler as $row){
					$sql="select OLC_DEG_HARF, OLC_DEG_NUMARA from M_BIRIM_OLCME_DEGERLENDIRME where BIRIM_ID=".$row["BIRIM_ID"];
					$sinav_kodlari=$_db->prep_exec($sql, array());
					foreach ($sinav_kodlari as $row2){
						if ($row2["OLC_DEG_HARF"]!="D"){
							$yeterlilik[]=array("ID"=>$row["BIRIM_ID"],"KODU"=>$row["BIRIM_KODU"],"TUR"=>$row2["OLC_DEG_HARF"].$row2["OLC_DEG_NUMARA"]);
						}
					}
				}
		
			} else {
				$sql="select yeterlilik_alt_birim_id as birim_id,yeterlilik_alt_birim_no as birim_kodu from m_yeterlilik_alt_birim where yeterlilik_id=".$yeterlilik_id;
				$birimler=$_db->prep_exec($sql, array());
				foreach ($birimler as $row){
					$yeterlilik[]=array("ID"=>$row["BIRIM_ID"],"KODU"=>$row["BIRIM_KODU"],"TUR"=>"T1");
					$yeterlilik[]=array("ID"=>$row["BIRIM_ID"],"KODU"=>$row["BIRIM_KODU"],"TUR"=>"P1");
				}
			}
				
			$sinavTarihi = $this->getSinavTarihi($get['sinav']);
			$sinavYerleri= $this->sinavYeriKontrol($user_id);
			$degerlendiriciler=$this->sinavDegerlendiriciKontrol($user_id, $yeterlilik_id);

			$adaySonuc = array();
			$adayBirims = array();
			$return=array();
			foreach ($data as $key=>$satir){
				if (!$satir['tckn'][0]){
					$satir['tckn']=strval($satir['tckn']);
				}
		
				////////////// TC KIMLIK NO KURALLARA UYGUN MU KONTROLÜ ///////////////
				if ($this->tckimlik($satir['tckn'])===FALSE){
					$return['hatalıTckimlik'][] = array($key,$satir['tckn']);
					$return["hataMesaji"][1]="Aşağıdaki TC Kimlik Numaraları hatalıdır. Lütfen kontrol edip dosyanızı tekrar yükleyiniz.";
				} else {
		
					////////////// EXCEL'DEN GELEN KULLANICILAR DB DE KAYITLI MI DEĞİL Mİ? HATA VAR MI YOK MU KONRTROLÜ ///////////////
		
				if($yeni_mi==1){
					$sql = "SELECT DISTINCT M_BELGELENDIRME_OGRENCI.*,M_BELGELENDIRME_ADAY_BILDIRIM.*,M_BIRIM.BIRIM_KODU
								FROM M_BELGELENDIRME_OGRENCI
								JOIN M_BELGELENDIRME_ADAY_BILDIRIM ON M_BELGELENDIRME_OGRENCI.TC_KIMLIK = M_BELGELENDIRME_ADAY_BILDIRIM.TC_KIMLIK
								JOIN M_BIRIM ON M_BELGELENDIRME_ADAY_BILDIRIM.BIRIM_ID = M_BIRIM.BIRIM_ID
								WHERE M_BELGELENDIRME_OGRENCI.TC_KIMLIK = ? AND M_BELGELENDIRME_ADAY_BILDIRIM.SINAV_ID = ?";
				}
				else{
					$sql = "SELECT DISTINCT M_BELGELENDIRME_OGRENCI.*,M_BELGELENDIRME_ADAY_BILDIRIM.*,M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU
								FROM M_BELGELENDIRME_OGRENCI
								JOIN M_BELGELENDIRME_ADAY_BILDIRIM ON M_BELGELENDIRME_OGRENCI.TC_KIMLIK = M_BELGELENDIRME_ADAY_BILDIRIM.TC_KIMLIK
								JOIN M_YETERLILIK_ALT_BIRIM ON M_BELGELENDIRME_ADAY_BILDIRIM.BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
								WHERE M_BELGELENDIRME_OGRENCI.TC_KIMLIK = ? AND M_BELGELENDIRME_ADAY_BILDIRIM.SINAV_ID = ?";
				}
					$kayitliaday = $_db->prep_exec($sql, array($satir['tckn'],$get['sinav']));
		
					if(FormFactory::toUpperCase($satir['cinsiyeti']) == 'ERKEK'){
						$Cins=1;
					} else if(FormFactory::toUpperCase($satir['cinsiyeti']) == 'KADIN'){
						$Cins=2;
					} else if(FormFactory::toUpperCase($satir['cinsiyeti']) == 'BELİRTİLMEMİŞ'){
						$Cins=3;
					}
		
		
					if(FormFactory::toUpperCase(trim(str_replace(' ', '',$satir['egitimi']))) == 'OKURYAZARDEĞİL'){
						$egitimi = 1;
					} else if(FormFactory::toUpperCase(trim(str_replace(' ', '',$satir['egitimi']))) == 'OKURYAZAR'){
						$egitimi = 2;
					} else if(FormFactory::toUpperCase(trim(str_replace(' ', '',$satir['egitimi']))) == 'İLKOKUL'){
						$egitimi = 3;
					} else if(FormFactory::toUpperCase(trim(str_replace(' ', '',$satir['egitimi']))) == 'ORTAOKUL'){
						$egitimi = 4;
					} else if(FormFactory::toUpperCase(trim(str_replace(' ', '',$satir['egitimi']))) == 'MESLEKLİSESİ'){
						$egitimi = 5;
					} else if(FormFactory::toUpperCase(trim(str_replace(' ', '',$satir['egitimi']))) == 'GENELLİSE'){
						$egitimi = 6;
					} else if(FormFactory::toUpperCase(trim(str_replace(' ', '',$satir['egitimi']))) == 'MESLEKYÜKSEKOKULU'){
						$egitimi = 7;
					} else if(FormFactory::toUpperCase(trim(str_replace(' ', '',$satir['egitimi']))) == 'LİSANS'){
						$egitimi = 8;
					} else if(FormFactory::toUpperCase(trim(str_replace(' ', '',$satir['egitimi']))) == 'YÜKSEKLİSANS'){
						$egitimi = 9;
					} else if(FormFactory::toUpperCase(trim(str_replace(' ', '',$satir['egitimi']))) == 'DOKTORA'){
						$egitimi = 10;
					}
		
					if(FormFactory::toUpperCase(trim(str_replace(' ', '',$satir['calismadurumu']))) == 'ÇALIŞIYOR'){
						$calismaDurum = 1;
					} else if(FormFactory::toUpperCase(trim(str_replace(' ', '',$satir['calismadurumu']))) == 'ÇALIŞMIYOR'){
						$calismaDurum = 2;
					} else if(FormFactory::toUpperCase(trim(str_replace(' ', '',$satir['calismadurumu']))) == 'STAJYAPIYOR'){
						$calismaDurum = 3;
					}
		
					if(count($kayitliaday)>0){
						if($kayitliaday[0]['ADI'] != FormFactory::ucWordsTR($satir['adi']) || $kayitliaday[0]['SOYADI'] != FormFactory::toUpperCase($satir['soyadi']) || $kayitliaday[0]['DOGUM_TARIHI'] != $satir['dogumtarihi'] ||$kayitliaday[0]['DOGUM_YERI'] != FormFactory::ucWordsTR($satir['dogumyeri']) || $kayitliaday[0]['BABA_ADI'] != FormFactory::ucWordsTR($satir['babaadi']) || $kayitliaday[0]['CINSIYETI'] != $Cins || $kayitliaday[0]['EGITIMI'] != $egitimi || $kayitliaday[0]['CALISMA_DURUMU'] != $calismaDurum){
							$return['tckimlik'][] = array($key,$satir['tckn']);
							$return["hataMesaji"][2]="Sistemde Kayıtlı olan kişilerin bilgileri sizin tarafınızdan yüklenen dosyada hatalıdır. Lütfen aşağıda tckn.'ları olan kişileri kontrol ederek tekrar dosyayı yükleyiniz.";
								
						}
						
						////////////// EXCEL'DEN GELEN BIRIMLERIN VE SINAV TURLERININ KONRTROLÜ ///////////////
						
						if($kayitliaday[0]['BIRIM_KODU'] != $satir["birimkodu"] && $kayitliaday[0]['SINAV_TUR_KODU'] != $satir["sinavturukodu"]){
							$return["hataMesaji"][3]="Aşağıdaki satırlarda Birim Kodu veya Sınav türü kodu, aday bildiriminde yüklediğiz dosyadaki bilgilerden farklıdır. Hataları giderip tekrar dosyayı yükleyiniz.";
							$return["sinavTuruKoduSatir"][]=$key;
						}
						else{
							$adayBirims[$key] = array($kayitliaday[0]['BIRIM_ID'],$kayitliaday[0]['SINAV_TURU_KODU']);
						}
						
						////////////// EXCEL'DEN GELEN SINAV TARİHİ KONTROLÜ ///////////////
				
                                                if (strtotime($sinavTarihi)>strtotime(ereg_replace("/","-",$satir["sinavtarihi"]))){
                                                        $return["hataMesaji"][4]="Aşağıdaki satırlarda verilen Sınav Tarihleri, Sınav Programınızda belirttiğiniz Başlangıç Tarihinden (".$sinavTarihi.") öncedir. Düzeltip dosyanızı yeniden yükleyiniz.";
                                                        $return["sinavTarihi"][]=array($key,$satir["sinavtarihi"]);
                                                }

                                                ////////////// EXCEL'DEN GELEN SINAV TARİHİ 360 GÜN KONTROLÜ ///////////////

                                                if (strtotime('+360 days',strtotime($sinavTarihi))<strtotime(ereg_replace("/","-",$satir["sinavtarihi"]))){
                                                        $return["hataMesaji"][10]="Aşağıdaki satırlarda verilen Sınav Tarihleri, Sınav Programınızda belirttiğiniz Başlangıç Tarihinden (".$sinavTarihi.") 1 yıl içinde olmalıdır. Düzeltip dosyanızı yeniden yükleyiniz.";
                                                        $return["sinavTarihi360"][]=array($key,$satir["sinavtarihi"]);
                                                }
						
						////////////// EXCEL'DEN GELEN SINAV YERİ KONTROLÜ ///////////////
						
						if ($kayitliaday[0]['SINAV_YERI_ID'] != $satir["sinavyeri"]){
							$return["hataMesaji"][5]="Aşağıdaki satırlarda Verdiğiniz Sınav Yeri ID'leri, aday bildiriminde yüklediğiz dosyadaki bilgilerden farklıdır. Düzeltip dosyanızı yeniden yükleyiniz.";
							$return["sinavYeri"][]=array($key,$satir["sinavyeri"]);
						}
						
						////////////// EXCEL'DEN GELEN DEĞERLENDİRİCİLERİN KONTROLÜ ///////////////
						
						if ($kayitliaday[0]["DEGERLENDIRICI_TC_KIMLIK"] != $satir["degerlendirici"]){
							$return["hataMesaji"][6]="Aşağıdaki satırlarda verdiğiniz Değerlendirici'ler, aday bildiriminde yüklediğiz dosyadaki bilgilerden farklıdır. Düzeltip dosyanızı yeniden yükleyiniz.";
							$return["degerlendirici"][]=array($key,$satir["degerlendirici"]);
						}
						
						if($satir["sonuc"] == '' || empty($satir["sonuc"]) || !isset($satir["sonuc"])){
							$return["hataMesaji"][7]="Aşağıdaki satırlarda Sonuç bildirilmemiştir. Düzeltip dosyanızı yeniden yükleyiniz.";
							$return["sonuc"][]=$key;
						}
						else{
							$sonuc=0;
							if(FormFactory::toUpperCase($satir["sonuc"]) == 'BAŞARILI'){
								if($satir['puan'] == ''  || empty($satir["puan"]) || !isset($satir["puan"])){
									$return["hataMesaji"][8]="Aşağıdaki satırlarda Sonuç bildirilmesine rağmen Puan bildirilmemiştir. Düzeltip dosyanızı yeniden yükleyiniz.";
									$return["puan"][]=$key;
								}
								else{
									$adaySonuc[$key] = 1;
								}
							}
							else if(FormFactory::toUpperCase($satir["sonuc"]) == 'BAŞARISIZ'){
							if($satir['puan'] == ''  || empty($satir["puan"]) || !isset($satir["puan"])){
									$return["hataMesaji"][8]="Aşağıdaki satırlarda Sonuç bildirilmesine rağmen Puan bildirilmemiştir. Düzeltip dosyanızı yeniden yükleyiniz.";
									$return["puan"][]=$key;
								}
								else{
									$adaySonuc[$key]=2;
								}
							}
							else if(FormFactory::toUpperCase($satir["sonuc"]) == 'GİRMEDİ'){
								$adaySonuc[$key] = 3;
							}
						}
                                                
                       if(!empty($kayitliaday[0]['BASARI_DURUM']) || $kayitliaday[0]['BASARI_DURUM'] != ''){
                       		$return["hataMesaji"][11] = "Aşağıdaki satırlarda bilgileri yer alan adayların bu sınav için başarı durumları önceden bildirilmiştir. Bu adayları düzeltmek isterseniz MYK ile iletişime geçiniz.(Aşagıdaki linklerden adayların başarı durumlarını görebilirsiniz.)";
                       		$return["basDurum"][] = array($key,$satir['tckn'],$kayitliaday[0]['SINAV_ID']);
                      	}
						
					} else{
						// Kayıtlı değilse hata verdiriceksin
						$return["hataMesaji"][9] = "Aşağıdaki satırlarda bilgileri yer alan adaylar bu sınav için önceden bildirdiğiniz aday listesinde yer almamaktadır. Düzeltip dosyanızı tekrar yükleyiniz.";
						$return["tcknHata"][] = array($key,$satir['tckn']);
					}
		
				}
			}
			
			if(count($return)==0){
				foreach ($data as $key=>$satir){
					$sql = "UPDATE M_BELGELENDIRME_ADAY_BILDIRIM SET PUAN=?, BASARI_DURUMU = ? WHERE TC_KIMLIK = ? AND SINAV_ID=? AND BIRIM_ID=? AND SINAV_TURU_KODU=?";
					$param = array(
						$satir['puan'],
						$adaySonuc[$key],
						$satir['tckn'],
						$get['sinav'],
						$adayBirims[$key][0],
						$adayBirims[$key][1],
					);
					
					$durum = $_db->prep_exec_insert($sql, $param);
					
				}
				
				// ? paket_id'yi neye göre alıcaz.
				//unlink(EK_FOLDER."sinav_bildirimleri/".$user_id."_".$get["sinav"]."_".$paket_id.".xlsx");
				//move_uploaded_file($files['upload']['tmp_name'], EK_FOLDER."sinav_bildirimleri/".$user_id."_".$get["sinav"]."_".$paket_id.".xlsx");
			}
			else{
				return $return;
			}
// 			$i=0;
// 			foreach ($data as $key=>$satir){
// 				foreach ($yeterlilik as $yetrow){
// 					if ($yetrow['KODU'] != $satir["birimkodu"]){
// 						$birimId=$yetrow['ID'];
		
// 					}
// 				}
// 				$param = array(
// 						$satir["tckn"],
// 						$get['sinav'],
// 						$birimId,
// 						$satir["sinavturukodu"],
// 				);
// 				$sql="SELECT * FROM M_BELGELENDIRME_ADAY_BILDIRIM
// 						WHERE TC_KIMLIK=? AND SINAV_ID=? AND BIRIM_ID=? AND SINAV_TURU_KODU=?";
		
// 				if($_db->prep_exec($sql, $param)){
// 					$return["hataMesaji"][7]="Aşağıdaki satırlardaki adayın bu sınavda aynı birim ve aynı sınav türü ile kaydı bulunmaktadır. Bu dosyadaki hiç bir veri kaydedilmemiştir. Düzeltip dosyanızı yeniden yükleyiniz.";
// 					$return["mukerrer"][]=$key;
// 				}
		
// 				$sql = "INSERT INTO M_BELGELENDIRME_ADAY_BILDIRIM (TC_KIMLIK,SINAV_ID,BIRIM_ID,SINAV_TURU_KODU,SINAV_TARIHI,SINAV_SAATI,SINAV_YERI_ID,DEGERLENDIRICI_TC_KIMLIK)
// 						VALUES(?,?,?,?,TO_DATE(?, 'dd.mm.yyyy'),?,?,?)";
// 				$param = array(
// 						$satir["tckn"],
// 						$get['sinav'],
// 						$birimId,
// 						$satir["sinavturukodu"],
// 						$satir["sinavtarihi"],
// 						$satir["sinavsaati"],
// 						$satir["sinavyeri"],
// 						$satir["degerlendirici"]
// 				);
// 				$kayit=$_db->prep_exec_insert($sql, $param);
// 				if ($kayit){
// 					$i++;
// 				}
// 			}
				
// 			if ($i==0){
// 				$return["hataMesaji"][8]="Dosyada boş ya da hatalıdır Kontrol edip tekrar yükleyiniz..";
// 			}
				
// 			if (count($return)>0){
// 				$sql = "DELETE FROM M_BELGELENDIRME_ADAY_BILDIRIM WHERE SINAV_ID=? AND PAKET_ID=-1";
// 				$_db->prep_exec_insert($sql, array($get['sinav']));
// 				return $return;
		
// 			}
				
				
		
// 			$paket_id = $_db->getNextVal('SEQ_SINAV_DOSYA');
				
// 			$sql="INSERT INTO M_BELGELENDIRME_SINAV_DOSYA (PAKET_ID,SINAV_ID) VALUES(?,?)";
// 			$_db->prep_exec_insert($sql, array($paket_id,$get['sinav']));
				
// 			$sql = "UPDATE M_BELGELENDIRME_ADAY_BILDIRIM SET PAKET_ID = ? WHERE SINAV_ID=? AND PAKET_ID=-1";
// 			$_db->prep_exec_insert($sql, array($paket_id,$get['sinav']));
				
// 			move_uploaded_file($files['upload']['tmp_name'], EK_FOLDER."sinav_bildirimleri/".$user_id."_".$get["sinav"]."_".$paket_id.".xlsx");
				
			// Kaydetme işleminde sorun yoksa dosyayı m_belgelendirme_sinav_dosya'ya kaydet ve paket_id'yi al
			// excel dosyasını [kuruluş_id]-[sınav_id]-[paket_id].xlsx ismiyle kaydet
			// sonra m_belgelendirme_aday_bildirimieki sinav idsi bizinm sınavımız ve paket_id si -1 olanları yeni paket id sini update et.
		
		} else{
			$return["hataMesaji"]="Gönderdiğiniz dosya hatalı.";
			return $return;
		}
		
		
	}
	
	
    function getSonucExcel($post,$get,$files){
        $_db = JFactory::getOracleDBO ();
        $user 	 = &JFactory::getUser ();
        $user_id = $user->getOracleUserId ();
        

        /////// EKLENEN FILENAME BIZDE KAYITLIMI DEGILMI ////////////////////7
//        $filename = $files['upload']['name'];
//
//        $paktetBul = explode('_', $filename);
//        $paket_Id = explode('.',$paktetBul[2]);
        $paket_Id = $post['paketId'];

//        if(!file_exists(EK_FOLDER.'sinav_bildirimleri/'.$filename) || $paktetBul[0] != $user_id || $paktetBul[1] != $get['sinav']){
//                $return['hataMesaji'][1] = 'Sonuç bildirimi gönderdiğiniz dosya sistemimizde yer almamaktadır. Lütfen sistemden indirdiğiniz dosyanın adını değiştirmeden yollayınız.';
//                return $return;
//        }
        ////////////////////////////////////////////////////////////////////777

        if($files['upload']['size'] > 0){
            if($files['upload']['type'] == 'application/vnd.ms-excel'){
                    $objPHPExcel = PHPExcel_IOFactory::load($files['upload']['tmp_name']);

            }
            else if($files['upload']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $files['upload']['type'] == "application/octet-stream"){
                    $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                    $objReader->setReadDataOnly(true);

                    $objPHPExcel = $objReader->load($files['upload']['tmp_name']);
            }
            else{
                    print 'dosya formatı yanlış';
                    exit();
            }


            $objWorksheet = $objPHPExcel->getActiveSheet();

            $highestRow = $objWorksheet->getHighestRow();
//             if ($highestRow>400){
//                     $highestRow=400;
//             }
            $highestColumn = $objWorksheet->getHighestColumn();

            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = array();
            for ($col = 0; $col <= $highestColumnIndex-1; ++$col) {
                    $key[] = $objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
            }

            $keySql = array(
                            'TC_KIMLIK',
            				'UYRUK',
                            'ADI',
                            'SOYADI',
                            'DOGUM_TARIHI',
                            'CINSIYETI',
                            'EGITIMI',
                            'CALISMA_DURUMU',
                            'YETERLILIK_KODU',
                            'BIRIM_KODU',
                            'SINAV_TURU_KODU',
                            'SINAV_TARIHI',
                            'SINAV_SAATI',
                            'SINAV_YERI_ID',
                            'DEGERLENDIRICI_TC_KIMLIK',
                            'PUAN',
                            'BASARI_DURUMU'
            );

            $bossatir = 0;
            for ($row = 4; $row <= $highestRow; ++$row) {

                for ($col = 0; $col <= $highestColumnIndex-1; ++$col) {

                    if ($key[$col]=="dogumtarihi"){
                        if($objWorksheet->getCellByColumnAndRow($col, $row)->getValue() != ''){
//                                 $timestamp = trim($objWorksheet->getCellByColumnAndRow($col, $row)->getValue()) ;
//                                 $mysqlDate = date('d/m/Y',strtotime('1899-12-31+'.($timestamp-1).' days'));
//                                 $data[$row][$keySql[$col]] = $mysqlDate;
                                
                                $timestamp = trim($objWorksheet->getCellByColumnAndRow($col, $row)->getValue());
                                $mysqlDate = date('d/m/Y',strtotime('1899-12-31+'.($timestamp-1).' days'));
                                if(strpos($timestamp, ".") || strpos($timestamp, "/")){
                                	 $data[$row][$keySql[$col]] = str_replace('.', '/', $timestamp);
                                }else{
                                	 $data[$row][$keySql[$col]] = $mysqlDate;
                                }
                        }
                    }
                    else if ($key[$col]=="sinavtarihi"){
                        if($objWorksheet->getCellByColumnAndRow($col, $row)->getValue() != ''){
                        	
                        	$timestamp = trim($objWorksheet->getCellByColumnAndRow($col, $row)->getValue());
                        	$mysqlDate = date('d/m/Y',strtotime('1899-12-31+'.($timestamp-1).' days'));
                        	if(strpos($timestamp, ".") || strpos($timestamp, "/")){
                        		 $data[$row][$keySql[$col]] = str_replace('.', '/', $timestamp);
                        	}else{
                        		$data[$row][$keySql[$col]] = $mysqlDate;
                        	}
//                                 $timestamp = trim($objWorksheet->getCellByColumnAndRow($col, $row)->getValue()) ;
//                                 $mysqlDate = date('d/m/Y',strtotime('1899-12-31+'.($timestamp-1).' days'));
//                                 $data[$row][$keySql[$col]] = $mysqlDate;
                        }
                    }
                    else if($key[$col]=="sinavsaati"){
                        if($objWorksheet->getCellByColumnAndRow($col, $row)->getValue() != ''){
                                //$timestamp = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() ;
                                $mysqlDate = PHPExcel_Style_NumberFormat::toFormattedString(trim($objWorksheet->getCellByColumnAndRow($col, $row)->getCalculatedValue()), 'hh:mm');
                                $data[$row][$keySql[$col]] = $mysqlDate;
                        }
                    }
                    else if($key[$col]=="tckn" && $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() == ''){
                    	$bossatir++;
                    	break;
                    }
                    else {
                        if($objWorksheet->getCellByColumnAndRow($col, $row)->getValue() != '' ){
                                $data[$row][$keySql[$col]] = trim($objWorksheet->getCellByColumnAndRow($col, $row)->getValue());
                        }
                    }
                }
                if($bossatir>0){
                	break;
                }
            }
            
            $sql= "select yeterlilik_id from m_belgelendirme_sinav where sinav_id=".$get["sinav"];
            $yeterlilik_id=$_db->prep_exec($sql, array());
            $yeterlilik_id=$yeterlilik_id[0]["YETERLILIK_ID"];

            $sinavYerleri = $this->sinavYeriKontrol($user_id,$yeterlilik_id);
            $degerlendiriciler = $this->sinavDegerlendiriciKontrol($user_id, $yeterlilik_id);
            
            $keyArray = array();
            $dataTest = array();
            $dataTest = $data;
        foreach ($dataTest as $key=>$cow){
                $keyArray[] = $key;
                unset($dataTest[$key]['PUAN']);
                unset($dataTest[$key]['BASARI_DURUMU']);
                unset($dataTest[$key]['SINAV_TARIHI']);
                unset($dataTest[$key]['SINAV_SAATI']);
                unset($dataTest[$key]['YETERLILIK_KODU']);
                unset($dataTest[$key]['UYRUK']);
//                unset($dataTest[$key]['SINAV_YERI_ID']);
               unset($dataTest[$key]['DEGERLENDIRICI_TC_KIMLIK']);
//                var_dump($dataTest);
                settype($dataTest[$key]['TC_KIMLIK'], "string");
                
                $dataTest[$key]['SINAV_YERI_ID'] = (int)$dataTest[$key]['SINAV_YERI_ID'];

                $dataTest[$key]['ADI'] = FormFactory::ucWordsTR($dataTest[$key]['ADI']); 
                $dataTest[$key]['SOYADI'] = FormFactory::toUpperCase($dataTest[$key]['SOYADI']);
                $dataTest[$key]['BIRIM_KODU'] = ucwords(trim(str_replace(' ', '',$dataTest[$key]['BIRIM_KODU'])));
                $dataTest[$key]['SINAV_TURU_KODU'] = ucwords(trim(str_replace(' ', '',$dataTest[$key]['SINAV_TURU_KODU'])));
                //$dataTest[$key]['DOGUM_YERI'] = FormFactory::ucWordsTR($dataTest[$key]['DOGUM_YERI']);
                //$dataTest[$key]['BABA_ADI'] = FormFactory::ucWordsTR($dataTest[$key]['BABA_ADI']);

                $cinsiyet = FormFactory::toUpperCase($dataTest[$key]['CINSIYETI']);
                if($cinsiyet == 'ERKEK'){
                        $dataTest[$key]['CINSIYETI']=1;
                        $data[$key]['CINSIYETI']=1;
                } else if($cinsiyet == 'KADIN'){
                        $dataTest[$key]['CINSIYETI']=2;
                        $data[$key]['CINSIYETI']=2;
                } else if($cinsiyet == 'BELİRTİLMEMİŞ'){
                        $dataTest[$key]['CINSIYETI']=3;
                        $data[$key]['CINSIYETI']=3;
                }

                $egitimm = FormFactory::toUpperCase(trim(str_replace(' ', '',$dataTest[$key]['EGITIMI'])));
                
                if($egitimm == 'OKURYAZARDEĞİL'){
                        $dataTest[$key]['EGITIMI'] = 1;
                        $data[$key]['EGITIMI'] = 1;
                } else if($egitimm == 'OKURYAZAR'){
                        $dataTest[$key]['EGITIMI'] = 2;
                        $data[$key]['EGITIMI'] = 2;
                } else if($egitimm == 'İLKOKUL'){
                        $dataTest[$key]['EGITIMI'] = 3;
                        $data[$key]['EGITIMI'] = 3;
                } else if($egitimm == 'ORTAOKUL'){
                        $dataTest[$key]['EGITIMI'] = 4;
                        $data[$key]['EGITIMI'] = 4;
                } else if($egitimm == 'MESLEKLİSESİ'){
                        $dataTest[$key]['EGITIMI'] = 5;
                        $data[$key]['EGITIMI'] = 5;
                } else if($egitimm == 'GENELLİSE'){
                        $dataTest[$key]['EGITIMI'] = 6;
                        $data[$key]['EGITIMI'] = 6;
                } else if($egitimm == 'MESLEKYÜKSEKOKULU'){
                        $dataTest[$key]['EGITIMI'] = 7;
                        $data[$key]['EGITIMI'] = 7;
                } else if($egitimm == 'LİSANS'){
                        $dataTest[$key]['EGITIMI'] = 8;
                        $data[$key]['EGITIMI'] = 8;
                } else if($egitimm == 'YÜKSEKLİSANS'){
                        $dataTest[$key]['EGITIMI'] = 9;
                        $data[$key]['EGITIMI'] = 9;
                } else if($egitimm == 'DOKTORA'){
                        $dataTest[$key]['EGITIMI'] = 10;
                        $data[$key]['EGITIMI'] = 10;
                }
                
                $calismaDurum = FormFactory::toUpperCase(trim(str_replace(' ', '',$dataTest[$key]['CALISMA_DURUMU'])));
                if($calismaDurum == 'ÇALIŞIYOR'){
                        $dataTest[$key]['CALISMA_DURUMU'] = 1;
                        $data[$key]['CALISMA_DURUMU'] = 1;
                } else if($calismaDurum == 'ÇALIŞMIYOR'){
                        $dataTest[$key]['CALISMA_DURUMU'] = 2;
                        $data[$key]['CALISMA_DURUMU'] = 2;
                } else if($calismaDurum == 'STAJYAPIYOR'){
                        $dataTest[$key]['CALISMA_DURUMU'] = 3;
                        $data[$key]['CALISMA_DURUMU'] = 3;
                }
            }


            //array_splice($data[4], 5) ilk 5 degerden sonrasını siliyor. 5'degerden sonrasını sana döndürüyor.

            $sql= "select * from m_yeterlilik where yeterlilik_id=".$yeterlilik_id;
            $yeterlilik = $_db->prep_exec($sql, array());
            $yeni_mi=$yeterlilik[0]["YENI_MI"];

            if($yeni_mi==1){
                    $sql = "SELECT DISTINCT M_BELGELENDIRME_OGRENCI.TC_KIMLIK, M_BELGELENDIRME_OGRENCI.ADI, M_BELGELENDIRME_OGRENCI.SOYADI, M_BELGELENDIRME_OGRENCI.DOGUM_TARIHI, 
                                            M_BELGELENDIRME_OGRENCI.CINSIYETI, M_BELGELENDIRME_OGRENCI.EGITIMI,
                                            M_BELGELENDIRME_OGRENCI.CALISMA_DURUMU,M_BIRIM.BIRIM_KODU, M_BELGELENDIRME_ADAY_BILDIRIM.SINAV_TURU_KODU,
                                            M_BELGELENDIRME_ADAY_BILDIRIM.BILDIRIM_ID,M_BELGELENDIRME_ADAY_BILDIRIM.BIRIM_ID,M_BELGELENDIRME_ADAY_BILDIRIM.SINAV_TURU_KODU,
                                            M_BELGELENDIRME_ADAY_BILDIRIM.SINAV_YERI_ID, M_BELGELENDIRME_ADAY_BILDIRIM.DEGERLENDIRICI_TC_KIMLIK
                                                FROM M_BELGELENDIRME_OGRENCI
                                                    JOIN M_BELGELENDIRME_ADAY_BILDIRIM ON M_BELGELENDIRME_OGRENCI.TC_KIMLIK = M_BELGELENDIRME_ADAY_BILDIRIM.TC_KIMLIK
                                                    JOIN M_BIRIM ON M_BELGELENDIRME_ADAY_BILDIRIM.BIRIM_ID = M_BIRIM.BIRIM_ID
                                                    WHERE M_BELGELENDIRME_ADAY_BILDIRIM.SINAV_ID = ? AND PAKET_ID=?
                                    ORDER BY M_BELGELENDIRME_ADAY_BILDIRIM.BILDIRIM_ID";
            }
            else{
                    $sql = "SELECT  DISTINCT M_BELGELENDIRME_OGRENCI.TC_KIMLIK, M_BELGELENDIRME_OGRENCI.ADI, M_BELGELENDIRME_OGRENCI.SOYADI, M_BELGELENDIRME_OGRENCI.DOGUM_TARIHI, 
                                            M_BELGELENDIRME_OGRENCI.CINSIYETI, M_BELGELENDIRME_OGRENCI.EGITIMI,
                                            M_BELGELENDIRME_OGRENCI.CALISMA_DURUMU, M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU, M_BELGELENDIRME_ADAY_BILDIRIM.SINAV_TURU_KODU,
                                            M_BELGELENDIRME_ADAY_BILDIRIM.BILDIRIM_ID,M_BELGELENDIRME_ADAY_BILDIRIM.BIRIM_ID,M_BELGELENDIRME_ADAY_BILDIRIM.SINAV_TURU_KODU,
                                            M_BELGELENDIRME_ADAY_BILDIRIM.SINAV_YERI_ID, M_BELGELENDIRME_ADAY_BILDIRIM.DEGERLENDIRICI_TC_KIMLIK
                                                    FROM M_BELGELENDIRME_OGRENCI
                                                    JOIN M_BELGELENDIRME_ADAY_BILDIRIM ON M_BELGELENDIRME_OGRENCI.TC_KIMLIK = M_BELGELENDIRME_ADAY_BILDIRIM.TC_KIMLIK
                                                    JOIN M_YETERLILIK_ALT_BIRIM ON M_BELGELENDIRME_ADAY_BILDIRIM.BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
                                                    WHERE M_BELGELENDIRME_ADAY_BILDIRIM.SINAV_ID = ? AND PAKET_ID=?
                                                    ORDER BY M_BELGELENDIRME_ADAY_BILDIRIM.BILDIRIM_ID";
            }
            $kayitliaday = $_db->prep_exec($sql, array($get['sinav'],$paket_Id));

            $adayBirims = array();
            $adaylar = array();
            foreach ($kayitliaday as $key=>$row){
                $adayBirims[$keyArray[$key]][] = $kayitliaday[$key]['BIRIM_ID'];
                $adayBirims[$keyArray[$key]][] = $kayitliaday[$key]['SINAV_TURU_KODU'];
                unset($kayitliaday[$key]['BIRIM_ID']);
                unset($kayitliaday[$key]['BILDIRIM_ID']);
                unset($kayitliaday[$key]['DEGERLENDIRICI_TC_KIMLIK']);
//                var_dump($kayitliaday);
                $kayitliaday[$key]['CINSIYETI'] = (int)$kayitliaday[$key]['CINSIYETI'];
                $kayitliaday[$key]['EGITIMI'] = (int)$kayitliaday[$key]['EGITIMI'];
                $kayitliaday[$key]['CALISMA_DURUMU'] = (int)$kayitliaday[$key]['CALISMA_DURUMU'];
                $kayitliaday[$key]['SINAV_YERI_ID'] = (int)$kayitliaday[$key]['SINAV_YERI_ID'];
                if($yeni_mi==1){
                	$kayitliaday[$key]['BIRIM_KODU'] = trim($kayitliaday[$key]['BIRIM_KODU']);
                }else{
                	$kayitliaday[$key]['BIRIM_KODU'] = trim($yeterlilik[0]['YETERLILIK_KODU'].'/'.$kayitliaday[$key]['BIRIM_KODU']);
                }
                
                
                $adaylar[$keyArray[$key]] = $kayitliaday[$key];
            }

//             for($i = 4; $i<74;$i++){
//             	if($adaylar[$i] != $dataTest[$i]){
//             		print_r('<pre>');
//             		print_r($adaylar[$i]);
//             		print_r($dataTest[$i]);
//             		print_r($i);
//             		print_r('</pre>');
//             		exit();
//             		die();
//             	}
//             }

        $hataArray = array(); 
        for($i=4;$i<(count($dataTest)+4);$i++){
        	if($adaylar[$i] != $dataTest[$i]){
        		$return["adayBilgisi"][] = $i;
        	}
        }    
            
        if($adaylar == $dataTest){
                $sinavTarihi = $this->getSinavTarihi($get['sinav']);
                $sinavYerleri= $this->sinavYeriKontrol($user_id,$yeterlilik_id);
                $degerlendiriciler=$this->sinavDegerlendiriciKontrol($user_id, $yeterlilik_id);

        foreach ($data as $key=>$satir){
                ////////////// EXCEL'DEN GELEN SINAV TARİHİ KONTROLÜ ///////////////

                if (strtotime($sinavTarihi)>strtotime(ereg_replace("/","-",$satir["SINAV_TARIHI"]))){
                        $return["hataMesaji"][4]="Aşağıdaki satırlarda verilen Sınav Tarihleri, Sınav Programınızda belirttiğiniz Başlangıç Tarihinden (".$sinavTarihi.") öncedir. Düzeltip dosyanızı yeniden yükleyiniz.";
                        $return["sinavTarihi"][]=array($key,$satir["SINAV_TARIHI"]);
                }

                ////////////// EXCEL'DEN GELEN SINAV TARİHİ 360 GÜN KONTROLÜ ///////////////

                if (strtotime('+360 days',strtotime($sinavTarihi))<strtotime(ereg_replace("/","-",$satir["SINAV_TARIHI"]))){
                        $return["hataMesaji"][2]="Aşağıdaki satırlarda verilen Sınav Tarihleri, Sınav Programınızda belirttiğiniz Başlangıç Tarihinden (".$sinavTarihi.") 1 yıl içinde olmalıdır. Düzeltip dosyanızı yeniden yükleyiniz.";
                        $return["sinavTarihi360"][]=array($key,$satir["SINAV_TARIHI"]);
                }

                ////////////// EXCEL'DEN GELEN SINAV YERİ KONTROLÜ ///////////////

//                if (!in_array($satir["SINAV_YERI_ID"], $sinavYerleri)){
//                        $return["hataMesaji"][5]="Aşağıdaki satırlarda Verdiğiniz Sınav Yeri ID'leri, <a href='index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_sinav_yeri'  style='color:red;'>Sınav Yerleriniz</a> arasında yoktur. Düzeltip dosyanızı yeniden yükleyiniz.";
//                        $return["sinavYeri"][]=array($key,$satir["SINAV_YERI_ID"]);
//                }

                ////////////// EXCEL'DEN GELEN DEĞERLENDİRİCİLERİN KONTROLÜ ///////////////
               $degTcKimliks=explode(",",$satir["DEGERLENDIRICI_TC_KIMLIK"]);
               foreach ($degTcKimliks as $degTcKimlik){
                       if (!in_array(trim($degTcKimlik), $degerlendiriciler)){
                               $return["hataMesaji"][6]="Aşağıdaki satırlarda verdiğiniz Değerlendirici/Gözetmen'ler, <a href='index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_degerlendirici' style='color:red;'>Değerlendiriciler</a> arasında yoktur. Düzeltip dosyanızı yeniden yükleyiniz.";
                               $return["degerlendirici"][]=array($key,$degTcKimlik);
                       }
               }

                ////////////// EXCEL'DEN GELEN BASARI VE SONUC KONTROLÜ ///////////////
                if($satir["BASARI_DURUMU"] == '' || empty($satir["BASARI_DURUMU"]) || !isset($satir["BASARI_DURUMU"])){
                        $return["hataMesaji"][7]="Aşağıdaki satırlarda Sonuç bildirilmemiştir. Düzeltip dosyanızı yeniden yükleyiniz.";
                        $return["sonuc"][]=$key;
                }
                else{
                    $sonuc=0;
                    if(FormFactory::toUpperCase($satir["BASARI_DURUMU"]) == 'BAŞARILI'){
                            if($satir['PUAN'] == ''  || empty($satir["PUAN"]) || !isset($satir["PUAN"])){
                                    $return["hataMesaji"][8]="Aşağıdaki satırlarda Sonuç bildirilmesine rağmen Puan bildirilmemiştir. Düzeltip dosyanızı yeniden yükleyiniz.";
                                    $return["puan"][]=$key;
                            }
                            else{
                                    $adaySonuc[$key] = 1;
                            }
                    }
                    else if(FormFactory::toUpperCase($satir["BASARI_DURUMU"]) == 'BAŞARISIZ'){
                            if($satir['PUAN'] == ''  || empty($satir["PUAN"]) || !isset($satir["PUAN"])){
                                    $satir['PUAN'] = 0;
                                    $adaySonuc[$key]=2;
                        	}
                            else{
                                    $adaySonuc[$key]=2;
                            }
                    }
                    else if(FormFactory::toUpperCase($satir["BASARI_DURUMU"]) == 'GİRMEDİ'){
                            $adaySonuc[$key] = 3;
                    }
                }

                /////////////  EXCEL'DEN GELEN VERIYI KAYDETME ////////////////
                $sql = "UPDATE M_BELGELENDIRME_ADAY_BILDIRIM SET PUAN=?, BASARI_DURUMU = ?, DEGERLENDIRICI_TC_KIMLIK = ? WHERE TC_KIMLIK = ? AND SINAV_ID=? AND BIRIM_ID=? AND SINAV_TURU_KODU=? AND PAKET_ID=?";
                $param = array(
                                $satir['PUAN'],
                                $adaySonuc[$key],
                				$satir['DEGERLENDIRICI_TC_KIMLIK'],
                                $satir['TC_KIMLIK'],
                                $get['sinav'],
                                $adayBirims[$key][0],
                                $adayBirims[$key][1],
                                $paket_Id
                );

                $durum = $_db->prep_exec_insert($sql, $param);

            }

                if(count($return) == 0){

                    $sql="DELETE FROM M_BELGELENDIRME_SINAV_DOSYA WHERE SINAV_ID=? AND PAKET_ID=?";
                    $_db->prep_exec_insert($sql, array($get['sinav'],$paket_Id));
                    
                    $paket_id_yeni = $_db->getNextVal('SEQ_SINAV_DOSYA');
                    $sql="INSERT INTO M_BELGELENDIRME_SINAV_DOSYA (PAKET_ID,SINAV_ID,TIP) VALUES(?,?,2)";
                    $_db->prep_exec_insert($sql, array($paket_id_yeni,$get['sinav']));

                    $sql = "UPDATE M_BELGELENDIRME_ADAY_BILDIRIM SET PAKET_ID = ? WHERE SINAV_ID=? AND PAKET_ID=?";
                    $_db->prep_exec_insert($sql, array($paket_id_yeni,$get['sinav'],$paket_Id));

                    move_uploaded_file($files['upload']['tmp_name'], EK_FOLDER."sinav_bildirimleri/".$user_id."_".$get["sinav"]."_".$paket_id_yeni.".xlsx");
                }
                else{
                    $sql = "UPDATE M_BELGELENDIRME_ADAY_BILDIRIM SET PUAN = null, BASARI_DURUMU = null WHERE PAKET_ID = ?";
                    $_db->prep_exec_insert($sql, array($paket_Id));

                    return $return;
                }
            }
            else{
                 $return["hataMesaji"][3] = "Yolladığınız dosyadaki veriler ile indirdiğiniz dosyadaki veriler uyuşmamaktadır. Kontrol ederek tekrar yükleyiniz.";
                return $return;
            }
        }
    }
	
	
	function getSonuclar($post,$get){
		$_db = JFactory::getOracleDBO ();
		
		if(!empty($post['sinav']) || !empty($post['tckn'])){
			$sinav_id = $post['sinav'];
			$tckn = $post['tckn'];
		}
		else {
			$sinav_id = $get['sinav'];
			$tckn = $get['tckn'];
		}
		
		$sql= "select yeni_mi from m_belgelendirme_sinav join m_yeterlilik using(yeterlilik_id) where sinav_id=".$sinav_id;
		$yeni_mi=$_db->prep_exec($sql, array());
		$yeni_mi=$yeni_mi[0]["YENI_MI"];
		
		if($yeni_mi==1){
			$sql = "SELECT DISTINCT M_BELGELENDIRME_OGRENCI.*,M_BELGELENDIRME_ADAY_BILDIRIM.*,M_BIRIM.BIRIM_KODU
								FROM M_BELGELENDIRME_OGRENCI
								JOIN M_BELGELENDIRME_ADAY_BILDIRIM ON M_BELGELENDIRME_OGRENCI.TC_KIMLIK = M_BELGELENDIRME_ADAY_BILDIRIM.TC_KIMLIK
								JOIN M_BIRIM ON M_BELGELENDIRME_ADAY_BILDIRIM.BIRIM_ID = M_BIRIM.BIRIM_ID
								WHERE 1";
		}
		else{
			$sql = "SELECT DISTINCT M_BELGELENDIRME_OGRENCI.*,M_BELGELENDIRME_ADAY_BILDIRIM.*,M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU
								FROM M_BELGELENDIRME_OGRENCI
								JOIN M_BELGELENDIRME_ADAY_BILDIRIM ON M_BELGELENDIRME_OGRENCI.TC_KIMLIK = M_BELGELENDIRME_ADAY_BILDIRIM.TC_KIMLIK
								JOIN M_YETERLILIK_ALT_BIRIM ON M_BELGELENDIRME_ADAY_BILDIRIM.BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
								WHERE 1";
		}
		
		if(!empty($sinav_id)){
			$sql .= " AND M_BELGELENDIRME_ADAY_BILDIRIM.SINAV_ID = ".$sinav_id;
		}
		if(!empty($tckn)){
			$sql .= " AND M_BELGELENDIRME_OGRENCI.TC_KIMLIK = ".$tckn;
		}
		
		$kayitliaday = $_db->prep_exec($sql, array());
		
		return $kayitliaday;
	}
        
        function adaySonucSil($post){
            $_db = JFactory::getOracleDBO ();
            
            $paket = $post['paketId'];
            $sinav = $post['sinavId'];
            
            $sql = "UPDATE M_BELGELENDIRME_ADAY_BILDIRIM SET PUAN=NULL, BASARI_DURUMU=NULL WHERE SINAV_ID=? AND PAKET_ID=?";
            $_db->prep_exec_insert($sql,array($sinav,$paket));
            
            $sql = "UPDATE M_BELGELENDIRME_SINAV_DOSYA SET TIP=1 WHERE SINAV_ID=? AND PAKET_ID=?";
            $_db->prep_exec_insert($sql,array($sinav,$paket));
            return true;
        }
        
        function BildirilmisAdaySil($post){
            $_db = JFactory::getOracleDBO ();
            
            $paket = $post['paketId'];
            $sinav = $post['sinavId'];
            
            $sql = "DELETE FROM M_BELGELENDIRME_ADAY_BILDIRIM WHERE SINAV_ID=? AND PAKET_ID=?";
            $_db->prep_exec_insert($sql,array($sinav,$paket));
            
            $sql = "DELETE FROM M_BELGELENDIRME_SINAV_DOSYA WHERE SINAV_ID=? AND PAKET_ID=?";
            $_db->prep_exec_insert($sql,array($sinav,$paket));
            return true;
        }
        
        function getKayitSayisi($sinav_id){
            $_db = JFactory::getOracleDBO ();
            
            $sql = "SELECT COUNT(*) AS CONT FROM M_BELGELENDIRME_ADAY_BILDIRIM WHERE SINAV_ID = ?";
            return $_db->prep_exec_array($sql,array($sinav_id));
        }
        
        function sonucGonderYetkilimi($post){
            $_db = JFactory::getOracleDBO ();
            
            $sinav_id = $post['sinavId'];
            
            $sql = "SELECT * FROM M_BELGELENDIRME_ADAY_BILDIRIM WHERE SINAV_ID = ? AND BASARI_DURUMU IS NULL";
            $return = $_db->prep_exec_array($sql,array($sinav_id));
            if(count($return) == 0){
                return true;
            }
            else{
                return false;
            }
        }
        
        function sonucGonder($post){
            $_db = JFactory::getOracleDBO ();
            
            $sinav_id = $post['sinavId'];
            $user 	 = &JFactory::getUser ();
            $user_id = $user->getOracleUserId ();
            
            $sql = "SELECT * FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID = ? AND SONUC_DURUMU = 1 AND KURULUS_ID =?";
            $return = $_db->prep_exec_array($sql,array($sinav_id,$user_id));
            
            if(count($return) == 0){
            	return false;
            }
            
            $sinavBilgi = $this->getSinavBilgi($sinav_id);
            $yeterlilik_id = $sinavBilgi[0]['YETERLILIK_ID'];
            
            $sql = "SELECT DISTINCT TC_KIMLIK FROM M_BELGELENDIRME_ADAY_BILDIRIM WHERE SINAV_ID = ?";
            $Adaylar = $_db->prep_exec($sql, array($sinav_id));
            
            $ogrenci = array();
            foreach ($Adaylar as $row){
            	$sql = "SELECT * FROM M_BELGELENDIRME_OGRENCI WHERE TC_KIMLIK = ?";
            	$ogr = $_db->prep_exec($sql, array($row['TC_KIMLIK']));
            	$ogrenci[$row['TC_KIMLIK']] = $ogr[0];
            }
            
            $basariliBirimler = array();
            $basarisizBirimler = array();
            $alternatifTipi = $this->AlternatifTipi($yeterlilik_id);
            $dataYet = $this->AlteratifBirim($yeterlilik_id);
            foreach($Adaylar as $aday){
                $sonucBirim = $this->yeterlilikBelgeHakki($aday['TC_KIMLIK'],$yeterlilik_id,$alternatifTipi,$dataYet);
                if($sonucBirim != false){
                    $basariliBirimler[(string)$aday['TC_KIMLIK']] = $sonucBirim;   
                }else{
                	$basarisizBirimler[(string)$aday['TC_KIMLIK']] = $this->yeterlilikBelgeBasariliBirim($aday['TC_KIMLIK'],$yeterlilik_id);
                }
            }
            $yenimi = $this->YeterlilikYenimi($yeterlilik_id);
            if($yenimi == 1){
	            foreach($basariliBirimler as $tc=>$val){
	            	for($i=0; $i<count($val);$i++){
	            		array_push($basariliBirimler[$tc][$i], $this->YeniBirimKodu($val[$i][0]));
	            	}
	            }
	            
	            foreach($basarisizBirimler as $tc=>$val){
	            	for($i=0; $i<count($val);$i++){
	            		array_push($basarisizBirimler[$tc][$i], $this->YeniBirimKodu($val[$i][0]));
	            	}
	            }
            }else{
            	foreach($basariliBirimler as $tc=>$val){
            		for($i=0; $i<count($val);$i++){
            			array_push($basariliBirimler[$tc][$i], $this->EskiBirimKodu($val[$i][0]));
            		}
            	}
            	 
            	foreach($basarisizBirimler as $tc=>$val){
            		for($i=0; $i<count($val);$i++){
            			array_push($basarisizBirimler[$tc][$i], $this->EskiBirimKodu($val[$i][0]));
            		}
            	}
            }
            
          
            
//             foreach($basariliBirimler as $tckimlik=>$birimler){
//                 $hak_id = $_db->getNextVal('SEQ_HAK_KAZANAN');
//                 $sql = "INSERT INTO M_BELGELENDIRME_HAK_KAZANANLAR "
//                         . "(ID,TC_KIMLIK,YETERLILIK_ID,SINAV_ID,KURULUS_ID,SINAV_TARIHI) "
//                         . "VALUES(?,?,?,?,?,?)";
//                 $param = array($hak_id, $tckimlik, $yeterlilik_id, $sinav_id, $user_id, $sinavBilgi[0]['BASLANGIC_TARIHI']);
//                 if($_db->prep_exec_insert($sql,$param)){
//                     foreach ($birimler as $birim) {
//                         $sql = "INSERT INTO M_BELGELENDIRME_BASARILI_BIRIM (HAK_KAZANAN_ID,BIRIM_ID,TARIH) "
//                                 . "VALUES(?,?,TO_DATE(?, 'dd/mm/yyyy'))";
//                         $param = array($hak_id, $birim[0],$birim[1]);
//                         $_db->prep_exec_insert($sql,$param);
//                     }
//                 }
//             }
//             $yeterlilik = $this->getYeterlilikwithYeterlilikId($yeterlilik_id);
// 			$kurulus = FormFactory::getKurulusValues($user_id);
//             $aciklamaText=$kurulus['KURULUS_ADI'].", ".$yeterlilik[0]['YETERLILIK_KODU']." - ".$yeterlilik[0]['YETERLILIK_ADI']." için sınav sonucunu gönderdi. ";
//             if (count($basariliBirimler)>0){
//             	$aciklamaText .= count($basariliBirimler)." kişi için belge başvurusu yapıldı.";
//             }
//             $link="index.php?option=com_belgelendirme&view=belge_olusturma&kurulusId=".$user_id."&sinavId=".$sinav_id;
//             $sql="select distinct user_id from m_YETKI_SEKTOR_SORUMLUSU";
//             $sektorSorumlulari=$_db->prep_exec($sql,array());
//             foreach ($sektorSorumlulari as $toUserID){
//             	FormFactory::sektorSorumlusunaNotificationGonder($aciklamaText, $link, $toUserID['USER_ID']);
//             }
            
            
//             $sql = "UPDATE M_BELGELENDIRME_SINAV SET SONUC_DURUMU = 2 WHERE SINAV_ID = ?";
//             $_db->prep_exec_insert($sql, array($sinav_id));
//             return count($basariliBirimler);
				return array(0=>$basariliBirimler,1=>$basarisizBirimler,2=>$ogrenci);
        }
        
        function belgeAdaySonucGonder($post){
        	$_db = JFactory::getOracleDBO ();
        	
        	$sinav_id = $post['sinav'];
        	$user 	 = &JFactory::getUser ();
        	$user_id = $user->getOracleUserId ();
        	
        	$basariliAday = $post['basarili'];
        	$basarisizAdaylar = $post['basarisiz'];
        	$aciklama = $post['aciklama'];
        	
        	$sql = "SELECT * FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID = ? AND SONUC_DURUMU = 1 AND KURULUS_ID =?";
        	$return = $_db->prep_exec_array($sql,array($sinav_id,$user_id));
        	
        	
        	if(count($return) == 0){
        		return false;
        	}
        	
        	$sinavBilgi = $this->getSinavBilgi($sinav_id);
        	$yeterlilik_id = $sinavBilgi[0]['YETERLILIK_ID'];
        	
        	$alternatifTipi = $this->AlternatifTipi($yeterlilik_id);
        	$dataYet = $this->AlteratifBirim($yeterlilik_id);
        	foreach($basariliAday as $aday){
        		$sonucBirim = $this->yeterlilikBelgeHakki((string)$aday,$yeterlilik_id,$alternatifTipi,$dataYet);
        		if($sonucBirim != false){
        			
        			$hak_id = $_db->getNextVal('SEQ_HAK_KAZANAN');
        			$sql = "INSERT INTO M_BELGELENDIRME_HAK_KAZANANLAR "
        					. "(ID,TC_KIMLIK,YETERLILIK_ID,SINAV_ID,KURULUS_ID,SINAV_TARIHI,AKTIF) "
        					. "VALUES(?,?,?,?,?,?,?)";
        			$param = array($hak_id, $aday, $yeterlilik_id, $sinav_id, $user_id, $sinavBilgi[0]['BASLANGIC_TARIHI'],1);
        			if($_db->prep_exec_insert($sql,$param)){
	        			foreach($sonucBirim as $row){
	        				$sql = "INSERT INTO M_BELGELENDIRME_BASARILI_BIRIM (HAK_KAZANAN_ID,BIRIM_ID,TARIH) "
	        						. "VALUES(?,?,TO_DATE(?, 'dd/mm/yyyy'))";
	        				$param = array($hak_id, $row[0],$row[1]);
	        				$_db->prep_exec_insert($sql,$param);
	        			}
        			}
        		}
        	}
        	
        	foreach($basarisizAdaylar as $aday){
        		$sonucBirim = $this->yeterlilikBelgeBasariliBirim((string)$aday,$yeterlilik_id);
        		
        		$hak_id = $_db->getNextVal('SEQ_HAK_KAZANAN');
        		$sql = "INSERT INTO M_BELGELENDIRME_HAK_KAZANANLAR "
        				. "(ID,TC_KIMLIK,YETERLILIK_ID,SINAV_ID,KURULUS_ID,SINAV_TARIHI,AKTIF,ACIKLAMA) "
        				. "VALUES(?,?,?,?,?,?,?,?)";
        		$param = array($hak_id, $aday, $yeterlilik_id, $sinav_id, $user_id, $sinavBilgi[0]['BASLANGIC_TARIHI'],0,$aciklama[$aday]);
        		if($_db->prep_exec_insert($sql,$param)){
	        		foreach ($sonucBirim as $row){
	        				$sql = "INSERT INTO M_BELGELENDIRME_BASARILI_BIRIM (HAK_KAZANAN_ID,BIRIM_ID,TARIH) "
	        						. "VALUES(?,?,TO_DATE(?, 'dd/mm/yyyy'))";
	        				$param = array($hak_id, $row[0],$row[1]);
	        				$_db->prep_exec_insert($sql,$param);
	        		}
        		}
        	}
        	
        	$yeterlilik = $this->getYeterlilikwithYeterlilikId($yeterlilik_id);
        	$kurulus = FormFactory::getKurulusValues($user_id);
        	$aciklamaText=$kurulus['KURULUS_ADI'].", ".$yeterlilik[0]['YETERLILIK_KODU']." - ".$yeterlilik[0]['YETERLILIK_ADI']." için sınav sonucunu gönderdi. ";
        	if ((count($basariliAday)+count($basarisizAdaylar))>0){
        		$aciklamaText .= (count($basariliAday)+count($basarisizAdaylar))." kişi için belge başvurusu yapıldı.";
        	}
        	$link="index.php?option=com_belgelendirme&view=belge_olusturma&kurulusId=".$user_id."&sinavId=".$sinav_id;
        	$sqlGorevli = "SELECT TGUSERID FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
			$gorevli = $_db->prep_exec($sqlGorevli, array($user_id));
        	foreach ($gorevli as $toUserID){
        		FormFactory::sektorSorumlusunaNotificationGonder($aciklamaText, $link, $toUserID['TGUSERID']);
        	}
        	
        	
        	$sql = "UPDATE M_BELGELENDIRME_SINAV SET SONUC_DURUMU = 2 WHERE SINAV_ID = ?";
        	$_db->prep_exec_insert($sql, array($sinav_id));
        	return true;
        	
        }
        
        
        function sonucGonderilecekAdaylar($post){
        	 $_db = JFactory::getOracleDBO ();
            
            $sinav_id = $post['sinavId'];
            $user 	 = &JFactory::getUser ();
            $user_id = $user->getOracleUserId ();
            
            $sql = "SELECT * FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID = ? AND SONUC_DURUMU = 1 AND KURULUS_ID =?";
            $return = $_db->prep_exec_array($sql,array($sinav_id,$user_id));
            
            if(count($return) == 0){
            	return false;
            }
            
            $sinavBilgi = $this->getSinavBilgi($sinav_id);
            $yeterlilik_id = $sinavBilgi[0]['YETERLILIK_ID'];
            
            $sql = "SELECT DISTINCT TC_KIMLIK FROM M_BELGELENDIRME_ADAY_BILDIRIM WHERE SINAV_ID = ?";
            $Adaylar = $_db->prep_exec($sql, array($sinav_id));
            
            $ogrenci = array();
            foreach ($Adaylar as $row){
            	$sql = "SELECT * FROM M_BELGELENDIRME_OGRENCI WHERE TC_KIMLIK = ?";
            	$ogr = $_db->prep_exec($sql, array($row['TC_KIMLIK']));
            	$ogrenci[$row['TC_KIMLIK']] = $ogr[0];
            }
            
            $basariliBirimler = array();
            $basarisizBirimler = array();
            $alternatifTipi = $this->AlternatifTipi($yeterlilik_id);
            $dataYet = $this->AlteratifBirim($yeterlilik_id);
            foreach($Adaylar as $aday){
                $sonucBirim = $this->yeterlilikBelgeHakki($aday['TC_KIMLIK'],$yeterlilik_id,$alternatifTipi,$dataYet);
                if($sonucBirim != false){
                    $basariliBirimler[(string)$aday['TC_KIMLIK']] = $sonucBirim;   
                }
//                 else{
//                 	$basarisizBirimler[(string)$aday['TC_KIMLIK']] = $this->yeterlilikBelgeBasariliBirim($aday['TC_KIMLIK'],$yeterlilik_id);
//                 }
            }
            $yenimi = $this->YeterlilikYenimi($yeterlilik_id);
            if($yenimi == 1){
	            foreach($basariliBirimler as $tc=>$val){
	            	for($i=0; $i<count($val);$i++){
	            		array_push($basariliBirimler[$tc][$i], $this->YeniBirimKodu($val[$i][0]));
	            	}
	            }
	            
// 	            foreach($basarisizBirimler as $tc=>$val){
// 	            	for($i=0; $i<count($val);$i++){
// 	            		array_push($basarisizBirimler[$tc][$i], $this->YeniBirimKodu($val[$i][0]));
// 	            	}
// 	            }
            }else{
            	foreach($basariliBirimler as $tc=>$val){
            		for($i=0; $i<count($val);$i++){
            			array_push($basariliBirimler[$tc][$i], $this->EskiBirimKodu($val[$i][0]));
            		}
            	}
            	 
//             	foreach($basarisizBirimler as $tc=>$val){
//             		for($i=0; $i<count($val);$i++){
//             			array_push($basarisizBirimler[$tc][$i], $this->EskiBirimKodu($val[$i][0]));
//             		}
//             	}
            }
            
          
            
//             foreach($basariliBirimler as $tckimlik=>$birimler){
//                 $hak_id = $_db->getNextVal('SEQ_HAK_KAZANAN');
//                 $sql = "INSERT INTO M_BELGELENDIRME_HAK_KAZANANLAR "
//                         . "(ID,TC_KIMLIK,YETERLILIK_ID,SINAV_ID,KURULUS_ID,SINAV_TARIHI) "
//                         . "VALUES(?,?,?,?,?,?)";
//                 $param = array($hak_id, $tckimlik, $yeterlilik_id, $sinav_id, $user_id, $sinavBilgi[0]['BASLANGIC_TARIHI']);
//                 if($_db->prep_exec_insert($sql,$param)){
//                     foreach ($birimler as $birim) {
//                         $sql = "INSERT INTO M_BELGELENDIRME_BASARILI_BIRIM (HAK_KAZANAN_ID,BIRIM_ID,TARIH) "
//                                 . "VALUES(?,?,TO_DATE(?, 'dd/mm/yyyy'))";
//                         $param = array($hak_id, $birim[0],$birim[1]);
//                         $_db->prep_exec_insert($sql,$param);
//                     }
//                 }
//             }
//             $yeterlilik = $this->getYeterlilikwithYeterlilikId($yeterlilik_id);
// 			$kurulus = FormFactory::getKurulusValues($user_id);
//             $aciklamaText=$kurulus['KURULUS_ADI'].", ".$yeterlilik[0]['YETERLILIK_KODU']." - ".$yeterlilik[0]['YETERLILIK_ADI']." için sınav sonucunu gönderdi. ";
//             if (count($basariliBirimler)>0){
//             	$aciklamaText .= count($basariliBirimler)." kişi için belge başvurusu yapıldı.";
//             }
//             $link="index.php?option=com_belgelendirme&view=belge_olusturma&kurulusId=".$user_id."&sinavId=".$sinav_id;
//             $sql="select distinct user_id from m_YETKI_SEKTOR_SORUMLUSU";
//             $sektorSorumlulari=$_db->prep_exec($sql,array());
//             foreach ($sektorSorumlulari as $toUserID){
//             	FormFactory::sektorSorumlusunaNotificationGonder($aciklamaText, $link, $toUserID['USER_ID']);
//             }
            
            
//             $sql = "UPDATE M_BELGELENDIRME_SINAV SET SONUC_DURUMU = 2 WHERE SINAV_ID = ?";
//             $_db->prep_exec_insert($sql, array($sinav_id));
//             return count($basariliBirimler);
				return array(0=>$basariliBirimler,1=>array(),2=>$ogrenci);
        }
        
        
        function YeniBirimKodu($birimId){
        	$_db = JFactory::getOracleDBO ();
        	$sql= "select birim_kodu from m_birim where birim_id=".$birimId;
        	$birim = $_db->prep_exec($sql, array());
        	return $birim[0]['BIRIM_KODU'];
        }
        
        function EskiBirimKodu($birimId){
        	$_db = JFactory::getOracleDBO ();
        	$sql= "select yeterlilik_kodu, yeterlilik_alt_birim_no from m_yeterlilik_alt_birim join m_yeterlilik using(yeterlilik_id) where yeterlilik_alt_birim_id=".$birimId;
        	$birim = $_db->prep_exec($sql, array());
        	return $birim[0]['YETERLILIK_KODU'].'/'.$birim[0]['YETERLILIK_ALT_BIRIM_NO'];
        }
        
        function yeterlilikBelgeBasariliBirim($tckn, $yeterlilik_id){
        	$_db = JFactory::getOracleDBO ();
        
        	$tckn = (string)$tckn;
        	$yenimi = $this->YeterlilikYenimi($yeterlilik_id);
        
        	if($yenimi == 1){
        		$dataYet = $this->AlteratifBirim($yeterlilik_id);
        		$alternatifTipi = $this->AlternatifTipi($yeterlilik_id);
        		$zorunluBirims =$dataYet[1];
        		$secmeliBirims = $dataYet[0];
        		$basariliZorunluBirimler = $this->BelgeHakkiAdayBirimler($zorunluBirims, $tckn,1,$yeterlilik_id);
        		$basariliSecmeliBirimler = $this->BelgeHakkiAdayBirimler($secmeliBirims, $tckn,1,$yeterlilik_id);
        		if(count($basariliSecmeliBirimler)>0){
        			return array_merge($basariliZorunluBirimler, $basariliSecmeliBirimler);
        		}else{
        			return $basariliZorunluBirimler;
        		} 
        	}
        	else{
        		$dataYet = $this->AlteratifBirim($yeterlilik_id);
        		$alternatifTipi = $this->AlternatifTipi($yeterlilik_id);
        		$zorunluBirims =$dataYet[1];
        		$secmeliBirims = $dataYet[0];
        		$basariliZorunluBirimler = $this->BelgeHakkiAdayBirimler($zorunluBirims, $tckn,0,$yeterlilik_id);
        		$basariliSecmeliBirimler = $this->BelgeHakkiAdayBirimler($secmeliBirims, $tckn,0,$yeterlilik_id);
        		if(count($basariliSecmeliBirimler)>0){
        			return array_merge($basariliZorunluBirimler, $basariliSecmeliBirimler);
        		}else{
        			return $basariliZorunluBirimler;
        		}
        	}
        
        }
        
        function tekSonucGonder($post){
        	$_db = JFactory::getOracleDBO ();
        	
        	$user 	 = &JFactory::getUser ();
        	$user_id = $user->getOracleUserId ();
        	
        	$tckn = $post['tckn'];
        	$yeterlilik_id = $post['yeterlilik_id'];
        	
        	$alternatifTipi = $this->AlternatifTipi($yeterlilik_id);
        	$dataYet = $this->AlteratifBirim($yeterlilik_id);
        	
        	$birimler = $this->yeterlilikBelgeHakki($tckn,$yeterlilik_id,$alternatifTipi,$dataYet);
        	$birims = array();
        	foreach ($birimler as $birim){
        		$birims[] = $birim[0];
        	}
                
                $sql = "SELECT ID FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE TC_KIMLIK=? AND YETERLILIK_ID=? AND DURUM=1";
                $hak_id = $_db->prep_exec($sql,array($tckn,$yeterlilik_id));
                if ($hak_id[0]['ID']!=""){
	                $sql = "DELETE FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE ID=?";
	                $_db->prep_exec_insert($sql,array($hak_id[0]['ID']));
	                
	                $sql = "DELETE FROM M_BELGELENDIRME_BASARILI_BIRIM WHERE HAK_KAZANAN_ID=?";
	                $_db->prep_exec_insert($sql,array($hak_id[0]['ID']));
                }
        	if($birimler != false){
        		$sql = "SELECT SINAV_ID, BASLANGIC_TARIHI FROM M_BELGELENDIRME_SINAV 
        				JOIN M_BELGELENDIRME_ADAY_BILDIRIM USING(SINAV_ID)
        				WHERE BASARI_DURUMU=1
        				AND TC_KIMLIK = ?
        				AND BIRIM_ID IN (".implode(',',$birims).") 
        				and rownum=1
        				order by BASLANGIC_TARIHI desc";
        		$sinavBilgi = $_db->prep_exec($sql, array($tckn));
        		
	        	$hak_id = $_db->getNextVal('SEQ_HAK_KAZANAN');
	        	$sql = "INSERT INTO M_BELGELENDIRME_HAK_KAZANANLAR "
	        			. "(ID,TC_KIMLIK,YETERLILIK_ID,SINAV_ID,KURULUS_ID,SINAV_TARIHI) "
	        			. "VALUES(?,?,?,?,?,?)";
	        	$param = array($hak_id, $tckn, $yeterlilik_id, $sinavBilgi[0]['SINAV_ID'], $user_id, $sinavBilgi[0]['BASLANGIC_TARIHI']);
	        	if($_db->prep_exec_insert($sql,$param)){
	        		foreach ($birimler as $birim) {
	        			$sql = "INSERT INTO M_BELGELENDIRME_BASARILI_BIRIM (HAK_KAZANAN_ID,BIRIM_ID,TARIH) "
	        					. "VALUES(?,?,TO_DATE(?, 'dd/mm/yyyy'))";
	        			$param = array($hak_id, $birim[0],$birim[1]);
	        			$_db->prep_exec_insert($sql,$param);
	        		}
	        		
	        	}
	        	$yeterlilik = $this->getYeterlilikwithYeterlilikId($yeterlilik_id);
	        	$kurulus = FormFactory::getKurulusValues($user_id);
	        	$aciklamaText=$kurulus['KURULUS_ADI']." tarafından ".$tckn." TC Kimlik numaralı adayın, ".$yeterlilik[0]['YETERLILIK_KODU']." - ".$yeterlilik['YETERLILIK_ADI'][0]." için belge başvurusu yapılmıştır.";
	        	$link="index.php?option=com_belgelendirme&view=belge_olusturma&kurulusId=".$kurulus['KURULUS_ID']."sinavId=".$sinavBilgi[0]['SINAV_ID'];
	        	$sqlGorevli = "SELECT TGUSERID FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
				$gorevli = $_db->prep_exec($sqlGorevli, array($user_id));
	        	foreach ($gorevli as $toUserID){
	        		FormFactory::sektorSorumlusunaNotificationGonder($aciklamaText, $link, $toUserID['TGUSERID']);
	        	}
	        	
	        	$yenimi = $this->YeterlilikYenimi($yeterlilik_id);
	        	$birimBilgi = $this->BirimBilgileri($birims,$yenimi);
	        	return array(true,$tckn,$birimBilgi);
        	}
        	else{
        		$yenimi = $this->YeterlilikYenimi($yeterlilik_id);
        		$dataYet = $this->AlteratifBirim($yeterlilik_id);
            	$alternatifTipi = $this->AlternatifTipi($yeterlilik_id);
            	$zorunluBirims =$dataYet[1];
            	$secmeliBirims = $dataYet[0];
            	$basariliZorunluBirimler = $this->BelgeHakkiAdayBirimler($zorunluBirims, $tckn,$yenimi,$yeterlilik_id);
            	$basariliSecmeliBirimler = $this->BelgeHakkiAdayBirimler($secmeliBirims, $tckn,$yenimi,$yeterlilik_id);
            	
            	$birimBilgiZorunlu = $this->BirimBilgileri($basariliZorunluBirimler,$yenimi);
            	$birimBilgiSecmeli = $this->BirimBilgileri($basariliSecmeliBirimler,$yenimi);
            	
            	return array(false,$tckn,$alternatifTipi,$basariliZorunluBirimler,$basariliSecmeliBirimler);
        	}
        	
        	
        }
        
        function BirimBilgileri($birimler,$yenimi){
        	$_db = JFactory::getOracleDBO ();
        	$birimBilgi = array();
        	if($yenimi == 1){
        		foreach ($birimler as $birim){
        			$sql = "SELECT BIRIM_ADI, BIRIM_KODU FROM M_BIRIM WHERE BIRIM_ID=?";
        			$birimBilgi[$birim] = $_db->prep_exec($sql, array($birim));
        		}
        	}
        	else{
        		foreach ($birimler as $birim){
        			$sql = "SELECT YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU FROM M_YETERLILIK_ALT_BIRIM WHERE YETERLILIK_ALT_BIRIM_ID=?";
        			$birimBilgi[$birim] = $_db->prep_exec($sql, array($birim));
        		}
        	}
        	return $birimBilgi;
        }
        
        function getSinavBilgi($sinavId){
            $_db = JFactory::getOracleDBO ();
            
            $sql = "SELECT * FROM M_BELGELENDIRME_SINAV JOIN M_YETERLILIK USING(YETERLILIK_ID) WHERE SINAV_ID = ?";
            return $_db->prep_exec($sql,array($sinavId));
        }
        
        function yeterlilikBelgeHakki($tckn, $yeterlilik_id, $alternatifTipi, $dataYet){
            $_db = JFactory::getOracleDBO ();
            
            $tckn = (string)$tckn;
            $yenimi = $this->YeterlilikYenimi($yeterlilik_id);
            
            if($yenimi == 1){
//                 $dataYet = $this->AlteratifBirim($yeterlilik_id);
//                 $alternatifTipi = $this->AlternatifTipi($yeterlilik_id);
                $zorunluBirims =$dataYet[1];
                $secmeliBirims = $dataYet[0];
                $basariliZorunluBirimler = $this->BelgeHakkiAdayBirimler($zorunluBirims, $tckn,1,$yeterlilik_id);
                $basariliSecmeliBirimler = $this->BelgeHakkiAdayBirimler($secmeliBirims, $tckn,1,$yeterlilik_id);
                if(count($basariliZorunluBirimler) != count($zorunluBirims)){
                    $sonuc=false;
                } else {
                    $sonuc=true;
                }
                
                if ($sonuc and count($secmeliBirims)>0){
                    
                   if($alternatifTipi[0] == 1){
                       if(count($basariliSecmeliBirimler) < $alternatifTipi[1]){
                           $sonuc = false;
                       }
                   }else{
                   	if(count($alternatifTipi[1])>0){
                   		$basSecBirims = array();
                   		foreach($basariliSecmeliBirimler as $tow){
                   			$basSecBirims[] = $tow[0];
                   		}
                   		$sonuc = false;
                   		foreach($alternatifTipi[1] as $key=>$birimler){
                   			$say = 0;
                   			foreach($birimler as $birim){
                   				if (in_array($birim, $basSecBirims)){
                   					$say++;
                   				}
                   			}
                   			if($say == count($birimler)){
                   				$sonuc = true;
                   				break;
                   			}
                   		}	
                   	}  
                   }
                   if ($sonuc && count($basariliSecmeliBirimler)>0){
                   	return array_merge($basariliZorunluBirimler, $basariliSecmeliBirimler);
                   }
//                    else{
//                    	return $basariliZorunluBirimler;
//                    }
                }
                if ($sonuc){
                    return $basariliZorunluBirimler;
                } else {
                    return false; 
                }
             
            }
            else{
//             	$dataYet = $this->AlteratifBirim($yeterlilik_id);
//             	$alternatifTipi = $this->AlternatifTipi($yeterlilik_id);
            	$zorunluBirims =$dataYet[1];
            	$secmeliBirims = $dataYet[0];
            	$basariliZorunluBirimler = $this->BelgeHakkiAdayBirimler($zorunluBirims, $tckn,0,$yeterlilik_id);
            	$basariliSecmeliBirimler = $this->BelgeHakkiAdayBirimler($secmeliBirims, $tckn,0,$yeterlilik_id);
            	if(count($basariliZorunluBirimler) != count($zorunluBirims)){
            		$sonuc=false;
            	} else {
            		$sonuc=true;
            	}
            	
            	if ($sonuc and count($secmeliBirims)>0){
            	
            		if($alternatifTipi[0] == 1){
            			if(count($basariliSecmeliBirimler) < $alternatifTipi[1]){
            				$sonuc = false;
            			}
            		} else {
            			$sonuc = false;
            			foreach($alternatifTipi[1] as $birimler){
            				$say = 0;
            				foreach($birimler as $birim){
            					if (in_array($birim, $basariliSecmeliBirimler)){
            						$say++;
            					}
            				}
            				if($say == count($birimler)){
            					$sonuc = true;
            					break;
            				}
            			}
            			 
            		}
            		if ($sonuc && count($basariliSecmeliBirimler)>0){
            			return array_merge($basariliZorunluBirimler, $basariliSecmeliBirimler);
            		}
            	}
            	if ($sonuc){
            		return $basariliZorunluBirimler;
            	} else {
            		return false;
            	}
            }
            
        }
        
        function EskiBelgeHakkiBirimTur($yeterlilik_id,$tckn){
        	$_db = JFactory::getOracleDBO ();
        	
        	$sql = "SELECT DISTINCT SINAV_TURU_KODU FROM M_BELGELENDIRME_ADAY_BILDIRIM 
        			WHERE BIRIM_ID IN (SELECT YETERLILIK_ALT_BIRIM_ID FROM M_YETERLILIK_ALT_BIRIM WHERE YETERLILIK_ID = ?, YETERLILIK_ZORUNLU = 1) 
        			AND BASARI_DURUMU = 1 AND TC_KIMLIK = ?";
        	$zorunluTur = $_db->prep_exec($sql, array($yeterlilik_id,$tckn));
        	
        	$sql = "SELECT DISTINCT SINAV_TURU_KODU FROM M_BELGELENDIRME_ADAY_BILDIRIM
        			WHERE BIRIM_ID IN (SELECT YETERLILIK_ALT_BIRIM_ID FROM M_YETERLILIK_ALT_BIRIM WHERE YETERLILIK_ID = ?, YETERLILIK_ZORUNLU = 0)
        			AND BASARI_DURUMU = 1 AND TC_KIMLIK = ?";
        	$secmeliTur = $_db->prep_exec($sql, array($yeterlilik_id,$tckn));
        	$data = array();
        	$data[1] = $zorunluTur;
        	$data[0] = $secmeliTur;
        	return $data;
        }
        
        function EskiYeterlilikBirims($yeterlilik_id){
        	$_db = JFactory::getOracleDBO ();
        	$sql = "SELECT YETERLILIK_ALT_BIRIM_ID AS BIRIM_ID FROM M_YETERLILIK_ALT_BIRIM WHERE YETERLILIK_ID = ?";
        	return $_db->prep_exec($sql, array($yeterlilik_id));
        }
        
        function AlteratifBirim($yeterlilik_id) {
            $_db = JFactory::getOracleDBO ();
            
            $sql = "SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
            $yenimi = $_db->prep_exec($sql,array($yeterlilik_id));
            $yeni_mi=$yenimi[0]["YENI_MI"];
            
            if ($yeni_mi=="1"){
                $sql= "select birim_id, birim_kodu, zorunlu from m_birim join M_YETERLILIK_BIRIM using (birim_id)  where yeterlilik_id=".$yeterlilik_id;
                $birimler=$_db->prep_exec($sql, array());

                foreach ($birimler as $row){
                        $sql="select OLC_DEG_HARF, OLC_DEG_NUMARA from M_BIRIM_OLCME_DEGERLENDIRME where BIRIM_ID=".$row["BIRIM_ID"];
                        $sinav_kodlari=$_db->prep_exec($sql, array());
                        foreach ($sinav_kodlari as $row2){
                                if ($row2["OLC_DEG_HARF"]!="D"){
                                    if($row['ZORUNLU'] == 0){
                                        $yeterlilik[0][$row["BIRIM_ID"]][]=$row2["OLC_DEG_HARF"].$row2["OLC_DEG_NUMARA"];
                                    }
                                    else{
                                        $yeterlilik[1][$row["BIRIM_ID"]][]=$row2["OLC_DEG_HARF"].$row2["OLC_DEG_NUMARA"];
                                    }
                                }
                        }
                }

            } else {
                $sql="select yeterlilik_alt_birim_id as birim_id,yeterlilik_alt_birim_no as birim_kodu, 
                		yeterlilik_zorunlu as zorunlu 
                		from m_yeterlilik_alt_birim where yeterlilik_id=".$yeterlilik_id;
                $birimler=$_db->prep_exec($sql, array());
                foreach ($birimler as $row){
                	$sql = "SELECT * FROM M_YETERLILIK_ALT_BIRIM_TUR WHERE BIRIM_ID = ?";
                	$sinav_kodlari = $_db->prep_exec($sql, array($row["BIRIM_ID"]));
                	
                	foreach ($sinav_kodlari as $row2){
                		if($row['ZORUNLU'] == 0){
                			$yeterlilik[0][$row["BIRIM_ID"]][] = $row2['TUR_KODU'];
                		}
                		else{
                			$yeterlilik[1][$row["BIRIM_ID"]][] = $row2["TUR_KODU"];
                		}	
                	}
                }
            }
            
            return $yeterlilik;
        }
        
        function YeterlilikYenimi($yeterlilik_id){
            $_db = JFactory::getOracleDBO ();
            
            $sql = "SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
            $data = $_db->prep_exec($sql,array($yeterlilik_id));
            return $data[0]['YENI_MI'];
        }
        
        function BelgeHakkiAdayBirimler($data, $tckn, $yenimi, $yeterlilik_id){        
            $_db = JFactory::getOracleDBO ();
            if ($yenimi==1){
            	foreach ($data as $birim_id=>$sinavTurleri){
            		$sqlBirimTur = "SELECT * FROM M_BIRIM_ALTERNATIF_TUR WHERE BIRIM_ID = ? ORDER BY ALTERNATIF_TUR_ID ASC";
            		$biriTur = $_db->prep_exec($sqlBirimTur, array($birim_id));
            		$turler = array();
            		if($biriTur){
            			foreach ($biriTur as $till){
            				$turler[$till['ALTERNATIF_TUR_ID']][] = $till['BIRIM_TUR'].$till['BIRIM_NUMARA'];
            			}
            			
            			foreach ($turler as $fill){
            				$sinavId=array();
            				foreach ($fill as $till){
            					$sql="select KURULUS_ID, SINAV_TARIHI from M_BELGELENDIRME_ADAY_BILDIRIM
	                        		where TC_KIMLIK = ? and BIRIM_ID = ? and SINAV_TURU_KODU = ? and BASARI_DURUMU = 1 
									and YETERLILIK_ID = ? and SINAV_TARIHI >= (SELECT SYSDATE-365 FROM DUAL) and rownum=1
	                                order by SINAV_TARIHI desc";
            					$param = array($tckn,$birim_id,$till,$yeterlilik_id);
            					$sinav = $_db->prep_exec($sql, $param);
            					
            					foreach ($sinav as $value) {
            						if(!in_array($till,$sinavId[$birim_id])){
            							$sinavId[$birim_id][]=$till;
            							if ($sinav[0]['SINAV_TARIHI']){
            								$tarih[$birim_id]=$sinav[0]['SINAV_TARIHI'];
            							}
            						}
            					}
            				}
            				
            				foreach ($sinavId as $row){
            					if (count($row) == count($fill)){
            						if(!in_array($birim_id, $basariliBirimKontrol)){
            							$basariliBirim[]=array($birim_id,$tarih[$birim_id]);
            							$basariliBirimKontrol[]=$birim_id;
            						}
            					}
            					
            				}
            			}
            		}
            		else{
	                    $sinavId=array();
	                    foreach ($sinavTurleri as $sinavTuru){
	                        $sql="select KURULUS_ID, SINAV_TARIHI from M_BELGELENDIRME_ADAY_BILDIRIM"
	                                . " where TC_KIMLIK = ?"
	                                . " and BIRIM_ID = ?"
	                                . " and SINAV_TURU_KODU = ?"
	                                . " and BASARI_DURUMU = 1"
									. " and YETERLILIK_ID = ?"
	                                . " and SINAV_TARIHI >= (SELECT SYSDATE-365 FROM DUAL)
	                               and rownum=1
	                                order by SINAV_TARIHI desc";
	                        $param = array($tckn,$birim_id,$sinavTuru,$yeterlilik_id);
	                        $sinav = $_db->prep_exec($sql, $param);
	
	                        foreach ($sinav as $value) {
	                            if(!in_array($sinavTuru,$sinavId[$birim_id])){
	                                $sinavId[$birim_id][]=$sinavTuru;
	                                if ($sinav[0]['SINAV_TARIHI']){
	                                	$tarih[$birim_id]=$sinav[0]['SINAV_TARIHI'];
	                                }
	                            }
	                        }
	                        
	                    }
	                    foreach ($sinavId as $row){
	                        if (count($row) == count($sinavTurleri)){
	                            if(!in_array($birim_id, $basariliBirimKontrol)){
	                                $basariliBirim[]=array($birim_id,$tarih[$birim_id]);
	                                $basariliBirimKontrol[]=$birim_id;
	                            }
	                        }
	                    }
            		} 
                }
            } else {
            	foreach ($data as $birim_id=>$sinavTurleri){
            		$sinavId=array();
            		foreach ($sinavTurleri as $till){
            					$sql="select KURULUS_ID, SINAV_TARIHI from M_BELGELENDIRME_ADAY_BILDIRIM
	                        		where TC_KIMLIK = ? and BIRIM_ID = ? and SINAV_TURU_KODU = ? and BASARI_DURUMU = 1 
									and YETERLILIK_ID = ? and SINAV_TARIHI >= (SELECT SYSDATE-365 FROM DUAL) and rownum=1
	                                order by SINAV_TARIHI desc";
            					$param = array($tckn,$birim_id,$till,$yeterlilik_id);
            					$sinav = $_db->prep_exec($sql, $param);
            					
            					foreach ($sinav as $value) {
            						if(!in_array($till,$sinavId[$birim_id])){
            							$sinavId[$birim_id][]=$till;
            							if ($sinav[0]['SINAV_TARIHI']){
            								$tarih[$birim_id]=$sinav[0]['SINAV_TARIHI'];
            							}
            						}
            					}
            				}
            				
            				foreach ($sinavId as $row){
            					if (count($row) == count($sinavTurleri)){
            						if(!in_array($birim_id, $basariliBirimKontrol)){
            							$basariliBirim[]=array($birim_id,$tarih[$birim_id]);
            							$basariliBirimKontrol[]=$birim_id;
            						}
            					}
            				}			
            	}
            }
                return $basariliBirim;
        }

        function AlternatifTipi($yeterlilik_id){
            $_db = JFactory::getOracleDBO ();
            
            $sql = "SELECT ALTERNATIF_TIPI, MIN_SECMELI_BIRIM_SAYISI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
            $data = $_db->prep_exec($sql,array($yeterlilik_id));
            if($data[0]['ALTERNATIF_TIPI'] == 1){
                return array(1,$data[0]['MIN_SECMELI_BIRIM_SAYISI']);
            }
            else{
                $alternatifBirimler = array();
                $sql = "SELECT ALTERNATIF_ID FROM M_YETERLILIK_ALTERNATIF WHERE YETERLILIK_ID = ?";
                $alterneatifler = $_db->prep_exec($sql,array($yeterlilik_id));
                foreach ($alterneatifler as $alternatifId) {
                    $sql = "SELECT BIRIM_ID FROM M_YETERLILIK_ALTERNATIF_BIRIM WHERE ALTERNATIF_ID = ?";
                    $altBirimler = $_db->prep_exec($sql,array($alternatifId['ALTERNATIF_ID']));
                    
                    if(count($altBirimler)>0){
                    	foreach ($altBirimler as $birimId) {
                    		$alternatifBirimler[$alternatifId['ALTERNATIF_ID']][] = $birimId['BIRIM_ID'];
                    	}
                    }else{
                    	$alternatifBirimler[$alternatifId['ALTERNATIF_ID']] = null;
                    }
                }
                return array(2,$alternatifBirimler);
            }
        }
        
        function BelgesiVarmi($post){
            $_db = JFactory::getOracleDBO ();
            
            $tckn = $post['tckn'];
            $yeterlilik_id = $post['yeterlilik_id'];
            
            $sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE TC_KIMLIK=? AND YETERLILIK_ID=? AND DURUM=1";
            return $_db->prep_exec($sql,array($tckn,$yeterlilik_id));
        }
        
        function getBelgelendirmeBekleyenKuruluslar($user_id){
        	 $_db = JFactory::getOracleDBO ();
        	 
        	 if($user_id != 40){

	        	 $sqlGorev = "SELECT DISTINCT KURULUS_ID FROM M_KURULUS_GOREVLI WHERE TGUSERID = ?";
	        	 
	        	 $gorevli = $_db->prep_exec_array($sqlGorev, array($user_id)); 
	        	 
	        	 $sql = "SELECT DISTINCT M_KURULUS.* FROM M_KURULUS 
	        	 		JOIN M_BELGELENDIRME_HAK_KAZANANLAR ON USER_ID = KURULUS_ID 
	        	 		WHERE DURUM=1 AND M_KURULUS.USER_ID IN (".implode(',', $gorevli).")";
	        	 return $_db->prep_exec($sql,array());
        	 }else{
        	 	$sql = "SELECT DISTINCT M_KURULUS.* FROM M_KURULUS
	        	 		JOIN M_BELGELENDIRME_HAK_KAZANANLAR ON USER_ID = KURULUS_ID
	        	 		WHERE DURUM=1";
        	 	return $_db->prep_exec($sql,array());
        	 }
        }
        
        function KurulusSinavlar($post){
            $_db = JFactory::getOracleDBO ();
            
            $kurulus_id = $post['kurulus_id'];
            $durum_id = $post['durum_id'];
            
            $sql = "SELECT DISTINCT M_BELGELENDIRME_SINAV.*,YETERLILIK_KODU, YETERLILIK_ADI FROM M_BELGELENDIRME_SINAV 
                   JOIN M_BELGELENDIRME_HAK_KAZANANLAR ON M_BELGELENDIRME_SINAV.SINAV_ID = M_BELGELENDIRME_HAK_KAZANANLAR.SINAV_ID
                   JOIN M_YETERLILIK ON M_BELGELENDIRME_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
                   WHERE M_BELGELENDIRME_HAK_KAZANANLAR.DURUM = ? AND M_BELGELENDIRME_SINAV.KURULUS_ID = ?";
            return $_db->prep_exec($sql,array($durum_id,$kurulus_id));
        }
        
        function BelgeAdayGetir($post){
            $_db = JFactory::getOracleDBO ();
            
            $sinavId = $post['sinavId'];
            $kurulusId = $post['kurulusId'];
            $durum_id = $post['durum_id'];
            if ($sinavId>0){
                $sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR "
                        . "JOIN M_BELGELENDIRME_OGRENCI USING(TC_KIMLIK) "
                        . "WHERE SINAV_ID=? AND DURUM = ?";
                $data= $_db->prep_exec($sql,array($sinavId,$durum_id));
            } else {
                $sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR "
                        . "JOIN M_BELGELENDIRME_OGRENCI USING(TC_KIMLIK) "
                        . "WHERE KURULUS_ID=? AND DURUM = ? AND SINAV_ID NOT IN (SELECT SINAV_ID FROM M_BELGELENDIRME_SINAV WHERE KURULUS_ID=?)";
                $data= $_db->prep_exec($sql,array($kurulusId,$durum_id,$kurulusId));
            }
            return $data;
        }
        
        function BelgeAdayBirimler($post){
            $_db = JFactory::getOracleDBO ();
            
            $hakId = $post['hakId'];
            
            $sql = "SELECT DISTINCT YENI_MI FROM M_YETERLILIK "
                    . "JOIN M_BELGELENDIRME_HAK_KAZANANLAR USING(YETERLILIK_ID) "
                    . " WHERE ID=?";
            
            $yeni_mi = $_db->prep_exec($sql,array($hakId));
            $yenimi = $yeni_mi[0]['YENI_MI'];
            
            if($yenimi == 1){
                $sql = "SELECT BIRIM_KODU,BIRIM_ADI FROM M_BELGELENDIRME_BASARILI_BIRIM 
                		JOIN M_BIRIM USING(BIRIM_ID) 
                		WHERE HAK_KAZANAN_ID=? ORDER BY BIRIM_ID"; 
            }
            else{
                 $sql = "SELECT M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU, M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI FROM M_BELGELENDIRME_BASARILI_BIRIM 
                 		JOIN M_YETERLILIK_ALT_BIRIM ON M_BELGELENDIRME_BASARILI_BIRIM.BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID 
                 		WHERE HAK_KAZANAN_ID=? ORDER BY YETERLILIK_ALT_BIRIM_ID";
            }
            return $_db->prep_exec($sql,array($hakId));
        }
        
        function BelgeSablonGetir($post){
            $_db = JFactory::getOracleDBO ();
            
            $sinavId = $post['sinavId'];
            $kurulusId = $post['kurulusId'];
            if ($sinavId>0){
                $sql = "SELECT * FROM M_BELGELENDIRME_KURULUS_SABLON "
                        . "WHERE KURULUS_ID=(SELECT KURULUS_ID FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID=?) "
                        . "AND YETERLILIK_ID =(SELECT YETERLILIK_ID FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID=?)";
                $data = $_db->prep_exec($sql,array($sinavId,$sinavId));
                if(!$data){
                    $sql = "SELECT KURULUS_ADI,AKREDITASYON_NO,KURULUS_LOGO,MYK_MARKASI,TURKAK_MARKASI FROM M_BELGELENDIRME_KURULUS_SABLON "
                        . "WHERE KURULUS_ID=(SELECT KURULUS_ID FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID=?) "
                        . "AND rownum=1 ORDER BY ID DESC";
                    $data = $_db->prep_exec($sql,array($sinavId));
                }
            } else {
                $sql = "SELECT KURULUS_ADI,AKREDITASYON_NO,KURULUS_LOGO,MYK_MARKASI,TURKAK_MARKASI FROM M_BELGELENDIRME_KURULUS_SABLON "
                        . "WHERE KURULUS_ID=? "
                        . "AND rownum=1 ORDER BY ID DESC";
                    $data = $_db->prep_exec($sql,array($kurulusId));
            }
            return $data;
        }
        
        function BelgeAdaylariKaydet($post,$file){
            $_db = JFactory::getOracleDBO ();
            
            $sinavId = $post['belgeSinav'];
//             $imzaYetkili = $post['imzaYetkili'];
//             $turkak = $post['turkak'];
//             $yetkino = $post['yetkino'];
//             $yetkitarih = $post['yetkitarih'];
            
//             $kurAdi = $post['kurAdi'];
            
            $belgeAday = $post['belgeAday'];
            
//             $turkakPath = $post['turkakPath'];
//             $mykPath = $post['mykPath'];
            
            $sqlKurs = "SELECT * FROM M_BELGELENDIRME_SINAV
          			JOIN M_KURULUS ON M_BELGELENDIRME_SINAV.KURULUS_ID = M_KURULUS.USER_ID
					JOIN M_BELGELENDIRME_KURULUS_SABLON ON M_BELGELENDIRME_SINAV.KURULUS_ID = M_BELGELENDIRME_KURULUS_SABLON.KURULUS_ID
          			JOIN M_BELGELENDIRME_IMZA_YETKILI ON M_BELGELENDIRME_SINAV.SINAV_ID = M_BELGELENDIRME_IMZA_YETKILI.SINAV_ID
            		JOIN M_YETERLILIK ON M_BELGELENDIRME_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
					WHERE M_BELGELENDIRME_SINAV.SINAV_ID = ?";
            $kurs = $_db->prep_exec($sqlKurs, array($sinavId));
            
//             if($file['mykMarka']['type'] != 'image/png' && $file['mykMarka']['type'] != 'image/jpeg' && empty($mykPath)){
//             	return array('hata'=>'Yüklemek istediğiniz MYK Markası (.png veya .jpg) formatında değildir. Bundan dolayı işleminiz gerçekleşmemiştir.');
//             }
            
//             if($file['turkakMarka']['type'] != 'image/png' && $file['turkakMarka']['type'] != 'image/jpeg' && empty($turkakPath)){
//             	return array('hata'=>'Yüklemek istediğiniz TÜRKAK Markası (.png veya .jpg) formatında değildir. Bundan dolayı işleminiz gerçekleşmemiştir.');
//             }
            
//             if($file['mykMarka']['size']>0 && $file['mykMarka']['type'] == 'image/png'){
//             	//$mykPath = date('now')."-1.png";
//             	$mykPath = $kurs[0]['KURULUS_YETKILENDIRME_NUMARASI']."-m.png";
//             	move_uploaded_file($file['mykMarka']['tmp_name'], EK_FOLDER."logolar/".$mykPath);
//             }
//             else if($file['mykMarka']['size']>0 && $file['mykMarka']['type'] == 'image/jpeg'){
//             	//$mykPath = date('now')."-1.jpg";
//             	$mykPath = $kurs[0]['KURULUS_YETKILENDIRME_NUMARASI']."-m.jpg";
//             	move_uploaded_file($file['mykMarka']['tmp_name'], EK_FOLDER."logolar/".$mykPath);
//             }
            
//             if($file['turkakMarka']['size']>0 && $file['turkakMarka']['type'] == 'image/png'){
//             	//$turkakPath = date('now')."-2.png";
//             	$turkakPath = $kurs[0]['KURULUS_YETKILENDIRME_NUMARASI']."-T.png";
//             	move_uploaded_file($file['turkakMarka']['tmp_name'], EK_FOLDER."logolar/".$turkakPath);
//             }
//             else if($file['turkakMarka']['size']>0 && $file['turkakMarka']['type'] == 'image/jpeg'){
//             	//$turkakPath = date('now')."-2.jpg";
//             	$turkakPath = $kurs[0]['KURULUS_YETKILENDIRME_NUMARASI']."-T.jpg";
//             	move_uploaded_file($file['turkakMarka']['tmp_name'], EK_FOLDER."logolar/".$turkakPath);
//             }
//            if($sinavId != -1){ 
// 	           $sql = "DELETE FROM M_BELGELENDIRME_KURULUS_SABLON "
// 	                    . "WHERE KURULUS_ID=(SELECT KURULUS_ID FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID=?) "
// 	                    . "AND YETERLILIK_ID =(SELECT YETERLILIK_ID FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID=?)";
// 	           $_db->prep_exec($sql,array($sinavId,$sinavId));
	           
// 	           $sql = "INSERT INTO M_BELGELENDIRME_KURULUS_SABLON (KURULUS_ID,YETERLILIK_ID,IMZA_YETKILISI, AKREDITASYON_NO, KURULUS_ADI, YETKILENDIRME_NO, MYK_MARKASI, TURKAK_MARKASI) "
// 	                   . "VALUES((SELECT KURULUS_ID FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID=?),(SELECT YETERLILIK_ID FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID=?),?,?,?,?,?,?)";
	            
// 	           $param = array($sinavId, $sinavId, $imzaYetkili,$turkak, $kurAdi, $yetkino, $mykPath, $turkakPath);
	           
// 	           $_db->prep_exec_insert($sql, $param);
//            }
//            else{
// 	           	$sql = "DELETE FROM M_BELGELENDIRME_KURULUS_SABLON "
// 	           			. "WHERE KURULUS_ID=(SELECT KURULUS_ID FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID=?) "
// 	           			. "AND YETERLILIK_ID =(SELECT YETERLILIK_ID FROM M_BELGELENDIRME_SINAV WHERE SINAV_ID=?)";
// 	           	$_db->prep_exec($sql,array($sinavId,$sinavId));
	           	
// 	           	$sql = "INSERT INTO M_BELGELENDIRME_KURULUS_SABLON (KURULUS_ID,YETERLILIK_ID,IMZA_YETKILISI, AKREDITASYON_NO, KURULUS_ADI, YETKILENDIRME_NO, MYK_MARKASI, TURKAK_MARKASI) "
// 	           			. "VALUES(?,?,?,?,?,?,?,?)";
	           	 
// 	           	$param = array($sinavId, $sinavId, $imzaYetkili,$turkak, $kurAdi, $yetkino, $mykPath, $turkakPath);
	           	
// 	           	$_db->prep_exec_insert($sql, $param);
//            }
           ///////////////////// Aday belge nolarını verme ///////////////////////////
           
            
           $matbaaId = $_db->getNextVal('SEQ_MATBAA');
           
           $sqlMatbaa = "INSERT INTO M_BELGELENDIRME_MATBAA (MATBAA_ID, MATBAA_DURUM, SINAV_ID) VALUES(?,?,?)";
           $_db->prep_exec_insert($sqlMatbaa, array($matbaaId, 1, $sinavId));
//            matbaa kullanıcı id = 178;
           $aciklamaText=$kurs[0]['KURULUS_ADI']." kuruluşunun ".$sinavId." Sınav ID'li yapmış olduğu ".$kurs[0]['YETERLILIK_KODU']." - ".$kurs[0]['YETERLILIK_ADI']." yeterlilik sınavı için yüklenmiş olan dekont onaylanarak başarılı aday listesi matbaaya iletildi. ";
           FormFactory::sektorSorumlusunaNotificationGonder($aciklamaText, 'index.php?option=com_matbaa&view=matbaa&layout=basilacak', 178);
           
           /********************************* Matbaaya Mail Bildirimi ********************************************************/
           $mysqlDB = &JFactory::getDBO();
           $sqlMatbaa= "SELECT email FROM #__users WHERE tgUserId = 178";
			$mysqlDB->setQuery($sqlMatbaa);
			$matbaaUser = $mysqlDB->loadResult();
			
			$sqlGorevli = "SELECT * FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
			$gorevli = $_db->prep_exec($sqlGorevli, array($kurs[0]['USER_ID']));
			
			$mailGorevli = array($matbaaUser,'mordukaya@myk.gov.tr','ktunc@myk.gov.tr');
			foreach($gorevli as $tow){
				$sqlMatbaa= "SELECT email FROM #__users as users
					WHERE tgUserId = ".$tow['TGUSERID'];
				$mysqlDB->setQuery($sqlMatbaa);
				$matbaaUser = $mysqlDB->loadObjectList();
				$mailGorevli[] = $matbaaUser[0]->email;
			}
			
			//$to = array($matbaaUser,'mordukaya@myk.gov.tr','ktunc@myk.gov.tr');
			$to = $mailGorevli;
			$baslik = $kurs[0]['KURULUS_ADI'].' Belge Basım Başvurusu Yapıldı.';
			$icerik = $aciklamaText;
				
			FormFactory::sentEmail($baslik,$icerik,$to);
			
// 			$recipient = array($matbaaUser,'sbdportal@myk.gov.tr','ktunc@myk.gov.tr');
			
// 			$mailer =& JFactory::getMailer();
			
// 			$config =& JFactory::getConfig();
// 			$sender = array(
// 					$config->getValue( 'config.mailfrom' ),
// 					$config->getValue( 'config.fromname' ) );
// 			$mailer->setSender($sender);
			
// 			//$recipient = 'bim@myk.gov.tr';
// 			$mailer->addRecipient($recipient);
			
// 			$mailer->setSubject($kurs[0]['KURULUS_ADI'].' Belge Basım Başvurusu Yapıldı.');
// 			$mailer->setBody($aciklamaText);
			
// 			$send =& $mailer->Send();
			
			/*************************************** Matbaaya Mail Bildirimi SON ****************************************************************/
           
           
           $directory = EK_FOLDER.'sinavBelgeQRcode/'.$matbaaId;
           if (!file_exists($directory)){
           	mkdir($directory, 0700,true);
           }
           
           $zip = new ZipArchive();
           $zip->open($directory.'/'.$matbaaId.'.zip', ZipArchive::CREATE);
           
           $pngPath = array();
           
           foreach($belgeAday as $adayHak){
               
               $sql = "SELECT * FROM M_BELGELENDIRME_OGRENCI 
                        JOIN M_BELGELENDIRME_HAK_KAZANANLAR USING(TC_KIMLIK)
                        JOIN M_YETERLILIK USING(YETERLILIK_ID) WHERE ID=?";
               $adayBilgi = $_db->prep_exec($sql,array($adayHak));
               
//                 $sonBelgeNo = 0;

//                 $sql = "SELECT YETERLILIK_KODU,BASLANGIC_KRITERI,GECERLILIK_SURESI FROM M_YETERLILIK "
//                     . "JOIN M_BELGELENDIRME_HAK_KAZANANLAR USING(YETERLILIK_ID) "
//                     . "WHERE ID =?";
//                 $yeterlilik = $_db->prep_exec($sql,array($adayHak));
//                 $yetkod = $yeterlilik[0]['YETERLILIK_KODU'];

//                 $yetkodId=substr($yetkod,strpos($yetkod,"Y")+1,6);

//                 $sql = "SELECT * FROM M_BELGELENDIRME_BELGE_NO WHERE YETKOD = ?";
//                 $data = $_db->prep_exec($sql,array($yetkodId));

//                 if($data){
//                     $sonBelgeNo = $data[0]['BELGENO'];
//                 }//yoksa
//                 else{
//                      $sql = "SELECT BELGENO FROM M_BELGE_SORGU WHERE BELGENO LIKE '%".$yetkodId."%' AND rownum = 1 ORDER BY BELGENO DESC";
//                      $data = $_db->prep_exec($sql,array());
//                      if($data){
//                         $sonBelgeNo = substr($data[0]['BELGENO'],strpos($data[0]['BELGENO'],"/")+1);
//                      }
//                      $sonBelgeNo = (int)$sonBelgeNo;
//                      $sql="INSERT INTO M_BELGELENDIRME_BELGE_NO (YETKOD,BELGENO) VALUES(?,?)";
//                      $_db->prep_exec_insert($sql, array($yetkodId,$sonBelgeNo));
//                 }
//                 $sonBelgeNo = (int)$sonBelgeNo;
//                 $sonBelgeNo++;
//                 $noUzun = 5-strlen($sonBelgeNo);
//                 $noSifir = '';
//                 for($i = 0; $i<$noUzun;$i++){
//                 	$noSifir .= '0';
//                 }
//                 $belgeNoSon = 'UY'.$yetkodId.'/'.$noSifir.$sonBelgeNo;

//                 $gcSuresi = 5;
//                 if($yeterlilik[0]['BASLANGIC_KRITERI'] == 2){
//                     if($yeterlilik[0]['GECERLILIK_SURESI'] == 0 || empty($yeterlilik[0]['GECERLILIK_SURESI'])){
//                         $date = strtotime("+$gcSuresi year",  strtotime(str_replace('/','-',$yetkitarih)));
//                     }
//                     else{
//                         $date = strtotime("+$yeterlilik[0]['GECERLILIK_SURESI'] year",  strtotime(str_replace('/','-',$yetkitarih)));
//                     }
//                     $date = date('d/m/Y',strtotime('-1 day',$date));
//                 }
//                 else if($yeterlilik[0]['BASLANGIC_KRITERI'] == 1){
//                      if($yeterlilik[0]['GECERLILIK_SURESI'] == 0 || empty($yeterlilik[0]['GECERLILIK_SURESI'])){
//                         $date = strtotime("+$gcSuresi year",  strtotime(str_replace('/','-',$adayBilgi[0]['SINAV_TARIHI'])));
//                     }else{
//                         $date = strtotime("+$yeterlilik[0][GECERLILIK_SURESI] year",  strtotime(str_replace('/','-',$adayBilgi[0]['SINAV_TARIHI'])));
//                     }
//                     $date = date('d/m/Y',strtotime('-1 day',$date));
//                 }

                if(empty($adayBilgi[0]['GECERLILIK_SURESI'])){
                	$gcSuresi = 5;
                }else{
                	$gcSuresi = $adayBilgi[0]['GECERLILIK_SURESI'];
                }

                
                $date = strtotime("+$gcSuresi year",  strtotime(str_replace('/','-',$adayBilgi[0]['BELGE_BAS_TARIH'])));
                $date = date('d/m/Y',strtotime('-1 day',$date));
                
                $sql = "INSERT INTO M_BELGE_SORGU (TCKIMLIKNO,AD,SOYAD,BELGENO,YETERLILIK_ADI,YETERLILIK_SEVIYESI,SINAV_TARIHI,BELGE_DUZENLEME_TARIHI,GECERLILIK_TARIHI,BELGELENDIRME_KURULUSU,KURULUS_ID,YETERLILIK_ID,IMZA_YETKILISI,AKREDITASYON_NO,KURULUS_ADI,YETKILENDIRME_NO,MYK_MARKASI,TURKAK_MARKASI,YK_TARIH) "
                        . "VALUES(?,?,?,?,?,?,TO_DATE(?,'dd/mm/yyyy'),TO_DATE(?,'dd/mm/yyyy'),TO_DATE(?,'dd/mm/yyyy'),?,?,?,?,?,?,?,?,?,TO_DATE(?,'dd/mm/yyyy'))";
                
                $param = array($adayBilgi[0]['TC_KIMLIK'],
                    $adayBilgi[0]['ADI'],
                    $adayBilgi[0]['SOYADI'],
                    $adayBilgi[0]['BELGE_NO'],
                    $adayBilgi[0]['YETERLILIK_ADI'],
                    (int)$adayBilgi[0]['SEVIYE_ID'],
                    $adayBilgi[0]['SINAV_TARIHI'],
                    $adayBilgi[0]['BELGE_BAS_TARIH'],
                    $date,
                    $kurs[0]['KURULUS_ADI'],
                    $adayBilgi[0]['KURULUS_ID'],
                    $adayBilgi[0]['YETERLILIK_ID'],
                    $kurs[0]['YETKILI_AD'].' '.$kurs[0]['YETKILI_SOYAD'],
                    $kurs[0]['AKREDITASYON_NO'],
                    $kurs[0]['KURULUS_ADI'],
                    $kurs[0]['KURULUS_YETKILENDIRME_NUMARASI'],
                    $kurs[0]['MYK_MARKASI'],
                    $kurs[0]['TURKAK_MARKASI'],
                    date("d/m/Y"));
                
                $_db->prep_exec_insert($sql,$param);
                
                $belgeUrl = 'http://portal.myk.gov.tr/index.php?option=com_belgelendirme&view=belge_sorgula&layout=belgeno_sorgu&belgeno='.$adayBilgi[0]['BELGE_NO'];
                $QRAD = trim(str_replace("/","#",$adayBilgi[0]['BELGE_NO']));
                $path = $directory.'/'.$QRAD.'.png';
                QRcode::png($belgeUrl,$path,QR_ECLEVEL_H,3,1);
                
                $zip->addFile($path,$QRAD.'.png');
                //$this->qrCodeBelge($get);
                
                $sql = "UPDATE M_BELGELENDIRME_HAK_KAZANANLAR SET DURUM = 2, MATBAA_ID = ? WHERE ID=?";
                $_db->prep_exec_insert($sql,array($matbaaId,$adayHak));
                
//                 $sql = "UPDATE M_BELGELENDIRME_BELGE_NO SET BELGENO=? WHERE YETKOD=?";
//                 $_db->prep_exec_insert($sql,array($sonBelgeNo,$yetkodId));
            }
           ///////////////////// Aday belge nolarını verme ///////////////////////////
           $zip->close();
           
           if($sinavId == -1){
           		return $sinavId;
           }
            $sql = "SELECT DISTINCT * FROM M_BELGE_SORGU
						JOIN M_BELGELENDIRME_OGRENCI ON M_BELGE_SORGU.TCKIMLIKNO = M_BELGELENDIRME_OGRENCI.TC_KIMLIK
						JOIN M_BELGELENDIRME_HAK_KAZANANLAR ON (M_BELGE_SORGU.TCKIMLIKNO = M_BELGELENDIRME_HAK_KAZANANLAR.TC_KIMLIK AND M_BELGE_SORGU.BELGENO = M_BELGELENDIRME_HAK_KAZANANLAR.BELGE_NO)
						WHERE M_BELGELENDIRME_HAK_KAZANANLAR.SINAV_ID = ? AND M_BELGELENDIRME_HAK_KAZANANLAR.DURUM = 2";
            return $_db->prep_exec($sql,array($sinavId));
            //return true;
        }
        
        function getBelgelendirmeYapilanKuruluslar(){
        	$_db = JFactory::getOracleDBO ();
        	
        	$sql = "SELECT DISTINCT M_KURULUS.* FROM M_KURULUS
        	 		JOIN M_BELGELENDIRME_HAK_KAZANANLAR ON USER_ID = KURULUS_ID
        	 		WHERE DURUM=2";
        	return $_db->prep_exec($sql,array());
        }
        
        function getAdayBelgeExcel($get){
        	$_db = JFactory::getOracleDBO ();
        	
                $sinavId = isset($get['sinavId'])?$get['sinavId']:'';
                $hakId = isset($get['hakId'])?$get['hakId']:'';
                $SorguID = isset($get['SorguID'])?$get['SorguID']:'';
                
                if($sinavId != '' && !empty($sinavId)){
                    $sql = "SELECT DISTINCT M_BELGE_SORGU.*,M_BELGELENDIRME_OGRENCI.*,M_BELGELENDIRME_HAK_KAZANANLAR.*,M_YETERLILIK.*,
							M_KURULUS.*, M_YETERLILIK_REVIZYON.REVIZYON_NO,M_YETERLILIK_REVIZYON.REVIZYON_DURUMU, M_YETERLILIK_REVIZYON.YETERLILIK_KODU AS YETERLILIK_REV_KOD,
							M_YETERLILIK_REVIZYON.YAYIN_TARIHI AS REV_TARIH, M_YETERLILIK_REVIZYON.REVIZYON_DURUMU
							FROM M_BELGE_SORGU
                           	JOIN M_BELGELENDIRME_OGRENCI ON M_BELGE_SORGU.TCKIMLIKNO = M_BELGELENDIRME_OGRENCI.TC_KIMLIK
                            JOIN M_BELGELENDIRME_HAK_KAZANANLAR ON (M_BELGE_SORGU.TCKIMLIKNO = M_BELGELENDIRME_HAK_KAZANANLAR.TC_KIMLIK AND M_BELGE_SORGU.BELGENO = M_BELGELENDIRME_HAK_KAZANANLAR.BELGE_NO)
                    		JOIN M_YETERLILIK ON M_BELGE_SORGU.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
                    		JOIN M_KURULUS ON M_BELGE_SORGU.KURULUS_ID = M_KURULUS.USER_ID
							LEFT JOIN M_YETERLILIK_REVIZYON ON M_YETERLILIK.YETERLILIK_ID = M_YETERLILIK_REVIZYON.YETERLILIK_ID
                            WHERE M_BELGELENDIRME_HAK_KAZANANLAR.SINAV_ID = ? AND M_BELGELENDIRME_HAK_KAZANANLAR.DURUM = 2 ORDER BY M_BELGELENDIRME_HAK_KAZANANLAR.ID ASC";
					$data = $_db->prep_exec($sql,array($sinavId));
				
				
					$sqlYetkili = "SELECT * FROM M_BELGELENDIRME_IMZA_YETKILI
									WHERE SINAV_ID = ?";
					$yetkili = $_db->prep_exec($sqlYetkili, array($sinavId));
				
					$sql = "SELECT M_KURULUS.*,M_BELGELENDIRME_KURULUS_SABLON.*  FROM M_BELGELENDIRME_SINAV
			          			JOIN M_KURULUS ON M_BELGELENDIRME_SINAV.KURULUS_ID = M_KURULUS.USER_ID
								JOIN M_BELGELENDIRME_KURULUS_SABLON ON M_BELGELENDIRME_SINAV.KURULUS_ID = M_BELGELENDIRME_KURULUS_SABLON.KURULUS_ID
								WHERE SINAV_ID =?";
					$kurData = $_db->prep_exec($sql, array($sinavId));
				
					$sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE SINAV_ID = ? AND DURUM=2";
					
					$data2 = $_db->prep_exec($sql, array($sinavId));
					
					$AdayBirims = array();
					
					if($data[0]['YENI_MI']==1){
						$sqlBirim="SELECT * FROM M_BELGELENDIRME_BASARILI_BIRIM 
								JOIN M_BIRIM USING(BIRIM_ID) WHERE HAK_KAZANAN_ID = ? ORDER BY BIRIM_KODU";
						
						foreach($data2 as $cow){
							$AdayBirims[$cow['TC_KIMLIK']] = $_db->prep_exec($sqlBirim, array($cow['ID']));
						}
					}else{
						$sqlBirim="SELECT M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_NO AS BIRIM_NO, M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, M_YETERLILIK.YETERLILIK_KODU FROM M_BELGELENDIRME_BASARILI_BIRIM
								JOIN M_YETERLILIK_ALT_BIRIM ON M_BELGELENDIRME_BASARILI_BIRIM.BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID 
								JOIN M_YETERLILIK ON M_YETERLILIK_ALT_BIRIM.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
								WHERE HAK_KAZANAN_ID = ? ORDER BY BIRIM_NO";
							
						foreach($data2 as $cow){
							$birims = $_db->prep_exec($sqlBirim, array($cow['ID']));
							for($t = 0; $t<count($birims); $t++){
								$birims[$t]['BIRIM_KODU'] = $birims[$t]['YETERLILIK_KODU'].'/'.$birims[$t]['BIRIM_NO'];
							}
							$AdayBirims[$cow['TC_KIMLIK']] = $birims;
						}
					}
					
					return array(0=>$data,1=>$yetkili[0],2=>$kurData[0],3=>$AdayBirims);
                }
                else if($hakId != '' && !empty($hakId)){
                    $sql = "SELECT DISTINCT M_BELGE_SORGU.*,M_BELGELENDIRME_OGRENCI.*,M_BELGELENDIRME_HAK_KAZANANLAR.*,M_YETERLILIK.*,
							M_KURULUS.*, M_YETERLILIK_REVIZYON.REVIZYON_NO,M_YETERLILIK_REVIZYON.REVIZYON_DURUMU, M_YETERLILIK_REVIZYON.YETERLILIK_KODU AS YETERLILIK_REV_KOD,
							M_YETERLILIK_REVIZYON.YAYIN_TARIHI AS REV_TARIH, M_YETERLILIK_REVIZYON.REVIZYON_DURUMU
							FROM M_BELGE_SORGU
                           	JOIN M_BELGELENDIRME_OGRENCI ON M_BELGE_SORGU.TCKIMLIKNO = M_BELGELENDIRME_OGRENCI.TC_KIMLIK
                            JOIN M_BELGELENDIRME_HAK_KAZANANLAR ON (M_BELGE_SORGU.TCKIMLIKNO = M_BELGELENDIRME_HAK_KAZANANLAR.TC_KIMLIK AND M_BELGE_SORGU.BELGENO = M_BELGELENDIRME_HAK_KAZANANLAR.BELGE_NO)
                    		JOIN M_YETERLILIK ON M_BELGE_SORGU.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
                    		JOIN M_KURULUS ON M_BELGE_SORGU.KURULUS_ID = M_KURULUS.USER_ID
							LEFT JOIN M_YETERLILIK_REVIZYON ON M_YETERLILIK.YETERLILIK_ID = M_YETERLILIK_REVIZYON.YETERLILIK_ID
                            WHERE M_BELGELENDIRME_HAK_KAZANANLAR.ID = ? AND M_BELGELENDIRME_HAK_KAZANANLAR.DURUM = 2 ORDER BY M_BELGELENDIRME_HAK_KAZANANLAR.ID ASC";
					$data = $_db->prep_exec($sql,array($hakId));
				
				
					$sqlYetkili = "SELECT * FROM M_BELGELENDIRME_IMZA_YETKILI
									WHERE SINAV_ID = ?";
					$yetkili = $_db->prep_exec($sqlYetkili, array($data[0]['SINAV_ID']));
				
					$sql = "SELECT M_KURULUS.*,M_BELGELENDIRME_KURULUS_SABLON.*  FROM M_BELGELENDIRME_SINAV
			          			JOIN M_KURULUS ON M_BELGELENDIRME_SINAV.KURULUS_ID = M_KURULUS.USER_ID
								JOIN M_BELGELENDIRME_KURULUS_SABLON ON M_BELGELENDIRME_SINAV.KURULUS_ID = M_BELGELENDIRME_KURULUS_SABLON.KURULUS_ID
								WHERE SINAV_ID =?";
					$kurData = $_db->prep_exec($sql, array($data[0]['SINAV_ID']));
				
					$sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE ID = ? AND DURUM=2";
					
					$data2 = $_db->prep_exec($sql, array($hakId));
					
					$AdayBirims = array();
					
					if($data[0]['YENI_MI']==1){
						$sqlBirim="SELECT * FROM M_BELGELENDIRME_BASARILI_BIRIM 
								JOIN M_BIRIM USING(BIRIM_ID) WHERE HAK_KAZANAN_ID = ? ORDER BY BIRIM_KODU";
						
						foreach($data2 as $cow){
							$AdayBirims[$cow['TC_KIMLIK']] = $_db->prep_exec($sqlBirim, array($cow['ID']));
						}
					}else{
						$sqlBirim="SELECT M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_NO AS BIRIM_NO, M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, M_YETERLILIK.YETERLILIK_KODU FROM M_BELGELENDIRME_BASARILI_BIRIM
								JOIN M_YETERLILIK_ALT_BIRIM ON M_BELGELENDIRME_BASARILI_BIRIM.BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID 
								JOIN M_YETERLILIK ON M_YETERLILIK_ALT_BIRIM.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
								WHERE HAK_KAZANAN_ID = ? ORDER BY BIRIM_NO";
							
						foreach($data2 as $cow){
							$birims = $_db->prep_exec($sqlBirim, array($cow['ID']));
							for($t = 0; $t<count($birims); $t++){
								$birims[$t]['BIRIM_KODU'] = $birims[$t]['YETERLILIK_KODU'].'/'.$birims[$t]['BIRIM_NO'];
							}
							$AdayBirims[$cow['TC_KIMLIK']] = $birims;
						}
					}
					
					return array(0=>$data,1=>$yetkili[0],2=>$kurData[0],3=>$AdayBirims);
                }
                else if($SorguID != '' && !empty($SorguID)){
                	$sql = "SELECT * FROM M_BELGE_SORGU WHERE ID=?";
                	$data = $_db->prep_exec($sql, array($SorguID));
                	$yetkili = array(0=>null);
                	$kurData = array(0=>null);
                	return array(0=>$data,1=>$yetkili[0],2=>$kurData[0],3=>null);
                }
        }
        
        function YeterlilikSinavBilgileri($sinavId){
        	$_db = JFactory::getOracleDBO ();
        	
        	$sql = "SELECT YETERLILIK_KODU,YETERLILIK_ADI,YETERLILIK_ID FROM M_YETERLILIK
        			JOIN M_BELGELENDIRME_SINAV USING(YETERLILIK_ID)
        			WHERE SINAV_ID=?";
        	return $_db->prep_exec($sql,array($sinavId));
        }
        
        function getYeterlilikwithYeterlilikId($yeterlilik_id){
        	$_db = JFactory::getOracleDBO ();
        	$sql = "SELECT DISTINCT
	YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_KODU FROM M_YETERLILIK WHERE YETERLILIK_ID=?";
        	return $_db->prep_exec($sql, array($yeterlilik_id));
        }
        
        function KurulusSinavlarTckn($post){
        	$_db = JFactory::getOracleDBO ();
            
            $tckn = $post['tckn'];
            $durum_id = $post['durum_id'];
            
            $sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR 
            		JOIN M_BELGELENDIRME_OGRENCI USING(TC_KIMLIK) 
            		JOIN M_YETERLILIK USING(YETERLILIK_ID)
            		JOIN M_BELGE_SORGU ON BELGE_NO = M_BELGE_SORGU.BELGENO 
            		WHERE TC_KIMLIK=? AND DURUM = ?";
            $data= $_db->prep_exec($sql,array($tckn,$durum_id));
            
            $belgeNoArray1 = array();
            foreach ($data as $row){
            	$belgeNoArray1[] = $row['BELGE_NO'];
            }
            
            if(count($belgeNoArray1)>0){
            	$sql = "SELECT ID, TCKIMLIKNO AS TC_KIMLIK, AD AS ADI, SOYAD AS SOYADI, YETERLILIK_ADI, BELGENO AS BELGE_NO, BELGEDURUMU, IPTAL_ACIKLAMA FROM M_BELGE_SORGU WHERE TCKIMLIKNO=? AND BELGENO NOT IN('".implode(',', $belgeNoArray1)."')";
            }else{
            	$sql = "SELECT ID, TCKIMLIKNO AS TC_KIMLIK, AD AS ADI, SOYAD AS SOYADI, YETERLILIK_ADI, BELGENO AS BELGE_NO, BELGEDURUMU, IPTAL_ACIKLAMA FROM M_BELGE_SORGU WHERE TCKIMLIKNO=?";
            }
            $data1 = $_db->prep_exec($sql, array($tckn));
            
            
            return array_merge($data,$data1);
        }
        
        function KurulusSinavlarBelgeNo($post){
        	$_db = JFactory::getOracleDBO ();
        	
        	
        	$sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR
            		JOIN M_BELGELENDIRME_OGRENCI USING(TC_KIMLIK)
            		JOIN M_YETERLILIK USING(YETERLILIK_ID)
            		WHERE BELGE_NO = ? AND DURUM = 2";
        	$data = $_db->prep_exec($sql,array($post['belgeNo']));
        	
        	if(count($data) == 0){
        		$sql = "SELECT ID, TCKIMLIKNO AS TC_KIMLIK, AD AS ADI, SOYAD AS SOYADI, YETERLILIK_ADI, BELGENO AS BELGE_NO, BELGEDURUMU, IPTAL_ACIKLAMA FROM M_BELGE_SORGU WHERE BELGENO = ?";
        		$data = $_db->prep_exec($sql, array($post['belgeNo']));
        	}
        	
        	return $data;
        }
        
        function BelgeNoAl($post){
        	$_db = JFactory::getOracleDBO ();
        	
        	$yetKod = $post['yetKod'];
        	$kacBelge = (int)$post['kacBelge'];
        	
        	$yetkodId=substr($yetKod,strpos($yetKod,"Y")+1,6);
        	
        	$sonBelgeNo = 0;
        	$belgeNumaralari = array();
        	
        	$sql = "SELECT * FROM M_BELGELENDIRME_BELGE_NO WHERE YETKOD = ?";
        	$data = $_db->prep_exec($sql,array($yetkodId));
        	if($data){
        		$sonBelgeNo = $data[0]['BELGENO'];
        	}//yoksa
        	else{
        		$sql = "SELECT BELGENO FROM M_BELGE_SORGU WHERE BELGENO LIKE '%".$yetkodId."%' AND rownum = 1 ORDER BY BELGENO DESC";
        		$data = $_db->prep_exec($sql,array());
        		if($data){
        			$sonBelgeNo = substr($data[0]['BELGENO'],strpos($data[0]['BELGENO'],"/")+1);
        		}
        		$sonBelgeNo = (int)$sonBelgeNo;
        		$sql="INSERT INTO M_BELGELENDIRME_BELGE_NO (YETKOD,BELGENO) VALUES(?,?)";
        		$_db->prep_exec_insert($sql, array($yetkodId,$sonBelgeNo));
        	}
        	
        	$sonVerilenNo = 0;
        	$noUzun = 5-strlen($sonBelgeNo);
        	$noSifir = '';
        	for($i = 0; $i<$noUzun;$i++){
        		$noSifir .= '0';
        	}
        	$sonVerilenNo = 'UY'.$yetkodId.'/'.$noSifir.$sonBelgeNo;
        	
        	
        	for($say = 0; $say < $kacBelge; $say++){
        		
	        	$sonBelgeNo = (int)$sonBelgeNo;
	        	$sonBelgeNo++;
	        	$noUzun = 5-strlen($sonBelgeNo);
	        	$noSifir = '';
	        	for($i = 0; $i<$noUzun;$i++){
	        		$noSifir .= '0';
	        	}
	        	$belgeNoSon = 'UY'.$yetkodId.'/'.$noSifir.$sonBelgeNo;
	        	$belgeNumaralari[] = $belgeNoSon;
	        	
// 	        	$sql = "UPDATE M_BELGELENDIRME_BELGE_NO SET BELGENO=? WHERE YETKOD=?";
// 	        	$_db->prep_exec_insert($sql,array($sonBelgeNo,$yetkodId));
        	}
        	return array($sonVerilenNo,$belgeNumaralari,$belgeNumaralari[count($belgeNumaralari)-1]);
        }
        
        function YeterlilikMYKWeb(){

        	$mysqli = new mysqli("localhost", "root", "767879", "mykweb");
			$mysqli->set_charset("utf8");
        	if ($mysqli->connect_errno) {
        		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        	}
        	$result = $mysqli->query('SELECT yetkod,yetname FROM yeterlilik ORDER BY yetname,yetkod');
        	while($row = mysqli_fetch_array($result))
			{
        		$yeterlilikWeb[] = array($row['yetkod'],$row['yetname']);
        	}
        	//mysqli_close($kcon);
        	$mysqli->close();
        	return $yeterlilikWeb;
        }
        
        function BelgeNoVer($post){
        	$_db = JFactory::getOracleDBO ();
        	 
        	$yetKod = $post['yetKod'];
        	$sonBelge = $post['sonBelge'];
        	
        	$yetkodId=substr($yetKod,strpos($yetKod,"Y")+1,6);
        	
        	$sonBelgeNo= substr($sonBelge,strpos($sonBelge,"/")+1);
        	
        	$sql = "UPDATE M_BELGELENDIRME_BELGE_NO SET BELGENO=? WHERE YETKOD=?";
			return $_db->prep_exec_insert($sql,array($sonBelgeNo,$yetkodId));
        }
        
        function sinavYeriSil($post){
        	$_db = JFactory::getOracleDBO ();
        	
        	$yerId = $post['yerId'];
        	
        	$yetId = $post['yetId'];
        	
        	$sql = "SELECT * FROM M_BELGELENDIRME_ADAY_BILDIRIM
        			JOIN M_BELGELENDIRME_SINAV USING(SINAV_ID) 
        			WHERE SINAV_YERI_ID=? AND YETERLILIK_ID=?";
        	
        	$result = $_db->prep_exec($sql, array($yerId,$yetId));
        	
        	if(count($result)>0){
        		return true;
        	}else{
        		$sqlDel = "DELETE FROM M_BELGELENDIRME_SINAV_YERI WHERE SINAV_YERI_ID=? AND YETERLILIK_ID=?";
        		$_db->prep_exec($sqlDel, array($yerId,$yetId));
        		return false;
        	}
        }
        
        function sonucTaAdaylar($sinavId){
        	$_db = JFactory::getOracleDBO ();
        	
        	$yets = $this->YeterlilikSinavBilgileri($sinavId);
        	$yenimi = $this->YeterlilikYenimi($yets[0]['YETERLILIK_ID']);
        	
        	$sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR JOIN M_BELGELENDIRME_OGRENCI USING(TC_KIMLIK) WHERE SINAV_ID = ?";
        	$result = $_db->prep_exec($sql, array($sinavId));
        	
        	$belgeNolar = array();
        	
        	foreach($result as $till){
        		$belgeNolar[$till['TC_KIMLIK']] = $till['BELGE_NO'];
        	}
        	
        	$tcArray = array();
        	
        	$TCBirim = array();
        	foreach($result as $row){
        		$tcArray[] = $row['TC_KIMLIK'];
        		if($yenimi == 1){
        			$sqlBirim = "SELECT DISTINCT BIRIM_KODU FROM M_BELGELENDIRME_BASARILI_BIRIM JOIN M_BIRIM USING(BIRIM_ID) WHERE HAK_KAZANAN_ID=?";
        			$TCBirim[$row['TC_KIMLIK']] = $_db->prep_exec($sqlBirim, array($row['ID']));
        		}else{
        			$sqlBirim = "select DISTINCT yeterlilik_alt_birim_no as BIRIM_KODU from m_yeterlilik_alt_birim join M_BELGELENDIRME_BASARILI_BIRIM 
        					ON m_yeterlilik_alt_birim.yeterlilik_alt_birim_id = M_BELGELENDIRME_BASARILI_BIRIM.birim_id where HAK_KAZANAN_ID=?";
        			$TCBirim[$row['TC_KIMLIK']] = $_db->prep_exec($sqlBirim, array($row['ID']));
        		}
        	}
        	
        	$sqlIsteksiz = "SELECT DISTINCT TC_KIMLIK,ADI,SOYADI FROM M_BELGELENDIRME_ADAY_BILDIRIM JOIN M_BELGELENDIRME_OGRENCI USING(TC_KIMLIK) WHERE TC_KIMLIK NOT IN(".implode (' , ',  $tcArray).") AND SINAV_ID=? ORDER BY TC_KIMLIK";
        	$isteksizAday = $_db->prep_exec($sqlIsteksiz, array($sinavId));
        	
        	foreach ($isteksizAday as $row){
        		if($yenimi == 1){
        			$sqlBirim = "SELECT DISTINCT BIRIM_KODU FROM M_BELGELENDIRME_ADAY_BILDIRIM JOIN M_BIRIM USING(BIRIM_ID) WHERE TC_KIMLIK=? AND BASARI_DURUMU=1";
        			$TCBirim[$row['TC_KIMLIK']] = $_db->prep_exec($sqlBirim, array($row['TC_KIMLIK']));
        		}else{
        			$sqlBirim = "select DISTINCT yeterlilik_alt_birim_no as BIRIM_KODU from m_yeterlilik_alt_birim join M_BELGELENDIRME_BASARILI_BIRIM
        					ON m_yeterlilik_alt_birim.yeterlilik_alt_birim_id = M_BELGELENDIRME_ADAY_BILDIRIM.birim_id where TC_KIMLIK=? AND BASARI_DURUMU=1";
        			$TCBirim[$row['TC_KIMLIK']] = $_db->prep_exec($sqlBirim, array($row['TC_KIMLIK']));
        		}
        	}
        	
        	return array(0=>$result,1=>$isteksizAday,2=>$TCBirim,3=>$belgeNolar);
        }
        
        function AdayBilgi($adays){
        	$_db = JFactory::getOracleDBO ();
        	
        	$adayArray = array();
        	foreach($adays as $val){
        		$sql = "SELECT * FROM M_BELGELENDIRME_OGRENCI WHERE TC_KIMLIK=?";
        		$data = $_db->prep_exec($sql,array($val));
        		$adayArray[$val] = $data[0];
        	}
        	
        	return $adayArray;
        }
        
	function SonBelgeNo($yetId){
		$_db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId();
		
		$sql = "SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID =?";
		$yeterlilik = $_db->prep_exec($sql, array($yetId));
		
		$kurs = FormFactory::getKurulusValues($user_id);
		
		//$yetBelgeKod = str_replace('-','',$kurs['KURULUS_YETKILENDIRME_NUMARASI']).'/'.$yeterlilik[0]['YETERLILIK_KODU'].'/'.$yeterlilik[0]['REVIZYON'];
		$yetBelgeKod = str_replace('-','',$kurs['KURULUS_YETKILENDIRME_NUMARASI']).'/'.$yeterlilik[0]['YETERLILIK_KODU'];
		
		$sonBelgeNo = 0;
		
// 		$sql = "SELECT * FROM M_BELGELENDIRME_BELGE_NO WHERE YETKOD = ? AND USER_ID=?";
// 		$data = $_db->prep_exec($sql,array($yetBelgeKod,$user_id));

		$sql = "SELECT * FROM M_BELGELENDIRME_BELGE_NO WHERE YETERLILIK_ID = ? AND USER_ID=?";
		$data = $_db->prep_exec($sql,array($yetId,$user_id));
		
		if($data){
			$sonBelgeNo = $data[0]['BELGENO'];
		}
		//yoksa
		else{
			//$sql = "SELECT BELGENO FROM M_BELGE_SORGU WHERE BELGENO LIKE '%".$yetkodId."%' AND rownum = 1 ORDER BY BELGENO DESC";
			$sql = "SELECT BELGENO FROM M_BELGE_SORGU WHERE BELGENO LIKE '%".$yetBelgeKod."%' AND rownum = 1 ORDER BY BELGENO DESC";
			$data = $_db->prep_exec($sql,array());
			if($data){
				//$sonBelgeNo = substr($data[0]['BELGENO'],strpos($data[0]['BELGENO'],"/")+1);
				$sonBelgeNo = explode("/", $data[0]['BELGENO']);
				$sonBelgeNo = $sonBelgeNo[3];
			}
			$sonBelgeNo = (int)$sonBelgeNo;
			$sql="INSERT INTO M_BELGELENDIRME_BELGE_NO (YETKOD,BELGENO,USER_ID,YETERLILIK_ID) VALUES(?,?,?,?)";
			$_db->prep_exec_insert($sql, array($yetBelgeKod,$sonBelgeNo,$user_id,$yetId));
		}
		$sonBelgeNo = (int)$sonBelgeNo;
		//$sonBelgeNo++;
		$belgeNoSon = $yetBelgeKod.'/'.$yeterlilik[0]['REVIZYON'].'/'.$sonBelgeNo;
		return array($belgeNoSon,$sonBelgeNo,$yetBelgeKod.'/'.$yeterlilik[0]['REVIZYON']);
	}
	
	function BelgeNoVarMi($belgeNo){
		$_db = JFactory::getOracleDBO ();
		
		$kontrol = explode('/', $belgeNo);
		$belgeNoYeni = $kontrol[0].'/'.$kontrol[1].'/__/'.$kontrol[3];
		
		$sql = "SELECT * FROM M_BELGE_SORGU WHERE BELGENO LIKE ?";
		$data = $_db->prep_exec($sql, array($belgeNoYeni));
		
		$sql1 = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE BELGE_NO LIKE ?";
		$data1 = $_db->prep_exec($sql1, array($belgeNoYeni));
		
		if($data || $data1){
			return true;
		}else{
			return false;
		}
	}
	
	function BelgeNoSonucGonder($post, $files){
		$_db = JFactory::getOracleDBO ();
		
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId();
		
		$aciklama = $post['aciklama'];
		$belgeNo = $post['belgeNo'];
		$belgeTarih = $post['belgeTarih'];
		$sinav_id = $post['sinav_id'];
		$dekontNo = $post['dekontNo'];
		$tutar = $post['tutar'];
		
		//****************************** DEKONT Kaydet ***************************************//
		$directory = EK_FOLDER.'sinavBelgeDekont/'.$sinav_id;
		if (!file_exists($directory)){
			mkdir($directory, 0700,true);
		}
		
		if($files["dekont"]["error"] == 0 && ($files["dekont"]["type"] == 'image/jpg' 
				|| $files["dekont"]["type"] == 'image/jpeg' 
				|| $files["dekont"]["type"] == 'image/png' 
				|| $files["dekont"]["type"] == 'image/x-png' 
				|| $files["dekont"]["type"] == 'image/pjpeg'
				|| $files["dekont"]["type"] == 'application/pdf')){
			
			$fileName = explode('.',$files['dekont']['name']);
			
			$name = $sinav_id.'.'.$fileName[count($fileName)-1];
			$path = $directory.'/'.$name;
			
			if(move_uploaded_file($files['dekont']['tmp_name'], $path)){
				$sqlDekont = "UPDATE M_BELGELENDIRME_SINAV SET DEKONT = ? WHERE SINAV_ID = ?";
				$_db->prep_exec_insert($sqlDekont, array($name,$sinav_id));
			}else{
				return false;
			}
			
		}else{
			return false;
		}
		//****************************** DEKONT Kaydet ***************************************//
		
		
		$sinavBilgi = $this->getSinavBilgi($sinav_id);
		$yeterlilik_id = $sinavBilgi[0]['YETERLILIK_ID'];
		
		$basariliBirimler = array();
		$basarisizBirimler = array();
		$alternatifTipi = $this->AlternatifTipi($yeterlilik_id);
		$dataYet = $this->AlteratifBirim($yeterlilik_id);
		foreach($Adaylar as $aday){
			$sonucBirim = $this->yeterlilikBelgeHakki($aday['TC_KIMLIK'],$yeterlilik_id,$alternatifTipi,$dataYet);
			if($sonucBirim != false){
				$basariliBirimler[(string)$aday['TC_KIMLIK']] = $sonucBirim;
			}else{
				$basarisizBirimler[(string)$aday['TC_KIMLIK']] = $this->yeterlilikBelgeBasariliBirim($aday['TC_KIMLIK'],$yeterlilik_id);
			}
		}
		
		
		foreach($belgeNo as $key=>$val){
			$sonBelgeNo = $val;
			$sonucBirim = $this->yeterlilikBelgeHakki((string)$key,$yeterlilik_id,$alternatifTipi,$dataYet);
			if($sonucBirim != false){
				 
				$hak_id = $_db->getNextVal('SEQ_HAK_KAZANAN');
				$sql = "INSERT INTO M_BELGELENDIRME_HAK_KAZANANLAR "
						. "(ID,TC_KIMLIK,YETERLILIK_ID,SINAV_ID,KURULUS_ID,SINAV_TARIHI,AKTIF,BELGE_NO,BELGE_BAS_TARIH) "
								. "VALUES(?,?,?,?,?,?,?,?,TO_DATE(?, 'dd/mm/yyyy'))";
				$param = array($hak_id, $key, $yeterlilik_id, $sinav_id, $user_id, $sinavBilgi[0]['BASLANGIC_TARIHI'],0,$val,$belgeTarih[$key]);
				if($_db->prep_exec_insert($sql,$param)){
					foreach($sonucBirim as $row){
						$sql = "INSERT INTO M_BELGELENDIRME_BASARILI_BIRIM (HAK_KAZANAN_ID,BIRIM_ID,TARIH) "
								. "VALUES(?,?,TO_DATE(?, 'dd/mm/yyyy'))";
						$param = array($hak_id, $row[0],$row[1]);
						$_db->prep_exec_insert($sql,$param);
					}
				}
			}else{
				
				$sonucBirim = $this->yeterlilikBelgeBasariliBirim((string)$key,$yeterlilik_id);
				$hak_id = $_db->getNextVal('SEQ_HAK_KAZANAN');
				$sql = "INSERT INTO M_BELGELENDIRME_HAK_KAZANANLAR "
						. "(ID,TC_KIMLIK,YETERLILIK_ID,SINAV_ID,KURULUS_ID,SINAV_TARIHI,AKTIF,BELGE_NO,BELGE_BAS_TARIH,ACIKLAMA) "
						. "VALUES(?,?,?,?,?,?,?,?,TO_DATE(?, 'dd/mm/yyyy'),?)";
				$param = array($hak_id, $key, $yeterlilik_id, $sinav_id, $user_id, $sinavBilgi[0]['BASLANGIC_TARIHI'],1,$val,$belgeTarih[$key],$aciklama[$key]);
				if($_db->prep_exec_insert($sql,$param)){
					foreach($sonucBirim as $row){
						$sql = "INSERT INTO M_BELGELENDIRME_BASARILI_BIRIM (HAK_KAZANAN_ID,BIRIM_ID,TARIH) "
								. "VALUES(?,?,TO_DATE(?, 'dd/mm/yyyy'))";
						$param = array($hak_id, $row[0],$row[1]);
						$_db->prep_exec_insert($sql,$param);
					}
				}
			}
		}
		$sonBelgeNo = explode('/', $sonBelgeNo);
		$sonBelgeNo = $sonBelgeNo[3];
		
			$sqlBelgeNo = "UPDATE M_BELGELENDIRME_BELGE_NO SET BELGENO=? WHERE YETERLILIK_ID=? AND USER_ID=?";
			$_db->prep_exec($sqlBelgeNo, array($sonBelgeNo,$yeterlilik_id,$user_id));
			
			$yeterlilik = $this->getYeterlilikwithYeterlilikId($yeterlilik_id);
			$kurulus = FormFactory::getKurulusValues($user_id);
			$aciklamaText=$kurulus['KURULUS_ADI'].", ".$sinav_id." Sınav ID'li ".$yeterlilik[0]['YETERLILIK_KODU']." - ".$yeterlilik[0]['YETERLILIK_ADI']." yeterliliğinden sınav sonucunu bildirdi. ";
			if (count($belgeNo)>0){
				$aciklamaText .= 'Başarılı '.count($belgeNo)." kişi için belge masraf karşılığı ödendiğine dair dekont yüklendi.";
			}
			$link="index.php?option=com_belgelendirme&view=belge_olusturma&kurulusId=".$user_id."&sinavId=".$sinav_id;
			$sql="select distinct user_id from m_YETKI_SEKTOR_SORUMLUSU";
			$sektorSorumlulari=$_db->prep_exec($sql,array());
			$mysqlDB = &JFactory::getDBO();
// 			foreach ($sektorSorumlulari as $toUserID){
// 				FormFactory::sektorSorumlusunaNotificationGonder($aciklamaText, $link, $toUserID['USER_ID']);
// 			}
			
			/********************************* Mail Bildirimi ********************************************************/
			// 				$mysqlDB = &JFactory::getDBO();
// 			$sqlMatbaa= "SELECT email FROM #__users WHERE tgUserId = ".$toUserID['USER_ID'];
// 			$mysqlDB->setQuery($sqlMatbaa);
// 			$matbaaUser = $mysqlDB->loadResult();

			//Görevlendirilen Userlar
			$sqlGorevli = "SELECT * FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
			$gorevli = $_db->prep_exec($sqlGorevli, array($user_id));
				
			$mysqlDB = &JFactory::getDBO();
			$mailGorevli = array('mordukaya@myk.gov.tr','ktunc@myk.gov.tr');
			foreach($gorevli as $tow){
				$sqlMatbaa= "SELECT email FROM #__users as users
					WHERE tgUserId = ".$tow['TGUSERID'];
				$mysqlDB->setQuery($sqlMatbaa);
				$matbaaUser = $mysqlDB->loadObjectList();
				$mailGorevli[] = $matbaaUser[0]->email;
				FormFactory::sektorSorumlusunaNotificationGonder($aciklamaText, $link, $tow['TGUSERID']);
			}
				
				
			//Görevlendirilen Userlar

			$baslik = $kurulus['KURULUS_ADI'].' Belge Basım Başvurusu Yapıldı.';
			$icerik = $aciklamaText.'  http://portal.myk.gov.tr/'.$link;
			$to = $mailGorevli;
			
			FormFactory::sentEmail($baslik,$icerik,$to);
			
// 			$recipient = $mailGorevli;
				
// 			$mailer =& JFactory::getMailer();
				
// 			$config =& JFactory::getConfig();
// 			$sender = array(
// 					$config->getValue( 'config.mailfrom' ),
// 					$config->getValue( 'config.fromname' ) );
// 			$mailer->setSender($sender);
				
// 			//$recipient = 'bim@myk.gov.tr';
// 			$mailer->addRecipient($recipient);
				
// 			$mailer->setSubject($kurulus['KURULUS_ADI'].' Belge Basım Başvurusu Yapıldı.');
// 			$mailer->setBody($aciklamaText.'  http://portal.myk.gov.tr/'.$link);
				
// 			$send =& $mailer->Send();
				
			/*************************************** Mail Bildirimi SON ****************************************************************/
			
			$sql = "UPDATE M_BELGELENDIRME_SINAV SET SONUC_DURUMU = 2, DEKONTNO = ?, TUTAR = ? WHERE SINAV_ID = ?";
			$_db->prep_exec_insert($sql, array($dekontNo,$tutar,$sinav_id));
			
			$yetkili = explode(' ', $post['yetkiliAd']);
			$yetkiliAd = FormFactory::ucWordsTR($post['yetkiliAd']);
			$yetkiliSoyAd = FormFactory::toUpperCase($post['yetkiliSoyAd']);
			
			$yetkiliUnvan = $post['yetkiliUnvan'];
			
			$sqlImza = "INSERT INTO M_BELGELENDIRME_IMZA_YETKILI (SINAV_ID,YETKILI_AD,YETKILI_UNVAN, YETKILI_SOYAD) VALUES (?,?,?,?)";
			$_db->prep_exec_insert($sqlImza, array($sinav_id,$yetkiliAd,$yetkiliUnvan,$yetkiliSoyAd));
			
			return true;
	}
	
	function SinavYapilanYeterlilikler(){
		$_db = JFactory::getOracleDBO();
		
		$sql = "select distinct yeterlilik_id, yeterlilik_adi, yeterlilik_kodu,revizyon 
				from m_belgelendirme_sinav join m_yeterlilik using(yeterlilik_id) order by yeterlilik_adi";
		
		$data = $_db->prep_exec($sql, array());
		return $data;
	}
	
	function SinavYapanKuruluslar(){
		$_db = JFactory::getOracleDBO();
	
		$sql = "select distinct m_kurulus.user_id as kurulus_id,m_kurulus.kurulus_adi
				from m_belgelendirme_sinav join m_kurulus on m_belgelendirme_sinav.kurulus_id = m_kurulus.user_id order by kurulus_adi";
	
		$data = $_db->prep_exec($sql, array());
		return $data;
	}
	
	function SinavSearch($post){
		$_db = JFactory::getOracleDBO();
		
		if(isset($post['yapilmayan'])){
			
			$sql = "select m_belgelendirme_sinav.*,m_yeterlilik.*,m_kurulus.*,
					m_yeterlilik_revizyon.revizyon_no, m_yeterlilik_revizyon.revizyon_durumu, m_yeterlilik_revizyon.yeterlilik_kodu as yeterlilik_rev_kod
					 from m_belgelendirme_sinav
					  join m_yeterlilik on m_belgelendirme_sinav.yeterlilik_id = m_yeterlilik.yeterlilik_id
					  join m_kurulus on kurulus_id = m_kurulus.user_id
					left join m_yeterlilik_revizyon on m_yeterlilik.yeterlilik_id = m_yeterlilik_revizyon.yeterlilik_id
					where ((bildirim_durumu = 0 AND BASLANGIC_TARIHI<TO_DATE(sysdate, 'dd/mm/yyyy')) OR (GECERLILIK_DURUMU = 2) OR (bildirim_durumu=1 AND BASLANGIC_TARIHI<TO_DATE(sysdate, 'dd/mm/yyyy') AND SINAV_ID NOT IN (SELECT DISTINCT SINAV_ID FROM M_BELGELENDIRME_SINAV_DOSYA)))";
			
			if(!empty($post['yeterlilik_id'])){
				$sql .= " and m_yeterlilik.yeterlilik_id =".$post['yeterlilik_id'];
			}
			
			if(!empty($post['kurulus_id'])){
				$sql .= " and m_belgelendirme_sinav.kurulus_id =".$post['kurulus_id'];
			}
			
			return $_db->prep_exec($sql, array());
			
		}else{
			$sql = "select m_belgelendirme_sinav.*,m_yeterlilik.*,m_kurulus.*,
					m_yeterlilik_revizyon.revizyon_no, m_yeterlilik_revizyon.revizyon_durumu, m_yeterlilik_revizyon.yeterlilik_kodu as yeterlilik_rev_kod
					 from m_belgelendirme_sinav
					  join m_yeterlilik on m_belgelendirme_sinav.yeterlilik_id = m_yeterlilik.yeterlilik_id
					  join m_kurulus on kurulus_id = m_kurulus.user_id
					left join m_yeterlilik_revizyon on m_yeterlilik.yeterlilik_id = m_yeterlilik_revizyon.yeterlilik_id";
				
			$sql .= " where sonuc_durumu =".$post['durum']." AND GECERLILIK_DURUMU = 1 AND bildirim_durumu = 1 
					AND ((BASLANGIC_TARIHI<TO_DATE(sysdate, 'dd/mm/yyyy') AND SINAV_ID IN (SELECT DISTINCT SINAV_ID FROM M_BELGELENDIRME_SINAV_DOSYA)) OR (BASLANGIC_TARIHI>=TO_DATE(sysdate, 'dd/mm/yyyy')))";
				
			if(!empty($post['yeterlilik_id'])){
				$sql .= " and m_yeterlilik.yeterlilik_id =".$post['yeterlilik_id'];
			}
				
			if(!empty($post['kurulus_id'])){
				$sql .= " and m_belgelendirme_sinav.kurulus_id =".$post['kurulus_id'];
			}
			//TO_DATE(?, 'dd/mm/yyyy')
			if(!empty($post['basTarih']) && !empty($post['bitTarih'])){
				$sql .= " and m_belgelendirme_sinav.baslangic_tarihi >= TO_DATE('".$post['basTarih']."', 'dd/mm/yyyy') and  m_belgelendirme_sinav.baslangic_tarihi <= TO_DATE('".$post['bitTarih']."', 'dd/mm/yyyy')";
			}
			else if(!empty($post['basTarih'])){
				$sql .= " and m_belgelendirme_sinav.baslangic_tarihi >= TO_DATE('".$post['basTarih']."', 'dd/mm/yyyy')";
			}
			else if(!empty($post['bitTarih'])){
				$sql .= "and  m_belgelendirme_sinav.baslangic_tarihi <= TO_DATE(".$post['bitTarih'].", 'dd/mm/yyyy')";
			}
				
			$sql .= " order by m_belgelendirme_sinav.baslangic_tarihi asc";
				
			return $_db->prep_exec($sql, array());
		}
	}
	
	function sinavYeriGetir($post){
		$_db = JFactory::getOracleDBO();
		
		$sql = "select distinct yer_adi, adres from m_belgelendirme_sinav 
				  join m_belgelendirme_aday_bildirim using(sinav_id)
		          join m_belgelendirme_sinav_yeri using(sinav_yeri_id)
		          where sinav_id = ?";
		
		return $_db->prep_exec($sql, array($post['sinav_id']));
	}
	
	function sinavDegerGetir($post){
		$_db = JFactory::getOracleDBO();
		
		$sql = "select distinct degerlendirici_tc_kimlik from m_belgelendirme_sinav 
					join m_belgelendirme_aday_bildirim using(sinav_id)
          			where sinav_id = ?";
		
		$data = $_db->prep_exec($sql, array($post['sinav_id']));
		
		$deger = explode(',', $data[0]['DEGERLENDIRICI_TC_KIMLIK']);
		
		$degerArray = array();
		
		foreach ($deger as $row){
			$sqlDeger = "select * from m_belgelendirme_degerlendirici where tc_kimlik=?";
			$result = $_db->prep_exec($sqlDeger, array($row));
			$degerArray[] = $result[0];
		}
		return $degerArray;
	}
	
	function sinavAdayGetir($post){
		$_db = JFactory::getOracleDBO();
		
		$sql = "select kurulus_id, sinav_id, paket_id from m_belgelendirme_sinav
				  join m_belgelendirme_sinav_dosya using(sinav_id)
				  where sinav_id= ?";
		
		return $_db->prep_exec($sql, array($post['sinav_id']));
	}
	
	function BelgeKontrol($belgeNo){
		$_db = JFactory::getOracleDBO();
		
		//$belge = explode('/', $belgeNo);
		
		$sql = "SELECT * FROM M_BELGE_SORGU
				JOIN M_YETERLILIK USING(YETERLILIK_ID)
				WHERE BELGENO = ?";
		
		$data = $_db->prep_exec($sql, array($belgeNo));
		
		if($data){
			$sqlAday = "SELECT * FROM M_BELGELENDIRME_OGRENCI WHERE TC_KIMLIK=?";
			$aday = $_db->prep_exec($sqlAday, array($data[0]['TCKIMLIKNO']));
			
			if($data[0]['YENI_MI'] == 1){
				$sqlBirim = "SELECT M_BIRIM.* FROM M_BELGELENDIRME_HAK_KAZANANLAR
					        JOIN M_BELGELENDIRME_BASARILI_BIRIM ON M_BELGELENDIRME_HAK_KAZANANLAR.ID = M_BELGELENDIRME_BASARILI_BIRIM.HAK_KAZANAN_ID
					        JOIN M_BIRIM ON M_BELGELENDIRME_BASARILI_BIRIM.BIRIM_ID = M_BIRIM.BIRIM_ID
							WHERE BELGE_NO = ? ORDER BY M_BIRIM.BIRIM_ID";
					
				$birims = $_db->prep_exec($sqlBirim, array($belgeNo));
			}
			else{
				$sqlBirim = "SELECT M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU, M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI FROM M_BELGELENDIRME_HAK_KAZANANLAR
					        JOIN M_BELGELENDIRME_BASARILI_BIRIM ON M_BELGELENDIRME_HAK_KAZANANLAR.ID = M_BELGELENDIRME_BASARILI_BIRIM.HAK_KAZANAN_ID
					        JOIN M_YETERLILIK_ALT_BIRIM ON M_BELGELENDIRME_BASARILI_BIRIM.BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
							WHERE BELGE_NO = ? ORDER BY M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID";
					
				$birims = $_db->prep_exec($sqlBirim, array($belgeNo));
			}
			
			return array($data[0],$aday[0],$birims);
		}
		else{
			$sql = "SELECT * FROM M_BELGE_SORGU
				WHERE BELGENO = ?";
			
			$data = $_db->prep_exec($sql, array($belgeNo));
			
			if($data){
				return array($data[0],false,false);	
			}
			else{
			return 'Böyle bir belge numarasına ait belge bulunmamaktadır.';
			}
		}
	}
	
	function getYeterlilikAd (){
		$_db = & JFactory::getOracleDBO();
		$sql = "SELECT *
				FROM m_yeterlilik 
				WHERE YETERLILIK_SUREC_DURUM_ID = ".ONAYLANMIS_YETERLILIK." AND YETERLILIK_KODU IS NOT NULL
				ORDER BY yeterlilik_adi ASC, yeterlilik_kodu ASC, revizyon ASC";
	
		$data = $_db->prep_exec($sql, array());	
                
		return $data;
	}
	
	function getAlternatifYeterlilik($post){
		$_db = & JFactory::getOracleDBO();
		$sql = "select * from m_yeterlilik_alternatif where yeterlilik_id = ? order by alternatif_id";
		
		$data = $_db->prep_exec($sql, array($post['yetId']));
		
		return $data;
	}
	
	function sinavBirimTxt($get){
		$_db = & JFactory::getOracleDBO();
		
		$directory = EK_FOLDER.'sinavBelgeBirim/'.$get['sinavId'];
		if (!file_exists($directory)){
			mkdir($directory, 0700,true);
		}
		
		$sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE SINAV_ID = ?";
		
		$haks = $_db->prep_exec($sql, array($get['sinavId']));
		if($haks){
			$zip = new ZipArchive();
			$zip->open($directory.'/'.$get['sinavId'].'.zip', ZipArchive::CREATE);
			foreach ($haks as $row){
				$sqlBirims = "SELECT * FROM M_BELGELENDIRME_BASARILI_BIRIM 
								JOIN M_BIRIM USING(BIRIM_ID)
								WHERE HAK_KAZANAN_ID = ? ORDER BY BIRIM_ID ASC,BIRIM_KODU ASC";
				$Birims = $_db->prep_exec($sqlBirims, array($row['ID']));
				
				$content = '';
				$say = 1;
				foreach ($Birims as $cow){
					if($say == count($Birims)){
						$content .= $cow['BIRIM_KODU']." ".$cow['BIRIM_ADI'];
					}else{
						$content .= $cow['BIRIM_KODU']." ".$cow['BIRIM_ADI']."\r\n";
					}
					$say++;
				}
				
				$txtAdi = str_replace("/","#",$row['BELGE_NO']).'.txt';
				$fp = fopen($directory.'/'.$txtAdi,'wb');
				fwrite($fp, $content);
				fclose($fp);
				$zip->addFile($directory.'/'.$txtAdi, $txtAdi);
			}
			$zip->close();
		}
	}
	
	function BelgeImzaYetkiliGetir($post){
		$_db = & JFactory::getOracleDBO();
		
		$sinavId = $post['sinavId'];
		
		$sql = "SELECT * FROM M_BELGELENDIRME_IMZA_YETKILI JOIN M_BELGELENDIRME_SINAV USING(SINAV_ID) WHERE SINAV_ID = ?";
		
		$data = $_db->prep_exec($sql, array($sinavId));
		
		return $data[0];
	}
	
	function getKurulusLogoTamMi($post){
		$_db = & JFactory::getOracleDBO();
		
		$kurulus = $post['kurulusId'];
		
		$sql = "SELECT * FROM M_KURULUS 
					WHERE USER_ID =?";
		$data = $_db->prep_exec($sql, array($kurulus));
		
		$data = $data[0];
		
		$sqlSablon = "SELECT * FROM M_BELGELENDIRME_KURULUS_SABLON WHERE KURULUS_ID=?";
		$sablon = $_db->prep_exec($sqlSablon, array($kurulus));
		
		$hatalar = array();
		$say = 0;
		
		if(empty($data['KURULUS_YETKILENDIRME_NUMARASI'])){
			$hatalar[] = "Kuruluşun Yetkilendirme Numarası belirtilmemiştir.";
			$say++;
		}
		if(empty($data['LOGO'])){
			$hatalar[] = "Kuruluşun logosu belirtilmemiştir.";
			$say++;
		}
		if(empty($sablon[0]['AKREDITASYON_NO'])){
			$hatalar[] = "Kuruluşun TÜRKAK Kodu belirtilmemiştir.";
			$say++;
		}
		if(empty($sablon[0]['MYK_MARKASI'])){
			$hatalar[] = "Kuruluşun MYK Markası belirtilmemiştir.";
			$say++;
		}
		if(empty($sablon[0]['TURKAK_MARKASI'])){
			$hatalar[] = "Kuruluşun TÜRKAK Markası belirtilmemiştir.";
			$say++;
		}
		
		if($say>0){
			return array(0=>false,1=>$hatalar);
		}else{
			return array(0=>true);
		}
		
	}
	
	function degerlendiriciEtkin($post){
		$_db = & JFactory::getOracleDBO();
		
		$yetId = $post['yetId'];
		$degerId = $post['degerId'];
		$etkin = $post['etkin'];
		
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		
		$sql="UPDATE M_BELGELENDIRME_DGRLNDRC_KRLS SET ETKIN=? WHERE KURULUS_ID=? AND YETERLILIK_ID=? AND TC_KIMLIK=?";
		return $_db->prep_exec_insert($sql, array($etkin,$user_id,$yetId,$degerId));
	}
	
	function degerYetSil($post){
		$_db = & JFactory::getOracleDBO();
		
		$yetId = $post['yetId'];
		$degerId = $post['degerId'];
		
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		
		$sql="SELECT * FROM M_BELGELENDIRME_ADAY_BILDIRIM JOIN M_BELGELENDIRME_SINAV USING(SINAV_ID) WHERE DEGERLENDIRICI_TC_KIMLIK = ? AND KURULUS_ID=? AND YETERLILIK_ID=?";
		$data = $_db->prep_exec($sql, array($degerId,$user_id,$yetId));
		
		if($data){
			return false;
		}else{
			$sqlDelete = "DELETE FROM M_BELGELENDIRME_DGRLNDRC_KRLS WHERE YETERLILIK_ID=? AND TC_KIMLIK=? AND KURULUS_ID=?";
			return $_db->prep_exec_insert($sqlDelete, array($yetId,$degerId,$user_id));
		}
	}
	
	function SonucBos($sinavId){
		$_db = & JFactory::getOracleDBO();
		
		$sqlBilgi = "SELECT * FROM M_BELGELENDIRME_SINAV 
				JOIN M_YETERLILIK ON M_BELGELENDIRME_SINAV.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID 
				JOIN M_KURULUS ON M_BELGELENDIRME_SINAV.KURULUS_ID = M_KURULUS.USER_ID 
				WHERE M_BELGELENDIRME_SINAV.SINAV_ID = ?";
		
		$bilgi = $_db->prep_exec($sqlBilgi, array($sinavId));
		
		$aciklamaText = $bilgi[0]['KURULUS_ADI']." kuruluşu ".$sinavId." Sınav ID'li ".$bilgi[0]['BASLANGIC_TARIHI']." tarihinde 
".$bilgi[0]['YETERLILIK_KODU']." ".$bilgi[0]['YETERLILIK_ADI']." yeterliliğinden yaptığı sınav sonucunu bildirmiş olup, belge almaya hak kazanan aday bulunmamaktadır.";
		
		//Görevlendirilen Userlar
		$sqlGorevli = "SELECT * FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
		$gorevli = $_db->prep_exec($sqlGorevli, array($bilgi[0]['USER_ID']));
			
		$mysqlDB = &JFactory::getDBO();
		$mailGorevli = array('mordukaya@myk.gov.tr','ktunc@myk.gov.tr');
		foreach($gorevli as $tow){
			$sqlMatbaa= "SELECT email FROM #__users as users
					WHERE tgUserId = ".$tow['TGUSERID'];
			$mysqlDB->setQuery($sqlMatbaa);
			$matbaaUser = $mysqlDB->loadObjectList();
			$mailGorevli[] = $matbaaUser[0]->email;
		}
			
			
		//Görevlendirilen Userlar
		$baslik = $bilgi[0]['KURULUS_ADI'].' Sonuç Bildirimi';
		$icerik = $aciklamaText.'  http://portal.myk.gov.tr/'.$link;
		$to = $mailGorevli;
		
		//FormFactory::sentEmail($baslik,$icerik,$to);
		
// 		$recipient = $mailGorevli;
		
// 		$mailer =& JFactory::getMailer();
		
// 		$config =& JFactory::getConfig();
// 		$sender = array(
// 				$config->getValue( 'config.mailfrom' ),
// 				$config->getValue( 'config.fromname' ) );
// 		$mailer->setSender($sender);
		
// 		//$recipient = 'bim@myk.gov.tr';
// 		$mailer->addRecipient($recipient);
		
// 		$mailer->setSubject($bilgi[0]['KURULUS_ADI'].' Sonuç Bildirimi');
// 		$mailer->setBody($aciklamaText.'  http://portal.myk.gov.tr/'.$link);
		
// 		$send =& $mailer->Send();
		
		/*************************************** Mail Bildirimi SON ****************************************************************/
			
		$sql = "UPDATE M_BELGELENDIRME_SINAV SET SONUC_DURUMU = 2 WHERE SINAV_ID = ?";
		$_db->prep_exec_insert($sql, array($sinavId));
		
		return true;
	}
	
	public function TestKisiler($sinav_id){
		$_db = & JFactory::getOracleDBO();
		
		$sql = "SELECT DISTINCT TC_KIMLIK,EGITIMI FROM M_BELGELENDIRME_ADAY_BILDIRIM 
				JOIN M_BELGELENDIRME_OGRENCI USING(TC_KIMLIK) 
				WHERE SINAV_ID = ?";
		
		return $_db->prep_exec($sql, array($sinav_id));
	}
	
	public function belgeNoBilgi($belgeNo){
		$_db = & JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_BELGE_SORGU WHERE BELGENO = ?";
		
		$data = $_db->prep_exec($sql, array($belgeNo));
		
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	public function BelgeDurumDuzenle($post){
		$_db = & JFactory::getOracleDBO();
		
		$belgeNo = $post['belgeNo'];
		$aciklama = $post['aciklama'];
		$belgeDurumu = $post['belgeDurumu'];
		
		$sql = "UPDATE M_BELGE_SORGU SET BELGEDURUMU = ?, IPTAL_ACIKLAMA = ? WHERE BELGENO = ?";
		
		$return = $_db->prep_exec_insert($sql, array($belgeDurumu,$aciklama,$belgeNo));
		
		if($return){
			return true;
		}else{
			return false;
		}
	}
	
	public function belgeMatbaahSearch($post){
		$_db = & JFactory::getOracleDBO();
		
		$sql = "select distinct count(*) as say from m_belgelendirme_hak_kazananlar mhk 
			join m_belge_sorgu mbs on mhk.belge_no = mbs.belgeno
			join m_belgelendirme_matbaa mbm on mhk.matbaa_id = mbm.matbaa_id
			where mbs.belgedurumu = 1";
		
		if(!empty($post['yeterlilik_id'])){
			$sql .= " and mhk.yeterlilik_id = ".$post['yeterlilik_id'];
		}
		
		if(!empty($post['kurulus_id'])){
			$sql .= " and mhk.kurulus_id = ".$post['kurulus_id'];
		}
		
		if(!empty($post['basTarih']) && !empty($post['bitTarih'])){
			$sql .= " and mbm.basim_tarihi >= TO_DATE('".$post['basTarih']."', 'dd/mm/yyyy') and  mbm.basim_tarihi <= TO_DATE('".$post['bitTarih']."', 'dd/mm/yyyy')";
		}
		else if(!empty($post['basTarih'])){
			$sql .= " and mbm.basim_tarihi >= TO_DATE('".$post['basTarih']."', 'dd/mm/yyyy')";
		}
		else if(!empty($post['bitTarih'])){
			$sql .= " and  mbm.basim_tarihi <= TO_DATE(".$post['bitTarih'].", 'dd/mm/yyyy')";
		}
		
		$return = $_db->prep_exec($sql, array());
		
		if($return){
			return $return;
		}else{
			return false;
		}
	}
}
