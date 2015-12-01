<?php
defined('_JEXEC') or die('Restricted access');
$session =&JFactory::getSession();
$tumSonuclar = $session->get('tumSonuclar');

echo '<pre>';
print_r($tumSonuclar);
echo '</pre>';

?>