<?php
defined('_JEXEC') or die('Restricted access');
include ('libraries/phpqrcode/qrlib.php');

class MatbaaModelMatbaa extends JModel {
	
	function BasilacakBelgeler($durum,$user_id=null){
		$db = JFactory::getOracleDBO ();
// 		$mysqlDB = &JFactory::getDBO();
		
// 		$sqlMatbaa= "SELECT email FROM #__users as users
// 					WHERE tgUserId = 1006312";
// 		$mysqlDB->setQuery($sqlMatbaa);
// 		$matbaaUser = $mysqlDB->loadObjectList();
		
// 		$sqlMatbaa= "SELECT users.* FROM #__users as users
// 					JOIN #__community_acl_users as user_groups ON users.id = user_groups.user_id 
// 					WHERE users.block = 0 AND (user_groups.group_id = 15 OR user_groups.group_id = 17) ORDER BY users.name";
// 			$mysqlDB->setQuery($sqlMatbaa);
// 			$matbaaUser = $mysqlDB->loadObjectList();
			
// 			$basar = FormFactory::toUpperCase('Başarılı');
			
// 			$recipient = $matbaaUser;
			
// 			$mailer =& JFactory::getMailer();
			
// 			$config =& JFactory::getConfig();
// 			$sender = array(
// 					$config->getValue( 'config.mailfrom' ),
// 					$config->getValue( 'config.fromname' ) );
// 			$mailer->setSender($sender);
			
// 			//$recipient = 'bim@myk.gov.tr';
// 			$mailer->addRecipient($recipient);
			
// 			$body   = "The body string";
// 			$mailer->setSubject('The subject string');
// 			$mailer->setBody($body.' http://portal.myk.gov.tr/index.php?option=com_matbaa&view=matbaa&layout=basilacak');
			
// 			$send =& $mailer->Send();
		
// 		$directory = EK_FOLDER.'sinavBelgeQRcode/12';
// 		if (!file_exists($directory)){
// 			mkdir($directory, 0700,true);
// 		}
// 		for($i = 11; $i<22; $i++){
// 			$belgeUrl = 'http://portal.myk.gov.tr/index.php?option=com_belgelendirme&view=belge_sorgula&layout=belgeno_sorgu&belgeno=YB0015/12UY0096-2/00/'.$i;
// 			$QRAD = "YB0015#12UY0096-2#00#".$i;
// 			$path = $directory.'/'.$QRAD.'.png';
// 			QRcode::png($belgeUrl,$path,QR_ECLEVEL_Q,3,1);
// 		}
		
		
		if($user_id){
			$sql = "SELECT DISTINCT M_BELGELENDIRME_MATBAA.SINAV_ID,KARGONO, MATBAA_ID,SINAV_TARIHI,ISTEK_TARIHI,BASIM_TARIHI,GONDERIM_TARIHI,YETERLILIK_KODU,YETERLILIK_ADI,REVIZYON,M_KURULUS.KURULUS_ADI,M_KURULUS.KURULUS_ADRESI,M_KURULUS.KURULUS_TELEFON,
					M_KURULUS_EDIT.KURULUS_ADI as KUR_AD,
					M_KURULUS_EDIT.KURULUS_ADRESI as KUR_ADRES, 
					M_KURULUS_EDIT.KURULUS_TELEFON as KUR_TELEFON
					FROM M_BELGELENDIRME_MATBAA
					JOIN M_BELGELENDIRME_HAK_KAZANANLAR USING(MATBAA_ID)
	        		JOIN M_YETERLILIK USING(YETERLILIK_ID)
					JOIN M_KURULUS ON KURULUS_ID = M_KURULUS.USER_ID
					LEFT JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID AND M_KURULUS_EDIT.AKTIF = 1
					WHERE MATBAA_DURUM = ? AND KURULUS_ID=? ORDER BY ISTEK_TARIHI ASC";
			$basilacak = $db->prep_exec($sql, array($durum,$user_id));
		}else{
			$sql = "SELECT DISTINCT M_BELGELENDIRME_MATBAA.SINAV_ID,KARGONO, MATBAA_ID,SINAV_TARIHI,ISTEK_TARIHI,BASIM_TARIHI,GONDERIM_TARIHI,YETERLILIK_KODU,YETERLILIK_ADI,REVIZYON,M_KURULUS.KURULUS_ADI,M_KURULUS.KURULUS_ADRESI,M_KURULUS.KURULUS_TELEFON, 
					M_KURULUS_EDIT.KURULUS_ADI as KUR_AD,
					M_KURULUS_EDIT.KURULUS_ADRESI as KUR_ADRES,
					M_KURULUS_EDIT.KURULUS_TELEFON as KUR_TELEFON 
					FROM M_BELGELENDIRME_MATBAA
					JOIN M_BELGELENDIRME_HAK_KAZANANLAR USING(MATBAA_ID) 
	        		JOIN M_YETERLILIK USING(YETERLILIK_ID)
					JOIN M_KURULUS ON KURULUS_ID = M_KURULUS.USER_ID
					LEFT JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID AND M_KURULUS_EDIT.AKTIF = 1
					WHERE MATBAA_DURUM = ? ORDER BY ISTEK_TARIHI ASC";
			$basilacak = $db->prep_exec($sql, array($durum));
		}
		
		$adayCount = array();
		foreach ($basilacak as $row){
			$sqlCount = "SELECT COUNT(*) AS SAY FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE MATBAA_ID = ?";
			$adayCount[$row['MATBAA_ID']] = $db->prep_exec($sqlCount, array($row['MATBAA_ID']));
		}
		
		return array(0=>$basilacak,1=>$adayCount);
	}

	function getAdayBelgeExcel($matbaaId){
		$_db = JFactory::getOracleDBO ();
		 
		$sqlMatbaa = "SELECT * FROM M_BELGELENDIRME_MATBAA WHERE MATBAA_ID = ?";
		
		$sinavId = $_db->prep_exec($sqlMatbaa, array($matbaaId));
		$sinavId = $sinavId[0]['SINAV_ID'];
		
		$sql = "SELECT DISTINCT M_BELGE_SORGU.BELGE_DUZENLEME_TARIHI,
								M_BELGE_SORGU.GECERLILIK_TARIHI,
								M_BELGE_SORGU.YETERLILIK_SEVIYESI,
								M_BELGELENDIRME_OGRENCI.*,
								M_BELGELENDIRME_HAK_KAZANANLAR.*,
								M_YETERLILIK.*, 
								M_KURULUS.* 
				 FROM M_BELGE_SORGU
                           	JOIN M_BELGELENDIRME_OGRENCI ON M_BELGE_SORGU.TCKIMLIKNO = M_BELGELENDIRME_OGRENCI.TC_KIMLIK
                            JOIN M_BELGELENDIRME_HAK_KAZANANLAR ON (M_BELGE_SORGU.TCKIMLIKNO = M_BELGELENDIRME_HAK_KAZANANLAR.TC_KIMLIK AND M_BELGE_SORGU.BELGENO = M_BELGELENDIRME_HAK_KAZANANLAR.BELGE_NO)
                    		JOIN M_YETERLILIK ON M_BELGE_SORGU.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
                    		JOIN M_KURULUS ON M_BELGE_SORGU.KURULUS_ID = M_KURULUS.USER_ID
				WHERE M_BELGELENDIRME_HAK_KAZANANLAR.MATBAA_ID = ? AND M_BELGELENDIRME_HAK_KAZANANLAR.DURUM = 2 ORDER BY M_BELGELENDIRME_HAK_KAZANANLAR.ID ASC";
		$data = $_db->prep_exec($sql,array($matbaaId));
	
	
		$sqlYetkili = "SELECT * FROM M_BELGELENDIRME_IMZA_YETKILI
						WHERE BASVURU_ID =(SELECT DISTINCT BASVURU_ID FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE MATBAA_ID = ?)";
		$yetkili = $_db->prep_exec($sqlYetkili, array($matbaaId));
	
		$sql = "SELECT M_KURULUS.*, M_BELGELENDIRME_KURULUS_SABLON.*, M_KURULUS_EDIT.KURULUS_ADI as KUR_AD, M_KURULUS_EDIT.KURULUS_WEB as KUR_WEB 
				FROM M_BELGELENDIRME_SINAV
	          		JOIN M_KURULUS ON M_BELGELENDIRME_SINAV.KURULUS_ID = M_KURULUS.USER_ID
					JOIN M_BELGELENDIRME_KURULUS_SABLON ON M_BELGELENDIRME_SINAV.KURULUS_ID = M_BELGELENDIRME_KURULUS_SABLON.KURULUS_ID
					LEFT JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID AND M_KURULUS_EDIT.AKTIF = 1
					WHERE SINAV_ID =?";
		$kurData = $_db->prep_exec($sql, array($sinavId));
	
		$sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE MATBAA_ID = ?";
		
		$data2 = $_db->prep_exec($sql, array($matbaaId));
		
		$AdayBirims = array();
		
		if($data[0]['YENI_MI']==1){
			$sqlBirim="SELECT * FROM M_BELGELENDIRME_BASARILI_BIRIM 
					JOIN M_BIRIM USING(BIRIM_ID) WHERE HAK_KAZANAN_ID = ? AND BIRIM_UCRETI_ODENECEK_MI = 1 ORDER BY BIRIM_KODU";
			
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
	
	function BelgeDurum($post){
		$db = JFactory::getOracleDBO ();
		if($post['durum'] == 2){
			$sql = "UPDATE M_BELGELENDIRME_MATBAA SET MATBAA_DURUM=?,BASIM_TARIHI = TO_DATE(sysdate, 'dd/mm/yyyy') WHERE MATBAA_ID=?";
			$db->prep_exec_insert($sql, array($post['durum'],$post['matbaaId']));
		}
		else if($post['durum'] == 3) {
			$sql = "UPDATE M_BELGELENDIRME_MATBAA SET MATBAA_DURUM=?, GONDERIM_TARIHI = TO_DATE(sysdate, 'dd/mm/yyyy'), KARGONO=? WHERE MATBAA_ID=?";
			$db->prep_exec_insert($sql, array($post['durum'],$post['kargoNo'],$post['matbaaId']));
		}
		
		return true;
	}
	
	function getKuruluslar($durum){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT DISTINCT M_KURULUS.*, M_KURULUS_EDIT.KURULUS_ADI as KUR_AD FROM M_BELGELENDIRME_MATBAA
					JOIN M_BELGELENDIRME_HAK_KAZANANLAR USING(MATBAA_ID)
					JOIN M_KURULUS ON KURULUS_ID = M_KURULUS.USER_ID
					LEFT JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID AND M_KURULUS_EDIT.AKTIF = 1
					WHERE MATBAA_DURUM = ? ORDER BY M_KURULUS.KURULUS_ADI ASC";
		
		return $db->prep_exec($sql, array($durum));
	}
	
	function getYeterlilikler($durum){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT DISTINCT YETERLILIK_ADI, YETERLILIK_KODU, REVIZYON, YETERLILIK_ID FROM M_BELGELENDIRME_MATBAA
					JOIN M_BELGELENDIRME_HAK_KAZANANLAR USING(MATBAA_ID)
					JOIN M_YETERLILIK USING(YETERLILIK_ID)
					WHERE MATBAA_DURUM = ? ORDER BY YETERLILIK_ADI ASC";
		
		return $db->prep_exec($sql, array($durum));
	}
	
	function SearchMatbaa($post){
		$db = JFactory::getOracleDBO ();
		
		$kurId = $post['kurId'];
		$yetId = $post['yetId'];
		$durum = $post['durum'];
		
		$sql = "SELECT DISTINCT M_BELGELENDIRME_MATBAA.SINAV_ID, MATBAA_ID,SINAV_TARIHI,ISTEK_TARIHI,BASIM_TARIHI,GONDERIM_TARIHI,KARGONO,YETERLILIK_KODU,YETERLILIK_ADI,REVIZYON,M_KURULUS.KURULUS_ADI,M_KURULUS.KURULUS_ADRESI,M_KURULUS.KURULUS_TELEFON 
				FROM M_BELGELENDIRME_MATBAA
					JOIN M_BELGELENDIRME_HAK_KAZANANLAR USING(MATBAA_ID)
	        		JOIN M_YETERLILIK USING(YETERLILIK_ID)
					JOIN M_KURULUS ON KURULUS_ID = M_KURULUS.USER_ID
					WHERE MATBAA_DURUM = ? ";
		
		if($kurId != 0){
			$sql .= " AND KURULUS_ID=".$kurId;
		}
		
		if($yetId != 0){
			$sql .= " AND YETERLILIK_ID=".$yetId;
		}
		
		$sql .= " ORDER BY ISTEK_TARIHI ASC";
		
		$data = $db->prep_exec($sql, array($durum));
		
		if($data){
			$adayCount = array();
			foreach ($data as $row){
				$sqlCount = "SELECT COUNT(*) AS SAY FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE MATBAA_ID = ?";
				$adayCount[$row['MATBAA_ID']] = $db->prep_exec($sqlCount, array($row['MATBAA_ID']));
			}
			return array(0=>$data,1=>$adayCount);
		}
		else{
			return false;
		}
	}
	
	function takipNoGetir($post){
		$db = JFactory::getOracleDBO ();
		
		$matbaaId = $post['matbaaId'];
		$sql = "SELECT KARGONO FROM M_BELGELENDIRME_MATBAA WHERE MATBAA_ID = ?";
		$data = $db->prep_exec($sql, array($matbaaId));
		
		if($data){
			return $data;
		}else{
			return false;
		}
	}
	
	function takipNoUpdate($post){
		$db = JFactory::getOracleDBO ();
	
		$matbaaId = $post['matbaaId'];
		$kargono = trim($post['kargono']);
		$sql = "UPDATE M_BELGELENDIRME_MATBAA SET KARGONO = ? WHERE MATBAA_ID = ?";
		$data = $db->prep_exec_insert($sql, array($kargono,$matbaaId));
	
		if($data){
			return $data;
		}else{
			return false;
		}
	}
	
	function getKurulus(){
		$db = JFactory::getOracleDBO ();
		
		$sql="SELECT * FROM M_KURULUS WHERE KURULUS_DURUM_ID != 1";
		
		return $db->prep_exec($sql, array());
	}
	
	function BasilmayanGecmisMail(){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT * FROM M_BELGELENDIRME_MATBAA 
				WHERE BASIM_TARIHI IS NULL AND TO_DATE(ISTEK_TARIHI) <= (SELECT TO_DATE(SYSDATE)-4 FROM DUAL) 
				AND (SELECT TO_CHAR(TO_DATE(ISTEK_TARIHI), 'DY', 'NLS_DATE_LANGUAGE=TURKISH') FROM DUAL) IN ('PZT','PAZ')
			UNION 
			SELECT * FROM M_BELGELENDIRME_MATBAA 
				WHERE BASIM_TARIHI IS NULL AND TO_DATE(ISTEK_TARIHI) <= (SELECT TO_DATE(SYSDATE)-6 FROM DUAL) 
				AND (SELECT TO_CHAR(TO_DATE(ISTEK_TARIHI), 'DY', 'NLS_DATE_LANGUAGE=TURKISH') FROM DUAL) IN ('SAL','ÇAR','PER','CUM')
			UNION 
			SELECT * FROM M_BELGELENDIRME_MATBAA 
				WHERE BASIM_TARIHI IS NULL AND TO_DATE(ISTEK_TARIHI) <= (SELECT TO_DATE(SYSDATE)-5 FROM DUAL) 
				AND (SELECT TO_CHAR(TO_DATE(ISTEK_TARIHI), 'DY', 'NLS_DATE_LANGUAGE=TURKISH') FROM DUAL) IN ('CMT') ";
		
		$data = $db->prep_exec($sql, array());
		
		$mysqlDB = &JFactory::getDBO();
		$sqlMatbaa= "SELECT email FROM #__users WHERE tgUserId = 178";
		$mysqlDB->setQuery($sqlMatbaa);
		$matbaaUser = $mysqlDB->loadResult();
		
		$kay = 0;
		if($data){
			$body = '<div style="font-size:16px;">';
			foreach ($data as $val){
				$sql = "SELECT COUNT(*) AS SAY FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE MATBAA_ID = ?";
				$say = $db->prep_exec($sql, array($val['MATBAA_ID']));
				
				if($say[0]['SAY']>0){
					$body .= "<strong>".$val['MATBAA_ID']."</strong> Matbaa ID'li <strong>".$say[0]['SAY']."</strong> belge,<br>";
					$kay++;
				}
			}
			
			$body .= "<br><h3>İstek tarihinden itibaren 3 gün içerisinde basılmamıştır.</h3></div>";
			if($kay>0){
				FormFactory::sentEmail('Basım Zamanı Gecikmiş Belgeler', $body, array('ktunc@myk.gov.tr','mozgen@myk.gov.tr','mordukaya@myk.gov.tr',$matbaaUser), true);
			}
		}
		return true;
	}
	
	function GonderimiGecmisMail(){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT * FROM M_BELGELENDIRME_MATBAA
				WHERE GONDERIM_TARIHI IS NULL AND TO_DATE(BASIM_TARIHI) <= (SELECT TO_DATE(SYSDATE)-2 FROM DUAL)
				AND (SELECT TO_CHAR(TO_DATE(BASIM_TARIHI), 'DY', 'NLS_DATE_LANGUAGE=TURKISH') FROM DUAL) IN ('PZT','PAZ','SAL','ÇAR')
			UNION
			SELECT * FROM M_BELGELENDIRME_MATBAA
				WHERE GONDERIM_TARIHI IS NULL AND TO_DATE(BASIM_TARIHI) <= (SELECT TO_DATE(SYSDATE)-4 FROM DUAL)
				AND (SELECT TO_CHAR(TO_DATE(BASIM_TARIHI), 'DY', 'NLS_DATE_LANGUAGE=TURKISH') FROM DUAL) IN ('PER','CUM')
			UNION
			SELECT * FROM M_BELGELENDIRME_MATBAA
				WHERE GONDERIM_TARIHI IS NULL AND TO_DATE(BASIM_TARIHI) <= (SELECT TO_DATE(SYSDATE)-3 FROM DUAL)
				AND (SELECT TO_CHAR(TO_DATE(BASIM_TARIHI), 'DY', 'NLS_DATE_LANGUAGE=TURKISH') FROM DUAL) IN ('CMT') ";
		
		$data = $db->prep_exec($sql, array());
		
		$mysqlDB = &JFactory::getDBO();
		$sqlMatbaa= "SELECT email FROM #__users WHERE tgUserId = 178";
		$mysqlDB->setQuery($sqlMatbaa);
		$matbaaUser = $mysqlDB->loadResult();
		$kay = 0;
		if($data){
			$body = '<div style="font-size:16px;">';
			foreach ($data as $val){
				$sql = "SELECT COUNT(*) AS SAY FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE MATBAA_ID = ?";
				$say = $db->prep_exec($sql, array($val['MATBAA_ID']));
				if($say[0]['SAY']>0){
					$body .= "<strong>".$val['MATBAA_ID']."</strong> Matbaa ID'li <strong>".$say[0]['SAY']."</strong> belge,<br>";
					$kay++;
				}
			}
			
			$body .= "<br><h3>Basım tarihinden itibaren 1 gün içerisinde gönderilmemiştir.</h3></div>";
			if($kay>0){
				FormFactory::sentEmail('Gönderim Zamanı Gecikmiş Belgeler', $body, array('ktunc@myk.gov.tr','mozgen@myk.gov.tr','mordukaya@myk.gov.tr',$matbaaUser), true);
			}
		}
		return true;
	}
	
	function MatbaaBasilmayanUyariMail(){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT * FROM M_BELGELENDIRME_MATBAA
				WHERE BASIM_TARIHI IS NULL AND TO_DATE(ISTEK_TARIHI) = (SELECT TO_DATE(SYSDATE)-3 FROM DUAL)
				AND (SELECT TO_CHAR(TO_DATE(ISTEK_TARIHI), 'DY', 'NLS_DATE_LANGUAGE=TURKISH') FROM DUAL) IN ('PZT','PAZ','SAL')
			UNION
			SELECT * FROM M_BELGELENDIRME_MATBAA
				WHERE BASIM_TARIHI IS NULL AND TO_DATE(ISTEK_TARIHI) = (SELECT TO_DATE(SYSDATE)-5 FROM DUAL)
				AND (SELECT TO_CHAR(TO_DATE(ISTEK_TARIHI), 'DY', 'NLS_DATE_LANGUAGE=TURKISH') FROM DUAL) IN ('ÇAR','PER','CUM')
			UNION
			SELECT * FROM M_BELGELENDIRME_MATBAA
				WHERE BASIM_TARIHI IS NULL AND TO_DATE(ISTEK_TARIHI) = (SELECT TO_DATE(SYSDATE)-4 FROM DUAL)
				AND (SELECT TO_CHAR(TO_DATE(ISTEK_TARIHI), 'DY', 'NLS_DATE_LANGUAGE=TURKISH') FROM DUAL) IN ('CMT') ";
		
		$data = $db->prep_exec($sql, array());
		
		$mysqlDB = &JFactory::getDBO();
		$sqlMatbaa= "SELECT email FROM #__users WHERE tgUserId = 178";
		$mysqlDB->setQuery($sqlMatbaa);
		$matbaaUser = $mysqlDB->loadResult();
		
		$kay = 0;
		if($data){
			$body = '<div style="font-size:16px;">';
			foreach ($data as $val){
				$sql = "SELECT COUNT(*) AS SAY FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE MATBAA_ID = ?";
				$say = $db->prep_exec($sql, array($val['MATBAA_ID']));
				if($say[0]['SAY']>0){
					$body .= "<strong>".$val['MATBAA_ID']."</strong> Matbaa ID'li <strong>".$say[0]['SAY']."</strong> belge,<br>";
					$kay++;
				}
			}
				
			$body .= "<br><h3>İstek tarihinden itibaren basılmayı bekleyen belgeler için son gündür.</h3></div>";
			if($kay>0){
				FormFactory::sentEmail('Basım Zamanı Son Gün Olan Belgeler', $body, array('ktunc@myk.gov.tr',$matbaaUser), true);
			}
		}
		return true;
	}
	
	function MatbaaGonderilmeyenUyariMail(){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT * FROM M_BELGELENDIRME_MATBAA
				WHERE GONDERIM_TARIHI IS NULL AND TO_DATE(BASIM_TARIHI) = (SELECT TO_DATE(SYSDATE)-1 FROM DUAL)
				AND (SELECT TO_CHAR(TO_DATE(BASIM_TARIHI), 'DY', 'NLS_DATE_LANGUAGE=TURKISH') FROM DUAL) IN ('PZT','PAZ','SAL','ÇAR','PER')
			UNION
			SELECT * FROM M_BELGELENDIRME_MATBAA
				WHERE GONDERIM_TARIHI IS NULL AND TO_DATE(BASIM_TARIHI) = (SELECT TO_DATE(SYSDATE)-3 FROM DUAL)
				AND (SELECT TO_CHAR(TO_DATE(BASIM_TARIHI), 'DY', 'NLS_DATE_LANGUAGE=TURKISH') FROM DUAL) IN ('CUM')
			UNION
			SELECT * FROM M_BELGELENDIRME_MATBAA
				WHERE GONDERIM_TARIHI IS NULL AND TO_DATE(BASIM_TARIHI) = (SELECT TO_DATE(SYSDATE)-2 FROM DUAL)
				AND (SELECT TO_CHAR(TO_DATE(BASIM_TARIHI), 'DY', 'NLS_DATE_LANGUAGE=TURKISH') FROM DUAL) IN ('CMT') ";
		
		$data = $db->prep_exec($sql, array());
		
		$mysqlDB = &JFactory::getDBO();
		$sqlMatbaa= "SELECT email FROM #__users WHERE tgUserId = 178";
		$mysqlDB->setQuery($sqlMatbaa);
		$matbaaUser = $mysqlDB->loadResult();
		
		$kay = 0;
		if($data){
			$body = '<div style="font-size:16px;">';
			foreach ($data as $val){
				$sql = "SELECT COUNT(*) AS SAY FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE MATBAA_ID = ?";
				$say = $db->prep_exec($sql, array($val['MATBAA_ID']));
				if($say[0]['SAY']>0){
					$body .= "<strong>".$val['MATBAA_ID']."</strong> Matbaa ID'li <strong>".$say[0]['SAY']."</strong> belge,<br>";
					$kay++;
				}
			}
				
			$body .= "<br><h3>Basım tarihinden itibaren gönderilmeyi bekleyen belgeler için son gündür.</h3></div>";
			if($kay>0){
				FormFactory::sentEmail('Gönderim Zamanı Son Gün Olan Belgeler', $body, array('ktunc@myk.gov.tr',$matbaaUser), true);				
			}			
		}
		return true;
	}
}
?>