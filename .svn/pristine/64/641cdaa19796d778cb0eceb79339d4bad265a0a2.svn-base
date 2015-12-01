<?php
defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/functions.php');

class ItembankModelSorulari_listele extends JModel {
	var $title 		= "MYK Portal Itembank"; 
	
	function ara()
	{
		$db = JFactory::getOracleDBO();
		
		if ($this->kullaniciTipi()==1){
			$user=JFactory::getUser();
			$user_id=$user->id;			
//			$kullaniciSql= " AND M_ITEMBANK_SORULAR.ITEMBANK_USER_ID='".$user_id."'";
			$sql="select kurulus_id from m_itembank_kurulus_users where user_id=".$user_id;
			$result= $db->prep_exec_array($sql);
			$kurulus_user_id=$result[0];
			$kullaniciSql= " AND KURULUS_USER_ID='".$kurulus_user_id."'";				
			$condition=true;
		}
		
		
		if ($this->kullaniciTipi()==2 and $_POST["kurulus_id"]!=""){
			$kurulusSql= " AND KURULUS_USER_ID = ".$_POST["kurulus_id"]."";
			$condition=true;
		}
		
		
		
		if ($_POST["sektor"]!="" and $_POST["seviye"]=="" and $_POST["yeterlilik_id"]==""){
			$sql="select yeterlilik_id from m_yeterlilik where sektor_id=".$_POST["sektor"];
			$result= $db->prep_exec($sql, $array);
			foreach ($result as $arr){
				$yeterlilik_Ids[]=$arr["YETERLILIK_ID"];
			}
			$yeterlilik_Ids=implode(",",$yeterlilik_Ids);
		}
		
			
/*		if ($_POST["sektor"]!="" and $_POST["seviye"]!="" and $_POST["yeterlilik_id"]==""){
			$sql="select yeterlilik_id from m_yeterlilik where sektor_id=".$_POST["sektor"]." and seviye_id=".$_POST["seviye"];
			$result= $db->prep_exec($sql, $array);
			foreach ($result as $arr){
				$yeterlilik_Ids[]=$arr["YETERLILIK_ID"];
			}
			$yeterlilik_Ids=implode(",",$yeterlilik_Ids);
		}*/
		
		if ($yeterlilik_Ids){
			$sektorSeviyeSql= " AND (YETERLILIK_ID_NULLABLE IS NULL OR YETERLILIK_ID_NULLABLE IN (".$yeterlilik_Ids."))";
			$condition=true;
		}
		
		if ($_POST["yeterlilik_id"]!=""){
			$yeterlilik_id=explode("-",$_POST["yeterlilik_id"]);
			$yeterlilikSql= " AND YETERLILIK_ID_2 = ".$yeterlilik_id[0]."";
			$condition=true;
		}
		
		if ($_POST["birim_id"]!=""){
			$birimSql= " AND BIRIM_ID = ".$_POST["birim_id"]."";
			$condition=true;
		}
		
		if ($_POST["basarim_olcutu_id"]!=""){
			$basarimOlcutuSql= " AND BASARIM_OLCUTU_ID = ".$_POST["basarim_olcutu_id"]."";
			$condition=true;
		}
		
		if ($_POST["ogrenme_ciktisi_id"]!=""){
			$ogrenmeCiktisiSql= " AND OGRENME_CIKTISI_ID = ".$_POST["ogrenme_ciktisi_id"]."";
			$condition=true;
		}
		
			
		if ($_POST["soru_grubu_id"]!=""){
			$soruTipiSql= " AND SORU_TIPI_ID = ".$_POST["soru_grubu_id"]."";
			$condition=true;
			if ($_POST["soru_tipi_id_p"]!=""){
				$soruSekliSql= " AND SORU_SEKLI_ID = ".$_POST["soru_tipi_id_p"]."";
				$condition=true;
			}
			
			if ($_POST["soru_tipi_id"]!=""){
				$soruSekliSql= " AND SORU_SEKLI_ID = ".$_POST["soru_tipi_id"]."";
				$condition=true;
			}
		
			
		}
		
		
		if ($_POST["turkak_onayli_mi"]!=""){
			$turkakSql= " AND TURKAK_ONAYLI_MI = ".$_POST["turkak_onayli_mi"]."";
			$condition=true;
		}
		
		
		if ($_POST["zorluk_derecesi_id"]!=""){
			$zorlukDerecesiSql= " AND ZORLUK_DERECESI_ID = ".$_POST["zorluk_derecesi_id"]."";
			$condition=true;
		}
		
		if ($_POST["bilgiBeceriYetkinlik_id"]!=""){
			$bilgiBeceriYetkinlikSql= " AND BECERI_YETKINLIK_ID IN ( ".implode(',', $_POST["bilgiBeceriYetkinlik_id"]).")";
			$condition=true;
		}
		
		if ($_POST["durum_id"]!=""){
			$durumSql= " AND DURUM_ID = ".$_POST["durum_id"]."";
			$condition=true;
		}
		
		
			if ($_POST["soru_metni"]!=""){
				
			$soruMetniSql= " AND SORU_METNI LIKE '%".$_POST["soru_metni"]."%'";
			$condition=true;
		}
		
		if ($_POST["s_baslangic_tarihi"]!=""){
			$sBasTarihSql= " AND KAYIT_TARIHI>= ".strtotime($_POST["s_baslangic_tarihi"])."";
			$condition=true;
		}
		
			
		if ($_POST["s_bitis_tarihi"]!=""){
			$sBitTarihSql= " AND KAYIT_TARIHI<= ".(strtotime($_POST["s_bitis_tarihi"])+24*60*60)."";
			$condition=true;
		}
		
			
		if ($_POST["o_baslangic_tarihi"]!=""){
			$oBasTarihSql= " AND OLUSTURMA_TARIHI>= '".$_POST["o_baslangic_tarihi"]."'";
			$condition=true;
		}
		
		
		if ($_POST["o_bitis_tarihi"]!=""){
			$oBitTarihSql= " AND OLUSTURMA_TARIHI<= '".$_POST["o_bitis_tarihi"]."'";
			$condition=true;
		}
		
				
		if ($_POST["kurulus_soru_kodu"]!=""){				
			$kurulusSorukoduSql= " AND KURULUS_SORU_KODU= '".$_POST["kurulus_soru_kodu"]."'";
			$condition=true;
		}
		
		$sql = "SELECT DISTINCT 
					SORU_ID,
					YETERLILIK_ID_2, 
					SEKTOR_ADI,
					KURULUS_ADI,
					YENI_MI,
					SEVIYE_ID,
					YETERLILIK_KODU,
					BASARIM_OLCUTU_ID,
                    BASARIM_OLCUTU_ADI,         
					SORU_DURUM_ADI,
					SORU_DURUM_ID,
					TURKAK_ONAYLI_MI,
					ONAYLAYAN,
					OLUSTURAN,
					KAYIT_TARIHI,
					SON_GUNCELLEYEN_ID,
					SON_GUNCELLEME_TARIHI,
					M_ITEMBANK_SORULAR.OLUSTURMA_TARIHI as OLUSTURMA_TARIHI,
                                       
                    case when SORU_TIPI_ID=1 then
                      PM_ITEMBANK_TEORIK_SORU_SEKLI.SORU_SEKLI_ADI
                     when SORU_TIPI_ID=2 then
	                  PM_ITEMBANK_PRATIK_SORU_SEKLI.SORU_SEKLI_ADI
                     end as SORU_SEKLI_ADI,

                    SORU_TIPI_ID,
                    SORU_TIPI_ADI
                                        
		
		FROM M_ITEMBANK_SORULAR
		JOIN M_YETERLILIK USING (YETERLILIK_ID)
		JOIN PM_SEKTORLER USING (SEKTOR_ID)
		JOIN PM_ITEMBANK_SORU_TIPI USING (SORU_TIPI_ID)
		JOIN PM_ITEMBANK_SORU_DURUMU ON (M_ITEMBANK_SORULAR.DURUM_ID = PM_ITEMBANK_SORU_DURUMU.SORU_DURUM_ID)
		LEFT JOIN (SELECT YETERLILIK_ID AS YETERLILIK_ID_NULLABLE, BIRIM_ID from M_YETERLILIK_BIRIM myb) ON (YETERLILIK_ID = YETERLILIK_ID_NULLABLE)
		LEFT JOIN M_BIRIM USING (BIRIM_ID)
		LEFT JOIN M_ITEMBANK_SORU_BO USING (SORU_ID)
		LEFT JOIN M_BASARIM_OLCUTU USING (BASARIM_OLCUTU_ID)
		LEFT JOIN M_OGRENME_CIKTISI__BASARIM_OLC USING (BASARIM_OLCUTU_ID)
		LEFT JOIN M_OGRENME_CIKTISI USING (OGRENME_CIKTISI_ID)
		LEFT JOIN M_ITEMBANK_SORU_BECERI_YETK USING (SORU_ID)
		LEFT JOIN M_YETER_BECERI_YETKINLIK USING (BECERI_YETKINLIK_ID)
		JOIN M_KURULUS ON (M_ITEMBANK_SORULAR.KURULUS_USER_ID=M_KURULUS.USER_ID)
		LEFT JOIN PM_ITEMBANK_TEORIK_SORU_SEKLI USING (SORU_SEKLI_ID)
		LEFT JOIN PM_ITEMBANK_PRATIK_SORU_SEKLI USING (SORU_SEKLI_ID)
		LEFT JOIN (SELECT SORU_ID, YETERLILIK_ID AS YETERLILIK_ID_2 FROM M_ITEMBANK_SORULAR ) USING (SORU_ID)
		WHERE SORU_ID IS NOT NULL
		";
		if ($condition){
			$allTheConditions = $bilgiBeceriYetkinlikSql.$kullaniciSql.$sektorSeviyeSql.$yeterlilikSql.$birimSql.$ogrenmeCiktisiSql.$turkakSql.$basarimOlcutuSql.$soruMetniSql.$soruSekliSql.$soruTipiSql.$zorlukDerecesiSql.$kurulusSql.$durumSql.$sBasTarihSql.$sBitTarihSql.$oBasTarihSql.$oBitTarihSql.$kurulusSorukoduSql;
			$sql=$sql.$allTheConditions;
		}
		
		
		$result= $db->prep_exec($sql, $array);
		for ($i=0;$i<count($result);$i++){
			$this->getYeterlilikDataFromSoruID($result[$i]["SORU_ID"], $result[$i]['YETERLILIK_ID'], $result[$i]['YETERLILIK_ADI']);
			$result[$i]["icerik"]=$this->soruGoster($result[$i]["SORU_ID"]);		
			$result[$i]["KAYIT_TARIHI"]=date("d.m.Y",$result[$i]["KAYIT_TARIHI"]);
			if ($result[$i]["SON_GUNCELLEME_TARIHI"]!=""){	
				$result[$i]["SON_GUNCELLEME_TARIHI"]=date("d.m.Y",$result[$i]["SON_GUNCELLEME_TARIHI"]);
				$mysql=mysql_query("select name from jos_users where id=".$result[$i]["SON_GUNCELLEYEN_ID"]);
				$liste=mysql_fetch_row($mysql);
				$result[$i]["SON_GUNCELLEYEN_ID"]=$liste[0];
			}else {
				$result[$i]["SON_GUNCELLEME_TARIHI"]="Güncelleme yapılmamış.";
				$result[$i]["SON_GUNCELLEYEN_ID"]="Güncelleme yapılmamış.";
			}	
			
			if($result[$i]["YENI_MI"]=='0')//eski format, yani beceri yetkinliklerini bul
				$result[$i]["BECERI_YETKINLIK"] = $this->getBeceriYetkinlikData($result[$i]["SORU_ID"]);
		}
		if(count($result) > 0)
			ajax_success_response_with_array('Sorgu başarılı', $result);
		else
			ajax_error_response("Hatayla karşılaşıldı");
		
	}
	
	//ASIL ARA FONKSIYONU
	function ara2(){
		$db = JFactory::getOracleDBO();
		
		if ($this->kullaniciTipi()==1){
			$user=JFactory::getUser();
			$user_id=$user->id;			
//			$kullaniciSql= " AND M_ITEMBANK_SORULAR.ITEMBANK_USER_ID='".$user_id."'";
			$sql="select kurulus_id from m_itembank_kurulus_users where user_id=".$user_id;
			$result= $db->prep_exec_array($sql);
			$kurulus_user_id=$result[0];
			$kullaniciSql= " AND M_ITEMBANK_SORULAR.KURULUS_USER_ID='".$kurulus_user_id."'";				
			$condition=true;
		}
		
		
		if ($this->kullaniciTipi()==2 and $_POST["kurulus_id"]!=""){
			$kurulusSql= " AND M_ITEMBANK_SORULAR.KURULUS_USER_ID = ".$_POST["kurulus_id"]."";
			$condition=true;
		}
		
		
		
		if ($_POST["sektor"]!="" and $_POST["seviye"]=="" and $_POST["yeterlilik_id"]==""){
			$sql="select yeterlilik_id from m_yeterlilik where sektor_id=".$_POST["sektor"];
			$result= $db->prep_exec($sql, $array);
			foreach ($result as $arr){
				$yeterlilik_Ids[]=$arr["YETERLILIK_ID"];
			}
			$yeterlilik_Ids=implode(",",$yeterlilik_Ids);
		}
		
			
		if ($_POST["sektor"]!="" and $_POST["seviye"]!="" and $_POST["yeterlilik_id"]==""){
			$sql="select yeterlilik_id from m_yeterlilik where sektor_id=".$_POST["sektor"]." and seviye_id=".$_POST["seviye"];
			$result= $db->prep_exec($sql, $array);
			foreach ($result as $arr){
				$yeterlilik_Ids[]=$arr["YETERLILIK_ID"];
			}
			$yeterlilik_Ids=implode(",",$yeterlilik_Ids);
		}
		
		if ($yeterlilik_Ids){
			$sektorSeviyeSql= " AND M_ITEMBANK_SORULAR.YETERLILIK_ID IN (".$yeterlilik_Ids.")";
			$condition=true;
		}
		
		if ($_POST["yeterlilik_id"]!=""){
			$yeterlilik_id=explode("-",$_POST["yeterlilik_id"]);
			$yeterlilikSql= " AND M_ITEMBANK_SORULAR.YETERLILIK_ID = ".$yeterlilik_id[0]."";
			$condition=true;
		}
		
		if ($_POST["birim_id"]!=""){
			$birimSql= " AND M_ITEMBANK_SORU_BO.BIRIM_ID = ".$_POST["birim_id"]."";
			$condition=true;
		}
		
		if ($_POST["basarim_olcutu_id"]!=""){
			$basarimOlcutuSql= " AND M_ITEMBANK_SORU_BO.BASARIM_OLCUTU_ID = ".$_POST["basarim_olcutu_id"]."";
			$condition=true;
		}
		
			if ($_POST["ogrenme_ciktisi_id"]!=""){
			$ogrenmeCiktisiSql= " AND M_ITEMBANK_SORU_BO.OGRENME_CIKTISI_ID = ".$_POST["ogrenme_ciktisi_id"]."";
			$condition=true;
		}
		
			
		if ($_POST["soru_grubu_id"]!=""){
			$soruTipiSql= " AND M_ITEMBANK_SORULAR.SORU_TIPI_ID = ".$_POST["soru_grubu_id"]."";
			$condition=true;
			if ($_POST["soru_tipi_id_p"]!=""){
				$soruSekliSql= " AND M_ITEMBANK_SORULAR.SORU_SEKLI_ID = ".$_POST["soru_tipi_id_p"]."";
				$condition=true;
			}
			
			if ($_POST["soru_tipi_id"]!=""){
				$soruSekliSql= " AND M_ITEMBANK_SORULAR.SORU_SEKLI_ID = ".$_POST["soru_tipi_id"]."";
				$condition=true;
			}
		
			
		}
		
		
		if ($_POST["turkak_onayli_mi"]!=""){
			$turkakSql= " AND M_ITEMBANK_SORULAR.TURKAK_ONAYLI_MI = ".$_POST["turkak_onayli_mi"]."";
			$condition=true;
		}
		
		
		if ($_POST["zorluk_derecesi_id"]!=""){
			$zorlukDerecesiSql= " AND M_ITEMBANK_SORULAR.ZORLUK_DERECESI_ID = ".$_POST["zorluk_derecesi_id"]."";
			$condition=true;
		}
		
		
		if ($_POST["durum_id"]!=""){
			$durumSql= " AND M_ITEMBANK_SORULAR.DURUM_ID = ".$_POST["durum_id"]."";
			$condition=true;
		}
		
		
			if ($_POST["soru_metni"]!=""){
				
			$soruMetniSql= " AND M_ITEMBANK_SORULAR.SORU_METNI LIKE '%".$_POST["soru_metni"]."%'";
			$condition=true;
		}
		
		if ($_POST["s_baslangic_tarihi"]!=""){
			$sBasTarihSql= " AND M_ITEMBANK_SORULAR.KAYIT_TARIHI>= ".strtotime($_POST["s_baslangic_tarihi"])."";
			$condition=true;
		}
		
			
		if ($_POST["s_bitis_tarihi"]!=""){
			$sBitTarihSql= " AND M_ITEMBANK_SORULAR.KAYIT_TARIHI<= ".(strtotime($_POST["s_bitis_tarihi"])+24*60*60)."";
			$condition=true;
		}
		
			
		if ($_POST["o_baslangic_tarihi"]!=""){
			$oBasTarihSql= " AND M_ITEMBANK_SORULAR.OLUSTURMA_TARIHI>= '".$_POST["o_baslangic_tarihi"]."'";
			$condition=true;
		}
		
		
		if ($_POST["o_bitis_tarihi"]!=""){
			$oBitTarihSql= " AND M_ITEMBANK_SORULAR.OLUSTURMA_TARIHI<= '".$_POST["o_bitis_tarihi"]."'";
			$condition=true;
		}
		
				
		if ($_POST["kurulus_soru_kodu"]!=""){				
			$kurulusSorukoduSql= " AND M_ITEMBANK_SORULAR.KURULUS_SORU_KODU= '".$_POST["kurulus_soru_kodu"]."'";
			$condition=true;
		}
		
		$sql = "select distinct
					M_ITEMBANK_SORULAR.SORU_ID as SORU_ID,
					SEKTOR_ADI,
					KURULUS_ADI,
					YETERLILIK_ADI,
					YETERLILIK_KODU,
					SEVIYE_ID,
					YETERLILIK_ALT_BIRIM_ADI,
					YETERLILIK_ALT_BIRIM_NO,
					BIRIM_ADI,
					BIRIM_KODU,
					OGRENME_CIKTISI_YAZISI,
					BASARIM_OLCUTU_ADI,         
					SORU_DURUM_ADI,
					SORU_DURUM_ID,
					TURKAK_ONAYLI_MI,
					ONAYLAYAN,
					OLUSTURAN,
					KAYIT_TARIHI,
					SON_GUNCELLEYEN_ID,
					SON_GUNCELLEME_TARIHI,
					M_ITEMBANK_SORULAR.OLUSTURMA_TARIHI as OLUSTURMA_TARIHI,
					SORU_TIPI_ADI, 
					M_ITEMBANK_SORULAR.SORU_TIPI_ID as SORU_TIPI_ID, 
			          case when M_ITEMBANK_SORULAR.SORU_TIPI_ID=1 then
								PM_ITEMBANK_TEORIK_SORU_SEKLI.SORU_SEKLI_ADI
			          when M_ITEMBANK_SORULAR.SORU_TIPI_ID=2 then
								PM_ITEMBANK_PRATIK_SORU_SEKLI.SORU_SEKLI_ADI
			          end as SORU_SEKLI_ADI
					from
					M_ITEMBANK_SORULAR ,
					M_YETERLILIK,
					M_YETERLILIK_ALT_BIRIM,
					M_BIRIM,
					PM_ITEMBANK_SORU_TIPI,
					PM_ITEMBANK_TEORIK_SORU_SEKLI,
					PM_ITEMBANK_PRATIK_SORU_SEKLI,
					PM_SEKTORLER,
					M_BASARIM_OLCUTU,
					M_OGRENME_CIKTISI,
					PM_ITEMBANK_SORU_DURUMU,
					M_KURULUS,
					M_ITEMBANK_SORU_BO
				where
					M_ITEMBANK_SORULAR.SILINDI=0
					and M_YETERLILIK.YETERLILIK_ID=M_ITEMBANK_SORULAR.YETERLILIK_ID
			        and M_ITEMBANK_SORU_BO.BIRIM_ID=M_YETERLILIK_ALT_BIRIM.YETERLILIK_ALT_BIRIM_ID (+)
					and M_ITEMBANK_SORU_BO.BIRIM_ID=M_BIRIM.BIRIM_ID (+)
			        and PM_ITEMBANK_SORU_TIPI.SORU_TIPI_ID=M_ITEMBANK_SORULAR.SORU_TIPI_ID
			        and M_ITEMBANK_SORU_BO.SORU_ID=M_ITEMBANK_SORULAR.SORU_ID
			        and 
			        
			        M_ITEMBANK_SORULAR.SORU_SEKLI_ID=
				        case when M_ITEMBANK_SORULAR.SORU_TIPI_ID=1 then
	              			PM_ITEMBANK_TEORIK_SORU_SEKLI.SORU_SEKLI_ID
	              		when M_ITEMBANK_SORULAR.SORU_TIPI_ID=2 then
				        	PM_ITEMBANK_PRATIK_SORU_SEKLI.SORU_SEKLI_ID
	              		end
			        
			        and PM_SEKTORLER.SEKTOR_ID=M_YETERLILIK.SEKTOR_ID
					and M_ITEMBANK_SORULAR.KURULUS_USER_ID=M_KURULUS.USER_ID
					and PM_ITEMBANK_SORU_DURUMU.SORU_DURUM_ID=M_ITEMBANK_SORULAR.DURUM_ID
					and M_ITEMBANK_SORU_BO.BASARIM_OLCUTU_ID=M_BASARIM_OLCUTU.BASARIM_OLCUTU_ID (+)
			        and M_ITEMBANK_SORU_BO.OGRENME_CIKTISI_ID=M_OGRENME_CIKTISI.OGRENME_CIKTISI_ID (+)	
		";
		if ($condition){
			$sql=$sql.$kullaniciSql.$sektorSeviyeSql.$yeterlilikSql.$birimSql.$ogrenmeCiktisiSql.$turkakSql.$basarimOlcutuSql.$soruMetniSql.$soruSekliSql.$soruTipiSql.$zorlukDerecesiSql.$kurulusSql.$durumSql.$sBasTarihSql.$sBitTarihSql.$oBasTarihSql.$oBitTarihSql.$kurulusSorukoduSql;
		}
		
		
		$result= $db->prep_exec($sql, $array);
		for ($i=0;$i<count($result);$i++){
			$result[$i]["icerik"]=$this->soruGoster($result[$i]["SORU_ID"]);		
			$result[$i]["KAYIT_TARIHI"]=date("d.m.Y",$result[$i]["KAYIT_TARIHI"]);
			if ($result[$i]["SON_GUNCELLEME_TARIHI"]!=""){	
				$result[$i]["SON_GUNCELLEME_TARIHI"]=date("d.m.Y",$result[$i]["SON_GUNCELLEME_TARIHI"]);
				$mysql=mysql_query("select name from jos_users where id=".$result[$i]["SON_GUNCELLEYEN_ID"]);
				$liste=mysql_fetch_row($mysql);
				$result[$i]["SON_GUNCELLEYEN_ID"]=$liste[0];
			}else {
				$result[$i]["SON_GUNCELLEME_TARIHI"]="Güncelleme yapılmamış.";
				$result[$i]["SON_GUNCELLEYEN_ID"]="Güncelleme yapılmamış.";
			}	
		}
		if(count($result) > 0)
			ajax_success_response_with_array('Sorgu başarılı', $result);
		else
			ajax_error_response();
		
	}  
	
	function kullaniciTipi(){
    	$user=JFactory::getUser();
			if (FormFactory::checkAuthorization  ($user, ITEMBANK_GROUP_ID)){
			return 1;
		}
			if (FormFactory::checkAuthorization  ($user, YET_SEKTOR_SORUMLUSU_GROUP_ID)){
			return 2;
		}
	}
	
	function getKuruluslar(){
			$db = JFactory::getOracleDBO();
		
			$sql = "SELECT distinct m_kurulus.user_id as user_id, m_kurulus.kurulus_adi as kurulus_adi
    	FROM m_kurulus, m_itembank_kurulus_users
    	where m_kurulus.user_id=m_itembank_kurulus_users.kurulus_id
    	ORDER BY m_kurulus.kurulus_adi";
		
			return $db->prep_exec($sql, array());
	}
		
	function getPMSoruDurum(){
		$db = JFactory::getOracleDBO();
	
		$sql = "SELECT soru_durum_id,soru_durum_adi
		FROM pm_itembank_soru_durumu
		order by SIRA";
	
		return $db->prep_exec($sql, array());
	}
	
	function secilenleriSil(){
		$db = JFactory::getOracleDBO();
		$user=JFactory::getUser();
		$user_id=$user->id;
		
		for ($i=0;$i<count($_POST["soruId"]);$i++){
			$sql = "UPDATE m_itembank_sorular
					SET silindi=1, son_guncelleyen_id=".$user_id.", son_guncelleme_tarihi=".time()."
					WHERE durum_id=1 and soru_id=".$_POST["soruId"][$i];
			$result=$db->prep_exec_insert($sql,array());
		}
		
		echo "Seçilenler başarıyla silindi";
		
	}
	
	function durumDegistir(){
		$db = JFactory::getOracleDBO();
		$user=JFactory::getUser();
		$user_id=$user->id;
	
		for ($i=0;$i<count($_POST["soruId"]);$i++){
			$sql = "UPDATE m_itembank_sorular
			SET durum_id=".$_POST["yeni_durum_id"].", son_guncelleyen_id=".$user_id.", son_guncelleme_tarihi=".time()."
			WHERE soru_id=".$_POST["soruId"][$i];
			$result=$db->prep_exec_insert($sql,array());
		}
		echo "Seçilenlerin durumları başarıyla değiştirildi.";
	}
	
	
	function soruGoster($id){
		$db = JFactory::getOracleDBO();
		$user=JFactory::getUser();
		$itembank_user_id=$user->id;
			
		$sql = "SELECT *
		FROM m_itembank_sorular
		WHERE soru_id=".$id.""; 
	
		$soru = $db->prep_exec($sql, array());
		$sql="select sektor_id,seviye_id from m_yeterlilik where yeterlilik_id=".$soru[0]["YETERLILIK_ID"];
		$seviyeSektor = $db->prep_exec($sql, array());
		if ($soru){
			$sql = "SELECT *
			FROM m_itembank_cevaplar
			WHERE soru_id=".$id." ORDER BY cevap_index"; 
			
			$cevap = $db->prep_exec($sql, array());		
			$detay= array ("soru"=>$soru[0],"cevap"=>$cevap,"sektor"=>$seviyeSektor[0]["SEKTOR_ID"],"seviye"=>$seviyeSektor[0]["SEVIYE_ID"]);		
		}
		
		$icerik='<div width="100%">
		<table width="100%">
		<tr><td width="25%"><b>Sistem Soru ID: '.$detay["soru"]["SORU_ID"].'</b></td><td width="25%"></td><td width="25%"><b>Kuruluş Soru Kodu: '.$detay["soru"]["KURULUS_SORU_KODU"].'</b></td><td width="25%"></td></tr>
		<tr><td colspan=4 style="border-top: 1px solid #999999;"><b>Soru Bölümü</b><p>
		'.ereg_replace("\r\n","<br>",$detay["soru"]["SORU_METNI"]);
			if ($detay["soru"]["SORU_GORSELI_PATH"]!=""){
				$dosyaTip=$this->dosyaTip(EK_FOLDER.$detay["soru"]["SORU_GORSELI_PATH"]);
				if (strpos($dosyaTip,"mage")){
					$imageSizes=getimagesize(EK_FOLDER.$detay["soru"]["SORU_GORSELI_PATH"]);
					if ($imageSizes[1]>200){
						$height="height=200";
					}
					$icerik.='<br><img src=index.php?img='.$detay["soru"]["SORU_GORSELI_PATH"].'" '.$height.'>';
				} else {
					$icerik.='<br><a href="index.php?dl='.$detay["soru"]["SORU_GORSELI_PATH"].'">Dokumanı indirmek için tıklayınız</a>';
				}
			}
			if ($detay["soru"]["SORU_DOKUMANI_PATH"]!=""){
				$dosyaTip=$this->dosyaTip(EK_FOLDER.$detay["soru"]["SORU_DOKUMANI_PATH"]);
				if (strpos($dosyaTip,"mage")){
					$imageSizes=getimagesize(EK_FOLDER.$detay["soru"]["SORU_DOKUMANI_PATH"]);
					if ($imageSizes[1]>200){
						$height="height=200";
					}
					$icerik.='<br><img src=index.php?img='.$detay["soru"]["SORU_DOKUMANI_PATH"].'" '.$height.'></center>';
				} else {
					$icerik.='<br><a href="index.php?dl='.$detay["soru"]["SORU_DOKUMANI_PATH"].'">Dokumanı indirmek için tıklayınız</a>';
				}
			}
		$icerik.='</td></tr>
		<tr><td colspan=4 style="border-top: 1px solid #999999;"><b>Cevap Bölümü</b><p>';
		foreach ($detay["cevap"] as $arr){
			if ($arr["DOGRU_MU"]!=""){
				$bgcolor=' bgcolor="#dddddd"';
			} else {
				$bgcolor="";
			}
			if ($detay["soru"]["SORU_TIPI_ID"]==1 and $detay["soru"]["SORU_SEKLI_ID"]==4){
				if ($arr["CEVAP_METNI"]==1){$cevap1="Evet";} else {$cevap1="Hayır";}
			} else if ($detay["soru"]["SORU_TIPI_ID"]==1 and $detay["soru"]["SORU_SEKLI_ID"]==3){
				if ($arr["CEVAP_METNI"]==1){$cevap1="Doğru";} else {$cevap1="Yanlış";}
			} else {
				$cevap1=$arr["CEVAP_METNI"];
			}
			$icerik.='<tr'.$bgcolor.'><td colspan=4 style="border-top:1px dotted #999999">'.$cevap1;
			if ($cevap1){$icerik.='<br>';}
			if ($arr["CEVAP_DOSYA_PATH"]!=""){
// 				if ($detay["soru"]["SORU_TIPI_ID"]==1 and ($detay["soru"]["SORU_SEKLI_ID"]==1 or $detay["soru"]["SORU_SEKLI_ID"]==2 or $detay["soru"]["SORU_SEKLI_ID"]==5 and $detay["soru"]["SORU_SEKLI_ID"]==6)){
// 					$icerik.='<br><center><img src=index.php?img='.$arr["CEVAP_DOSYA_PATH"].'" '.$height.'></center>';			
// 				} else {
// 					$icerik.='<br><center><a href="index.php?dl='.$arr["CEVAP_DOSYA_PATH"].'">Dokumanı indirmek için tıklayınız</a></center>';
// 				}
				$dosyaTip=$this->dosyaTip(EK_FOLDER.$arr["CEVAP_DOSYA_PATH"]);
				if (strpos($dosyaTip,"mage")){
					$imageSizes=getimagesize(EK_FOLDER.$arr["CEVAP_DOSYA_PATH"]);
					if ($imageSizes[1]>200){
						$height="height=200";
					}
					$icerik.='<img src=index.php?img='.$arr["CEVAP_DOSYA_PATH"].'" '.$height.'>';
				} else {
					$icerik.='<a href="index.php?dl='.$arr["CEVAP_DOSYA_PATH"].'">Dokumanı indirmek için tıklayınız</a>';
				}
				
			} 
		}
		
		$icerik.='</td></tr></table>		
		</div>';
		
		$icerik=ereg_replace ("\n","",$icerik);
		$icerik=ereg_replace ("\r","",$icerik);
		$icerik=ereg_replace ("\t","",$icerik);
		return $icerik;
	}
	function dosyaTip($imgpath){
		$finfo = finfo_open(FILEINFO_MIME_TYPE);  // return mime type ala mimetype extension
		return finfo_file($finfo, $imgpath);
	}
	
	function getYeterlilikDataFromSoruID($id, &$yetID, &$yetAdi)
	{
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT YETERLILIK_ID, YETERLILIK_ADI FROM M_ITEMBANK_SORULAR JOIN M_YETERLILIK USING (YETERLILIK_ID) WHERE SORU_ID=?";
			$result=$db->prep_exec($sql,array($id));
		
		$yetID = $result[0]['YETERLILIK_ID'];
		$yetAdi = $result[0]['YETERLILIK_ADI'];
	}
	
	function getBeceriYetkinlikData($id)
	{
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT * FROM M_ITEMBANK_SORU_BECERI_YETK JOIN M_YETER_BECERI_YETKINLIK USING (BECERI_YETKINLIK_ID) WHERE SORU_ID=?";
		$result = $db->prep_exec($sql,array($id));
		foreach ($result as $row) 
			$resultToReturn .= $row['BECERI_YETKINLIK_ADI'].'<br>';
		
		return $resultToReturn;
	}
	
	
}


?>