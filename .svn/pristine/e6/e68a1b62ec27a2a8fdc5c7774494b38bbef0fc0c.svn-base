<style>
<!--
span.label {
	width:150px;
	font-weight: bold;
}
-->
</style>

<?php
$yets = $this->kurYets;
$adayVarmi = $this->adayVarmi;
$programsGelecek = $this->programsGelecek;
$programsGecmis = $this->programsGecmis;
$programsYapilmayan = $this->programsYapilmayan;
$IptalProgram = $this->IptalProgram;

$yetOption = '<option value="">Seçiniz</option>';
foreach ($yets as $yet){
	$yetOption .= '<option value="'.$yet['YETERLILIK_ID'].'">'.trim($yet['YETERLILIK_KODU']).'/'.$yet['REVIZYON'].' - '.$yet['YETERLILIK_ADI'].'</option>';
}


// $ilOption = '';
// foreach ($ils as $il){
// 	$ilOption .=  '<option value="'.$il['IL_ID'].'">'.$il['IL_ADI'].'</option>';
// }
echo $this->sayfaLink;
if(!$yets){
	echo '<p style="color:#ff4136;font-size:16px;font-weight:bold;" class="text-center">Yetki Kapsamınız Askıya alındığı için hiç bir yeterlilikten sınav yapamazsınız.</p>';
}
?>
<div class="anaDiv">
	<h2 style="color:#063B5E; border-bottom: 1px solid #42627D;">Sınav Programı Bildirim Ekranı</h2><br>
</div>
<?php if($yets){ ?>
<div class="anaDiv">
	<button type="button" class="btn btn-sm btn-primary" id="sinavs"><i class="fa fa-plus"></i> Yeni Sınav Ekle</button>
</div>
<div class="anaDiv">
<div id="yeniSinav" style="display:none">
	<form method="POST" id="programKaydetmeFormu"
		action="index.php?option=com_belgelendirme&task=program_kaydet&layout=belgelendirme_program" enctype="multipart/form-data">
	<br><hr><br>
	<div class="anaDiv">
		<div class="div20 font16 hColor">Yeterlilik:</div>
		<div class="div80"><select id="yets" name="yets" class="input-sm"><?php echo $yetOption;?></select></div>
	</div>
	<div class="anaDiv">
		<div class="div20 font16 hColor">Başlangıç Tarihi:</div>
		<div class="div80"><input type="text" id="bastar" name="bastar" class="input-sm" readonly="readonly"/></div>
	</div>
    <div class="anaDiv">
        <div class="div20 font16 hColor">Başlangıç Saati:</div>
        <div class="div80"><input type="text" id="bassaat" name="bassaat" class="input-sm"/></div>
    </div>
	<div class="anaDiv">
		<div class="div20 font16 hColor">Sınav İli:</div>
		<div class="div80"><input type="text" id="il" name="il" class="input-sm" /></div>
	</div>
    <div class="anaDiv">
        <div class="div20 font16 hColor">Aday Dosyası:</div>
        <div class="div80"><input type="file" id="adayFile" name="upload" class="input-sm" /></div>
    </div>
    <div class="anaDiv">
        <div class="div20 font16 hColor">Aday Bildirim Dosyası:</div>
        <div class="div70">
            <a class="btn btn-sm btn-info" target="_blank" href="<?php echo SITE_URL;?>ekler/aday_bildirim.xls">İndir</a>
        </div>
    </div>
	<div class="anaDiv"><button type="button" class="btn btn-sm btn-success" id="sinavKaydet">Kaydet</button></div>
	<!--	<a href="#" id="sinavKaydet" >Kaydet</a>-->
	</form>						
</div>
</div>
<?php }?>
<br>
<!--<a href="#" id="sinavs">Yeni Sinav Ekle</a>-->
<br>
<hr>
<br>
<div id="KayitliSinavs">
<div class="anaDiv">
	<table style="width:100%; text-align:center;"  border="0" cellpadding="0" cellspacing="10">
		<tr>
			<td colspan="2" width="30%"><a href="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program&program=1" id="Glprogram" style="border:1px solid #1C617C;margin:2px;padding:5px;background-color:#ffffff;color:black;">Açık Sınavlar</a></td>
			<td width="22%"><a href="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program&program=2" id="Gcprogram" style="border:1px solid #1C617C;margin:2px;padding:5px;background-color:#ffffff;color:black;">Tamamlanmış Sınavlar</a></td>
			<td width="24%"><a href="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program&program=3" id="Ypprogram" style="border:1px solid #1C617C;margin:2px;padding:5px;background-color:#ffffff;color:black;">Tamamlanmamış Sınavlar</a></td>
            <td width="24%"><a href="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program&program=5" id="IPprogram" style="border:1px solid #1C617C;margin:2px;padding:5px;background-color:#ffffff;color:black;">İptal Edilmiş Sınavlar</a></td>
		</tr>
		<tr>
			<td><a href="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program&program=1" id="Glprogram1" style="border:1px solid #1C617C;padding:5px;background-color:#ffffff;color:black;">Aday Bildirimi</a></td>
			<td><a href="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program&program=4" id="Glprogram4" style="border:1px solid #1C617C;padding:5px;background-color:#ffffff;color:black;">Sonuç Bildirimi</a></td>
		</tr>
	</table>
</div>
<div class="anaDiv">
	<form id="Fromarama" method="POST" action="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program&program=<?php echo $_GET['program'] ?>" >
		<div class="div40">
			<div class="divYan font16 hColor">Yeterlilik:</div>
			<div class="divYan"><select id="yeter" name="yeter" class="input-sm" style="width:90%"><?php echo $yetOption; ?></select></div>
		</div>
		<div class="div60">
			<div class="divYan font16 hColor">Tarih aralığı:</div>
			<div class="divYan"><input type="text" name="tartar" class="input-sm" id="tartar" readonly="true"/></div>
			<div class="divYan"><input type="text" name="sontar" class="input-sm" id="sontar" readonly="true"/></div>
			<div class="divYan"><button type="submit" class="btn btn-sm btn-warning">Ara</button></div>
		</div>
		
		<input type="hidden" name="program" id="programId" />
	
	</form>
</div>
<div id="gelecekProgram" style="display:none" class="anaDiv">
<?php if(count($programsGelecek) > 0){
?>
<table style="width:100%;" border="0" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED" class="thPad5">
		<tr>
			<th width="4%">Sınav ID</th>
			<th width="40%">Yeterlilik</th>
			<th width="10%">Başlangıç Tarihi ve Saati</th>
			<th width="20%">Sınav İli</th>
			<th width="15%">Sınav Durumu</th>
			<th width="8%">Bildirilme Durumu</th>
			<th width="5%">İptal</th>
			<th width="5%">Aday İşlemleri</th>
		</tr>
	</thead>
	<tbody id="sınavTbody" class="tdPad5 fontBold">
	<?php 
	$even = 'bgcolor="#efefef"';
	$say = 1;
    $datecon1 = date('d-m-Y',mktime(0,0,0,date("m"),date("d")+1,date("Y")));
    $datecon = date('d-m-Y',mktime(0,0,0,date("m"),date("d")+2,date("Y")));
    $datecongun = date('d-m-Y',mktime(0,0,0,date("m"),date("d")+3,date("Y")));
    $datecon5 = date('d-m-Y',mktime(0,0,0,date("m"),date("d")+5,date("Y")));
    $daylen = 60*60*24;

	foreach ($programsGelecek as $cow){ 
		if($say%2 == 0){
		    echo '<tr id="'.$cow['SINAV_ID'].'" '.$even.'>';
		}
		else{
			echo '<tr id="'.$cow['SINAV_ID'].'">';
		}
		$say++;

        $basdate = str_replace('/','-',$cow['BASLANGIC_TARIHI']);
        $saat = str_replace(':','',$cow['BASSAAT']);
        $saatKontrol = str_replace(':','',$cow['BASSAAT'])+100;

		echo '<td align="center">'.$cow['SINAV_ID'].'</td>';
		echo '<td align="center">'.trim($cow['YETERLILIK_KODU']).'/'.$cow['REVIZYON'].' - '.$cow['YETERLILIK_ADI'].'</td>';
		echo '<td align="center">'.$cow['BASLANGIC_TARIHI'].' '.$cow['BASSAAT'].'</td>';
		echo '<td id="prIl" align="center">';

        if(strtotime($basdate) > strtotime(date('d-m-Y'))){
            echo $cow['SINAV_ILI'].'</br><button style="margin-top:5px" class="btn btn-xs btn-warning" onclick="FuncSinavIli('.$cow['SINAV_ID'].')">Düzenle</button>';
    	}else{
            echo $cow['SINAV_ILI'];
        }
        echo '</td>';
		echo '<td align="center">';

		if($cow['BILDIRIM_DURUMU'] == 1 && strtotime(date('d-m-Y')) == strtotime($basdate)){
            if($saat > (date('Hi')+100)){
                echo "<p style='color:red'>Aday Bildirimi bugün saat " . $cow['BASSAAT'] . " kadardır.</p>";
                $exsaat = explode(':',$cow['BASSAAT']);
                echo "<p style='color:red'>Sınav İptali bugün saat " . ($exsaat[0]-1).":".$exsaat[1]. " kadardır.</p>";
            }else if($saat > date('Hi')) {
                echo "<p style='color:red'>Aday Bildirimi bugün saat " . $cow['BASSAAT'] . " kadardır.</p>";
            }
		}
    	else if($cow['BILDIRIM_DURUMU'] == 1 && strtotime($datecon1) < strtotime($basdate)){
            echo '<p style="color:red">İl değiştirmek için '.round((strtotime($basdate)-strtotime($datecon1))/$daylen).' gün kaldı.</p>';
		}
		else if($cow['BILDIRIM_DURUMU'] == 0 && strtotime($datecon) < strtotime($basdate)){
		    echo '<p style="color:red">Sınav bildirim için '.round((strtotime($basdate)-strtotime($datecon))/$daylen).' gün kaldı.</p>';
		}
		else{
				
		}
        echo '</td>';
		echo '<td id="bildirimDurum" align="center">';
		if($cow['BILDIRIM_DURUMU'] == 1){
		    echo '<span style="color:green">Bildirildi</span>';
		}else{
			if(strtotime($datecon) >= strtotime($basdate)){
				echo '<span style="color:red">Bildirilmedi</span>';
			}else{
				echo '<input type="button" id="bildir" value="Bildir"/>';
			}
		}
        echo '</td>';
		echo '<td align="left">';
        if(strtotime($basdate) > strtotime(date('d-m-Y'))){
            echo '<button class="btn btn-xs btn-danger" onclick="FuncSinavIptal('.$cow['SINAV_ID'].')">İptal</button>';
        }else if(strtotime($basdate) == strtotime(date('d-m-Y')) && $saat > (date('Hi')+100)){
            echo '<button class="btn btn-xs btn-danger" onclick="FuncSinavIptal('.$cow['SINAV_ID'].')">İptal</button>';
        }

		echo '</td>';
		echo '<td align="center">';
		if($cow['BILDIRIM_DURUMU'] == 1){
			if(strtotime($basdate) > strtotime(date('d-m-Y'))){
                echo '<a class="btn btn-xs btn-primary" href="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=aday_bildirim&sinav='.$cow['SINAV_ID'].'">Aday Bildir</a>';
            }else if(strtotime($basdate) == strtotime(date('d-m-Y')) && $saat > date('Hi')){
                echo '<a class="btn btn-xs btn-primary" href="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=aday_bildirim&sinav='.$cow['SINAV_ID'].'">Aday Bildir</a>';
            }
		}
		echo '</td>';
		echo '</tr>';
    }
    ?>
	</tbody>
</table>
<?php	
}?>
</div>
<div id="gecmisProgram" style="display:none" class="anaDiv">
<?php if(count($programsGecmis) > 0){
?>
<table style="width:98%;" border="0" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED" class="thPad5">
		<tr>
			<th width="4%">Sınav ID</th>
			<th width="30%">Yeterlilik</th>
            <th width="10%">Başlangıç Tarihi ve Saati</th>
			<th width="15%">Sınav İli</th>
			<th width="5%">Bildirilme Durumu</th>
			<th width="10%">Aday İşlemleri</th>
            <th width="15%">Sonuç Bildirimi</th>
            <th width="15%">Tekrar Belge İste</th>
		</tr>
	</thead>
	<tbody id="sınavTbody" class="tdPad5 fontBold">
	<?php 
	$even = 'bgcolor="#efefef"';
	$say = 1;
	foreach ($programsGecmis as $cow){
		if($cow['SONUC_DURUMU'] == 2){
		if($say%2 == 0){
		?>
		<tr id="<?php echo $cow['SINAV_ID'];?>" <?php echo $even;?>>
		<?php
		}
		else{
		?>
			<tr id="<?php echo $cow['SINAV_ID'];?>">
		<?php 
		}
		$say++;
	?>
		<td align="center"><?php echo $cow['SINAV_ID'];?></td>
		<td align="center"><?php 
			echo trim($cow['YETERLILIK_KODU']).'/'.$cow['REVIZYON'].' - '.$cow['YETERLILIK_ADI'];
		?>
		</td>
		<td align="center"><?php echo $cow['BASLANGIC_TARIHI'].' '.$cow['BASSAAT'];?></td>
		<td id="prIl" align="center"><?php echo $cow['SINAV_ILI'];?></td>
		<td id="bildirimDurum" align="center"><span style="color:green">Bildirildi</span></td>
		
		<td align="center"><a style="color:green" href="#" id="bildirilenExcel">Sonuclar Bildirildi</a></td>
		<td align="center"><a style="color:green" href="#" id="istenilenAday">Sonuç Gönderildi</a></td>
		<td align="center"><a href="#" id="sonucGonder">Tekrar Belge İste</a></td>
		</tr>
<?php }
	}	?>
	</tbody>
</table>
<?php	
}?>
</div>
<!-- Yapilmayan Programlar -->
<div id="yapilmayanProgram" style="display:none" class="anaDiv">
<?php if(count($programsYapilmayan) > 0){
?>
<table style="width:98%;" border="0" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED" class="thPad5">
		<tr>
			<th width="4%">Sınav ID</th>
			<th width="40%">Yeterlilik</th>
            <th width="10%">Başlangıç Tarihi ve Saati</th>
			<th width="20%">Sınav İli</th>
			<th width="15%">Sınav Durumu</th>
			<th width="10%">Bildirilme Durumu</th>
			<th width="5%">Aday İşlemleri</th>
		</tr>
	</thead>
	<tbody id="sınavTbody" class="tdPad5 fontBold">
	<?php 
	$even = 'bgcolor="#efefef"';
	$say = 1;
	foreach ($programsYapilmayan as $cow){ 
		if($say%2 == 0){
		?>
		<tr id="<?php echo $cow['SINAV_ID'];?>" <?php echo $even;?>>
		<?php
		}
		else{
		?>
			<tr id="<?php echo $cow['SINAV_ID'];?>">
		<?php 
		}
		$say++;
	?>
			<td align="center"><?php echo $cow['SINAV_ID'];?></td>
			<td align="center"><?php 
				echo trim($cow['YETERLILIK_KODU']).'/'.$cow['REVIZYON'].' - '.$cow['YETERLILIK_ADI'];
			?>
			</td>
			<td align="center"><?php echo $cow['BASLANGIC_TARIHI'].' '.$cow['BASSAAT'];?></td>
			<td id="prIl" align="center"><?php
                            echo $cow['SINAV_ILI'];
			?></td>
			<?php if($cow['GECERLILIK_DURUMU']==1){?>
				<td align="center"><p style="color:red;">Sınav Yapılmadı</p></td>	
			<?php }else{?>
				<td align="center"><p style="color:red;">İptal Edildi</p></td>
			<?php }?>
            
			<td id="bildirimDurum" align="center"><?php
			if($cow['BILDIRIM_DURUMU'] == 1){
				echo '<span style="color:green">Bildirildi</span>';
			}
			else{
                            echo '<span style="color:red">Bildirilmedi</span>';
                        }?></td>
			
           <td><p style="color:red;">Aday Bildirilmemiş</p></td>
		</tr>
<?php }	?>
	</tbody>
</table>
<?php	
}?>
</div>

<div id="sonucBildirilmemis" style="display:none" class="anaDiv">
<?php if(count($programsGecmis) > 0){
?>
<table style="width:98%;" border="0" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED" class="thPad5">
		<tr>
			<th width="4%">Sınav ID</th>
			<th width="40%">Yeterlilik</th>
            <th width="10%">Başlangıç Tarihi ve Saati</th>
			<th width="15%">Sınav İli</th>
			<th width="10%">Sınav Durumu</th>
			<th width="5%">Bildirilme Durumu</th>
			<th width="10%">Aday İşlemleri</th>
            <th width="15%">Sonuç Bildirimi</th>
		</tr>
	</thead>
	<tbody id="sınavTbody" class="tdPad5 fontBold">
	<?php 
	$even = 'bgcolor="#efefef"';
	$say = 1;
	foreach ($programsGecmis as $cow){
		if($cow['SONUC_DURUMU'] == 1){ 
		if($say%2 == 0){
		?>
		<tr id="<?php echo $cow['SINAV_ID'];?>" <?php echo $even;?>>
		<?php
		}
		else{
		?>
			<tr id="<?php echo $cow['SINAV_ID'];?>">
		<?php 
		}
		$say++;
	?>
			<td align="center"><?php echo $cow['SINAV_ID'];?></td>
			<td align="center"><?php 
				echo trim($cow['YETERLILIK_KODU']).'/'.$cow['REVIZYON'].' - '.$cow['YETERLILIK_ADI'];
			?>
			</td>
			<td align="center"><?php echo $cow['BASLANGIC_TARIHI'].' '.$cow['BASSAAT'];?></td>
			<td id="prIl" align="center"><?php
					echo $cow['SINAV_ILI'];
				?></td>
			<td align="center"></td>
			<td id="bildirimDurum" align="center">
			<?php echo '<span style="color:green">Bildirildi</span>'; ?></td>
			<td>
		<?php
		if($cow['SONUC_DURUMU'] == 1){
                    echo '<a href="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=sonuc_bildir&sinav='.$cow['SINAV_ID'].'">Sonuç Dosyası Yükle</a>';
                }    
			
		?></td>
                <td>
                    <?php 
                    if($cow['SONUC_DURUMU'] == 1){
                        echo '<a href="#" id="sonucGonder">Sonuç Bildirimini Tamamla</a>';
                    }
                    ?>
                    
                </td>
		</tr>
<?php }
	}	
?>
	</tbody>
</table>
<?php	
}?>
</div>

<div id="iptalProgram" style="display:none" class="anaDiv">
    <?php if(count($IptalProgram) > 0){
        ?>
        <table style="width:100%;" border="0" cellpadding="0" cellspacing="1">
            <thead style="background-color:#71CEED" class="thPad5">
            <tr>
                <th width="5%">Sınav ID</th>
                <th width="40%">Yeterlilik</th>
                <th width="10%">Başlangıç Tarihi ve Saati</th>
                <th width="20%">Sınav İli</th>
                <th width="5%">İptal</th>
                <th width="5%">İptal Eden</th>
            </tr>
            </thead>
            <tbody id="sınavTbody" class="tdPad5 fontBold">
            <?php
            $even = 'bgcolor="#efefef"';
            $say = 1;

            foreach ($IptalProgram as $cow){
                if($say%2 == 0){
                    echo '<tr id="'.$cow['SINAV_ID'].'" '.$even.'>';
                }
                else{
                    echo '<tr id="'.$cow['SINAV_ID'].'">';
                }
                $say++;

                echo '<td align="center">'.$cow['SINAV_ID'].'</td>';
                echo '<td align="center">'.trim($cow['YETERLILIK_KODU']).'/'.$cow['REVIZYON'].' - '.$cow['YETERLILIK_ADI'].'</td>';
                echo '<td align="center">'.$cow['BASLANGIC_TARIHI'].' '.$cow['BASSAAT'].'</td>';
                echo '<td id="prIl" align="center">'.$cow['SINAV_ILI'].'</td>';
                echo '<td align="center"><button type="button" class="btn btn-xs btn-info" onclick="FuncSinavIptalBilgi('.$cow['SINAV_ID'].')">Detay</button></td>';
                echo '<td align="center" class="text-danger">'.$cow['IPTAL_EDEN'].'</td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    <?php
    }?>
</div>

</div>

<script type="text/javascript">
var IptalFile = '<div class="anaDiv"><div class="div70"><input type="file" class="input-sm inputW90" name="IptalFile[]"/></div><div class="div30"><button type="button" class="btn btn-xs btn-danger IptalFileSil"><i class="fa fa-minus"></i> Sil</button></div></div>';
jQuery(document).ready(function(){
    var tab = <?php echo isset($_GET['program'])?$_GET['program']:1; ?>;
    if(tab == 1){
        jQuery('#Glprogram').css('background-color','#3C91FF');
        jQuery('#Glprogram').css('color','#FFFFFF');
        jQuery('#Glprogram1').css('background-color','#3C91FF');
        jQuery('#Glprogram1').css('color','#FFFFFF');
        jQuery('#gelecekProgram').show();
        jQuery('#programId').val(1);
    }
    else if(tab == 2){
        jQuery('#Gcprogram').css('background-color','#3C91FF');
		jQuery('#Gcprogram').css('color','#FFFFFF');
        jQuery('#gecmisProgram').show();
        jQuery('#programId').val(2);
    }
    else if(tab == 3){
        jQuery('#Ypprogram').css('background-color','#3C91FF');
		jQuery('#Ypprogram').css('color','#FFFFFF');
        jQuery('#yapilmayanProgram').show();
        jQuery('#programId').val(3);
    }
    else if(tab == 4){
    	jQuery('#Glprogram').css('background-color','#3C91FF');
        jQuery('#Glprogram').css('color','#FFFFFF');
        jQuery('#Glprogram4').css('background-color','#3C91FF');
        jQuery('#Glprogram4').css('color','#FFFFFF');
        jQuery('#sonucBildirilmemis').show();
        jQuery('#programId').val(4);
    }
    else if(tab == 5){
        jQuery('#IPprogram').css('background-color','#3C91FF');
        jQuery('#IPprogram').css('color','#FFFFFF');
        jQuery('#iptalProgram').show();
        jQuery('#programId').val(5);
    }
	

	
	jQuery('#sinavs').live('click',function(e){
		e.preventDefault();
		jQuery('#sinavs').children('i').removeClass('fa-plus');
		jQuery('#sinavs').children('i').addClass('fa-minus');
		jQuery('#yeniSinav').show('slow');
		jQuery(this).attr('id','sinavsHide');
	});

	jQuery('#sinavsHide').live('click',function(e){
		e.preventDefault();
		jQuery('#sinavsHide').children('i').removeClass('fa-minus');
		jQuery('#sinavsHide').children('i').addClass('fa-plus');
		jQuery('#yeniSinav').hide('slow');
		jQuery(this).attr('id','sinavs');
	});

	 jQuery('#bastar').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true
		     });
     });

    jQuery('#bassaat').live('hover',function(e){
        e.preventDefault();
        jQuery(this).timepicker({
            'timeFormat': 'H:i',
            'step': 15
        });
    });
          
    jQuery('#tartar').live('hover',function(e){
        e.preventDefault();
        jQuery(this).datepicker({
            changeYear: true,
            changeMonth: true
        });
    });
    jQuery('#sontar').live('hover',function(e){
        e.preventDefault();
        jQuery(this).datepicker({
            changeYear: true,
            changeMonth: true
        });
    });

	jQuery('#sinavKaydet').live('click',function(e){
		e.preventDefault();
		var now = new Date();
        var bassaat = jQuery('#bassaat').val();
        var spBassat = bassaat.split(':');
		var someDate = new Date(now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate(), now.getUTCHours()+48, now.getUTCMinutes(), 0);
		var secilenTarih = new Date(jQuery('#bastar').val().substr(6,4), jQuery('#bastar').val().substr(3,2)-1, jQuery('#bastar').val().substr(0,2),spBassat[0], spBassat[1], 0);
                
		if(jQuery('#yets').val() == ''){
			alert('Lütfen yeterlilik seçiniz.');
		}
		else if(jQuery('#bastar').val() == ''){
			alert('Lütfen başlangıç tarihi seçiniz.');
		}else if(bassaat == '' || bassaat.length != 5){
            alert('Lütfen başlangıç saatini seçiniz.');
        }else if(someDate > secilenTarih){
			//alert(someFormattedDate);
			//alert(jQuery('#bastar').val().replace('.','/').replace('.','/'));
			alert('Lütfen başlangıç tarihini bugünden en az 2 gün sonrasını seçiniz.');
		}else if(!jQuery('input#adayFile')[0].files[0]){
            alert('Lütfen Aday Dosyasını Boş Bırakmayınız.');
        }/*else if(!jQuery('input#adayFile')[0].files[0].type != 'application/vnd.ms-excel'){
            alert('Lütfen İndirdiğini Aday Dosyasını Doldurarak Sisteme Yükleyiniz.');
        }*/else if(jQuery('#il').val() == ''){
			alert('Lütfen sınav ili seçiniz.');
		}
		else{
			jQuery.ajax({
				async:false,
				type:'POST',
				url:"index.php?option=com_belgelendirme&task=ajaxYetRevizyonVarMi&format=raw",
				data:'yetId='+jQuery('#yets').val()
			}).done(function(data){
				var dat = jQuery.parseJSON(data);
				if(dat){
					if(confirm('Seçmiş oldğunuz yeterliliğin revizyonları bulunmaktadır. Doğru yeterliliği seçtiğinizden emin misiniz?')){
                        OpenLightBox('#loaderGif');
						jQuery('#programKaydetmeFormu').submit();
					}else{
						return false;
					}
				}else{
                    OpenLightBox('#loaderGif');
					jQuery('#programKaydetmeFormu').submit();
				}
			});
		}
	});

	jQuery('#bildir').live('click',function(e){
		e.preventDefault();
		var iid = jQuery(this).parent('td').parent('tr').attr('id');
		jQuery.ajax({
			type:'post',
			data:'id='+iid,
			url:'index.php?option=com_belgelendirme&task=program_bildir&format=raw',
			success:function(data){
				alert('Bildirim başarılı.');
				window.location.reload();
			}
		});
	});

	jQuery('#ilKaydet').live('click',function(e){
		e.preventDefault();
		var iid = jQuery(this).parent('td').parent('tr').attr('id');
		var ilId = jQuery(this).closest('td#prIl').children('#il').val();
		jQuery.ajax({
			type:'post',
			data:'id='+iid+'&ilId='+ilId,
			url:'index.php?option=com_belgelendirme&task=program_ilKaydet&format=raw',
			success:function(data){
				alert('İl kaydı başarılı.');
			}
		});
	});

	jQuery('#sil').live('click',function(e){
		if(confirm('Silme istediğinizden emin misiniz?')){
		e.preventDefault();
		var iid = jQuery(this).parent('td').parent('tr').attr('id');
		jQuery.ajax({
            async:false,
			type:'post',
			data:'id='+iid+'&adaySil=1',
			url:'index.php?option=com_belgelendirme&task=program_Sil&format=raw',
			success:function(data){
				var dat = jQuery.parseJSON(data);
				if(dat == true){
					alert('Başarıyla silindi.');
					window.location.reload();
				}
				else{
					alert('Bu sınavı silme yetkiniz yoktur.');
				}
			}
		});}
		else {return false}
	});

	jQuery('#Adaylasil').live('click',function(e){
		e.preventDefault();
		if(confirm('Bu sınava aday bilgileri girilmiştir.Silerseniz bu sınava ait adaylarda silinecektir. Emin misiniz?')){
				if(confirm('Bu işlemin geri dönüşü yoktur. Emin misiniz?')){
				var iid = jQuery(this).parent('td').parent('tr').attr('id');
				jQuery.ajax({
                    async:false,
					type:'post',
					data:'id='+iid+'&adaySil=1',
					url:'index.php?option=com_belgelendirme&task=program_Sil&format=raw',
					success:function(data){
						var dat = jQuery.parseJSON(data);
						if(dat == true){
							alert('Başarıyla silindi.');
							window.location.reload();
						}
						else{
							alert('Bu sınavı silme yetkiniz yoktur.');
						}
					}
				});
				}else {return false}
			}
			else {return false}
	});
        jQuery('#sonucGonder').live('click',function(e){
            e.preventDefault();
            var sinavId = jQuery(this).closest('tr').attr('id');
                jQuery.ajax({
                   type: 'POST',
                   url:'index.php?option=com_belgelendirme&task=sonucGonderYetkilimi&format=raw',//false dönerse cık, true dönerse başarılı işleme devam
                   data:'sinavId='+sinavId,
                   success: function (data) {
                       var dat = jQuery.parseJSON(data);
                       if(dat == true){
							window.location.href="index.php?option=com_belgelendirme&view=sonuc_bildirim&layout=aday_bildirim&sinavId="+sinavId;
                       }
                       else{
                           alert('Sonuçlarını bildirmediğiniz adaylar var. Lütfen kontrol ettikten sonra tekrar deneyiniz.');
                       }
                    }
                });
        });

        jQuery('#adayGonderIptal').live('click',function(e){
    		e.preventDefault();
    		jQuery('#basariliAdaylar').html('');
    		jQuery('#basarisizAdaylar').html('');
    		jQuery('#adaySecGonderSinav').val('');
    		jQuery('#adaySecGonder').trigger('close');
    	});

    	jQuery('#adayGonderKaydet').live('click',function(e){
        	e.preventDefault();
        	if(confirm('Aday Sonuçlarını Göndermek istediğinizden emin misiniz? Gönderdikten sonra sonuç sayfasında işlem yapamazsınız.')){
	        	var hata = 0;
	        	jQuery.each(jQuery(':checkbox[name="basarisiz[]"]'),function(key,vall){
	            	if(vall.checked == true){
	            		if(jQuery('textarea[name="aciklama['+vall.value+']"]').val().length == 0 || jQuery('textarea[name="aciklama['+vall.value+']"]').val() == ''){
	                        hata++;
	                   	}
	                }
	            });
	
	            if(hata>0){
	            	alert('Lütfen Belge Almaya Hak Kazanamayan Adaylar kısmında seçmiş olduğunuz adaylar için Belge Verebilmek için Açıklama kısımlarını doldurunuz.');
	            }else{
	            	jQuery.each(jQuery(':checkbox[name="basarisiz[]"]'),function(key,vall){
	            		if(vall.checked == false){
	                    	jQuery('textarea[name="aciklama['+vall.value+']"]').remove();
	                    }
	                });
	            	jQuery('#belgeAdayBildirimKaydet').submit();
	            }
        	}
//         	jQuery('#belgeAdayBildirimKaydet').submit();
        });

        jQuery('#bildirilenExcel').live('click',function(e){
            e.preventDefault();
            jQuery('#excelss').html('');
            jQuery('#SonucYets').html('');
            var sinavId = jQuery(this).closest('tr').attr('id');
            var yets = jQuery(this).closest('tr').children('td').eq(0).html();
            jQuery.ajax({
                type:"POST",
                url:"index.php?option=com_belgelendirme&task=geriAdayExcelKont&format=raw",
                data:"sinavId="+sinavId,
                success:function(data){
                    var dat = jQuery.parseJSON(data);
                    var ekle = '';
                    jQuery.each(dat['sonuc'],function(key,vall){
                        var exurl = "index.php?dl=sinav_bildirimleri/"+vall['paket_Adi'];
                        ekle +='<tr><td>'+vall['adayCount']+'</td>'
                        +'<td><a href="'+exurl+'">Dosya İndir</a></td></tr>'; 
                    });
                    jQuery('#excelss').append(ekle);
                    jQuery('#SonucYets').html(yets);
                    jQuery('#SonucExcel').lightbox_me({
                  	  centered: true
                    });
                }
            });
        });



        jQuery('#istenilenAday').live('click',function(e){
            e.preventDefault();
            var sinavId = jQuery(this).closest('tr').attr('id');

            jQuery.ajax({
                type: 'POST',
                url: "index.php?option=com_belgelendirme&task=sonucTaAdaylar&format=raw",
                data:'sinavId='+sinavId,
                success: function (data){
                    var dat = jQuery.parseJSON(data);
                    var basarili = dat[0];
                    var basarisiz = dat[1];
                    var birim = dat[2];
                    var belgeNo = dat[3];

                    var basariliEkle = "";
                    var sayBas = 0;
                    jQuery.each(basarili,function(key,vall){
                        sayBas++;
                        
                        if(sayBas%2==0){
                            var bgcolor="#efefef";
                        }else{
                        	var bgcolor="#FFFFFF";
                        }
                        var birimler = '';
                        basariliEkle += '<tr bgcolor="'+bgcolor+'">';
                        basariliEkle += '<td rowspan="2">'+sayBas+'</td>';
                        basariliEkle += '<td>'+vall['TC_KIMLIK']+' - '+vall['ADI']+' '+vall['SOYADI']+'</td>';
                        basariliEkle += '<td rowspan="2">'+belgeNo[vall['TC_KIMLIK']]+'</td></tr>';
                        basariliEkle += '<tr bgcolor="'+bgcolor+'"><td>';
                        jQuery.each(birim[vall['TC_KIMLIK']],function(keyy,birims){
                      	  basariliEkle += birims['BIRIM_KODU']+',';
//                       	  birimler += '<input type="hidden" name="birimId['+key+'][]" value="'+birims[0]+'"/>';
//                       	  birimler += '<input type="hidden" name="tarih['+key+'][]" value="'+birims[1]+'"/>';
                        });
                        basariliEkle += birimler + '</td></tr>';
                        
                    });

                    if(basariliEkle.length == 0 || basariliEkle == ''){
						jQuery('#istekDiv').hide();
					}else{
						jQuery('#istekAdaylar').html(basariliEkle);
						jQuery('#istekDiv').show();
					}
                    

                    var basarisizEkle = "";
                    var sayBassiz = 0;
                    jQuery.each(basarisiz,function(key,vall){
                    	sayBassiz++;
                    	if(sayBassiz%2==0){
                            var bgcolor="#efefef";
                        }else{
                        	var bgcolor="#FFFFFF";
                        }
                        var birimler = '';
                        basarisizEkle += '<tr bgcolor="'+bgcolor+'">';
                        basariliEkle += '<td rowspan="2">'+sayBassiz+'</td>';
                        basarisizEkle += '<td>'+vall['ADI']+' '+vall['SOYADI']+'</td>';
                        basarisizEkle += '<td>';
                        jQuery.each(birim[vall['TC_KIMLIK']],function(keyy,birims){
                      	  basarisizEkle += birims['BIRIM_KODU']+',';
//                       	  birimler += '<input type="hidden" name="birimId['+key+'][]" value="'+birims[0]+'"/>';
//                       	  birimler += '<input type="hidden" name="tarih['+key+'][]" value="'+birims[1]+'"/>';
                        });
                        basarisizEkle += birimler + '</td></tr>';
//                         basarisizEkle += '<tr bgcolor="'+bgcolor+'"><td rowspan="2"><textarea name="aciklama['+key+']"></textarea></td>';
//                         '</tr>';
                    });
					if(basarisizEkle.length == 0 || basarisizEkle == ''){
						jQuery('#istekYokDiv').hide();
					}else{
						jQuery('#isteksizAdaylar').html(basarisizEkle);
						jQuery('#istekYokDiv').show();
					}
                    
                    jQuery('#adayGonderilen').lightbox_me({
                  	  centered: true,
                        closeClick:false,
                        closeEsc:false  
                    });
                }
             });
        });

        jQuery('#adayGonderilenIptal').live('click',function(e){
            e.preventDefault();
            jQuery('#isteksizAdaylar').html('');
    		jQuery('#istekAdaylar').html('');
    		jQuery('#adayGonderilen').trigger('close');
        });

    jQuery('.IptalFileSil').live('click',function(e){
        e.preventDefault();
        jQuery(this).closest('.anaDiv').remove();
    });

    jQuery('#IptalFileEkle').live('click',function(e){
        e.preventDefault();
        jQuery('#iptalFiles').append(IptalFile);
    });

    jQuery('#SinavIptalKaydet').live('click',function(e){
        e.preventDefault();
        //30000000
        var IptalAciklama = jQuery('#SinavIptalFormu textarea[name="IptalAcik"]').val();
        var FileSize = 0;
        var FileHata = 0;
        jQuery('#SinavIptalFormu input[name="IptalFile[]"]').each(function(){
            var FileType = jQuery(this)[0].files[0].type;
            if(FileType != 'image/png' && FileType != 'image/jpeg' && FileType != "application/zip" && FileType != "application/x-zip"
                && FileType != "application/x-rar-compressed" && FileType != "application/pdf" && FileType != "application/x-7z-compressed"){
                alert('Lütfen .png, .jpeg, .pdf, .zip, .rar uzantılı dosyalar ekleyiniz.');
                FileHata++;
                return false;
            }
            FileSize += jQuery(this)[0].files[0].size;
        });

        if(FileHata > 0){
            return false;
        }else if(FileSize > 30000000){
            alert("Sınav İptali İçin Eklenen Dosyaların Boyutları 30 MB'tı Geçmemelidir. Lütfen Kontrol Ediniz.");
            return false;
        }else if(IptalAciklama == '' || IptalAciklama.length == 0){
            alert('Lütfen Sınav İptali İçin Açıklama Giriniz.');
            return false;
        }else{
            jQuery('#SinavIptalFormu').submit();
        }
    });
});

function FuncSinavIli(sId){
    jQuery.ajax({
        async:false,
        type: 'POST',
        url: "index.php?option=com_belgelendirme&task=AjaxGetSinavIli&format=raw",
        data:'sId='+sId
    }).done(function(data){
        var dat = jQuery.parseJSON(data);
        if(dat['hata']){
            jQuery('#UyariLoader #UyariContent').html('Bir hata meydana geldi. Lütfen tekrar deneyin.');
            OpenLightBox('#UyariLoader');
        }else{
            jQuery('#SinavIliDiv input[name="SinavIlisId"]').val(dat['sId']);
            jQuery('#SinavIliDiv input[name="SinavIli"]').val(dat['sIl']);
            OpenLightBox('#SinavIliDiv');
        }
    });
}

function FuncSinavIliKaydet(){
    var sId = jQuery('#SinavIliDiv input[name="SinavIlisId"]').val();
    var sIl = jQuery('#SinavIliDiv input[name="SinavIli"]').val();
    if(sIl == '' || sIl.length == 0){
        alert('Lütfen Sınav İli giriniz.');
    }else{
        jQuery.ajax({
            async:false,
            type: 'POST',
            url: "index.php?option=com_belgelendirme&task=AjaxSinavIliKaydet&format=raw",
            data:'sId='+sId+'&sIl='+sIl
        }).done(function(data){
            var dat = jQuery.parseJSON(data);
            if(dat){
                alert('Sınav ili başarıyla kaydedildi.');
            }else{
                alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
            }
            window.location.reload();
        });
    }
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

function FuncSinavIptal(sId){
    jQuery('#SinavIptalFormu textarea[name="IptalAcik"]').val('');
    jQuery('#SinavIptalFormu #iptalFiles').html('');
    jQuery('#SinavIptalFormu input[name="sId"]').val(sId);
    OpenLightBox('#SinavIptalDiv');
}

function FuncSinavIptalBilgi(sId){
    jQuery('#SinavIptalBilgi #IptalAcik').val('');
    jQuery('#SinavIptalBilgi #KayitliIptalFile').html('');
    jQuery('#SinavIptalBilgi #ipUser').html('');
    jQuery.ajax({
        async: false,
        type:'POST',
        url:'index.php?option=com_belgelendirme&task=AjaxSinavIptalBilgi&format=raw',
        data:'sId='+sId
    }).done(function(data){
        var dat = jQuery.parseJSON(data);
        if(dat){
            var ipDat = dat['data'];
            var ipFile = dat['dataFile'];
            jQuery('#SinavIptalBilgi #IptalAcik').html(ipDat['IPTAL_ACIKLAMA']);
            jQuery('#SinavIptalBilgi #ipUser').html(dat['IptalUser']);

            jQuery(ipFile).each(function(key,vall){
                var fileLink = "index.php?dl=SinavIptal/"+sId+"/"+vall['DOKUMAN'];
                var ekle = '<div class="anaDiv" id="ipFile_'+vall['ID']+'"><a target="_blank" class="btn btn-xs btn-info" href="'+fileLink+'">'+vall['DOKUMAN']+'</a></div>';
                jQuery('#SinavIptalBilgi #KayitliIptalFile').append(ekle);
            });

            OpenLightBox('#SinavIptalBilgi');
        }else{
            alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
        }
    });
}
</script>
<!-- Uyari Loader -->
<div id="UyariLoader" style=" width: 50%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <div class="anaDiv font20 fontBold hColor text-center">
        <i class="fa fa-exclamation-circle"></i> Uyarı <i class="fa fa-exclamation-circle"></i>
    </div>
    <div class="anaDiv font16 text-warning fontBold text-center" id="UyariContent">

    </div>
    <div class="anaDiv">
        <button type="button" class="btn btn-sm btn-danger" onclick="jQuery('#UyariLoader').trigger('close');">İptal</button>
    </div>
</div>

<!-- Sinav İli Düzenle Loader -->
<div id="SinavIliDiv" style=" width: 50%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <div class="anaDiv font20 fontBold hColor text-center">
        Sınav İli Düzenleme
    </div>
    <div class="anaDiv">
        <div class="div30 font16 hColor fontBold">
            Sınav İli:
        </div>
        <div class="div70">
            <input type="text" name="SinavIli" class="input-sm inputW90" value=""/>
            <input type="hidden" name="SinavIlisId" value="0"/>
        </div>
    </div>
    <div class="anaDiv">
        <div class="div50">
            <button type="button" class="btn btn-sm btn-danger" onclick="jQuery('#SinavIliDiv').trigger('close');">İptal</button>
        </div>
        <div class="div50 text-right">
            <button type="button" class="btn btn-sm btn-success" onclick="FuncSinavIliKaydet()">Kaydet</button>
        </div>
    </div>
</div>

<!-- Sinav İptal -->
<div id="SinavIptalDiv" style=" width: 50%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form method="POST" id="SinavIptalFormu" action="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=belgelendirme_program&task=program_iptal" enctype="multipart/form-data">
        <div class="anaDiv font20 fontBold hColor text-center">
            Sınav İptali
        </div>
        <div class="anaDiv" style="display: inline-flex">
            <div class="div30 fontBold font16 hColor">
                Açıklama:
            </div>
            <div class="div70">
                <textarea class="inputW90" name="IptalAcik"></textarea>
            </div>
        </div>
        <div class="anaDiv" style="display: inline-flex">
            <div class="div30 fontBold font16 hColor">
                İptal Ekleri:
            </div>
            <div class="div70" id="iptalFiles">

            </div>
        </div>
        <div class="anaDiv">
            <button type="button" class="btn btn-sm btn-primary" id="IptalFileEkle"><i class="fa fa-plus"></i> Dosya Ekle</button>
        </div>
        <div class="anaDiv">
            <div class="div50">
                <button type="button" class="btn btn-sm btn-danger" onclick="jQuery('#SinavIptalDiv').trigger('close');">İptal</button>
            </div>
            <div class="div50 text-right">
                <button type="button" class="btn btn-sm btn-success" id="SinavIptalKaydet">Kaydet</button>
            </div>
        </div>
        <input type="hidden" name="sId" value="0"/>
    </form>
</div>

<!-- Sinav İptal Bilgi -->
<div id="SinavIptalBilgi" style=" width: 50%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
        <div class="anaDiv font20 fontBold hColor text-center">
            Sınav İptali
        </div>
        <div class="anaDiv">
            <div class="div30 fontBold font16 hColor">
                İptal Eden Kişi:
            </div>
            <div class="div70 fontBold font16" id="ipUser">

            </div>
        </div>
        <div class="anaDiv" style="display: inline-flex">
            <div class="div30 fontBold font16 hColor">
                Açıklama:
            </div>
            <div class="div70 fontBold font16" id="IptalAcik">

            </div>
        </div>
        <div class="anaDiv" style="display: inline-flex">
            <div class="div30 fontBold font16 hColor">
                İptal Ekleri:
            </div>
            <div class="div70" id="KayitliIptalFile">

            </div>
        </div>
        <div class="anaDiv">
            <div class="div50">
                <button type="button" class="btn btn-sm btn-danger" onclick="jQuery('#SinavIptalBilgi').trigger('close');">İptal</button>
            </div>
        </div>
</div>

<div id="adaySecGonder" style="width: 90%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <form id="belgeAdayBildirimKaydet" name="belgeAdayBildirimKaydet"
	action="index.php?option=com_belgelendirme&task=belgeAdaySonucGonder&layout=belgelendirme_program" enctype="multipart/form-data" method="post">
	<div id="basAdayDiv">
    	<h2>Belge Almaya Hak Kazanan Adaylar</h2>
    	<table style="width:100%; text-align:center" border="1">
    		<thead style="background-color:#71CEED">
    		<tr>
    		<th>#</th>
    		<th>Aday Bilgisi</th>
    		</tr>
    		</thead>
    		<tbody id="basariliAdaylar">
    		</tbody>
    	</table>
    	</br>
    	<hr>
    	</div>
    	</br>
    	<div id="bassizAdayDiv">
    	<h2>Belge Almaya Hak Kazanamayan Adaylar</h2>
    	<table style="width:100%; text-align:center" border="1">
    		<thead style="background-color:#71CEED">
    		<tr>
    		<th>#</th>
    		<th>Aday Bilgisi</th>
    		<th>Belge Verebilmek için Açıklama</th>
    		</tr>
    		</thead>
    		<tbody id="basarisizAdaylar">
    		</tbody>
    	</table>
    	</div>
    	<input type="hidden" name="sinav" value="" id="adaySecGonderSinav"/>
    	<input type="button" value="İptal" id="adayGonderIptal"/>
    	<input type="button" value="Gönder" id="adayGonderKaydet"/>
    </form>
</div>

<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <img src="media/system/images/ajax-loader.gif">
</div>


<div id="SonucExcel" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<h2 id="SonucYets"></h2>
    <table style="width:100%; text-align:center" border="1">
    		<thead style="background-color:#71CEED">
    		<tr>
    		<th>Aday Sayısı</th>
    		<th>Belge</th>
    		</tr>
    		</thead>
    		<tbody id="excelss">
    		</tbody>
    	</table>
</div>

<div id="adayGonderilen" style="width: 90%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    	<div id="istekDiv">
    	<h2>Belge İsteğinde Bulunulan Adaylar</h2>
    	<table style="width:100%; text-align:center" border="1">
    		<thead style="background-color:#71CEED">
    		<tr>
    		<th>#</th>
    		<th>Aday Bilgisi</th>
    		<th>Belge No:</th>
    		</tr>
    		</thead>
    		<tbody id="istekAdaylar">
    		</tbody>
    	</table>
    	</br>
    	<hr>
    	</div>
    	</br>
    	<div id="istekYokDiv">
	    	<h2>Belge İsteğinde Bulunulmayan Adaylar</h2>
	    	<table style="width:100%; text-align:center" border="1">
	    		<thead style="background-color:#71CEED">
	    		<tr>
	    		<th>Aday Bilgisi</th>
	    		<th>Başarılı Olduğu Birimler</th>
	    		</tr>
	    		</thead>
	    		<tbody id="isteksizAdaylar">
	    		</tbody>
	    	</table>
    	</div>    	
    	<input type="button" value="İptal" id="adayGonderilenIptal" style="float:right"/>
</div>
