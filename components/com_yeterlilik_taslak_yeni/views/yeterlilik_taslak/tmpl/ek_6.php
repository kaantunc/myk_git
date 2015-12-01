<?php 
$yonetimKuruluTarihleri = $this->genelKurulTarihleri;

?>
<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak_yeni&layout=ek_6&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?> 
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">EK 6 : Yeterlilik Taslağının Görüşe Gönderildiği Kurum ve Kuruluşlar</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item" style="float:left; width:100%; padding: 15px 30px;">
	<input type="button" onclick="jQuery('#GenelKurul_wrapper').toggle('slow');"  value="Genel Kurul Listesinden Seç">

	<div style="display: none; border: 1px solid #898989; padding-left: 40px; padding-bottom:10px; margin-bottom:15px; padding-top: 10px; padding-right:10px; width: 90%; float: left;"
		class="GenelKurul_wrapper" id="GenelKurul_wrapper">
		
		<div style="float: left; width: 100%;">
			<div style="color: red;" id="GenelKurul_ErrorDiv" name="GenelKurul_ErrorDiv"></div>
		</div>
		<div style="float: left; width: 100%; height: 240px; overflow-y: scroll;">
			<table id="GenelKurulGrid" style="overflow:scroll; width: 100%; float:left;">
				<thead>
					<tr>
						<th>#</th>
						<th>Kuruluş Adı</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$genelKurul = $this->distinctGenelKurul;
				$x=0;
				for($i=0; $i<count($genelKurul); $i++)
				{
					if($i%2==1) $class="odd"; else $class="even";
					echo "<tr class='".$class."'>
							<td style='height:25px;'><input type='checkbox' name='genelKurul_idleri[]' class='genelKurul_idleri' value='".$genelKurul[$i]["UYE_ID"]."' ></input></td>
							<td>".$genelKurul[$i]["KURUM"]."</td>
							
						</tr>";
					
					
				}
				?>
				</tbody>
			</table>
		</div>

		
		<div style="float:left; width:100%">
		<input id="GenelKuruldanEkleButton" type="button" style="" value="EKLE"></input>
		</div>


	</div>
</div>


<div class="form_item"  style="float:left; width:100%; padding: 15px 30px;">
	<div style="float:left; width:100%;">
		<input type="button" style="float:left;"  value="Yeni Kuruluş(lar) Ekle" onclick="jQuery('#kurulusTopluEklemeDiv').toggle('slow');" />
	
	</div>
	<div style="float:left; width:100%; display:none;" id="kurulusTopluEklemeDiv">
		<textarea id="kurulusTopluEklemeTextArea" style="float:left; width:850px; height:150px; "></textarea>
		<input type="button" class="kurulusTopluEklemeTumunuEkleButton" id="kurulusTopluEklemeTumunuEkleButton" value="Tümünü Ekle" style="float:left; " />
	</div>
</div>



<div class="form_item"  style="float:left; width:100%;">
	<table id="ek6Tablosu" style="width:100%; padding-left:20px; padding-right:30px;">
		<thead><tr><th class="siraNoTD">Sıra No</th><th>Kurum/Kurulus Adı</th><th class="silButtonTD">SİL?</th></tr></thead>
		<tbody>
		<?php 
		$ek6Tablosu = $this->ek6Tablosu;
		for($i=0; $i<count($ek6Tablosu); $i++)
		{
			
			echo '<tr>
				<td class="siraNoTD">'.($i+1).'</td>
				<td><input style="width:100%;" type="text" id="inputkurulus-2-'.($i+1).'" name="inputkurulus-2[]" value="'.$ek6Tablosu[$i]["YETERLILIK_KURULUS_ADI"].'"></td>
				<td class="silButtonTD"><input type="button" value="SİL" onClick="jQuery(this.getParent().getParent()).remove(); tabloyuDuzenle(); " /></td>
			</tr>';
		}
		
		
		?>
		</tbody>
	</table>
</div>


<div style="width:100%; float: none; text-align:center;;">
<?php
echo "<select id='ytarih'>";
$i=0;
foreach ($yonetimKuruluTarihleri as $row){
	echo '<option value="'.$row['TARIH'].'">'.tariheDonustur($row['TARIH']).'</option>';
}
echo '</select>';
?>

<input type='button' id="tariheGoreGKGetirButton" value='Tarihli Genel Kurul Listesini Getir' onclick='listeGetir(jQuery("#ytarih").val(),1);' />
</div>



<?php 
if ($this->canEdit){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Kaydet" name="kaydet" type="submit" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}

echo $this->yorumDiv;

if ($this->sektorSorumlusu && $this->yorumDiv!=""){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('ek_6', <?php echo $this->yeterlilik_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>

</form>

<script type="text/javascript">

var settings = {
		"bPaginate": false,
 		"bFilter": false,
 		"bInfo": false,
	    
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

						
var oTable = jQuery('#ek6Tablosu').dataTable(settings);



<?php 
if ($this->canEdit)
	echo "var isReadOnly = false;";
else
	echo "var isReadOnly = true;";
?>
var readOnly = null;
if (isReadOnly)
	readOnly = "readOnly";


jQuery('#kurulusTopluEklemeTumunuEkleButton').click( function (e) {
		text=jQuery("#kurulusTopluEklemeTextArea").val();
	    text=text.replace("\r\n","\n");
	    var ek1Array=text.split("\n");

	    for(var i=0; i<ek1Array.length; i++)
	    {   
		    
		    var readOnlyValue = "";
			if (isReadOnly)
				readOnlyValue = ' readOnly="true" ';
			
		    
			var x = "inputkurulus-1[]";
			var rowCount = jQuery('#ek6Tablosu tbody tr').length;
			var nextRowNumber = rowCount+1;

			satirRow = '<tr>'
					+'<td class="siraNoTD">'+nextRowNumber+'</td>'
                    +'<td><input style="width:100%;" id="inputkurulus-2-'+nextRowNumber+'" type="text" name="inputkurulus-2[]" size="40" value="'+ ek1Array[i] +'"></td>' 
                    +'<td class="silButtonTD "><input onclick="jQuery(this.getParent().getParent()).remove(); tabloyuDuzenle();" type="button" value="SİL"></td></tr>';
			
    		if(jQuery(".dataTables_empty").length == 0)
				jQuery('#ek6Tablosu tbody').append(satirRow);
    		else
    		{
    			jQuery('#ek6Tablosu tbody tr').remove();
    			jQuery('#ek6Tablosu tbody').append(satirRow);
    		}
			
		    
		//    var satirText = '<tr class="tablo_row2 even" id="tablo_kurulus_6"><td class="  sorting_1"><input type="text" id="inputkurulus-1-6" name="inputkurulus-1[]" size="4" value="6" readonly=""></td><td class=" "><input type="text" id="inputkurulus-2-6" name="inputkurulus-2[]" size="40"></td><td width="10%" class="tablo_sil_hucre "><input type="button" id="satirSil_kurulus-6" value="SİL"></td></tr>';
	   	//	jQuery('#tablo_kurulus  tbody').append(satirText);
	    }
	    jQuery("#kurulusTopluEklemeTextArea").val("");
	    jQuery("#kurulusTopluEklemeDiv").toggle("slow");

	    tabloyuDuzenle();
		return false;
	} );


	jQuery('#GenelKuruldanEkleButton').click( function (e) {

		

		var readOnlyValue = "";
		if (isReadOnly)
			readOnlyValue = ' readOnly="true" ';
		jQuery(".genelKurul_idleri").filter(':checked').each(function(e){

			var kurulusName = jQuery(this).parent().parent().children()[1].getHTML();
			var x = "inputkurulus-2[]";
			var rowCount = jQuery('#ek6Tablosu tbody tr').length;
			var nextRowNumber = rowCount+1;

			var satirRow = '<tr class="table_row" >'
				+'<td class="siraNoTD">'+nextRowNumber+'</td>'
                +'<td><input style="width:100%;"  id="inputkurulus-2-'+nextRowNumber+'" type="text" name="inputkurulus-2[]" size="40" value="'+ kurulusName +'"></td>' 
                +'<td class="silButtonTD "><input onclick="jQuery(this.getParent().getParent()).remove(); tabloyuDuzenle();" type="button" value="SİL"></td></tr>';


            if(jQuery(".dataTables_empty").length == 0)
				jQuery('#ek6Tablosu tbody').append(satirRow);
			else
			{	jQuery('#ek6Tablosu tbody tr').remove();
				jQuery('#ek6Tablosu tbody').append(satirRow);
			}
			jQuery(this.getParent().getParent()).remove();
			jQuery('#GenelKurul_wrapper').toggle("slow")
		});

		tabloyuDuzenle();
		// Stop event handling in IE
		return false;
	} );


function tabloyuDuzenle()
{
	var rowElements = jQuery('#ek6Tablosu tbody tr');
	for(var i=0; i<rowElements.length; i++)
	{
		var classname = "even";
		if(i%2 == 1)
			classname = "odd";
			
		jQuery(rowElements[i]).attr("class", classname);
		jQuery(rowElements[i].getChildren()[0]).html(i+1);
	}
		
}

function listeGetir(tarih)
{
    var sendData = "tarih="+tarih;

    jQuery('#tariheGoreGKGetirButton').attr('value', 'Getiriliyor');
    jQuery('#tariheGoreGKGetirButton').attr('disabled', 'disabled');

    
    var url = 'index.php?option=com_meslek_std_taslak&task=ajaxGenelKurulGetir&format=raw';
//    var str="";
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
			     	var arrayToPut = data['array'];
            		var adet = arrayToPut.length;
            		for(var i=0;i<adet;i++)
                	{
                        var readOnlyValue = "";
                		if (isReadOnly)
                			readOnlyValue = ' readOnly="true" ';
                		
                			var x = "inputkurulus-2[]";
                			var rowCount = jQuery('#ek6Tablosu tbody tr').length;
                			var nextRowNumber = rowCount+1;

                			var satirRow = '<tr class="table_row" >'
                				+'<td class="siraNoTD">'+nextRowNumber+'</td>'
                                +'<td><input style="width:100%;"  id="inputkurulus-2-'+nextRowNumber+'" type="text" name="inputkurulus-2[]" size="40" value="'+ arrayToPut[i]["KURUM"] +'"></td>' 
                                +'<td class="silButtonTD "><input onclick="jQuery(this.getParent().getParent()).remove(); tabloyuDuzenle();" type="button" value="SİL"></td></tr>';


                            if(jQuery(".dataTables_empty").length == 0)
                				jQuery('#ek6Tablosu tbody').append(satirRow);
                			else
                			{	jQuery('#ek6Tablosu tbody tr').remove();
                				jQuery('#ek6Tablosu tbody').append(satirRow);
                			}
                			
                		
                        
             		}
            		tabloyuDuzenle();

            		jQuery('#tariheGoreGKGetirButton').attr('value', 'Tarihli Genel Kurul Listesini Getir');
            		jQuery('#tariheGoreGKGetirButton').removeAttr('disabled');
             		
                }else{
                    alert("Hata.")
                    jQuery('#tariheGoreGKGetirButton').attr('value', 'Tarihli Genel Kurul Listesini Getir');
                	jQuery('#tariheGoreGKGetirButton').removeAttr('disabled');
					
			  }
		  }
	});

}

window.yeniSatirId=new Array();
window.datatablosuAdi="ek6Tablosu";
window.datatablosuSatiradi="ek6TablosuSatir";
dtalanlar= new Array("adSoyad","unvan","kurum");
window.datatablosuAlanlar=dtalanlar;
window.count=dtalanlar.length;


function satirekle(id,veri,alan)
{
    window.sonSatir=jQuery("#"+window.datatablosuAdi+alan+" tr").length-1 ;   
    var yeniSatir=window.sonSatir+1;
    satir='<tr id="'+window.datatablosuSatiradi+alan+'y'+window.yeniSatirId[alan]+'" class="tablo_row" ><td style="text-align:center;">'+yeniSatir+'</td>';
    for(i=0;i<window.count;i++){
        size=25;
        if (window.count==i+1)
        	size=50;
    	
        satir=satir+"<td><input name="+window.datatablosuAlanlar[i]+"["+alan+"]"+"[] id="+window.datatablosuAlanlar[i]+alan+"y"+window.yeniSatirId[alan]+" value='";

        if (veri.length>0)
            satir=satir+veri[i];
        
        satir=satir+"' size='"+size+"'></td>";        
    }
    satir=satir+'<td style="text-align: center;"><input type="button" value="Sil" onclick="satirsil('+alan+',\'y'+window.yeniSatirId[alan]+'\');"></td></tr>';
    jQuery("#"+window.datatablosuAdi+alan).append(satir);
    window.yeniSatirId[alan]=window.yeniSatirId[alan]+1;
    window.sonSatir=yeniSatir;
}

</script>
