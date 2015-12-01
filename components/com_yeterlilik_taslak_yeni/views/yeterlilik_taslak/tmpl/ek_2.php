<?php 
$sektorSorumlusu = $this->sektorSorumlusu;
?>
<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak_yeni&layout=ek_2&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
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
	<h3 style="margin-left:35px;">AÇIKLAMA</h3>
	<div class="form_element cf_textarea" > 
		<textarea class="cf_inputbox" rows="3" style="margin-bottom: 10px;"
			id="terim_aciklama" title="" cols="105" name="terim_aciklama"><?php echo $this->taslakYeterlilik["TERIM_ACIKLAMA"] ? $this->taslakYeterlilik["TERIM_ACIKLAMA"] : "";?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">EK2 : Terimler, Simgeler ve Kısaltmalar</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>



<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="ulusalStandartYeterliliktenTerimEkle_outerDiv">
			<a id="ulusalStandartYeterliliktenTerimEkle_divToggler" href="#">Ulusal Standart/Yeterlilik'ten Terim Ekle</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
			<a id="terimAraAc" href="#">Terim Ara</a>
			<br>
			<div id="ulusalStandartYeterliliktenTerimEkle_toggleDiv" style="border: 1px solid #00A7DE; padding: 10px; width:600px;height:500px;display:none;background-color: white;">
				<?php 
					$document   = &JFactory::getDocument();
					$renderer   = $document->loadRenderer('module');
					$params   = array();
					echo $renderer->render(JModuleHelper::getModule('mod_ulusalstandartyeterlilikara'), $params);
				?>
			</div>
			<div id="terimAra" style="border: 1px solid #00A7DE; padding: 10px; width:600px;height:500px;display:none;background-color: white;">
            Terim: <input type="text" id="terimAdi"/> 
            <input type="button" id="idsubmit" onclick="terimSorgula(jQuery('#terimAdi').val())" value="Ara">
            (Büyük/küçük harfe duyarlıdır.)
            <br />
                <div id="listeTablosuAra" style="width: 580px; padding:10px; height:380px; overflow: auto;">
                </div>
                <div id="aktarButonAra" style="margin-top:10px; margin-left: auto; margin-right: auto;"></div>
			</div>
		</div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div>
		<table id="terimKisaltma" style="width:100%;">
			<thead>
				<tr>
					<th class="siraNo">Sıra No</th>
					<th>Terim/Kısaltma Adı</th>
					<th class="aciklama">Açıklama</th>
					<th class="sil">Satırı Sil</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$terim=$this->ek2Terimleri;
			$terimCount=count($terim);
            
			
			for($i=0; $i<$terimCount; $i++)
			{
				echo '<tr>';
				echo '<td>'.($i+1).'</td>';
				echo '<td>'.$terim[$i]['TERIM_ADI'].'</td>';
				echo '<td>'.$terim[$i]['TERIM_ACIKLAMA'].'<input type="hidden" name=terimId[] value="'.$terim[$i]['TERIM_ID'].'"/></td>';
				echo '<td><input type="button" name="sil" class="required" id="silButton" value="Sil"/></td>';
				echo '</tr>';
			}
			
			
			?>
			</tbody>
		</table>
		</div>
		<div class="cfclear">&nbsp;</div>
		<input type="text" name="adet" class="required" id="adet" value="1" style="width: 20px;"/>
		<input type="button" name="satirEkleButton" class="required" id="satirEkle" value="Adet yeni satır ekle"/>
	
	<div class="cfclear">&nbsp;</div>
	
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

if ($sektorSorumlusu && $this->yorumDiv!=""){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('ek_2', <?php echo $this->standart_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>
</form>

<script type="text/javascript">
<?php 
if ($this->canEdit)
	echo "var isReadOnly = false;";
else
	echo "var isReadOnly = true;";
?>
var readOnly = null;
if (isReadOnly)
	readOnly = "readOnly";



window.count= <?php echo count($terim);?> + <?php echo count($terimFromModule); ?>;
var oTable = jQuery('#terimKisaltma').dataTable({
	"iDisplayLength": 250,
    "aoColumns" : [null,
                    null,
                    null,
                    {sClass: "ortala"}],
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
});
jQuery('#silButton').live('click', function() {
	var row = jQuery(this).closest("tr").get(0);
	oTable.fnDeleteRow(oTable.fnGetPosition(row));
	window.count--;
	var i=0;
	if(window.count!=0){
		for(i=0;i<window.count;i++){
			oTable.fnUpdate('<input type="text" name="siraNoTextbox" readonly="readonly" class="required" id="siraNo" value='+(i+1)+' style="width: 95%;" />', i, 0, false, false);
		}
	}
});
jQuery("#satirEkle").live('click', function() {
	var adet = jQuery('#adet').val();
	for(var i=0;i<adet;i++){
		window.count++;
		oTable.fnAddData([''+(window.count)+'',
		                '<input type="text" name="terimAdi[]" class="required" id="terimAdi" value="" style="width: 98%;"  />',
		          		'<textarea name="terimAciklama[]" class="required" id="terimAciklama" cols="60" rows="4" ></textarea>',
		          		'<input type="button" name="sil" class="required" id="silButton" value="Sil"/>']);
	}
});

jQuery('#ulusalStandartYeterliliktenTerimEkle_divToggler').click(function(e) {
	jQuery('#ulusalStandartYeterliliktenTerimEkle_toggleDiv').lightbox_me({
	    centered: true, 
	});
	e.preventDefault();
});
jQuery('#terimAraAc').click(function(e) {
	jQuery('#terimAra').lightbox_me({
	    centered: true, 
	});
	e.preventDefault();
});


function veriaktar(veri){
//    alert("veri geldi:" +veri)
//	var jqInputs = jQuery('#taslakid');
//	var sendData = jqInputs.serializeArray();
//
    var sendData = "terimIds="+veri;
    var oTable = jQuery('#terimKisaltma').dataTable();
    
    var url = 'index.php?option=com_meslek_std_taslak&task=ajaxTaslakTerimGetir&format=raw';
    var str="";
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
				  	oTable.fnSort( [ [0,'desc'] ] );
			  		var arrayToPut = data['array'];
            		var adet = arrayToPut.length;
            		for(var i=0;i<adet;i++){
                        str=str+arrayToPut[i]["TERIM_ADI"];
            			window.count++;
            			oTable.fnAddData([''+window.count+'',
            			                ''+arrayToPut[i]["TERIM_ADI"]+'<input type="hidden" name="terimId[]" value="'+arrayToPut[i]["TERIM_ID"]+'">',
            			          		''+arrayToPut[i]["TERIM_ACIKLAMA"]+'',
            			          		'<input type="button" name="sil" class="required" id="silButton" value="Sil"/>'],1);
            		}
            		jQuery('#ulusalStandartYeterliliktenTerimEkle_toggleDiv').trigger('close');
				}else{
                    alert("Terim bulunamadı.")
					oTableMS.fnClearTable();
					
			  }
		  }
	});


}

jQuery("#terimAdi").keyup(function(event){
    var sveri=jQuery('#terimAdi').val();
    if(event.keyCode == '13'){
        terimSorgula(sveri);
    } 
//    else {
//        jQuery("#listeTablosuAra").html("");
//        jQuery("#aktarButonAra").html("");
//        
//    }
});

function hepsiniSec( flag )
{
    if (flag == 0)
    {
        jQuery("input[name=terimId]").attr('checked',  false);
    }
    else
    {
        jQuery("input[name=terimId]").attr('checked',  false);
        jQuery("input[name=terimId]").attr('checked', true);
    }
}

function terimSorgula(sveri){
    jQuery("#listeTablosuAra").html("<center><br><br><br><br><br><br><br><br>Lütfen Bekleyiniz.<center>");
    jQuery("#aktarButonAra").html("");
    var url = 'index.php?option=com_ajax&task=getTerimAra&format=raw';        
    var listeTablosu="";
	jQuery.post(
        url,{veri:sveri}, function(data) {
            if(data['success']){
                var gelenIcerik = data['array'];
                var adet = gelenIcerik.length;
                
                listeTablosu=''
                +'<form id="terimForm"><table>'
                +'<tr><td style="font-weight:bold; text-align:center;">Seç</td><td style="font-weight:bold; text-align:center;">Terim</td><td style="font-weight:bold; text-align:center;">Açıklama</td></tr>';
                for(var i=0;i<adet;i++){
                    listeTablosu=listeTablosu + '<tr><td><input type="checkbox" name="terimId1" value="'+gelenIcerik[i]["TERIM_ID"]+'"></td><td>'+gelenIcerik[i]["TERIM_ADI"]+'</td><td>'+gelenIcerik[i]["TERIM_ACIKLAMA"]+'</td></tr>';
                }
                listeTablosu=listeTablosu+'</table></form>';
                jQuery("#listeTablosuAra").html(listeTablosu);
                jQuery("#aktarButonAra").html('<center><input type="button" onclick="hepsiniSec(\'1\');" value="Hepsini Seç" style="margin:2px;"/><input type="button" onclick="hepsiniSec(\'0\')" value="Hiçbirini Seçme" style="margin:2px;"/><br><input type="button" onclick="kontrol1();" value="Seçilen Terimleri Aktar" style="margin:2px;"/></center>');
                
                
                
            }else{
                jQuery("#listeTablosuAra").html("<center><br><br><br><br><br><br><br><br>İçeriğinde <b>"+sveri+"</b> geçen bir terim bulunamadı.<center>");
            
            }
    	},"json"
    );
}
function kontrol1(){
    veriaktar((jQuery("input[name=terimId1]:checked").map(function () {return this.value;}).get().join(",")));

    jQuery('#terimAra').trigger("close");
}



</script>