<?php
defined('_JEXEC') or die('Restricted access');

class AdminModelAdmin extends JModel {
	var $title 		= "MYK Portal Yönetici Sayfası"; 
	var $pages 		= array ("yonetim","genelkurul","komite","sektorSorumlusuYetki","sektorSorumlusu","sektorIslemleri","itemBankKullanicilari","sektorSorumlusuGorev","tesvikonaykomitesi"); 
	var $pageNames 	= array ("Yönetim Kurulu","Genel Kurul","Sektör Komitesi","SS Yetkilendirme","SS Kullanıcı Yönetimi","Sektör İşlemleri","Item Bank Kullanıcıları","SS Kuruluş Görevlendirme","Teşvik Onay Komitesi");
		
	function getPageTree ($user, $activeLayout, $standart_id, $evrak_id, $taslak = 0){
		$activeStyle = 'style="background-color:rgb(170,0,0);color:rgb(255,255,255); margin: 1px;"';
		$sayfa = count ($this->pages);
		$activeStyle = 'style="background-color:rgb(170,0,0);color:rgb(255,255,255); margin: 1px;"';

		$tree = '<div style="text-align:center; padding-bottom: 15px;" >
				 <div style="padding-bottom:10px;">';
		
		$inp = '<input style="padding:5px; margin: 5px;" type="button" ';
		$value	 = "";
		$onClick = "";
		$disabled= "";
		
		
		$tree .= '</div>';
		
		for ($i = 0; $i < $sayfa; $i++){
			$style = 'style="margin: 1px;"';
			
			$input = '<input type="button" onclick="window.location=\'index.php?option=com_admin&layout='.$this->pages[$i].'\', \'\'" class="" id="page'.$i.'" value="'.$this->pageNames[$i].'" ';
            if ($activeLayout == $this->pages[$i])
				$tree .= $input.$activeStyle.' />';
			else
				$tree .= $input.$style.' />'; 
		}
		
		$tree .= '<br /></div>';
		
		return $tree;
	}
	
    
	function getYonetimKuruluTarihleri ($etkin){
		$db = JFactory::getOracleDBO();		
		$sql = "SELECT distinct tarih
				FROM M_YONETIM_KURULU
                WHERE etkin='".$etkin."'
                ORDER BY tarih desc";
		
		return $db->prep_exec($sql, array());
	}
    
	function getYonetimKurulu (){
		$db = JFactory::getOracleDBO();
        if ($_REQUEST["etkin"]==""){
            $_REQUEST["etkin"]=1;
        }

        $etkin= $_REQUEST['etkin'];
        if ($_REQUEST['tarih']!=""){
            $tarih= $_REQUEST['tarih'];
        } else {
            $tarihal=$db->prep_exec("select max(tarih) as tarih from m_yonetim_kurulu where etkin=".$etkin, array());
    		$tarih=$tarihal[0]["TARIH"];
        }
		$sql = "SELECT *
				FROM M_YONETIM_KURULU
                WHERE tarih='".$tarih."'
                AND etkin='".$etkin."'
                ORDER BY sira";
//                echo $sql;
		return $db->prep_exec($sql, array());
	}
    
    function yonetimKaydet ($post) {
		$db = JFactory::getOracleDBO();
        $tarih=tarihdenDonustur($post["tarih"]);
        $etkin=($post["etkin"]);
        $sql="SELECT *
            FROM m_yonetim_kurulu
            WHERE tarih='".$tarih."'
            AND etkin='".$etkin."'";
        $sonuc=$db->prep_exec($sql, array());
        foreach($sonuc as $row){
            $hata="Hata";
        }
        if ($hata==""){
        	
        	$sql2="UPDATE  m_yonetim_kurulu
        	SET AKTIF_MI=0
        	where etkin=".$post["etkin"]."
        	";
        	$sonuc=$db->prep_exec($sql2, array());
        	 
            for ($i=0;$i<count($post["adsoyad"]);$i++){
                if ($post["adsoyad"][$i]!=""){
                    $sql="INSERT INTO m_yonetim_kurulu
                        (tarih,
                        on_ek,
                        ad_soyad,
                        unvan,
                        kurum,                        
                        baslangic,
                        bitis,
                        uye_id,
                        etkin,
                        sira,
                        aktif_mi
                        )
                        VALUES
                        ('".$tarih."',
                        ?,
                        ?,
                        ?,
                        ?,
                        '".tarihdenDonustur($post["baslangic"][$i])."',
                        '".tarihdenDonustur($post["bitis"][$i])."',
                        0,
                        ".$post["etkin"].",
                        ?,
                        1)
                        ";
                $params= array(
                    $post["onek"][$i],
                    $post["adsoyad"][$i],
                    $post["unvan"][$i],
                    $post["kurum"][$i],
                    $post["sira"][$i]
                );
      		    $sonuc=$db->prep_exec_insert($sql, $params);
      		    if ($sonuc===false){
      		    	JError::raiseWarning(500, "Girmiş olduğunuz tarihler gg.aa.yil (ör: 23.02.2012) formatında olmalı.");
      		    		
      		    }

                        
                }
            }

            $message="Başarıyla Kaydedildi.";


        } else {
            JError::raiseWarning(500, "Girmiş olduğunuz tarih son oluşturulmuş tarihten sonraki bir tarih değil.");
        }
        return $message;
//        echo "<pre>";
//        print_r($post);
//        echo "</pre>";
//        exit;
    }
    
	function getGenelKurulTarihleri (){
		$db = JFactory::getOracleDBO();		
		$sql = "SELECT distinct tarih
				FROM M_GENEL_KURUL
                ORDER BY tarih desc";
		
		return $db->prep_exec($sql, array());
	}
    
    
	function getGenelKurul (){
		$db = JFactory::getOracleDBO();
        if ($_REQUEST['tarih']!=""){
            $tarih= $_REQUEST['tarih'];
        } else {
            $tarihal=$db->prep_exec("select max(tarih) as tarih from m_genel_kurul", array());
    		$tarih=$tarihal[0]["TARIH"];
        }
		$sql = "SELECT *
				FROM M_GENEL_KURUL
                WHERE tarih='".$tarih."'
                ORDER BY sira";
//                echo $sql;
		return $db->prep_exec($sql, array());
	}
    
    function genelKurulKaydet ($post) {
		$db = JFactory::getOracleDBO();
        $tarih=tarihdenDonustur($post["tarih"]);
        $sql="SELECT *
            FROM m_genel_kurul
            WHERE tarih='".$tarih."'";
        $sonuc=$db->prep_exec($sql, array());
        foreach($sonuc as $row){
            $hata="Hata";
        }
        if ($hata==""){
        	
        	$sql2="UPDATE  m_genel_kurul
        	SET AKTIF_MI=0";
        	$sonuc=$db->prep_exec($sql2, array());
        	
            for ($i=0;$i<count($post["adsoyad"]);$i++){
                if ($post["adsoyad"][$i]!=""){
                    $sql="INSERT INTO m_genel_kurul
                        (tarih,
                        on_ek,
                        ad_soyad,
                        unvan,
                        kurum,                        
                        baslangic,
                        bitis,
                        uye_id,
                        sira,
                        aktif_mi
                        )
                        VALUES
                        ('".$tarih."',
                        ?,
                        ?,
                        ?,
                        ?,
                        '".tarihdenDonustur($post["baslangic"][$i])."',
                        '".tarihdenDonustur($post["bitis"][$i])."',
                        0,
                        ?,?)
                        ";
                $params= array(
                    $post["onek"][$i],
                    $post["adsoyad"][$i],
                    $post["unvan"][$i],
                    $post["kurum"][$i],
                    $post["sira"][$i],
                		1
                );
      		    $db->prep_exec_insert($sql, $params);

                        
                }
            }
            
            $message="Başarıyla Kaydedildi.";


        } else {
            JError::raiseWarning(500, "Girmiş olduğunuz tarih son oluşturulmuş tarihten sonraki bir tarih değil.");
        }
        return $message;
//        echo "<pre>";
//        print_r($post);
//        echo "</pre>";
//        exit;
    }
    
    function getSektorler(){
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT sektor_id,sektor_adi
				FROM pm_sektorler
                WHERE sektor_durum=1
                ORDER BY sektor_adi";
		
		return $db->prep_exec($sql, array());
    }
    
	function getKomiteTarihleri (){
        $db = JFactory::getOracleDBO();		
        $sektor= $_REQUEST['sektorId'];
        $sql = "SELECT distinct tarih
        		FROM m_sektor_komiteleri
                WHERE sektor_id='".$sektor."'
                ORDER BY tarih desc";
//echo $sql;		
		return $db->prep_exec($sql, array());
	}

	function getSektorKomitesi (){
		$db = JFactory::getOracleDBO();
        $sektor= $_REQUEST['sektorId'];
        if ($_REQUEST['tarih']!=""){
            $tarih= $_REQUEST['tarih'];
        } else {
            $tarihal=$db->prep_exec("select max(tarih) as tarih from m_sektor_komiteleri where sektor_id=".$sektor."", array());
    		$tarih=$tarihal[0]["TARIH"];
        }
		$sql = "SELECT *
				FROM m_sektor_komiteleri
                WHERE tarih='".$tarih."'
                AND sektor_id=".$sektor."
                ORDER BY sira";
//                echo $sql;
		return $db->prep_exec($sql, array());
	}
    
    function komiteKaydet ($post) {
		$db = JFactory::getOracleDBO();
        $tarih=tarihdenDonustur($post["tarih"]);
        $sektor=($post["sektor"]);
        $sql="SELECT *
            FROM m_sektor_komiteleri
            WHERE tarih='".$tarih."'
            AND sektor_id='".$sektor."'";
        $sonuc=$db->prep_exec($sql, array());
        foreach($sonuc as $row){
            $hata="Hata";
        }
        if ($hata==""){
        	
            $sql2="UPDATE  m_sektor_komiteleri
        	SET AKTIF_MI=0
            where sektor_id='".$sektor."'";
        	$sonuc=$db->prep_exec($sql2, array());
        	
        	for ($i=0;$i<count($post["adsoyad"]);$i++){
                if ($post["adsoyad"][$i]!=""){
                    $sql="INSERT INTO m_sektor_komiteleri
                        (sektor_id,
                        tarih,
                        ad_soyad,
                        komite_unvani,
                        unvani,
                        temsil_ettigi_kurum,
                        calistigi_kurum,                        
                        kurum_unvani,
                        sira,
                        aktif_mi
                        )
                        VALUES
                        ('".$sektor."',
                        '".$tarih."',
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        1)
                        ";
                $params= array(
                    $post["adsoyad"][$i],
                    $post["komiteUnvani"][$i],
                    $post["onek"][$i],
                    $post["temsil"][$i],
                    $post["calistigi_kurum"][$i],
                    $post["kurum_unvani"][$i],
                    $post["sira"][$i]
                );
      		    $db->prep_exec_insert($sql, $params);

                        
                }
            }
            
            $message="Başarıyla Kaydedildi.";


        } else {
            JError::raiseWarning(500, "Girmiş olduğunuz tarih son oluşturulmuş tarihten sonraki bir tarih değil.");
        }
        return $message;
//        echo "<pre>";
//        print_r($sql);
//        echo "</pre>";
//        exit;
    }
    
    function getSSYetkileri (){
   	$db = JFactory::getOracleDBO();
   // 	$mysql= & JFactory::getDBO();
    	
    	$sql = "SELECT tgUserId,name,id
					FROM `jos_users`
					WHERE `active` =2
					AND `block` =0
					ORDER BY `name`";
    //	$users= $mysql->Execute ($sql);  	
		$query=mysql_query($sql);
		while($us=mysql_fetch_array($query)){
			$result[]=$us;
		}
    	
    	$sql="SELECT * FROM M_YETKI_SEKTOR_SORUMLUSU";
    	$sonuc= $db->prep_exec($sql, array());
    	
    	$satir[users]=$result;
    	$satir[yetki]=$sonuc;
    	return $satir;
    	    	
    }
    
    function yetkiKaydet ($post) {
    	$db = JFactory::getOracleDBO();
    	   
    	$orasql="delete from m_yetki_sektor_sorumlusu";
    	$sonuc=$db->prep_exec_insert($orasql, array());
	    $orasql="insert into m_yetki_sektor_sorumlusu (yetki_alani,user_id,sektor_id) values (?,?,?)";
    	for ($i=0;$i<count($post[userid]);$i++){
    		$sql="delete from jos_community_acl_users where user_id='".$post[userid][$i]."'and group_id='".YET_SEKTOR_SORUMLUSU_GROUP_ID."' and role_id='".YET_SEKTOR_SORUMLUSU_ROLE_ID."' and function_id='".YET_SEKTOR_SORUMLUSU_FUNCTION_ID."'";
    		$sorgu=mysql_query($sql);
    		$sql="delete from jos_community_acl_users where user_id='".$post[userid][$i]."'and group_id='".MS_SEKTOR_SORUMLUSU_GROUP_ID."' and role_id='".MS_SEKTOR_SORUMLUSU_ROLE_ID."' and function_id='".MS_SEKTOR_SORUMLUSU_FUNCTION_ID."'";
    		$sorgu=mysql_query($sql);    		
    	}
	    
    	for ($i=0;$i<count($post[id]);$i++){
    		$veri=explode("-",$post[id][$i]);
    		$arr=array($veri[0],$veri[1],$veri[2]);
	    	$sonuc=$db->prep_exec_insert($orasql, $arr);
	    	if ($veri[0]==1){
		     	$sql="delete from jos_community_acl_users where user_id='".$veri[3]."'and group_id='".YET_SEKTOR_SORUMLUSU_GROUP_ID."' and role_id='".YET_SEKTOR_SORUMLUSU_ROLE_ID."' and function_id='".YET_SEKTOR_SORUMLUSU_FUNCTION_ID."'";
		     	$sorgu=mysql_query($sql);
		     	
		     	$sql="insert into jos_community_acl_users set user_id='".$veri[3]."',group_id='".YET_SEKTOR_SORUMLUSU_GROUP_ID."',	role_id='".YET_SEKTOR_SORUMLUSU_ROLE_ID."',	function_id='".YET_SEKTOR_SORUMLUSU_FUNCTION_ID."'";
		     	$sorgu=mysql_query($sql);
	    	}
    	   	if ($veri[0]==2){
		     	$sql="delete from jos_community_acl_users where user_id='".$veri[3]."'and group_id='".MS_SEKTOR_SORUMLUSU_GROUP_ID."' and role_id='".MS_SEKTOR_SORUMLUSU_ROLE_ID."' and function_id='".MS_SEKTOR_SORUMLUSU_FUNCTION_ID."'";
		     	$sorgu=mysql_query($sql);
	     	
	    		$sql="insert into jos_community_acl_users set user_id='".$veri[3]."',group_id='".MS_SEKTOR_SORUMLUSU_GROUP_ID."',	role_id='".MS_SEKTOR_SORUMLUSU_ROLE_ID."',	function_id='".MS_SEKTOR_SORUMLUSU_FUNCTION_ID."'";
		     	$sorgu=mysql_query($sql);   	
	    	}
//     	   	if ($veri[2]==0){
// 		     	$sql="delete from jos_community_acl_users where user_id='".$veri[3]."'and group_id='".YETKILI_SEKTOR_SORUMLUSU_GROUP_ID."' and role_id='".YETKILI_SEKTOR_SORUMLUSU_ROLE_ID."'";
// 		     	$sorgu=mysql_query($sql);
	     	
// 	    		$sql="insert into jos_community_acl_users set user_id='".$veri[3]."',group_id='".YETKILI_SEKTOR_SORUMLUSU_GROUP_ID."',	role_id='".YETKILI_SEKTOR_SORUMLUSU_ROLE_ID."'";
// 		     	$sorgu=mysql_query($sql);   	
// 	    	}
    	}
    	$message="Başarıyla Kaydedildi.";
    
    
    	return $message;
    }
    
    function sektorDurumGuncelle ($post) {
    	$db = JFactory::getOracleDBO();
    	   
    	$sql="update pm_sektorler set sektor_durum=0";
    	$sonuc=$db->prep_exec_insert($sql, array());
	    $sql="update pm_sektorler set sektor_durum=1 where sektor_id= ?";

    	for ($i=0;$i<count($post[id]);$i++){
    		$veri=explode("-",$post[id][$i]);
	    	$sonuc=$db->prep_exec_insert($sql, $veri);
    	}
    	$message="Durumlar Güncellendi.";
    
    
    	return $message;
    }
    
    function sektorEkle ($post) {
    	$db = JFactory::getOracleDBO();
    	$sektorid=$db->getNextVal(PM_SEKTORLER_SEQ);   
	    $sql="insert into pm_sektorler (sektor_id,sektor_adi,sektor_durum) values (?,?,?)";

   		$veri=array($sektorid,$post[sektorName],1);
    	$sonuc=$db->prep_exec_insert($sql, $veri);
    	$message="Başarıyla Kaydedildi.";
    
    
    	return $message;
    }
    
    function getSektorSorumlulari (){
    	$mysql= & JFactory::getDBO();
    	 
    	$sql = "SELECT
    	id, 
    	tgUserId,
    	name,
    	username,
    	email,
    	block
    	
    	FROM `jos_users`
    	WHERE `active` =2
    	ORDER BY block,`name`";
    	$users= $mysql->Execute ($sql);
    	 
    	return $users->data;
    	 
    }
    
    function getSektorSorumlulari2(){
    	$mysqlDB = &JFactory::getDBO();
    	$sqlMatbaa= "SELECT users.* FROM #__users as users
					WHERE users.block = 0 AND users.active = 2 ORDER BY users.name";
    	$mysqlDB->setQuery($sqlMatbaa);
    	$matbaaUser = $mysqlDB->loadObjectList();
    	return $matbaaUser;
    }
    
    function sektorSorumlusuGuncelle ($post) {
    	$db= & JFactory::getDBO();
		for ($i=0;$i<count($post[id]);$i++){
			if ($post[sifre][$i]!=""){    	   
					$password	= $this->sifreOlustur($post[sifre][$i]);
			     	$querypart	= "password = '".$password."',";
			} else {
				$querypart="";
			}
			if ($post[durum][$i]=="aktif") {$block=0;} else {$block=1;}
			$query="update jos_users set tgUserId='".$post[tgUserName][$i]."',name='".$post[ad][$i]."',	username='".$post[username][$i]."',	email='".$post[eposta][$i]."', ".$querypart." block='".$block."', usertype='Registered'	where id='".$post[id][$i]."'";			
			$db->setQuery($query);
            $db->query();
		}
		$message="Durumlar Güncellendi.";
    
    
    	return $message;
    }
    
    function sektorSorumlusuEkle ($post) {
    	$db= & JFactory::getDBO();
		$password	= $this->sifreOlustur($post[password]);
     	$sql="insert into jos_users set tgUserId='".$post[tguserid]."',name='".$post[name]."',	username='".$post[username]."',	email='".$post[email]."', password = '".$password."', block='0',active=2,gid='18', usertype='Registered'";
    	$sorgu=mysql_query($sql);
    	$userid=mysql_insert_id();

//     	$sql="insert into jos_community_acl_users set user_id='".$userid."',group_id='15',	role_id='14',	function_id='14'";
//     	$sorgu=mysql_query($sql);
    	
//     	$sql="insert into jos_community_acl_users set user_id='".$userid."',group_id='17',	role_id='16',	function_id='16'";
//     	$sorgu=mysql_query($sql);
    	
    	$sql="insert into jos_core_acl_aro (section_value, value, name) values('users','".$userid."','".$post[name]."')";
    	$sorgu=mysql_query($sql);
    	$aroid=mysql_insert_id();
    	$sql="insert into jos_core_acl_groups_aro_map (group_id, aro_id) values('18','".$aroid."')";
    	$sorgu=mysql_query($sql);
    	 
    	$message="Başarıyla Kaydedildi.";
  
    	return $message;
    }
    
    function getItemBankUsers (){
    	$resultToReturn;
    	
    	$mysql= & JFactory::getDBO();
    	 
    	$sql = "SELECT
    	id, 
    	name,
    	username,
    	email,
    	block
    	
    	FROM `jos_users`
    	WHERE `active` =4
    	ORDER BY block,`name`";
    	$users= $mysql->Execute ($sql);

    	$i=0;
    	foreach ($users->data as &$row)
    	{
    		$db = JFactory::getOracleDBO();
    	
    		$sql = "SELECT KURULUS_ADI
    		FROM m_itembank_kurulus_users JOIN m_kurulus ON m_itembank_kurulus_users.KURULUS_ID = m_kurulus.USER_ID
    		WHERE m_itembank_kurulus_users.user_id = ?";
    		$sonuc= $db->prep_exec_array($sql, array($row['0']));
    	
    		$row['5'] = $sonuc[0];
    	}
    	 
    	return $users->data;
    	 
    }
    
    function itemBankUsersGuncelle ($post) {
    	$db= & JFactory::getDBO();
		for ($i=0;$i<count($post[id]);$i++){
			if ($post[sifre][$i]!=""){    	   
					$password	= $this->sifreOlustur($post[sifre][$i]);
			     	$querypart	= "password = '".$password."',";
			}
			if ($post[durum][$i]=="aktif") {$block=0;} else {$block=1;}
			$query="update jos_users set name='".$post[ad][$i]."',	username='".$post[username][$i]."',	email='".$post[eposta][$i]."', ".$querypart." block='".$block."', usertype='Registered'	where id='".$post[id][$i]."'";			
			$db->setQuery($query);
            $db->query();
		}
		$message="Durumlar Güncellendi.";
    
    
    	return $message;
    }
    
    function itemBankUsersEkle ($post) {
    	$db= & JFactory::getDBO();
   		$dbO = JFactory::getOracleDBO();
   		
		$password	= $this->sifreOlustur($post[password]);
     	
		$sql="insert into jos_users set name='".$post[name]."',	username='".$post[username]."',	email='".$post[email]."', password = '".$password."', block='0',active=4,gid='18', usertype='Registered'";
    	$sorgu=mysql_query($sql);
    	
    	$userid=mysql_insert_id();
    	$tguserid=200000+$userid;
    	
    	$sql="update jos_users set tgUserId=".$tguserid." where id=$userid";
    	$sorgu=mysql_query($sql);
    	
    	$sql="insert into jos_community_acl_users set user_id='".$userid."',group_id='".ITEMBANK_GROUP_ID."',	role_id='".ITEMBANK_ROLE_ID."'";
    	$sorgu=mysql_query($sql);
    	 
	   	$sql="insert into jos_core_acl_aro (section_value, value, name) values('users','".$userid."','".$post[name]."')";
    	$sorgu=mysql_query($sql);
    	$aroid=mysql_insert_id();

    	$sql="insert into jos_core_acl_groups_aro_map (group_id, aro_id) values('18','".$aroid."')";
    	$sorgu=mysql_query($sql);
    	 
	    $sql="delete from m_itembank_kurulus_users where user_id=? and kurulus_id=?";

	    $veri=array($userid,$post[kurulus]);

   		$sonuc=@$dbO->prep_exec_insert($sql, $veri);
    	
	    $sql="insert into m_itembank_kurulus_users (user_id,kurulus_id) values (?,?)";
   		$veri=array($userid,$post[kurulus]);

   		$sonuc=$dbO->prep_exec_insert($sql, $veri);
    	
   		$message="Başarıyla Kaydedildi.";
  
    	return $message;
    }
    
    function getKurulus(){
    	$db = JFactory::getOracleDBO();
    	 
    	$sql = "SELECT user_id,kurulus_adi
    	FROM m_kurulus
    			WHERE KURULUS_DURUM_ID != 1
    	ORDER BY kurulus_adi";
     	$sonuc= $db->prep_exec($sql, array());
    	 
    	return $sonuc;
    	 
    	 
    }
    
    function sifreOlustur($sifre){
    	jimport('joomla.mail.helper');
		jimport('joomla.user.helper');
    	$salt		= JUserHelper::genRandomPassword(32);
    	$crypt		= JUserHelper::getCryptedPassword($sifre, $salt);
    	$password	= $crypt.':'.$salt;
    	return $password; 
    }
    
    function getGorevlendirme($kurId){
    	$db = JFactory::getOracleDBO();
    	
    	$sql = "SELECT TGUSERID FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
    	
    	return $db->prep_exec_array($sql, array($kurId));
    }
    
    function KurulusGorevliler($kurId){
    	$db = JFactory::getOracleDBO();
    	 
    	$sql = "SELECT * FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
    	 
    	$data = $db->prep_exec($sql, array($kurId));
    	if($data){
    		$kisiler = array();
    		foreach ($data as $row){
    			$kisiler[$row['TGUSERID']] = $row;
    		}
    		return $kisiler;
    	}else{
    		return false;
    	}
    }
    
    function kurulusaGorevlendir($post){
    	$db = JFactory::getOracleDBO();
    	$kurId = $post['kurs'];
    	$gorevliBir = $post['gorevBir'];
    	$gorevliIki = $post['gorevIki'];
    	
    	$sqlDelete = "DELETE FROM M_KURULUS_GOREVLI WHERE KURULUS_ID = ?";
    	$db->prep_exec_insert($sqlDelete, array($kurId));
    	
    	$sql="INSERT INTO M_KURULUS_GOREVLI (KURULUS_ID, TGUSERID, BIRINCIL) VALUES(?,?,?)";
    	foreach ($gorevliIki as $row){
    		$db->prep_exec_insert($sql, array($kurId,$row,2));	
    	}
    	
    	$db->prep_exec_insert($sql, array($kurId,$gorevliBir,1));
    	
    	return 'Başarıyla Eklendi';
    }
    
    function getUserGroups(){
    	$mysqlDB = &JFactory::getDBO();
    	
    	$mysqlDB->setQuery("SELECT id,name from jos_community_acl_groups order by name");
    	$grouplists = $mysqlDB->loadObjectList();
    	
    	foreach ($grouplists as $key=>$value ){
 
    		 $grouplist[] = (array) $value;
    	}
    	return $grouplist;
    }
    
    function getUserByGroup($group){
    	$mysqlDB = &JFactory::getDBO();
    	 
    	$mysqlDB->setQuery("SELECT tgUserId as id,name FROM jos_users INNER JOIN jos_community_acl_users ON jos_community_acl_users.user_id = jos_users.id WHERE jos_community_acl_users.group_id = '".$group."'");
    	$userlists = $mysqlDB->loadObjectList();
    	 
    	foreach ($userlists as $key=>$value ){
    
    		$userlist[] = (array) $value;
    	}
    	return $userlist;
    }
    
    function getTesvikKomitesi(){
    	
    	$db = JFactory::getOracleDBO();
    	$mysqlDB = &JFactory::getDBO();
    	
    	$sql= "SELECT * FROM M_TESVIK_ONAY_KOMITESI ORDER BY SIRA";
    	$datas = $db->prep_exec($sql, array());
    	for($i = 0; $i < count($datas) ; $i++){
    		
    		$mysqlDB->setQuery("SELECT jos_users.name AS username,jos_community_acl_groups.name AS groupname FROM jos_users 
								LEFT OUTER JOIN jos_community_acl_users ON jos_community_acl_users.user_id = jos_users.id 
								LEFT OUTER JOIN jos_community_acl_groups ON jos_community_acl_groups.id = jos_community_acl_users.group_id 
								
								
								WHERE jos_users.tgUserId = '".$datas[$i]['USER_ID']."' and jos_community_acl_groups.id = '".$datas[$i]['ROL_ID']."'");
    		$list = $mysqlDB->loadObjectList();
    		
     		$datas[$i]['ADSOYAD'] = $list[0]->username;
     		$datas[$i]['GROUP'] = $list[0]->groupname;
    	}
    	
    	return $datas;
    }
    
    function tesvikOnayKomitesiKaydet($post){
    	
    	$db = JFactory::getOracleDBO();
    	
    	$datas = $db->prep_exec("DELETE FROM M_TESVIK_ONAY_KOMITESI", array());
    	
    	for($i = 0 ; $i < count($post['usercode']) ; $i++){
    		$sql = "INSERT INTO M_TESVIK_ONAY_KOMITESI (USER_ID,ROL_ID,SIRA) VALUES(?,?,?)";
    		$datas = $db->prep_exec_insert($sql, array($post['usercode'][$i],$post['groupcode'][$i],($i+1)));
    		
    	}
    	return "Teşvik komitesi başarıyla kaydedildi";
    }
}
?>