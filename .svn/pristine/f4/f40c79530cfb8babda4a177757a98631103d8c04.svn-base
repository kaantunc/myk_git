<?php 
$sektorler=getSektorler();

?>
<style>
table
{
	width:100%;
}
table *
{
	text-align: center;
}
</style>
<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading"><?php echo $baslik;?></h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<form
	enctype="multipart/form-data"
	id="soru_arama_formu"
	name="soru_arama_formu"
	method="post">

	<div class="form_item">
	  <div class="form_element cf_textbox">
		<label class="cf_label" style="width: 200px;">T.C. Kimlik No</label>
	    <input class="cf_inputbox required" style="width: 300px;" id="tck_no" name="tck_no">
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
		<label class="cf_label" style="width: 200px;">Ad</label>
	    <input class="cf_inputbox required" style="width: 300px;" id="ad" name="ad">
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
		<label class="cf_label" style="width: 200px;">Soyad</label>
	    <input class="cf_inputbox required" style="width: 300px;" id="soyad" name="soyad">
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
		<label class="cf_label" style="width: 200px;">Başvuru Tipi</label>
	    <select class="cf_inputbox required" style="width: 300px;" id="basvuru_tipi" name="basvuru_tipi">
			<option value="0">Hepsi</option>
			<option value="1">Denetçi / Baş Denetçi</option>
			<option value="2">Teknik Uzman</option>
			<option value="3">Modaratör</option>
		</select>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
		<label class="cf_label" style="width: 200px;">Onay Durumu:</label>
	    <select class="cf_inputbox required" style="width: 300px;" id="onay_durumu" name="onay_durumu">
	    	<option value="3">Onaylı</option>
			<option value="2">Yönetici Onayı Bekleniyor</option>
			<option value="1">DS Onayı Bekleniyor</option>
			<option value="">Hepsi</option>
			<option value="0">Başvusu Tamamlanmamış</option>
		</select>
	    
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
	  <div class="form_element cf_textbox">
	    <label class="cf_label" style="width: 200px;"></label>
	    <input class="cf_inputbox" style="width: 100px;" title="" id="submit_button" name="submit_button" type="button" value="Ara" onclick="ara();" />
	    <!--input class="cf_inputbox" style="width: 100px;" title="" id="submit_button" name="submit_button" type="button" value="Ara" onclick="ara(jQuery('#sektor').val(),jQuery('#seviye').val(),jQuery('#yeterlilik_id').val(),jQuery('#birim_id').val(),jQuery('#ogrenme_ciktisi_id').val(),jQuery('#basarim_olcutu_id').val(),jQuery('#soru_metni').val());" /-->
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	
	</form>
	<div id="listeDiv" style="margin-top:20px;"></div>
<script>
function ara(){
	jQuery("#listeDiv").html("<center><font color=red><b>Lütfen Bekleyiniz</b></font></center>");
	var url = 'index.php?option=com_uzman_basvur&view=uzman_basvurulari&task=uzmanlardan_ara&format=raw';
    postdata=jQuery("#soru_arama_formu").serialize();
    var seviyeIcerik="";
	jQuery.post(
        url,postdata, function(data) {
            if(data['success']){
                var gelenIcerik = data['array']['UZMANLAR'];

                icerik='<form id="listeForm"><table cellspacing="1" bgcolor="#999999">';
                
                for(var i=0;i<gelenIcerik.length;i++){
                	icerik += '<table><tbody>';
    				icerik	+='<tr bgcolor="#dddddd">';

    				icerik +='<thead><tr bgcolor="#dddddd">'+
    				'<th style="padding:2px; width:5%;">#</th>'+
                    '<th style="padding:2px; width:10%;">T.C. Kimlik No</th>'+
                    '<th style="padding:2px; width:20%;">Ad Soyad</th>'+
                    '<th style="padding:2px;width:20%;">E-Posta Adresi</th>'+
                    '<th style="padding:2px;width:20%;">Başvuru Tipi</th>'+
                    '<th style="padding:2px;width:10%;">İşlemler</th>'+
                    '</tr></thead>';

                    icerik+= '<tbody><tr>';
                    icerik+= '<td style="padding:2px;">'+(i+1)+'</td>';	
                	icerik+= '<td style="padding:2px;"><a href="index.php?option=com_uzman_basvur&tc_kimlik='+gelenIcerik[i]["TC_KIMLIK"]+'">'+gelenIcerik[i]["TC_KIMLIK"]+'</a></td>';
                	icerik+= '<td style="padding:2px;" align="center"><a href="index.php?option=com_uzman_basvur&tc_kimlik='+gelenIcerik[i]["TC_KIMLIK"]+'">'+gelenIcerik[i]["AD"]+' '+gelenIcerik[i]["SOYAD"]+'</a></td>';
                	icerik+= '<td style="padding:2px;" align="center">'+gelenIcerik[i]["EPOSTA"]+'</td>';
                	if(jQuery('#basvuru_tipi').val() != 0){
                		if(jQuery('#basvuru_tipi').val() == 1){
                			icerik+= '<td style="padding:2px;" align="center"><a href="index.php?option=com_uzman_basvur&view=uzman_profile&layout=denetci&tc_kimlik='+gelenIcerik[i]["TC_KIMLIK"]+'">Denetçi</a></td>';
                        }else if(jQuery('#basvuru_tipi').val() == 2){
                			icerik+= '<td style="padding:2px;" align="center"><a href="index.php?option=com_uzman_basvur&view=uzman_profile&layout=teknik_uzman&tc_kimlik='+gelenIcerik[i]["TC_KIMLIK"]+'">Teknik Uzman</a></td>';
                        }else if(jQuery('#basvuru_tipi').val() == 3){
                			icerik+= '<td style="padding:2px;" align="center">Modaratör</td>';
                        }
                    }else{
                        if(jQuery('#onay_durumu').val()){
                        	icerik+= '<td style="padding:2px;" align="center">';
                           	if(gelenIcerik[i]['DENETCI'] == jQuery('#onay_durumu').val()){
                           		icerik+= '<a href="index.php?option=com_uzman_basvur&view=uzman_profile&layout=denetci&tc_kimlik='+gelenIcerik[i]["TC_KIMLIK"]+'">Denetçi</a><br>';
                            }

                           	if(gelenIcerik[i]['UZMAN'] == jQuery('#onay_durumu').val()){
                           		icerik+= '<a href="index.php?option=com_uzman_basvur&view=uzman_profile&layout=teknik_uzman&tc_kimlik='+gelenIcerik[i]["TC_KIMLIK"]+'">Teknik Uzman</a><br>';
                            }

//                            	if(gelenIcerik[i]['MODARATOR'] == jQuery('#onay_durumu').val()){
//                            		icerik+= '<a href="index.php?option=com_uzman_basvur&view=uzman_profile&layout=modarator&tc_kimlik='+gelenIcerik[i]["TC_KIMLIK"]+'">Modarator</a><br>';
//                             }
                            
                            icerik+= '</td>';
                        }else{
                        	icerik+= '<td style="padding:2px;" align="center">';
                           	icerik+= '<a href="index.php?option=com_uzman_basvur&view=uzman_profile&layout=denetci&tc_kimlik='+gelenIcerik[i]["TC_KIMLIK"]+'">Denetçi</a><br>';
                           	icerik+= '<a href="index.php?option=com_uzman_basvur&view=uzman_profile&layout=teknik_uzman&tc_kimlik='+gelenIcerik[i]["TC_KIMLIK"]+'">Teknik Uzman</a><br>';

//                            	if(gelenIcerik[i]['MODARATOR'] == jQuery('#onay_durumu').val()){
//                            		icerik+= '<a href="index.php?option=com_uzman_basvur&view=uzman_profile&layout=modarator&tc_kimlik='+gelenIcerik[i]["TC_KIMLIK"]+'">Modarator</a><br>';
//                             }
                            
                            icerik+= '</td>';
                        }
                    }
                	
                	icerik+= '<td style="padding:2px;" align="center"><a href="index.php?option=com_uzman_basvur&tc_kimlik='+gelenIcerik[i]["TC_KIMLIK"]+'">DETAY</a></td>';
                	icerik+= '</tr>';
					icerik+= '<tbody></table>';


                }
					
                
                icerik=icerik+'</form>';
				
                if(gelenIcerik.length!=0)                             
                	jQuery("#listeDiv").html(icerik);
                else
                    jQuery("#listeDiv").html("Arama sonucu bir kayıda rastlanmadı");
            }else{
            	alert("Bir hatayla karşılaşıldı");
            }
    	},"json"
    );
}
		
jQuery( ".tarih" ).datepicker({ });
</script>

<?php 
function getSektorler(){
		$db = JFactory::getOracleDBO();
		
		$sql = "SELECT sektor_id,sektor_adi
				FROM pm_sektorler
                WHERE sektor_durum=1
                ORDER BY sektor_adi";
		
		return $db->prep_exec($sql, array());
    }
?>