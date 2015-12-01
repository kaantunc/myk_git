<?php echo $this->sayfaLink;?>
<?php 
$user = & JFactory::getUser();
$userId = $user->getOracleUserId();		
$denetciMi = FormFactory::buIDDenetciMi($userId);
$denetlemesiYapilacakKurulusMu = FormFactory::buIDDenetlemesiYapilacakKurulusMu($user->id);
$isSektorSorumlusu = FormFactory::buIDDenetlemedenSorumluSSMu($user->id);

$yetkilendirilmisBirimlerYeni = $this->sinavYetkisiVerilmisBirimler_Detaylariyla;
$yetkilendirilmisBirimlerEski = $this->sinavYetkisiVerilmisBirimler_Detaylariyla_EskiFormattakiYeterlilikler;

$yetkilendirilmisBirimler = array_merge($yetkilendirilmisBirimlerYeni,$yetkilendirilmisBirimlerEski );
?>



<form method="post" action="index.php?option=com_denetim&task=yetkiKapsamiKaydet&denetim_id=<?php echo $_GET['denetim_id']; ?>">
<input type="hidden" value="<?php $_GET['denetim_id'];?>" name="denetim_id">
<h2 style="padding-bottom:5px;"><?php echo denetimIDdenKurulusAdiGetir($_GET['denetim_id']);?>’ın Yetkilendirildiği Yeterlilikler</h2>

<table border="1">
<thead>
	<tr><th>Yeterlilik</th><th>Açıklama</th><th>Yetkilendirilme Tarihi</th></tr>
</thead>
<tbody>
	<?php



$currentYeterlilikID = 0;
for($i=0; $i<count($yetkilendirilmisBirimler); $i++)
{	
	$currentBirimID = $yetkilendirilmisBirimler[$i]['BIRIM_ID'];
	$yeniYeterlilik = ($yetkilendirilmisBirimler[$i]['YETERLILIK_ID'] != $currentYeterlilikID) ? true : false; 
	if($yeniYeterlilik==true)
	{
		$currentYeterlilikID = $yetkilendirilmisBirimler[$i]['YETERLILIK_ID'];
		$yeterlilikIDleri[] = $yetkilendirilmisBirimler[$i]['YETERLILIK_ID'];
		$yeterliliklerTD[] 	= $yetkilendirilmisBirimler[$i]['YETERLILIK_KODU'].'/'.$yetkilendirilmisBirimler[$i]['REVIZYON'].' '.$yetkilendirilmisBirimler[$i]['YETERLILIK_ADI'];
		$birimlerTD[] 		= $yetkilendirilmisBirimler[$i]['BIRIM_KODU'];
		$yetkilendirilmeTarihiTD[] = str_replace('/','.', $yetkilendirilmisBirimler[$i]['YETKI_KAPSAMI_YETKI_TARIHI']);
	}
	else{
		$birimlerTD[count($birimlerTD)-1] .= ', '.$yetkilendirilmisBirimler[$i]['BIRIM_KODU'];	
        }
}

for($i=0; $i<count($yeterliliklerTD); $i++)
{	
	if($isSektorSorumlusu)
		$yetkilendirilmeTarihiText = '<input class="datepicker" 
		name="yetkiTarihi['.$yeterlilikIDleri[$i].'][]"
		value="'.$yetkilendirilmeTarihiTD[$i].'">';
	else
		$yetkilendirilmeTarihiText = $yetkilendirilmeTarihiTD[$i];
		
	echo '<tr><td>'.$yeterliliklerTD[$i].'</td>
			<td>'.$birimlerTD[$i].'</td>
			<td>'.$yetkilendirilmeTarihiText.'</td>
		</tr>';
}
if(count($yeterliliklerTD)==0)
	echo '<tr><td colspan="2">Yetkilendirilmiş Bir Birim Yok</td></tr>';


function denetimIDdenKurulusAdiGetir($denetim_id)
{
	$db  = &JFactory::getOracleDBO();
	
	$sql = "SELECT KURULUS_ADI 
	FROM M_DENETIM JOIN M_KURULUS ON (M_DENETIM.DENETIM_KURULUS_ID = M_KURULUS.USER_ID)
	WHERE DENETIM_ID=?";
	
	$result = $db->prep_exec($sql, array($denetim_id));
	return $result[0]['KURULUS_ADI'];
}


?>
</tbody> 

</table>
<br>
<br>
<?php 
if(count($yetkilendirilmisBirimler)>0)
	echo '<input type="hidden" name="user_id" value="'.$yetkilendirilmisBirimler[0]['USER_ID'].'">';


if($isSektorSorumlusu)
	echo '<input type="submit" value="KAYDET">';
	
?>


</form>
<script>
jQuery('.datepicker').datepicker({});
</script>

