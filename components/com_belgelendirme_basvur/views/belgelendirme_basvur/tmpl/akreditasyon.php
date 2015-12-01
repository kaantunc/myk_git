<?php
defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form_config.php');
require_once('libraries/form/form_parametrik.php');
require_once('libraries/form/formBelgelendirme.php');
require_once('libraries/form/captcha.php');
require_once("libraries/joomla/utilities/browser_detection.php");

$document = &JFactory::getDocument();
$document->addScript(SITE_URL . '/templates/elegance/js/paginate.min.js');
$document->addScript(SITE_URL . '/templates/elegance/js/tablesort.min.js');
$document->addScript(SITE_URL . '/templates/elegance/js/jscal2.js');
$document->addScript(SITE_URL . '/templates/elegance/js/lang/tr.js');
$document->addStyleSheet(SITE_URL . '/templates/elegance/css/jscal2.css');
$durum = $this->durum;
?>
<form
    onsubmit="return validate('ChronoContact_belgelendirme_basvuru_t3')"
    action="index.php?option=com_belgelendirme_basvur&amp;layout=akreditasyon&amp;task=belgelendirmeKaydet"
    enctype="multipart/form-data" method="post"
    id="ChronoContact_belgelendirme_basvuru_t3"
    name="ChronoContact_belgelendirme_basvuru_t3">

    <input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id ?>"/>

    <?php
    echo '<h2><u>' . $this->kurulus['KURULUS_ADI'] . ' Sınav ve Belgelendirme Başvuru Formu</u></h2>';
    echo $this->pageTree;
    ?>

    <div class="form_item">
        <div class="form_element cf_heading">
            <h3 class="contentheading">10. Kuruluş akreditasyon bilgileri[2]</h3>
        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <div class="form_item">
        <div class="form_element cf_placeholder">
            <div id="kAkreditasyonBilgi_panel_div" class="panel_main_div"></div>
        </div>
        <div class="cfclear">&nbsp;</div>
    </div>

    <?php if ($durum == 0 || $durum == 2 || $durum == 6 || $durum == 10 || $durum == 14) { ?>
        <div class="form_item" style="padding-top: 25px;">
            <div class="form_element cf_button">
                <input value="Kaydet" name="kaydet" type="submit"/>
            </div>
            <div class="cfclear">&nbsp;</div>
        </div>
    <?php } else if ($this->canEdit) {
        ?>
        <div class="form_item" style="padding-top: 25px;">
            <div class="form_element cf_button">
                <input value="Kaydet" name="kaydet" type="submit"/>
            </div>
            <div class="cfclear">&nbsp;</div>
        </div>
        <?php
    } ?>
    <br>
    <hr>
    <div class="form_item" style="padding-top: 25px; font-style:italic;">
        <p>[2]-Yetki talep edilen her bir yeterlilik için bu tablo doldurulacaktır.</p>

        <div class="cfclear">&nbsp;</div>
    </div>

</form>

<script type="text/javascript">
    dPanels.kAkreditasyonBilgi_panel = new Array("Kuruluş akreditasyon bilgileri",
        new Array("Yetki talep edilen ve akredite olunan ulusal yeterlilik ", "text"),
        new Array("Yeterlilik seviyesi/seviyeleri", "text"),
        new Array("Akreditasyon kuruluşu ve akreditasyon standardı", "text"),
        new Array("Akreditasyon başlangıç tarihi", "text", "date", "10", "date"),
        new Array("Akreditasyon bitiş tarihi", "text", "date", "10", "date"),
        new Array("Yetki talep edilen yeterlilikte gerçekleştirilen en son denetim tarihi", "text", "date", "10", "date"),
        new Array("Yetki talep edilen ulusal yeterliliğin akreditasyon kapsamına alındığı tarih", "text", "date", "10", "date"));

    function createPanels() {
        var panelName = "kAkreditasyonBilgi_panel";
        AddAkreditasyonValues(panelName, "Akreditasyon");
//	patchEkleForDatePick2(panelName, new Array('5', '6', '7', '8'));

        <?php
        $data = $this->akreditasyon;
        $panelCount = count($data);
        for ($i=0; $i< $panelCount; $i++) {
        if ($i>0){ $panelek=$i+1;} else {$panelek='';}
        echo "patchEkleForDatePick2(panelName+'".$panelek."', new Array('5', '6', '7', '8'));";
        }
        ?>
    }

    function AddAkreditasyonValues(panelName, buttonName) {
        var arry = new Array();
        <?php
        $data = $this->akreditasyon;
        $panelCount = count($data);

        echo 'var panelCount ='. $panelCount.';';

        $c = 0;
        for ($i=0; $i< $panelCount; $i++) {
            $arrAk = $data[$i];
            echo 'arry['.$c++.']= "'. $arrAk["AKREDITASYON_ID"] .'";';
            echo 'arry['.$c++.']= "'. FormFactory2::normalizeVariable ($arrAk["AKREDITASYON_ADI"] ).'";';
            echo 'arry['.$c++.']= "'. FormFactory2::normalizeVariable ($arrAk["AKREDITASYON_SEVIYE"]) .'";';
            echo 'arry['.$c++.']= "'. FormFactory2::normalizeVariable ($arrAk["AKREDITASYON_STANDARDI"]) .'";';
            echo 'arry['.$c++.']= "'. $arrAk["AKREDITASYON_BASLANGIC"] .'";';
            echo 'arry['.$c++.']= "'. $arrAk["AKREDITASYON_BITIS"] .'";';
            echo 'arry['.$c++.']= "'. $arrAk["AKREDITASYON_DENETIM"] .'";';
            echo 'arry['.$c++.']= "'. $arrAk["AKREDITASYON_KAPSAM"] .'";';


        }
        ?>

        var rowCount = 7;
        createNPanels(panelCount, panelName, buttonName, "datePick");

        if (isset(arry))
            addPanelValues(arry, panelName, panelCount, rowCount);
    }

</script>
<script type="text/javascript">//<![CDATA[
    //bu script inputtan sonra konmali, mümünse en alta </body> den önce

    var cal = Calendar.setup({
        onSelect: function (cal) {
            cal.hide()
        }
    });
    //]]></script>