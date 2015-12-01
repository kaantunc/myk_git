<div class="anaDiv font20 fontBold hColor text-center">
    AB Hibe Kapsamında Ücret İadesininden Yararlanıcak Aday Listesi
</div>
<div class="anaDiv font16 fontBold text-warning">

</div>
<div class="anaDiv">
    <div class="div30 font18 fontBold hColor">
        Örnek Başvuru Listesi
    </div>
    <div class="div70">
        <a target="_blank" href="index.php?dl=ekler/abhibe_basvuru_listesi.xlsx" class="btn btn-sm btn-warning">İndir</a>
    </div>
</div>

<?php
if($this->basvuruExcel){
?>
<div class="anaDiv">
    <div class="div30 font18 fontBold hColor">
        Yüklenen Başvuru Listesi
    </div>
    <div class="div70">
        <a target="_blank" href="index.php?dl=<?php echo $this->basvuruExcel; ?>" class="btn btn-sm btn-primary">İndir</a>
    </div>
</div>
<?php
}
?>

<form method="post" enctype="multipart/form-data" action="index.php?option=com_belgelendirme_abhibe&task=BasvuruListesiYukle">
<div class="anaDiv">
    <div class="div30 font18 fontBold hColor">
        Başvuru Listesi Yükle
    </div>
    <div class="div70">
        <input type="file" name="excelFile" class="input-sm"/>
    </div>
</div>
<div class="anaDiv">
    <button type="submit" class="btn btn-sm btn-success">Yükle</button>
</div>
</form>