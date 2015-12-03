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

$user = & JFactory::getUser();
$userId = $user->getOracleUserId();
$denetciMi = FormFactory::buIDDenetciMi($userId);
$denetlemesiYapilacakKurulusMu = FormFactory::buIDDenetlemesiYapilacakKurulusMu($user->id);
$isSektorSorumlusu = FormFactory::buIDDenetlemedenSorumluSSMu($user->id);

if($denetciMi==true)
	$denetimler = $this->bagliOldugumDenetimler;
else if($denetlemesiYapilacakKurulusMu == true)
{
	$kurulusMu = true;				
	$denetimler = $this->denetimlerim;//kurulus
}
else if($isSektorSorumlusu==true)
	$denetimler = $this->denetimListesi;


$AkIcDenetimListesi = $this->AkIcDenetimListesi;
$akDenetim = $AkIcDenetimListesi['akdenetim'];
$icDenetim = $AkIcDenetimListesi['icdenetim'];
?>

<form>


<table id="denetimListesiGrid" width="100%">
<thead><tr>
	<td class="sortable-text">#</td>
	<td class="sortable-text" align="center">KURULUŞ ADI</td>
	<td class="sortable-text">DENETIM TARİHİ</td>
	<td class="sortable-text">ÜCRET DURUMU</td>
	<td class="sortable-text">DENETİM RAPORU</td>
	<td class="sortable-text">UYGUNSUZLUK</td>
	<?php if($isSektorSorumlusu==true)
		echo '<td class="sortable-text">YETKILENDIRME</td>';
	?>
<!-- 	<td class="sortable-text">ÜCRET TARİFESİ</td> -->
	<td class="sortable-text">YETKİ KAPSAMI</td>
	<?php 
		if($isSektorSorumlusu==true)
			echo '<td class="sortable-text">BK KODU</td>
			<td class="sortable-text">YB KODU</td>';
		if($denetlemesiYapilacakKurulusMu==true)
			echo '<td>DENETİM PLANI</td>';
	?>
	</tr></thead>
<tbody>

<?php 
for($i=0; $i<count($denetimler); $i++)
{
	$denetim_id = $denetimler[$i]['DENETIM_ID'];
	$ekipListesi = getDenetimEkibiByDenetimID($denetim_id);
	
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
	
	$uygunsuzlukVarMiText = (uygunsuzlukVarMi($denetim_id) == true ) ? 'Var' : 'Yok';
	$uygunsuzlukVarMiColor = (uygunsuzlukVarMi($denetim_id) == true) ? 'red' : 'green';
	
	if(uygunsuzlukVarMi($denetim_id) == true)
	{
		$uygunsuzlukVarMiText = (giderilmemisUygunsuzlukVarMi($denetim_id) == true ) ?  $uygunsuzlukVarMiText : 'Giderilmis' ;
		$uygunsuzlukVarMiColor = (giderilmemisUygunsuzlukVarMi($denetim_id) == true) ?  $uygunsuzlukVarMiColor: 'green';
	}
	$denetimEkibiColor = (count(getDenetimEkibiByDenetimIDAndRolu($denetim_id, PM_DENETIM_EKIBI_ROLU__BAS_DENETCI)) > 0) ? 'green' : 'red';
	
	/*if(strlen($denetimler[$i]['DENETIM_RAPOR_PATH']) != 0) //rapor varsa linkli olsun
		$uygunsuzlukVarMiText = '<a style="color:'.$uygunsuzlukVarMiColor.'; text-decoration:underline;" href="index.php?option=com_denetim&layout=uygunsuzluk_listele&denetim_id='.$denetim_id.'">'.$uygunsuzlukVarMiText.'</a>';
	else 
	{
		if($denetlemesiYapilacakKurulusMu)
			$uygunsuzlukVarMiText = 'Yok';
		else//yani ss veya denetci
		(uygunsuzlukVarMi($denetim_id) == true ) ? 'Var' : 'Yok'
			$uygunsuzlukVarMiText = '<a style="color:gray; text-decoration:underline;" href="index.php?option=com_denetim&layout=rapor_aktar&denetim_id='.$denetim_id.'">Yok</a>';//Rapor Yükleyiniz
		
	}*/
	if(uygunsuzlukVarMi($denetim_id) == true)
	{
		$uygunsuzlukVarMiText = (giderilmemisUygunsuzlukVarMi($denetim_id) == true ) ?  $uygunsuzlukVarMiText : 'Giderilmis' ;
		$uygunsuzlukVarMiColor = (giderilmemisUygunsuzlukVarMi($denetim_id) == true) ?  $uygunsuzlukVarMiColor: 'green';
	}
	$uygunsuzlukVarMiText = '<a style="color:'.$uygunsuzlukVarMiColor.'; text-decoration:underline;" href="index.php?option=com_denetim&layout=uygunsuzluk_listele&denetim_id='.$denetim_id.'">'.$uygunsuzlukVarMiText.'</a>';
	
	
	if(strlen($denetimler[$i]['DENETIM_RAPOR_PATH']) != 0 && giderilmemisUygunsuzlukVarMi($denetim_id) == false ) //raporu varsa
	{	
		$yetkiColor='green';
		$yetkilendirilebilirMi = true;
		$yetkilendirmeText = '<a style="color:'.$yetkiColor.'; text-decoration:underline;" href="index.php?option=com_denetim&layout=yetkilendirme&denetim_id='.$denetim_id.'">Yetki Ver</a>';
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
	$yetkiKapsamiText = ($yetkilendirilebilirMi==true) ? '<a style="color:'.$yetkiColor.'; text-decoration:underline;" href="index.php?option=com_denetim&layout=yetki_kapsami&denetim_id='.$denetim_id.'">Yetki Kapsamı</a>' : '&nbsp;&nbsp;&nbsp;&nbsp;<font color="'.$yetkiColor.'"> - </font>';;
	
	
	
	$ybKoduColor = (strlen($denetimler[$i]['YB_KODU']) > 0) ? 'green' : 'red';
	$ybChangeLink = '<a style="color:'.$ybKoduColor.'; text-decoration:underline;" href="index.php?option=com_denetim&layout=kod_duzenle&denetim_id='.$denetim_id.'">'.((strlen($denetimler[$i]['YB_KODU']) > 0)?'YB-'.$denetimler[$i]['YB_KODU']:'Düzenle').'</a>';
	
	$bkKoduColor = (strlen($denetimler[$i]['BK_KODU']) > 0) ? 'green' : 'red';
	$bkChangeLink = '<font color="'.$bkKoduColor.'">'.((strlen($denetimler[$i]['BK_KODU']) > 0)?'BK-'.$denetimler[$i]['BK_KODU']:'Düzenle').'</font>';
	
	if($denetciMi || $isSektorSorumlusu)
	{
		$denetimRaporuText = '<a style="color:'.$denetimRaporuColor.'; text-decoration:underline;" href="index.php?option=com_denetim&layout=rapor_aktar&denetim_id='.$denetim_id.'">'.$denetimRaporuText.'</a>';
	}
	else //kuruluş
	{
		$denetimRaporuText = '<font color="'.$denetimRaporuColor.'">'.$denetimRaporuText.'</font></td>';
	}
	
	if($isSektorSorumlusu==true || $denetciMi)
		$denetimKurulusField = '<a href="index.php?option=com_denetim&layout=yeni_denetim&denetim_id='.$denetim_id.'">'.$denetimler[$i]['KURULUS_ADI'].$YBVeyaBKKod.'</a>';
	else
		$denetimKurulusField = $denetimler[$i]['KURULUS_ADI'];
	
	echo '<tr class="'.$evenOdd.'" id="'.$denetim_id.'">
	<td><input type="checkbox" class="denetimlerCheckbox" id="denetimlerCheckbox-'.$denetimler[$i]['USER_ID'].'" value="'.$denetimler[$i]['USER_ID'].'"></td>
	<td>'.$denetimKurulusField.'</td>
	<td><font color="'.$tarihColor.'">'.$denetimler[$i]['DENETIM_TARIHI_BASLANGIC'].'</font></td>
	<td><font color="'.$parasiColor.'">'.$parasiYattiMi.'</font></td>
	<td>'.$denetimRaporuText.'</td>
	<td>'.$uygunsuzlukVarMiText.'</td>';
	
	if($isSektorSorumlusu==true)
		echo '<td>'.$yetkilendirmeText.'</td>';
	
	//'<td>'.$ucretTarifesiText.'</td>
		echo '	<td>'.$yetkiKapsamiText.'</td>';
	
	if($isSektorSorumlusu==true)
		echo '<td>'.$bkChangeLink.'</td><td>'.$ybChangeLink.'</td>';
	
	if($denetlemesiYapilacakKurulusMu==true)
		echo '<td><a href="index.php?option=com_denetim&layout=denetim_planim&denetim_id='.$denetim_id.'">Denetim Planım</a></td>';
		
	echo '</tr>';

		

}
?>

</tbody></table>
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
<?php if($kurulusMu){ ?>
<div class="anaDiv">
    <a class="btn btn-xs btn-primary" href="index.php?option=com_profile&view=profile&layout=ekler&kurulus=<?php echo $userId; ?>#table_ekdokumantasyon"><i class="fa fa-plus"></i> Akreditasyon Denetim Raporu Ekle</a>
</div>
<?php } ?>
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
<?php if($kurulusMu){ ?>
<div class="anaDiv">1q2w3e4r
    <a class="btn btn-xs btn-primary" href="index.php?option=com_profile&view=profile&layout=ekler&kurulus=<?php echo $userId; ?>#table_akdenetim"><i class="fa fa-plus"></i> İç Denetim Raporu Ekle</a>
</div>
<?php } ?>
<?php
function getDenetimEkibiByDenetimID($denetim_id)
{
	$db  = &JFactory::getOracleDBO();
	
	$sql = "SELECT *
	FROM M_DENETIM_EKIP, M_UZMAN_HAVUZU WHERE 
	M_DENETIM_EKIP.PERSONEL_ID = M_UZMAN_HAVUZU.USER_ID 
	AND DENETIM_ID = ?
	AND M_UZMAN_HAVUZU.DURUM = 2";
	
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
	AND DURUM=2 AND DENETIM_ID = ?
	AND M_DENETIM_EKIP.PERSONEL_ROLU = ?";

	return $db->prep_exec($sql, array($denetim_id, $rol));

}

?>