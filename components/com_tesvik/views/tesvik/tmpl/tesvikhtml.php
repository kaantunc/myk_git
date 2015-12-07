<?php
$AdayBilgi = $this->TesvikAdaylar['AdayBilgi'];

$tesvik = $this->tesvik;
if ($tesvik['LISTE_KODU'] == "") {
    $_SESSION['liste_kodu'] = " - ";
} else {
    $_SESSION['liste_kodu'] = str_pad($tesvik['LISTE_KODU'], 3, "0", STR_PAD_LEFT);
}
$_SESSION['tesvik'] = $this->tesvik;
if (strlen($this->tesvikId) == 1) {
    $_SESSION['tesvikId'] = '00' . $this->tesvikId;
} else if (strlen($this->tesvikId) == 2) {
    $_SESSION['tesvikId'] = '0' . $this->tesvikId;
} else {
    $_SESSION['tesvikId'] = $this->tesvikId;
}



$html = '
<table width="100%" border="1" style="padding:3px;font-size:9px">
		<thead>
			<tr style="text-align:center">
				<th width="3%"><strong>A</strong></th>
				<th width="7%"><strong>B</strong></th>
				<th width="6%"><strong>C</strong></th>
				<th width="16%"><strong>D</strong></th>
				<th width="18%"><strong>E</strong></th>
				<th width="6%"><strong>F</strong></th>
				<th width="6%"><strong>G</strong></th>
				<th width="6%"><strong>I</strong></th>
				<th width="6%"><strong>J</strong></th>
				<th width="6%"><strong>K</strong></th>
				<th width="13%"><strong>L</strong></th>
				<th width="7%"><strong>M</strong></th>
			</tr>
			<tr style="text-align:center">
				<th width="3%"><strong>Sıra No</strong></th>
				<th width="7%"><strong>Adı Soyadı</strong></th>
				<th width="6%"><strong>TC Kimlik No</strong></th>
				<th width="16%"><strong>Belgelendirildiği Meslek Adı ve Seviyesi</strong></th>
				<th width="18%"><strong>Belgelendirme Kuruluşu</strong></th>
				<th width="6%"><strong>Bakanlar Kurulu Kararı No:</strong></th>
				<th width="6%"><strong>Bakanlar Kurulu Tavan Ücret</strong></th>
				<th width="6%"><strong>Kuruluş Sınav Ücreti</strong></th>
				<th width="6%"><strong>Fondan Karşılanan Ücret</strong></th>
				<th width="6%"><strong>MYK Belge Ücreti</strong></th>
				<th width="13%"><strong>IBAN</strong></th>
				<th width="7%"><strong>GSM</strong></th>
			</tr>
		</thead>
	<tbody>';

$say = 0;
$TopSinav = 0;
$FonBürüt = 0;
$FonNet = 0;
$TopBelgeMasraf = 0;
$temmuzOncesi = 0;
$temSay = 0;

foreach ($AdayBilgi as $row) {
    $say++;
    $html .= '<tr nobr="true">';
    $html .= '<td width="3%" align="center">' . $say . '</td>';
    $html .= '<td width="7%">' . $row['ADI'] . ' ' . $row['SOYADI'] . '</td>';
    $html .= '<td width="6%" align="center">' . $row['TC_KIMLIK'] . '</td>';
    $html .= '<td width="16%">' . $row['YETERLILIK_ADI'] . ' Seviye ' . $row['YETERLILIK_SEVIYESI'] . '</td>';
// $html .= '<td width="16%">NC/CNC TAKIM TEZGAHLARI ELEKTRİK/ELEKTRONİK SERVİS GÖREVLİSİ Seviye '.$row['YETERLILIK_SEVIYESI'].'</td>';
    $html .= '<td width="18%">' . $row['KURULUS_ADI'] . '</td>';
// $html .= '<td width="18%">Türkiye İnşaat Sanayicileri İşveren Sendikası Mesleki Yeterlilik ve Belgelendirme Merkezi İktisadi İşletmesi</td>';
    $html .= '<td width="6%" align="center">' . $row['BK_KARAR_SAYI'] . '</td>';
    $html .= '<td width="6%" align="center">' . number_format(UcretDuzenle($row['BK_UCRET']), 2, ',', '.') . '</td>';

    $uc = UcretDuzenle($row['SINAV_UCRET']);
    $TopSinav += $uc;

    $html .= '<td width="6%" align="center">' . number_format($uc, 2, ',', '.') . '</td>';
    $html .= '<td width="6%" align="center">' . number_format(UcretDuzenle($row['DAMGALI_UCRET']), 2, ',', '.') . '</td>';

    $FonBürüt += UcretDuzenle($row['DAMGALI_UCRET']);
    $FonNet += UcretDuzenle($row['DAMGASIZ_UCRET']);

    if ($row['BELGE_MASRAF'] == 1) {
        $html .= '<td width="6%" align="center">0,00</td>';
        $temmuzOncesi += UcretDuzenle($row['BELGE_UCRET']);
        $temSay++;
    } else {
        $html .= '<td width="6%" align="center">' . number_format(UcretDuzenle($row['BELGE_UCRET']), 2, ',', '.') . '</td>';
        $TopBelgeMasraf += UcretDuzenle($row['BELGE_UCRET']);
    }


    $html .= '<td width="13%">' . trim(str_replace(' ', '', $row['IBAN'])) . '</td>';
// $html .= '<td width="13%" align="center">TR888888888889999999999999999999</td>';
    $html .= '<td width="7%">' . str_replace(' ', '', $row['TELEFON']) . '</td>';
// $html .= '<td width="6%" align="center">+905438888888</td>';
    $html .= '</tr>';

}

$html .= '<tr>';
$html .= '<td align="center"><strong>' . $say . '</strong></td>';
$html .= '<td colspan="6" align="center"><strong>TOPLAM</strong></td>';
$html .= '<td align="center"><strong>' . number_format($TopSinav, 2, ',', '.') . '-TL</strong></td>';
$html .= '<td align="center"><strong>' . number_format($FonBürüt, 2, ',', '.') . '-TL</strong></td>';
// $html .= '<td align="center"><strong>'.number_format($FonNet,2,',','.').'-TL</strong></td>';
$html .= '<td align="center"><strong>' . number_format($TopBelgeMasraf, 2, ',', '.') . '-TL</strong></td>';
$html .= '<td colspan="2"></td>';
$html .= '</tr>';

$html .= '</tbody>
</table>
';

// $pdf->Cell(30, 0, 'Top-Center', 1, $ln=0, 'C', 0, '', 0, false, 'C', 'C');

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
echo $html;

function UcretDuzenle($ucret)
{
    return str_replace(',', '.', $ucret);
}

function DamgasizHesapla($alinacak)
{
    $dat = $alinacak - ($alinacak * (0.00759));
    $dat = floor($dat * 100) / 100;
    return number_format($dat, '2', ',', '.');
}