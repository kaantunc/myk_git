<?php 
$sektorSorumlusu = $this->sektorSorumlusu;
?>

<form
<?php 
$task = "task=taslakKaydet";
echo 'action="index.php?option=com_meslek_std_taslak&amp;layout=ekipman&amp;'.$task.'&amp;standart_id='.$this->standart_id.'"'	
?>
	onSubmit = "return validate('ChronoContact_meslek_std_taslak')"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_meslek_std_taslak"
	name="ChronoContact_meslek_std_taslak">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
echo $this->pageTree;
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">3.2.	Kullanılan Araç, Gereç ve Ekipman</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>


<div id="topluEkleDiv" style="border: 1px solid #00A7DE; padding: 10px; width:600px;height:500px;display:none;background-color: white;">
<textarea id="topluEkleText" cols="82" rows="30"></textarea>
<input type="button" id="ekleButton" value="Listeye Ekle" />
</div>
<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="ekipman_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
<div style="padding-left: 25px;;"><a id="topluEkleLink" href="#">Toplu Ekle</a></div>

<?php 
if ($this->canEdit){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Kaydet" name="kaydet" type="submit" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}

echo $this->yorumDiv;

if ($this->sektorSorumlusu && $this->yorumDiv!=""){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('ekipman', <?php echo $this->standart_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>

</form>

<script type="text/javascript">
<?php 
if ($this->canEdit)
	echo "var isReadOnly = false;";
else
	echo "var isReadOnly = true;";
?>
var readOnly = null;
if (isReadOnly)
	readOnly = "readOnly";
		
dTables.ekipman = new Array(new Array("text","","4","", readOnly),	
						    new Array("text","required", "100","", readOnly));

function createTables(){
	var tableName = 'ekipman';
	var headers = new Array ('Sıra No', 'Ekipman Adı');
	createTable(tableName, headers);
	patchSatirEkle(tableName, headers, tableName);
	addEkipmanValues (dTables.ekipman, tableName);

	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 2);
	}
}

function addEkipmanValues (ekipman, name){
	var length = ekipman.length;
	var params = new Array ();
    var arrId= new Array();
    var arr = new Array();
	
	for (var i = 0; i < length; i++){
		params[i] = ekipman[i][0];
	}
	<?php
	$tableCount = count ($this->ekipman);

	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $this->ekipman[$i];
		echo 'arrId['.$id++.']= "'. $arr["EKIPMAN_ID"] .'";';
		
		echo 'arr['.$c++.']= "'. ($i+1) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["EKIPMAN_ADI"]) .'";';
        
	}
	echo "window.count=".$c.";";
    
	?>
    window.arrid=arrId;
	if (isset (arr))
		addTableValues (arr, arrId, params, name);
}
jQuery('#topluEkleLink').click(function(e) {
    jQuery('#topluEkleDiv').lightbox_me({
        centered: true, 
        });
    e.preventDefault();
});

jQuery('#ekleButton').click(function(e) {
    text=jQuery("#topluEkleText").val ();
    text=text.replace("\r\n","\n");
    text=text.split("\n");
  var ekipman = dTables.ekipman;
	var length = ekipman.length;
	var params = new Array ();
	var veri    = new Array ();
	var arr    = new Array ();
	for (var i = 0; i < length; i++){
		params[i] = ekipman[i][0];
	}
	id = -1;
    for (i=1;i<500;i++){
        if (jQuery("#inputekipman-2-"+i).val()!=null){
            veri.push(jQuery("#inputekipman-2-"+i).val());
        }
    }
	var adet = text.length;
    for (j=0;j<adet;j++){
        if (text[j].replace(" ","")!=""){
            yenitext=text[j].split(". ");
            if (yenitext.length>1){
                yenitext1="";
                for (i=1;i<yenitext.length;i++){
                    yenitext1=yenitext1+yenitext[i]+". "
                }
                yenitext1=rtrim(yenitext1,". ");
            } else {
                yenitext1=text[j];
            }
            veri.push(trim(yenitext1)) ;
        }
        window.arrid.push("");
    }
    for(k=0;k<veri.length;k++){
        arr.push(k+1);
        arr.push(veri[(k)]);
    }
	addTableValues (arr, window.arrid, params, "ekipman");

});

</script>