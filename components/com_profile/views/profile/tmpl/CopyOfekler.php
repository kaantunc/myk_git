<?php
$eks = $this->eks;
$basvuruEk = $this->basvuruEk;
$kurulus = $this->kurulus_bilgi;
echo '<h2 style="margin-bottom:10px;"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';
echo $this->sayfaLink;
$belge = array(
	"taahutname"=>"1. Taahhütname *",
	"dekont"=>"2. Yetkilendirilme başvurusu masraf karşılığının yatırıldığına dair dekont *",
	"organizasyonsema"=>"3. Kurum/kuruluş organizasyon şeması *",
	"surecrehber"=>"4. Sınav ve belgelendirme süreçleriyle ilgili el kitabı, rehber ve prosedürler *",
	"sertifikaornek"=>"5. Yetkilendirilme talep edilen yeterliliklerle ilgili düzenlenen sertifika örnekleri",
	"gorevliliste"=>"6. Sınavlarda görev alacak kişilerin listesi",
	"gorevlibilgi"=>"7. Sınavlarda görevlendirilecekler ile belgelendirme süreçlerinde görev alacak diğer kişilere ilişkin bilgi formu",
	"gorevlibeyan"=>"8. Sınavlarda görevlendirilecekler ve belgelendirme süreçlerinde görev alacak diğer kişiler ile yönetmeliğin 17. maddesinin (b) ve (c) bentlerinde tanımlanan kişiler için yönetmelikteki şartları sağladığına dair kişisel beyan",
	"peryongorevtanim"=>"9. Belgelendirme faaliyetlerinde görev alan personel ve yöneticilere ilişkin görev tanımları *",
	"kurucumetin"=>"10. Başvuru sahibi kurum/kuruluşların kurucu metinleri (şirket ana sözleşmesi, dernek/vakıf tüzüğü, kurucu kanunlar, vb.) *",
	"denetimrapor"=>"11. Dışarıdan hizmet sağlayan kuruluşun yönetmelik hükümlerine ve akreditasyon şartlarına uygunluğu ile ilgili denetim raporları (Dışarıdan hizmet alımı yapan kuruluşlar için)",
	"protokolsozornek"=>"12. Sınav ve belgelendirme ile ilgili dışarıdan sağlanan hizmetlere ilişkin ilgili kuruluş(lar)la yapılan olan protokol/sözleşme örnekleri",
	"akreditasyonbelge"=>"13. Akreditasyon belgesi ve akreditasyon kapsamını gösterir belge",
	"akreditasyonrapor"=>"14. Akreditasyona ilişkin denetim raporu veya uygunsuzluk raporları suretleri *",
	"kurdegkayit"=>"15. Ticaret sicil gazetesi şirket kuruluş ve değişiklik kayıtları (şirketler ve kooperatifler için) *",
	"imzasirku"=>"16. Noter onaylı imza sirküleri[7] (Kuruluşu temsil ve ilzama yetkili kişiler ile kuruluş tarafından düzenlenen sertifikaları imzalamaya yetkili kişiler için) *",
	"bilancovergi"=>"17. Son üç yıla ilişkin bilanço, vergi levhası suretleri[8] *",
	"sgkborc"=>"18. SGK’dan alınacak sosyal güvenlik prim borcu bulunmadığını gösterir yazı[8] *",
	"vergi"=>"19. Vergi borcu bulunmadığını göstermek üzere bağlı bulunulan vergi dairesinden alınacak yazı[8] *",
	"tanitim"=>"20. Kuruluşu tanıtıcı materyal[9]",
	"misviz"=>"21. Kuruluş Misyon&Vizyon[9]",
	"urunhizmet"=>"22. Kuruluşun sahip olduğu ürün hizmet veya kalite belgeleri[9]",
	"ulusproje"=>"23. Konuyla ilgili ulusal veya uluslararası kuruluşlarca desteklenen projeler[9]",
	"ekdokumantasyon"=>"24. Kuruluş ile ilgili ilave edilmek istenen ek dokümantasyon[9]"
);
?>
<form id="EklerForm" method="POST" action="index.php?option=com_profile&task=DocFormKaydet" enctype="multipart/form-data">
<?php
foreach($belge as $key=>$val){ ?>
<div class="DocumentContainer" style="padding: 5px 0 10px 0;">
<div class="DocsContainer" style="width:100%;margin-top:20px;margin-bottom:10px">
	<h2><?php echo $val;?></h2>
	<table style="width:100%;" id="table_<?php echo $key;?>">
		<thead>
			<tr>
				<th width="40%">Döküman</th>
				<th width="30%">Yükleme Tarihi</th>
				<th width="20%">Durumu</th>
				<th width="10%">İşlem</th>
			</tr>
		</thead>
		<tbody style="text-align:center">
		<?php 
		$control = false;
		foreach($eks as $value){
			if(in_array($key, $value)){
				$control = true;	
			}
		}
		if($control == false){?>
			<tr class="EmptyDocs">
				<td colspan="4">İlgili ek döküman bulunmamaktadır !</td>
			</tr>
		<?php }else{
		if(count($eks) > 0){
			foreach($eks as $value){
				if($value['BELGE_TUR'] == $key){
					echo '<tr>';
					echo '<td><input type="hidden" name="docid" value="'.$value['ID'].'" />
			<input type="hidden" name="doctype" value="'.$value['BELGE_TUR'].'" />
			<input type="hidden" name="docstatus" value="'.$value['DURUM'].'" /> <a target="_blank" href="index.php?dl='.$value['BELGE_PATH'].'">'.$value['BELGE'].'</a></td>';
					echo '<td>'.$value['TARIH'].'</td>';
					if($value['DURUM'] == 1){
						if($this->canEdit){
							echo '<td><input style="background-color:red;color:white" type="button" onclick="docsOnayla('.$value['ID'].')" value="Onay Bekliyor" /></td>';
						}else{
							echo '<td><input style="background-color:red;color:white" type="button" value="Onay Bekliyor" /></td>';
						}
					}else if($value['DURUM'] == 2){
						if($this->canEdit){
							echo '<td><input style="background-color:green;color:white" type="button" onclick="docsOnayKaldir('.$value['ID'].')" value="Onaylandı" /></td>';
						}else{
							echo '<td><input style="background-color:green;color:white" type="button" value="Onaylandı" /></td>';
						}
					}
					
					if($this->canEdit){
						echo '<td>'.
								'<input type="button" class="SendArchiveDocs" style="background-color:green;color:white" value="Arşivle"/> /'.
								'<input type="button" onclick="docSil('.$value['ID'].')"  value="Sil"/>'.
							  '<td>';
					}else if($value['DURUM'] == 1){
						echo '<td>'.
								'<input type="button" class="SendArchiveDocs" style="background-color:green;color:white" value="Arşivle"/> /'.
							  	'<input type="button" onclick="docSil('.$value['ID'].')"  value="Sil"/>'.
							  '</td>';
					}
					echo '</tr>';
					}
				}
			}
		}?>
		</tbody>
		<tfoot>
			<tr>
			
			</tr>
		</tfoot>
	</table>
	
</div>
<div class="DocsOptions">
<input type="button" id="NewDocs" value="Yeni Döküman Ekle"/>
<input type="button" class="ArchiveDocs" value=" + Arşiv Görüntüle"/>
</div>
<div class="ArchiveDocsContainer" style="width:100%;margin-top:20px;margin-bottom:10px; display: none;">
	<table style="width:100%;" id="table_archive_<?php echo $key;?>">
		<thead>
			<tr>
				<th width="40%">Döküman</th>
				<th width="30%">Yükleme Tarihi</th>
				<th width="20%">Durumu</th>
				<th width="10%">İşlem</th>
			</tr>
		</thead>
		<tbody style="text-align:center">
		<?php 
		$controlarc = false;
		foreach($eks as $value){
			if(in_array($key."_Archieve", $value)){
				$controlarc = true;
			}
		}
		if($controlarc == false){?>
					<tr class="EmptyArchieve">
						<td colspan="4">İlgili dökümana ilişkin arşiv bulunmamaktadır !</td>
					</tr>
		<?php }else{
			foreach($eks as $value){
					if($value['BELGE_TUR'] == $key."_Archieve"){
						echo '<tr>';
							echo '<td><input type="hidden" name="docid" value="'.$value['ID'].'" />
			<input type="hidden" name="doctype" value="'.$value['BELGE_TUR'].'" />
			<input type="hidden" name="docstatus" value="'.$value['DURUM'].'" /><a target="_blank" href="index.php?dl='.$value['BELGE_PATH'].'">'.$value['BELGE'].'</a></td>';
							echo '<td>'.$value['TARIH'].'</td>';
							echo '<td>Arşiv</td>';
							echo '<td>'.
									'<input type="button" class="RemoveFromArchieve" style="background-color:red;color:white" value="Çıkar"/> /'.
								  	'<input type="button" onclick="docSil('.$value['ID'].')"  value="Sil"/>'.
								  '</td>';
						echo '</tr>';
				}
			}
		}
		?>
		</tbody>
	</table>
</div>
</div>
<?php if(array_key_exists($key, $basvuruEk)){?>
<div>
	<h2>Başvuru Ekleri</h2>
	<table style="width:100%;">
		<thead>
			<tr>
				<th width="40%">Döküman</th>
				<th width="30%">Yükleme Tarihi</th>				
			</tr>
		</thead>
		<tbody style="text-align:center">
<?php foreach ($basvuruEk[$key] as $tow){
		echo '<tr>';
		echo '<td><a href="/index.php?dl=belgelendirme_basvuru_ekleri/'.$tow['EVRAK_ID'].'/'.$key.'/'.$tow['BELGE_ADI'].'" target="_blank">'.$tow['BELGE_ADI'].'</a></td>';
		echo '<td>'.date('d/m/Y',$tow['TARIH']).'</td>';
		echo '</tr>';
	}
?>
		</tbody>
	</table>
</div>	
<?php } ?>
<hr>
<?php
}
?>
</form>
<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>
<?php echo $this->geriLink;?>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#NewDocs').live('click',function(e){
		e.preventDefault();
		if(jQuery('#DocSil').length > 0){
			alert('Lütfen Önce Dokumanı kaydediniz.');
		}else{
			var tableId = jQuery(this).closest(".DocumentContainer").find(".DocsContainer table").attr('id').split('_');
			var ekle = '<tr><td></td><td><input type="file" name="'+tableId[1]+'" /><br><input style="background-color:green;color:#ffffff" type="button" id="DocKaydet" value="Kaydet"/><input style="background-color:red;color:#ffffff;margin-left:5px;" type="button" id="DocSil" value="Sil"/></td><td></td></tr>';
			jQuery(this).closest(".DocumentContainer").find(".DocsContainer table").children('tbody').append(ekle);
		}
	});

	jQuery('#DocSil').live('click',function(e){
		e.preventDefault();
		jQuery(this).closest('tr').remove();
	});

	jQuery('#DocKaydet').live('click',function(e){
		e.preventDefault();
		jQuery('#EklerForm').submit();
	});
	jQuery(".ArchiveDocs").click(function(){
		jQuery(this).closest(".DocumentContainer").find(".ArchiveDocsContainer").toggle();
		if(jQuery(this).closest(".DocumentContainer").find(".ArchiveDocsContainer").css("display") == "none"){
			jQuery(this).val(" + Arşiv Görüntüle");		
		}else{
			jQuery(this).val(" - Arşiv Gizle");	
		}
	});
	jQuery(".SendArchiveDocs").live('click',function(e){
		button = jQuery(this);
		docId   = jQuery(this).closest('tr').find("input[name=docid]").val();
		docType = jQuery(this).closest('tr').find("input[name=doctype]").val();
		docStatus = jQuery(this).closest('tr').find("input[name=docstatus]").val();
		console.log(docStatus);
		if(docStatus != '2'){
			alert("Belge onaylanmadan arşivleme işlemi gerçekleştirilemez !");
		}else{
			jQuery.ajax({
	            type:"POST",
	            url:"index.php?option=com_profile&task=SendArchiveDoc&format=raw",
	            data:"docId="+docId+"&docType="+docType+"_Archieve",
	            dataType: "json",
	            beforeSend: function() {
	//             	jQuery('#loaderGif').lightbox_me({
	//         			centered: true,
	//         	        closeClick:false,
	//         	        closeEsc:false  
	//                 });
	            },
	            success:function(data){
		            if(data.STATUS == 1){
		            	alert(data.STATUSNAME);
		            	if(button.closest(".DocumentContainer").find(".ArchiveDocsContainer tbody tr.EmptyArchieve").length > 0){
		        			button.closest(".DocumentContainer").find(".ArchiveDocsContainer tbody tr.EmptyArchieve").remove();
		        		}
		        		archieveitem = "<tr>"+
		        							"<td>"+button.closest("tr").children('td:eq(0)').html()+"</td>"+
		        							"<td>"+button.closest("tr").children('td:eq(1)').html()+"</td>"+
		        							"<td>Arşiv</td>"+
		        							"<td>"+
		        								"<input type='button' class='RemoveFromArchieve' style='background-color:red;color:white' value='Çıkar'/> /"+
		        							  	"<input type='button' onclick='docSil('')'  value='Sil'/>"+
		        							"</td>"+
		        						"</tr>";
		        	
		        		button.closest(".DocumentContainer").find(".ArchiveDocsContainer tbody").append(archieveitem);
		        		button.closest(".DocumentContainer").find(".ArchiveDocsContainer tbody ").children('tr:eq(0)').children('td:eq(0)').find("input[name=doctype]").val(data.DOCTYPE);
		        		if(button.closest(".DocumentContainer").find(".ArchiveDocsContainer tbody tr").length > 0){
		        			button.closest(".DocumentContainer").find(".ArchiveDocs").trigger('click');
		        		}
		        		button.closest("tr").remove();
		            }else{
		            	alert(data.STATUSNAME);
			        }
	// 	            jQuery('#loaderGif').trigger('close');
	            },  
	            complete : function (){
	// 				jQuery('#loaderGif').trigger('close');
	            }
			});
		} 
		
	});
	jQuery(".RemoveFromArchieve").live('click',function(e){
		button = jQuery(".RemoveFromArchieve");
		docId   = jQuery(this).closest('table').find("input[name=docid]").val();
		docType = jQuery(this).closest('table').find("input[name=doctype]").val();
		jQuery.ajax({
            type:"POST",
            url:"index.php?option=com_profile&task=RemoveFromArchieveDoc&format=raw",
            data:"docId="+docId+"&docType="+docType,
            dataType: "json",
            beforeSend: function() {
//             	jQuery('#loaderGif').lightbox_me({
//         			centered: true,
//         	        closeClick:false,
//         	        closeEsc:false  
//                 });
            },
            success:function(data){
            	
	            if(data.STATUS == 1){
	            	alert(data.STATUSNAME);
	            	if(button.closest(".DocumentContainer").find(".DocsContainer tbody tr.EmptyDocs").length > 0){
	            		button.closest(".DocumentContainer").find(".DocsContainer tbody tr.EmptyDocs").remove();
	        		}
	        		Archievetable = button.closest("table");
	        		removedarchieve = "<tr>"+
	        					"<td>"+button.closest("tr").children('td:eq(0)').html()+"</td>"+
	        					"<td>"+button.closest("tr").children('td:eq(1)').html()+"</td>"+
	        					"<td><input style='background-color:green;color:white' type='button' onclick='docsOnayKaldir()' value='Onaylandı' /></td>"+
	        					"<td>"+
	        						"<input type='button' class='SendArchiveDocs' style='background-color:green;color:white' value='Arşivle'/> /"+
	        					  	"<input type='button' onclick='docSil('')'  value='Sil'/>"+
	        					"</td>"+
	        				 "</tr>";
	        		button.closest(".DocumentContainer").find(".DocsContainer table tbody").append(removedarchieve);
	        		button.closest(".DocumentContainer").find(".DocsContainer tbody ").children('tr:eq(0)').children('td:eq(0)').find("input[name=doctype]").val(data.DOCTYPE);
	        		button.closest("tr").remove();
	        		if(Archievetable.find("tbody").children("tr").length == 1){
	        			warning = "<tr class='EmptyArchieve'>"+
	        						  "<td colspan='4'>İlgili dökümana ilişkin arşiv bulunmamaktadır !</td>"+
	        					  "</tr>";
	        					  Archievetable.append(warning);
	        		}
	            }else{
	            	alert(data.STATUSNAME);
		        }
	            window.location.reload();
// 	            jQuery('#loaderGif').trigger('close');
            },  
            complete : function (){
// 				jQuery('#loaderGif').trigger('close');
            }
		});
	});
});

function docsOnayla(docId){
	if(confirm('Bu dökümanı onaylamak istediğinizden emin misiniz?')){
		jQuery('#loaderGif').lightbox_me({
			centered: true,
	        closeClick:false,
	        closeEsc:false  
        });

        jQuery.ajax({
            async:false,
            type:"POST",
            url:"index.php?option=com_profile&task=DocsOnayla&format=raw",
            data:"docId="+docId,
            success:function(data){
                window.location.reload();
                }
		});
	}
}

function docsOnayKaldir(docId){
	if(confirm('Bu dökümanın onayını kaldırmak istediğinizden emin misiniz?')){
		jQuery('#loaderGif').lightbox_me({
			centered: true,
	        closeClick:false,
	        closeEsc:false  
        });

        jQuery.ajax({
            async:false,
            type:"POST",
            url:"index.php?option=com_profile&task=DocsOnayKaldir&format=raw",
            data:"docId="+docId,
            success:function(data){
                window.location.reload();
                }
		});
	}
}

function docSil(docId){
	if(confirm('Bu dökümanı silmek istediğinizden emin misiniz?')){
		jQuery('#loaderGif').lightbox_me({
			centered: true,
	        closeClick:false,
	        closeEsc:false  
        });

        jQuery.ajax({
            async:false,
            type:"POST",
            url:"index.php?option=com_profile&task=DocsSil&format=raw",
            data:"docId="+docId,
            success:function(data){
                 window.location.reload();
                }
		});
 	}
}


</script>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>