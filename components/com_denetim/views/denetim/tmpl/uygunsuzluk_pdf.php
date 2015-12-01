<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

	$width 			= 260;//260
	$tableHTMLWidth = 820;
	$tWidth			= 475;
	$tWidth2		= 335;
	$titleWidth	 	= 500;
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
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////7
        //********************* Uygunsuzluk Bilgileri Son***************************************************//
	
//echo '<div>';
	echo '<div style="height:auto;padding: 10px 15px;">
                                <table border="1" style="width:100%;" cellpadding="'.$tablePadding.'">';
        
        echo '<tr nobr="true"><td>';
//        echo borderBegin ();
            echo tabloNoBorder (array(image('images/MYKlogo.jpg'),'<h3 style="text-align:center">MESLEKİ YETERLİLİK KURUMU</h3> <br/><h2 style="text-align:center"><strong>DENETİM UYGUNSUZLUK RAPORU</strong></h2>'),array(30,70));
//            echo borderEnd ();
        echo '</td></tr>';
        echo '<tr nobr="true"><td>';
//            echo borderBegin ();
            echo tabloNoBorder (array('<strong>UYGUNSUZLUK NO: </strong>'.$uygunsuzlukNoText,'<strong>DENETİM TARİHİ: </strong>'.$denetimTarihiText,'<strong>DENETİM TÜRÜ: </strong>'.$denetimTuruText),array(33,32,35));
//            echo borderEnd ();
        echo '</td></tr>';
	//KURULUS BILGILERI
        echo '<tr nobr="true"><td>';
//	echo borderBegin ();
        echo tabloNoBorder(array("<strong>KURULUŞ: </strong>".$uygunsuzlukKurulusuText,"<strong>DOSYA NO: </strong>".$uygunsuzlukDosyaNoText),array(70,30));
	echo tableHTML ("<strong>KURULUŞ TEMSİLCİSİ:</strong>", $kurulusTemsilcisiText,25);
	echo tableHTML ("<strong>DENETİM EKİBİ:</strong>", $denetimEkibiText,20);	
//	echo borderEnd ();
	echo '</td></tr>';
        
        echo '<tr nobr="true"><td>';
//	echo borderBegin ();
        echo blockTitle ("UYGUNSUZLUK TESPİT EDİLEN KONU:");
	echo tableHTML ("<strong>AÇIKLAMA:</strong>");	
        echo tableHTML($uygunsuzlukAciklamasiText,'','100');
	echo tableHTML ("<strong>UYGUNSUZLUK TÜRÜ:</strong>", $uygunsuzlukTuruText,25);	
	echo tableHTML ("<strong>YERİNDE TAKİP DENETİMİ GEREKİR Mİ?  </strong>", $uygunsuzlukYerindeTakipText);
        echo tabloNoBorder(array('<strong>KURULUŞ TEMSİLCİSİ: </strong>'.$kurulusTemsilcisiText, '<strong>BAŞ DENETCİ: </strong>'.$denetimBasDenetcisiText));
        echo tabloNoBorder(array('<strong>İMZA: </strong>', '<strong>İMZA: </strong>'));
//	echo borderEnd ();
        echo '</td></tr>';
        //********************* GERÇEKLEŞTİRİLECEK DÜZELTİCİ FAALİYET *******************************************//
        echo '<tr nobr="true"><td>';
//        echo borderBegin ();
        echo blockTitle ("GERÇEKLEŞTİRİLECEK DÜZELTİCİ FAALİYET");
	echo tableHTML ($gerceklestirilecekDuzelticiFaaliyetText,'','100');	
        echo tabloNoBorder(array('<strong>TAMAMLANMA SÜRESİ: </strong>'.$tamamlanmaSuresiText, '<strong>KURULUŞ TEMSİLCİSİ İMZASI</strong>'));
	echo tableHTML ("<strong>TARİH: </strong>",$duzelticiFaaliyetTarihText,8);
//	echo borderEnd ();
        echo '</td></tr>';
        //********************* DÜZELTİCİ FAALİYET SONUCU *******************************************//
        echo '<tr nobr="true"><td>';
//        echo borderBegin ();
        echo blockTitle ("DÜZELTİCİ FAALİYET SONUCU");
	echo tableHTML ($duzelticiFaaliyetSonucuText,'','100');	
        echo tableHTML ("<strong>AÇIKLAMA:</strong>");
        echo tableHTML ($dfSonucAciklamaText);
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
        $table = '<table cellpadding="'.$tablePadding.'">
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
        $table = '<table cellpadding="'.$tablePadding.'">
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
        return '<img src="'.$data.'" width="600" height="300"/>';
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
                                <table border="1" style="width:100%;" cellpadding="'.$tablePadding.'">
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
                                <table border="1" style="width:100%;" cellpadding="'.$tablePadding.'">
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
                                <dt> </dt><dd><table style="width:100%;" cellpadding="'.$tablePadding.'">
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
        return '<table width="100%" border="1"><tbody><tr><td>';
    }

    function  borderEnd (){
        return '</td></tr></tbody></table>';
    }

    function getPersonelArr ($arr, $params, $dil = 0){
        $returnArr = array ();
        $personelId = -1;
        $c = -1;
        $p = 0;
        for ($i = 0; $i < count($arr); $i++){
            if ($personelId != $arr[$i]["GOREVLI_PERSONEL_ID"]){
                    $personelId = $arr[$i]["GOREVLI_PERSONEL_ID"];
                    $c++;
                    $p = 0;
            }

            for ($j = 0; $j < count($params); $j++){
                    $returnArr [$c][$p][$params[$j]] = $arr[$i][$params[$j]];
            }
            $p++;
        }

        if ($dil){
            $dilReturn = array ();
            for ($i = 0; $i < count($returnArr); $i++){ //Personel
                    $c = 0;
                    for ($j = 0; $j < count($returnArr[ $i])/4; $j++){ //Dil
                            $dilReturn [$i][$c]["DIL_ADI"] = $returnArr[$i][$j*4]["DIL_ADI"];
                            for ($k = 0; $k < 4; $k++){
                                    if (isset ($returnArr[$i][$k+$j*4]["DIL_DERECESI"]))
                                            $dilReturn [$i][$c]["DIL_DERECESI_".($k+1)] = $returnArr[$i][$k+$j*4]["DIL_DERECESI"];
                                    else
                                            $dilReturn [$i][$c]["DIL_DERECESI_".($k+1)] = null;
                            }
                            $c++;
                    }
            }

            $returnArr = $dilReturn;
        }


        return $returnArr;
    }
	
?>