<?php
header( 'Location: http://myk.gov.tr/index.php/tr/component/msd/?view=msd&layout=msdlist' );
// geri kalan kod hiç bir işe yaramıyor. header var. header baska sayfaya yönlendiriyor.

defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form_config.php');
require_once('libraries/form/form.php');
require_once('libraries/form/form_parametrik.php');
?>

<div class="icBtnsWrapper">
<div class="contentheading">Ulusal Meslek Standartları</div>
<p>
<a class="bigBtn" href="index.php?option=com_meslek_std_ara"	title="Yönetim Kurulu tarafından onaylanan ve Resmi Gazetede yayınlanan Ulusal Meslek Standartları">Yayınlanmış
Ulusal Meslek Standartları</a>
 <a class="bigBtn"	href="index.php?option=com_meslek_std_taslak_ara&amp;gorus=1&amp;Itemid=255"	title="Görüş Aşamasındaki Taslak Meslek Standartları">Görüş Aşamasındaki Taslak Meslek Standartları</a>
 <a class="bigBtn"	href="index.php?option=com_meslek_std_taslak_ara&amp;protokol=1"	title="Protokolü İmzalanmış Tüm Meslek Standartları">Protokol
Kapsamındaki Meslek Standartları</a> 

<?php 

$user =& JFactory::getUser();

$autMS =  FormFactory::checkAuthorization  ($user, MS_SEKTOR_SORUMLUSU_GROUP_ID);
$autYet =  FormFactory::checkAuthorization  ($user, YET_SEKTOR_SORUMLUSU_GROUP_ID);

if($user->guest || $autYet || $autMS){?>

<!-- <a class="bigBtnDisabled" -->
<!-- 	href="javascript:;" -->
<!-- 	title="Başvuru yapabilmek için öncelikle kayıt olmalısınız!">Ulusal Meslek -->
<!-- Standardı Hazırlama Başvurusu</a>	 -->

<?php }
else{
?>
<a class="bigBtn"
	href="index.php?option=com_meslek_std_basvur&Itemid=210"
	title="Ulusal Meslek Standardı Hazırlama Başvurusu">Ulusal Meslek
Standardı Hazırlama Başvurusu</a>
<?php }?>
</p>
</div>
