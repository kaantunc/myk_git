<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once('libraries/form/functions.php');
require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');
include ('libraries/phpqrcode/qrlib.php');

class BelgelendirmeModelBelge_Edit extends JModel {
	
	public function BelgeDuzenleKaydet($post){
		$db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		
		$belgeNo = $post['belgeNo'];
		$belgeId = $post['belgeId'];
		
		// Kayıtlı Belgeyi al. M_BELGE_SORGU_OLD'a kaydet.
		$sql = "SELECT * FROM M_BELGE_SORGU WHERE ID = ?";
		$data = $db->prep_exec($sql, array($belgeId));
		
		if(!$data){
			return false;
		}
		$belge = $data[0];
		
		$params = array(
				$belge['ID'],
				$belge['TCKIMLIKNO'],
				$belge['AD'],
				$belge['SOYAD'],
				$belge['BELGENO'],
				$belge['YETERLILIK_ADI'],
				$belge['YETERLILIK_SEVIYESI'],
				$belge['SINAV_TARIHI'],
				$belge['BELGE_DUZENLEME_TARIHI'],
				$belge['GECERLILIK_TARIHI'],
				$belge['BELGELENDIRME_KURULUSU'],
				$belge['KURULUS_ID'],
				$belge['YETERLILIK_ID'],
				$belge['IMZA_YETKILISI'],
				$belge['AKREDITASYON_NO'],
				$belge['KURULUS_ADI'],
				$belge['YETKILENDIRME_NO'],
				$belge['MYK_MARKASI'],
				$belge['TURKAK_MARKASI'],
				$belge['YK_TARIH'],
				$belge['BELGEDURUMU'],
				$belge['IPTAL_ACIKLAMA'],
				$belge['USER_ID'],
				$belge['IMZA_YETKILISI_UNVAN']
		);
		
		$sqlInsert = "INSERT INTO M_BELGE_SORGU_OLD (ID,TCKIMLIKNO,AD,SOYAD,BELGENO,YETERLILIK_ADI,YETERLILIK_SEVIYESI,
				SINAV_TARIHI,BELGE_DUZENLEME_TARIHI,GECERLILIK_TARIHI,BELGELENDIRME_KURULUSU,KURULUS_ID,YETERLILIK_ID,
				IMZA_YETKILISI,AKREDITASYON_NO,KURULUS_ADI,YETKILENDIRME_NO,MYK_MARKASI,TURKAK_MARKASI,YK_TARIH,
				BELGEDURUMU,IPTAL_ACIKLAMA,USER_ID,DEG_TARIH,IMZA_YETKILISI_UNVAN)
				VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,TO_DATE('".date('d/m/Y H:i:s').",'DD/MM/YYYY HH24:MI:SS''),?)";
		
		$return = $db->prep_exec_insert($sqlInsert, $params);
		
		if(!$return){
			return false;
		}
		
		$noBelge = $post['noBelge'];
		$belgeTarih = $post['belgeDuzTarih'];
		$belgeGecTarih = $post['belgeGecTarih'];
		$belgeDurumu = $post['belgeDurumu'];
		$durumAciklama = $post['aciklama'];
		$yetkili = $post['yetkili'];
		$yetkiliUnvan = $post['yetkiliUnvan'];
		
		$sqlAday = "SELECT ADI, SOYADI FROM M_BELGELENDIRME_OGRENCI WHERE TC_KIMLIK = ?";
		$dataAday = $db->prep_exec($sqlAday, array($belge['TCKIMLIKNO']));
		
		$sqlYet = "SELECT YETERLILIK_ADI,YETERLILIK_ID, SEVIYE_ID FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
		$dataYet = $db->prep_exec($sqlYet, array($belge['YETERLILIK_ID']));
		
		$sqlKur = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI FROM M_KURULUS
					  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.USER_ID = ? 
					UNION
					SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI FROM M_KURULUS
					  WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND USER_ID = ?
					  ORDER BY KURULUS_ADI ASC";
		
		$dataKur = $db->prep_exec($sqlKur, array($belge['KURULUS_ID']));
		
		$params = array(
				$dataAday[0]['ADI'],
				$dataAday[0]['SOYADI'],
				$noBelge,
				$dataYet[0]['YETERLILIK_ADI'],
				$dataYet[0]['YETERLILIK_SEVIYESI'],
				$belgeTarih,
				$belgeGecTarih,
				$dataKur[0]['KURULUS_ADI'],
				$yetkili,
				$dataKur[0]['KURULUS_ADI'],
				date("d/m/Y"),
				$belgeDurumu,
				$durumAciklama,
				$yetkiliUnvan
		);
		
		$sqlUpdate = "UPDATE M_BELGE_SORGU SET AD=?, SOYAD=?, BELGENO=?, YETERLILIK_ADI=?, YETERLILIK_SEVIYESI=?, 
				BELGE_DUZENLEME_TARIHI=?, GECERLILIK_TARIHI=?, BELGELENDIRME_KURULUSU=?, IMZA_YETKILISI=?, 
				KURULUS_ADI=?, YK_TARIH=?, BELGEDURUMU=?, IPTAL_ACIKLAMA=?, IMZA_YETKILISI_UNVAN=? WHERE ID=".$belgeId;
		
		$return = $db->prep_exec_insert($sqlUpdate, $params);
		
		if($return){
			return $noBelge;
		}else{
			return false;
		}
	}
	
	public function BelgeAdayBilgisi($post){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT TCKIMLIKNO, AD, SOYAD FROM M_BELGE_SORGU WHERE ID=?";
		$dataBelge = $db->prep_exec($sql, array($post['belgeId']));
		
		$sqlAday = "SELECT ADI, SOYADI FROM M_BELGELENDIRME_OGRENCI WHERE TC_KIMLIK=?";
		$dataAday = $db->prep_exec($sqlAday, array($dataBelge[0]['TCKIMLIKNO']));
		
		if($dataBelge[0]['AD'] != $dataAday[0]['ADI'] || $dataBelge[0]['SOYAD'] != $dataAday[0]['SOYADI']){
			return $dataAday[0];
		}else{
			return false;
		}
	}
	
	public function BelgeAdayBilgisiGuncelle($post){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT TCKIMLIKNO FROM M_BELGE_SORGU WHERE ID=?";
		$dataBelge = $db->prep_exec($sql, array($post['belgeId']));
		
		$sqlAday = "SELECT ADI, SOYADI FROM M_BELGELENDIRME_OGRENCI WHERE TC_KIMLIK=?";
		$dataAday = $db->prep_exec($sqlAday, array($dataBelge[0]['TCKIMLIKNO']));
		
		$return = $this->BelgeSorguOldYedekle($post['belgeId']);
		if(!$return){
			return false;
		}
		
		$sqlUp = "UPDATE M_BELGE_SORGU SET AD=?,SOYAD=? WHERE ID=?";
		$return = $db->prep_exec_insert($sqlUp, array($dataAday[0]['ADI'],$dataAday[0]['SOYADI'],$post['belgeId']));
		
		if($return){
			return true;
		}else{
			return false;
		}
	}
	
	public function BelgeSorguOldYedekle($belgeId){
		$db = JFactory::getOracleDBO ();
		
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		
		$sql = "SELECT * FROM M_BELGE_SORGU WHERE ID = ?";
		$data = $db->prep_exec($sql, array($belgeId));
		
		if(!$data){
			return false;
		}
		
		$belge = $data[0];
		
		$params = array(
				$belge['ID'],
				$belge['TCKIMLIKNO'],
				$belge['AD'],
				$belge['SOYAD'],
				$belge['BELGENO'],
				$belge['YETERLILIK_ADI'],
				$belge['YETERLILIK_SEVIYESI'],
				$belge['SINAV_TARIHI'],
				$belge['BELGE_DUZENLEME_TARIHI'],
				$belge['GECERLILIK_TARIHI'],
				$belge['BELGELENDIRME_KURULUSU'],
				$belge['KURULUS_ID'],
				$belge['YETERLILIK_ID'],
				$belge['IMZA_YETKILISI'],
				$belge['AKREDITASYON_NO'],
				$belge['KURULUS_ADI'],
				$belge['YETKILENDIRME_NO'],
				$belge['MYK_MARKASI'],
				$belge['TURKAK_MARKASI'],
				$belge['YK_TARIH'],
				$belge['BELGEDURUMU'],
				$belge['IPTAL_ACIKLAMA'],
				$user_id,
				date('d/m/Y H:i:s'),
				$belge['IMZA_YETKILISI_UNVAN']
		);
		
		$sqlInsert = "INSERT INTO M_BELGE_SORGU_OLD (ID,TCKIMLIKNO,AD,SOYAD,BELGENO,YETERLILIK_ADI,YETERLILIK_SEVIYESI,
				SINAV_TARIHI,BELGE_DUZENLEME_TARIHI,GECERLILIK_TARIHI,BELGELENDIRME_KURULUSU,KURULUS_ID,YETERLILIK_ID,
				IMZA_YETKILISI,AKREDITASYON_NO,KURULUS_ADI,YETKILENDIRME_NO,MYK_MARKASI,TURKAK_MARKASI,YK_TARIH,
				BELGEDURUMU,IPTAL_ACIKLAMA,USER_ID,DEG_TARIH,IMZA_YETKILISI_UNVAN)
				VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,TO_DATE(?,'DD/MM/YYYY HH24:MI:SS'),?)";
		
		$return = $db->prep_exec_insert($sqlInsert, $params);
		
		if($return){
			return true;
		}else{
			return false;
		}
	}
	
	public function BelgeImzaYetkilisiGuncelle($post){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT BELGENO FROM M_BELGE_SORGU WHERE ID=?";
		$dataBelge = $db->prep_exec($sql, array($post['belgeId']));
		
		$return = $this->BelgeSorguOldYedekle($post['belgeId']);
		if(!$return){
			return false;
		}
		
		$sqlUp = "UPDATE M_BELGE_SORGU SET IMZA_YETKILISI=?, IMZA_YETKILISI_UNVAN=? WHERE ID=?";
		$return = $db->prep_exec_insert($sqlUp, array($post['yetkili'],$post['yetkiliUnvan'],$post['belgeId']));
		
		if($return){
			return $dataBelge[0]['BELGENO'];
		}else{
			return false;
		}
	}
	
	public function BelgeYetBilgisi($post){
		$db = JFactory::getOracleDBO ();
		
		$sqlBelge = "SELECT YETERLILIK_ID, YETERLILIK_ADI, YETERLILIK_SEVIYESI FROM M_BELGE_SORGU WHERE ID = ?";
		$dataBelge = $db->prep_exec($sqlBelge, array($post['belgeId']));
		
		
		$sql = "SELECT M_YETERLILIK.YETERLILIK_KODU, M_YETERLILIK.YETERLILIK_ADI, M_YETERLILIK.SEVIYE_ID, M_YETERLILIK.REVIZYON 
				FROM M_BELGE_SORGU 
				JOIN M_YETERLILIK ON M_BELGE_SORGU.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
				WHERE M_BELGE_SORGU.ID = ?";
		
		$dataYet = $db->prep_exec($sql, array($post['belgeId']));
		
		if($dataBelge[0]['YETERLILIK_ADI'] != $dataYet[0]['YETERLILIK_ADI'] || $dataBelge[0]['YETERLILIK_SEVIYESI'] != $dataYet[0]['SEVIYE_ID']){
			return $dataYet[0];
		}else{
			false;
		}
	}
	
	public function BelgeYeterlilikBilgisiGuncelle($post){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT BELGENO, YETERLILIK_ID FROM M_BELGE_SORGU WHERE ID=?";
		$dataBelge = $db->prep_exec($sql, array($post['belgeId']));
		
		$return = $this->BelgeSorguOldYedekle($post['belgeId']);
		if(!$return){
			return false;
		}
		
		$sqlYet = "SELECT YETERLILIK_ADI, SEVIYE_ID FROM M_YETERLILIK WHERE YETERLILIK_ID=?";
		$dataYet = $db->prep_exec($sql, $dataBelge[0]['YETERLILIK_ID']);
		
		$sqlUp = "UPDATE M_BELGE_SORGU SET YETERLILIK_ADI = ?, YETERLILIK_SEVIYESI = ? WHERE ID = ?";
		$return = $db->prep_exec_insert($sqlUp, array($dataYet[0]['YETERLILIK_ADI'],$dataYet[0]['SEVIYE_ID'],$post['belgeId']));
		
		if($return){
			return true;
		}else{
			return false;
		}
	}
	
	public function BelgeKurBilgisi($post){
		$db = JFactory::getOracleDBO ();
	
		$sqlBelge = "SELECT KURULUS_ADI, KURULUS_ID, BELGELENDIRME_KURULUSU FROM M_BELGE_SORGU WHERE ID = ?";
		$dataBelge = $db->prep_exec($sqlBelge, array($post['belgeId']));
	
	
		$sqlKur = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI FROM M_KURULUS
					  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.USER_ID = ? 
					UNION
					SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI FROM M_KURULUS
					  WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.USER_ID = ?
					  ";
	
		$dataKur = $db->prep_exec($sqlKur, array($dataBelge[0]['KURULUS_ID'],$dataBelge[0]['KURULUS_ID']));
	
		if($dataBelge[0]['BELGELENDIRME_KURULUSU'] != $dataKur[0]['KURULUS_ADI']){
			return $dataKur[0];
		}else{
			false;
		}
	}
	
	public function BelgeKurulusBilgisiGuncelle($post){
		$db = JFactory::getOracleDBO ();
	
		$sql = "SELECT BELGENO, KURULUS_ID FROM M_BELGE_SORGU WHERE ID=?";
		$dataBelge = $db->prep_exec($sql, array($post['belgeId']));
	
		$return = $this->BelgeSorguOldYedekle($post['belgeId']);
		if(!$return){
			return false;
		}
	
		$sqlKur = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI FROM M_KURULUS
					  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.USER_ID = ? 
					UNION
					SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI FROM M_KURULUS
					  WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.USER_ID = ?
					  ";
	
		$dataKur = $db->prep_exec($sqlKur, array($dataBelge[0]['KURULUS_ID'],$dataBelge[0]['KURULUS_ID']));
	
		$sqlUp = "UPDATE M_BELGE_SORGU SET BELGELENDIRME_KURULUSU = ?, KURULUS_ADI = ? WHERE ID = ?";
		$return = $db->prep_exec_insert($sqlUp, array($dataKur[0]['KURULUS_ADI'],$dataKur[0]['KURULUS_ADI'],$post['belgeId']));
	
		if($return){
			return true;
		}else{
			return false;
		}
	}
	
	public function BelgeBelgeNoGuncelle($post){
		$db = JFactory::getOracleDBO ();
		
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		
		$newBelge = trim($post['noBelge']);
		$belge = explode('/', $newBelge);
		
		$sql = "SELECT BELGENO, KURULUS_ID, YETERLILIK_ID, AD, SOYAD FROM M_BELGE_SORGU WHERE ID=?";
		$dataBelge = $db->prep_exec($sql, array($post['belgeId']));
		
		$sqlYet = "SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID=?";
		$dataYet = $db->prep_exec($sqlYet, array($dataBelge[0]['YETERLILIK_ID']));
		
		$kurs = FormFactory::getKurulusValues($dataBelge[0]['KURULUS_ID']);
		
		$yetBelgeKod = str_replace('-','',$kurs['KURULUS_YETKILENDIRME_NUMARASI']).'/'.$dataYet[0]['YETERLILIK_KODU'];
		
		$sql = "SELECT * FROM M_BELGELENDIRME_BELGE_NO WHERE YETKOD = ? AND USER_ID=?";
		$data = $db->prep_exec($sql,array($yetBelgeKod,$dataBelge[0]['KURULUS_ID']));
		
		$sqlOnayBek = "SELECT * FROM M_BELGE_EDIT_BELGENO WHERE BELGE_ID = ? AND DURUM = 1";
		$dataOnayBek = $db->prep_exec($sqlOnayBek, array($post['belgeId']));
		
		$sqlOnaysiz = "SELECT * FROM M_BELGE_EDIT_BELGENO WHERE BELGE_ID = ? AND DURUM = 0";
		$dataOnaysiz = $db->prep_exec($sqlOnaysiz, array($post['belgeId']));
		
		if($dataOnayBek){
			$sqlDelete = "DELETE FROM M_BELGE_EDIT_BELGENO WHERE BELGE_ID = ? AND DURUM = 1";
			if(!$db->prep_exec_insert($sqlDelete, array($post['belgeId']))){
				return false;
			}
		}else if($dataOnaysiz){
			$sqlDelete = "DELETE FROM M_BELGE_EDIT_BELGENO WHERE BELGE_ID = ? AND DURUM = 0";
			if(!$db->prep_exec_insert($sqlDelete, array($post['belgeId']))){
				return false;
			}
		}
		
		//*********************************************************************************************//
		if($aut2 || $aut3){
			$sqlOnayli = "SELECT * FROM M_BELGE_EDIT_BELGENO WHERE BELGE_ID = ? AND DURUM=2";
			$dat = $db->prep_exec($sqlOnayli, array($post['belgeId']));
			
			if($dat){
				$sqlUp = "UPDATE M_BELGE_EDIT_BELGENO SET DURUM = -1 WHERE BELGE_ID = ? AND DURUM = 2";
				$db->prep_exec_insert($sqlUp, array($post['belgeId']));
			}
			
			$return = $this->BelgeSorguOldYedekle($post['belgeId']);
			if(!$return){
				return false;
			}
			
			if($data[0]['BELGENO'] <= (int)$belge[3]){
				$sonBelgeNo = (int)$belge[3]+1;
				$sqlUpBelgeNo = "UPDATE M_BELGELENDIRME_BELGE_NO SET BELGENO = ? WHERE YETKOD=? AND USER_ID=?";
				$db->prep_exec_insert($sqlUpBelgeNo, array($sonBelgeNo,$yetBelgeKod,$dataBelge[0]['KURULUS_ID']));
			}
			
			$sqlUp = "INSERT INTO M_BELGE_EDIT_BELGENO (BELGE_ID,BELGE_NO,DURUM,USER_ID, ONAY_TARIHI) VALUES(?,?,2,?,TO_DATE(SYSDATE))";
			$return = $db->prep_exec_insert($sqlUp, array($post['belgeId'],$newBelge,$user_id));
			
			if($return){
				$sqlUp = "UPDATE M_BELGE_SORGU SET BELGENO = ? WHERE ID = ?";
				$return = $db->prep_exec_insert($sqlUp, array($newBelge,$belgeId));
				if($return){
					return urlencode($newBelge);
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			if($data[0]['BELGENO'] <= (int)$belge[3]){
				$sonBelgeNo = (int)$belge[3]+1;
				$sqlUpBelgeNo = "UPDATE M_BELGELENDIRME_BELGE_NO SET BELGENO = ? WHERE YETKOD=? AND USER_ID=?";
				$db->prep_exec_insert($sqlUpBelgeNo, array($sonBelgeNo,$yetBelgeKod,$dataBelge[0]['KURULUS_ID']));
			}
			
			$sqlUp = "INSERT INTO M_BELGE_EDIT_BELGENO (BELGE_ID,BELGE_NO,DURUM) VALUES(?,?,1)";
			$return = $db->prep_exec_insert($sqlUp, array($post['belgeId'],$newBelge));
			
			if($return){
				
				//****** Mail Gönderimi **************************************************************//
				$message = $dataBelge[0]['BELGENO'].' belge numaralı '.$dataBelge[0]['AD'].' '.$dataBelge[0]['SOYAD'].' kişinin belge numarası değişiklik talebi oluşturuldu ve dosya sorumlusu onayına sunuldu.';
				$sqlGorevli = "SELECT * FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
				$gorevli = $_db->prep_exec($sqlGorevli, array($dataBelge[0]['KURULUS_ID']));
				
				$mysqlDB = &JFactory::getDBO();
				$mailGorevli = array('huseyin.toplu@myk.gov.tr','ktunc@myk.gov.tr');
				foreach($gorevli as $tow){
					$sqlMatbaa= "SELECT email FROM #__users as users
							WHERE tgUserId = ".$tow['TGUSERID'];
					$mysqlDB->setQuery($sqlMatbaa);
					$matbaaUser = $mysqlDB->loadObjectList();
					$mailGorevli[] = $matbaaUser[0]->email;
						
					FormFactory::sektorSorumlusunaNotificationGonder($message, 'index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($dataBelge[0]['BELGENO']), $tow['TGUSERID']);
				}
					
				$url = 'http://portal.myk.gov.tr/index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($dataBelge[0]['BELGENO']);;
					
				$baslik = 'Belge Numarası Güncelleme Talebi';
				$icerik = '<div style="widht:100%;font-size: 18px">';
				$icerik .= '<p>'.$message.' Talebe <a target="_blank" href="'.$url.'"><em>burdan</em></a> ulaşabilirsiniz.</p>';
				$icerik .= '</div>';
				
				$to = $mailGorevli;
				
				FormFactory::sentEmail($baslik,$icerik,$to,true);
				//****** Mail Gönderimi SON **************************************************************//
				
				return $dataBelge[0]['BELGENO'];
			}else{
				return false;
			}
		}
	}
	
	public function BelgeNoGuncelleOnay($post){
		$db = JFactory::getOracleDBO();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		
		$belgeId = $post['belgeId'];
		$durum = $post['durum'];
		
		if($durum == 2){
			$sqlOnayli = "SELECT * FROM M_BELGE_EDIT_BELGENO WHERE BELGE_ID = ? AND DURUM = 2";
			$dataOnayli = $db->prep_exec($sqlOnayli, array($belgeId));
			if($dataOnayli){
				$sqlUpOnayli = "UPDATE M_BELGE_EDIT_BELGENO SET DURUM = -1 WHERE BELGE_ID = ? AND DURUM = 2";
				if(!$db->prep_exec_insert($sqlUpOnayli, array($belgeId))){
					return false;
				}
			}
			
			$return = $this->BelgeSorguOldYedekle($post['belgeId']);
			if(!$return){
				return false;
			}
			
			$sqlUpOnaysiz = "UPDATE M_BELGE_EDIT_BELGENO SET DURUM = 2, USER_ID = ?, ONAY_TARIHI = TO_DATE(SYSDATE) WHERE BELGE_ID = ? AND DURUM = 1";
			if(!$db->prep_exec_insert($sqlUpOnaysiz, array($user_id,$belgeId))){
				return false;
			}
			
			$sqlOnayli = "SELECT * FROM M_BELGE_EDIT_BELGENO WHERE BELGE_ID = ? AND DURUM = 2";
			$dataOnayli = $db->prep_exec($sqlOnayli, array($belgeId));
			
			$sqlUp = "UPDATE M_BELGE_SORGU SET BELGENO = ? WHERE ID = ?";
			$return = $db->prep_exec_insert($sqlUp, array($dataOnayli[0]['BELGE_NO'],$belgeId));
			
			if($return){
				return urlencode($dataOnayli[0]['BELGE_NO']);
			}else{
				return false;
			}
		}else{
			$sqlOnaysiz = "SELECT * FROM M_BELGE_EDIT_BELGENO WHERE BELGE_ID = ? AND DURUM = 1";
			$dataOnaysiz = $db->prep_exec($sqlOnaysiz, array($belgeId));
			if($dataOnaysiz){
				$sqlUpOnaysiz = "UPDATE M_BELGE_EDIT_BELGENO SET DURUM = 0 WHERE BELGE_ID = ? AND DURUM = 1";
				if($db->prep_exec_insert($sqlUpOnaysiz, array($belgeId))){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}
	
	public function BelgeTarihGuncelle($post){
		$db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		
		$belgeTarih = $post['belgeDuzTarih'];
		
		//*****************************************************************************************************//
		
		$sql = "SELECT BELGENO, KURULUS_ID, YETERLILIK_ID, AD, SOYAD FROM M_BELGE_SORGU WHERE ID=?";
		$dataBelge = $db->prep_exec($sql, array($post['belgeId']));
		
		$sqlOnayBek = "SELECT * FROM M_BELGE_EDIT_BELGETARIH WHERE BELGE_ID = ? AND DURUM = 1";
		$dataOnayBek = $db->prep_exec($sqlOnayBek, array($post['belgeId']));
		
		$sqlOnaysiz = "SELECT * FROM M_BELGE_EDIT_BELGETARIH WHERE BELGE_ID = ? AND DURUM = 0";
		$dataOnaysiz = $db->prep_exec($sqlOnaysiz, array($post['belgeId']));
		
		if($dataOnayBek){
			$sqlDelete = "DELETE FROM M_BELGE_EDIT_BELGETARIH WHERE BELGE_ID = ? AND DURUM = 1";
			if(!$db->prep_exec_insert($sqlDelete, array($post['belgeId']))){
				return false;
			}
		}else if($dataOnaysiz){
			$sqlDelete = "DELETE FROM M_BELGE_EDIT_BELGETARIH WHERE BELGE_ID = ? AND DURUM = 0";
			if(!$db->prep_exec_insert($sqlDelete, array($post['belgeId']))){
				return false;
			}
		}
		
		if($aut2 || $aut3){
			$sqlOnayli = "SELECT * FROM M_BELGE_EDIT_BELGETARIH WHERE BELGE_ID = ? AND DURUM = 2";
			$dat = $db->prep_exec($sqlOnayli, array($post['belgeId']));
			
			if($dat){
				$sqlUp = "UPDATE M_BELGE_EDIT_BELGETARIH SET DURUM = -1 WHERE BELGE_ID =? AND DURUM = 2";
				$db->prep_exec_insert($sqlUp, array($post['belgeId']));
			}
			
			$return = $this->BelgeSorguOldYedekle($post['belgeId']);
			if(!$return){
				return false;
			}
			
			$sql = "SELECT MY.* FROM M_BELGE_SORGU MBS
                        JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID)
						WHERE MBS.ID=?";
			$adayBilgi = $db->prep_exec($sql,array($post['belgeId']));
				
			if(empty($adayBilgi[0]['GECERLILIK_SURESI'])){
				$gcSuresi = 5;
			}else{
				$gcSuresi = $adayBilgi[0]['GECERLILIK_SURESI'];
			}
				
			$date = strtotime("+$gcSuresi year",  strtotime(str_replace('/','-',$belgeTarih)));
			$date = date('d/m/Y',strtotime('-1 day',$date));
				
			$sqlUp = "UPDATE M_BELGE_SORGU SET BELGE_DUZENLEME_TARIHI = TO_DATE(?),GECERLILIK_TARIHI = TO_DATE(?) WHERE ID = ?";
			$return = $db->prep_exec_insert($sqlUp, array($belgeTarih,$date,$belgeId));
			
			if($return){
				$sqlUp = "INSERT INTO M_BELGE_EDIT_BELGETARIH (BELGE_ID,BELGE_TARIHI,DURUM,USER_ID, ONAY_TARIHI) VALUES(?,?,2,?,TO_DATE(SYSDATE))";
				$return = $db->prep_exec_insert($sqlUp, array($post['belgeId'],$belgeTarih,$user_id));
					
				if($return){
					return $dataBelge[0]['BELGENO'];
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			$sqlUp = "INSERT INTO M_BELGE_EDIT_BELGETARIH (BELGE_ID,BELGE_TARIHI,DURUM) VALUES(?,?,1)";
			$return = $db->prep_exec_insert($sqlUp, array($post['belgeId'],$belgeTarih));
			
			if($return){
				
				//****** Mail Gönderimi **************************************************************//
				$message = $dataBelge[0]['BELGENO'].' belge numaralı '.$dataBelge[0]['AD'].' '.$dataBelge[0]['SOYAD'].' kişinin belge geçerlilik tarihi değişiklik talebi oluşturuldu ve dosya sorumlusu onayına sunuldu.';
				$sqlGorevli = "SELECT * FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
				$gorevli = $_db->prep_exec($sqlGorevli, array($dataBelge[0]['KURULUS_ID']));
				
				$mysqlDB = &JFactory::getDBO();
				$mailGorevli = array('huseyin.toplu@myk.gov.tr','ktunc@myk.gov.tr');
				foreach($gorevli as $tow){
					$sqlMatbaa= "SELECT email FROM #__users as users
							WHERE tgUserId = ".$tow['TGUSERID'];
					$mysqlDB->setQuery($sqlMatbaa);
					$matbaaUser = $mysqlDB->loadObjectList();
					$mailGorevli[] = $matbaaUser[0]->email;
				
					FormFactory::sektorSorumlusunaNotificationGonder($message, 'index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($dataBelge[0]['BELGENO']), $tow['TGUSERID']);
				}
					
				$url = 'http://portal.myk.gov.tr/index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($dataBelge[0]['BELGENO']);;
					
				$baslik = 'Belge Geçerlilik Tarihi Güncelleme Talebi';
				$icerik = '<div style="widht:100%;font-size: 18px">';
				$icerik .= '<p>'.$message.' Talebe <a target="_blank" href="'.$url.'"><em>burdan</em></a> ulaşabilirsiniz.</p>';
				$icerik .= '</div>';
				
				$to = $mailGorevli;
				
				FormFactory::sentEmail($baslik,$icerik,$to,true);
				//****** Mail Gönderimi SON **************************************************************//
				
				return $dataBelge[0]['BELGENO'];
			}else{
				return false;
			}
		}
	}
	
	public function BelgeTarihiGuncelleOnay($post){
		$db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		
		$belgeId = $post['belgeId'];
		$durum = $post['durum'];
		
		if($durum == 2){
			$sqlOnayli = "SELECT * FROM M_BELGE_EDIT_BELGETARIH WHERE BELGE_ID = ? AND DURUM = 2";
			$dataOnayli = $db->prep_exec($sqlOnayli, array($belgeId));
			if($dataOnayli){
				$sqlUpOnayli = "UPDATE M_BELGE_EDIT_BELGETARIH SET DURUM = -1 WHERE BELGE_ID = ? AND DURUM = 2";
				if(!$db->prep_exec_insert($sqlUpOnayli, array($belgeId))){
					return false;
				}
			}
				
			$return = $this->BelgeSorguOldYedekle($post['belgeId']);
			if(!$return){
				return false;
			}
				
			$sqlUpOnaysiz = "UPDATE M_BELGE_EDIT_BELGETARIH SET DURUM = 2, USER_ID = ?, ONAY_TARIHI = TO_DATE(SYSDATE) WHERE BELGE_ID = ? AND DURUM = 1";
			if(!$db->prep_exec_insert($sqlUpOnaysiz, array($user_id,$belgeId))){
				return false;
			}
				
			$sqlOnayli = "SELECT * FROM M_BELGE_EDIT_BELGETARIH WHERE BELGE_ID = ? AND DURUM = 2";
			$dataOnayli = $db->prep_exec($sqlOnayli, array($belgeId));
			
			$sql = "SELECT MY.* FROM M_BELGE_SORGU MBS
                        JOIN M_YETERLILIK MY ON(MBS.YETERLILIK_ID = MY.YETERLILIK_ID) 
						WHERE MBS.ID=?";
			$adayBilgi = $db->prep_exec($sql,array($belgeId));
			
			if(empty($adayBilgi[0]['GECERLILIK_SURESI'])){
				$gcSuresi = 5;
			}else{
				$gcSuresi = $adayBilgi[0]['GECERLILIK_SURESI'];
			}
			
			$date = strtotime("+$gcSuresi year",  strtotime(str_replace('/','-',$dataOnayli[0]['BELGE_TARIHI'])));
			$date = date('d/m/Y',strtotime('-1 day',$date));
			
			$sqlUp = "UPDATE M_BELGE_SORGU SET BELGE_DUZENLEME_TARIHI = TO_DATE(?),GECERLILIK_TARIHI = TO_DATE(?) WHERE ID = ?";
			$return = $db->prep_exec_insert($sqlUp, array($dataOnayli[0]['BELGE_TARIHI'],$date,$belgeId));
				
			if($return){
				return true;
			}else{
				return false;
			}
		}else{
			$sqlOnaysiz = "SELECT * FROM M_BELGE_EDIT_BELGETARIH WHERE BELGE_ID = ? AND DURUM = 1";
			$dataOnaysiz = $db->prep_exec($sqlOnaysiz, array($belgeId));
			if($dataOnaysiz){
				$sqlUpOnaysiz = "UPDATE M_BELGE_EDIT_BELGETARIH SET DURUM = 0 WHERE BELGE_ID = ? AND DURUM = 1";
				if($db->prep_exec_insert($sqlUpOnaysiz, array($belgeId))){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}
	
	function BelgeDurumGuncelle($post){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT BELGENO FROM M_BELGE_SORGU WHERE ID=?";
		$dataBelge = $db->prep_exec($sql, array($post['belgeId']));
		
		$return = $this->BelgeSorguOldYedekle($post['belgeId']);
		if(!$return){
			return false;
		}
		
		$sqlUp = "UPDATE M_BELGE_SORGU SET BELGEDURUMU = ?, IPTAL_ACIKLAMA = ? WHERE ID = ?";
		$return = $db->prep_exec_insert($sqlUp, array($post['belgeDurumu'],$post['aciklama'],$post['belgeId']));
		
		if($return){
			return $dataBelge[0]['BELGENO'];
		}else{
			return false;
		}
	}
	
	function BelgeNoKontrol($post){
		$db = JFactory::getOracleDBO ();
		
		$belgeNo = $post['belgeNo'];
		
		$sql = "SELECT KURULUS_ID, YETERLILIK_ID FROM M_BELGE_SORGU WHERE ID=?";
		$dataBelge = $db->prep_exec($sql, array($post['belgeId']));
		
		$sql = "SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID =?";
		$yeterlilik = $db->prep_exec($sql, array($dataBelge[0]['YETERLILIK_ID']));
		
		$kurs = FormFactory::getKurulusValues($dataBelge[0]['KURULUS_ID']);
		
		//$yetBelgeKod = str_replace('-','',$kurs['KURULUS_YETKILENDIRME_NUMARASI']).'/'.$yeterlilik[0]['YETERLILIK_KODU'].'/'.$yeterlilik[0]['REVIZYON'];
		$yetBelgeKod = str_replace('-','',$kurs['KURULUS_YETKILENDIRME_NUMARASI']).'/'.$yeterlilik[0]['YETERLILIK_KODU'].'/'.$yeterlilik[0]['REVIZYON'];
		
		$belge = explode('/', $belgeNo);
		
		if(count($belge) != 4){
			return false;
		}
		
		$newYetBelgeKod = $belge[0].'/'.$belge[1].'/'.$belge[2];
		
		if($yetBelgeKod != $newYetBelgeKod){
			return false;
		}
		
		if(empty($belge[3])){
			return false;
		}else{
			return true;
		}
	}
	
	function BelgeTekrarBas($post,$files){
		$db = JFactory::getOracleDBO ();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		
		$belgeId = $post['belgeId'];
		$basimNeden = $post['basimNeden'];
		$dekont = array_key_exists('dekont', $files)?$files['dekont']:false;
		$dekontNo = $post['dekontNo'];
		$tutar = $post['tutar'];
		$dekontTarih = $post['tarih'];
		
		$sql = "SELECT * FROM M_BELGE_SORGU WHERE ID=?";
		$dataBelge = $db->prep_exec($sql, array($post['belgeId']));
		
		
			$BasimId = $db->getNextVal('SEQ_BELGE_TEKRAR_BASIM');
			$DekontId = 0;
			
			if($dekont){
				//****************************** DEKONT Kaydet ***************************************//
				$directory = EK_FOLDER.'sinavBelgeTekrarDekont/'.$belgeId;
				if (!file_exists($directory)){
					mkdir($directory, 0700,true);
				}
					
				$dekSay = 0;
				for($i=0;$i<count($dekont['name']);$i++){
					if($dekont["error"][$i] != 0 || !($dekont["type"][$i] == 'image/jpg'
							|| $dekont["type"][$i] == 'image/jpeg'
							|| $dekont["type"][$i] == 'image/png'
							|| $dekont["type"][$i] == 'image/x-png'
							|| $dekont["type"][$i] == 'image/pjpeg'
							|| $dekont["type"][$i] == 'application/pdf') || empty($dekontNo[$i]) || empty($tutar[$i])){
						return array('durum'=>false,'belgeNo'=>$dataBelge[0]['BELGENO'],'message'=>'Eklenen dekont formatı desteklenmemektedir. (formatlar: jpg, png, pdf)');
					}
					$dekSay++;
				}
					
				$DekontId = $db->getNextVal('SEQ_BELGE_TEKRAR_BAS_DEK');
				$dekSay = 0;
				for($i=0;$i<count($dekont['name']);$i++){
						
					$fileName = explode('.',$dekont['name'][$i]);
						
					$name = $DekontId.'_'.$i.'.'.$fileName[count($fileName)-1];
					$path = $directory.'/'.$name;
						
					if(move_uploaded_file($dekont['tmp_name'][$i], $path)){
						$sqlDekont = "INSERT INTO M_BELGELENDIRME_TEKRAR_BAS_DEK (ID,BELGE_ID,DEKONT,DEKONTNO,TUTAR,TARIH)
						VALUES(?,?,?,?,?,?)";
						$db->prep_exec_insert($sqlDekont, array($DekontId,$belgeId,$name,$dekontNo[$i],$tutar[$i],$dekontTarih[$i]));
					}else{
						return array('durum'=>false,'belgeNo'=>$dataBelge[0]['BELGENO'],'message'=>'Bir hata meydana geldi. Lütfen tekrar deneyin.');
					}
					$dekSay++;
				}
				//****************************** DEKONT Kaydet SON ***************************************//				
			}
			
			$sql = "INSERT INTO M_BELGE_TEKRAR_BASIM (BASIM_ID,BELGE_ID,DEKONT_ID,BASIM_NEDENI_ID,USER_ID,DURUM) 
					VALUES(?,?,?,?,?,?)";
			
			$result = $db->prep_exec_insert($sql, array($BasimId,$belgeId,$DekontId,$basimNeden,$user_id,0));
			
			if($result){
// 				$this->MatbaaGonder($BasimId, $dataBelge[0]['BELGENO']);
				$message = $dataBelge[0]['BELGENO'].' belge numaralı '.$dataBelge[0]['AD'].' '.$dataBelge[0]['SOYAD'].' kişinin belgesi basım için dosya sorumlusunun bilgisine sunuldu.';
				// Mail Gönderimi
				$sqlGorevli = "SELECT * FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
				$gorevli = $_db->prep_exec($sqlGorevli, array($dataBelge[0]['KURULUS_ID']));
					
				$mysqlDB = &JFactory::getDBO();
				$mailGorevli = array('huseyin.toplu@myk.gov.tr','kaan@myk.gov.tr');
				foreach($gorevli as $tow){
					$sqlMatbaa= "SELECT email FROM #__users as users
							WHERE tgUserId = ".$tow['TGUSERID'];
					$mysqlDB->setQuery($sqlMatbaa);
					$matbaaUser = $mysqlDB->loadObjectList();
					$mailGorevli[] = $matbaaUser[0]->email;
						
					FormFactory::sektorSorumlusunaNotificationGonder($message, 'index.php?option=com_belgelendirme&view=tekrar_basim', $tow['TGUSERID']);
				}
				
				$baslik = 'Belge Tekrar Basım Başvurusu Yapıldı.';
				$icerik = $message.'  http://portal.myk.gov.tr/index.php?option=com_belgelendirme&view=tekrar_basim';
				$to = $mailGorevli;
					
				FormFactory::sentEmail($baslik,$icerik,$to);
				// Mail Gönderimi SON
				return array('durum'=>true,'belgeNo'=>$dataBelge[0]['BELGENO'],'message'=>$message);
			}else{
				return array('durum'=>false,'belgeNo'=>$dataBelge[0]['BELGENO'],'message'=>'Bir hata meydana geldi. Lütfen tekrar deneyin.');
			}
	}
	
	private function MatbaaGonder($basimId,$belgeNo){
		$db = JFactory::getOracleDBO ();
		 
		$sql = "SELECT * FROM M_BELGE_SORGU WHERE BELGENO=?";
		$dataBelge = $db->prep_exec($sql, array($belgeNo));
		
		$sqlMatbaa = "UPDATE M_BELGE_TEKRAR_BASIM SET DURUM = ?,ISTEK_TARIHI=? WHERE BASIM_ID = ?";
		$db->prep_exec_insert($sqlMatbaa, array(1, date('d/m/Y'),$basimId));
		
		$aciklamaText = $dataBelge[0]['BELGENO'].' belge numaralı '.$dataBelge[0]['AD'].' '.$dataBelge[0]['SOYAD'].' kişinin belgesi tekrar basım için matbaaya iletildi.';
		FormFactory::sektorSorumlusunaNotificationGonder($aciklamaText, 'index.php?option=com_matbaa&view=tekrar_basim&layout=basilacak', 178);
		 
		/********************************* Matbaaya Mail Bildirimi ********************************************************/
		$mysqlDB = &JFactory::getDBO();
		$sqlMatbaa= "SELECT email FROM #__users WHERE tgUserId = 178";
		$mysqlDB->setQuery($sqlMatbaa);
		$matbaaUser = $mysqlDB->loadResult();
			
		$sqlGorevli = "SELECT * FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
		$gorevli = $db->prep_exec($sqlGorevli, array($dataBelge[0]['KURULUS_ID']));
			
		$mailGorevli = array($matbaaUser,'mordukaya@myk.gov.tr','ktunc@myk.gov.tr');
		foreach($gorevli as $tow){
			$sqlMatbaa= "SELECT email FROM #__users as users
					WHERE tgUserId = ".$tow['TGUSERID'];
			$mysqlDB->setQuery($sqlMatbaa);
			$matbaaUser = $mysqlDB->loadObjectList();
			$mailGorevli[] = $matbaaUser[0]->email;
		}
			
		$to = $mailGorevli;
		$baslik = 'Tekrar Basım Başvurusu Yapıldı.';
		$icerik = $aciklamaText;
		FormFactory::sentEmail($baslik,$icerik,$to);
		/********************************* Matbaaya Mail Bildirimi SON ********************************************************/
		
		$directory = EK_FOLDER.'sinavBelgeTekrarQRcode/'.$basimId;
		if (!file_exists($directory)){
			mkdir($directory, 0700,true);
		}
		 
		$zip = new ZipArchive();
		$zip->open($directory.'/'.$basimId.'.zip', ZipArchive::CREATE);
		$belgeUrl = 'http://portal.myk.gov.tr/index.php?option=com_belgelendirme&view=belge_sorgula&layout=belgeno_sorgu&belgeno='.$belgeNo;
		$QRAD = trim(str_replace("/","#",$belgeNo));
		$path = $directory.'/'.$QRAD.'.png';
		QRcode::png($belgeUrl,$path,QR_ECLEVEL_H,3,1);
		$zip->addFile($path,$QRAD.'.png');
		$zip->close();
		
		return true;
	}
	
	function getAdayBelgeExcel($belge){
		$db = JFactory::getOracleDBO ();
	
		$BelgeNo = urldecode($belge);
		
		$sqlBilgi = "SELECT * FROM M_BELGE_SORGU WHERE BELGENO = ?";
		$BelgeBilgi = $db->prep_exec($sqlBilgi, array($BelgeNo));
	
		// Yeterlilik
		$sqlYet = "SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
		$dataYet = $db->prep_exec($sqlYet, array($BelgeBilgi[0]['YETERLILIK_ID']));
	
		// Kuruluş Bilgi
		$sqlKur = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI,
						M_KURULUS.LOGO, MBKS.MYK_MARKASI, MBKS.TURKAK_MARKASI,
						M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI, MBKS.AKREDITASYON_NO, M_KURULUS_EDIT.KURULUS_WEB
						FROM M_KURULUS
						JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
						JOIN M_BELGELENDIRME_KURULUS_SABLON MBKS ON M_KURULUS.USER_ID = MBKS.KURULUS_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.USER_ID = ?
					UNION
					SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI, M_KURULUS.LOGO, MBKS.MYK_MARKASI,
						MBKS.TURKAK_MARKASI, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI, MBKS.AKREDITASYON_NO,
						M_KURULUS.KURULUS_WEB
						FROM M_KURULUS
						JOIN M_BELGELENDIRME_KURULUS_SABLON MBKS ON M_KURULUS.USER_ID = MBKS.KURULUS_ID
					  	WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.USER_ID = ?
					  	ORDER BY KURULUS_ADI ASC";
	
		$KurBilgi = $db->prep_exec($sqlKur, array($BelgeBilgi[0]['KURULUS_ID'],$BelgeBilgi[0]['KURULUS_ID']));
	
		// Eski belge numarası var mi?
		$sqlEdit = "SELECT * FROM M_BELGE_SORGU_OLD
				WHERE ID = ? AND BELGENO != ? AND ROWNUM <= 1
				ORDER BY DEG_TARIH ASC";
		$eskiBelge = $db->prep_exec($sqlEdit, array($BelgeBilgi[0]['ID'],$BelgeBilgi[0]['BELGENO']));
	
		// Başarılı Birimleri
		if($eskiBelge){
			$belgeNo = $eskiBelge[0]['BELGENO'];
		}else{
			$belgeNo = $BelgeBilgi[0]['BELGENO'];
		}
	
		$sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE BELGE_NO = ?";
	
		$data2 = $db->prep_exec($sql, array($belgeNo));
		$AdayBirims = array();
		
		if($data2){
			
			if($dataYet[0]['YENI_MI']==1){
				$sqlBirim="SELECT * FROM M_BELGELENDIRME_BASARILI_BIRIM
					JOIN M_BIRIM USING(BIRIM_ID) WHERE HAK_KAZANAN_ID = ? ORDER BY BIRIM_KODU";
			
				foreach($data2 as $cow){
					$AdayBirims[$BelgeBilgi[0]['ID']] = $db->prep_exec($sqlBirim, array($cow['ID']));
				}
			}else{
				$sqlBirim="SELECT M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_NO AS BIRIM_NO, M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, M_YETERLILIK.YETERLILIK_KODU FROM M_BELGELENDIRME_BASARILI_BIRIM
					JOIN M_YETERLILIK_ALT_BIRIM ON M_BELGELENDIRME_BASARILI_BIRIM.BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
					JOIN M_YETERLILIK ON M_YETERLILIK_ALT_BIRIM.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
					WHERE HAK_KAZANAN_ID = ? ORDER BY BIRIM_NO";
			
				foreach($data2 as $cow){
					$birims = $db->prep_exec($sqlBirim, array($cow['ID']));
					for($t = 0; $t<count($birims); $t++){
						$birims[$t]['BIRIM_KODU'] = $birims[$t]['YETERLILIK_KODU'].'/'.$birims[$t]['BIRIM_NO'];
					}
					$AdayBirims[$BelgeBilgi[0]['ID']] = $birims;
				}
			}
		}else{
            $eskiSinavBirim = array();
			$sql = "SELECT BIRIM_ID FROM M_ESKI_BELGE_BIRIM WHERE BELGE_ID = ? AND DURUM = 2";
			$pat = $db->prep_exec_array($sql, array($BelgeBilgi[0]['ID']));
			$patAr = explode('#', $pat[0]);
			foreach($patAr as $row){
				if(!empty($row)){
					$eskiSinavBirim[] .= $row;
				}
			}
				
			if($dataYet[0]['YENI_MI'] == 1){
				$sqlBirim = "SELECT MB.BIRIM_ID, MB.BIRIM_KODU, MB.BIRIM_ADI FROM M_BIRIM MB
						JOIN M_YETERLILIK_BIRIM MYB ON (MB.BIRIM_ID = MYB.BIRIM_ID)
						WHERE MYB.YETERLILIK_ID = ? AND MB.BIRIM_ID IN (".implode(',', $eskiSinavBirim).")
						ORDER BY MB.BIRIM_KODU";
				$birims = $db->prep_exec($sqlBirim, array($BelgeBilgi[0]['YETERLILIK_ID']));
				$AdayBirims[$BelgeBilgi[0]['ID']] = $birims;
			
			}else{
				$sqlBirim = "SELECT MB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, MB.YETERLILIK_ALT_BIRIM_ID AS BIRIM_ID,
						MB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_NO
						FROM M_YETERLILIK_ALT_BIRIM MB
						WHERE MB.YETERLILIK_ID = ? AND MB.YETERLILIK_ALT_BIRIM_ID IN(".implode(',', $eskiSinavBirim).")
						ORDER BY MB.YETERLILIK_ALT_BIRIM_NO ASC";
				$birims = $db->prep_exec($sqlBirim, array($BelgeBilgi[0]['YETERLILIK_ID']));
			
				foreach($birims as $key=>$row){
					$birims[$key]['BIRIM_KODU'] = $dataYet[0]['YETERLILIK_KODU'].'/'.$row['BIRIM_NO'];
				}
				
				$AdayBirims[$BelgeBilgi[0]['ID']] = $birims;
			}
		}
	
		return array('BelgeBilgi'=>$BelgeBilgi,'BasariliBirim'=>$AdayBirims,'Yeterlilik'=>$dataYet[0],'KurBilgi'=>$KurBilgi[0]);
	}
	
	public function getBasimTalep(){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT *  
				FROM M_BELGE_TEKRAR_BASIM BTB 
				INNER JOIN M_BELGE_SORGU BS ON BTB.BELGE_ID = BS.ID 
				WHERE BTB.DURUM = 0 ORDER BY BTB.BASIM_ID ASC";
		
		return $db->prep_exec($sql, array());
	}
	
	public function getTekrarBasimBirim(){
		
		$sql = "SELECT *
				FROM M_BELGE_TEKRAR_BASIM BTB
				INNER JOIN M_BELGE_SORGU BS ON BTB.BELGE_ID = BS.ID
				LEFT JOIN M_BELGELENDIRME_TEKRAR_BAS_DEK BTBD ON BTB.DEKONT_ID = BTBD.ID";
	}
	
	public function TekrarBasimBilgi($post){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT *  
				FROM M_BELGE_TEKRAR_BASIM BTB 
				INNER JOIN M_BELGE_SORGU BS ON BTB.BELGE_ID = BS.ID 
				INNER JOIN M_YETERLILIK ON BS.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
				INNER JOIN PM_TEKRAR_BASIM_NEDENI PTBN ON BTB.BASIM_NEDENI_ID = PTBN.BASIM_NEDENI_ID
				WHERE BASIM_ID = ?";
		
		$BasimBilgi = $db->prep_exec($sql, array($post['BasimId']));
		
		$sqlDek = "SELECT * 
				FROM M_BELGELENDIRME_TEKRAR_BAS_DEK BTBD  
				INNER JOIN M_BELGE_TEKRAR_BASIM BTB ON BTB.DEKONT_ID = BTBD.ID 
				WHERE BTB.BASIM_ID = ?";
		$DekontBilgi = $db->prep_exec($sqlDek, array($post['BasimId']));
		
		return array('BasimBilgi'=>$BasimBilgi[0], 'DekontBilgi'=>$DekontBilgi);
	}
	
	public function BelgeBasimaGonder($post){
		$db = JFactory::getOracleDBO ();
		
		$sqlBelge = "SELECT * FROM M_BELGE_TEKRAR_BASIM 
				JOIN M_BELGE_SORGU ON M_BELGE_TEKRAR_BASIM.BELGE_ID = M_BELGE_SORGU.ID 
				WHERE M_BELGE_TEKRAR_BASIM.BASIM_ID = ?";
		$dataBelge = $db->prep_exec($sqlBelge, array($post['BasimId']));
		
		$sqlUp = "UPDATE M_BELGE_TEKRAR_BASIM SET DURUM = 1 WHERE BASIM_ID = ?";
		$dataUp = $db->prep_exec_insert($sqlUp, array($post['BasimId']));
		
		if($dataUp){
			return $this->MatbaaGonder($post['BasimId'], $dataBelge[0]['BELGENO']);
		}else{
			return false;
		}
	}
	
	public function BelgeBasimIptal($post){
		$db = JFactory::getOracleDBO ();
	
		$sqlUp = "UPDATE M_BELGE_TEKRAR_BASIM SET DURUM = -1 WHERE BASIM_ID = ?";
		$dataUp = $db->prep_exec_insert($sqlUp, array($post['BasimId']));
	
		if($dataUp){
			return true;
		}else{
			return false;
		}
	}
	
	public function BasimdaBelgeVarMi($post){
		$db = JFactory::getOracleDBO ();
		
		$sqlBelge = "SELECT * FROM M_BELGE_TEKRAR_BASIM 
				JOIN M_BELGE_SORGU ON M_BELGE_TEKRAR_BASIM.BELGE_ID = M_BELGE_SORGU.ID 
				WHERE M_BELGE_SORGU.BELGENO = ? AND (M_BELGE_TEKRAR_BASIM.DURUM = 0 OR M_BELGE_TEKRAR_BASIM.DURUM = 1 OR M_BELGE_TEKRAR_BASIM.DURUM = 2)";
		$dataBelge = $db->prep_exec($sqlBelge, array($post['belgeNo']));
		
		if($dataBelge){
			return true;
		}else{
			return false;
		}
	}
	
	public function belgeNoBilgi($belgeNo,$userId = null){
		$_db = & JFactory::getOracleDBO();
	
		$sqlSor = '';
		if($userId){
			$sqlSor = " AND KURULUS_ID = ".$userId;
		}
		
		$sql = "SELECT * FROM M_BELGE_SORGU WHERE BELGENO = ?".$sqlSor;
	
		$data = $_db->prep_exec($sql, array($belgeNo));
	
		if($data){
			$sqlKur = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI,
					 M_KURULUS_EDIT.LOGO, M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKOD, M_BELGELENDIRME_KURULUS_SABLON.*
					FROM M_KURULUS
					  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
					  JOIN M_BELGELENDIRME_KURULUS_SABLON ON M_KURULUS.USER_ID = M_BELGELENDIRME_KURULUS_SABLON.KURULUS_ID
					  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.USER_ID = ?
					UNION
					SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI, M_KURULUS.LOGO, 
					M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI AS YBKOD, M_BELGELENDIRME_KURULUS_SABLON.* 
					FROM M_KURULUS
					JOIN M_BELGELENDIRME_KURULUS_SABLON ON M_KURULUS.USER_ID = M_BELGELENDIRME_KURULUS_SABLON.KURULUS_ID
					  WHERE M_KURULUS.USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND M_KURULUS.USER_ID = ?
					  ";
			$dataKur = $_db->prep_exec($sqlKur, array($data[0]['KURULUS_ID'],$data[0]['KURULUS_ID']));
				
			$sqlYet = "SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
			$dataYet = $_db->prep_exec($sqlYet, array($data[0]['YETERLILIK_ID']));
				
			return array('belgeBilgi'=>$data[0],'kurBilgi'=>$dataKur[0],'yetBilgi'=>$dataYet[0]);
		}else{
			return false;
		}
	}
	
	function BelgeBasariliBirim($post){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_BELGE_SORGU WHERE ID=?";
		$BelgeBilgi = $db->prep_exec($sql, array($post['belgeId']));
		
		// Eski belge numarası var mi?
		$sqlEdit = "SELECT * FROM M_BELGE_SORGU_OLD
				WHERE ID = ? AND BELGENO != ? AND ROWNUM <= 1
				ORDER BY DEG_TARIH ASC";
		$eskiBelge = $db->prep_exec($sqlEdit, array($post['belgeId'],$BelgeBilgi[0]['BELGENO']));
		
		// Başarılı Birimleri
		if($eskiBelge){
			$belgeNo = $eskiBelge[0]['BELGENO'];
		}else{
			$belgeNo = $BelgeBilgi[0]['BELGENO'];
		}
		
		$sql = "SELECT * FROM M_BELGELENDIRME_HAK_KAZANANLAR WHERE BELGE_NO = ?";
		
		$data2 = $db->prep_exec($sql, array($belgeNo));
		
		if($data2){
			$AdayBirims = array();
			
			$sqlYet = "SELECT YENI_MI FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
			$dataYet = $db->prep_exec($sqlYet, array($data2[0]['YETERLILIK_ID']));
			
			if($dataYet[0]['YENI_MI']==1){
				$sqlBirim="SELECT * FROM M_BELGELENDIRME_BASARILI_BIRIM
					JOIN M_BIRIM USING(BIRIM_ID) WHERE HAK_KAZANAN_ID = ? ORDER BY BIRIM_KODU";
			
				foreach($data2 as $cow){
					$AdayBirims[$BelgeBilgi[0]['ID']] = $db->prep_exec($sqlBirim, array($cow['ID']));
				}
			}else{
				$sqlBirim="SELECT M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_NO AS BIRIM_NO, M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, M_YETERLILIK.YETERLILIK_KODU FROM M_BELGELENDIRME_BASARILI_BIRIM
					JOIN M_YETERLILIK_ALT_BIRIM ON M_BELGELENDIRME_BASARILI_BIRIM.BIRIM_ID = M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID
					JOIN M_YETERLILIK ON M_YETERLILIK_ALT_BIRIM.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID
					WHERE HAK_KAZANAN_ID = ? ORDER BY BIRIM_NO";
			
				foreach($data2 as $cow){
					$birims = $db->prep_exec($sqlBirim, array($cow['ID']));
					for($t = 0; $t<count($birims); $t++){
						$birims[$t]['BIRIM_KODU'] = $birims[$t]['YETERLILIK_KODU'].'/'.$birims[$t]['BIRIM_NO'];
					}
					$AdayBirims[$BelgeBilgi[0]['ID']] = $birims;
				}
			}
			
			// SON
			return array("eksiMi"=>0,"birims"=>$AdayBirims);
		}else{
			$sqlOnayli = "SELECT BIRIM_ID FROM M_ESKI_BELGE_BIRIM WHERE BELGE_ID = ? AND DURUM = 2";
			$dataOnayli = $db->prep_exec($sqlOnayli, array($post['belgeId']));
			
			$sqlOnayBek = "SELECT BIRIM_ID FROM M_ESKI_BELGE_BIRIM WHERE BELGE_ID = ? AND DURUM = 1";
			$dataOnayBek = $db->prep_exec($sqlOnayBek, array($post['belgeId']));
			
			$sqlOnaysiz = "SELECT BIRIM_ID FROM M_ESKI_BELGE_BIRIM WHERE BELGE_ID = ? AND DURUM = 0";
			$dataOnaysiz = $db->prep_exec($sqlOnaysiz, array($post['belgeId']));
			
			$eskiSinavBirim = array();
			$onay = -1;
			if($dataOnaysiz){
				$eskiSinavBirim = explode('#', $dataOnaysiz[0]['BIRIM_ID']);
				$onay = 0;
			}else if($dataOnayBek){
				$eskiSinavBirim = explode('#', $dataOnayBek[0]['BIRIM_ID']);
				$onay = 1;
			}else if($dataOnayli){
				$eskiSinavBirim = explode('#', $dataOnayli[0]['BIRIM_ID']);
				$onay = 2;
			}
			
			$sqlYet = "SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
			$dataYet = $db->prep_exec($sqlYet, array($BelgeBilgi[0]['YETERLILIK_ID']));
			
			if($dataYet[0]['YENI_MI'] == 1){
				$sqlBirim = "SELECT MB.BIRIM_ID, MB.BIRIM_KODU, MB.BIRIM_ADI FROM M_BIRIM MB
						JOIN M_YETERLILIK_BIRIM MYB ON (MB.BIRIM_ID = MYB.BIRIM_ID)
						WHERE MYB.YETERLILIK_ID = ?
						ORDER BY MB.BIRIM_KODU";
				$birims = $db->prep_exec($sqlBirim, array($BelgeBilgi[0]['YETERLILIK_ID']));
			
			}else{
				$sqlBirim = "SELECT MB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, MB.YETERLILIK_ALT_BIRIM_ID AS BIRIM_ID,
						MB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_NO
						FROM M_YETERLILIK_ALT_BIRIM MB
						WHERE MB.YETERLILIK_ID = ?
						ORDER BY MB.YETERLILIK_ALT_BIRIM_NO ASC";
				$birims = $db->prep_exec($sqlBirim, array($BelgeBilgi[0]['YETERLILIK_ID']));
			
				foreach($birims as $key=>$row){
					$birims[$key]['BIRIM_KODU'] = $dataYet[0]['YETERLILIK_KODU'].'/'.$row['BIRIM_NO'];
				}
			}
			
			// ESKİ
// 			$sql = "SELECT BIRIM_ID FROM M_ESKI_BELGE_BIRIM WHERE BELGE_ID = ?";
// 			$eskiSinavBirim = $db->prep_exec_array($sql, array($post['belgeId']));
			
// 			$sqlYet = "SELECT * FROM M_YETERLILIK WHERE YETERLILIK_ID = ?";
// 			$dataYet = $db->prep_exec($sqlYet, array($BelgeBilgi[0]['YETERLILIK_ID']));
			
// 			if($dataYet[0]['YENI_MI'] == 1){
// 				$sqlBirim = "SELECT MB.BIRIM_ID, MB.BIRIM_KODU, MB.BIRIM_ADI FROM M_BIRIM MB
// 						JOIN M_YETERLILIK_BIRIM MYB ON (MB.BIRIM_ID = MYB.BIRIM_ID) 
// 						WHERE MYB.YETERLILIK_ID = ? 
// 						ORDER BY MB.BIRIM_KODU";
// 				$birims = $db->prep_exec($sqlBirim, array($BelgeBilgi[0]['YETERLILIK_ID']));
				
// 			}else{
// 				$sqlBirim = "SELECT MB.YETERLILIK_ALT_BIRIM_ADI AS BIRIM_ADI, MB.YETERLILIK_ALT_BIRIM_ID AS BIRIM_ID, 
// 						MB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_NO 
// 						FROM M_YETERLILIK_ALT_BIRIM MB
// 						WHERE MB.YETERLILIK_ID = ? 
// 						ORDER BY MB.YETERLILIK_ALT_BIRIM_NO ASC";
// 				$birims = $db->prep_exec($sqlBirim, array($BelgeBilgi[0]['YETERLILIK_ID']));
				
// 				foreach($birims as $key=>$row){
// 					$birims[$key]['BIRIM_KODU'] = $dataYet[0]['YETERLILIK_KODU'].'/'.$row['BIRIM_NO'];
// 				}
// 			}
			
			return array("eskiMi"=>1,"yet"=>$dataYet[0],"birims"=>$birims,"kayitliBirim"=>$eskiSinavBirim, "onay"=>$onay);
		}
		
	}
	
	function BelgeBasimdaMi($belgeNo){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT ID FROM M_BELGE_SORGU WHERE BELGENO=?";
		$BelgeBilgi = $db->prep_exec($sql, array($belgeNo));
		
		$sql = "SELECT * FROM M_BELGE_TEKRAR_BASIM 
				WHERE BELGE_ID = ? AND (DURUM != -1 OR DURUM != 3)";
		$data = $db->prep_exec($sql, array($BelgeBilgi[0]['ID']));
		
		if($data){
			return true;
		}else{
			return false;
		}
	}
	
	function EskiBelgeBirimKaydet($post){
		$db = & JFactory::getOracleDBO();
		
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		$group_id2 = MS_SEKTOR_SORUMLUSU_GROUP_ID;
		$group_id3 = YET_SEKTOR_SORUMLUSU_GROUP_ID;
		$aut2 = FormFactory::checkAuthorization ($user, $group_id2);
		$aut3 = FormFactory::checkAuthorization ($user, $group_id3);
		
		$belgeId = $post['belgeId'];
		$birim = $post['birim'];
		
		$sqlOnaysiz = "SELECT * FROM M_ESKI_BELGE_BIRIM WHERE BELGE_ID = ? AND (DURUM = 0 OR DURUM = 1)";
		$dataOnaysiz = $db->prep_exec($sqlOnaysiz, array($belgeId));
		
		if($dataOnaysiz){
			$sqlDelete = "DELETE FROM M_ESKI_BELGE_BIRIM WHERE BELGE_ID = ? AND (DURUM = 0 OR DURUM = 1)";
			$db->prep_exec_insert($sqlDelete, array($belgeId));
		}
		
		$dataInsert = '';
		foreach($birim as $row){
			$dataInsert .= $row.'#';
		}
		
		$sql = "SELECT * FROM M_BELGE_SORGU WHERE ID = ?";
		$data = $db->prep_exec($sql, array($belgeId));
		
		if($aut2 || $aut3){
			$sqlOnayli = "SELECT * FROM M_ESKI_BELGE_BIRIM WHERE BELGE_ID = ? AND DURUM = 2";
			$dat = $db->prep_exec($sqlOnayli, array($belgeId));
			
			if($dat){
				$sqlUp = "UPDATE M_ESKI_BELGE_BIRIM SET DURUM = -1 WHERE BELGE_ID = ? AND DURUM = 2";
				$db->prep_exec_insert($sqlUp, array($belgeId));
			}
			
			$sqlInsert = "INSERT INTO M_ESKI_BELGE_BIRIM (BELGE_ID,BIRIM_ID,DURUM,USER_ID, ONAY_TARIHI) VALUES(?,?,2,?,TO_DATE(SYSDATE))";
			$db->prep_exec_insert($sqlInsert, array($belgeId,$dataInsert,$user_id));
		}else{
			$sqlInsert = "INSERT INTO M_ESKI_BELGE_BIRIM (BELGE_ID,BIRIM_ID,DURUM) VALUES(?,?,1)";
			$db->prep_exec_insert($sqlInsert, array($belgeId,$dataInsert));
			
			//****** Mail Gönderimi **************************************************************// 
			$message = $data[0]['BELGENO'].' belge numaralı '.$data[0]['AD'].' '.$data[0]['SOYAD'].' kişinin belgesindeki başarılı birimler için değişiklik talebi oluşturuldu ve dosya sorumlusu onayına sunuldu.';
			$sqlGorevli = "SELECT * FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
			$gorevli = $_db->prep_exec($sqlGorevli, array($data[0]['KURULUS_ID']));
				
			$mysqlDB = &JFactory::getDBO();
			$mailGorevli = array('huseyin.toplu@myk.gov.tr','ktunc@myk.gov.tr');
			foreach($gorevli as $tow){
				$sqlMatbaa= "SELECT email FROM #__users as users
							WHERE tgUserId = ".$tow['TGUSERID'];
				$mysqlDB->setQuery($sqlMatbaa);
				$matbaaUser = $mysqlDB->loadObjectList();
				$mailGorevli[] = $matbaaUser[0]->email;
			
				FormFactory::sektorSorumlusunaNotificationGonder($message, 'index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($dat[0]['BELGENO']), $tow['TGUSERID']);
			}
			
			$url = 'http://portal.myk.gov.tr/index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='.urlencode($dat[0]['BELGENO']);;
			
			$baslik = 'Belge İçin Birim Güncelleme Talebi';
			$icerik = '<div style="widht:100%;font-size: 18px">';
			$icerik .= '<p>'.$message.' Talebe <a target="_blank" href="'.$url.'"><em>burdan</em></a> ulaşabilirsiniz.</p>';
			$icerik .= '</div>';

			$to = $mailGorevli;
				
			FormFactory::sentEmail($baslik,$icerik,$to,true);
			//****** Mail Gönderimi SON **************************************************************//
		}
		
		
		
		return $data[0]['BELGENO'];
	}
	
	function BelgeBasariliBirimOnayla($post){
		$db = & JFactory::getOracleDBO();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
	
		$belgeId = $post['belgeId'];
		$durum = $post['durum'];
	
		if($durum == 2){
			$sqlOnayli = "SELECT BIRIM_ID FROM M_ESKI_BELGE_BIRIM WHERE BELGE_ID = ? AND DURUM = 2";
			$dataOnayli = $db->prep_exec($sqlOnayli, array($post['belgeId']));
			if($dataOnayli){
				$sqlUpOnayli = "UPDATE M_ESKI_BELGE_BIRIM SET DURUM = -1 WHERE BELGE_ID = ? AND DURUM = 2";
				if(!$db->prep_exec_insert($sqlUpOnayli,array($belgeId))){
					return false;
				}
			}
			
			$sqlUpOnaysiz = "UPDATE M_ESKI_BELGE_BIRIM SET DURUM = 2, USER_ID = ?, ONAY_TARIHI = TO_DATE(SYSDATE) WHERE BELGE_ID = ? AND DURUM = 1";
			if($db->prep_exec_insert($sqlUpOnaysiz,array($user_id,$belgeId))){
				return true;
			}else{
				return false;
			}
		}else{
			$sqlOnayli = "SELECT BIRIM_ID FROM M_ESKI_BELGE_BIRIM WHERE BELGE_ID = ? AND DURUM = 1";
			$dataOnayli = $db->prep_exec($sqlOnayli, array($post['belgeId']));
			if($dataOnayli){
				$sqlUpOnayli = "UPDATE M_ESKI_BELGE_BIRIM SET DURUM = 0 WHERE BELGE_ID = ? AND DURUM = 1";
				if(!$db->prep_exec_insert($sqlUpOnayli,array($belgeId))){
					return false;
				}
			}
			return true;
		}
	}
	
	public function BelgeBirimleriOnayBekliyorMu($BelgeNo){
		$db = & JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_ESKI_BELGE_BIRIM WHERE (DURUM = 1 OR DURUM = 0) AND BELGE_ID = (SELECT ID FROM M_BELGE_SORGU WHERE BELGENO = ?)";
		$data = $db->prep_exec($sql, array($BelgeNo));
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	public function BelgeNoEditMi($post){
		$db = & JFactory::getOracleDBO();
		$sql = "SELECT * FROM M_BELGE_EDIT_BELGENO WHERE (DURUM = 1 OR DURUM = 0) AND BELGE_ID = ?";
		return $db->prep_exec($sql, array($post['belgeId']));
	}
	
	public function BelgeNoEditMiByBelgeNo($belgeNo){
		$db = & JFactory::getOracleDBO();
		$sql = "SELECT * FROM M_BELGE_EDIT_BELGENO WHERE (DURUM = 1 OR DURUM = 0) AND BELGE_ID = (SELECT ID FROM M_BELGE_SORGU WHERE BELGENO = ?)";
		$data = $db->prep_exec($sql, array($belgeNo));
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
	
	public function BelgeTarihEditMi($post){
		$db = & JFactory::getOracleDBO();
		$sql = "SELECT * FROM M_BELGE_EDIT_BELGETARIH WHERE (DURUM = 1 OR DURUM = 0) AND BELGE_ID = ?";
		return $db->prep_exec($sql, array($post['belgeId']));
	}
	
	public function BelgeTarihEditMiByBelgeNo($belgeNo){
		$db = & JFactory::getOracleDBO();
		$sql = "SELECT * FROM M_BELGE_EDIT_BELGETARIH WHERE (DURUM = 1 OR DURUM = 0) AND BELGE_ID = (SELECT ID FROM M_BELGE_SORGU WHERE BELGENO = ?)";
		$data = $db->prep_exec($sql, array($belgeNo));
		if($data){
			return $data[0];
		}else{
			return false;
		}
	}
}