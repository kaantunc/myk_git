<?php 
$IstekUser = $this->IstekUser;
$TesvikImzaUserName = $this->TesvikImzaUserName;
?>

<div class="anaDiv hColor font20 text-center text-underline fontBold">
	Teşvikten Yararlanmak İsteyen Adaylar
</div>
<form action="index.php?option=com_tesvik&view=tesvik&layout=tesvik_adaylar" enctype="multipart/form-data" method="post">
<div class="anaDiv">
	<div class="div30 hColor font18">
		Teşvik Yararlanma Tarihi:
	</div>
	<div class="div70">
<!-- 		<div class="divYan"> -->
<!-- 			<input class="input-sm tarih" type="text" name="basTarih"/> -->
<!-- 		</div> -->
		<div class="divYan">
			<input class="input-sm tarih" type="text" name="bitTarih" title="teasdasdsd"/>
		</div>
		<div class="divYan">
			<button type="submit" class="btn btn-sm btn-primary">Yeni Teşvik Talebi Oluştur</button>
		</div>
	</div>
</div>
<div class="anaDiv">
<hr>
</div>
</form>

<!-- Teşvik Talebi (Teşvik talebinden bulununan adaylar) -->
<div class="anaDiv">
<table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
		<thead style="text-align:center;background-color:#71CEED">
			<tr>
				<th width="5%">Sıra</th>
				<th width="5%">İstek ID</th>
				<th width="10%">İstek Sahibi</th>
				<th width="10%">İstek Tarihi</th>
				<th width="10%">Teşvik Yararlanma Tarihi</th>
				<th width="10%">Detay</th>
				<th width="10%">Aday Sayısı</th>
				<th width="10%">Durum</th>
				<th width="10%">Düzenle</th>
				<th width="10%">PDF</th>
			</tr>
		</thead>
		<tbody class="text-center">
		<?php
		$say = 1;
		foreach ($this->tesvikIstek as $row){
			$ImzaName = '<strong><u>Onaylayan Kullanıcılar</u></strong><br>';
			$ImzaNot = '<br><strong><u>Onayı Beklenen Kullanıcılar</u></strong><br>';
			foreach ($TesvikImzaUserName as $key2=>$tow){
				if(in_array($key2, $this->ImzaUser[$row['ID']])){
					$ImzaName .= $tow.'<br>';
				}else{
					$ImzaNot .= $tow.'<br>';
				}
			}
			$ImzaName .= $ImzaNot;
			
			echo '<tr>';
			echo '<td>'.$say.'</td>';
			echo '<td>'.$row['ID'].'</td>';
			echo '<td>'.$IstekUser[$row['ID']].'</td>';
			echo '<td>'.$row['TARIH'].'</td>';
			echo '<td>'.$row['ARAMA_TARIH'].'</td>';
			echo '<td><button type="button" class="btn btn-xs btn-warning tooltipHtml detail" istekid = "'.$row['ID'].'">Detay</button></td>';
			echo '<td>'.$this->tesvikIstekAday[$row['ID']].'</td>';
			if($row['DURUM'] == 0){
				if($this->user_id == $row['USER_ID']){
					echo '<td><button type="button" class="btn btn-xs btn-success" onclick="FuncTesvikOnayaSun('.$row['ID'].')">Onaya Sun</button></td>';
				}else{
					echo '<td><button type="button" class="btn btn-xs btn-info">Oluşturuluyor</button></td>';
				}
			}else if($row['DURUM'] == 1){
				if(in_array($this->user_id, $this->ImzaUserArray)){
					if(in_array($this->user_id, $this->ImzaUser[$row['ID']])){
						echo '<td><button type="button" class="btn btn-xs btn-success tooltipHtml" title="'.$ImzaName.'" onclick="FuncTesvikOnayla('.$row['ID'].','.$this->user_id.')">Onay Bekleniyor</button></td>';
					}else{
						echo '<td><button type="button" class="btn btn-xs btn-success tooltipHtml" title="'.$ImzaName.'" onclick="FuncTesvikOnayla('.$row['ID'].','.$this->user_id.')">Onayla</button><br></td>';
					}
				}else{
					echo '<td><button type="button" class="btn btn-xs btn-info tooltipHtml" title="'.$ImzaName.'">Onay Bekleniyor</button></td>';
				}
			}else if($row['DURUM'] == 2){
				if($this->UserGroup == 999 || $this->UserGroup == 29){
					echo '<td><button type="button" class="btn btn-xs btn-success" onclick="FuncTesvikGonder('.$row['ID'].',3)">İŞKURA Gönder</button></td>';
				}else{
					echo '<td><button type="button" class="btn btn-xs btn-info">SGB ye Sunuldu</button></td>';
				}
			}else if($row['DURUM'] == 3){
				if($this->UserGroup == 999 || $this->UserGroup == 29){
					echo '<td>
							 <button type="button" class="btn btn-xs btn-success" onclick="FuncTesvikGonder('.$row['ID'].',4)">Bankaya Gönder</button><br>
							 <a target="_blank" href="index.php?option=com_tesvik&view=tesvik&layout=tesvikpdfbanka&tesvikId='.$row['ID'].'&previewtxt=1" class="btn btn-xs btn-warning">Bankaya Txt Önizleme</a>
						 </td>';
				}else{
					echo '<td><button type="button" class="btn btn-xs btn-info">İşkura gönderildi</button></td>';
				}
			}else if($row['DURUM'] == 4){
				echo '<td>
						<button type="button" class="btn btn-xs btn-info">Ödeme Beklemede</button><br>
					 	<a target="_blank" href="index.php?option=com_tesvik&view=tesvik&layout=tesvikpdfbanka&tesvikId='.$row['ID'].'" class="btn btn-xs btn-success">Banka Txt</button>
					 </td>';
			}else if($row['DURUM'] == 5){
				echo '<td>';
				echo '<a target="_blank" href="index.php?option=com_tesvik&view=tesvik&layout=tesvikpdfbanka&tesvikId='.$row['ID'].'" class="btn btn-xs btn-success">Bankaya Gönderilen Txt</a><br/>';
				echo '<a target="_blank" href="index.php?option=com_tesvik&view=tesvik&layout=tesvikpdfbanka&tesvikId='.$row['ID'].'&aftertransfer=1" class="btn btn-xs btn-warning">Banka Akibet Txt</a><br/>';
				if($this->TesvikTamamlanan[$row['ID']]['odendi']>0){
					echo '<a target="_blank" href="index.php?option=com_tesvik&view=tesvik&layout=odenen&tesvikId='.$row['ID'].'" class="text-success fontBold font16">'.$this->TesvikTamamlanan[$row['ID']]['odendi'].' ödendi.</a><br>';
				}
				
				if($this->TesvikTamamlanan[$row['ID']]['odenmedi']>0){
					echo '<a target="_blank" href="index.php?option=com_tesvik&view=tesvik&layout=odenemeyen&tesvikId='.$row['ID'].'" class="text-danger fontBold font16">'.$this->TesvikTamamlanan[$row['ID']]['odenmedi'].' ödenemedi</a>.';
				}
				echo '</td>';
			}
			
			if($row['DURUM'] == 0){
				if($this->user_id == $row['USER_ID']){
					echo '<td>
					<div class="anaDiv">
					<div class="divYan">
					<a href="index.php?option=com_tesvik&view=tesvik&layout=tesvik_edit&tesvikId='.$row['ID'].'" class="btn btn-xs btn-warning">Düzenle</a>
					</div>
					<div class="divYan">
					<button type="button" onclick="FuncTesvikIstekSil('.$row['ID'].')" class="btn btn-xs btn-danger">Sil</button>
					</div>
					</div>
					</td>';
				}else{
					echo '<td></td>';
				}
			}else if($row['DURUM'] == 1 || $row['DURUM'] == 2){
				echo '<td><button type="button" class="btn btn-xs btn-warning" onclick="FuncTesvikGeriGonder('.$row['ID'].','.$this->user_id.')">Geri Gönder</button></td>';
			}else{
				echo '<td></td>';
			}
			
			echo '<td><a target="_blank" href="index.php?option=com_tesvik&view=tesvik&layout=tesvikpdf&tesvikId='.$row['ID'].'" class="btn btn-xs btn-danger">PDF</a></td>';
			echo '</tr>';
			$say++;
		} 
		?>
		</tbody>
	</table>
</div>

<div id="istekContainer" style="width:520px; max-width: 800px; min-height:200px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form method="POST" id="protestFeeForm" enctype="multipart/form-data" action="index.php?option=com_scheduled_tasks&task=SaveScheduledTask">
    	<div class="anaDiv text-center font20 hColor" id="baslik">
    		Teşvik İstek Detayı
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			İstek Id:
    		</div>
    		<div class="div60" id="istekid"></div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			İstek Sahibi:
    		</div>
    		<div class="div60" id="isteksahibi"></div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			İstek Tarihi:
    		</div>
    		<div class="div60" id="istektarihi"></div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Teşvik Yararlanma Tarihi:
    		</div>
    		<div class="div60" id="istekyararlanmatarihi"></div>
    	</div>
    	<div class="anaDiv">
    		<div class="div40 font16 hColor">
    			Banka Ödeme Tarihi:
    		</div>
    		<div class="div60">
    			<input type="text" name="banka_odeme_tarihi" class="input-sm inputW60"/>
    		</div>
    	</div>
    	<div class="anaDiv">
    		<div style="float:right;">
	    		<div class="divYan">
	    			<button type="button" class="btn btn-xs btn-success" id="istekKaydet">Kaydet</button>
	    		</div>
	    		<div class="divYan">
	    			<button type="button" class="btn btn-xs btn-danger" id="istekIptal">İptal</button>
	    		</div>
    		</div>
    	</div>        
    </form>
</div>
<!-- Teşvik Talebi (Teşvik talebinden bulununan adaylar son) -->

<script type="text/javascript">
jQuery(document).ready(function(){
	 jQuery("#istekIptal").click(function(){

		jQuery("#istekid").html("");
		jQuery("#isteksahibi").html("");
		jQuery("#istektarihi").html("");
		jQuery("#istekyararlanmatarihi").html("");
		jQuery("input[name='banka_odeme_tarihi']").val("");
		jQuery("#istekContainer").trigger('close');
	 });
	 jQuery("#istekKaydet").click(function(){
		 jQuery.ajax({
	 			type: "POST",
	 			dataType:"json",
	 			url: "index.php?option=com_tesvik&format=raw&task=saveIstekDetay",
	 			data:"istekId="+jQuery('#istekid').html()+"&bankaodemetarihi="+jQuery('input[name=banka_odeme_tarihi]').val(),
	 			beforeSend:function(){
	 				 jQuery.blockUI();
		 		},
	 			success: function(data){
	 				alert(data.STATUS_MESSAGE);
		 			if(data.STATUS == true){
		 				window.location.reload();	
			 		}
	 			},
	 			complete : function (){
	 				jQuery.unblockUI();
	             }
	 		});
     });
	 jQuery("input[name='banka_odeme_tarihi']").datepicker({
         changeYear: true,
         changeMonth: true
 		 });
	  
	var oTables = jQuery('#kurTable').dataTable({
// 		"aaSorting": [[ 1, "asc" ]],
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": "# _MENU_ öğe göster",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ İstek Oluşturuldu)",
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
	
	jQuery('.tarih').live('hover',function(e){
		e.preventDefault();
		jQuery(this).datepicker({
			changeYear: true,
		    changeMonth: true
		});
	});

	jQuery(".detail").click(function(){
		jQuery.ajax({
 			type: "POST",
 			dataType:"json",
 			url: "index.php?option=com_tesvik&format=raw&task=istekDetay",
 			data:"istekId="+jQuery(this).closest('tr').find('td:eq(1)').html(),
 			beforeSend:function(){
 				 jQuery.blockUI();
	 		},
 			success: function(data){
	 			if(data.STATUS == true){
					jQuery("#istekid").html(data.DATA['ID']);
					jQuery("#isteksahibi").html(data.DATA['NAME']);
					jQuery("#istektarihi").html(data.DATA['TARIH']);
					jQuery("#istekyararlanmatarihi").html(data.DATA['BIT_TARIH']);
					jQuery("input[name='banka_odeme_tarihi']").val((data.DATA['BANKA_ODEME_TARIHI'] == "" ? "" : data.DATA['BANKA_ODEME_TARIHI']));
		 		}else{
					alert("Teknikbir problem oluştu.Lütfen tekrar deneyiniz !");
			 	}
 			},
 			complete : function (){
 				jQuery.unblockUI();
             }
 		});

		 jQuery("#istekContainer").lightbox_me({
				overlaySpeed: 350,
				lightboxSpeed: 400,
		    	centered: true,
		        closeClick:false,
		        closeEsc:false,
		        overlayCSS: {background: 'black', opacity: .7}
		    });

		    
	});

//     jQuery('input[name="bitTarih"]').tooltipster({
//     	positionTracker: true,
//     	position: 'bottom',
//     	theme: 'tooltipster-shadow',
//     	content: jQuery('<span><img src="http://img-cdn.ntvspor.net/banners/ekspres_logo_1.jpg" /> <strong>This text is in bold case !</strong></span>'),
//     	/*functionBefore: function(origin, continueTooltip) {

//             // we'll make this function asynchronous and allow the tooltip to go ahead and show the loading notification while fetching our data
//             continueTooltip();

//             // next, we want to check if our data has already been cached
//             if (origin.data('ajax') !== 'cached') {
//                 $.ajax({
//                     type: 'POST',
//                     url: 'example.php',
//                     success: function(data) {
//                         // update our tooltip content with our returned data and cache it
//                         origin.tooltipster('content', data).data('ajax', 'cached');
//                     }
//                 });
//             }
//         }*/
//     });

    jQuery('.tooltipHtml').tooltipster({
    	positionTracker: true,
    	theme: 'tooltipster-shadow',
    	contentAsHTML: true,
    	interactive: true
    });
	
});

function FuncTesvikIstekSil(tId){
	if(confirm('Bu Teşvik İsteğini Silmek İstediğinizden Emin Misiniz?')){
		OpenLightBox('#loaderGif');
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_tesvik&task=TesvikSil&format=raw",
			data:'tId='+tId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Teşvik İsteği Başarıyla Silindi.');
				window.location.reload();
			}else{
				alert('Teşvik İsteği Silme İşleminde Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
				window.location.reload();
			}
		});
	}else{
		return false;
	}
}

function FuncTesvikOnayaSun(tId){
	if(confirm('Bu Teşvik İsteğini Onaya Sunmak İstediğinizden Emin Misiniz? Onaya Sunulan Teşvik İstekleri Yönetici Tarafından Düzeltme İstenmediği Sürece Düzeltme Yapılamaz.')){
		OpenLightBox('#loaderGif');
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_tesvik&task=TesvikOnayaSun&format=raw",
			data:'tId='+tId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Teşvik İsteği Başarıyla Yönetici Onayına Sunuldu.');
				window.location.reload();
			}else{
				alert('Teşvik İsteği Onaya Sunma İşleminde Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
				window.location.reload();
			}
		});
	}else{
		return false;
	}
}

function FuncTesvikOnayla(tId,uId){
	if(confirm('Bu Teşvik İsteğini Onaylamak İstediğinizden Emin Misiniz?')){
		OpenLightBox('#loaderGif');
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_tesvik&task=TesvikOnayla&format=raw",
			data:'tId='+tId+'&uId='+uId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Teşvik İsteği Başarıyla Onaylandı.');
				window.location.reload();
			}else{
				alert('Teşvik İsteği Onaylama İşleminde Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
				window.location.reload();
			}
		});
	}else{
		return false;
	}
}

function FuncTesvikGeriGonder(tId,uId){
	if(confirm('Bu Teşvik İsteğini Düzenlenmesi İçin Geri Göndermek İstediğinizden Emin Misiniz?')){
		OpenLightBox('#loaderGif');
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_tesvik&task=TesvikGeriGonder&format=raw",
			data:'tId='+tId+'&uId='+uId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Teşvik İsteği Başarıyla Onaylandı.');
				window.location.reload();
			}else{
				alert('Teşvik İsteği Onaylama İşleminde Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
				window.location.reload();
			}
		});
	}else{
		return false;
	}
}

function CloseLightBox(ele){
	jQuery(ele).trigger('close');
	return true;
}

function OpenLightBox(ele, overSpeed, boxSpeed){
	jQuery(ele).lightbox_me({
		overlaySpeed: 350,
		lightboxSpeed: 400,
    	centered: true,
        closeClick:false,
        closeEsc:false,
        overlayCSS: {background: 'black', opacity: .7}
    });
    return false;
}

function UyariLightBox(sonra){
	if(sonra){
		jQuery('#UyariModal').lightbox_me({
			overlaySpeed: 300,
			lightboxSpeed: 350,
	    	centered: true,
	        closeClick:false,
	        closeEsc:false,
	        overlayCSS: {background: 'black', opacity: .7},
	        onClose: OpenLightBox(sonra)
	    });
	}else{
		jQuery('#UyariModal').lightbox_me({
			overlaySpeed: 300,
			lightboxSpeed: 350,
	    	centered: true,
	        closeClick:false,
	        closeEsc:false,
	        overlayCSS: {background: 'black', opacity: .7}
	    });
	}
}

function FuncTesvikGonder(tId,dId){
	if(dId == 4){
		if(confirm('Bu Teşvik İsteğini Ödenmesi İçin Bankaya Göndermek İstediğinizden Emin Misiniz?')){
			OpenLightBox('#loaderGif');
			jQuery.ajax({
				async:false,
				type:"POST",
				url:"index.php?option=com_tesvik&task=TesvikBankayaGonder&format=raw",
				data:'tId='+tId+'&dId='+dId
			}).done(function(data){
				var dat = jQuery.parseJSON(data);
				alert(dat.STATUS_MESSAGE);
				window.location.reload();
			});
		}else{
			return false;
		}
	}else if(dId == 3){
		OpenLightBox('#loaderGif');
		jQuery.ajax({
			async:false,
			type:"POST",
			url:"index.php?option=com_tesvik&task=TesvikIskuraGonder&format=raw",
			data:'tId='+tId+'&dId='+dId
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Teşvik İsteği İşkura Gönderildi.');
				window.location.reload();
			}else{
				alert('Bir Hata Meydana Geldi. Lütfen Tekrar Deneyin.');
				window.location.reload();
			}
		});
	}else{
		return false;
	}
	
}
</script>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>