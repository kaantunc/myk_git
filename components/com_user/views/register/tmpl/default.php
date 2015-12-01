<?php
/**
* @title		Shape 5 S5 Register - Joomla 1.5
* @version		1.0
* @package		Joomla
* @website		http://www.shape5.com
* @copyright	Copyright (C) 2009 Shape 5 LLC. All rights reserved.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<script type="text/javascript">

function passwdcheck(){
	var re = /^(?=.*[A-Za-z])(?=.*[0-9])(?!.*\s).{8,15}$/;///^\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*$/;
	var pswd = document.getElementById("password").value;
	
	if (pswd.length<8) {
		alert('PAROLANIZ 8 KARAKTERDEN KISA OLAMAZ...');
		return false;
	}
	else if (!re.test(pswd))
	{	
		jQuery("#showhint").show();
		alert('GiRiLEN PAROLA KRiTERLERE UYMUYOR...');
		return false;
	}
}
</script>									
<style>
.labeldiv{
	float:left;
	width:200px;
	line-height:31px;
}
</style>
<br/>
<br/>
<?php echo JText::_( "REGISTER_INFO");?>:
<br><br>
<form class="form-validate" name="josForm" id="josForm" method="post" action="<?php echo JRoute::_( 'index.php?option=com_user' ); ?>" onsubmit="return passwdcheck()">
<p id="form-register-usertype">
	<label for="modlgn-usertype" style="font-weight: bold;"><?php echo JText::_('MOD_REGISTER_VALUE_USERTYPE') ?></label>			
	<div>
		<label style="display: block;"><input type="radio" value="1" name="active" class="userTypeChangee" /> Kurum/Kuruluş</label>
		<label><input type="radio" value="3" name="active" class="userTypeChangee" /> Teknik Uzman ya da Denetçi</label>
	</div>
</p>
<div id="register-div" style="display: none;width:450px;">
	<div class="labeldiv">
		<label for="name" id="namemsg" class="kurumm"><?php echo JText::_( "Name_kurum");?>:</label>
		<label for="name" id="namemsg" class="sahiss"><?php echo JText::_( "Name_sahis");?>:</label>
	</div>		
	<div style="float:left;">
		<input type="text" maxlength="250" class="inputbox required" value="" size="30" id="name" name="name"/>*
	</div>
	<div style="clear:both;"></div>
	
	<div class="labeldiv">
		<label for="username" id="usernamemsg" class="kurumm"><?php echo JText::_( "Username_kurum");?>:</label>
		<label for="username" id="usernamemsg" class="sahiss"><?php echo JText::_( "Username");?>:</label>
	</div>
	<div style="float:left;">
			<input type="text" maxlength="35" class="inputbox required validate-username" value="" size="30" name="username" id="username"/>*
	</div>
	<div style="float:left;width:258px;line-height:31px;padding-left:120px;">
			<label for="email exp" id="emailexp" class="kurumm">
				<?php echo "(".JText::_( "SHORT NAME KURUM").")";?>
			</label>
	</div>	
	<div style="clear:both;"></div>	
	
	<div class="labeldiv">
			<label for="email" id="emailmsg">
				<?php echo JText::_( "E-mail");?>:
			</label>
	</div>
	<div style="float:left;">
			<input type="text" maxlength="150" class="inputbox required validate-email" value="" size="30" name="email" id="email"/>*
	</div>
	
	<div style="float:left;width:258px;line-height:31px;padding-left:120px;">
			<label for="email exp" id="emailexp">
				<?php echo "(".JText::_( "E-MAIL EXP").")";?>
			</label>
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="labeldiv">
			<label for="password" id="pwmsg">
				<?php echo JText::_( "Password");?>:<img src="images/question_button1.png" onclick="jQuery('#showhint').show();">
			</label>
	</div>
	<div style="float:left;">
	  		<input type="password" value="" size="30" name="password" id="password" class="inputbox required validate-password"/>*
	</div>
	
	
	<div style="clear:both;"></div>
	
	
	<div class="labeldiv">
			<label for="password2" id="pw2msg">
				<?php echo JText::_( "Verify Password");?>:
			</label>
	</div>
	<div style="float:left;">
			<input type="password" value="" size="30" name="password2" id="password2" class="inputbox required validate-passverify"/>*
	</div>
	<div style="clear:both;"></div>
	<br/>
		<?php echo JText::_( "Fields marked with an asterisk (*) are required.");?>
		<span style="display:none;" id="showhint"><?php echo "".JText::_( "PASSWORD EXP")."";?></span>
	<br/><br/>
		<button type="submit" class="button validate"><?php echo JText::_( "Register");?></button>
		<input type="hidden" value="register_save" name="task"/>
		<input type="hidden" value="0" name="id"/>
		<input type="hidden" value="0" name="gid"/>
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
</div>				


<script>

jQuery('.userTypeChangee').click(function(e){
	
	jQuery('#register-div').show();

	if (jQuery(this).val()=='1'){
		jQuery("label.kurumm").show();
		jQuery("label.sahiss").hide();
	}else if (jQuery(this).val()=='3'){
		jQuery("label.sahiss").show();
		jQuery("label.kurumm").hide();
	}
});


</script>