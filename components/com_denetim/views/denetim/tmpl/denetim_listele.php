<style>
#denetimListesiGrid thead tr td
{
	font-weight: bold;
	padding:3px;
}
#yeniButton {
    background-image: url("images/ekle.png");
    background-position: left center;
    background-repeat: no-repeat;
    cursor: pointer;
    padding: 2px 5px 2px 18px;
}
</style>


<?php 

$model = $this->getModel();


$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );
$document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );


$denetimler = $this->denetimListesi;
$AkIcDenetimListesi = $this->AkIcDenetimListesi;
$akDenetim = $AkIcDenetimListesi['akdenetim'];
$icDenetim = $AkIcDenetimListesi['icdenetim'];
?>

<form>
<?php 
if(isset($_GET['kid'])){
    echo '<div class="anaDiv font20 hColor text-center">';
	echo '<u>'.$denetimler[0]['KURULUS_ADI'].' Kuruluşunun Denetimleri</u>';
    echo '</div>';
} ?>
<div class="anaDiv font18 hColor fontBold">
    MYK Denetimleri
</div>
<div class="anaDiv">
<input id="yeniButton" type="button" 
onclick="window.location='index.php?option=com_denetim&layout=yeni_denetim';"
name="yeniButton" value="Yeni Denetim">
<input type="button" onclick="window.location='index.php?option=com_denetim&layout=kurulus_denetim';" value="Kuruluş Bazlı Denetimleri Görüntüle"  class="btn btn-xs btn-primary">
<?php if(isset($_GET['kid'])){?>
	<input type="button"
	onclick="window.location='index.php?option=com_denetim&layout=denetim_listele';"
	value="Bütün Denetimleri Görüntüle" class="btn btn-xs btn-primary">
<?php } ?>
</div>
<div class="anaDiv" style="overflow: auto;">
<table id="denetimListesiGrid" style="text-align:center">
<thead><tr>
	<td class="sortable-text" width="3%">#</td>
	<td class="sortable-text" width="30%" align="center">KURULUŞ ADI</td>
	<td class="sortable-text" width="10%">DENETIM TÜRÜ</td>
	<td class="sortable-text" width="5%">DENETIM TARİHİ</td>
	<td class="sortable-text" width="5%">ÜCRET DURUMU</td>
	<td class="sortable-text" width="5%">EKİPTEKİ KİŞİ SAYISI</td>
	<td class="sortable-text" width="10%">DENETİM RAPORU</td>
	<td class="sortable-text" width="7%">UYGUNSUZLUK</td>
	<td class="sortable-text" width="5%">YETKILENDIRME</td>
<!-- 	<td class="sortable-text" width="5%">ÜCRET TARİFESİ</td> -->
	<td class="sortable-text" width="5%">YETKİ KAPSAMI</td>
	<td class="sortable-text" width="5%">BK KODU</td>
	<td class="sortable-text" width="5%">YB KODU</td>
</tr></thead>
<tbody>

<?php 
for($i=0; $i<count($denetimler); $i++)
{
	$denetim_id = $denetimler[$i]['DENETIM_ID'];
	$ekipListesi = getDenetimEkibiByDenetimID($denetim_id);
	$disekiplistesi = getDisDenetimEkibiByDenetimID($denetim_id);
	
	$denetimTuru = getDenetimturuByDenetimID($denetim_id);
	
	$evenOdd = ($i % 2 == 0 ) ? 'even' : 'odd';
	$denetimTarihi=explode("/",$denetimler[$i]['DENETIM_TARIHI_BASLANGIC']);
	$denetimTarihiTimeStamp=mktime(0, 0, 0, $denetimTarihi[1], $denetimTarihi[0], $denetimTarihi[2]);
	$bugunTimeStamp=strtotime(date('d-m-Y'));
	$kirmiziOlmaSuresi=30;
	if ($bugunTimeStamp>$denetimTarihiTimeStamp) {
		$tarihColor = 'green' ;
	}else if ($bugunTimeStamp + $kirmiziOlmaSuresi*24*60*60 > $denetimTarihiTimeStamp) {
		$tarihColor = 'red' ;
	} else {
		$tarihColor = 'black' ;
		
	}
	
	
	
	$parasiYattiMi = ($model->denetimUcretiYatmisMi($denetim_id)==true ) ? 'Yatırılmış' : 'Yatırılmamış';
	$parasiColor = ($model->denetimUcretiYatmisMi($denetim_id)==true  ) ? 'green' : 'red';

	$denetimRaporuColor = (strlen($denetimler[$i]['DENETIM_RAPOR_PATH']) > 0) ? 'green' : 'red';
	$denetimRaporuText = (strlen($denetimler[$i]['DENETIM_RAPOR_PATH']) > 0) ? 'Rapor yüklendi' : 'Rapor yüklenmedi';
	
	$uygunsuzlukVarMiText = (uygunsuzlukVarMi($denetim_id) == true ) ? 'Uygunsuzluk Var' : 'Uygunsuzluk Yok';
	$uygunsuzlukVarMiColor = (uygunsuzlukVarMi($denetim_id) == true) ? 'red' : 'green';
	
	if(uygunsuzlukVarMi($denetim_id) == true)
	{
		$uygunsuzlukVarMiText = (giderilmemisUygunsuzlukVarMi($denetim_id) == true ) ?  $uygunsuzlukVarMiText : 'Giderilmis' ;
		$uygunsuzlukVarMiColor = (giderilmemisUygunsuzlukVarMi($denetim_id) == true) ?  $uygunsuzlukVarMiColor: 'green';
	}
	$denetimEkibiColor = (count(getDenetimEkibiByDenetimIDAndRolu($denetim_id, PM_DENETIM_EKIBI_ROLU__BAS_DENETCI)) > 0) ? 'green' : 'red';
	
	/*
	 if(strlen($denetimler[$i]['DENETIM_RAPOR_PATH']) != 0) //rapor varsa linkli olsun
		$uygunsuzlukVarMiText = '<a style="color:'.$uygunsuzlukVarMiColor.'; text-decoration:underline;" href="index.php?option=com_denetim&layout=uygunsuzluk_listele&denetim_id='.$denetim_id.'">'.$uygunsuzlukVarMiText.'</a>';
	else 
		$uygunsuzlukVarMiText = '<a style="color:gray; text-decoration:underline;" href="index.php?option=com_denetim&layout=rapor_aktar&denetim_id='.$denetim_id.'">Yok</a>';//Rapor Yükleyiniz
	*/
	$uygunsuzlukVarMiText = '<a style="color:'.$uygunsuzlukVarMiColor.'; text-decoration:underline;" href="index.php?option=com_denetim&layout=uygunsuzluk_listele&denetim_id='.$denetim_id.'">'.$uygunsuzlukVarMiText.'</a>';
	
	
	
	if(strlen($denetimler[$i]['DENETIM_RAPOR_PATH']) != 0 && giderilmemisUygunsuzlukVarMi($denetim_id) == false ) //raporu varsa
	{	
		$yetkiColor='green';
		$yetkilendirilebilirMi = true;
// 		$yetkilendirmeText = '<a style="color:'.$yetkiColor.'; text-decoration:underline;" href="index.php?option=com_denetim&layout=yetkilendirme&denetim_id='.$denetim_id.'">Yetki Ver</a>';
		$yetkilendirmeText = '<a style="color:'.$yetkiColor.'; text-decoration:underline;" href="index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki&layout=kurulus_yetki&kurulusId='.$denetimler[$i]['DENETIM_KURULUS_ID'].'" target="_blank">Yetki Ver</a>';
	}
	else
	{
		$yetkiColor='red';
		$yetkilendirilebilirMi = false;
		$yetkilendirmeText = '&nbsp;&nbsp;&nbsp;&nbsp;<font color="'.$yetkiColor.'"> - </font>';
		
	}
	
	$YBVeyaBKKod= (strlen($denetimler[$i]['YB_KODU'])>0) 
				? ' - (YB-'.$denetimler[$i]['YB_KODU'].')' 
				: ( (strlen($denetimler[$i]['BK_KODU'])>0) 
							? ' - (BK-'.$denetimler[$i]['BK_KODU'].')' 
							: "");
	$ucretTarifesiText = ($yetkilendirilebilirMi==true) ? '<a style="color:'.$yetkiColor.'; text-decoration:underline;" href="index.php?option=com_denetim&layout=ucret_tarifesi&kurulus_id='.$denetimler[$i]['DENETIM_KURULUS_ID'].'">Ücret Tarifesi</a>' : '&nbsp;&nbsp;&nbsp;&nbsp;<font color="'.$yetkiColor.'"> - </font>';;
	$yetkiKapsamiText = ($yetkilendirilebilirMi==true) ? '<a style="color:'.$yetkiColor.'; text-decoration:underline;" href="index.php?option=com_belgelendirme_yetki&view=belgelendirme_yetki&layout=kurulus_yetki&kurulusId='.$denetimler[$i]['DENETIM_KURULUS_ID'].'" target="_blank">Yetki Kapsamı</a>' : '&nbsp;&nbsp;&nbsp;&nbsp;<font color="'.$yetkiColor.'"> - </font>';;
	
	
	
	$ybKoduColor = (strlen($denetimler[$i]['YB_KODU']) > 0) ? 'green' : 'red';
	$ybChangeLink = '<a style="color:'.$ybKoduColor.'; text-decoration:underline;" href="index.php?option=com_denetim&layout=kod_duzenle&denetim_id='.$denetim_id.'">'.((strlen($denetimler[$i]['YB_KODU']) > 0)?'YB-'.$denetimler[$i]['YB_KODU']:'Düzenle').'</a>';
	
	if(strlen($denetimler[$i]['BK_KODU']) == 0 && strlen($denetimler[$i]['YB_KODU']) > 0){
		$bkChangeLink = '-';
	}
	else{
		$bkKoduColor = (strlen($denetimler[$i]['BK_KODU']) > 0) ? 'green' : 'red';
		$bkChangeLink = '<a style="color:'.$bkKoduColor.'; text-decoration:underline;" href="index.php?option=com_denetim&layout=kod_duzenle&denetim_id='.$denetim_id.'">'.((strlen($denetimler[$i]['BK_KODU']) > 0)?'BK-'.$denetimler[$i]['BK_KODU']:'Düzenle').'</a>';
	}
	
// 	echo '<tr class="'.$evenOdd.'" id="'.$denetim_id.'">
// 	<td><input type="checkbox" class="denetimlerCheckbox" id="denetimlerCheckbox-'.$denetimler[$i]['USER_ID'].'" value="'.$denetimler[$i]['USER_ID'].'"></td>
// 	<td><a href="index.php?option=com_denetim&layout=yeni_denetim&denetim_id='.$denetim_id.'">'.$denetimler[$i]['KURULUS_ADI'].$YBVeyaBKKod.'</a></td>
// 	<td><font color="green">'.$denetimTuru[0]['DENETIM_TURU_ACIKLAMA'].'</font></td>
// 	<td><font color="'.$tarihColor.'">'.$denetimler[$i]['DENETIM_TARIHI_BASLANGIC'].'</font></td>';
	echo '<tr class="'.$evenOdd.'" id="'.$denetim_id.'">
	<td>'.$denetim_id.'</td>
	<!-- <td><a href="index.php?option=com_denetim&layout=yeni_denetim&denetim_id='.$denetim_id.'">'.$denetimler[$i]['KURULUS_ADI'].$YBVeyaBKKod.'</a></td>-->
			<td><a href="index.php?option=com_denetim&layout=denetim_ekibi&denetim_id='.$denetim_id.'">'.$denetimler[$i]['KURULUS_ADI'].$YBVeyaBKKod.'</a></td>
	<td><font color="green">'.$denetimTuru[0]['DENETIM_TURU_ACIKLAMA'].'</font></td>
	<td><font color="'.$tarihColor.'">'.$denetimler[$i]['DENETIM_TARIHI_BASLANGIC'].'</font></td>';
	
	//<td><a style="color:'.$parasiColor.'; text-decoration:underline;" href="index.php?option=com_denetim&task=togglePara&denetim_id='.$denetim_id.'" class="ucretDurumuLink" onClick="return confirm(\'Ücret Durumunu Değiştirmek İstediğinize Emin Misiniz?\')">'.$parasiYattiMi.'</a></td>
	echo '<td><a href="index.php?option=com_finans&layout=kurulus_finansal_bilgileri&uid='.$denetimler[$i]['DENETIM_KURULUS_ID'].'" target="_blank"><font color="'.$parasiColor.'" >'.$parasiYattiMi.'</font></a></td>';
	
	echo 
	'<td><a style="color:'.$denetimEkibiColor.'; text-decoration:underline;" href="index.php?option=com_denetim&layout=denetim_ekibi&denetim_id='.$denetim_id.'">'.(count($ekipListesi)+count($disekiplistesi)).'</a></td>
	<td><a style="color:'.$denetimRaporuColor.'; text-decoration:underline;" href="index.php?option=com_denetim&layout=rapor_aktar&denetim_id='.$denetim_id.'">'.$denetimRaporuText.'</a></td>
	<td>'.$uygunsuzlukVarMiText.'</td>
	<td>'.$yetkilendirmeText.'</td>';
	
	//<td>'.$ucretTarifesiText.'</td>
	echo '<td>'.$yetkiKapsamiText.'</td>
	
	<td>'.$bkChangeLink.'</td>
	<td>'.$ybChangeLink.'</td>
	</tr>';



}
?>

</tbody></table>
</div>
</form>
<div class="anaDiv">
    <hr>
</div>
<div class="anaDiv font18 fontBold hColor">
    Akreditasyon Denetimleri
</div>
<?php if($akDenetim){ ?>
<div class="anaDiv">
    <table style="width:100%;">
        <thead>
        <tr>
            <th width="40%">Döküman</th>
            <th width="30%">Yükleme Tarihi</th>
        </tr>
        </thead>
        <tbody style="text-align:center">
        <?php foreach ($akDenetim as $row) {
            echo '<tr>';
            echo '<td><a target = "_blank" href = "index.php?dl='.$row['BELGE_PATH'].'">'.$row['BELGE'].'</a></td>';
            echo '<td>'.$row['TARIH'].'</td >';
            echo '</tr>';
        } ?>
        </tbody>
    </table>
</div>
<?php }?>
<div class="anaDiv">
    <a class="btn btn-xs btn-primary" href="index.php?option=com_profile&view=profile&layout=ekler&kurulus=<?php echo $_GET['kid']; ?>#table_ekdokumantasyon"><i class="fa fa-plus"></i> Akreditasyon Denetim Raporu Ekle</a>
</div>
<div class="anaDiv">
    <hr>
</div>

<div class="anaDiv font18 fontBold hColor">
    İç Denetimler
</div>
<?php if($icDenetim){ ?>
<div class="anaDiv">
    <table style="width:100%;">
        <thead>
        <tr>
            <th width="40%">Döküman</th>
            <th width="30%">Yükleme Tarihi</th>
        </tr>
        </thead>
        <tbody style="text-align:center">
        <?php foreach ($icDenetim as $row) {
            echo '<tr>';
            echo '<td><a target = "_blank" href = "index.php?dl='.$row['BELGE_PATH'].'">'.$row['BELGE'].'</a></td>';
            echo '<td>'.$row['TARIH'].'</td >';
            echo '</tr>';
        } ?>
        </tbody>
    </table>
</div>
<?php } ?>
<div class="anaDiv">
    <a class="btn btn-xs btn-primary" href="index.php?option=com_profile&view=profile&layout=ekler&kurulus=<?php echo $_GET['kid']; ?>#table_akdenetim"><i class="fa fa-plus"></i> İç Denetim Raporu Ekle</a>
</div>
<script>
var settings = {
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
		"oLanguage": {
			"sLengthMenu": "<?php echo JText::_("LENGTH_MENU");?>",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "<?php echo JText::_("INFO");?>",
			"sInfoEmpty": "<?php echo JText::_("INFO_EMPTY");?>",
			"sInfoFiltered": "<?php echo JText::_("INFO_FILTERED");?>",
			"sSearch": "<?php echo JText::_("SEARCH");?>",
			"oPaginate": {
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "<?php echo JText::_("PREVIOUS");?>",
				"sNext":     "<?php echo JText::_("NEXT");?>",
				"sLast":     "<?php echo JText::_("LAST");?>"
			}
		}
	};
jQuery('#denetimListesiGrid').dataTable(settings);
</script>
<?php 
function getDenetimEkibiByDenetimID($denetim_id)
{
	$db  = &JFactory::getOracleDBO();
	
	$sql = "SELECT *
	FROM M_DENETIM_EKIP, M_UZMAN_HAVUZU WHERE 
	M_DENETIM_EKIP.PERSONEL_ID = M_UZMAN_HAVUZU.USER_ID 
	AND DENETIM_ID = ?
	AND M_UZMAN_HAVUZU.BASVURU_DURUM = 2
	";
	
	$result = $db->prep_exec($sql, array($denetim_id));
	if(count($result)>0)
		return $result;
	else
		return null;
}

function getDisDenetimEkibiByDenetimID($denetim_id)
{
	$db  = &JFactory::getOracleDBO();

	$sql = "SELECT * FROM M_UZMAN_DIS WHERE DENETIM_ID = ?";

	$result = $db->prep_exec($sql, array($denetim_id));
	if(count($result)>0)
		return $result;
	else
		return null;
}

function giderilmemisUygunsuzlukVarMi($denetim_id)
{
	$db  = &JFactory::getOracleDBO();

	$sql = "SELECT *
	FROM M_UYGUNSUZLUK WHERE DENETIM_ID = ? AND GIDERILDI_MI != 1 
	";

	$result = $db->prep_exec($sql, array($denetim_id));
	if(count($result)>0)
		return true;
	else
		return false;
}

function uygunsuzlukVarMi($denetim_id)
{
	$db  = &JFactory::getOracleDBO();

	$sql = "SELECT *
	FROM M_UYGUNSUZLUK WHERE DENETIM_ID = ?
	";

	$result = $db->prep_exec($sql, array($denetim_id));
	if(count($result)>0)
		return true;
	else
		return false;
}
function getDenetimEkibiByDenetimIDAndRolu($denetim_id, $rol)
{
	$db  = &JFactory::getOracleDBO();

	$sql = "SELECT *
	FROM M_DENETIM_EKIP, M_UZMAN_HAVUZU, PM_DENETIM_EKIP_ROLU
	WHERE M_DENETIM_EKIP.PERSONEL_ID = M_UZMAN_HAVUZU.USER_ID
	AND M_DENETIM_EKIP.PERSONEL_ROLU = PM_DENETIM_EKIP_ROLU.ROL_ID
	AND BASVURU_DURUM=2 AND DENETIM_ID = ?
	AND M_DENETIM_EKIP.PERSONEL_ROLU = ?";

	return $db->prep_exec($sql, array($denetim_id, $rol));

}

function getDenetimturuByDenetimID($denetim_id){
	$db  = &JFactory::getOracleDBO();

	$sql = "SELECT DENETIM_TURU_ACIKLAMA
		FROM M_DENETIM
		JOIN PM_DENETIM_TURU USING(DENETIM_TURU)
		WHERE DENETIM_ID = ?";
	
	return $db->prep_exec($sql, array($denetim_id));
}

?>