<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<div id="changePasswordForm">
    <form>
<table cellpadding="5" cellspacing="0" border="0" width="100%">
<tr>
	<td>
		<label for="password">
			<?php echo JText::_( 'Current Password' ); ?>:
		</label>
	</td>
	<td>
    <input name="varolan" id="varolan" type="password" class="inputbox validate-passverify" />
	</td>
</tr>
<tr>
	<td>
		<label for="newPassword">
			<?php echo JText::_( 'New Password' ); ?>:
		</label>
	</td>
	<td>
    <input name="yeni" id="yeni" type="password" class="inputbox validate-passverify" />
	</td>
</tr>
<tr>
	<td>
		<label for="password2">
			<?php echo JText::_( 'Verify New Password' ); ?>:
		</label>
	</td>
	<td>
    <input name="tekrar" id="tekrar" type="password" class="inputbox" />
	</td>
</tr>
<tr>
	<td>
		<label>
			
		</label>
	</td>
	<td>
    <input type="button" class="button" id="submitButton" onclick="degistir();" value="Değiştir" />
	</td>
</tr>
</table>
</form>
</div>

<script>
function sifreDegistirValidator(a,b,c){
    var a=jQuery("#"+a);
    var b=jQuery("#"+b);
    var c=jQuery("#"+c);
    re=/(?=.*\d)(?=.*[a-zçşğüöı])(?=.*[A-ZÇŞĞÜÖİ])(?=.*[A-ZÇŞĞÜÖİ]).{8,}/;
	if (a.val().length<1) {
	    jQuery(b).css( "border-color", "red" ); 
		alert("Lütfen, Geçerli şifrenizi yazınız.");
		return false;
	} else
		if (b.val().length<1) {
		    jQuery(b).css( "border-color", "red" ); 
			alert("Lütfen, yeni şifrenizi yazınız.");
			return false;
		} else
	    	if (!re.test(b.val())) {
	    jQuery(b).css( "border-color", "red" ); 
		alert("Şifreniz en az bir rakam, bir büyük, bir küçük harf içermeli ve en az 8 karakter olmalı.");
		return false;
	} else
	if (c.val().length<1) {
	    jQuery(c).css( "border-color", "red" ); 
		alert("Lütfen, yeni şifrenizi tekrar yazınız.");
		return false;
	} else
	if (b.val()!=c.val()) {
	    jQuery(b).css( "border-color", "red" ); 
	    jQuery(c).css( "border-color", "red" ); 
		alert("Girdiğiniz şifreler aynı olmalı.");
		return false;
	}
    return true;
    
}
 function degistir(){
    var a=jQuery("#varolan").val();
    var b=jQuery("#yeni").val();
    var c=jQuery("#tekrar").val();
    
    if(sifreDegistirValidator('varolan','yeni','tekrar')){
    	jQuery("#changePasswordForm").html("<p align=center>Lütfen bekleyiniz.</p>");
    	var url="index.php?option=com_user&task=ajaxChangePassword&format=raw";
    	jQuery.post(
            url,
            {varolan:a,yeni:b}, 
            function(data) {
//                return (data);
                jQuery("#changePasswordForm").html(data);
        	}
        );
    }
};

jQuery("#varolan").focus(function(){ jQuery("#varolan").css( "border-color", "#CDCDCD" );});
jQuery("#yeni").focus(function(){ jQuery("#yeni").css( "border-color", "#CDCDCD" );});
jQuery("#tekrar").focus(function(){ jQuery("#tekrar").css( "border-color", "#CDCDCD" );});


</script>