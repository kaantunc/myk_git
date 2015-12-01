<?php
$kuruluslar = $this->Belgekuruluslar;

$kuruluss = '<option value="">Seçiniz</option>';
foreach ($kuruluslar as $kurulus){
	$kuruluss .= '<option value="'.$kurulus['USER_ID'].'">'.$kurulus['KURULUS_ADI'].'</option>'; 
}

?>
<style>
.llable
{
	width: 200px;
	float: left;
	text-align: left;
	margin-right: 10px;
	display: block
}


</style>
<h2>Belge Sorgulama</h2>
<hr><br>
<div>
	<label><input type="radio" id="belgeKur" name="belgeSorgu" /> Kuruluşta Ara</label><br>
	<label><input type="radio" id="belgeKurTckn" name="belgeSorgu" /> T.C. Kimlik No ile Ara</label><br>
	<label><input type="radio" id="belgeNo" name="belgeSorgu" /> Belge Numarası ile Ara</label>
</div>
<div id="BelgeSorgulaKurulus" style="display:none">
<hr>
        <label>Kurulus:<select id="kurulus" name="kurulus"><?php echo $kuruluss;?></select><input type="button" id="getir" value="Getir" /></label><br><br>
      
        <label  id="displaySinav" style="display: none;">Sınav: <select style="margin-left: 9px;" id="sinavId" name="sinav"></select></label><br><br>
        <label id="displayAday" style="display: none"><button id="adayGetir">Bilgileri Getir</button></label>
</div>
<div id="BelgeSorgulaAday" style="display:none">
<hr>
        <label>T.C. Kimlik No:<input type="text" id="tckn" /><input type="button" id="Tckngetir" value="Getir" /></label><br><br>
      
<!--        <label  id="displaySinavTckn" style="display: none;">Sınav: <select style="margin-left: 9px;" id="sinavIdTckn" name="sinav"></select></label><br><br>
        <label id="displayAdayTckn" style="display: none"><a href="#" id="adayGetir">Bilgileri Getir</a></label>-->
</div>
<div id="BelgeSorgulaBelgeNo" style="display:none">
<hr>
        <label>Belgel Numarası:<input type="text" id="Nobelge" style="width:200px"/><input type="button" id="NobelgeGetir" value="Getir" /></label><br><br>
      
<!--        <label  id="displaySinavTckn" style="display: none;">Sınav: <select style="margin-left: 9px;" id="sinavIdTckn" name="sinav"></select></label><br><br>
        <label id="displayAdayTckn" style="display: none"><a href="#" id="adayGetir">Bilgileri Getir</a></label>-->
</div>

    <input type="hidden" name="belgeSinav" id="belgeSinav"/>
    
<div id="adaylar" style="display: none; margin-top: 10px;">
    <hr>
    <a href="#" id="excelAdayBelge" style="color:#1C617C" target="_blank">Matbaaya Gönderilecek Excel Dosyasını İndir</a><br><br>
    <table width="100%" border="0" cellpadding="0" cellspacing="1" style="text-align: center" id="queriedDocuments">
        <thead style="background-color:#71CEED">
            <tr>
                <th>#</th>
                <th>T.C. Kimlik No:</th>
                <th>Ad</th>
                <th>Soyad</th>
                <th>Belge No:</th>
                <th>Başarılı Birimler</th>
            </tr>
        </thead>
        <tbody id="AdayYaz"></tbody>
    </table>
</div>
    
<div id="adaylarTckn" style="display: none; margin-top: 10px;">
    <hr>
<!--    <a href="#" id="excelAdayBelge" style="color:#1C617C" target="_blank">Matbaaya Gönderilecek Excel Dosyasını İndir</a><br><br>-->
    <table width="100%" border="0" cellpadding="0" cellspacing="1" style="text-align: center">
        <thead style="background-color:#71CEED">
            <tr>
                <th width="2%">#</th>
                <th width="10%">T.C. Kimlik No:</th>
                <th width="6%">Ad</th>
                <th width="10%">Soyad</th>
                <th width="30%">Yeterlilik</th>
                <th width="15%">Belge No</th>
                <th width="5%">Sınav ID</th>
<!--                 <th width="15%">Açıklama</th> -->
                <th width="7%">Başarılı Birimler</th>
                <th width="5%">Excel Çıktısı</th>
                <th width="7%">Geçerlilik Durumu</th>
                <th width="7%">Belge Durumu</th>
            </tr>
        </thead>
        <tbody id="AdayYazTckn"></tbody>
    </table>
</div>
    
<div id="yeniDis" style=" width: 400px; min-height:250px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
</div>

<div id="belgeDurumDuzenleme" style="width: 400px; min-height:250px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">

</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	
	jQuery('input[name=belgeSorgu]').live('change',function(e){
		e.preventDefault();
		if(jQuery(this).attr('id') == 'belgeKur'){
                    jQuery('#BelgeSorgulaAday').hide();
                    jQuery('#BelgeSorgulaBelgeNo').hide();
                    jQuery('#displaySinav').hide();
                    jQuery('#displayAday').hide();
                    jQuery('#adaylar').hide();
                    jQuery('#adaylarTckn').hide();
                    jQuery('#BelgeSorgulaKurulus').show();
		}
		else if(jQuery(this).attr('id') == 'belgeKurTckn'){
                    jQuery('#BelgeSorgulaKurulus').hide();
                    jQuery('#BelgeSorgulaBelgeNo').hide();
                    jQuery('#displaySinav').hide();
                    jQuery('#displayAday').hide();
                    jQuery('#adaylar').hide();
                    jQuery('#adaylarTckn').hide();
                    jQuery('#BelgeSorgulaAday').show();
		}
		else if(jQuery(this).attr('id') == 'belgeNo'){
			 jQuery('#BelgeSorgulaAday').hide();
			 jQuery('#BelgeSorgulaKurulus').hide();
             jQuery('#displaySinav').hide();
             jQuery('#displayAday').hide();
             jQuery('#adaylar').hide();
             jQuery('#adaylarTckn').hide();
             jQuery('#BelgeSorgulaBelgeNo').show();
		}
	});

	jQuery('#kurulus').live('change',function(e){
		e.preventDefault();
		jQuery('#displaySinav').hide();
        jQuery('#displayAday').hide();
        jQuery('#adaylar').hide();
	});

	jQuery('#displaySinav').live('change',function(e){
		e.preventDefault();
        jQuery('#adaylar').hide();
	});

	jQuery('#Tckngetir').live('click',function(e){
		e.preventDefault();
		jQuery('#displaySinav').hide();
        jQuery('#displayAday').hide();
        jQuery('#adaylar').hide();
        var tckn = jQuery('#tckn').val();
        if(tckn == ''){
            alert('Lütfen T.C. Kimlik Numarasını veya Pasaport Numarasını kontrol ederek tekrar deneyiniz.');
        }
        else{
        	jQuery.ajax({
                type: 'POST',
                url:"index.php?option=com_belgelendirme&view=belgelendirme_islemleri&task=KurulusSinavlarTckn&format=raw",
                data:'tckn='+tckn+'&durum_id=2',
                success: function (data) {
                        var dat = jQuery.parseJSON(data);
                        if(dat.length>0){
                            var adaylar = '';
                            var even = 'bgcolor="#efefef"';
                            var say = 1;
                            jQuery.each(dat,function(key,value){
                                if(say%2 == 0){
                                    adaylar += '<tr id="'+value['ID']+'" '+even+'>';
                                }
                                else{
                                    adaylar += '<tr id="'+value['ID']+'">';
                                }
                                adaylar += '<td>'+say+'</td>'
                                    +'<td>'+value['TC_KIMLIK']+'</td>'
                                    +'<td>'+value['ADI']+'</td>'
                                    +'<td>'+value['SOYADI']+'</td>';
                                adaylar += '<td>';
                                if(value['YETERLILIK_KODU'] != undefined){
                                	adaylar += value['YETERLILIK_KODU']+' - ';
                                }
                                adaylar +=value['YETERLILIK_ADI']+' ';
                                if(value['SINAV_TARIHI'] != undefined){
                                    adaylar += '('+value['SINAV_TARIHI']+')';
                                    }
                                adaylar += '</td>';
                                adaylar += '<td>'+value['BELGE_NO']+'</td>';
//                                 if(value['ACIKLAMA'] != undefined){
//                                     adaylar += +'<td>'+value['ACIKLAMA']+'</td>';
//                                 }else{
//                                     adaylar += '<td></td>';
//                                 }
                                if(typeof value['SINAV_ID'] != 'undefined'){
                                	adaylar += '<td>'+value['SINAV_ID']+'</td>';
                                	adaylar += '<td align="center"><input type="button" id="birimler" value="Birimleri"/></td>';
                                	adaylar += '<td align="center"><a href="index.php?option=com_belgelendirme&view=belge_olusturma&layout=belgeExcel&hakId='+value['ID']+'" target="_blank" class="btn btn-xs btn-info">Excel İndir</a></td>';
                                }else{
                                	adaylar += '<td align="center"></td>';
                                	adaylar += '<td align="center"></td>';
                                	adaylar += '<td align="center"><a href="index.php?option=com_belgelendirme&view=belge_olusturma&layout=belgeExcel&SorguID='+value['ID']+'" target="_blank" class="btn btn-xs btn-info">Excel İndir</a></td>';
                                }

                                if(value['BELGEDURUMU'] == 1){
                                	adaylar += '<td align="center"><a href="#" onclick="belgeDurumuDuz('+"'"+value['BELGE_NO']+"'"+')" style="color:green;">Geçerli</br>('+value['GECERLILIK_TARIHI']+')</a></td>';
                                }else if(value['BELGEDURUMU'] == 2){
                                	adaylar += '<td align="center"><a href="#" onclick="belgeDurumuDuz('+"'"+value['BELGE_NO']+"'"+')" style="color:red;">İptal Edildi</a></td>';
                                }else if(value['BELGEDURUMU'] == 3){
                                	adaylar += '<td align="center"><a href="#" onclick="belgeDurumuDuz('+"'"+value['BELGE_NO']+"'"+')" style="color:red;">Askıya Alındı</a></td>';
                                }

                                adaylar += '<td align="center"><button type="button" class="btn btn-xs btn-warning" onclick="belgeDuzenleme('+"'"+value['BELGE_NO']+"'"+')">Düzenle</button></td></tr>';
                                
                                say++;
                            });
                            jQuery('#AdayYazTckn').html(adaylar);
                            jQuery('#adaylarTckn').show();
                        }
                        else{
                            alert('Aday hiç bir belge hak etmemiştir.');
                        }
                    }
            });
		}
	});
	
    jQuery('#getir').live('click',function(e){
        e.preventDefault();
        jQuery('#displaySinav').hide();
        jQuery('#displayAday').hide();
        jQuery('#adaylar').hide();
        jQuery('#sablon').hide();
        var kurulusId = jQuery('#kurulus').val();
        if(kurulusId == ''){
            alert('Lütfen bir kuruluş seçiniz.');
        }
        else{
            jQuery.ajax({
                type: 'POST',
                url:"index.php?option=com_belgelendirme&view=belgelendirme_islemleri&task=KurulusSinavlar&format=raw",
                data:'kurulus_id='+kurulusId+'&durum_id=2',
                success: function (data) {
                        var dat = jQuery.parseJSON(data);
                        if(dat.length>0){
                            var sinav = '<option value="">Seçiniz</option>';
                            jQuery.each(dat,function(key,value){
                                sinav += '<option value="'+value['SINAV_ID']+'">'+value['BASLANGIC_TARIHI']+' - '+value['YETERLILIK_KODU']+'-'+value['YETERLILIK_ADI']+' ('+value['SINAV_ILI']+')</option>';
                            });
                            jQuery('#sinavId').html(sinav);
                            jQuery('#displaySinav').show();
                            jQuery('#displayAday').show();
                        }
                    }
            });
        }
    });

    var table_config = {
            "bDestroy": true,
            "paging": false,
            "language": {
                "zeroRecords": "No results found",
                "processing": "<div align='center'><img src='/static/ajax-loader.gif'></div>",
                "loadingRecords": "<div align='center'><img src='/static/ajax-loader.gif'></div>"
            }
        }; 
    jQuery('#adayGetir').live('click',function(e){
        e.preventDefault();
        jQuery('#adaylar').hide();
        var sinav = jQuery('#sinavId').val();
        var kurulus = jQuery("#kurulus").val();
		var postAjax = '';
        if(sinav != ''){
        	postAjax = 'sinavId='+sinav+'&kurulusId='+kurulus+'&durum_id=2';
        }else{
        	postAjax = 'kurulusId='+kurulus+'&durum_id=2';
        }
//         if(sinav == ''){
//             alert('Lütfen bir sınav seçiniz.');
//         }
//         else{
            jQuery('#belgeSinav').val(sinav);
            jQuery('#excelAdayBelge').attr('href','index.php?option=com_belgelendirme&view=belge_olusturma&layout=belgeExcel&sinavId='+sinav);
             jQuery.ajax({
                type: 'POST',
                url:"index.php?option=com_belgelendirme&view=belgelendirme_islemleri&task=BelgeAdayGetir&format=raw",
                data:postAjax,
                success: function (data) {
                        var dat = jQuery.parseJSON(data);
                        if(dat.length>0){
                            var adaylar = '';
                            var even = 'bgcolor="#efefef"';
                            var say = 1;
                            jQuery.each(dat,function(key,value){
                                if(say%2 == 0){
                                    adaylar += '<tr id="'+value['ID']+'" '+even+'>';
                                }
                                else{
                                    adaylar += '<tr id="'+value['ID']+'">';
                                }
                                adaylar += '<td>'+say+'</td>'
                                    +'<td>'+value['TC_KIMLIK']+'</td>'
                                    +'<td>'+value['ADI']+'</td>'
                                    +'<td>'+value['SOYADI']+'</td>'
                                    +'<td>'+value['BELGE_NO']+'</td>'
                                    +'<td><input type="button" id="birimler" value="Birimleri"/></td></tr>';
                                say++;
                            });
                            jQuery('#queriedDocuments').dataTable().fnDestroy();
                            jQuery('#AdayYaz').html(adaylar);
                            reDrawDatatable();
                            jQuery('#adaylar').show('slow');
                        }
                        else{
                            jQuery('#AdayYaz').html('');
                            alert('Aradığınız kriterlere ait bilgi bulunmamaktadır.');
                        }
                        
                    }
            });
        //}
    });
    function reDrawDatatable(){
        jQuery('#queriedDocuments').dataTable({
    		// 		"aaSorting": [[ 2, "desc" ]],
    				"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    				"bInfo": true,
    				"bPaginate": true,
    				"bFilter": true,
    				"sPaginationType": "full_numbers",
    				"oLanguage": {
    					"sLengthMenu": "# _MENU_ öğe göster",
    					"sZeroRecords": "Sonuç Yok",
    					"sInfo": "_START_ - _END_ (Toplam _TOTAL_ öğe)",
    					"sSearch": "Ara",
    					"oPaginate": {
    						"sFirst":    "<?php echo JText::_("FIRST");?>",
    						"sPrevious": "Önceki",
    						"sNext":     "Sonraki",
    						"sLast":     "<?php echo JText::_("LAST");?>"
    						}
    					}
    				});
    }
    jQuery('#NobelgeGetir').live('click',function(){
    	jQuery('#displaySinav').hide();
        jQuery('#displayAday').hide();
        jQuery('#adaylar').hide();

    	var belgeNo = jQuery('#Nobelge').val();
    	 if(belgeNo == ''){
             alert('Lütfen Belge Numarası giriniz.');
         }
         else{
         	jQuery.ajax({
                 type: 'POST',
                 url:"index.php?option=com_belgelendirme&view=belgelendirme_islemleri&task=KurulusSinavlarBelgeNo&format=raw",
                 data:'belgeNo='+belgeNo,
                 success: function (data) {
                         var dat = jQuery.parseJSON(data);
                         if(dat.length>0){
                             var adaylar = '';
                             var even = 'bgcolor="#efefef"';
                             var say = 1;
                             jQuery.each(dat,function(key,value){
                                 if(say%2 == 0){
                                     adaylar += '<tr id="'+value['ID']+'" '+even+'>';
                                 }
                                 else{
                                     adaylar += '<tr id="'+value['ID']+'">';
                                 }
                                 adaylar += '<td>'+say+'</td>'
                                     +'<td>'+value['TC_KIMLIK']+'</td>'
                                     +'<td>'+value['ADI']+'</td>'
                                     +'<td>'+value['SOYADI']+'</td>';
                                 adaylar += '<td>';
                                 if(value['YETERLILIK_KODU'] != undefined){
                                 	adaylar += value['YETERLILIK_KODU']+' - ';
                                 }
                                 adaylar +=value['YETERLILIK_ADI']+' ';
                                 if(value['SINAV_TARIHI'] != undefined){
                                     adaylar += '('+value['SINAV_TARIHI']+')';
                                     }
                                 adaylar += '</td>';
                                 adaylar += '<td>'+value['BELGE_NO']+'</td>';
//                                  if(value['ACIKLAMA'] != undefined){
//                                      adaylar += +'<td>'+value['ACIKLAMA']+'</td>';
//                                  }else{
//                                      adaylar += '<td></td>';
//                                  }
                                 if(typeof value['SINAV_ID'] != 'undefined'){
                                	 adaylar += '<td>'+value['SINAV_ID']+'</td>';
                                 	adaylar += '<td align="center"><input type="button" id="birimler" value="Birimleri"/></td>';
                                 	adaylar += '<td align="center"><a href="index.php?option=com_belgelendirme&view=belge_olusturma&layout=belgeExcel&hakId='+value['ID']+'" target="_blank" class="btn btn-xs btn-info">Excel İndir</a></td>';
                                 }else{
                                	adaylar += '<td align="center"></td>';
                                 	adaylar += '<td align="center"></td>';
                                 	adaylar += '<td align="center"><a href="index.php?option=com_belgelendirme&view=belge_olusturma&layout=belgeExcel&SorguID='+value['ID']+'" target="_blank" class="btn btn-xs btn-info">Excel İndir</a></td>';
                                 }

                                 if(value['BELGEDURUMU'] == 1){
                                 	adaylar += '<td align="center"><a href="#" onclick="belgeDurumuDuz('+"'"+value['BELGE_NO']+"'"+')" style="color:green;">Geçerli</br>('+value['GECERLILIK_TARIHI']+')</a></td>';
                                 }else if(value['BELGEDURUMU'] == 2){
                                 	adaylar += '<td align="center"><a href="#" onclick="belgeDurumuDuz('+"'"+value['BELGE_NO']+"'"+')" style="color:red;">İptal Edildi</a></td>';
                                 }else if(value['BELGEDURUMU'] == 3){
                                 	adaylar += '<td align="center"><a href="#" onclick="belgeDurumuDuz('+"'"+value['BELGE_NO']+"'"+')" style="color:red;">Askıya Alındı</a></td>';
                                 }

                                 adaylar += '<td align="center"><button type="button" class="btn btn-xs btn-warning" onclick="belgeDuzenleme('+"'"+value['BELGE_NO']+"'"+')">Düzenle</button></td></tr>';
                                 
                                 say++;
                             });
                             jQuery('#AdayYazTckn').html(adaylar);
                             jQuery('#adaylarTckn').show();
                         }
                         else{
                             alert('Girilmiş olan belge numarasına ait hiç bir belge bulunmamaktadır.');
                         }
                     }
             });
 		}
    });
    
    jQuery('#birimler').live('click',function(e){
        e.preventDefault();
        var hakId = jQuery(this).closest('tr').attr('id');
        jQuery.ajax({
            type: 'POST',
            url:"index.php?option=com_belgelendirme&view=belgelendirme_islemleri&task=BelgeAdayBirimler&format=raw",
            data:'hakId='+hakId,
            success: function (data) {
                        var dat = jQuery.parseJSON(data);
                        var birims = '<h3 style="color:#1C617C">Başarılı olduğu birimler</h3><hr style="color:#1C617C"><ul>';
                        jQuery.each(dat,function(key,value){
                            birims += '<li>'+value['BIRIM_KODU']+' - '+value['BIRIM_ADI']+'</li>';
                        });
                        birims += '</ul>';
                        jQuery('#yeniDis').html(birims);
                        jQuery('#yeniDis').lightbox_me({
                            centered: true, 
                        });
                    }
        });
    });
});

function belgeDurumuDuz(belgeNo){
// 	window.open('index.php');
	var test = encodeURIComponent(belgeNo);
	window.open('index.php?option=com_belgelendirme&view=belge_olusturma&layout=belge_durum&belgeNo='+test);
}

function belgeDuzenleme(belgeNo){
	jQuery.ajax({
		async:false,
		type:'POST',
		url:"index.php?option=com_belgelendirme&task=BasimdaBelgeVarMi&format=raw",
		data:"belgeNo="+belgeNo
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			alert('Bu belge Tekrar Basım için gönderilmiştir. Basılana veya reddedilene kadar düzenleme yapamazsınız.');
		}else{
			var test = encodeURIComponent(belgeNo);
			window.open('index.php?option=com_belgelendirme&view=tekrar_basim&layout=belge_duzenleme&belgeNo='+test);
		}
	});
	
}
</script>