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

defined('_JEXEC') or die('Restricted access'); 
	global $mainframe, $option;
	$session =& JFactory::getSession();
	$db		=& JFactory::getDBO();
	$count=$session->get( 'count');
	
$menu = &Jsite::getMenu();
$asmenuname = $menu->getActive()->title;
$asshow_menu=$menu->getActive()->query['asshow_menu'];
$asshow_pag=$menu->getActive()->query['asshow_pag'];
//$ascount=$menu->getActive()->query['ascount'];
if($_REQUEST['Itemid']!="")
{$Itemid=$_REQUEST['Itemid'];}
else
{
$Itemid= JRequest::getVar('Itemid');
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
<style>
.testimonial:before, .testimonial:after {
    content: "\201C"!important;
}
.testimonial:after {
    content: "\201D"!important;
	}
	</style>
<script>
function test(){
	<?php if($status->tname==1){ ?>
			name=document.contactform.my_name.value;
				if(name==""){
				document.getElementById('error_name').innerHTML='<span id="error_msg"><b>Please enter your name</b></span>';
				return false;
			}
		<?php
		}
		?>
		<?php if($status->email==1){ ?>
		email=document.contactform.email.value;
		var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
		if(!(pattern.test(email))){
			document.getElementById('error_email').innerHTML='<span id="error_msg"><b> Wrong Email Address</b></span>';
			return false;
		}
		<?php
		}
		?>
		
 }
 function change_div(id){
		document.getElementById(id).innerHTML="";
	}
</script>

<?php 
/*------------------------------------------------------------------------
SHOW TESTIMONIAL 
-------------------------------------------------------------------------*/
?>

	<div id="#showTestimonials">
	<?php
	if($asshow_menu){ ?>
	<h2><?php echo $asmenuname; ?></h2>
	<?php } ?>
			<?php

				$db				=& JFactory::getDBO();
				for ($i = 0, $j = count($this->items); $i < $j; $i++)
				{
					$row 	=& $this->items[$i];
				?>
			<blockquote class="testimonial">
			<p><?php echo stripcslashes($row->testimonial ); ?></p>
			</blockquote>
	<div class="arrow-down"></div>
	<p class="testimonial-author"><?php echo stripcslashes($row->name ); ?></p>
				
				<?php
				}
				?>
			
	</div>
	<?php
	if($asshow_pag){
	?>
	<div class="faderPag">
	<?php
	$itemid=$this->itemid;
	$limit=$this->limit;
	$total=$this->total;
	$ptot=(int)$total/$limit;
	$prem=$total%$limit;
	if($prem){
	$ptot=$ptot+1;
	} ?>
		<ul>
		<?php
		for($i=1;$i<=$ptot;$i++)
		{ ?>
			<li>
			<a href="<?php echo JRoute::_('index.php?option=com_testimonial_fader&view=addshow&limitstart='.($i-1)*$limit.'&Itemid='.$itemid);?>"><?php echo $i;?></a>
			</li>
		<?php }
		?>
		</ul>
	</div>
	<?php
	}
	?>
<div class="clear"></div>

<?php 
/*------------------------------------------------------------------------
ADD TESTIMONIAL 
-------------------------------------------------------------------------*/
?>


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
	<div><img src="<?php echo JURI::base();?>index.php?option=com_testimonial_fader&view=addshow&task=captcha&tmpl=component<?php echo rand(5, 1000)?>"/></div>
	<div class="faderSecurityTxt"><input type="text" name="security_code" value="" autocomplete="off"/></div>
	<div class="faderSubmit"><input type="submit" name="save" value="Submit" class="submit">
	<input type="reset" name="clear" value="Clear" class="submit" onclick="history.go(0)"/></div>
	
	
	<input type="hidden" name="Itemid" value="<?php	echo $Itemid ?>" class="submit"/>
	<input type="hidden" name="count" value="<?php	echo $this->count; ?>" class="submit"/>
	<input type="hidden" name="option" value="com_testimonial_fader" />
	<input type="hidden" name="task" value="save_addshow" />
	<input type="hidden" name="view" value="addshow" />
	<input type="hidden" name="id" value="<?php echo $row->id ; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="hidden_code" value="<?php echo $session->get(code);?>" />
	</form>
</div>