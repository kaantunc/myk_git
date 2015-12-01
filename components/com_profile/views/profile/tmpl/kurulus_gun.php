<?php
$kurulus = $this->kurulus_bilgi;
$kurulus_bekleyen = $this->kurulus_bekleyen;
$kurulus_edit = $this->kurulus_edit;

$iller	 = $this->iller;

echo '<h2 style="margin-bottom:10px;"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';
echo '<h3 style="margin-bottom:10px;">Bilgileri buradan güncelleyebilirsiniz.</h3>';
?>
<!-- Güncellenecek bilgiler -->
<div>
<form action="index.php?option=com_profile&task=ProfileEdit"
      enctype="multipart/form-data" method="post"
      id="kurulus_edit_form"
      name="kurulus_edit_form">

<!-- 	<div class="form_item"> -->
<!-- 	  <div class="form_element cf_heading"> -->
<!-- 	  	<h1 class="contentheading">KURULUŞ BİLGİLERİ</h1> -->
<!-- 	  </div> -->
<!-- 	  <div class="cfclear">&nbsp;</div> -->
<!-- 	</div> -->
<?php
if(isset($kurulus_bekleyen['EDIT_ID']) && $kurulus_bekleyen['ONAY_BEKLEYEN'] == 1 && $kurulus_bekleyen['AKTIF'] == 0){
    ?>
    <input type="hidden" name="edit_id" value="<?php echo $kurulus_bekleyen['EDIT_ID'];?>"/>
<?php
}
?>
<div class="form_item">
    <div class="form_element cf_heading">
        <?php if($this->bekleyen){
            echo '<h3 class="contentheading">İletişim Bilgileri (Onay Bekleniyor)</h3>';
        }else{
            echo '<h3 class="contentheading">İletişim Bilgileri (Güncel Bilgiler)</h3>';
        }?>

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Adı</label>
        <input class="cf_inputbox required" maxlength="150" size="30"  id="text_1" name="ad_edit" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_ADI"];?>" />

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Kısa Adı</label>
        <input class="cf_inputbox required" maxlength="150" size="30"  id="text_25" name="kisa_ad_edit" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_KISA_ADI"];?>" />

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Vergi Kimlik Numarası</label>
        <input class="cf_inputbox" maxlength="150" size="30"  id="text_5" name="vergino_edit" type="text" value="<?php echo $kurulus_bekleyen["VERGI_KIMLIK_NO"];?>" />

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Yetkilisi</label>
        <input class="cf_inputbox" maxlength="150" size="30"  id="text_4" name="yetkili_edit" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_YETKILISI"];?>" />

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Yetkili Unvanı</label>
        <input class="cf_inputbox" maxlength="150" size="30"  id="text_5" name="unvan_edit" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_YETKILI_UNVANI"];?>" />

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
        <textarea class="cf_inputbox" rows="3" id="text_3" title="" cols="30" name="adres_edit" ><?php echo $kurulus_bekleyen["KURULUS_ADRESI"];?></textarea>

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Posta Kodu</label>
        <input class="cf_inputbox numeric" maxlength="150" size="30"  id="text_7" name="posta_kodu_edit" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_POSTA_KODU"];?>" />

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_placeholder"><?php
        $data = $this->pm_il;
        ?>
        <label class="cf_label" style="width:150px;">Şehir</label>
        <select id="sehir" class="cf_inputbox" name="sehir_edit" title="" size="1" >
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
        <input id="irtibatTelFax" class="cf_inputbox numeric" maxlength="150" size="30"  id="text_9" name="telefon_edit" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_TELEFON"];?>" />

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Faks</label>
        <input id="irtibatTelFax" class="cf_inputbox numeric" maxlength="150" size="30"  id="text_10" name="faks_edit" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_FAKS"];?>" />

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">E-Posta</label>
        <input class="cf_inputbox e-mail" maxlength="150" size="30"  id="text_11" name="eposta_edit" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_EPOSTA"];?>" />

    </div>
    <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Web</label>
        <input class="cf_inputbox url" maxlength="150" size="30"  id="text_12" name="web_edit" type="text" value="<?php echo $kurulus_bekleyen["KURULUS_WEB"];?>" />

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
        <select id="list" name="iller_edit[]" size="10" title="" style='width:150px;'  multiple >
            <?php
            if(isset($data)){
                foreach ($data as $row){
                    if (isset ($this->editIller)){
                        $selected = '';
                        for ($i = 0; $i < count($this->editIller); $i++){
                            if ($this->editIller[$i] == $row["IL_ID"]){
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
        <select id="statu" class="cf_inputbox" name="statu_edit" title="" size="1" >
            <option value="Seçiniz">Seçiniz</option>
            <?php
            if(isset($data)){
                foreach ($data as $row){
                    if ($kurulus_bekleyen["KURULUS_STATU_ID"] == $row["KURULUS_STATU_ID"]){
                        $selected = 'selected="selected"';
                    }
                    else{
                        $selected = '';
                    }

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
            <div style="float:left;">
                <img id="previewLogo" src="#" alt="Yüklenen resim" style="padding:5px 5px 5px 0; display:none;"/><br/>
                <input type="hidden" id="crop_x" name="crop_x" />
                <input type="hidden" id="crop_y" name="crop_y" />
                <input type="hidden" id="crop_w" name="crop_w" />
                <input type="hidden" id="crop_h" name="crop_h" />
                <input class="cf_inputbox required uppercase" maxlength="150" size="30" title="" id="text_13logo" name="logo" type="file"/>
                <input type="hidden" name="yenilogo" id="yenilogo" value="1"/>
            </div>
        </div>
        <div class="cfclear">&nbsp;</div>
    </div>
<?php }
else{?>
<div class="form_item">
    <div class="form_element cf_textbox">
        <label class="cf_label" style="width: 150px;">Kuruluş Logo<sup>(1)</sup></label>
        <div style="float:left;">
            <img id="previewLogo" src="index.php?dl=kurulus_logo/<?php echo $kurulus_bekleyen["USER_ID"].'/'.$kurulus_bekleyen["LOGO"];?>" alt="Yüklenen resim" style="padding:5px 5px 5px 0; display:none;"/><br/>
            <input type="hidden" id="crop_x" name="crop_x" />
            <input type="hidden" id="crop_y" name="crop_y" />
            <input type="hidden" id="crop_w" name="crop_w" />
            <input type="hidden" id="crop_h" name="crop_h" />
            <em id="previewLogoText" style="color: red; font-size:10px; display:none;">Fotograf üzerinde seçim yaparak ilgili alanı logo olarak kaydedebilirsiniz !</em>
            <div>
                <div id="logoGun" style="display:none;float: left;">
                    <input class="cf_inputbox uppercase" maxlength="150" size="30" title="" id="text_13logo" name="logo" type="file" value="<?php echo $kurulus_bekleyen["LOGO"];?>"/>
                    <br><br>
                    <input type="button" id="logoIptal" value="İptal"/>
                </div>
                <div id="logoDeg" style="float: left;">
                    <input type="button" id="logoShow" value="Logo Görüntüle" style="margin-right:10px;"/>
                    <input type="button" id="logoNew" value="Logo Değiştir"/>
                    <input type="hidden" name="yenilogo" id="yenilogo" value="0"/>
                </div>
            </div>
            <div class="cfclear">&nbsp;</div>
        </div>
        <?php }?>

        <div class="cfclear">&nbsp;</div><br>
        <div class="form_item" style="float:left">
            <div class="form_element cf_button">
                <input value="Güncelle" name="kaydet" type="submit" />
            </div>
            <div class="cfclear">&nbsp;</div>
        </div>

        <?php
        if($this->canEdit && $kurulus_bekleyen['ONAY_BEKLEYEN'] == 1 && $kurulus_bekleyen['AKTIF'] == 0){
            ?>
            <br>
            <br>
            <br>
            <hr>
            <br>
            <div class="form_item" style="float:left">
                <div class="form_element cf_button">
                    <input value="Kuruluşun Bilgilerini Onayla" onclick="kurBilgiOnayla(<?php echo $kurulus_bekleyen['EDIT_ID'];?>)" type="button" />
                </div>
                <div class="cfclear">&nbsp;</div>
            </div>
        <?php
        }
        ?>

</form>
</div>
<!-- Güncellenecek bilgiler -->
<br/>
<?php echo $this->geriLink;?>
<script type="text/javascript">
    jQuery(document).ready(function (){
        var currentLogo = jQuery('#previewLogo').attr("src");
        var jcrop_api;
        jQuery("#irtibatTelFax").live("focus",function (){
            jQuery(this).mask("9999999999");
        });

        jQuery('#logoNew').live('click',function(e){
            e.preventDefault();
            jQuery('#logoDeg').hide();
            jQuery('#previewLogo').hide("slow");
            jQuery('#previewLogoText').hide();
            jQuery('#logoGun').show();
            jQuery('#yenilogo').val(1);
        });

        jQuery('#logoIptal').live('click',function(e){
            window.location.reload;
            e.preventDefault();
            jQuery('#logoGun').hide();
            jQuery('#logoDeg').show();
            jQuery('#previewLogo').attr("src",currentLogo);
            jQuery('#yenilogo').val(0);
            jcrop_api.destroy();
            jQuery('#previewLogo').hide();
            jQuery('#previewLogoText').hide();
        });
        jQuery("input[name=logo]").change(function(){
            readURL(this);
        });
        jQuery("#logoShow").click(function(){
            jQuery('#previewLogo').toggle('slow', function() {
                if(jQuery(this).is(':hidden')) {
                    jQuery("#logoShow").val('Logo Görüntüle');
//     			  	jQuery('#previewLogoText').hide();
                }
                else {
                    jQuery("#logoShow").val('Logo Gizle');
//     				  jQuery('#previewLogoText').show();
                }
            });
        });

        var jcrop_api;
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var image  = new Image();
                reader.onload = function (e) {
                    jQuery('#previewLogo').attr('src', e.target.result);
                    image.src    = e.target.result;
                    image.onload = function() {
                        var width  = this.width,
                            height = this.height;
                        if(width > 500 || height > 500){
                            alert("Yüklenmeye çalışılan dosya 500px X 500px'den büyük olamaz !");
                            jQuery("#"+input.id).val('');
                        }else{
                            if(jcrop_api){
                                jcrop_api.destroy();
                            }
                            jQuery('#previewLogo').show('slow',function(){
                                jQuery('#previewLogo').Jcrop({
                                    onSelect: updateCoords
                                },function(){
                                    jcrop_api = this;
                                });
                                jQuery('#previewLogoText').show();
                            });
                        }
                    };
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function updateCoords(c)
        {
            jQuery('#crop_x').val(c.x);
            jQuery('#crop_y').val(c.y);
            jQuery('#crop_w').val(c.w);
            jQuery('#crop_h').val(c.h);
        };
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
    });

</script>