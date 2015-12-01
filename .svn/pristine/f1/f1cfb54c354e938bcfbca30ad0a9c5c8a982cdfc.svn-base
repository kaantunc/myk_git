<?php
defined('_JEXEC') or die('Restricted access');

class Uzman_BasvurModelBasvuru_Kaydet extends JModel {
	
	function basvuruKaydet ($data, $layout){
		global $mainframe;
		$session	 = &JFactory::getSession();
		$user 	 = &JFactory::getUser ();
		$user_id = $user->getOracleUserId ();
		$dbOrc 	= & JFactory::getOracleDBO();
		$db		=& JFactory::getDBO();
		if ($user_id<1){
			$user_id = $this->userVerileriEkle ($dbOrc, $user);
			$this->updateUserId($db, $user, $user_id);
		}
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
		if ($data[tckimlik]!=""){
			$evrak_id = $data[tckimlik];
		} else {
			$evrak_id = $data[evrak_id];
		}
    	$session->set ("evrak_id", $evrak_id);
    	
		if ($isSektorSorumlusu){
			$durum=UZMAN_HAVUZU__DURUMU__SS_KAYDI;
//			$basvuru_durumu=UZMAN_HAVUZU__BASVURU_DURUMU__ONAYLANDI;
		} else {
			$durum=UZMAN_HAVUZU__DURUMU__KULLANICI_KAYDI;
			$basvuru_durumu=UZMAN_HAVUZU__BASVURU_DURUMU__BASVURU_TAMAMLANMAMIS;
			$db 	= & JFactory::getOracleDBO();
			$sql="update m_uzman_havuzu set basvuru_durum=".UZMAN_HAVUZU__BASVURU_DURUMU__BASVURU_TAMAMLANMAMIS.", durum=".UZMAN_HAVUZU__DURUMU__KULLANICI_KAYDI." where tc_kimlik=".$evrak_id;
			$sonuc=$db->prep_exec_insert($sql);
			
		}					
//   					echo "<pre>";
//   					print_r($data);
//   					echo "</pre>";
//  					exit;
		
    	if ($evrak_id != -1){  //$evrak_id, tc kimlik numarasıdır.	
    		
			switch ($layout){
				case "uzman_bilgi":
					$sayfa = 1;
					if ($isSektorSorumlusu){
						$user_id = $this->getUserIdbyTcKN($evrak_id);
					}
					
					if ($this->uzmanBilgiKaydet($user_id, $data,$durum,$basvuru_durumu,$isSektorSorumlusu))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = "Kaydedilecek hiç veri yok veya ".JText::_("VERI_KAYDI_BASARISIZ");
					break;
				case "egitim":
					$sayfa = 4;
					if ($this->egitimVerileriKaydet($evrak_id, $data,$sayfa,$durum))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = "Kaydedilecek hiç veri yok veya ".JText::_("VERI_KAYDI_BASARISIZ");
					break;
                case "yabanci_dil":
					$sayfa = 5;
					if ($this->dilVerileriKaydet($evrak_id, $data,$sayfa,$durum))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = "Kaydedilecek hiç veri yok veya ".JText::_("VERI_KAYDI_BASARISIZ");
						
					break;
				case "sertifika":
					$sayfa = 6;
					if ($this->sertifikaVerileriKaydet($evrak_id, $data,$sayfa,$durum))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = "Kaydedilecek hiç veri yok veya ".JText::_("VERI_KAYDI_BASARISIZ");
						
					
					break;
				case "is_deneyimi":
					$sayfa = 7;
					if ($this->deneyimVerileriKaydet($evrak_id, $data,$sayfa,$durum))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = "Kaydedilecek hiç veri yok veya ".JText::_("VERI_KAYDI_BASARISIZ");
						
					break;
				case "myk_deneyimi":
					$sayfa = 8;
					if ($this->mykDeneyimVerileriKaydet($evrak_id, $data,$sayfa,$durum))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = "Kaydedilecek hiç veri yok veya ".JText::_("VERI_KAYDI_BASARISIZ");
						
					break;
				case "basvuru_bilgi":
					$sayfa = 3;
					if ($this->basvuruBilgiVerileriKaydet($evrak_id, $data,$sayfa,$durum))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = "Kaydedilecek hiç veri yok veya ".JText::_("VERI_KAYDI_BASARISIZ");
						
					break;
					
				case "denetci":
					$sayfa = 3;
					if ($this->DenetciBasvuruVerisiKaydet($evrak_id, $data))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = "Kaydedilecek hiç veri yok veya ".JText::_("VERI_KAYDI_BASARISIZ");
					
					break;
					
				case "teknik_uzman":
					$sayfa = 3;
					if ($this->TeknikUzmanBasvuruVerisiKaydet($evrak_id, $data,$sayfa,$durum)){
						$message = JText::_("VERI_KAYDI_BASARILI");
					}
					else{
						$message = "Kaydedilecek hiç veri yok veya ".JText::_("VERI_KAYDI_BASARISIZ");
					}
			
					break;
					
				case "myk_egitim":
					$sayfa=2;
					if ($this->MykEgitimVerileriKaydet($evrak_id, $data,$sayfa,$durum))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = "Kaydedilecek hiç veri yok veya ".JText::_("VERI_KAYDI_BASARISIZ");
					break;
					
				case "ss_islemleri":
//					$sayfa = 2;
					if ($this->ssYorumKaydet($evrak_id, $data))
						$message = JText::_("VERI_KAYDI_BASARILI");
					else
						$message = "Kaydedilecek hiç veri yok veya ".JText::_("VERI_KAYDI_BASARISIZ");
				
					break;
			}
			
			if ($message == JText::_("VERI_KAYDI_BASARILI"))
				//if (!$isSektorSorumlusu){
					$this->insertSavedPage ($sayfa, substr($evrak_id,0,9), $user->id, UZMAN_BASVURU_TIP);
				//}
	    	}else {
	    		return JText::_("BASVURU_KAYDI_BASARISIZ");
	    	}
    	
    	return $message;
	}
	
	function basvuruBitir ($evrak_id){
 					$db 	= & JFactory::getOracleDBO(); //Oracle
								
 					$sql="update m_uzman_havuzu set basvuru_durum=1 where tc_kimlik='".$evrak_id."' and durum=1";
 					$sonuc=$db->prep_exec_insert($sql, array());
					$this->clearSavedPages (substr($evrak_id,0,9));
	}
	
	function uzmanBilgiKaydet($user_id, $data,$durum,$basvuru_durum,$isSektorSorumlusu){
		$db 	= & JFactory::getOracleDBO(); //Oracle
		if ($data[tckimlik]!=""){
			switch ($data["islem"]){
			

					case "olustur":
						$sql="select AD,UZMAN,DENETCI,BASVURU_DURUM from m_uzman_havuzu where tc_kimlik=".$data[tckimlik]." and user_id=".$user_id;
						$sonuc=$db->prep_exec($sql, array());
						$uzman=$sonuc[0]["UZMAN"];
						$denetci=$sonuc[0]["DENETCI"];
						if ($isSektorSorumlusu){
							$basvuru_durum = $sonuc[0]["BASVURU_DURUM"];
						}
						if (!$sonuc[0]["AD"]){
							$sql="select AD from m_uzman_havuzu where tc_kimlik=".$data[tckimlik];
							$sonuc2=$db->prep_exec($sql, array());
							if ($sonuc2[0]["AD"]){
								return false;
							}
						}
						$sql="delete from m_uzman_havuzu where tc_kimlik=".$data[tckimlik]." and user_id=".$user_id;
						$sonuc=$db->prep_exec_insert($sql);
// 						if ($data[tckimlik]!=$data[evrak_id]){
// 							$this->deleteAllRecordsByTckimlik($data[evrak_id],$durum,$user_id);
// 						}
						if ($_FILES[cv][size]){
							if($_FILES[cv][size]>10500000){
								$mainframe->redirect("index.php?option=com_uzman_kayit", "Gönderdiğiniz CV'nin boyutu 10 mb dan büyük.", 'error');
							} else {
									
								if (!file_exists(EK_FOLDER."uzman/cv/".$user_id."/")){
									mkdir(EK_FOLDER."uzman/cv/".$user_id, 0700,true);;
								}
								$normalFile = FormFactory::formatFilename ($_FILES[cv][name]);
								$_FILES[cv][name]=	"uzman/cv/".$user_id."/" . $normalFile;
								move_uploaded_file($_FILES[cv][tmp_name],EK_FOLDER.$_FILES[cv][name]);		
								$cvpath=$_FILES[cv][name];						
							}
						}
						
						if ($_FILES[foto][size]){
							if($_FILES[foto][size]>10500000){
								$mainframe->redirect("index.php?option=com_uzman_kayit", "Gönderdiğiniz Fotoğrafın boyutu 10 mb dan büyük.", 'error');
							} else {
									
								if (!file_exists(EK_FOLDER."uzman/foto/".$user_id."/")){
									mkdir(EK_FOLDER."uzman/foto/".$user_id, 0700,true);;
								}
								$normalFile = FormFactory::formatFilename ($_FILES[foto][name]);
								$_FILES[foto][name]=	"uzman/foto/".$user_id."/" . $normalFile;
								move_uploaded_file($_FILES[foto][tmp_name],EK_FOLDER.$_FILES[foto][name]);
								$fotopath=$_FILES[foto][name];
								$data['foto'] = $fotopath;
							}
						}
						
						$sql = "INSERT INTO M_UZMAN_HAVUZU
					(USER_ID, TC_KIMLIK,ONEK, AD, SOYAD, KURUM,
					KURUM_UNVANI, KADEME, DERECE, ADRES, IL, POSTAKODU, TEL,
					FAX, EPOSTA, WEB, DURUM, TARIH,BASVURU_DURUM,CV_PATH,UZMAN,DENETCI,FOTO_PATH)
					values( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,".time().",?,?,?,?,?)";
					
						$params = array($user_id,
								$data[tckimlik],
								$data[unvan],
								$data[ad],
								$data[soyad],
								$data[kurum],
								$data[kurum_unvan],
								$data[kademe],
								$data[derece],
								$data[adres],
								$data[sehir],
								$data[posta_kodu],
								$data[telefon],
								$data[faks],
								$data[eposta],
								$data[web],
								$durum,
								$basvuru_durum,
								$data[cv],
								$uzman,
								$denetci,
								$data[foto]
						);
						$sonuc=$db->prep_exec_insert($sql, $params);
						if ($cvpath){
							$sql="update m_uzman_havuzu set CV_PATH='".$cvpath."' where tc_kimlik=".$data[tckimlik]." and durum=".UZMAN_HAVUZU__DURUMU__KULLANICI_KAYDI;
							$sonuc=$db->prep_exec_insert($sql);							
						}
						
						if ($fotopath){
							$sql="update m_uzman_havuzu set FOTO_PATH='".$fotopath."' where tc_kimlik=".$data[tckimlik]." and durum=".UZMAN_HAVUZU__DURUMU__KULLANICI_KAYDI;
							$sonuc=$db->prep_exec_insert($sql);
						}
						break;
					
							
			}
		}				
		//return $sonuc;
		return true;
		
	}

	
	function egitimVerileriKaydet ($evrak_pk, $posted,$sayfa,$durum){
		$db 	= & JFactory::getOracleDBO(); //Oracle
                
                //update
                if(strlen($posted['egitId'])>0 && $posted['egitId']>0){
                    $sql="update m_uzman_havuzu_egitim set
					TC_KIMLIK=?,TUR=?,OKUL=?,BOLUM=?,BASLANGIC=?,BITIS=?,DURUM=? where EGITIM_ID=?";
				$params=array($posted['tckimlik'],$posted['egitimTur'],$posted['okulAdi'],$posted['okulBolum'],$posted['okulBas'],$posted['okulBit'],$durum,$posted['egitId']);
				$sonuc=$db->prep_exec_insert($sql, $params);
                }
                //Yeni Kayıt
                else{
                    $sql="insert into m_uzman_havuzu_egitim 
					(TC_KIMLIK,TUR,OKUL,BOLUM,BASLANGIC,BITIS,DURUM) values
					( ? ,? , ? , ? , ? , ? , ? )";
				$params=array($posted['tckimlik'],$posted['egitimTur'],$posted['okulAdi'],$posted['okulBolum'],$posted['okulBas'],$posted['okulBit'],$durum);
				$sonuc=$db->prep_exec_insert($sql, $params);
                }		
		//return $sonuc;
		return true;
	}
	
	function MykEgitimVerileriKaydet($evrak_pk, $posted,$sayfa,$durum){
		$db 	= & JFactory::getOracleDBO(); 
		
		//update
		if(strlen($posted['egitId'])>0 && $posted['egitId']>0){
			$sql="update m_uzman_havuzu_myk_egitim set
					TARIH = ?, TUR=?, EGITMEN=?, SURE=?, ACIKLAMA = ? WHERE EGITIM_ID=?";
			$params=array($posted['basTarih'],$posted['tur'],$posted['egitmen'],$posted['sure'],trim($posted['acik']),$posted['egitId']);
			$sonuc=$db->prep_exec_insert($sql, $params);
		}
		//Yeni Kayıt
		else{
			$egitimId = $db->getNextVal('SEQ_U_MYK_EGITIM');
			$sql="insert into m_uzman_havuzu_myk_egitim
					(EGITIM_ID, TC_KIMLIK, TARIH, TUR, EGITMEN, SURE, ACIKLAMA) values
					( ? ,? , ? , ? , ? , ? , ?)";
			$params=array($egitimId,$posted['tckimlik'],$posted['basTarih'],$posted['tur'],$posted['egitmen'],$posted['sure'],trim($posted['acik']));
			$sonuc=$db->prep_exec_insert($sql, $params);
		}
		//return $sonuc;
		return $sonuc;
	}
		
	function dilVerileriKaydet ($evrak_pk, $posted,$sayfa,$durum){
		$db 	= & JFactory::getOracleDBO(); //Oracle
		
                if(strlen($posted['dilId'])>0 && $posted['dilId']>0){
                    $sql="update M_UZMAN_HAVUZU_YABANCI_DIL set
					TC_KIMLIK=?,DIL=?,OKUMA=?,YAZMA=?,KONUSMA=?,ANLAMA=?,DURUM=? where DIL_ID=?";
                    $params=array($posted['tckimlik'],$posted['yabanciDil'],$posted['okumaTur'],$posted['yazmaTur'],$posted['konusmaTur'],$posted['dinlemeTur'],$durum,$posted['dilId']);
                    $sonuc=$db->prep_exec_insert($sql, $params);
                }
                //Yeni Kayıt
                else{
                    $sql="insert into M_UZMAN_HAVUZU_YABANCI_DIL 
					(TC_KIMLIK,DIL,OKUMA,YAZMA,KONUSMA,ANLAMA,DURUM) values
					( ? ,? , ? , ? , ? , ? , ? )";
                    $params=array($posted['tckimlik'],$posted['yabanciDil'],$posted['okumaTur'],$posted['yazmaTur'],$posted['konusmaTur'],$posted['dinlemeTur'],$durum);
                    $sonuc=$db->prep_exec_insert($sql, $params);
                }		
          
		//return $sonuc;
		return true;
		
	}
		
	function sertifikaVerileriKaydet ($evrak_pk, $posted,$sayfa,$durum){
		global $mainframe;
		$db 	= & JFactory::getOracleDBO(); //Oracle
                
                $sql = "SELECT USER_ID FROM M_UZMAN_HAVUZU WHERE TC_KIMLIK = ?";
                $user = $db->prep_exec($sql,array($posted['tckimlik']));
                $user_id = $user[0]['USER_ID'];
                
                if(array_key_exists('serId', $posted)){
                    if($_FILES['dosyaAdi']['size']>10500000){
                        $mainframe->redirect("index.php?option=com_uzman_basvur&layout=sertifika&tc_kimlik=".$evrak_pk, "Gönderdiğiniz dosya(lar)nın boyutu 10 mb dan büyük olamaz.", 'error');
                    }else if($_FILES['dosyaAdi']['size']==0){
                        $sql="update M_UZMAN_HAVUZU_SERTIFIKA SET
					TC_KIMLIK = ?,BELGE_ADI = ?,VEREN = ?,TARIH = ?,ACIKLAMA = ?,DURUM = ? where SERTIFIKA_ID = ?";
			$params=array($posted['tckimlik'],$posted['belgeAdi'],$posted['verenKur'],$posted['belgeTarih'],$posted['belgeAci'],$durum,$posted['serId']);
                        $sonuc=$db->prep_exec_insert($sql, $params);
                    }else if($_FILES['dosyaAdi']['size']>0){
                        if (!file_exists(EK_FOLDER."uzman/belge/".$user_id."/")){
                                mkdir(EK_FOLDER."uzman/belge/".$user_id, 0700,true);
                        }
                        $normalFile = FormFactory::formatFilename ($_FILES['dosyaAdi']['name']);
                        $filename =	"uzman/belge/".$user_id."/" . $normalFile;
                        move_uploaded_file($_FILES['dosyaAdi']['tmp_name'],EK_FOLDER.$filename);
                        
                        $sql="update M_UZMAN_HAVUZU_SERTIFIKA SET
					TC_KIMLIK = ?,BELGE_ADI = ?,VEREN = ?,TARIH = ?,ACIKLAMA = ?,DURUM = ?,PATH = ? where SERTIFIKA_ID = ?";
			$params=array($posted['tckimlik'],$posted['belgeAdi'],$posted['verenKur'],$posted['belgeTarih'],$posted['belgeAci'],$durum,$filename,$posted['serId']);
                        $sonuc=$db->prep_exec_insert($sql, $params);
                    }
                }
                else{
                    if($_FILES['dosyaAdi']['size']>10500000){
                        $mainframe->redirect("index.php?option=com_uzman_basvur&layout=sertifika&tc_kimlik=".$evrak_pk, "Gönderdiğiniz dosyanın boyutu 10 mb dan büyük olamaz.", 'error');
                    }
                    else{
                        if (!file_exists(EK_FOLDER."uzman/belge/".$user_id."/")){
                                mkdir(EK_FOLDER."uzman/belge/".$user_id, 0700,true);
                        }
                        $normalFile = FormFactory::formatFilename ($_FILES['dosyaAdi']['name']);
                        $filename =	"uzman/belge/".$user_id."/" . $normalFile;
                        move_uploaded_file($_FILES['dosyaAdi']['tmp_name'],EK_FOLDER.$filename);

                        $sql="insert into M_UZMAN_HAVUZU_SERTIFIKA 
					(TC_KIMLIK,BELGE_ADI,VEREN,TARIH,PATH,ACIKLAMA,DURUM) values
					( ? ,? , ? , ? , ? , ? , ? )";
			$params=array($posted['tckimlik'],$posted['belgeAdi'],$posted['verenKur'],$posted['belgeTarih'],$filename,$posted['belgeAci'],$durum);
                        $sonuc=$db->prep_exec_insert($sql, $params);
                    }
                }            		
				//return $sonuc;
		return true;
	}
	
	function deneyimVerileriKaydet ($evrak_pk, $posted,$sayfa,$durum){
		$db 	= & JFactory::getOracleDBO(); //Oracle
                
                if(strlen($posted['isId'])>0 && $posted['isId']>0){
                    $sql="update m_uzman_havuzu_deneyim set
					TC_KIMLIK=?,BASLANGIC=?,BITIS=?,ISYERI=?,UNVAN=?,IS_TANIMI=?,DURUM=? where DENEYIM_ID=?";
                    $params=array($posted['tckimlik'],$posted['isBas'],$posted['isBit'],$posted['isKur'],$posted['isUnvan'],$posted['isTanim'],$durum,$posted['isId']);
                    $sonuc=$db->prep_exec_insert($sql, $params);
                }
                //Yeni Kayıt
                else{
                    $sql="insert into m_uzman_havuzu_deneyim 
					(TC_KIMLIK,BASLANGIC,BITIS,ISYERI,UNVAN,IS_TANIMI,DURUM) values
					( ? ,? , ? , ? , ? , ? , ? )";
                    $params=array($posted['tckimlik'],$posted['isBas'],$posted['isBit'],$posted['isKur'],$posted['isUnvan'],$posted['isTanim'],$durum);
                    $sonuc=$db->prep_exec_insert($sql, $params);
                }		
                
		return $sonuc;
	}
		
	function mykDeneyimVerileriKaydet ($evrak_pk, $posted,$sayfa,$durum){
		$db 	= & JFactory::getOracleDBO(); //Oracle
		
                if(strlen($posted['mykdeneyimId'])>0 && $posted['mykdeneyimId']>0){
                    $sql="update m_uzman_havuzu_myk_deneyim set
					TC_KIMLIK=?,TIP=?,ACIKLAMA=?,SURE=?,DURUM=? where MYKDENEYIM_ID=?";
                    $params=array($posted['tckimlik'],$posted['tip'],$posted['aciklama'],$posted['sure'],$durum,$posted['mykdeneyimId']);
                    $sonuc=$db->prep_exec_insert($sql, $params);
                }
                //Yeni Kayıt
                else{
                    $sql="insert into m_uzman_havuzu_myk_deneyim 
					(TC_KIMLIK,TIP,ACIKLAMA,SURE,DURUM) values
					( ? ,? , ? , ? ,  ? )";
                    $params=array($posted['tckimlik'],$posted['tip'],$posted['aciklama'],$posted['sure'],$durum);
                    $sonuc=$db->prep_exec_insert($sql, $params);
                }	
                
		//return $sonuc;
		return true;
		
	}
	
	function DenetciBasvuruVerisiKaydet($evrak_id, $data){
		$return[] = $this->DenetciGecerlilikBelgesiEkle($evrak_id, $data);
		
		$return[] = $this->DenetciKanitBelgesiEkle($evrak_id, $data);
		
		$return[] = $this->UzmanTaahutnameEkle($evrak_id, $data);
		
		$return[] = $this->DenetciMusaitlik($evrak_id, $data);
		
		foreach($return as $val){
			if(!$val){
				return false;
			}
		}
		
		return true;
	}
	
	function DenetciGecerlilikBelgesiEkle($evrak_id, $data){
		$db 	= & JFactory::getOracleDBO();
		$dtBelgeAdi = $data['dtBelgeAdi'];
		$dtBelge = $_FILES['dtBelgeFile'];
		$dtBelgeTarih = $data['dtBelgeTarih'];
		
		$sqlInsert = "INSERT INTO M_UZMAN_DENETCI_BELGE (BELGE_ID, UZMAN_ID, BELGE_ADI, BELGE_PATH, GECERLILIK_TARIHI) 
				values(?,?,?,?,TO_DATE(?,'DD/MM/YYYY HH24:MI:SS'))";
		
		if(!empty($dtBelgeAdi)){
			$hata = 0;
			foreach ($dtBelgeAdi as $key=>$val){
				if($dtBelge['error'][$key] > 0 || $dtBelge['type'][$key] != 'application/pdf'){
					$hata++;
				}else{
					if (!file_exists(EK_FOLDER."uzman/denetci/belgegecerlilik/".$evrak_id."/")){
						mkdir(EK_FOLDER."uzman/denetci/belgegecerlilik/".$evrak_id, 0700,true);;
					}
					
					$normalFile = FormFactory::formatFilename ($dtBelge['name'][$key]);
					$belgePath =	"uzman/denetci/belgegecerlilik/".$evrak_id."/" .date('dmYHis').'_'. $normalFile;
					if(move_uploaded_file($dtBelge['tmp_name'][$key],EK_FOLDER.$belgePath)){
						$belgeId = $db->getNextVal('SEQ_U_DENETCI_BELGE');
						$param = array(
								$belgeId,
								$data['tckimlik'],
								$val,
								$belgePath,
								$dtBelgeTarih[$key]." 00:00:00"
						);
							
						if(!$db->prep_exec_insert($sqlInsert, $param)){
							$hata++;
						}
					}
				}
			}
			
			if($hata > 0){
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
	
	function DenetciKanitBelgesiEkle($evrak_id, $data){
		$db 	= & JFactory::getOracleDBO();
		$dtBelgeAdi = $data['dtKanit'];
		$dtBelge = $_FILES['dtKanitFile'];
	
		$sqlInsert = "INSERT INTO M_UZMAN_DENETCI_KANIT_BELGESI (BELGE_ID, UZMAN_ID, BELGE_ADI, BELGE_PATH)
				values(?,?,?,?)";
	
		if(!empty($dtBelgeAdi)){
			$hata = 0;
			foreach ($dtBelgeAdi as $key=>$val){
				if($dtBelge['error'][$key] > 0 || $dtBelge['type'][$key] != 'application/pdf'){
					$hata++;
				}else{
					if (!file_exists(EK_FOLDER."uzman/denetci/belgekanit/".$evrak_id."/")){
						mkdir(EK_FOLDER."uzman/denetci/belgekanit/".$evrak_id, 0700,true);;
					}
						
					$normalFile = FormFactory::formatFilename ($dtBelge['name'][$key]);
					$belgePath =	"uzman/denetci/belgekanit/".$evrak_id."/" .date('dmYHis').'_'.$normalFile;
					if(move_uploaded_file($dtBelge['tmp_name'][$key],EK_FOLDER.$belgePath)){
						$belgeId = $db->getNextVal('SEQ_U_DENETCI_KANIT');
						$param = array(
								$belgeId,
								$data['tckimlik'],
								$val,
								$belgePath
						);
							
						if(!$db->prep_exec_insert($sqlInsert, $param)){
							$hata++;
						}
					}
				}
			}
				
			if($hata > 0){
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
	
	function DenetciMusaitlik($evrak_id, $data){
		$db 	= & JFactory::getOracleDBO();
		$musait = trim($data['musait']);
		
		$sql = "SELECT * FROM M_UZMAN_DENETCI_MUSAIT WHERE UZMAN_ID = ?";
		$val = $db->prep_exec($sql, array($data['tckimlik']));
		
		if($val){
			$sqlDel = "DELETE FROM M_UZMAN_DENETCI_MUSAIT WHERE UZMAN_ID = ?";
			$return = $db->prep_exec_insert($sqlDel, array($data['tckimlik']));
		}
		
		$sqlInsert = "INSERT INTO M_UZMAN_DENETCI_MUSAIT (UZMAN_ID, MUSAIT) VALUES(?,?)";
		$return = $db->prep_exec_insert($sqlInsert, array($data['tckimlik'],$musait));
		
		if($return){
			return true;
		}else{
			return false;
		}
	}
	
	function TeknikUzmanBasvuruVerisiKaydet($evrak_id, $data){
		$return[] = $this->TUYetKaydet($evrak_id, $data);
		
		$return[] = $this->TUKanitBelgesiEkle($evrak_id, $data);
		
		$return[] = $this->UzmanTaahutnameEkle($evrak_id, $data);
		
		$return[] = $this->TUMusaitlik($evrak_id, $data);
		
		foreach($return as $val){
			if(!$val){
				return false;
			}
		}
		
		return true;
	}
	
	function TUYetKaydet($evrak_id, $data){
		$db 	= & JFactory::getOracleDBO();
		
		$yet = $data['yet'];
		$yetAcik = $data['yetAcik'];
		
		$sqlInsert = "INSERT INTO M_UZMAN_TEKNIK_YETERLILIK (TUYET_ID, UZMAN_ID, YETERLILIK_ID, ACIKLAMA) 
				VALUES(?,?,?,?)";
		
		$hata = 0;
		foreach($yet as $key=>$val){
			$tuId = $db->getNextVal('SEQ_U_TEKNIK_YETERLILIK');
			$param = array(
					$tuId,
					$data['tckimlik'],
					$val,
					trim($yetAcik[$key])
			);
			
			if(!$db->prep_exec_insert($sqlInsert, $param)){
				$hata++;
			}
		}
		
		if($hata>0){
			return false;
		}else{
			return true;
		}
	}
	
	function TUKanitBelgesiEkle($evrak_id, $data){
		$db 	= & JFactory::getOracleDBO();
		$dtBelgeAdi = $data['dtKanit'];
		$dtBelge = $_FILES['dtKanitFile'];
	
		$sqlInsert = "INSERT INTO M_UZMAN_TEKNIK_KANIT_BELGESI (BELGE_ID, UZMAN_ID, BELGE_ADI, BELGE_PATH)
				values(?,?,?,?)";
	
		if(!empty($dtBelgeAdi)){
			$hata = 0;
			foreach ($dtBelgeAdi as $key=>$val){
				if($dtBelge['error'][$key] > 0 || $dtBelge['type'][$key] != 'application/pdf'){
					$hata++;
				}else{
					if (!file_exists(EK_FOLDER."uzman/teknik_uzman/belgekanit/".$evrak_id."/")){
						mkdir(EK_FOLDER."uzman/teknik_uzman/belgekanit/".$evrak_id, 0700,true);;
					}
	
					$normalFile = FormFactory::formatFilename ($dtBelge['name'][$key]);
					$belgePath =	"uzman/teknik_uzman/belgekanit/".$evrak_id."/" .date('dmYHis').'_'.$normalFile;
					if(move_uploaded_file($dtBelge['tmp_name'][$key],EK_FOLDER.$belgePath)){
						$belgeId = $db->getNextVal('SEQ_U_TEKNIK_KANIT');
						$param = array(
								$belgeId,
								$data['tckimlik'],
								$val,
								$belgePath
						);
							
						if(!$db->prep_exec_insert($sqlInsert, $param)){
							$hata++;
						}
					}
				}
			}
	
			if($hata > 0){
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
	
	function TUMusaitlik($evrak_id, $data){
		$db 	= & JFactory::getOracleDBO();
		$musait = trim($data['musait']);
	
		$sql = "SELECT * FROM M_UZMAN_TEKNIK_MUSAIT WHERE UZMAN_ID = ?";
		$val = $db->prep_exec($sql, array($data['tckimlik']));
	
		if($val){
			$sqlDel = "DELETE FROM M_UZMAN_TEKNIK_MUSAIT WHERE UZMAN_ID = ?";
			$return = $db->prep_exec_insert($sqlDel, array($data['tckimlik']));
		}
	
		$sqlInsert = "INSERT INTO M_UZMAN_TEKNIK_MUSAIT (UZMAN_ID, MUSAIT) VALUES(?,?)";
		$return = $db->prep_exec_insert($sqlInsert, array($data['tckimlik'],$musait));
	
		if($return){
			return true;
		}else{
			return false;
		}
	}
	
	function UzmanTaahutnameEkle($evrak_id, $data){
		$db 	= & JFactory::getOracleDBO();
		$dtBelge = $_FILES['detTaahut'];
		
		$sqlInsert = "INSERT INTO M_UZMAN_TAAHUTNAME (UZMAN_ID, BELGE_PATH, TARIH)
				values(?, ?, TO_DATE('".date('d/m/Y H:i:s')."','DD/MM/YYYY HH24:MI:SS'))";
		
		if(!empty($dtBelge)){
			if(empty($dtBelge['name']) && empty($dtBelge['type'])){
				return true;	
			}else if($dtBelge['error'] > 0 || $dtBelge['type'] != 'application/pdf'){
				return false;
			}else{
				if (!file_exists(EK_FOLDER."uzman/taahutname/".$evrak_id."/")){
					mkdir(EK_FOLDER."uzman/taahutname/".$evrak_id, 0700,true);;
				}
				
				$normalFile = FormFactory::formatFilename ($dtBelge['name']);
				$belgePath =	"uzman/taahutname/".$data['tckimlik']."/" . $normalFile;
				if(move_uploaded_file($dtBelge['tmp_name'],EK_FOLDER.$belgePath)){
					$param = array(
							$data['tckimlik'],
							$belgePath
					);
						
					if($db->prep_exec_insert($sqlInsert, $param)){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}
		}else{
			return true;
		}
		
	}
		
	function basvuruBilgiVerileriKaydet ($evrak_pk, $posted,$sayfa,$durum){
		echo"<pre>";
		print_r($posted);
		echo "</pre>";
//		exit;		
		$this->deleteSavedPage ($sayfa,  substr($evrak_pk, 0, 9));
		$sonuc=false;
		
		$sektorsonuc=$this->basvuruBilgiSektorKaydet ($evrak_pk, $posted,$durum);
// 		$yeterliliksonuc=$this->basvuruBilgiYeterlilikKaydet ($evrak_pk, $posted,$durum);
		$alansonuc=$this->basvuruBilgiAlanKaydet ($evrak_pk, $posted,$durum);
		
		if ($sektorsonuc===true or $alansonuc===true){
			$sonuc=true;
		}
		
		//return $sonuc;
		return true;
		
		
	}
	function basvuruBilgiSektorKaydet ($evrak_pk, $posted,$durum){
		$db 	= & JFactory::getOracleDBO(); //Oracle
		$sql="delete from m_uzman_havuzu_sektor where TC_KIMLIK= ".$evrak_pk;
		$sonuc=$db->prep_exec_insert($sql, array());
		for ($i = 0; $i < count($posted[sektorler]); $i++){
			if ($posted[sektorler][$i]!=""){

				$sql="insert into m_uzman_havuzu_sektor 
					(TC_KIMLIK,SEKTOR_ID,DURUM) values
					( ".$evrak_pk.",? ,  ? )";
				$params=array($posted[sektorler][$i],$durum);
				$sonuc=$db->prep_exec_insert($sql, $params);
			}
		}		
		return $sonuc;
		//return true;
		
	}
	
		
	function basvuruBilgiYeterlilikKaydet ($evrak_pk, $posted,$durum){
		$db 	= & JFactory::getOracleDBO(); //Oracle
		$sql="delete from m_uzman_havuzu_yeterlilik where TC_KIMLIK= ".$evrak_pk;
		$sonuc=$db->prep_exec_insert($sql, array());
		for ($i = 0; $i < count($posted[yeterlilik_id]); $i++){
			if ($posted[yeterlilik_id][$i]!=""){

				$sql="insert into m_uzman_havuzu_yeterlilik 
					(TC_KIMLIK,YETERLILIK_ID,DURUM) values
					( ".$evrak_pk.",? ,  ? )";
				$params=array($posted[yeterlilik_id][$i],$durum);
				$sonuc=$db->prep_exec_insert($sql, $params);
			}
		}		
		return $sonuc;
		//return true;
		
	}
	
	function basvuruBilgiAlanKaydet ($evrak_pk, $posted,$durum){
		$db 	= & JFactory::getOracleDBO(); //Oracle
		$sql="delete from m_uzman_havuzu_alanlar where TC_KIMLIK= ".$evrak_pk;
		$sonuc=$db->prep_exec_insert($sql, array());
			$sql="update m_uzman_havuzu set DENETCI=?, DURUM=? where TC_KIMLIK=?";
			$params=array($posted[denetci],$durum,$evrak_pk);
			$sonuc=$db->prep_exec_insert($sql, $params);
		if ($posted[uzman]==1){
			$sql1="update m_uzman_havuzu set UZMAN=1 where TC_KIMLIK=? and durum=?";
			$params1=array($evrak_pk,$durum);
			$sonuc=$db->prep_exec_insert($sql1, $params1);
				
			for ($i = 1; $i <= count($posted[alanlar]); $i++){
				if ($posted[alanlar][$i]!=""){
	
					$sql="insert into m_uzman_havuzu_alanlar 
						(TC_KIMLIK,alan,ALAN_TIPI,DURUM) values
						( ".$evrak_pk.",? ,? , ? )";
					$params=array($posted[alanlar][$i],$i,$durum);
					$sonuc=$db->prep_exec_insert($sql, $params);
				}
			}
		} else {
			$sql1="update m_uzman_havuzu set UZMAN=?, DURUM=? where TC_KIMLIK=?";
			$params1=array($posted[uzman],$durum,$evrak_pk);
			$sonuc=$db->prep_exec_insert($sql1, $params1);
				
		}		
		return $sonuc;
		//return true;
		
	}
	
	function ssYorumKaydet($evrak_id, $data){
		$db 	= & JFactory::getOracleDBO(); //Oracle
		switch ($data["islem"]){
			case "reddet":
				// 					$sql="delete from m_uzman_havuzu where tc_kimlik=".$data[tckimlik]." and durum=2";
				// 					$sonuc=$db->prep_exec_insert($sql);
		
				$sql="update m_uzman_havuzu set basvuru_durum=".UZMAN_HAVUZU__BASVURU_DURUMU__REDDEDILDI.", durum=".UZMAN_HAVUZU__DURUMU__KULLANICI_KAYDI." where tc_kimlik=".$evrak_id;
				$sonuc=$db->prep_exec_insert($sql);
		
		
				break;
		
			case "iade":
				// 					$sql="delete from m_uzman_havuzu where tc_kimlik=".$data[tckimlik]." and durum=2";
				// 					$sonuc=$db->prep_exec_insert($sql);
		
				$sql="update m_uzman_havuzu set basvuru_durum=".UZMAN_HAVUZU__BASVURU_DURUMU__BASVURU_TAMAMLANMAMIS.", durum=".UZMAN_HAVUZU__DURUMU__KULLANICI_KAYDI." where tc_kimlik=".$evrak_id;
				$sonuc=$db->prep_exec_insert($sql);
		
		
				break;
		
			case "onayla":
				// 					$sql="delete from m_uzman_havuzu where tc_kimlik=".$data[tckimlik]." and durum=".$durum;
				// 					$sonuc=$db->prep_exec_insert($sql);
		
				$sql="update m_uzman_havuzu set basvuru_durum=".UZMAN_HAVUZU__BASVURU_DURUMU__ONAYLANDI.", durum=".UZMAN_HAVUZU__DURUMU__KULLANICI_KAYDI." where tc_kimlik=".$evrak_id;
				$sonuc=$db->prep_exec_insert($sql);
		
				// 					$sql = "INSERT INTO M_UZMAN_HAVUZU
				// 					(USER_ID, TC_KIMLIK,ONEK, AD, SOYAD, KURUM,
				// 					KURUM_UNVANI, KADEME, DERECE, ADRES, IL, POSTAKODU, TEL,
				// 					FAX, EPOSTA, WEB, DURUM, TARIH,CV_PATH,BASVURU_DURUM)
				// 					values( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,".time().",?,?)";
		
				// 					$params = array($user_id,
				// 							$data[tckimlik],
				// 							$data[unvan],
				// 							$data[ad],
				// 							$data[soyad],
				// 							$data[kurum],
				// 							$data[kurum_unvan],
				// 							$data[kademe],
				// 							$data[derece],
				// 							$data[adres],
				// 							$data[sehir],
				// 							$data[posta_kodu],
				// 							$data[telefon],
				// 							$data[faks],
				// 							$data[eposta],
				// 							$data[web],
				// 							$durum,
				// 							$data[cv],
				// 							$basvuru_durum
				// 					);
				// 					$sonuc=$db->prep_exec_insert($sql, $params);
		
				break;
		
			default:
		
				$sql="delete from m_uzman_havuzu_yorum where TC_KIMLIK= ".$evrak_id;
				$sonuc=$db->prep_exec_insert($sql, array());
				
				$sql="insert into m_uzman_havuzu_yorum
								(TC_KIMLIK,yorum) values
								( ".$evrak_id.",?  )";
				$params=array($data["yorum"]);
				$sonuc=$db->prep_exec_insert($sql, $params);
				break;
		}
		return $sonuc;
	}
	
	
	function basvuruOlustur (){
		$user		 	= &JFactory::getUser();
    	$user_id	 	= $user->getOracleUserId ();
    	$sayi_id 	 	= T4_SAYI_ID;
    	$basvuru_tip 	= UZMAN_BASVURU_TIP;
    	$basvuru_durum	= ONAYLANMAMIS_BASVURU;
    	
    	$evrak_id = FormFactory::evrakVerisiEkle($user_id, $sayi_id, KAYDEDILMEMIS_BASVURU_SEKLI_ID);
		if ($evrak_id != -1)
    		FormFactory::basvuruOlustur($evrak_id, $user_id, $basvuru_tip, $basvuru_durum);
		
		return $evrak_id;
	}
	
	function insertSavedPage ($pageNum, $evrak_id, $juser_id, $basvuru_tur){
		$db = &JFactory::getDBO();
		
		$sql= "	REPLACE INTO #__user_evrak (user_id, evrak_id,basvuru_tur,saved_page) 
				VALUES (".$juser_id.", ".$evrak_id.",".$basvuru_tur.",".$pageNum.")";
		
		return $db->Execute ($sql);
	}
	
	function clearSavedPages ($evrak_id){
		$db = &JFactory::getDBO();
		
		$sql= "	DELETE FROM #__user_evrak  
				WHERE evrak_id = ".$evrak_id;
		
		return $db->Execute ($sql);
	}
	
	function deleteSavedPage ($page, $evrak_id){
		$db = &JFactory::getDBO();
		
		$sql= "	DELETE FROM #__user_evrak  
				WHERE saved_page = ".$page." AND evrak_id = ".$evrak_id;
		
		return $db->Execute ($sql);
	}
	
	function userVerileriEkle ($dbOrc, $juser){
		$user_id = $dbOrc->getNextVal(USER_SEQ);
		$fileName	= FormFactory::getNormalFilename($_POST[$ekAd.($updated+$j+1)]);
		//Prepare sql statement
		$sql = "INSERT INTO ".DB_PREFIX.".tg_user
				(user_id, user_name, email_address, display_name)
				values( ?, ?, ?, ?)";
	
		$params = array ($user_id,
				$juser->username,
				$juser->email,
				$juser->name 	//Display Name
		);
		if ($dbOrc->prep_exec_insert($sql, $params))
			return $user_id;
		else
			return -1;
	}
	
	function updateUserId($db, $juser, $user_id){
		$sql = "UPDATE #__users
					SET tgUserId = ".$user_id."
				WHERE id = ".$juser->id;
	
		return $db->Execute ($sql);
	}
	
	function deleteAllRecordsByTckimlik ($tckimlik,$durum=1, $user_id=0){
		$db 	= & JFactory::getOracleDBO(); //Oracle
		
		$sql="delete from m_uzman_havuzu where tc_kimlik=".$tckimlik." and user_id=".$user_id;
		$sonuc=$db->prep_exec_insert($sql);
		
		if (!$sonuc){
			return false;
		}
		$sql="delete from m_uzman_havuzu_alanlar where tc_kimlik=".$tckimlik;
		$sonuc=$db->prep_exec_insert($sql);
		
		$sql="delete from m_uzman_havuzu_deneyim where tc_kimlik=".$tckimlik;
		$sonuc=$db->prep_exec_insert($sql);
		
		$sql="delete from m_uzman_havuzu_egitim where tc_kimlik=".$tckimlik;
		$sonuc=$db->prep_exec_insert($sql);
		
		$sql="delete from m_uzman_havuzu_myk_deneyim where tc_kimlik=".$tckimlik;
		$sonuc=$db->prep_exec_insert($sql);
		
		$sql="delete from m_uzman_havuzu_sektor where tc_kimlik=".$tckimlik;
		$sonuc=$db->prep_exec_insert($sql);
		
		$sql="delete from m_uzman_havuzu_sertifika where tc_kimlik=".$tckimlik;
		$sonuc=$db->prep_exec_insert($sql);
		
		$sql="delete from m_uzman_havuzu_yabanci_dil where tc_kimlik=".$tckimlik;
		$sonuc=$db->prep_exec_insert($sql);
		
		$sql="delete from m_uzman_havuzu_yeterlilik where tc_kimlik=".$tckimlik;
		$sonuc=$db->prep_exec_insert($sql);
		$this->clearSavedPages (substr($tckimlik,0,9));
		return true;
		
	}
	
	function updateRecorderToAllRecordsByTckimlik ($tckimlik,$yenikaydeden,$eksikaydeden){
		$db 	= & JFactory::getOracleDBO(); //Oracle
	
		$sql="delete from m_uzman_havuzu where tc_kimlik=".$tckimlik." and durum=".$yenikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
		$sql="set m_uzman_havuzu durum=".$yenikaydeden." where tc_kimlik=".$tckimlik." and durum=".$eksikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
	
		$sql="delete from m_uzman_havuzu_alanlar where tc_kimlik=".$tckimlik." and durum=".$yenikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
		$sql="set m_uzman_havuzu_alanlar durum=".$yenikaydeden." where tc_kimlik=".$tckimlik." and durum=".$eksikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
	
		$sql="delete from m_uzman_havuzu_deneyim where tc_kimlik=".$tckimlik." and durum=".$yenikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
		$sql="set m_uzman_havuzu_deneyim durum=".$yenikaydeden." where tc_kimlik=".$tckimlik." and durum=".$eksikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
	
		$sql="delete from m_uzman_havuzu_egitim where tc_kimlik=".$tckimlik." and durum=".$yenikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
		$sql="set m_uzman_havuzu_egitim durum=".$yenikaydeden." where tc_kimlik=".$tckimlik." and durum=".$eksikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
	
		$sql="delete from m_uzman_havuzu_myk_deneyim where tc_kimlik=".$tckimlik." and durum=".$yenikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
		$sql="set m_uzman_havuzu_myk_deneyim durum=".$yenikaydeden." where tc_kimlik=".$tckimlik." and durum=".$eksikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
	
		$sql="delete from m_uzman_havuzu_sektor where tc_kimlik=".$tckimlik." and durum=".$yenikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
		$sql="set m_uzman_havuzu_sektor durum=".$yenikaydeden." where tc_kimlik=".$tckimlik." and durum=".$eksikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
	
		$sql="delete from m_uzman_havuzu_sertifika where tc_kimlik=".$tckimlik." and durum=".$yenikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
		$sql="set m_uzman_havuzu_sertifika durum=".$yenikaydeden." where tc_kimlik=".$tckimlik." and durum=".$eksikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
	
		$sql="delete from m_uzman_havuzu_yabanci_dil where tc_kimlik=".$tckimlik." and durum=".$yenikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
		$sql="set m_uzman_havuzu_yabanci_dil durum=".$yenikaydeden." where tc_kimlik=".$tckimlik." and durum=".$eksikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
	
		$sql="delete from m_uzman_havuzu_yeterlilik where tc_kimlik=".$tckimlik." and durum=".$yenikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
		$sql="set m_uzman_havuzu_yeterlilik durum=".$yenikaydeden." where tc_kimlik=".$tckimlik." and durum=".$eksikaydeden;
		$sonuc=$db->prep_exec_insert($sql);
	
		return true;
	
	}
	
	function getUserIdbyTcKN($evrak_id){
		$db = & JFactory::getOracleDBO();
	
		$sql = "SELECT user_id
				FROM M_UZMAN_HAVUZU
				WHERE tc_kimlik = ?";
	
		$params = array ($evrak_id);
		$data = $db->prep_exec($sql, $params);
	
		if (!empty($data))
			return $data[0]["USER_ID"];
		else
			return null;
	}
	
}
?>