<?php
header( 'Location: http://myk.gov.tr/index.php/tr/component/yeterlilik_sor/?view=yeterlilik_sor' );
// geri kalan kod hiç bir işe yaramıyor. header var. header baska sayfaya yönlendiriyor.

defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form_config.php');
require_once('libraries/form/form.php');
require_once('libraries/form/form_parametrik.php');
?>

<div class="icBtnsWrapper">
<div class="contentheading">Ulusal Yeterlilikler</div>
<p><a class="bigBtn"
	href="index.php?option=com_yeterlilik_ara"
	title="Ulusal Yeterlilikler">Ulusal Yeterlilikler</a> <a class="bigBtn"
	href="index.php?option=com_yeterlilik_taslak_ara&amp;Itemid=256"
	title="Hazırlanmakta Olan Taslak Yeterlilikler">Hazırlanmakta Olan
Taslak Yeterlilikler</a>


<?php

$user =& JFactory::getUser();
$autMS =  FormFactory::checkAuthorization  ($user, MS_SEKTOR_SORUMLUSU_GROUP_ID);
$autYet =  FormFactory::checkAuthorization  ($user, YET_SEKTOR_SORUMLUSU_GROUP_ID);

if($user->guest || $autYet || $autMS){?>

<!-- <a class="bigBtnDisabled" -->
<!-- 	href="javascript:;" -->
<!-- 	title="Başvuru yapabilmek için öncelikle kayıt olmalısınız!">Ulusal -->
<!-- Yeterlilik Hazırlama Başvurusu</a> -->

<?php }
else{
	?>
<a class="bigBtn"
	href="index.php?option=com_yeterlilik_basvur&layout=kurulus_bilgi&Itemid=211"
	title="Ulusal Yeterlilik Hazırlama Başvurusu">Ulusal Yeterlilik
Hazırlama Başvurusu</a>
	<?php }?>
</p>
</div>
