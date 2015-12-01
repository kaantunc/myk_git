<style>
<!--
.marclass{
margin-bottom:5px;
}
-->
</style>
<?php
$data = $this->adays;
    echo "<div style='margin-left:50px'>";
    foreach($data["hataMesaji"] as $key=>$mesaj){

        switch ($key){
            case 1:
                    echo  "<h2>".$mesaj."</h2>";
//                    foreach($data['hatalıTckimlik'] as $tckimlik){
//                            echo "<li>Satır No: ".$tckimlik[0].", TC Kimlik No:".$tckimlik[1]."</li>";
//                    }
            echo "<hr>";				
            break;

            case 2:
                     echo  "<h2>".$mesaj."</h2>";
                    foreach($data['sinavTarihi360'] as $satir){
                            echo "<li>Satır no: ".$satir[0].", Sınav Tarihi: ".$satir[1]."</li>";
                    }
                    echo "<hr>";
            break;

            case 3:
                    echo  "<h2>".$mesaj."</h2>";
                    foreach($data['adayBilgisi'] as $satir){
                    	echo "<li>Satır no: ".$satir.", aday bilgileri sistemde kayıtlı aday bilgileri ile farklılık göstermektedir.</li>";
                    }
                    echo "<hr>";
            break;

            case 4:
                    echo  "<h2>".$mesaj."</h2>";
                    foreach($data['sinavTarihi'] as $satir){
                            echo "<li>Satır no: ".$satir[0].", Sınav Tarihi: ".$satir[1]."</li>";
                    }
                    echo "<hr>";
            break;

            case 5:
                    echo  "<h2>".$mesaj."</h2>";
                    foreach($data['sinavYeri'] as $satir){
                            echo "<li>Satır no: ".$satir[0].", Sınav Yeri: ".$satir[1]."</li>";
                    }
                    echo "<hr>";
            break;

            case 6:
                    echo  "<h2>".$mesaj."</h2>";
                    foreach($data['degerlendirici'] as $satir){
                            echo "<li>Satır no: ".$satir[0].", Değerlendirici TCKN: ".$satir[1]."</li>";
                    }
                    echo "<hr>";
            break;

            case 7:
                    echo  "<h2>".$mesaj."</h2>";
                    foreach($data['sonuc'] as $satir){
                            echo "<li>Satır no: ".$satir."</li>";
                    }
            break;

            case 8:
            echo  "<h2>".$mesaj."</h2>";
                    foreach($data['puan'] as $satir){
                            echo "<li>Satır no: ".$satir."</li>";
                    }
            break;

//            case 9:
//                    echo  "<h2>".$mesaj."</h2>";
//                    foreach($data['tcknHata'] as $satir){
//                            echo "<li>Satır no: ".$satir[0].", Sınav Tarihi: ".$satir[1]."</li>";
//                    }
//            break;
//                        
//            case 10:
//                    echo  "<h2>".$mesaj."</h2>";
//                    foreach($data['tcknHata'] as $satir){
//                            echo "<li>Satır no: ".$satir[0].", Sınav Tarihi: ".$satir[1]."</li>";
//                    }
//            break;
//                        
//            case 11:
//                    echo  "<h2>".$mesaj."</h2>";
//                    foreach($data['basDurum'] as $satir){
//                            echo "<li>Satır no: ".$satir[0].", TC Kimlik No'lu <a href='index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=sonucgor&sinav=".$satir[2]."&tckn=".$satir[1]."'>".$satir[1]." aday</li>";
//                    }
//            break;
			
            case 12:
            	echo  "<h2>".$mesaj."</h2>";
            	foreach($data['telefon'] as $satir){
            		echo "<li>Satır no: ".$satir."</li>";
            	}
            break;
            
            case 13:
            	echo  "<h2>".$mesaj."</h2>";
            	foreach($data['telefon'] as $satir){
            		echo "<li>Satır no: ".$satir."</li>";
            	}
            break;
            
            case 14:
            	echo  "<h2>".$mesaj."</h2>";
            	foreach($data['iban'] as $satir){
            		echo "<li>Satır no: ".$satir."</li>";
            	}
            break;
            
            case 15:
            	echo  "<h2>".$mesaj."</h2>";
            	foreach($data['iban'] as $satir){
            		echo "<li>Satır no: ".$satir."</li>";
            	}
            break;
            
            case 16:
            	echo  "<h2>".$mesaj."</h2>";
            	foreach($data['email'] as $satir){
            		echo "<li>Satır no: ".$satir."</li>";
            	}
            break;
            
            case 17:
            	echo  "<h2>".$mesaj."</h2>";
            	foreach($data['email'] as $satir){
            		echo "<li>Satır no: ".$satir."</li>";
            	}
            break;
				
		}
		
		
	}
echo "</div>";
echo '<br>';
echo '<a href="index.php?option=com_belgelendirme&view=belgelendirme_islemleri&layout=sonuc_bildir&sinav='.$_GET['sinav'].'">Dosyayı tekrar yükle.</a>';

?>
