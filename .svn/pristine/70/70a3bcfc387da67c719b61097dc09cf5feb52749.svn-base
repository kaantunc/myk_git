<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
if (!headers_sent()) {
	header_remove();
}

//echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
	$width 			= 60;//260
	$tableHTMLWidth = 420;
	$tWidth			= 75;
	$tWidth2		= 35;
	$titleWidth	 	= 50;
	$tablePadding	= 3;
        
        //********************* Uygunsuzluk Bilgileri ***************************************************//
        $uygunsuzluk_id = JRequest::getVar("uygunsuzluk_id");
        $denetim_id = JRequest::getVar("denetim_id");


        $user = & JFactory::getUser();
        $userId = $user->getOracleUserId();
        $denetciMi = FormFactory::buIDDenetciMi($userId);
        $denetlemesiYapilacakKurulusMu = FormFactory::buIDDenetlemesiYapilacakKurulusMu($user->id);
        $isSektorSorumlusu = FormFactory::buIDDenetlemedenSorumluSSMu($user->id);


        if(strlen($uygunsuzluk_id) > 0)//uygunsuzluk id tanımlı yani önceden tanımlanmış bişey
        {
                $uygunsuzluk = $this->seciliUygunsuzluk;
                $denetim = $this->seciliUygunsuzlugunDenetimi;
                $denetimEkibi = $this->seciliDenetiminDenetimEkibi;
                foreach($denetimEkibi as $ekipUyesi)
                        $denetimEkibiText .= $ekipUyesi['AD'].' '.$ekipUyesi['SOYAD'];

                $denetimBasDenetcisi = $this->seciliDenetiminBasDenetcisi;
                $denetimBasDenetcisiText .= $denetimBasDenetcisi[0]['AD'].' '.$denetimBasDenetcisi[0]['SOYAD'];

        }
        else
        { 
                if (strlen($denetim_id) > 0) // uygunsuzluk tanımlancak, denetim_id al
                {
                        $denetimEkibi = $this->seciliDenetiminDenetimEkibi;
                        foreach($denetimEkibi as $ekipUyesi)
                                $denetimEkibiText .= $ekipUyesi['AD'].' '.$ekipUyesi['SOYAD'];

                        $denetimBasDenetcisi = $this->seciliDenetiminBasDenetcisi;
                        $denetimBasDenetcisiText .= $denetimBasDenetcisi[0]['AD'].' '.$denetimBasDenetcisi[0]['SOYAD'];

                        $denetim = $this->seciliDenetim;
                }
                else // denetim_id yoksa hata
                {
                        global $mainframe;
                        $mainframe->redirect("index.php?option=com_denetim&layout=denetim_listele", "Hatalı giriş yapıldı", 'error');
                }	
        }
        
        
        
            $uygunsuzlukKurulusuText = $this->uygunsuzlugunKurulusu;
            $kurulusTemsilcisiText = $uygunsuzluk['KURULUS_TEMSILCISI'];
            $uygunsuzlukNoText = $uygunsuzluk['UYGUNSUZLUK_NO'];
            $uygunsuzlukDosyaNoText = $uygunsuzluk['DOSYA_NO'];
            $uygunsuzlukAciklamasiText = $uygunsuzluk['UYGUNSUZLUK_ACIKLAMASI'];
            $uygunsuzlukTuruText = $uygunsuzluk['TUR_ACIKLAMA'];
            $uygunsuzlukYerindeTakipText = ($uygunsuzluk['YERINDE_TAKIP_GEREKIR_MI']=='1') ? 'Evet' : 'Hayır';
        

        $denetimTarihiText = $denetim['DENETIM_TARIHI_BASLANGIC'];
        $denetimTuruText = $denetim['DENETIM_TURU_ACIKLAMA'];
        
        $gerceklestirilecekDuzelticiFaaliyetText = $uygunsuzluk['DUZELTICI_FAALIYET'];
        $tamamlanmaSuresiText = $uygunsuzluk['TAMAMLANMA_SURESI'];
        $duzelticiFaaliyetTarihText = $uygunsuzluk['DUZELTICI_FAALIYET_TARIHI'];
        $duzelticiFaaliyetSonucTarih = $uygunsuzluk['DUZELTICI_FAALIYET_SNC_TARIHI'];
        //$duzelticiFaaliyetSonucTarih = str_replace('/','.',$uygunsuzluk['DUZELTICI_FAALIYET_SNC_TARIHI']);
        
        if($uygunsuzluk['DUZELTICI_FAALIYET_SONUCU']=='1')
                                $duzelticiFaaliyetSonucuText = 'Yeterli';
                        else
                                $duzelticiFaaliyetSonucuText = 'Yetersiz';
        
        $dfSonucAciklamaText = $uygunsuzluk['DUZELTICI_FAALIYET_SNC_ACK'];
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=".$uygunsuzluk['UYGUNSUZLUK_ID'].".doc");
        //********************* Uygunsuzluk Bilgileri Son***************************************************//
	
//echo '<div>';
	echo '<div style="height:auto;padding: 10px 15px; width:500px">
                                <table nobr="true" border="1" style="width:100%;" cellpadding="'.$tablePadding.'">
                                        <tbody nobr="true"  style="page-break-before:auto;">';
        
        echo '<tr><td>';
//        echo borderBegin ();
            echo tabloNoBorder (array(image('http://portal.myk.gov.tr/images/MYKlogo.jpg'),'<h3 style="text-align:center">MESLEKİ YETERLİLİK KURUMU</h3> <br/><h3 style="text-align:center"><strong>DENETİM UYGUNSUZLUK RAPORU</strong></h3>'),array(20,80));
//            echo borderEnd ();
        echo '</td></tr>';
        echo '<tr><td>';
//            echo borderBegin ();
            echo tabloNoBorder (array('<strong>UYGUNSUZLUK NO: </strong>','<strong>DENETİM TARİHİ: </strong>','<strong>DENETİM TÜRÜ: </strong>'),array(30,30,30));
            echo tabloNoBorder (array($uygunsuzlukNoText,$denetimTarihiText,$denetimTuruText),array(30,30,30));
//            echo borderEnd ();
        echo '</td></tr>';
	//KURULUS BILGILERI
        echo '<tr><td>';
//	echo borderBegin ();
        echo tabloNoBorder(array("<strong>KURULUŞ: </strong>".$uygunsuzlukKurulusuText,"<strong>DOSYA NO: </strong>".$uygunsuzlukDosyaNoText),array(70,30));
	echo tableHTML ("<strong>KURULUŞ TEMSİLCİSİ:</strong>", $kurulusTemsilcisiText,45);
	echo tableHTML ("<strong>DENETİM EKİBİ:</strong>", $denetimEkibiText,40);	
//	echo borderEnd ();
	echo '</td></tr>';
        
        echo '<tr><td>';
//	echo borderBegin ();
        echo blockTitle ("UYGUNSUZLUK TESPİT EDİLEN KONU:");
	echo tableHTML ("<strong>AÇIKLAMA:</strong>");	
    echo tableHTML($uygunsuzlukAciklamasiText,'',100);
//     echo tableHTML("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
// It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
//  Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of de Finibus Bonorum et Malorum (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, Lorem ipsum dolor sit amet.., comes from a line in section 1.10.32.","",100);
	echo tableHTML ("<strong>UYGUNSUZLUK TÜRÜ:</strong>", $uygunsuzlukTuruText,45);	
	echo tableHTML ("<strong>YERİNDE TAKİP DENETİMİ GEREKİR Mİ?  </strong>", $uygunsuzlukYerindeTakipText,45);
        echo tabloNoBorder(array('<strong>KURULUŞ TEMSİLCİSİ: </strong>'.$kurulusTemsilcisiText, '<strong>BAŞ DENETÇİ: </strong>'.$denetimBasDenetcisiText),array(30,30));
        echo tabloNoBorder(array('<strong>İMZA: </strong>', '<strong>İMZA: </strong>'));
//	echo borderEnd ();
        echo '</td></tr>';
        //********************* GERÇEKLEŞTİRİLECEK DÜZELTİCİ FAALİYET *******************************************//
        echo '<tr><td>';
//        echo borderBegin ();
        echo blockTitle ("GERÇEKLEŞTİRİLECEK DÜZELTİCİ FAALİYET");
	echo tableHTML ($gerceklestirilecekDuzelticiFaaliyetText);	
        echo tabloNoBorder(array('<strong>TAMAMLANMA SÜRESİ: </strong>'.$tamamlanmaSuresiText, '<strong>KURULUŞ TEMSİLCİSİ İMZASI</strong>'));
	echo tableHTML ("<strong>TARİH: </strong>",$duzelticiFaaliyetTarihText,8);
//	echo borderEnd ();
        echo '</td></tr>';
        //********************* DÜZELTİCİ FAALİYET SONUCU *******************************************//
        echo '<tr><td>';
//        echo borderBegin ();
        echo blockTitle ("DÜZELTİCİ FAALİYET SONUCU");
	echo tableHTML ($duzelticiFaaliyetSonucuText);	
        echo tableHTML ("<strong>AÇIKLAMA:</strong>");
        echo tableHTML ($dfSonucAciklamaText,'',100);
        echo tabloNoBorder(array('<strong>BAŞ DENETÇİ: </strong>'.$denetimBasDenetcisiText, '<strong>İMZA:</strong>','<strong>TARİH: </strong>'.$duzelticiFaaliyetSonucTarih),array(40,30,30));
//	echo borderEnd ();
	echo '</td></tr>';
//	
    echo '</tbody>
        </table>
        </div>';
// echo '</div>';
    //*************************** FUNCTIONS *************************************************************//
    function tableHTML ($title, $data, $width=30, $tab = 1){
        $table = '<table nobr="true" cellpadding="'.$tablePadding.'">
                                <tr >
                                        <td width="'.$width.'%">'.$title.'</td>
                                        <td >'.$data.'</td>
                                </tr>
                        </table>';

        if ($tab)
            return "<dt> </dt><dd>".$table."</dd>";
        else
            return $table;
    }
    //
    function tableHTML2 ($title, $data, $width=120, $tab = 1){
        $table = '<table nobr="true" cellpadding="'.$tablePadding.'">
                                <tr >
                                        <td ><img src="'.$data.'" width="600" height="300"/></td>
                                </tr>
                        </table>';

        if ($tab)
            return "<dt> </dt><dd>".$table."</dd>";
        else
            return $table;
    }
    //
    function image($data){
        return '<img src="'.$data.'" width="180" height="100"/>';
    }
    //
    function blockTitle ($title, $align="left", $tab = 1){
        $titleHTML = '<h3 style="font-size:15px;text-align:'.$align.'">'.$title.'</h3>';
        if ($tab)
            return '<dt> </dt><dd>'.$titleHTML.'</dd>';
        else
            return $titleHTML;
    }

    function tablo ($paramTitles, $paramIds, $params){	
        $html = '';
        $colCount = count($paramTitles);

        $title = "<tr>";
        for ($i = 0; $i < $colCount; $i++){
                $title .= '<td style="text-align:center"><strong><br />'.$paramTitles[$i].'<br /></strong></td>';
        }
        $title .= "</tr>";

        $htmlPart = "";
        for ($i = 0; $i < count($params); $i++){ 
            $data = $params[$i];
            $part = "<tr>";
            for ($j = 0; $j < count($paramIds); $j++){	
                    $paramparts=explode(" ",$paramIds[$j]);
                    if(!empty($paramparts[1]))		
                            $part .= '<td style="padding-top: 5px; padding-bottom: 5px; border-bottom-width:thin; border-style:none none dotted;"><dt> </dt><dd>'.$data[$paramparts[0]].'  '.$data[$paramparts[1]].'</dd><dd></dd></td>';
                    else
                            $part .= '<td style="padding-top: 5px; padding-bottom: 5px; border-bottom-width:thin; border-style:none none dotted;"><dt> </dt><dd>'.$data[$paramparts[0]].'</dd><dd></dd></td>';
            }
            $part .= "</tr>";

            $htmlPart .= $part;
        }

        $html .= '<div style="height:auto;padding: 10px 15px;">
                                <table nobr="true" border="1" style="width:100%;" cellpadding="'.$tablePadding.'">
                                        <tbody>'.
                                                $title.$htmlPart 
                                        .'</tbody>
                                </table>
                        </div>';		

        return $html;
    }
    function tablo_for_basvuru_ek ($paramTitles, $paramIds, $params){	
        $html = '';
        $colCount = count($paramTitles);

        $title = "<tr>";
        for ($i = 0; $i < $colCount; $i++){
                $title .= '<td style="text-align:center"><strong><br />'.$paramTitles[$i].'<br /></strong></td>';
        }
        $title .= "</tr>";

        $htmlPart = "";
        for ($i = 0; $i < count($params); $i++){ 
            $data = $params[$i];
            $part = "<tr>";
            for ($j = 0; $j < count($paramIds); $j++){	
                            $part .= '<td style="padding-top: 5px; padding-bottom: 5px; border-bottom-width:thin; border-style:none none dotted;"></td>';
            }
            $part .= '<td style="padding-top: 5px; padding-bottom: 5px; border-bottom-width:thin; border-style:none none dotted;"><dt> </dt><dd>Ek 2 / Broş- '.($i+1).' </dd><dd></dd></td>';
            $part .= "</tr>";

            $htmlPart .= $part;
        }

        $html .= '<div style="height:auto;padding: 10px 15px;">
                                <table nobr="true" border="1" style="width:100%;" cellpadding="'.$tablePadding.'">
                                        <tbody>'.
                                                $title.$htmlPart 
                                        .'</tbody>
                                </table>
                        </div>';		

        return $html;
    }

    function tabloNoBorder($paramTitles, $widths){	
        $html = '';
        $colCount = count($paramTitles);

        $title = "<tr>";
        if(count($widths) == $colCount){
            for ($i = 0; $i < $colCount; $i++){
                    $title .= '<td width="'.$widths[$i].'%">'.$paramTitles[$i].'</td>';
            }
        }
        else{
            for ($i = 0; $i < $colCount; $i++){
                    $title .= '<td>'.$paramTitles[$i].'</td>';
            }
        }
        $title .= "</tr>";

        $html .= '<div style="height:auto;padding: 10px 15px;">
                                <dt> </dt><dd><table nobr="true" style="width:100%;" cellpadding="'.$tablePadding.'">
                                        <tbody>'.
                                                $title 
                                        .'</tbody>
                                </table></dd>
                        </div>';		

        return $html;
    }

    function divHTML ($data){
        return "<div><dt> </dt><dd>".FormFactory::ignoreBreaks($data)."</dd></div>";
    }

    function  borderBegin (){
        return '<table nobr="true" width="100%" border="1"><tbody><tr><td>';
    }

    function  borderEnd (){
        return '</td></tr></tbody></table>';
    }
    
	exit;
?>