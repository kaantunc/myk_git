<?php
defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form.php');
require_once('libraries/form/form_config.php');
require_once('libraries/form/form_parametrik.php');

$document = &JFactory::getDocument();

$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables_themeroller.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');
$document->addScript (SITE_URL.'/templates/elegance/js/jquery.blockUI.js');

$db = & JFactory::getOracleDBO();
$user 	= &JFactory::getUser();
$user_id = $user->getOracleUserId ();

$post = JRequest::get( 'post' );
$get = JRequest::get('get');

if(isset($get['belge_zorunlu']) && $get['belge_zorunlu'] == 1){
	$post['yeterlilik_belge_zorunluluk_durum'] = 1;
}
$condition = " ";   
if(isset($post['yeterlilik_kodu']) && $post['yeterlilik_kodu'] <> ""){
	$condition.= " AND  M_YETERLILIK.YETERLILIK_KODU like '%".$post['yeterlilik_kodu']."%'";
	$yeterlilik_kodu = $post['yeterlilik_kodu'];
}
if(isset($post['yeterlilik_adi']) && $post['yeterlilik_adi'] <> ""){
	$condition.= " AND NLS_LOWER(M_YETERLILIK.YETERLILIK_ADI, 'NLS_SORT = xturkish') LIKE '%".FormFactory::toLowerCase(trim($post['yeterlilik_adi']))."%' ";
	$yeterlilik_adi = $post['yeterlilik_adi'];
}
if(isset($post['seviye_id']) && $post['seviye_id'] <> "" && is_numeric($post['seviye_id'])){
	$condition.= " AND  M_YETERLILIK.SEVIYE_ID = '".$post['seviye_id']."'";
	$seviye_id = $post['seviye_id'];
}
if(isset($post['sektor_id']) && $post['sektor_id'] <> "" && is_numeric($post['sektor_id'])){
	$condition.= " AND  M_YETERLILIK.SEKTOR_ID = '".$post['sektor_id']."'";
	$sektor_id = $post['sektor_id'];
}
if(isset($post['kurulus_id']) && $post['kurulus_id'] <> "" && is_numeric($post['kurulus_id'])){
 	$condition.= " AND M_BELGELENDIRME_YET_YETKI.USER_ID = '".$post['kurulus_id']."'";
 	$kurulus_id = $post['kurulus_id'];
}

if((isset($post['yeterlilik_belge_zorunluluk_durum']) && $post['yeterlilik_belge_zorunluluk_durum'] <> "" && is_numeric($post['yeterlilik_belge_zorunluluk_durum']))  || (isset($get['yeterlilik_belge_zorunluluk_durum']) && $get['yeterlilik_belge_zorunluluk_durum'] <> "" && $get['yeterlilik_belge_zorunluluk_durum'] == "1")){
	$condition.= " AND M_YETERLILIK.BELGE_ZORUNLULUK_DURUM = '".($post['yeterlilik_belge_zorunluluk_durum'] <> "" ? $post['yeterlilik_belge_zorunluluk_durum'] : $get['yeterlilik_belge_zorunluluk_durum'])."'";
	$yeterlilik_belge_zorunluluk_durum = ($post['yeterlilik_belge_zorunluluk_durum'] <> "" ? $post['yeterlilik_belge_zorunluluk_durum'] : $get['yeterlilik_belge_zorunluluk_durum']);
}

if((isset($post['yeterlilik_tehlikeli_is_durum']) && $post['yeterlilik_tehlikeli_is_durum'] <> "" && is_numeric($post['yeterlilik_tehlikeli_is_durum']))  || (isset($get['yeterlilik_tehlikeli_is_durum']) && $get['yeterlilik_tehlikeli_is_durum'] <> "" && $get['yeterlilik_tehlikeli_is_durum'] == "1")){
	$condition.= " AND M_YETERLILIK.TEHLIKELI_IS_DURUM = '".($post['yeterlilik_tehlikeli_is_durum'] <> "" ? $post['yeterlilik_tehlikeli_is_durum'] : $get['yeterlilik_tehlikeli_is_durum'])."'";
	$yeterlilik_tehlikeli_is_durum = ($post['yeterlilik_tehlikeli_is_durum'] <> "" ? $post['yeterlilik_tehlikeli_is_durum'] : $get['yeterlilik_tehlikeli_is_durum']);
}

$sql = "SELECT  DISTINCT M_KURULUS.KURULUS_ADI,
				M_KURULUS.USER_ID,
				M_KURULUS_EDIT.KURULUS_KISA_ADI,
				M_YETERLILIK.YETERLILIK_ID, 
				M_YETERLILIK.YETERLILIK_KODU, 
				M_YETERLILIK.YETERLILIK_ADI, 
				M_YETERLILIK.SEVIYE_ID, 
				PM_SEVIYE.SEVIYE_ADI, 
				PM_SEKTORLER.SEKTOR_ADI, 
				M_YETERLILIK.REVIZYON,
				M_YETERLILIK.YENI_MI, 
				M_TASLAK_YETERLILIK.SON_TASLAK_PDF,
				M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI,
			    M_BELGELENDIRME_YET_YETKI.YETKININ_VERILDIGI_TARIH
				FROM M_YETERLILIK  
				LEFT JOIN M_BELGELENDIRME_YET_YETKI ON M_BELGELENDIRME_YET_YETKI.YETERLILIK_ID = M_YETERLILIK.YETERLILIK_ID AND M_BELGELENDIRME_YET_YETKI.DURUM=1 
				LEFT JOIN M_TASLAK_YETERLILIK ON M_YETERLILIK.YETERLILIK_ID = M_TASLAK_YETERLILIK.YETERLILIK_ID 
				LEFT JOIN M_KURULUS ON M_KURULUS.USER_ID = M_BELGELENDIRME_YET_YETKI.USER_ID 
				LEFT JOIN M_KURULUS_EDIT ON M_KURULUS_EDIT.USER_ID = M_BELGELENDIRME_YET_YETKI.USER_ID AND M_KURULUS_EDIT.AKTIF = 1
				INNER JOIN PM_SEVIYE ON M_YETERLILIK.SEVIYE_ID = PM_SEVIYE.SEVIYE_ID 
				INNER JOIN PM_SEKTORLER ON M_YETERLILIK.SEKTOR_ID = PM_SEKTORLER.SEKTOR_ID 
		WHERE M_YETERLILIK.YETERLILIK_DURUM_ID = 2 AND 
		M_YETERLILIK.YETERLILIK_SUREC_DURUM_ID = ".ONAYLANMIS_YETERLILIK.$condition." 
	   ORDER BY M_YETERLILIK.YETERLILIK_ADI,
				M_YETERLILIK.YETERLILIK_KODU,
				M_YETERLILIK.SEVIYE_ID,
				M_YETERLILIK.REVIZYON DESC,
				M_KURULUS.KURULUS_YETKILENDIRME_NUMARASI";     

$datas = $db->prep_exec(mb_convert_encoding($sql, "ISO-8859-9","UTF8"), array());
$grouped = array();
foreach ($datas as $data){ 
	if($data['YETERLILIK_KODU'] <> ""){
		$code = explode("-",$data['YETERLILIK_KODU']);
		
		$konum = strpos($code[1], "/");
		if($konum !== false){
			$code[1] = current(explode("/", $code[1]));
		}
		$array_code = trim($code[0])."-".trim($code[1]);
	}else{
		$search = array('Ç','ç','Ğ','ğ','İ','i','Ö','ö','Ş','ş','Ü','ü',' ');
		$replace = array('c','c','g','g','i','i','o','o','s','s','u','u','_');
		$array_code = str_replace($search,$replace,$data['YETERLILIK_ADI']);
		$array_code = strtolower($array_code)."-".$data['SEVIYE_ID'];
	}

	if(!array_key_exists($array_code,$grouped)){
		
		$grouped[$array_code]['YETERLILIK_KODU'] = $data['YETERLILIK_KODU'];
		$grouped[$array_code]['YETERLILIK_ADI']= str_replace(array('bt','cnc','nc/','pvc'), array('BT','CNC','NC/','PVC'),mb_strtolower( str_replace(array('I', 'Ğ', 'Ü', 'Ş', 'İ', 'Ö', 'Ç'), array('ı', 'ğ', 'ü', 'ş', 'i', 'ö', 'ç'), $data['YETERLILIK_ADI']), "UTF-8"));
		$grouped[$array_code]['SEVIYE_ADI']    = $data['SEVIYE_ADI'];
		$grouped[$array_code]['SEKTOR_ADI']    = $data['SEKTOR_ADI'];
		$grouped[$array_code]['REVIZYONBILGILERI'] = array();
	}
	
	if(!array_key_exists($data['REVIZYON'],$grouped[$array_code]['REVIZYONBILGILERI'])){
		$grouped[$array_code]['REVIZYONBILGILERI'][$data['REVIZYON']] = array('YETERLILIK_ID'  => $data['YETERLILIK_ID'],
																			  'REVIZYON'       => $data['REVIZYON'],
																			  'SON_TASLAK_PDF' => $data['SON_TASLAK_PDF']);
		$grouped[$array_code]['REVIZYONBILGILERI'][$data['REVIZYON']]['KURULUS_BILGILERI'] = array();
	}
	
	if($data['YENI_MI'] == 1){
		$sql = "SELECT  DISTINCT MBYY.YET_ESKI_MI,MBYY.DURUM,M_BIRIM.BIRIM_KODU,MBYY.YETKININ_VERILDIGI_TARIH
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_BIRIM ON(MBYY.YETERLILIK_ID = M_YETERLILIK_BIRIM.YETERLILIK_ID AND MBYY.BIRIM_ID = M_YETERLILIK_BIRIM.BIRIM_ID)
					INNER JOIN M_BIRIM ON(MBYY.BIRIM_ID = M_BIRIM.BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ? ";
	}else{
		$sql = "SELECT DISTINCT MBYY.YET_ESKI_MI,MBYY.DURUM,MYAB.YETERLILIK_ALT_BIRIM_NO AS BIRIM_KODU,MBYY.YETKININ_VERILDIGI_TARIH
					FROM M_BELGELENDIRME_YET_YETKI MBYY
					INNER JOIN M_YETERLILIK_ALT_BIRIM MYAB ON(MBYY.BIRIM_ID = MYAB.YETERLILIK_ALT_BIRIM_ID)
					WHERE MBYY.USER_ID = ? AND MBYY.YETERLILIK_ID = ? ";
	}
		
	$sql.= " ORDER BY BIRIM_KODU ASC, YETKININ_VERILDIGI_TARIH DESC";
	$sayi_datas = $db->prep_exec($sql, array($data['USER_ID'],$data['YETERLILIK_ID']));
	$x = 0;
	foreach ($sayi_datas as $sayi_data){
		if($sayi_data['DURUM'] == 1){
			$x++;
		}
	}
	if($x > 0){
		if($data['KURULUS_ADI'] <> ""){
			$kurulus = array('USER_ID' => $data['USER_ID'],
							 'KURULUS_ADI' => $data['KURULUS_ADI'],
							 'KURULUS_KISA_ADI' => $data['KURULUS_KISA_ADI']);
			if(!array_key_exists($data['USER_ID'], $grouped[$array_code]['REVIZYONBILGILERI'][$data['REVIZYON']]['KURULUS_BILGILERI'])){
				$grouped[$array_code]['REVIZYONBILGILERI'][$data['REVIZYON']]['KURULUS_BILGILERI'][$data['USER_ID']] = $kurulus;
			}else if($grouped[$array_code]['REVIZYONBILGILERI'][$data['REVIZYON']]['KURULUS_BILGILERI'][$data['USER_ID']]['KURULUS_KISA_ADI'] == ""){
				$grouped[$array_code]['REVIZYONBILGILERI'][$data['REVIZYON']]['KURULUS_BILGILERI'][$data['USER_ID']]['KURULUS_KISA_ADI'] = $data['KURULUS_KISA_ADI'];
			}
		}
	}
}

if((isset($post['kurulusiceren']) && $post['kurulusiceren'] <> "" && $post['kurulusiceren'] == "1") || (isset($get['kurulusiceren']) && $get['kurulusiceren'] <> "" && $get['kurulusiceren'] == "1")){
	if($post['kurulusiceren'] <> ""){
		$kurulusiceren = $post['kurulusiceren'];
	}else{
		$kurulusiceren = $get['kurulusiceren'];
	}
	foreach ($grouped as $key => $group){
		foreach ($group['REVIZYONBILGILERI'] as $key2 => $revizyon){
			if(count($revizyon['KURULUS_BILGILERI'])<1){
				unset($grouped[$key]['REVIZYONBILGILERI'][$key2]);
			}
		}
		
		if(count($grouped[$key]['REVIZYONBILGILERI']) < 1){
			unset($grouped[$key]);
		}
	}
}
?>
<style>
table tr{
	text-align:left;
} 
.yetadi,.yeterlilikadi{
	text-transform: capitalize;
}
table#yeterlilikListesiGrid ul li{
	font-size: 11px;
}

table#searchcriters tr td {
	padding: 8px 0 0 8px;
}

#revizyoncontent table tr td {
	padding: 5px;
}
.revizyon_row td{
	padding: 1px 6px;
}
.tableWrapper td img{
	border: none;
}
.odd_row{
background-color: #E2E4FF;
}
.even_row{
background-color: white;
}
<?php 
	if(isset($get['belge_zorunlu']) && $get['belge_zorunlu'] == 1){ ?>
		table#searchcriters tr:nth-child(6),table#searchcriters  tr:nth-child(7) {
			display:none;
		}
<?php }?>
</style>
<div class="form_item" style="margin: 0 0 20px 0;">
  <div class="form_element cf_heading" style="margin:0;">
	<?php
		if($get['belge_zorunlu']){ ?>
		  	<h3 class="contentheading">Belge Zorunluluğu Kapsamındaki Meslekler</h3>
<?php	}else{ ?>
			<h3 class="contentheading">Ulusal Yeterlilik Ara</h3>
<?php   } ?>

  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<form action="?option=com_yeterlilik_ara&<?php echo (isset($get['belge_zorunlu']) && $get['belge_zorunlu'] == 1 ? "belge_zorunlu=1" : "");?>" method="post">
	<table cellspacing="0" class="display compact"  width="100%" id="searchcriters">
		<tr>
			<td>Yeterlilik Kodu:</td>
			<td><input type="text" name="yeterlilik_kodu" value="<?php echo $yeterlilik_kodu;?>" /></td>
		</tr>
		<tr>
			<td>Yeterlilik Adı:</td>
			<td><input type="text" name="yeterlilik_adi" value="<?php echo $yeterlilik_adi;?>" /></td>
		</tr>
		<tr>
			<td>Seviye:</td>
			<td><?php echo seviyeleriGoster($db,$seviye_id)?></td>
		</tr>
		<tr>
			<td>Sektör:</td>
			<td><?php echo sektorleriGoster($db,$sektor_id)?></td>
		</tr>
		<tr>
			<td>Belgelendirme Kuruluşu:</td>
			<td><?php echo kuruluslariGoster($db,$kurulus_id)?></td>
		</tr>	
		<tr>
			<td></td>
			<td><input type="checkbox" name="kurulusiceren" value="1" <?php echo ($kurulusiceren <> "" ? "checked = 'checked'" : "");?> style="float:left;"/>&nbsp;&nbsp;&nbsp;Belgelendirilen ulusal yeterlilikler</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="checkbox" name="yeterlilik_belge_zorunluluk_durum" value="1" <?php echo ($yeterlilik_belge_zorunluluk_durum <> "" ? "checked = 'checked'" : "");?> style="float:left;"/>&nbsp;&nbsp;&nbsp;Belge zorunluluğu getirilmiş ulusal yeterlilikler</td>
		</tr>
<?php  if(1 == 2){  ?>
		<tr>
			<td></td>
			<td><input type="checkbox" name="yeterlilik_tehlikeli_is_durum" value="1" <?php echo ($yeterlilik_tehlikeli_is_durum <> "" ? "checked = 'checked'" : "");?> style="float:left;"/>&nbsp;&nbsp;&nbsp;Tehlikeli ve çok tehlikeli işler sınıfındaki ulusal yeterlilikler</td>
		</tr>
		<?php }?>
		<tr>
			<td></td>
			<td><input type="submit" value="Ara">
			 <div class="div40 fRgiht" style="float:right;">
			 <?php if(!isset($get['belge_zorunlu'])){ ?>	
	            <a href="http://www.myk.gov.tr/index.php?option=com_yeterlilik_sor&view=yeterlilik_sor&layout=serlist" target="_blank" style="text-decoration:underline;">
	                <center><img style="width:90px;height:70px;" src="<?php echo SITE_URL; ?>/templates/elegance/images/europass.png"/>
	                    <h2 style="font-size: 12px;">Ulusal Yeterliliklere İlişkin Europass Sertifika Eki Listesi İçin Tıklayın</h2></center>
	            </a>
			<?php }else{ ?>
				 <br><a href="http://myk.gov.tr/index.php/tr/myk-meslek-yeterllk-belges-zorunluluu-sayfasi" target="_blank" style="text-decoration:underline;">
	                <center><img style="width:60px;height:58px;" src="<?php echo SITE_URL; ?>/images/editor/belge_tablo.png"/>
	                    <h2 style="font-size: 12px;">MYK Mesleki Yeterlilik Belgesi zorunluluğu hakkında detaylı bilgi almak için tıklayınız</h2></center>
	            </a>
			<?php } ?>
	        </div>
			
			</td>
		</tr>
	</table>
</form>
<br>
<div class="tableWrapper">
	<table cellspacing="0" class="display compact" id="yeterlilikListesiGrid" border="1"  width="100%">
		<thead>
			<tr class="tablo_header">
				<th class="sortable">#</th>
				<th class="sortable-text" width="10%">Yeterlilik Kodu</th>
				<th class="sortable-text">Yeterlilik Adı</th>
				<th class="sortable-text">Seviye</th>
				<th class="sortable-text">Sektör</th>
				<th class="sortable-text">Revizyon</th>
				<th class="sortable-text">Belgelendirme Kuruluşu</th>
				<th>Pdf</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			if(count($grouped) < 1){ ?>
				<tr>
					<td colspan="8" style="  text-align: center; padding: 10px;">Seçimlerinize uygun yeterlilik bulunamadı.</td>
				</tr>
		<?php }else{
				$i = 1;
				foreach ($grouped as $data) {
					if($i%2==0)
						$rowClass = "even_row even";
					else
						$rowClass = "odd_row odd";
					
					$rowspan = (count($data['REVIZYONBILGILERI']) > 1 ? count($data['REVIZYONBILGILERI']) : "");
				?>
				<tr class="<?php echo $rowClass;?>">
					<td <?php echo ($rowspan <> "" ? "rowspan ='".$rowspan."'" : "");?>><?php echo $i;?></td>
					<td <?php echo ($rowspan <> "" ? "rowspan ='".$rowspan."'" : "");?>>
						<?php if($user_id <> "") { ?>
							<a href="javascript:void(0)" class="yeterlilik_detay" yetkod="<?php echo $data['YETERLILIK_KODU'];?>"><?php echo $data['YETERLILIK_KODU'];?></a>
						<?php }else{
							echo $data['YETERLILIK_KODU'];
						}?>
					</td>
					<td <?php echo ($rowspan <> "" ? "rowspan ='".$rowspan."'" : "");?> class="yetadi"><?php echo $data['YETERLILIK_ADI'];?></td>
					<td <?php echo ($rowspan <> "" ? "rowspan ='".$rowspan."'" : "");?>><?php echo ucfirst($data['SEVIYE_ADI']);?></td>
					<td <?php echo ($rowspan <> "" ? "rowspan ='".$rowspan."'" : "");?>><?php echo ucfirst($data['SEKTOR_ADI']);?></td>
					<?php $revizyon = current(($data['REVIZYONBILGILERI']));?>
						<td><?php echo $revizyon['REVIZYON'];?></td>
						<td>
							<ul>
							<?php foreach($revizyon['KURULUS_BILGILERI'] as $key => $val){ 
								echo "<li><a href='index.php?option=com_kurulus_ara&view=kurulus_ara&layout=kurulus&kurId=".$val['USER_ID']."' target='_blank'>".($val['KURULUS_KISA_ADI'] <> "" ? $val['KURULUS_KISA_ADI'] : $val['KURULUS_ADI'])."</a></li>";
							} ?>
							</ul>
						</td>
						<td><a href="index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&task=indir&id=4&yeterlilik_id=<?php echo $revizyon['YETERLILIK_ID'];?>" target="_blank"><img alt="PDF" src="<?php echo SITE_URL; ?>/templates/elegance/images/32pdf.png" /></a></td>
				</tr>
				
			<?php 
				if(count($data['REVIZYONBILGILERI']) > 1){
				unset($data['REVIZYONBILGILERI'][current(array_keys($data['REVIZYONBILGILERI']))]);
					foreach ($data['REVIZYONBILGILERI'] as $revizyon){ ?>
						<tr class="revizyon_row <?php echo $rowClass;?>">
							<td><?php echo $revizyon['REVIZYON'];?></td>
							<td>
							<ul>
							<?php foreach($revizyon['KURULUS_BILGILERI'] as $key => $val){ 
								echo "<li><a href='index.php?option=com_kurulus_ara&view=kurulus_ara&layout=kurulus&kurId=".$val['USER_ID']."' target='_blank'>".($val['KURULUS_KISA_ADI'] <> "" ? $val['KURULUS_KISA_ADI'] : $val['KURULUS_ADI'])."</a></li>";	
							} ?>
							</ul>
							</td>
							<td><a href="index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&task=indir&id=4&yeterlilik_id=<?php echo $revizyon['YETERLILIK_ID'];?>"><img alt="PDF" src="<?php echo SITE_URL; ?>/templates/elegance/images/32pdf.png" /></a></td>
						</tr>
			<?php }
				}
			$i++;
				}
		} ?>
		</tbody>
	</table>
</div>
<div class="revizyonDataPopupDiv" id="revizyonDataPopupDiv" style="border: 1px solid #00A7DE; padding: 10px; width:550px; display:none; background-color: white;">
	<div style="background-color:#1C617C; color:#FFF; height:30px; line-height:30px; padding:0 0 0 10px; margin: -11px -10px 0 -11px;">
		<strong>Yeterlilik Bilgisi </strong>
	</div>
	<div style="padding:15px;">
		<table width="100%" id="revizyonDataPopupDivContent">
			<tr>
				<td width="20%">Yeterlilik Kodu</td>
				<td width="20%" class="yeterlilikkodu"></td>
			</tr>
			<tr>
				<td>Yeterlilik Adi</td>
				<td class="yeterlilikadi"></td>
			</tr>
			<tr>
				<td>Seviye</td>
				<td class="seviyeadi"></td>
			</tr>
			<tr>
				<td>Sektör</td>
				<td class="sektoradi"></td>
			</tr>
			<tr>
				<td colspan="2"><b>Revizyon bilgileri<b></b></td>
			</tr>
			<tr>
				<td colspan="2" id="revizyoncontent"></td>
			</tr>
		</table>
	</div>
	<div style="background-color:#1C617C; color:#FFF; height:30px; line-height:30px; padding:0 0 0 10px; margin: -6px -10px -11px -11px;">
 		<div style="float:right; width:%20; margin:5px 20px 0 0;">
 			<input class="revizyonDataPopupDivCancel" id="revizyonDataPopupDivCancel" value="İPTAL" type="button" style="margin-left:10px;">
 		</div>
	</div>
</div>
<script>
jQuery(document).ready(function(){
	jQuery(".yeterlilik_detay").click(function(){
		var yetkod = jQuery(this).attr('yetkod');
		var temphtml = "";
		jQuery.ajax({
			  url: "index.php?option=com_yeterlilik_taslak_yeni&task=getYeterlilikDatas&format=raw",
			  data: "yeterlilikkodu="+yetkod,
			  type: "POST",
			  dataType: 'json',
			  beforeSend:function(){
	 			jQuery.blockUI();
		 	  },
			  success: function(data) {
				 temphtml = "<table border='1' cellspacing='0' width='100%'>";
				 jQuery(".yeterlilikkodu").html(data[yetkod].YETERLILIK_KODU);
				 jQuery(".yeterlilikadi").html(data[yetkod].YETERLILIK_ADI);
				 jQuery(".seviyeadi").html(data[yetkod].SEVIYE_ADI);
				 jQuery(".sektoradi").html(data[yetkod].SEKTOR_ADI);
				 console.log(data[yetkod].REVIZYONBILGILERI);
				 jQuery.each( data[yetkod].REVIZYONBILGILERI, function( key, revizyon ) {
					  temphtml += "<tr>"+
									"<td width='5%'>"+revizyon.REVIZYON+"</td>"+
									"<td><ul>";
					   jQuery.each( revizyon.KURULUS_BILGILERI, function( key, kurulus ) {
						   temphtml +="<li>"+kurulus+"</li>";
					   });		
					   temphtml +="</ul></td>"+
							"<td><a href='index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&task=indir&id=4&yeterlilik_id="+revizyon.YETERLILIK_ID+"'><img alt='PDF' src='<?php echo SITE_URL; ?>/templates/elegance/images/32pdf.png' /></a></td>"+
					   "</tr>";
					});
				temphtml += "</table>"; 
				jQuery(".revizyonDataPopupDiv table#revizyonDataPopupDivContent #revizyoncontent").html(temphtml);
			  },
 			  complete : function (){
 				jQuery.unblockUI();
 				jQuery('#revizyonDataPopupDiv').lightbox_me({
 			        centered: true,
 			        closeClick:false,
 			        closeEsc:false
 			        });
              }
			});	
	});

	jQuery(".revizyonDataPopupDivCancel").click(function(){
		jQuery('#revizyonDataPopupDiv').trigger('close');
	});
// 	jQuery('#yeterlilikListesiGrid').dataTable({
// 		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
// 		"bInfo": true,
// 		"bPaginate": false,
// 		"bFilter": true,
// 		"sPaginationType": "full_numbers",
// 		"oLanguage": {
// 			"sLengthMenu": "# _MENU_ öğe göster",
//			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
// 			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ öğe)",
// 			"sInfoEmpty": "0 - 0 öğeden 0'ı gösteriliyor.",
// 			"sSearch": "Ara",
// 			"oPaginate": {
//				"sFirst":    "<?php echo JText::_("FIRST");?>",
// 				"sPrevious": "Önceki",
// 				"sNext":     "Sonraki",
//				"sLast":     "<?php echo JText::_("LAST");?>"
// 			}
// 		}
// 		});	
});

</script>
<?php 
function kuruluslariGoster($db,$kurulus_id = null){
	$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI FROM M_KURULUS
				  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
				  INNER JOIN M_BELGELENDIRME_YET_YETKI ON M_BELGELENDIRME_YET_YETKI.USER_ID = M_KURULUS.USER_ID  
				WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.KURULUS_DURUM_ID IN(".SINAV_BELGELENDIRME_KURULUS_DURUM_IDS.")
				UNION
			SELECT DISTINCT M_KURULUS.USER_ID, M_KURULUS.KURULUS_ADI FROM M_KURULUS
				  INNER JOIN M_BELGELENDIRME_YET_YETKI ON M_BELGELENDIRME_YET_YETKI.USER_ID = M_KURULUS.USER_ID
				  WHERE M_KURULUS.USER_ID NOT IN (SELECT M_KURULUS_EDIT.USER_ID FROM M_KURULUS_EDIT WHERE M_KURULUS_EDIT.AKTIF = 1)
				   AND M_KURULUS.KURULUS_DURUM_ID IN(".SINAV_BELGELENDIRME_KURULUS_DURUM_IDS.")
				ORDER BY KURULUS_ADI ASC";
     $kuruluslar = $db->prep_exec($sql, array());
     ?>
     	<select name="kurulus_id">
     		<option selected="selected" value="">Seçiniz</option>
     		<?php 
     		foreach($kuruluslar AS $kurulus)
     			echo '<option value="'.$kurulus['USER_ID'].'" '.($kurulus['USER_ID'] == $kurulus_id ? 'selected=\"selected\"' : '').'>'.$kurulus['KURULUS_ADI'].'</option>';
     		?>
     	</select>
     	<?php
}

function sektorleriGoster($db,$sektor_id = null){

	$sektorler = FormParametrik::getSektor();
	?>
	
	<select name="sektor_id">
		<option selected="selected" value="">Seçiniz</option>
		<?php 
		foreach($sektorler AS $sektor)
			echo '<option value="'.$sektor['SEKTOR_ID'].'" '.($sektor['SEKTOR_ID'] == $sektor_id ? 'selected=\"selected\"' : '').'>'.$sektor['SEKTOR_ADI'].'</option>';
		?>
	</select>
	<?php
}

function seviyeleriGoster($db,$seviye_id = null){

	$sql = "SELECT * FROM PM_SEVIYE ORDER BY SEVIYE_ADI ASC";

	$seviyeler = $db->prep_exec($sql, array());
	?>
	
	<select name="seviye_id">
		<option selected="selected" value="">Seçiniz</option>
		<?php 
		foreach($seviyeler AS $seviye)
			echo '<option value="'.$seviye['SEVIYE_ID'].'" '.($seviye['SEVIYE_ID'] == $seviye_id ? 'selected=\"selected\"' : '').'>'.$seviye['SEVIYE_ADI'].'</option>';
		?>
	</select>
	<?php
}
?>