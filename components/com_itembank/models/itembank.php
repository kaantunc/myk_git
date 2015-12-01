<?php
defined('_JEXEC') or die('Restricted access');

class ItembankModelItembank extends JModel {
	var $title 		= "MYK Portal Itembank"; 
	var $pages 		= array ("yonetim","genelkurul","komite","sektorSorumlusuYetki","sektorSorumlusu","sektorIslemleri","itemBankKullanicilari"); 
	var $pageNames 	= array ("Yönetim Kurulu","Genel Kurul","Sektör Komitesi","SS Yetkilendirme","SS Kullanıcı Yönetimi","Sektör İşlemleri","Item Bank Kullanıcıları");
		
	function getPageTree ($user, $activeLayout, $standart_id, $evrak_id, $taslak = 0){
		$activeStyle = 'style="background-color:rgb(170,0,0);color:rgb(255,255,255); margin: 1px;"';
		$sayfa = count ($this->pages);
		$activeStyle = 'style="background-color:rgb(170,0,0);color:rgb(255,255,255); margin: 1px;"';

		$tree = '<div style="text-align:center; padding-bottom: 15px;" >
				 <div style="padding-bottom:10px;">';
		
		$inp = '<input style="padding:5px; margin: 5px;" type="button" ';
		$value	 = "";
		$onClick = "";
		$disabled= "";
		
		
		$tree .= '</div>';
		
		for ($i = 0; $i < $sayfa; $i++){
			$style = 'style="margin: 1px;"';
			
			$input = '<input type="button" onclick="window.location=\'index.php?option=com_admin&layout='.$this->pages[$i].'\', \'\'" class="btn" id="page'.$i.'" value="'.$this->pageNames[$i].'" ';
            if ($activeLayout == $this->pages[$i])
				$tree .= $input.$activeStyle.' />';
			else
				$tree .= $input.$style.' />'; 
		}
		
		$tree .= '<br /></div>';
		
		return $tree;
	}
	
    
   
    
}
?>