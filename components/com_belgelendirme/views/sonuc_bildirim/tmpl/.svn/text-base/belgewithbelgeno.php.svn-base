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
<?php echo $this->sayfaLinkBelge;?>
<h2>Belge Sorgulama</h2>
<hr><br>
<div>
	<label>Belge Numarası ile Ara</label>
</div>
<div id="BelgeSorgulaBelgeNo" style="display:inline-block">
<hr>
        <label>Belgel Numarası:<input type="text" id="Nobelge" style="width:200px"/><input type="button" id="NobelgeGetir" value="Getir" /></label><br><br>
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
                <th width="15%">Belge No:</th>
<!--                 <th width="15%">Açıklama</th> -->
                <th width="7%">Başarılı Birimler</th>
                <th width="7%">Geçerlilik Durumu</th>
                <th width="7%">Tekrar Basım</th>
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

    var table_config = {
            "bDestroy": true,
            "paging": false,
            "language": {
                "zeroRecords": "No results found",
                "processing": "<div align='center'><img src='/static/ajax-loader.gif'></div>",
                "loadingRecords": "<div align='center'><img src='/static/ajax-loader.gif'></div>"
            }
        }; 
    
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

    	var belgeNo = jQuery('#Nobelge').val();
    	 if(belgeNo == ''){
             alert('Lütfen Belge Numarası giriniz.');
         }
         else{
         	jQuery.ajax({
                 type: 'POST',
                 url:"index.php?option=com_belgelendirme&view=belgelendirme_islemleri&task=KurulusSinavlarBelgeNo&format=raw",
                 data:'belgeNo='+belgeNo+'&kurulusId=<?php echo $this->kurulusId; ?>',
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
                                 if(value['SINAV_ID'] != undefined){
                                 	adaylar += '<td align="center"><input type="button" id="birimler" value="Birimleri"/></td>';
                                 }else{
                                 	adaylar += '<td align="center"></td>';
                                 }

                                 if(value['BELGEDURUMU'] == 1){
                                 	adaylar += '<td align="center"><span style="color:green;">Geçerli</span></td>';
                                 }else if(value['BELGEDURUMU'] == 2){
                                 	adaylar += '<td align="center"><span style="color:red;">İptal Edildi</span></td>';
                                 }else if(value['BELGEDURUMU'] == 3){
                                 	adaylar += '<td align="center"><span style="color:red;">Askıya Alındı</span></td>';
                                 }
                                 adaylar += '<td align="center"><button type="button" class="btn btn-xs btn-warning" onclick="belgeDuzenleme('+"'"+value['BELGE_NO']+"'"+')">Düzenle</button></td></tr>';
                                 adaylar += '</tr>';
                                 
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