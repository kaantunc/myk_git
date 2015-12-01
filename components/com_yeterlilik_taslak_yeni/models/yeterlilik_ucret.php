<?php
defined('_JEXEC') or die('Restricted access');

class Yeterlilik_TaslakModelYeterlilik_Ucret extends JModel {
	
	public function getYeterlilik($sekId = 0){
		$db = &JFactory::getOracleDBO();
		$sqlEk = "";
		if($sekId){
			$sqlEk .= " AND MY.SEKTOR_ID = ".$sekId;
		}
		
		$sql = "SELECT DISTINCT MY.*, PMS.SEKTOR_ADI FROM M_YETERLILIK MY
				INNER JOIN PM_SEKTORLER PMS ON (MY.SEKTOR_ID = PMS.SEKTOR_ID)
				WHERE MY.YETERLILIK_DURUM_ID = 2 AND PMS.SEKTOR_DURUM = 1 AND TEHLIKELI_IS_DURUM = 1";
		$sql .= $sqlEk;
		$sql .= " ORDER BY YETERLILIK_ADI ASC, YETERLILIK_KODU ASC, REVIZYON ASC";
		$yets = $db->prep_exec($sql, array());
		return $yets;
	}
	
	public function getYetUcret($yets){
		$db = &JFactory::getOracleDBO();
		$yetUcret = array();
		foreach($yets as $row){
			$sqlYetUcret = "SELECT DISTINCT ID, YETERLILIK_ID, TO_CHAR(BAS_TARIH,'DD/MM/YYYY') AS BAS_TARIH, UCRET FROM M_YETERLILIK_UCRET
				WHERE YETERLILIK_ID = ? 
					ORDER BY BAS_TARIH DESC";
			$data = $db->prep_exec($sqlYetUcret, array($row['YETERLILIK_ID']));
			if($data){
				$yetUcret[$row['YETERLILIK_ID']] = $data[0];
			}
		}
		
		return $yetUcret;
	}
    
    function getYayindakiSektorler(){
    	$db = &JFactory::getOracleDBO();
    	$sql = "SELECT DISTINCT PMS.* FROM PM_SEKTORLER PMS 
    			INNER JOIN M_YETERLILIK MY ON (PMS.SEKTOR_ID = MY.SEKTOR_ID) 
    			WHERE PMS.SEKTOR_DURUM = 1 AND MY.YETERLILIK_DURUM_ID = 2
    			ORDER BY PMS.SEKTOR_ADI ASC";
    	return $db->prep_exec($sql, array());
    }
    
    function YetUcretGetir($post){
    	$db = &JFactory::getOracleDBO();
    	$yetId = $post['yetId'];
    	if(!is_numeric($yetId)){
    		return false;
    	}
    	
    	$return = array();
    	
    	$sql = "SELECT DISTINCT * FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
    	$yets = $db->prep_exec($sql, array($yetId));
    	$return['yets'] = $yets[0];
    	
    	$sqlUcret = "SELECT DISTINCT * FROM M_YETERLILIK_UCRET WHERE YETERLILIK_ID = ? ORDER BY BAS_TARIH DESC";
    	$yetUcret = $db->prep_exec($sqlUcret, array($yetId));
    	
    	if($yetUcret){
    		$return['yetUcret'] = $yetUcret[0];
    		$return['yetUcret']['BAS_TARIH'] = substr($return['yetUcret']['BAS_TARIH'],0,10);
    	}else{
    		$return['yetUcret'] = 0;
    	}
    	
    	return $return;
    }
    
    function YeterlilikUcretKaydet($post){
    	$db = &JFactory::getOracleDBO();
    	
    	$yetUcId = $post['yetUcId'];
    	$yetId = $post['yetId'];
    	$basTarih = $post['basTarih'];
    	$ucret = $post['yetUcret'];
    	$ucret = str_replace('.', ',', $ucret);
    	$kararSayi = $post['kararSayi'];
    	$return = true;
    	
    	if($yetUcId){
    		$sqlIns = "UPDATE M_YETERLILIK_UCRET SET BAS_TARIH = TO_DATE(?,'DD/MM/YYYY'), UCRET = ?, BAKANLAR_KURULU_KARAR_SAYI_ID = ? 
    				WHERE ID = ? AND YETERLILIK_ID = ?";
    		$param = array(
    				$basTarih,
    				$ucret,
    				$kararSayi,
    				$yetUcId,
    				$yetId
    		);
    		
    		$return = $db->prep_exec_insert($sqlIns, $param);
    	}else{
    		$yetUcretId = $db->getNextVal('SEQ_YET_UCRET_ID');
    		$sqlIns = "INSERT INTO M_YETERLILIK_UCRET (ID,YETERLILIK_ID,BAS_TARIH,UCRET,BAKANLAR_KURULU_KARAR_SAYI_ID) VALUES(?,?,TO_DATE(?,'DD/MM/YYYY'),?,?)";
    		$param = array(
    				$yetUcretId,
    				$yetId,
    				$basTarih,
    				$ucret,
    				$kararSayi
    		);
    		
    		$return = $db->prep_exec_insert($sqlIns, $param);
    	}
    	
    	$yets = $this->YetUcretGetir(array('yetId'=>$yetId));

    	if($return){
    		if($yetUcId){
    			$message = $yets['yets']['YETERLILIK_KODU'].'/'.$yets['yets']['REVIZYON'].' '.$yets['yets']['YETERLILIK_ADI'].' Yeterliliği ücreti güncellenmiştir.';
    			return array('durum'=>1,'message'=>$message,'yetId'=>$yets['yets']['YETERLILIK_ID']);
    		}else{
    			$message = $yets['yets']['YETERLILIK_KODU'].'/'.$yets['yets']['REVIZYON'].' '.$yets['yets']['YETERLILIK_ADI'].' Yeterliliğine yeni ücret eklenmiştir.';
    			return array('durum'=>1,'message'=>$message,'yetId'=>$yets['yets']['YETERLILIK_ID']);
    		}
    	}else{
    		$message = $yets['yets']['YETERLILIK_KODU'].'/'.$yets['yets']['REVIZYON'].' '.$yets['yets']['YETERLILIK_ADI'].' Yeterliliği ücreti güncelleme işlemi sırasında bir hata meydana geldi. Lütfen tekrar deneyin.';
    		return array('durum'=>0,'message'=>$message,'yetId'=>$yets['yets']['YETERLILIK_ID']);
    	}
    }
    
    function getBakanlarKuruluSayi(){
    	$db = &JFactory::getOracleDBO();
    	
    	$sql = "SELECT * FROM M_BAKANLAR_KURULU_KARAR_SAYI";
    	$datas = $db->prep_exec($sql, array());
    	
    	return $datas;
    }
    
    function kararNoEkle($post){
    	$db = &JFactory::getOracleDBO();
    	 
    	$sql = "INSERT INTO M_BAKANLAR_KURULU_KARAR_SAYI (KARAR_SAYI,KARAR_TARIH) VALUES(?,?)";
    	$status = $db->prep_exec_insert($sql, array($post['karar_sayisi'],$post['karar_tarih']));
    	 
    	if($status == true){
    		$return['STATUS'] = $status;
    		$return['MESSAGE'] = "Karar no başarıyla eklendi";
    	}else{
    		$return['STATUS'] = $status;
    		$return['MESSAGE'] = "Karar no ekleme işleminde hata oluştu";
    	}
    	return $return;	
    }
    
    function kararNoSil($kararId){
    	
    	$db = &JFactory::getOracleDBO();
    	
    	$sql = "DELETE FROM M_BAKANLAR_KURULU_KARAR_SAYI WHERE ID = ?";
    	$status = $db->prep_exec_insert($sql, array($kararId));
    	
    	if($status){
    		$return['STATUS'] = $status;
    		$return['MESSAGE'] = "Karar no silme işlemi başarıyla gerçekleşti";
    	}else{
    		$return['STATUS'] = $status;
    		$return['MESSAGE'] = "Karar no silme işleminde hata oluştu";
    	}
    	
    	return $return;
    }
    
    function kararNoDuzenle($post){
    
    	$db = &JFactory::getOracleDBO();
    	 
    	$sql = "UPDATE M_BAKANLAR_KURULU_KARAR_SAYI SET KARAR_SAYI = ?,KARAR_TARIH = ? WHERE ID = ?";
    	$status = $db->prep_exec_insert($sql, array($post['kararNo'],$post['kararTarih'],$post['kararId']));
    	 
    	if($status){
    		$return['STATUS'] = $status;
    		$return['MESSAGE'] = "Karar no düzenleme işlemi başarıyla gerçekleşti";
    	}else{
    		$return['STATUS'] = $status;
    		$return['MESSAGE'] = "Karar no düzenleme işleminde hata oluştu";
    	}
    	 
    	return $return;
    }
    
    function GetYetUcrets($yetId){
    	$db = &JFactory::getOracleDBO();
    	
    	$sqlYetUcret = "SELECT MYU.ID, MYU.YETERLILIK_ID, TO_CHAR(MYU.BAS_TARIH,'DD/MM/YYYY') AS BAS_TARIH, MYU.UCRET,
    				MBK.KARAR_SAYI, TO_CHAR(MBK.KARAR_TARIH,'DD/MM/YYYY') AS KARAR_TARIH
    			FROM M_YETERLILIK_UCRET MYU
    			LEFT JOIN M_BAKANLAR_KURULU_KARAR_SAYI MBK ON(MYU.BAKANLAR_KURULU_KARAR_SAYI_ID = MBK.ID)
				WHERE MYU.YETERLILIK_ID = ? 
    			ORDER BY BAS_TARIH ASC";
    	$yetUcret = $db->prep_exec($sqlYetUcret, array($yetId));
    	
    	$sqlYet = "SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
    	$yetBilgi = $db->prep_exec($sqlYet, array($yetId));
    	
    	return array('yetBilgi'=>$yetBilgi, 'yetUcret'=>$yetUcret);
    }
    
    function AjaxGetYetUcret($yetUcId){
    	$db = &JFactory::getOracleDBO();
    	 
    	$sqlYetUcret = "SELECT MYU.ID, MYU.YETERLILIK_ID, TO_CHAR(MYU.BAS_TARIH,'DD/MM/YYYY') AS BAS_TARIH, MYU.UCRET,
    				MBK.KARAR_SAYI, TO_CHAR(MBK.KARAR_TARIH,'DD/MM/YYYY') AS KARAR_TARIH, MBK.ID AS KARAR_ID
    			FROM M_YETERLILIK_UCRET MYU
    			LEFT JOIN M_BAKANLAR_KURULU_KARAR_SAYI MBK ON(MYU.BAKANLAR_KURULU_KARAR_SAYI_ID = MBK.ID)
				WHERE MYU.ID = ?";
    	$yetUcret = $db->prep_exec($sqlYetUcret, array($yetUcId));
    	
    	if($yetUcret){
    		return $yetUcret[0];
    	}else{
    		return false;
    	}
    }
    
    function AjaxDeleteYetUcret($yetUcId){
    	$db = &JFactory::getOracleDBO();
    	
    	$sql = "DELETE FROM M_YETERLILIK_UCRET WHERE ID = ?";
    	
    	$yetUcret = $db->prep_exec_insert($sql, array($yetUcId), true);
    	
    	return $yetUcret;
    }
    
    function ToplamZamUygula($post){
    	$db = &JFactory::getOracleDBO();
    	
    	$zam = $post['zam'];
    	$basTarih = $post['basTarih'];
    	$yets = $post['yets'];
    	
    	$hata = 0;
    	foreach($yets as $row){
    		$sql = "SELECT * FROM M_YETERLILIK_UCRET WHERE YETERLILIK_ID = ? 
    				ORDER BY BAS_TARIH DESC";
    		$data = $db->prep_exec($sql, array($row));
    		
    		if($data){
    			$ucret = $data[0]['UCRET'];
    			$ZamliUcret = $ucret+(($ucret*$zam)/100);
    			$ZamliUcret = floor($ZamliUcret*100)/100;
    			
    			$yetUcretId = $db->getNextVal('SEQ_YET_UCRET_ID');
    			$sqlIns = "INSERT INTO M_YETERLILIK_UCRET (ID,YETERLILIK_ID,BAS_TARIH,UCRET,BAKANLAR_KURULU_KARAR_SAYI_ID) VALUES(?,?,TO_DATE(?,'DD/MM/YYYY'),?,?)";
	    		$param = array(
	    				$yetUcretId,
	    				$row,
	    				$basTarih,
	    				$ZamliUcret,
	    				$data[0]['BAKANLAR_KURULU_KARAR_SAYI_ID']
	    		);
	    		
	    		$return = $db->prep_exec_insert($sqlIns, $param);
	    		
	    		if(!$return){
	    			$hata++;
	    		}
    		}
    	}
    	
    	if($hata>0){
    		return array('durum'=>false,'message'=>'Toplu zam uygulanırken bir hata meydana geldi. Bazı yeterliliklere zam uygulanamadı. Lütfen tek tek kontrol ediniz.');
    	}else{
    		return array('durum'=>true, 'message'=>'Toplu zam seçilen bütün yeterliliklere başarılı bir şekilde uygulandı.');
    	}
    }
}
?>
