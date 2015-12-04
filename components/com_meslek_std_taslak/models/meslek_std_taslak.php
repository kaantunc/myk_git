<?php
defined('_JEXEC') or die('Restricted access');

class Meslek_Std_TaslakModelMeslek_Std_Taslak extends JModel {

	var $title 		= "Ulusal Meslek Standardı Taslak Formu"; 
	var $pages 		= array ("hazirlayan","terim","meslek_tanitimi","meslek_profil","ekipman","bilgi_beceri","tutum_davranis","gorev_alanlar"); 
	var $pageNames 	= array ("Standardı Hazırlayan Kuruluş(lar)","Terim/Kısaltma", "Meslek Tanıtımı", "Meslek Profili", "Ekipman", "Bilgi/Beceri", "Tutum/Davranış", "Görev Alanlar");
	
	function getPageTree ($user, $activeLayout, $standart_id, $evrak_id, $taslak = 0){
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
		$canEdit = $this->canEdit ($user, $standart_id);
		$activeStyle = 'style="background-color:rgb(170,0,0);color:rgb(255,255,255); margin: 1px;"';
		$sayfa = count ($this->pages);
		$saved = $this->getSavedPages ($evrak_id, $standart_id);
		$saved[count($saved)] = 0;

		$tree = '<div style="text-align:center; padding-bottom: 15px;" >
				 <div style="padding-bottom:10px;">';
		
		$inp = '<input style="padding:5px; margin: 5px;" type="button" ';
		$value	 = "";
		$onClick = "";
		$disabled= "";
		
		$durumId = $this->getMeslekStandartDurumId ($standart_id);
//		$durumId = $meslekSTDDurumIdArray[0]["MESLEK_STANDART_DURUM_ID"];
				
		if ($isSektorSorumlusu){
			if($durumId != PM_MESLEK_STANDART_DURUMU__ULUSAL_STANDART)
			if($durumId <1)
			{
				//sektor sorumlusu pdf onizlemesi yapabilsin
				if ($taslak == 0){
					$onClick = 'onclick = "userSubmit (1,'.$standart_id.')" ';
					$value = 'value="Tüm Ön Taslağı Görüntüle" ';
					
					$name  = 'name="gonder" ';
					$tree .= $inp.$name.$value.$onClick.$disabled." />";
				}
				//
				$disabled = '';
				if ($this->getYorumCount_SS ($evrak_id) == 0) // Daha Yorum Yok
					$disabled = 'disabled ';
					
				$onClick = 'onclick = "sektorSorumlusuSubmit (1,'.$standart_id.')" ';
				$name  = 'name="gonder" ';
				$value = 'value="Yorumları Gönder" ';
				//$tree .= $inp.$name.$onClick.$value.$disabled." />";
				
				if ($taslak == 0){
				$onClick = 'onclick = "sektorSorumlusuSubmit (2,'.$standart_id.')" ';
				$name  = 'name="onayla" ';
				$value = 'value="Meslek Standardı Ön Taslağını Onayla" ';
				$tree .= $inp.$name.$onClick.$value." />";
				}
			}	
			
		}
		else if($durumId != PM_MESLEK_STANDART_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK && 
				$durumId != PM_MESLEK_STANDART_DURUMU__TASLAK &&
				$durumId != PM_MESLEK_STANDART_DURUMU__ULUSAL_STANDART
				) //KURULUS, SS Onayina gonderilmemis On Taslak ve Taslak olmayanlar
		{
			if ($durumId != PM_MESLEK_STANDART_DURUMU__ONAYLANMIS_ONTASLAK) //On Taslak Daha onaylanmamis
			{
				$onClick = 'onclick = "userSubmit (1,'.$standart_id.')" ';
				//$value = 'value="Tüm Taslağı Görüntüle / Bitir" ';
				$value = 'value="Ön Taslağı Sektör Sorumlusu İncelemesine Sun" ';
				
				$disabled = 'disabled';
				if (count($saved) >= $sayfa){
					$disabled = '';
				}
			}
			else // On Taslak onaylanip kurulusun bitirmesi icin sunulmus
			{
				$onClick = 'onclick = "userSubmit (2,'.$standart_id.')" ';
				$value = 'value="Tüm Taslağı Görüntüle  / Bitir" ';

				$disabled = '';
			}

			if ($onClick != ""){
				$name  = 'name="gonder" ';
				$tree .= $inp.$name.$value.$onClick.$disabled." />";
			}
		}
		
		
		$tree .= '</div>';
		
		for ($i = 0; $i < $sayfa; $i++){
			$style = 'style="margin: 1px;"';
			
			for ($j = 0; $j < count($saved); $j++){
				if ($saved[$j] == ($i+1)){
					$style	 = 'style="background-color:rgb(100,150,100);color:rgb(255,255,255); margin: 1px;"';
					break;
				}
			}
			$input = '<input type="button" onclick="goToPage(\''.$this->pages[$i].'\', '.$standart_id.')" class="btn" id="page'.$i.'" value="'.$this->pageNames[$i].'" ';
			if ($activeLayout == $this->pages[$i])
				$tree .= $input.$activeStyle.' />';
			else
				$tree .= $input.$style.' />'; 
		}
		
		$tree .= '<br /></div>';
		return $tree;
	}
	
	function getPageTreeYeni ($user, $activeLayout, $standart_id, $evrak_id, $taslak = 0){
		$isSektorSorumlusu = FormFactory::sektorSorumlusuMu ($user);
		$canEdit = $this->canEdit ($user, $standart_id);
		$activeStyle = 'style="background-color:rgb(170,0,0);color:rgb(255,255,255); margin: 1px;"';
		$sayfa = count ($this->pages);
		$saved = $this->getSavedPages ($evrak_id, $standart_id);
		$saved[count($saved)] = 0;
	
		$standartData = $this->getStandartInfo($standart_id);
		
		$standartDurumuPM = $standartData[0]["MESLEK_STANDART_DURUM_ADI"];
		$standartSurecDurumuPM = $standartData[0]["MESLEK_STANDART_SUREC_DURUM_ADI"];
		
		$tree = "<div style='font-size:22px; float: left; width:99%; font-size: 1em; font-weight: normal; line-height: normal; font-family: Arial,Helvetica,sans-serif; margin-left:50px; '>
		<big><b>Meslek Standartı:</b></big>
		<br><b>Adı - Seviyesi:</b> ".$standartData[0]["STANDART_ADI"]." - Seviye ".$standartData[0]["SEVIYE_ID"]." - Revizyon ".$standartData[0]["REVIZYON"]."
		<br><b>Durumu:</b> ".$standartDurumuPM."
		
		</div>";
		
		$tree .= '<div class="form_element" style="width:95%; text-align:center; padding-bottom: 15px;" >
				 <div style="padding-bottom:10px;">';
	
		$inp = '<input style="float:left; padding:5px; margin: 5px;" type="button" ';
		$value	 = "";
		$onClick = "";
		$disabled= "";
	
		$durumId = $this->getMeslekStandartDurumId ($standart_id);
		$surecdurumId = $this->getMeslekStandartSurecDurumId ($standart_id);
		if ($isSektorSorumlusu){
			if((false && $durumId != PM_MESLEK_STANDART_DURUMU__ULUSAL_STANDART && $surecdurumId != PM_MESLEK_STANDART_SUREC_DURUMU__KURULUSTAN_DUZELTME_ISTENDI) &&
			    $durumId != PM_MESLEK_STANDART_DURUMU__OLUSTURULMAMIS_ONTASLAK){
				$onClick = 'onclick = "sektorSorumlusuSubmit (2,'.$standart_id.')" ';
				$name  = 'name="onayla" ';
				$value = 'value="Kuruluşa Geri Gönder" ';
				$id = 'id="ontaslak_kurulusa_gonder" ';
				$tree .= $inp.$name.$id.$onClick.$value." />";
				
				$script .= 'jQuery("#ontaslak_kurulusa_gonder").live("click",function(){
									if(confirm("Meslek standardı ön taslağı kuruluşa geri gönderilecek emin misiniz ?")){
										sektorSorumlusuSubmit (4,'.$standart_id.');
									}
								});';
				
// 				$onClick = 'onclick = "sektorSorumlusuSubmit (2,'.$standart_id.')" ';
// 				$name  = 'name="onayla" ';
// 				$value = 'value="Meslek Standardı Ön Taslağını Onayla" ';
// 				$id = 'id="ontaslak_onayla" ';
// 				$tree .= $inp.$name.$id.$onClick.$value." />";
				
// 				$script .= 'jQuery("#ontaslak_onayla").live("click",function(){
// 									if(confirm("Meslek standardı ön taslağı onaylanacak emin misiniz ?")){
// 										sektorSorumlusuSubmit (3,'.$standart_id.');
// 									}
// 								});';
			}
		}
		else if($durumId != PM_MESLEK_STANDART_DURUMU__SS_ONAYINA_GONDERILMIS_ONTASLAK &&
		$durumId != PM_MESLEK_STANDART_DURUMU__TASLAK &&
		$durumId != PM_MESLEK_STANDART_DURUMU__ULUSAL_STANDART
		) 
		{
			if ($durumId != PM_MESLEK_STANDART_DURUMU__ONAYLANMIS_ONTASLAK) //On Taslak Daha onaylanmamis
			{
				$onClick = 'onclick = "" ';
				$value = 'value="Ön Taslağı Sektör Sorumlusu İncelemesine Sun" ';
				$id = 'id="ss_sun" ';
				$disabled = '';
				
				$script .= 'jQuery("#ss_sun").live("click",function(){
									if(confirm("Meslek standardı detayları Sektör Sorumlusunun incelemesine sunulanacak emin misiniz ?")){
										userSubmit (1,'.$standart_id.');
									}
								});';
			}
			else // On Taslak onaylanip kurulusun bitirmesi icin sunulmus
			{
				$onClick = 'onclick = "userSubmit (2,'.$standart_id.')" ';
				$value = 'value="Tüm Taslağı Görüntüle  / Bitir" ';
	
				$disabled = '';
			}
	
			if ($onClick != ""){
				$name  = 'name="gonder" ';
				$tree .= $inp.$name.$id.$value.$onClick.$disabled." />";
			}
		}
		$tree .= '</div>';
		$tree .= '<br /></div>';
		$tree .= '<script>'.$script.'</script>';
		return $tree;
	}
	
	function getSavedPages ($evrak_id, $standart_id){
		$db = & JFactory::getDBO();
		
		$sql = "SELECT saved_page FROM #__user_evrak 
				WHERE evrak_id= ".$evrak_id. " AND form_id = ".$standart_id;
		$db->setQuery($sql);
		$data = $db->loadResultArray();
		
		return $data;
	}
	function getMeslekStandardiByStandartID($standart_id)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT m_meslek_standartlari.*,
				      m_taslak_meslek.ILK_TASLAK_PDF,
					  m_taslak_meslek.RESMI_GORUS_ONCESI_PDF,
					  m_taslak_meslek.SEKTOR_KOMITESI_ONCESI_PDF,
					  m_taslak_meslek.YONETIM_KURULU_ONCESI_PDF,
					  m_taslak_meslek.SON_TASLAK_PDF 
				 FROM m_meslek_standartlari 
		   LEFT JOIN m_taslak_meslek
				   ON m_taslak_meslek.standart_id = m_meslek_standartlari.standart_id 
				WHERE m_meslek_standartlari.standart_id = ?";

		$params = array ($standart_id);
	
		$data = $_db->prep_exec($sql, $params);
	
		if (!empty($data))
		return $data[0];
		else
		return null;
	}
	
	
	function getMeslekStandartDurumId($standart_id)
	{
		$_db = &JFactory::getOracleDBO();
	
		$sql= "SELECT meslek_standart_durum_id FROM m_meslek_standartlari WHERE standart_id = ?";
	
		$params = array ($standart_id);
	
		$data = $_db->prep_exec($sql, $params);
		
		return $data[0]['MESLEK_STANDART_DURUM_ID'];
	}
	
	function getYorumDiv_SS ($evrak_id, $layout, $readOnly = true){
		$db = &JFactory::getOracleDBO();
		
		$sql= 'SELECT * FROM m_taslak_yorum WHERE STD_VEYA_YET_ID = ? 
		AND TASLAK_TIPI = '.PM_TASLAK_YORUM_TIPI__STANDART_YORUMU.' 
		AND SS_YORUMU_MU = 1 AND LAYOUT = ?';
		
		$params = array ($_GET['standart_id'], $layout);
		
		$data = $db->prep_exec($sql, $params);
		
		
		if ( !empty($data))
			$yorum = $data[0]['YORUM'];
		else if ( $readOnly == true)
			$yorum= 'Henüz Sektör Sorumlusu Tarafından Bir Yorum Bildirilmemiş.';
		
		$divText =  '<div style="padding-top:30px">
					<div class="form_item">
					  <div class="form_element cf_heading">
					  	<h1 class="contentheading">SEKTÖR SORUMLUSU YORUMLARI</h1>
					  </div>
					  <div class="cfclear">&nbsp;</div>
					</div>
					
					<div class="form_item">
						<div class="form_element cf_textarea"> ';
		
					if ( $readOnly != true)
						$divText .= '<textarea class="cf_inputbox" rows="5" 
						id="yorum" title="" cols="70" name="yorum">'.$yorum.'</textarea>';
					else
						$divText .= $yorum;
					
						$divText .= '</div>
						<div class="cfclear">&nbsp;</div>
					</div>
				</div>';
		
		return $divText;
	}
	function getYorumDiv_Kurulus ($evrak_id, $layout, $readOnly = true){
		$db = &JFactory::getOracleDBO();
		
		$sql= 'SELECT * FROM m_taslak_yorum WHERE STD_VEYA_YET_ID = ? 
		AND TASLAK_TIPI = '.PM_TASLAK_YORUM_TIPI__STANDART_YORUMU.' 
		AND SS_YORUMU_MU = 0 AND LAYOUT = ?';
		
		$params = array ($_GET['standart_id'], $layout);
		
		$data = $db->prep_exec($sql, $params);
		
		
		if ( !empty($data))
			$yorum = $data[0]['YORUM'];
		else
			$yorum= 'Henüz Kuruluş Tarafından Bir Yorum Bildirilmemiş.';
	
		$divText =  '<div style="padding-top:30px">
			<div class="form_item">
			<div class="form_element cf_heading">
			<h1 class="contentheading">KURULUŞ YORUMLARI</h1>
			</div>
			<div class="cfclear">&nbsp;</div>
			</div>
				
			<div class="form_item">
			<div class="form_element cf_textarea">';
		
			if ( !empty($data))
				$divText .= '<textarea class="cf_inputbox" rows="5" 
				id="yorum" title="" cols="70" name="yorum_Kurulus">'.$yorum.'</textarea>';
			else 
				$divText .= $yorum;
			
		$divText .= '</div>
			<div class="cfclear">&nbsp;</div>
			</div>
			</div>';
		
		return $divText;
	}
	function getHazirlayanValues ($taslak_meslek_id){
		$_db = &JFactory::getOracleDBO();

 		$sql= "SELECT TASLAK_MESLEK_ID,HAZIRLAYAN_ID,HAZIRLAYAN_KURULUS_ADI as KURULUS_ADI,KURULUS_TURU 
 			   FROM m_taslak_meslek_hazirlayan 
 			   WHERE taslak_meslek_id = ?
 			   ORDER BY hazirlayan_kurulus_adi";
		
		$params = array ($taslak_meslek_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getHazirlayanValues2 ($standart_id){
		$_db = &JFactory::getOracleDBO();

		$sql= "SELECT kurulus_adi,kurulus_turu
				FROM m_kurulus
				JOIN m_kurulus_yetki USING (user_id)
				JOIN m_yetki_standart USING (yetki_id)
				WHERE standart_id = ?
				ORDER BY kurulus_turu,kurulus_adi";
		
		$params = array ($standart_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	/**
	 * 
	 * Eger meslek standardi on taslagi henuz olusturulmamissa m_taslak_meslek gibi bazi
	 * tablolarda taslaga ait kayit bulunmayacagindan getHazirlayanValues( ) calismaz.
	 * Onun yerine dogrudan user_id kullanarak kurulus adina ulasilabilir.
	 * getKurulusValues() fonksiyonu bu amacla kullanilabilir.
	 * 
	 * @param $user_id
	 */
	function getKurulusValues($user_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT kurulus_adi, user_id
				FROM m_kurulus
				WHERE user_id = ?
				";
		
		$params = array($user_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getTerimValues ($id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT *
					   FROM M_TERIM,  m_standart_taslak_terim
			   WHERE m_standart_taslak_terim.taslak_id = ? and 
               m_standart_taslak_terim.terim_id = M_TERIM.terim_id
			   ORDER BY terim_adi";
		
		$params = array ($id);
		
		$data = $_db->prep_exec($sql, $params);
		
		$duzen = array();
		foreach($data as $row){
			$sql = "SELECT COUNT(*) AS SAY FROM M_STANDART_TASLAK_TERIM WHERE TERIM_ID=?";
			
			$ter = $_db->prep_exec($sql, array($row['TERIM_ID']));
			
			if($ter[0]['SAY']>1){
				$duzen[$row['TERIM_ID']] = false;
			}else{
				$duzen[$row['TERIM_ID']] = true;
			}
		}
		
		if (!empty($data))
			return array($data,$duzen);
		else
			return null;
	}
	
	
	function getMeslekTanitimValues ($taslak_meslek_id){
		$_db = &JFactory::getOracleDBO();
		$data = array ();
		
		$sql= "SELECT *
			   FROM m_taslak_meslek
			   WHERE taslak_meslek_id = ? ";
			
		$lobCol = array ("MESLEK_TANIM",
						 "MESLEK_SAGLIK_DUZENLEME",
						 "MESLEK_MEVZUAT",
						 "MESLEK_CALISMA_KOSUL",
						 "MESLEK_GEREKLILIK");
		
		$params = array ($taslak_meslek_id);
		
		for ($i = 0; $i < count($lobCol); $i++){
			$dataLob = $_db->prep_exec_clob($sql, $params, $lobCol[$i]);
			$data[$lobCol[$i]] = $dataLob;
		}
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getMeslekStandartValues ($taslak_meslek_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * 
			   FROM m_taslak_meslek_standart 
			   WHERE taslak_meslek_id = ? 
			   ORDER BY standart_adi";
		
		$params = array ($taslak_meslek_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getEkipmanValues ($taslak_meslek_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * 
			   FROM m_taslak_meslek_ekipman 
			   WHERE taslak_meslek_id = ? 
			   ORDER BY ekipman_adi";
		
		$params = array ($taslak_meslek_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getBilgiBeceriValues ($taslak_meslek_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * 
			   FROM m_taslak_meslek_bilgi_beceri 
			   WHERE taslak_meslek_id = ? 
			   ORDER BY bilgi_beceri_adi";
		
		$params = array ($taslak_meslek_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getTutumDavranisValues ($taslak_meslek_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * 
			   FROM m_taslak_meslek_tutum 
			   WHERE taslak_meslek_id = ? 
			   ORDER BY tutum_davranis_adi";
		
		$params = array ($taslak_meslek_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getGorevAlanValues ($taslak_meslek_id, $gorev_tur){
		$_db = &JFactory::getOracleDBO();
		
		switch($gorev_tur){
			case 3: 
				$orderBySql = "ORDER BY gorev_alan_kurulus";
				break;
			default:
				$orderBySql = "ORDER BY gorev_alan_id, gorev_alan_tur_id";
				break;
		}
		
		$sql= "SELECT * 
			   FROM m_taslak_meslek_gorev_alan 
			   WHERE taslak_meslek_id = ".$taslak_meslek_id." AND gorev_alan_tur_id = ".$gorev_tur."
			   ".$orderBySql ;
		
//		$params = array ($taslak_meslek_id, $gorev_tur);
		
		$data = $_db->prep_exec($sql, array());
        
//    	echo $sql."-".$taslak_meslek_id."-". $gorev_tur."<pre>";
//    	print_r($data);
//    	echo "</pre>";
//if ($gorev_tur==5){exit;}
//	echo "g".$gorev_tur."-";	
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getYonetimKuruluValues ($taslak_meslek_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= " SELECT * FROM M_TASLAK_MESLEK_GOREV_ALAN WHERE gorev_alan_tur_id=5 and TASLAK_MESLEK_ID=".$taslak_meslek_id;
		$params = array();
//		$tarihdata = $_db->prep_exec($sql, $params);
//		if(!empty($tarihdata)){
//			for($i=0; $i<count($tarihdata); $i++)
//			{
//				$tarih = $tarihdata[$i]['BASLANGIC_TARIHI'];
//			}
//			$sql = "SELECT *
//					FROM M_YONETIM_KURULU
//					WHERE M_YONETIM_KURULU.ETKINLIK_BASLANGIC_TARIHI < ?
//					AND NVL(M_YONETIM_KURULU.ETKINLIK_BITIS_TARIHI, CURRENT_DATE) > ?";
//			$params = array($tarih, $tarih);
			return $_db->prep_exec($sql, $params);
	}
	
	function getProfilValues ($taslak_meslek_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT * 
			   FROM m_taslak_meslek_profil 
			   WHERE taslak_meslek_id = ? 
			   ORDER BY sira,profil_id";
		
		$params = array ($taslak_meslek_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getCurrentEvrakId ($post, $basvuru_tip, $standart_id){
		$session = &JFactory::getSession();
		
		$evrak_id = $session->get("evrak_id");			 		//Kaydetme sayfasindan geldiyse
	
		if (!isset($evrak_id)){
			if (isset ($post["evrak_id"])) 	  		 			//Sayfa arasinda dolaniyorsa
				$evrak_id = $post["evrak_id"];
			else												//Sayfa yeni acildiysa
				$evrak_id = $this->getEvrakId($basvuru_tip, $standart_id); //MYSQL
		}else{
			$session->clear("evrak_id");
		}
		
		return $evrak_id;
	}
	
	function getEvrakId($basvuru_tip, $standart_id){
		$_db = &JFactory::getDBO();
		
		$sql = "SELECT evrak_id FROM #__user_evrak 
				WHERE basvuru_tur= ".$basvuru_tip." AND 
					  form_id = ".$standart_id;
		
		$_db->setQuery($sql);
		$data = $_db->loadRow();
		
		if ( !empty($data))
			return $data[0];
		else
			return -1;
	}
	
	function getOracleEvrakId ($standart_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT evrak_id 
			   FROM m_taslak_meslek 
			   WHERE standart_id = ?";
		
		$params = array ($standart_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return -1;
	}
	
	function getTaslakMeslekId ($evrak_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT taslak_meslek_id 
			   FROM m_taslak_meslek 
			   WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
    function getStandartBilgi(){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT standart_adi,seviye_id,meslek_standart_durum_adi 
			   FROM m_meslek_standartlari 
			   join pm_meslek_standart_durum using(meslek_standart_durum_id) join pm_meslek_standart_surec_durum using(meslek_standart_surec_durum_id)
			   WHERE standart_id= ".JRequest::getVar("standart_id");
		
		$data = $_db->prep_exec($sql, array ());
//         echo "
//         <div style='margin-left:40px;'>
//         <b><big>Standartın;</big></b><br>
//         <b>Adı-Seviyesi:</b> ".$data[0]["STANDART_ADI"]." - ".$data[0]["SEVIYE_ID"].". Seviye<br>";
//         echo "<b>Durumu:</b> ".$data[0]["MESLEK_STANDART_DURUM_ADI"]
//         ."</div>";

		return "<div style='margin-left:40px;'>
        <b><big>Standartın;</big></b><br>
        <b>Adı-Seviyesi:</b> ".$data[0]["STANDART_ADI"]." - ".$data[0]["SEVIYE_ID"].". Seviye<br>
        <b>Durumu:</b> ".$data[0]["MESLEK_STANDART_DURUM_ADI"]
		."</div>";
    }
	function getMeslekStandardiDurumId ($standart_id){
		$_db = &JFactory::getOracleDBO();
	
		$sql = "SELECT meslek_standart_durum_id FROM m_meslek_standartlari WHERE standart_id = ?";
			$params = array($standart_id);
		$data = $_db->prep_exec_array($sql, $params);
	
		if (!empty($data))
			return $data[0];
		else
			return PM_MESLEK_STANDART_DURUMU__BASVURU;
	}
	function getMeslekStandartSurecDurumId ($standart_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT MESLEK_STANDART_SUREC_DURUM_ID FROM m_meslek_standartlari WHERE standart_id = ?";
		$params = array ($standart_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		return $data[0];	
	}
	
	function getYorumDurumId_SS ($evrak_id){
		$_db = &JFactory::getDBO();
		
		$sql = "SELECT yorum_durum FROM #__taslak_yorum 
				WHERE evrak_id = ".$evrak_id." AND  ss_yorumu_mu = 1 
				ORDER BY yorum_durum DESC";
		$_db->setQuery($sql);
		$data = $_db->loadRow();
		
		if ( !empty($data))
			return $data[0];
		else
			return -1;
	}
	
	function getSayfa ($layout){
		for ($i = 0; $i < count($this->pages); $i++){
			if ($this->pages[$i] == $layout)
				break;
		}
		
		return $i+1;
	}
	
	function getYorumCount_SS ($evrak_id){
		$_db = &JFactory::getDBO();
		
		$sql = "SELECT count(*) FROM #__taslak_yorum 
				WHERE evrak_id = ".$evrak_id." AND ss_yorumu_mu = 1";
		$_db->setQuery($sql);
		$data = $_db->loadRow();
		
		return $data[0];
	}

	function isTaslak ($standart_id){
		
		$_db = &JFactory::getOracleDBO();
		$sql = "SELECT meslek_standart_durum_id
						FROM m_meslek_standartlari
						WHERE standart_id = ?";
		
		$params = array ($standart_id);
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0]["meslek_standart_durum_id"] == PM_MESLEK_STANDART_DURUMU__TASLAK;
		else
			return 0;
		
	}
	
	function getMeslekStandart ($user_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT STANDART_ID, 
					  STANDART_ADI, 
			    	  SEKTOR_ADI, 
			 		  SEVIYE_ADI,
			 		  MESLEK_STANDART_DURUM_ID,
					  REVIZYON,
					  BASLANGIC_TARIHI,
					  MESLEK_STANDART_DURUM_ADI,
					  STANDART_SUREC_DURUM_ADI
			   FROM m_meslek_standartlari
			   		JOIN m_yetki_standart USING(standart_id)
			   		JOIN m_yetki USING (yetki_id)
			   		JOIN m_kurulus_yetki USING (yetki_id)
			   		JOIN pm_seviye USING (seviye_id)
			   		JOIN pm_sektorler USING (sektor_id)
			   	JOIN pm_meslek_standart_durum USING (MESLEK_STANDART_DURUM_ID)	
				JOIN pm_meslek_standart_surec_durum USING (MESLEK_STANDART_SUREC_DURUM_ID)
			   	WHERE user_id = ?
			   		  AND m_yetki.ETKIN = 1
			   		  AND meslek_standart_durum_id IN (".PM_MESLEK_STANDART_DURUMU__ONTASLAK.")
			   		  order by standart_adi	
		";
		
		$params = array ($user_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data;
		else
			return null;
	}
	
	function getStandartId ($evrak_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT standart_id 
			   FROM m_taslak_meslek   
			   WHERE evrak_id = ?";
		
		$params = array ($evrak_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	function canEdit ($user, $standart_id){
		$juser 	= &JFactory::getUser();
		$user_id= $juser->getOracleUserId ();
		$isSektorSorumlusu  = FormFactory::sektorSorumlusuMu ($user);	
		$isYetkiliSektorSorumlusu  = FormFactory::getSorumluSektorId ($user_id, 2);	
		$isKurulus			= $this->yetkiliMeslekStandartKurulusuMu ($user);
		$standart_durum 	  = $this->getMeslekStandardiDurumId ($standart_id);	
		$editable			  = $this->getEditable ($standart_id);
		$standart_surec_durum = $this->getMeslekStandartSurecDurumId ($standart_id);
		$revizyonYetkisiVarMi = $this->getRevizyonYetkisiVarMi($user, $standart_id);
		
	 	// Sektor Sorumlusu
		if ($isSektorSorumlusu){
			return true;
		}
		else // Kurulus
		{
			if ($editable == 0)
			{
				return false;
			}
			else //editable da
			{
				if ($isKurulus)
				{
					//On Basvuru Bitirme asamasindaysa
					if ($standart_durum 	== PM_MESLEK_STANDART_DURUMU__ONAYLANMIS_ONTASLAK){
						return false;
					}
					else if($standart_durum 	== PM_MESLEK_STANDART_DURUMU__ULUSAL_STANDART)
					{
						return $revizyonYetkisiVarMi;
					}
								
					return true;
				}else{
					return false;
				}
			}
		}

	}
	
	
	function getRevizyonYetkisiVarMi($user, $standart_id)
	{
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT COUNT(*)
		FROM m_standart_revizyon
		WHERE standart_id = ?";
		
		$params = array ($standart_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		$revNo = $data[0];
		
		$sql= "SELECT *
		FROM m_yetki_standart
		WHERE standart_id = ?, user_id=?, revizyon_no=?";
		
		$params = array ( $standart_id, $user_id, $revNo );
		
		$result = $_db->prep_exec_array($sql, $params);
		
		if(count($result)==1)
			return true;
		else 
			return false;
		
	}
	
	function getEditable ($standart_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql= "SELECT editable  
			   FROM m_taslak_meslek   
			   WHERE standart_id = ?";
		
		$params = array ($standart_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return 1;
	}
	
	function yetkiliMeslekStandartKurulusuMu ($user){
		return FormFactory::checkAclGroupId($user->id, YT1_GROUP_ID);
	}

	function getYonetimKuruluTarihleri ($etkin){
    	$db = JFactory::getOracleDBO();		
    	$sql = "SELECT distinct tarih
    			FROM M_YONETIM_KURULU
                WHERE etkin='".$etkin."'
                ORDER BY tarih desc";
    	
    	return $db->prep_exec($sql, array());
	}
    
	function getGenelKurulTarihleri (){
    	$db = JFactory::getOracleDBO();		
    	$sql = "SELECT distinct tarih
    			FROM M_GENEL_KURUL
                ORDER BY tarih desc";
    	
    	return $db->prep_exec($sql, array());
	}
    
	function getKomiteTarihleri ($standart_id){
		$_db = &JFactory::getOracleDBO();
		$sql= "SELECT  distinct k.tarih,k.sektor_id
    			FROM M_SEKTOR_KOMITELERI k, m_meslek_standartlari s
                WHERE s.sektor_id=k.sektor_id AND s.standart_id = ?
                ORDER BY k.tarih desc";
		$params = array ($standart_id);
		
		return $_db->prep_exec($sql, $params);
//		echo $sql."<pre>";
//        print_r($data);
//        echo "</pre>";
//        exit;
	}
	
	function aktifYetkilendirmesiVarMi($standart_id, $user_id)
	{
		
		$_db = &JFactory::getOracleDBO();
		$sql= "SELECT * FROM M_YETKI_STANDART JOIN M_YETKI USING (YETKI_ID) JOIN M_KURULUS_YETKI USING (YETKI_ID)
WHERE ETKIN=1 AND STANDART_ID = ? AND USER_ID = ?";
		$params = array ($standart_id, $user_id);
		
		if(count($_db->prep_exec($sql, $params)) > 0) 
			return true;
		else
			return false;
	}
	
	function getTerims($post){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT COUNT(*) AS SAY FROM M_STANDART_TASLAK_TERIM WHERE TERIM_ID=?";
		
		$ter = $_db->prep_exec($sql, array($post['terimId']));
		
		if($ter[0]['SAY']>1){
			return false;
		}
		else{
			$sql = "SELECT * FROM M_TERIM WHERE TERIM_ID = ?";
			return $_db->prep_exec($sql, array($post['terimId']));
		}
	}
	
    function getStandartRevizyonBilgi($standart_id)
    {
        $_db = &JFactory::getOracleDBO();

        $sql = "SELECT STANDART_KODU,
					  REVIZYON_NO,
					  SEKTOR_ADI, 
					  TO_CHAR (REVIZYON_TARIHI, 'dd.mm.yyyy') REVIZYON_TARIHI,
					  TO_CHAR (KARAR_TARIHI	  , 'dd.mm.yyyy') KARAR_TARIHI,
					  KARAR_SAYI, 
					  TO_CHAR (RESMI_GAZETE_TARIH, 'dd.mm.yyyy') RESMI_GAZETE_TARIH,
					  RESMI_GAZETE_SAYI  
			   FROM m_meslek_standartlari 
			   	  JOIN m_taslak_meslek USING (standart_id) 
			   	  JOIN pm_sektorler USING (sektor_id) 
			   WHERE standart_id = ?";

        $params = array($standart_id);

        $data = $_db->prep_exec($sql, $params);
        $sql2="SELECT revizyon_no,
        TO_CHAR (RESMI_GAZETE_TARIH, 'dd.mm.yyyy') AS RESMI_GAZETE_TARIH,
        TO_CHAR (REVIZYON_TARIHI, 'dd.mm.yyyy') REVIZYON_TARIHI,
        TO_CHAR (YKK_TARIHI	  , 'dd.mm.yyyy') KARAR_TARIHI
        FROM m_standart_revizyon WHERE standart_id = '$standart_id'  ORDER BY revizyon_no desc";
        $sonuc2=$_db->prep_exec($sql2, array ());
        
        
        if ($sonuc2[0]["REVIZYON_NO"]){
        	$data[0]["REVIZYON_NO"]=$sonuc2[0]["REVIZYON_NO"];
        	$data[0]["RESMI_GAZETE_TARIH"]=$sonuc2[0]["RESMI_GAZETE_TARIH"];
        	$data[0]["REVIZYON_TARIHI"]=$sonuc2[0]["REVIZYON_TARIHI"];
        	$data[0]["KARAR_TARIHI"]=$sonuc2[0]["KARAR_TARIHI"];
        }
        
        if (!empty($data))
            return $data[0];
        else
            return null;
    }
    
    function getStandartBilgiWord ($standart_id){
    	$db = &JFactory::getOracleDBO();
    	 
    	$sql = "SELECT  STANDART_ADI,
    					SEVIYE_ADI,
    					STANDART_KODU,
    					REVIZYON_NO,
    					TO_CHAR (KARAR_TARIHI, 'dd.mm.yyyy') AS KARAR_TARIHI,
    					TO_CHAR (RESMI_GAZETE_TARIH, 'yyyy') AS RESMI_GAZETE_TARIH
    			FROM M_MESLEK_STANDARTLARI
    				JOIN PM_SEVIYE USING (SEVIYE_ID)
    				JOIN M_TASLAK_MESLEK USING (STANDART_ID)
    			WHERE STANDART_ID = ?";
    	$data=$db->prep_exec($sql, array ($standart_id));
    
    	$sql2="SELECT revizyon_no,
    	TO_CHAR (RESMI_GAZETE_TARIH, 'dd.mm.yyyy') AS RESMI_GAZETE_TARIH,
    	TO_CHAR (REVIZYON_TARIHI, 'dd.mm.yyyy') REVIZYON_TARIHI,
    	TO_CHAR (YKK_TARIHI	  , 'dd.mm.yyyy') KARAR_TARIHI
    	FROM m_standart_revizyon WHERE standart_id = '$standart_id'  ORDER BY revizyon_no desc";
    	$sonuc2=$db->prep_exec($sql2, array ());
    
    
    	if ($sonuc2[0]["REVIZYON_NO"]){
    		$data[0]["REVIZYON_NO"]=$sonuc2[0]["REVIZYON_NO"];
    		$data[0]["RESMI_GAZETE_TARIH"]=$sonuc2[0]["RESMI_GAZETE_TARIH"];
    		$data[0]["REVIZYON_TARIHI"]=$sonuc2[0]["REVIZYON_TARIHI"];
    		$data[0]["KARAR_TARIHI"]=$sonuc2[0]["KARAR_TARIHI"];
    	}
    	return $data;
    }
    
    function getStandartSeviye($standart_id)
    {
    	$db = &JFactory::getOracleDBO();
    
    	$sql = "SELECT standart_adi, seviye_adi, seviye_id
				FROM m_meslek_standartlari
					JOIN pm_seviye USING (seviye_id)
				WHERE standart_id = ?";
    
    	$params = array($standart_id);
    
    	$data = $db->prep_exec($sql, $params);
    	return $data[0];
    }
    
    function getKurulusAdFromStandartID($standart_id)
    {
    	$db = &JFactory::getOracleDBO();
    
    	$sql = "SELECT * FROM m_meslek_standartlari JOIN m_yetki_standart USING (standart_id) JOIN M_kurulus_yetki USING (yetki_id) JOIN M_KURULUS USING (USER_ID)
WHERE STANDART_ID = ? AND kurulus_turu = 1";
    
    	$params = array($standart_id);
    
    	$data = $db->prep_exec($sql, $params);
    	return $data[0]["KURULUS_ADI"];
    }
    
    function getStandartInfo($standart_id)
    {
    	$_db = &JFactory::getOracleDBO();
    
    	$sql= "SELECT * FROM m_meslek_standartlari join pm_meslek_standart_durum using(meslek_standart_durum_id) join pm_meslek_standart_surec_durum using(meslek_standart_surec_durum_id)
				WHERE STANDART_ID = ?";

    	$params = array ($standart_id);
    
    	$data = $_db->prep_exec($sql, $params);
    
    	if (!empty($data))
    		return $data;
    	else
    		return null;
    }
    
    function getStandartDurum($revizyon_mu){
    	$_db = &JFactory::getOracleDBO();
    	$_db = &JFactory::getOracleDBO();
    	if ($revizyon_mu==1){
    		$sqlpart="pm_MESLEK_STANDART_REVIZYON_SUREC";
    	} else {
    		$sqlpart="pm_MESLEK_STANDART_SUREC_DURUM";
    	}
   
    	$sql= "SELECT *
			   FROM ".$sqlpart."
			   WHERE MESLEK_STANDART_SUREC_DURUM_id != ".PROTOKOL_LISTE_REDDEDILMIS_STANDART."
			   ORDER BY SIRA";
    
    	return $_db->loadList($sql);
    }
    
    function getTaslakBilgi ($standart_id){ 
    	$_db = &JFactory::getOracleDBO();
    
    	$sql= "SELECT m_taslak_meslek.* FROM m_taslak_meslek WHERE standart_id = ?";
    	$params = array ($standart_id);
    
    	$data = $_db->prep_exec($sql, $params);
    
    	if (!empty($data))
    		return $data[0];
    	else
    		return null;
    }
}
?>
