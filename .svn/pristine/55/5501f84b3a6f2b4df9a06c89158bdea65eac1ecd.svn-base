<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');


class SinavModelSinav_Yetki_Yeterlilik_Ara extends JModel {
	
	function KuruluslariGetir(){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT DISTINCT USER_ID, KURULUS_ADI 
					FROM M_KURULUS JOIN M_BASVURU USING(USER_ID) 
					WHERE BASVURU_TIP_ID = 3 AND BASVURU_DURUM_ID = 6 ORDER BY KURULUS_ADI";
		$kuruluslar = $db->prep_exec($sql,array());
		return $kuruluslar;
	}
	
	function YeterlilikGetir(){
		$db  = &JFactory::getOracleDBO();
		$sql = "SELECT YETERLILIK_ID, YETERLILIK_KODU, YETERLILIK_ADI 
					FROM M_YETERLILIK 
					WHERE YETERLILIK_DURUM_ID = 2 AND YETERLILIK_SUREC_DURUM_ID = 1 ORDER BY YETERLILIK_ADI";
		$yeterlilikler = $db->prep_exec($sql,array());
		return $yeterlilikler;
	}
	
	function yetkiYeterlilikAra(){
		if(strlen($_POST["yeterlilik_id"]) > 0 && strlen($_POST["kurulus_id"]) > 0){
			$yetId = $_POST["yeterlilik_id"];
			$kurulus_id = $_POST["kurulus_id"];
			$sonuc = $this->getYetkiYeterlilikile($kurulus_id, $yetId);
		}
		else if (strlen($_POST["yeterlilik_id"]) == 0 && strlen($_POST["kurulus_id"]) > 0){
			$kurulus_id = $_POST["kurulus_id"];
			$sonuc = $this->getYetkiYeterlilikKurulus($kurulus_id);
		}
		else if (strlen($_POST["kurulus_id"]) == 0 && strlen($_POST["yeterlilik_id"]) > 0){
			$yetId = $_POST["yeterlilik_id"];
			$sonuc = $this->getYetkiYeterlilikId($yetId);
		}
		
		if(count($sonuc[0]) > 0){
			ajax_success_response_with_array('Sorgu başarılı', $sonuc);
			 
		}
		else{
			ajax_error_response('Kayıt bulunamadı'.$sonuc);
		}
		//return $sonuc;
	}
	
	function getYetkiYeterlilikKurulus($user_id){
		$db  = &JFactory::getOracleDBO();
		$kurulussql = "SELECT KURULUS_ADI FROM M_KURULUS
	    		              		WHERE USER_ID = ?";
		$kurulusadi = $db->prep_exec($kurulussql, array($user_id));
		 
		$yenimisql = "SELECT USER_ID, YETERLILIK_ID,YETERLILIK_ADI, YETERLILIK_KODU, YENI_MI FROM  M_BELGELENDIRME_YET_TALEBI
					    	JOIN M_YETERLILIK USING(YETERLILIK_ID) 
					    	JOIN M_BASVURU USING(EVRAK_ID)
		              		WHERE BASVURU_TIP_ID = 3 AND BASVURU_DURUM_ID = 6 AND USER_ID = ? ORDER BY YETERLILIK_ID";
		$yenimi = $db->prep_exec($yenimisql, array($user_id));
		 
		$birimler = array();
		$yetki_tarih = array();
		$sonuc = array();
		foreach($yenimi as $rows){
			if($rows['YENI_MI'] == 0){
				$birimsql = "SELECT DISTINCT BIRIM_ID, YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_KODU,
								   YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO AS BIRIM_NO, 
								   YETERLILIK_ALT_BIRIM_KODU AS BIRIM_KODU
								   FROM M_YETERLILIK 
				  				   JOIN M_YETERLILIK_ALT_BIRIM USING(YETERLILIK_ID) 
				             	   JOIN M_DENETIM_YETKI ON YETERLILIK_ALT_BIRIM_ID = BIRIM_ID
				             	   JOIN M_DENETIM USING(DENETIM_ID)
				  				   WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ? 
								   AND YETKININ_GERI_ALINDIGI_TARIH IS NULL ORDER BY BIRIM_ID";
				 
				$birimler[$rows["YETERLILIK_ID"]][] = $db->prep_exec($birimsql, array($rows["YETERLILIK_ID"], $user_id));
				 
				$yetkitarihsql = "SELECT YETKI_KAPSAMI_YETKI_TARIHI
					            		FROM M_YETERLILIK 
					  				    JOIN M_YETERLILIK_ALT_BIRIM USING(YETERLILIK_ID) 
					             		JOIN M_DENETIM_YETKI ON YETERLILIK_ALT_BIRIM_ID = BIRIM_ID
					             		JOIN M_DENETIM USING(DENETIM_ID)
					  				   	WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ? 
					              		AND YETKININ_GERI_ALINDIGI_TARIH IS NULL
										AND YETKI_KAPSAMI_YETKI_TARIHI IS NOT NULL
	    								ORDER BY YETKI_KAPSAMI_YETKI_TARIHI DESC";
				 
				$yetki_tarih[$rows["YETERLILIK_ID"]][] = $db->prep_exec($yetkitarihsql, array($rows["YETERLILIK_ID"], $user_id));
			}
			else{
				$birimsql = "SELECT  DISTINCT BIRIM_ID, YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_KODU, BIRIM_ADI, BIRIM_KODU
							    	FROM M_YETERLILIK
					                JOIN M_BIRIM ON YETERLILIK_ID = BAGIMLI_OLDUGU_YET_ID
					                JOIN M_DENETIM_YETKI USING(BIRIM_ID) 
					                JOIN M_DENETIM USING(DENETIM_ID)
				                    WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ?
				                    AND YETKININ_GERI_ALINDIGI_TARIH IS NULL ORDER BY BIRIM_ID";
				 
				$birimler[$rows["YETERLILIK_ID"]][] = $db->prep_exec($birimsql, array($rows["YETERLILIK_ID"], $user_id));
				 
				$yetkitarihsql = "SELECT YETKI_KAPSAMI_YETKI_TARIHI
					            		FROM M_YETERLILIK 
					  				     JOIN M_BIRIM ON YETERLILIK_ID = BAGIMLI_OLDUGU_YET_ID
					             		JOIN M_DENETIM_YETKI USING(BIRIM_ID) 
					             		JOIN M_DENETIM USING(DENETIM_ID)
					  				   	WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ? 
					              		AND YETKININ_GERI_ALINDIGI_TARIH IS NULL 
					              		AND YETKI_KAPSAMI_YETKI_TARIHI IS NOT NULL
	    								ORDER BY YETKI_KAPSAMI_YETKI_TARIHI DESC";
	
				$yetki_tarih[$rows["YETERLILIK_ID"]][] = $db->prep_exec($yetkitarihsql, array($rows["YETERLILIK_ID"], $user_id));
			}
		}//FOREACH BİTİS
		$sonuc[] = $yenimi;
		$sonuc[] = $birimler;
		$sonuc[] = $yetki_tarih;
		$sonuc[] = $kurulusadi;
		$sonuc[] = 'kurulus';
		return $sonuc;
	}
	
	function getYetkiYeterlilikile($user_id, $yetId){
		$db  = &JFactory::getOracleDBO();
		$kurulussql = "SELECT KURULUS_ADI FROM M_KURULUS
		    		              		WHERE USER_ID = ?";
		$kurulusadi = $db->prep_exec($kurulussql, array($user_id));
			
		$yenimisql = "SELECT USER_ID, YETERLILIK_ID,YETERLILIK_ADI, YETERLILIK_KODU, YENI_MI FROM  M_BELGELENDIRME_YET_TALEBI
						    	JOIN M_YETERLILIK USING(YETERLILIK_ID) 
						    	JOIN M_BASVURU USING(EVRAK_ID)
			              		WHERE BASVURU_TIP_ID = 3 AND BASVURU_DURUM_ID = 6 AND USER_ID = ? AND YETERLILIK_ID = ? ORDER BY YETERLILIK_ID";
		$yenimi = $db->prep_exec($yenimisql, array($user_id, $yetId));
			
		$birimler = array();
		$yetki_tarih = array();
		$sonuc = array();
		foreach($yenimi as $rows){
			if($rows['YENI_MI'] == 0){
				$birimsql = "SELECT DISTINCT BIRIM_ID, YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_KODU,
									   YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO AS BIRIM_NO, 
									   YETERLILIK_ALT_BIRIM_KODU AS BIRIM_KODU
									   FROM M_YETERLILIK 
					  				   JOIN M_YETERLILIK_ALT_BIRIM USING(YETERLILIK_ID) 
					             	   JOIN M_DENETIM_YETKI ON YETERLILIK_ALT_BIRIM_ID = BIRIM_ID
					             	   JOIN M_DENETIM USING(DENETIM_ID)
					  				   WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ? 
									   AND YETKININ_GERI_ALINDIGI_TARIH IS NULL ORDER BY BIRIM_ID";
					
				$birimler = $db->prep_exec($birimsql, array($yetId, $user_id));
					
				$yetkitarihsql = "SELECT YETKI_KAPSAMI_YETKI_TARIHI
						            		FROM M_YETERLILIK 
						  				    JOIN M_YETERLILIK_ALT_BIRIM USING(YETERLILIK_ID) 
						             		JOIN M_DENETIM_YETKI ON YETERLILIK_ALT_BIRIM_ID = BIRIM_ID
						             		JOIN M_DENETIM USING(DENETIM_ID)
						  				   	WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ? 
						              		AND YETKININ_GERI_ALINDIGI_TARIH IS NULL
											AND YETKI_KAPSAMI_YETKI_TARIHI IS NOT NULL
		    								ORDER BY YETKI_KAPSAMI_YETKI_TARIHI DESC";
					
				$yetki_tarih = $db->prep_exec($yetkitarihsql, array($yetId, $user_id));
			}
			else{
				$birimsql = "SELECT  DISTINCT BIRIM_ID, YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_KODU, BIRIM_ADI, BIRIM_KODU
								    	FROM M_YETERLILIK
						                JOIN M_BIRIM ON YETERLILIK_ID = BAGIMLI_OLDUGU_YET_ID
						                JOIN M_DENETIM_YETKI USING(BIRIM_ID) 
						                JOIN M_DENETIM USING(DENETIM_ID)
					                    WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ?
					                    AND YETKININ_GERI_ALINDIGI_TARIH IS NULL ORDER BY BIRIM_ID";
					
				$birimler = $db->prep_exec($birimsql, array($yetId, $user_id));
					
				$yetkitarihsql = "SELECT YETKI_KAPSAMI_YETKI_TARIHI
						            		FROM M_YETERLILIK 
						  				     JOIN M_BIRIM ON YETERLILIK_ID = BAGIMLI_OLDUGU_YET_ID
						             		JOIN M_DENETIM_YETKI USING(BIRIM_ID) 
						             		JOIN M_DENETIM USING(DENETIM_ID)
						  				   	WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ? 
						              		AND YETKININ_GERI_ALINDIGI_TARIH IS NULL 
						              		AND YETKI_KAPSAMI_YETKI_TARIHI IS NOT NULL
		    								ORDER BY YETKI_KAPSAMI_YETKI_TARIHI DESC";
	
				$yetki_tarih = $db->prep_exec($yetkitarihsql, array($yetId, $user_id));
			}
		}//FOREACH BİTİS
		$sonuc[] = $yenimi;
		$sonuc[] = $birimler;
		$sonuc[] = $yetki_tarih;
		$sonuc[] = $kurulusadi;
		$sonuc[] = 'yetkur';
		return $sonuc;
	}
	
	function getYetkiYeterlilikId($yetId){
		$db  = &JFactory::getOracleDBO();
	/*	$kurulussql = "SELECT KURULUS_ADI FROM M_KURULUS
			    		              		WHERE USER_ID = ?";
		$kurulusadi = $db->prep_exec($kurulussql, array($user_id));
	*/		
		$yenimisql = "SELECT USER_ID, YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_KODU, YENI_MI FROM  M_BELGELENDIRME_YET_TALEBI
							    	JOIN M_YETERLILIK USING(YETERLILIK_ID) 
							    	JOIN M_BASVURU USING(EVRAK_ID)
				              		WHERE BASVURU_TIP_ID = 3 AND BASVURU_DURUM_ID = 6 AND YETERLILIK_ID = ? ORDER BY YETERLILIK_ID";
		$yenimi = $db->prep_exec($yenimisql, array($yetId));
			
		$birimler = array();
		$yetki_tarih = array();
		$sonuc = array();
		$kurulusadi = array();
		$kurulus = array();
		foreach($yenimi as $rows){
			if($rows['YENI_MI'] == 0){
				$birimsql = "SELECT DISTINCT BIRIM_ID, YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_KODU,
										   YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, YETERLILIK_ALT_BIRIM_NO AS BIRIM_NO, 
										   YETERLILIK_ALT_BIRIM_KODU AS BIRIM_KODU
										   FROM M_YETERLILIK 
						  				   JOIN M_YETERLILIK_ALT_BIRIM USING(YETERLILIK_ID) 
						             	   JOIN M_DENETIM_YETKI ON YETERLILIK_ALT_BIRIM_ID = BIRIM_ID
						             	   JOIN M_DENETIM USING(DENETIM_ID)
						  				   WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ? 
										   AND YETKININ_GERI_ALINDIGI_TARIH IS NULL ORDER BY BIRIM_ID";
					$birimvarmi = $db->prep_exec($birimsql, array($yetId, $rows["USER_ID"]));
				if(count($birimvarmi) > 0){
					$kurulus[] = $rows;
					$birimler[$rows["USER_ID"]][] = $db->prep_exec($birimsql, array($yetId, $rows["USER_ID"]));
					
					$yetkitarihsql = "SELECT YETKI_KAPSAMI_YETKI_TARIHI
							            		FROM M_YETERLILIK 
							  				    JOIN M_YETERLILIK_ALT_BIRIM USING(YETERLILIK_ID) 
							             		JOIN M_DENETIM_YETKI ON YETERLILIK_ALT_BIRIM_ID = BIRIM_ID
							             		JOIN M_DENETIM USING(DENETIM_ID)
							  				   	WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ? 
							              		AND YETKININ_GERI_ALINDIGI_TARIH IS NULL
												AND YETKI_KAPSAMI_YETKI_TARIHI IS NOT NULL
			    								ORDER BY YETKI_KAPSAMI_YETKI_TARIHI DESC";
					
				$yetki_tarih[$rows["USER_ID"]][] = $db->prep_exec($yetkitarihsql, array($yetId, $rows["USER_ID"]));
				
				$kurulussql = "SELECT KURULUS_ADI FROM M_KURULUS
					    		              		WHERE USER_ID = ?";
				$kurulusadi[$rows["USER_ID"]][] = $db->prep_exec($kurulussql, array($rows["USER_ID"]));
				}
			}
			else{
				$birimsql = "SELECT  DISTINCT BIRIM_ID, YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_KODU, BIRIM_ADI, BIRIM_KODU
									    	FROM M_YETERLILIK
							                JOIN M_BIRIM ON YETERLILIK_ID = BAGIMLI_OLDUGU_YET_ID
							                JOIN M_DENETIM_YETKI USING(BIRIM_ID) 
							                JOIN M_DENETIM USING(DENETIM_ID)
						                    WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ?
						                    AND YETKININ_GERI_ALINDIGI_TARIH IS NULL ORDER BY BIRIM_ID";
					
				$birimvarmi = $db->prep_exec($birimsql, array($yetId, $rows["USER_ID"]));
			if(count($birimvarmi) > 0){
				$kurulus[] = $rows;
				$birimler[$rows["USER_ID"]][] = $birimvarmi;
					
				$yetkitarihsql = "SELECT YETKI_KAPSAMI_YETKI_TARIHI
							            		FROM M_YETERLILIK 
							  				     JOIN M_BIRIM ON YETERLILIK_ID = BAGIMLI_OLDUGU_YET_ID
							             		JOIN M_DENETIM_YETKI USING(BIRIM_ID) 
							             		JOIN M_DENETIM USING(DENETIM_ID)
							  				   	WHERE YETERLILIK_ID = ? AND DENETIM_KURULUS_ID = ? 
							              		AND YETKININ_GERI_ALINDIGI_TARIH IS NULL 
							              		AND YETKI_KAPSAMI_YETKI_TARIHI IS NOT NULL
			    								ORDER BY YETKI_KAPSAMI_YETKI_TARIHI DESC";
	
				$yetki_tarih[$rows["USER_ID"]][] = $db->prep_exec($yetkitarihsql, array($yetId, $rows["USER_ID"]));
				
				$kurulussql = "SELECT KURULUS_ADI FROM M_KURULUS
									    		              		WHERE USER_ID = ?";
				$kurulusadi[$rows["USER_ID"]][] = $db->prep_exec($kurulussql, array($rows["USER_ID"]));
				}
			}
		}//FOREACH BİTİS
		$sonuc[] = $kurulus;
		$sonuc[] = $birimler;
		$sonuc[] = $yetki_tarih;
		$sonuc[] = $kurulusadi;
		$sonuc[] = 'yetId';
		return $sonuc;
	}

}
?>
