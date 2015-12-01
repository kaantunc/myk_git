<?php
$sektorSorumlusu = $this->sektorSorumlusu;
?>

<form



<?php
$task = "task=taslakKaydet";
echo 'action="index.php?option=com_meslek_std_taslak&amp;layout=terim&amp;'.$task.'&amp;standart_id='.$this->standart_id.'"'
?>
	enctype="multipart/form-data" method="post"
	onSubmit="return validate('ChronoContact_meslek_std_taslak')"
	id="ChronoContact_meslek_std_taslak"
	name="ChronoContact_meslek_std_taslak">

	<input type="hidden" name="evrak_id"
		value="<?php echo $this->evrak_id;?>" />
	
	
	
	
	


<?php 
echo $this->pageTree;
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">1. TERİMLER, SİMGELER VE KISALTMALAR</h1>
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
		<table id="terimKisaltma">
			<thead>
				<tr>
					<th class="siraNo">Sıra No</th>
					<th>Terim/Kısaltma Adı</br><FONT SIZE=1>(Terim Sonuna : koymanıza gerek yoktur)</font></th>
					<th class="aciklama">Açıklama</th>
					<th class="sil">Düzenle/Sil</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$terimlers=$this->terim;
			
			$terim=$terimlers[0];
			$terimCount=count($terim);
			$duzen = $terimlers[1];
            
			
			for($i=0; $i<$terimCount; $i++)
			{
				echo '<tr id="terim_'.$terim[$i]['TERIM_ID'].'">';
				echo '<td>'.($i+1).'</td>';
				echo '<td>'.$terim[$i]['TERIM_ADI'].'</td>';
				echo '<td>'.$terim[$i]['TERIM_ACIKLAMA'].'<input type="hidden" name=terimId[] value="'.$terim[$i]['TERIM_ID'].'"/></td>';
				if($duzen[$terim[$i]['TERIM_ID']]){
					echo '<td><input type="button" onclick="TerimDuzenle('.$terim[$i]['TERIM_ID'].')" value="Düzenle" /> <input type="button" name="sil" class="required" id="silButton" value="Sil"/></td>';	
				}else{
					echo '<td><input type="button" name="sil" class="required" id="silButton" value="Sil"/></td>';
				}
				
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

<br />
<br />

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div >ifade eder.</div>
	</div>
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('terim', <?php echo $this->standart_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}

echo $this->yorumDiv_Kurulus;

if (!$this->sektorSorumlusu && $this->yorumDiv_Kurulus!=""){
	?>
    <div style="width:100%;float: none;text-align:center;">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet_Kurulus('bilgi_beceri', <?php echo $this->standart_id;?>)"/>
	</div>
<?php 
}


?>
</form>
<script type="text/javascript">
jQuery(document).ready(function() {
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
//    jQuery('#ulusalStandartYeterliliktenTerimEkle_divToggler').live('click', function (e){
//		jQuery('#ulusalStandartYeterliliktenTerimEkle_toggleDiv').show();
//		// Stop event handling in IE
//		return false;
//	} );

});

function TerimDuzenle(terimId){
	jQuery.ajax({
		async:false,
		type:"POST",
		url:"index.php?option=com_meslek_std_taslak&task=getTerims&format=raw",
		data:"terimId="+terimId,
		success:function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				var terAd = '<input class="required" type="text" style="width: 98%;" name="terimAdiUp[]" value="'+dat[0]['TERIM_ADI']+'"/> <input type="hidden" value="'+dat[0]['TERIM_ID']+'" name="terimId[]">';
				var terAc = '<textarea id="terimAciklama" class="required" rows="4" cols="60" name="terimAciklamaUp[]">'+dat[0]['TERIM_ACIKLAMA']+'</textarea><input type="hidden" name="terimIdUp[]" value="'+dat[0]['TERIM_ID']+'"/>';

				jQuery('#terim_'+terimId).children('td').eq(1).html(terAd);
				jQuery('#terim_'+terimId).children('td').eq(2).html(terAc);
			}
			else{
				alert('Bu terimi düzenleme yetkiniz yoktur.');
			}
		}
	});

// 	jQuery('#terim_'+terimId).children('td').eq(1).html();
// 	jQuery('#terim_'+terimId).children('td').eq(2).html();
}

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
            		jQuery('#terimAra').trigger('close');
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

}

</script>
