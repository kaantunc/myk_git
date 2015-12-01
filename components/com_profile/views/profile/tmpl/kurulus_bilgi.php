<?php
$kurulus = $this->kurulus_bilgi;
$kurulus_bekleyen = $this->kurulus_bekleyen;
$kurulus_edit = $this->kurulus_edit;

$iller	 = $this->iller;
?>
<div class="anaDiv text-center">
    <?php echo '<h2 class="font20 fontBold"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';?>
</div>
<?php echo $this->sayfaLink;?>
<div style="float:left">
<!-- 	<div class="form_item"> -->
<!-- 	  <div class="form_element cf_heading"> -->
<!-- 	  	<h1 class="contentheading">KURULUŞ BİLGİLERİ</h1> -->
<!-- 	  </div> -->
<!-- 	  <div class="cfclear">&nbsp;</div> -->
<!-- 	</div> -->

<div class="form_item">
    <div class="form_element cf_heading">
        <h3 class="contentheading">İletişim Bilgileri (Güncel Bilgiler)</h3>
    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Adı</label>
        <input class="cf_inputbox required" maxlength="150" size="30"  id="text_1" name="ad" type="text" value="<?php echo $kurulus["KURULUS_ADI"];?>" readonly="readonly"/>

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Kısa Adı</label>
        <input class="cf_inputbox required" maxlength="150" size="30"  id="text_25" name="kisa_ad_edit" type="text" value="<?php echo $kurulus["KURULUS_KISA_ADI"];?>" readonly="readonly"/>

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Vergi Kimlik No:</label>
        <input class="cf_inputbox required" maxlength="150" size="30"  id="text_25" name="kisa_ad_edit" type="text" value="<?php echo $kurulus["VERGI_KIMLIK_NO"];?>" readonly="readonly"/>

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Yetkilisi</label>
        <input class="cf_inputbox" maxlength="150" size="30"  id="text_4" name="yetkili" type="text" value="<?php echo $kurulus["KURULUS_YETKILISI"];?>" readonly="readonly"/>

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Yetkili Unvanı</label>
        <input class="cf_inputbox" maxlength="150" size="30"  id="text_5" name="unvan" type="text" value="<?php echo $kurulus["KURULUS_YETKILI_UNVANI"];?>" readonly="readonly"/>

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_heading">
        <h1 class="contentheading"></h1>
    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textarea">
        <label class="cf_label" style="width: 150px;">Adresi</label>
        <textarea class="cf_inputbox" rows="3" id="text_3" title="" cols="30" name="adres" readonly="readonly"><?php echo $kurulus["KURULUS_ADRESI"];?></textarea>

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Posta Kodu</label>
        <input class="cf_inputbox numeric" maxlength="150" size="30"  id="text_7" name="posta_kodu" type="text" value="<?php echo $kurulus["KURULUS_POSTA_KODU"];?>" readonly="readonly"/>

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_placeholder"><?php
        $data = $this->pm_il;
        ?>
        <label class="cf_label" style="width:150px;">Şehir</label>
        <select id="sehir" class="cf_inputbox" name="sehir" title="" size="1" disabled="disabled">
            <option value="Seçiniz">Seçiniz</option>
            <?php
            if(isset($data)){
                foreach ($data as $row){
                    if ($row["IL_ID"] != 0 && $kurulus["KURULUS_SEHIR"] == $row["IL_ID"])
                        $selected = 'selected="selected"';
                    else
                        $selected = '';

                    echo "<option ".$selected." value='".$row['IL_ID']."'>".$row['IL_ADI']."</option>";
                }
            }
            ?>
        </select></div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_heading">
        <h1 class="contentheading"></h1>
    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Telefon</label>
        <input id="irtibatTelFax" class="cf_inputbox numeric" maxlength="150" size="30"  id="text_9" name="telefon" type="text" value="<?php echo $kurulus["KURULUS_TELEFON"];?>" readonly="readonly"/>

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Faks</label>
        <input id="irtibatTelFax" class="cf_inputbox numeric" maxlength="150" size="30"  id="text_10" name="faks" type="text" value="<?php echo $kurulus["KURULUS_FAKS"];?>" readonly="readonly"/>

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">E-Posta</label>
        <input class="cf_inputbox e-mail" maxlength="150" size="30"  id="text_11" name="eposta" type="text" value="<?php echo $kurulus["KURULUS_EPOSTA"];?>" readonly="readonly"/>

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Web</label>
        <input class="cf_inputbox url" maxlength="150" size="30"  id="text_12" name="web" type="text" value="<?php echo $kurulus["KURULUS_WEB"];?>" readonly="readonly"/>

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_heading">
        <h1 class="contentheading"></h1>
    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_placeholder">
        <?php
        $data = $this->pm_il;
        ?>

        <label class="cf_label" style='width:150px;'>Varsa faaliyette bulunduğu diğer iller</label>
        <select id="list" name="iller[]" size="10" title="" style='width:150px;' disabled="disabled" multiple >
            <?php
            if(isset($data)){
                foreach ($data as $row){
                    if (isset ($iller)){
                        $selected = '';
                        for ($i = 0; $i < count($iller); $i++){
                            if ($iller[$i] == $row["IL_ID"]){
                                $selected = 'selected';
                                break;
                            }
                        }

                    }
                    echo "<option ".$selected." value='".$row['IL_ID']."'>".$row['IL_ADI']."</option>";
                }
            }
            ?>
        </select></div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_heading">
        <h3 class="contentheading">2.Kuruluşun Statüsü</h3>
    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_placeholder"><?php
        $data = $this->pm_kurulus_statu;
        ?>
        <label class="cf_label" style="width:150px;">Statüsü</label>
        <select id="statu" class="cf_inputbox" name="statu" title="" size="1" disabled="disabled">
            <option value="Seçiniz">Seçiniz</option>
            <?php
            if(isset($data)){
                foreach ($data as $row){
                    if ($kurulus["KURULUS_STATU_ID"] == $row["KURULUS_STATU_ID"])
                        $selected = 'selected="selected"';
                    else
                        $selected = '';

                    echo "<option ".$selected." value='".$row['KURULUS_STATU_ID']."'> ".$row['KURULUS_STATU_ADI']."</option>";
                }
            }
            ?>
        </select></div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_heading">
        <h1 class="contentheading"></h1>
    </div>
    <div class="cfclear">&nbsp;</div>
</div>
<?php if(empty($kurulus["LOGO"])){?>
    <div class="form_item">
        <div class="form_element cf_textbox">
            <label class="cf_label" style="width: 150px;">Kuruluş Logo<sup>(1)</sup></label>
            <!-- 	    <input class="cf_inputbox required uppercase" maxlength="150" size="30" title="" name="logo" type="file"/> -->
            <h3>Kuruluşun logosu bulunmamaktadır.</h3>
        </div>
        <div class="cfclear">&nbsp;</div>
    </div>
<?php }
else{?>
    <div class="form_item">
        <div class="form_element cf_textbox">
            <label class="cf_label" style="width: 150px;">Kuruluş Logo<sup>(1)</sup></label>
            <img id="previewLogo" src="index.php?dl=kurulus_logo/<?php echo $kurulus["USER_ID"].'/'.$kurulus["LOGO"];?>" alt="Yüklenen resim" style="padding:5px 5px 5px 0; display:none;"/><br/>
            <input type="button" id="logoShow" value="Logo Görüntüle" /></a>
        </div>
        <div class="cfclear">&nbsp;</div>
    </div>
<?php }?>


<br>
<br>
<br>
<hr>
<br>
<div style="float:left; margin-left:30px;" >
    <input type="button" value="Güncelle" id="guncelle" />
    <?php
    if($this->canEdit && $kurulus_bekleyen['ONAY_BEKLEYEN'] == 1 && $kurulus_bekleyen['AKTIF'] == 0){
        ?>
        <input value="Kuruluşun Bilgilerini Onayla" style="margin-left:50px;" onclick="kurBilgiOnayla(<?php echo $kurulus_bekleyen['EDIT_ID'];?>)" type="button" />
    <?php
    }
    ?>
</div>

</div>

<?php if($this->bekleyen){ ?>
    <div style="float:left">
    <!-- 	<div class="form_item"> -->
    <!-- 	  <div class="form_element cf_heading"> -->
    <!-- 	  	<h1 class="contentheading">KURULUŞ BİLGİLERİ</h1> -->
    <!-- 	  </div> -->
    <!-- 	  <div class="cfclear">&nbsp;</div> -->
    <!-- 	</div> -->

    <div class="form_item">
        <div class="form_element cf_heading">
            <h3 class="contentheading">İletişim Bilgileri (Onay Bekleniyor)</h3>
        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_textbox">
            <label class="cf_label" style="width: 150px;">Adı</label>
            <input class="cf_inputbox required" maxlength="150" size="30"  id="text_1" name="ad" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_ADI"];?>" readonly="readonly"/>

        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_textbox">
            <label class="cf_label" style="width: 150px;">Kısa Adı</label>
            <input class="cf_inputbox required" maxlength="150" size="30"  id="text_1" name="kisa_ad" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_KISA_ADI"];?>" readonly="readonly"/>

        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_textbox">
            <label class="cf_label" style="width: 150px;">Yetkilisi</label>
            <input class="cf_inputbox" maxlength="150" size="30"  id="text_4" name="yetkili" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_YETKILISI"];?>" readonly="readonly"/>

        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_textbox">
            <label class="cf_label" style="width: 150px;">Yetkili Unvanı</label>
            <input class="cf_inputbox" maxlength="150" size="30"  id="text_5" name="unvan" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_YETKILI_UNVANI"];?>" readonly="readonly"/>

        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_heading">
            <h1 class="contentheading"></h1>
        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_textarea">
            <label class="cf_label" style="width: 150px;">Adresi</label>
            <textarea class="cf_inputbox" rows="3" id="text_3" title="" cols="30" name="adres" readonly="readonly"><?php echo $kurulus_bekleyen["KURULUS_ADRESI"];?></textarea>

        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_textbox">
            <label class="cf_label" style="width: 150px;">Posta Kodu</label>
            <input class="cf_inputbox numeric" maxlength="150" size="30"  id="text_7" name="posta_kodu" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_POSTA_KODU"];?>" readonly="readonly"/>

        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_placeholder"><?php
            $data = $this->pm_il;
            ?>
            <label class="cf_label" style="width:150px;">Şehir</label>
            <select id="sehir" class="cf_inputbox" name="sehir" title="" size="1" disabled="disabled">
                <option value="Seçiniz">Seçiniz</option>
                <?php
                if(isset($data)){
                    foreach ($data as $row){
                        if ($row["IL_ID"] != 0 && $kurulus_bekleyen["KURULUS_SEHIR"] == $row["IL_ID"])
                            $selected = 'selected="selected"';
                        else
                            $selected = '';

                        echo "<option ".$selected." value='".$row['IL_ID']."'>".$row['IL_ADI']."</option>";
                    }
                }
                ?>
            </select></div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_heading">
            <h1 class="contentheading"></h1>
        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_textbox">
            <label class="cf_label" style="width: 150px;">Telefon</label>
            <input id="irtibatTelFax" class="cf_inputbox numeric" maxlength="150" size="30"  id="text_9" name="telefon" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_TELEFON"];?>" readonly="readonly"/>

        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_textbox">
            <label class="cf_label" style="width: 150px;">Faks</label>
            <input id="irtibatTelFax" class="cf_inputbox numeric" maxlength="150" size="30"  id="text_10" name="faks" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_FAKS"];?>" readonly="readonly"/>

        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_textbox">
            <label class="cf_label" style="width: 150px;">E-Posta</label>
            <input class="cf_inputbox e-mail" maxlength="150" size="30"  id="text_11" name="eposta" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_EPOSTA"];?>" readonly="readonly"/>

        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_textbox">
            <label class="cf_label" style="width: 150px;">Web</label>
            <input class="cf_inputbox url" maxlength="150" size="30"  id="text_12" name="web" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_WEB"];?>" readonly="readonly"/>

        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_heading">
            <h1 class="contentheading"></h1>
        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_placeholder">
            <?php
            $data = $this->pm_il;
            ?>

            <label class="cf_label" style='width:150px;'>Varsa faaliyette bulunduğu diğer iller</label>
            <select id="list" name="iller[]" size="10" title="" style='width:150px;' disabled="disabled" multiple >
                <?php
                if(isset($data)){
                    foreach ($data as $row){
                        if (isset ($iller)){
                            $selected = '';
                            for ($i = 0; $i < count($iller); $i++){
                                if ($iller[$i] == $row["IL_ID"]){
                                    $selected = 'selected';
                                    break;
                                }
                            }

                        }
                        echo "<option ".$selected." value='".$row['IL_ID']."'>".$row['IL_ADI']."</option>";
                    }
                }
                ?>
            </select></div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_heading">
            <h3 class="contentheading">2.Kuruluşun Statüsü</h3>
        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_placeholder"><?php
            $data = $this->pm_kurulus_statu;
            ?>
            <label class="cf_label" style="width:150px;">Statüsü</label>
            <select id="statu" class="cf_inputbox" name="statu" title="" size="1" disabled="disabled">
                <option value="Seçiniz">Seçiniz</option>
                <?php
                if(isset($data)){
                    foreach ($data as $row){
                        if ($kurulus_bekleyen["KURULUS_STATU_ID"] == $row["KURULUS_STATU_ID"])
                            $selected = 'selected="selected"';
                        else
                            $selected = '';

                        echo "<option ".$selected." value='".$row['KURULUS_STATU_ID']."'> ".$row['KURULUS_STATU_ADI']."</option>";
                    }
                }
                ?>
            </select></div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_heading">
            <h1 class="contentheading"></h1>
        </div>
        <div class="cfclear">&nbsp;</div>
    </div>
    <?php if(empty($kurulus_bekleyen["LOGO"])){?>
        <div class="form_item">
            <div class="form_element cf_textbox">
                <label class="cf_label" style="width: 150px;">Kuruluş Logo<sup>(1)</sup></label>
                <!-- 	    <input class="cf_inputbox required uppercase" maxlength="150" size="30" title="" name="logo" type="file"/> -->
                <h3>Kuruluşun logosu bulunmamaktadır.</h3>
            </div>
            <div class="cfclear">&nbsp;</div>
        </div>
    <?php }
    else{?>
        <div class="form_item">
            <div class="form_element cf_textbox">
                <label class="cf_label" style="width: 150px;">Kuruluş Logo<sup>(1)</sup></label>
                <img id="previewLogo" src="index.php?dl=kurulus_logo/<?php echo $kurulus_bekleyen["USER_ID"].'/'.$kurulus_bekleyen["LOGO"];?>" alt="Yüklenen resim" style="padding:5px 5px 5px 0; display:none; float:right;"/><br/>
                <br><input type="button" id="logoShow" value="Logo Görüntüle" /></a>
            </div>
            <div class="cfclear">&nbsp;</div>
        </div>
    <?php }?>

    </div>
<?php } ?>

<script>
    var nomenu = '<?php echo $_GET['nomenu'];?>';
    jQuery(document).ready(function(){
        if(nomenu == '1'){
            if (window.opener && !window.opener.closed) {
                window.opener.location.reload();
            }
            window.close();
        }

        jQuery("#logoShow").click(function(){
            jQuery('#previewLogo').toggle('slow', function() {
                if(jQuery(this).is(':hidden')) {
                    jQuery("#logoShow").val('Logo Görüntüle');
                    jQuery('#previewLogoText').hide();
                }
                else {
                    jQuery("#logoShow").val('Logo Gizle');
                    jQuery('#previewLogoText').show();
                }
            });
        });
    });

    function kurBilgiOnayla(editId){
        jQuery.ajax({
            async:false,
            type:'POST',
            url:"index.php?option=com_profile&task=ProfilOnayla&format=raw",
            data:'editId='+editId,
            success:function(data){
                var dat = jQuery.parseJSON(data);
                if(dat){
                    alert('Kuruluşun güncellediği bilgiler onaylanmıştır.');
                    window.location.reload();
                }else{
                    alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
                }
            }
        });
    }
    jQuery("#guncelle").click(function(){
        window.open('index.php?option=com_profile&view=profile&layout=kurulus_gun&kurulus=<?php echo $kurulus["USER_ID"];?>&nomenu=1',"myWindow", "width=800, height=400, scrollbars=1");
    });
</script>