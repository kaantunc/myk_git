<?php
defined('_JEXEC') or die('Restricted access');

$document = &JFactory::getDocument();

$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables_themeroller.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');

$sonuclar = $this->taslaklar;

if(empty($sonuclar)){
	echo '<div class="sonucBulunamadi">Henüz hiçbir taslak başvurusu bulunmamaktadır.</div>';
}
else{
?>
<style>
table tr{
	text-align:left;
} 
</style>
<div class="form_item" style="margin: 0 0 20px 0;">
  <div class="form_element cf_heading" style="margin:0;">
  	<?php if($this->sektorSorumlusu) {?>
  		<h3 class="contentheading">Ulusal Yeterlilik Taslakları</h3>
  	<?php }else{ ?>
  		<h3 class="contentheading">Yeterlilik Taslaklarım</h3>
  	<?php }?>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="tableWrapper">
<table cellspacing="0" id="datatable">
	<thead>
	<tr class="tablo_header">
		<th>#</th>
		<th>Id</th>
		<th>Yeterlilik Adı</th>
		<th>Yeterlilik Kodu</th>
		<th>Seviye</th>
		<th>Revizyon</th>
		<th>Sektör</th>
		<!--  <th class="sortable-text">Teslim Tarihi</th> -->
		<th>Taslak Durumu</th>
		<th>Taslağa Git</th>
		<!-- <th>Görüşleri Gör</th> -->
		<?php 
// 		if ($this->sektorSorumlusu)
// 			echo "<th>".JText::_("SEKTOR_SORUMLUSU_GIRECEGI_BILGILER")."</th>";
		?>
		<th>PDF</th>
	</tr>
	</thead>
	<tbody>
	<?php
		$user_browser = browser_detection('browser');
		$rowCount=1;
		$rowClass="";
		foreach($sonuclar AS $satir){
			
			$option = "com_yeterlilik_taslak_yeni";

			if($rowCount%2==0)
				$rowClass = "even_row";
			else
				$rowClass = "odd_row";

			if (strripos($user_browser, 'msie') !== FALSE) {
				$clickHTML = 'target="_blank" href="index.php?option='.$option.'&layout=pdf&format=pdf&form=5&id='.$satir['EVRAK_ID'].'&yeterlilik_id='.$satir['YETERLILIK_ID'].'"';
			} else {                     
				$clickHTML = 'onclick="window.open(\'index.php?option='.$option.'&layout=pdf&format=pdf&form=5&id='.$satir['EVRAK_ID'].'&yeterlilik_id='.$satir['YETERLILIK_ID'].'\',\'\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,directories=no,location=no\');"';
			}	
				
			$satir['YETERLILIK_BILGISI'] = ($satir['YETERLILIK_KODU'] <> "" ? current(explode('-',$satir['YETERLILIK_KODU'])) : "...")."-".$satir['SEVIYE_ID']."/".$satir['REVIZYON'];
			echo '<tr class="'.$rowClass.'">';
			
			echo '<td>'.$rowCount.'</td>';
			echo '<td>'.$satir['EVRAK_ID'].'</td>';
			echo '<td>'.$satir['YETERLILIK_ADI'].'</td>';
			echo '<td>'.($satir['YETERLILIK_KODU'] <> "" ? $satir['YETERLILIK_KODU'] : "-").'</td>';
			echo '<td>'.$satir['SEVIYE_ADI'].'</td>';
			echo '<td>'.$satir['REVIZYON'].'</td>';
			echo '<td>'.$satir['SEKTOR_ADI'].'</td>';
			echo '<td>'.$satir['YETERLILIK_SUREC_DURUM_ADI'].'</td>';
				
			if (!canOpenTaslak ($satir['YETERLILIK_SUREC_DURUM_ID'])){
				echo "<td>-</td>";
			}
			else{
				echo '<td><a href="index.php?option='.$option.'&layout=yeterlilik_taslak_yeni&yeterlilik_id='.$satir['YETERLILIK_ID'].'">Git</a></td>';
			}
						
			echo '<td>
				  	<a class="versions" rel="nofollow" >
						<input type="hidden" class="yeterlilikid" value="'.$satir['YETERLILIK_ID'].'" />
						<img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png">
					</a>
				</td>';
			echo '</tr>';
			$rowCount++;
		}
	?>
	</tbody>
</table>
</div>
<div class="versionsPopupDiv" id="versionsPopupDiv" style="border: 1px solid #00A7DE; padding: 10px; width:700px; display:none; background-color: white;">
	<div style="background-color:#1C617C; color:#FFF; height:30px; line-height:30px; padding:0 0 0 10px; margin: -11px -10px 0 -11px;">
		<strong>Versiyonlar </strong>
	</div>
	<div style="padding:15px;">
		<table width="100%">
			<tr>
				<td width="80%">Resmi görüşe/Kamuoyuna sunmadan önceki taslak</td>
				<td width="20%"><a href="#" id="gorus_oncesi">deede</a></td>
			</tr>
			<tr>
				<td>Sektör Komitelerine sunmadan önceki taslak</td>
				<td><a href="#" id="komite_oncesi">deede</a></td>
			</tr>
			<tr>
				<td>Yönetim Kuruluna sunmadan önceki taslak</td>
				<td><a href="#" id="kurul_oncesi">deede</a></td>
			</tr>
			<tr>
				<td>Yayınlanmış yeterlilik</td>
				<td><a href="#" id="son_taslak">deede</a></td>
			</tr>
		</table>
	</div>
	<div style="background-color:#1C617C; color:#FFF; height:30px; line-height:30px; padding:0 0 0 10px; margin: -6px -10px -11px -11px;">
 		<div style="float:right; width:%20; margin:5px 20px 0 0;">
 			<input class="versionsPopupDivCancel" id="versionsPopupDivCancel" value="İPTAL" type="button" style="margin-left:10px;">
 		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#datatable').dataTable({
		"aaSorting": [[ 2, "desc" ]],
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": "# _MENU_ öğe göster",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ öğe)",
			"sInfoEmpty": "0 - 0 öğeden 0'ı gösteriliyor.",
			"sSearch": "Ara",
			"oPaginate": {
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "Önceki",
				"sNext":     "Sonraki",
				"sLast":     "<?php echo JText::_("LAST");?>"
			}
		}
		});	

	
	jQuery(".versions").live('click',function(){
		jQuery('.versionsPopupDiv a').html('');
		yeterlilikid = jQuery(this).find('.yeterlilikid').val()
		jQuery.ajax({
			  url: "index.php?option=com_yeterlilik_taslak_yeni&task=getVersionDatas&format=raw",
			  data: "yeterlilikid="+yeterlilikid,
			  type: "POST",
			  dataType: 'json',
			  beforeSend:function(){
	 				 jQuery.blockUI();
		 		},
			  success: function(data) {
		
					if(data.datas['RESMI_GORUS_ONCESI_PDF'] != ""){
						jQuery('#gorus_oncesi').attr('href','index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&task=indir&id=1&yeterlilik_id='+yeterlilikid);
						jQuery('#gorus_oncesi').html(data.datas['RESMI_GORUS_ONCESI_PDF']);
					}else{
						jQuery('#gorus_oncesi').attr("href","javascript:void(0)");
						jQuery('#gorus_oncesi').html("-");
					}

					if(data.datas['SEKTOR_KOMITESI_ONCESI_PDF'] != ""){
						jQuery('#komite_oncesi').attr('href','index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&task=indir&id=2&yeterlilik_id='+yeterlilikid);
						jQuery('#komite_oncesi').html(data.datas['SEKTOR_KOMITESI_ONCESI_PDF']);
					}else{
						jQuery('#komite_oncesi').attr("href","javascript:void(0)");
						jQuery('#komite_oncesi').html("-");
					}		

					if(data.datas['YONETIM_KURULU_ONCESI_PDF'] != ""){
						jQuery('#kurul_oncesi').attr('href','index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&task=indir&id=3&yeterlilik_id='+yeterlilikid);
						jQuery('#kurul_oncesi').html(data.datas['YONETIM_KURULU_ONCESI_PDF']);
					}else{
						jQuery('#kurul_oncesi').attr("href","javascript:void(0)");
						jQuery('#kurul_oncesi').html("-");
					}

					if(data.datas['SON_TASLAK_PDF'] != ""){
						jQuery('#son_taslak').attr('href','index.php?option=com_yeterlilik_taslak_yeni&view=taslak_revizyon&task=indir&id=4&yeterlilik_id='+yeterlilikid);
						jQuery('#son_taslak').html(data.datas['SON_TASLAK_PDF']);
					}else{
						jQuery('#son_taslak').attr("href","javascript:void(0)");
						jQuery('#son_taslak').html("-");
					}
			  },
 			complete : function (){
 				jQuery.unblockUI();
             }
		});	
	    jQuery('#versionsPopupDiv').lightbox_me({
	        centered: true,
	        closeClick:false,
	        closeEsc:false,
	        });
        
	});

	jQuery("#versionsPopupDivCancel").live('click',function(){
		jQuery("#versionsPopupDivCancel").trigger('close');
	});
});
</script>
<?php
}

function canOpenTaslak ($durum){
	$reddedilmisIds = array (REDDEDILMIS_YETERLILIK);
	for ($i = 0; $i < count($reddedilmisIds); $i++){
		if ($reddedilmisIds[$i] == $durum)
			return false;
	}
	
	return true;
}

?>

