<?php
/*------------------------------------------------------------------------
# com_testimonial_fader - Testimonial Fader
# ------------------------------------------------------------------------
# author    Infyways Solutions
# copyright Copyright (C) 2012 Infyways Solutions. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.infyways.com
# Technical Support:  Forum - http://support.infyways/com
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
	global $mainframe, $option;
	$session =& JFactory::getSession();
	$document = JFactory::getDocument();
	$document->addStyleSheet(JURI::base().'components/com_testimonial_fader/css/style.css');
	$document->addScript(JURI::base().'components/com_testimonial_fader/js/messages.js');
	$menu = &Jsite::getMenu();
	$menuname = $menu->getActive()->title;
	$Itemid=$_REQUEST['Itemid'];
	
	if($Itemid=="")
	{
	$Itemid=$session->get('Itemid');
	
	}
	function generateCode($characters) {
		// list all possible characters, similar looking characters and vowels have been removed 
		$possible = '23456789bcdfghjkmnpqrstvwxyz';
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		$session =& JFactory::getSession();
		$session->set('code',$code);
			return $code;
	}
 generateCode(5);
	?>
	<script>
function clear_ses()
{
var form=document.contactform;
my_name.value="";
email.value="";
testimonial.value="";
return false;
}
</script>

<h2><?php echo $menuname; ?></h2>

<div id="faderAdd">
<form method="post" action="<?php echo JURI::base();?><?php echo('index.php?option=com_testimonial_fader&Itemid='.$Itemid.''); ?>"
			 name="contactform" id="contactform"
			 onsubmit="return valid(this);">

<div class="faderName"><?php echo JText::_( 'COM_TESTIMONIAL_FADER_NAME'); ?> </div>
<div class="faderNameTxt"><input type="text" name="my_name" id="my_name" value="<?php echo $session->get(name);?>"/></div>
<div class="faderEmail"> <?php echo JText::_( 'COM_TESTIMONIAL_FADER_EMAIL'); ?> </div>
<div class="faderEmailTxt"><input type="text" name="email" id="email" value="<?php echo $session->get(email);?>"/></div>
<div class="faderWrite"> <?php echo JText::_( 'COM_TESTIMONIAL_FADER_WRITE'); ?></div>
<div class="faderWriteTxt"><textarea name="testimonial"><?php echo stripcslashes($session->get(testimonial));?></textarea></div>
 <?php
	$session->clear(name);
	$session->clear(email);
	$session->clear(testimonial);
	?>
	<div><img src="<?php echo JURI::base();?>index.php?option=com_testimonial_fader&view=testimonial_fader&task=captcha&tmpl=component<?php echo rand(5, 1000)?>"/></div>
	<div class="faderSecurityTxt"><input type="text" name="security_code" value="" autocomplete="off"/></div>
	<div class="faderSubmit"><input type="submit" name="save" value="Submit" class="submit">
	<input type="reset" name="clear" value="Clear" class="submit" onclick="history.go(0)"/></div>
	<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>"class="submit"/>
	<input type="hidden" name="option" value="com_testimonial_fader" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="view" value="testimonial_fader" />
	<input type="hidden" name="boxchecked" value="0" />
	
<input type="hidden" name="hidden_code" value="<?php echo $session->get(code);?>" />
	</form>
	</div>