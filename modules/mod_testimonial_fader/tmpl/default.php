<?php
/*------------------------------------------------------------------------
# mod_testimonial_fader - Testimonial Fader
# ------------------------------------------------------------------------
# author    Infyways Solutions
# copyright Copyright (C) 2012 Infyways Solutions. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.infyways.com
# Technical Support:  Forum - http://support.infyways/com
-------------------------------------------------------------------------*/
// no direct access

defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
$base_url=JURI::root();
$document->addStyleSheet('modules/mod_testimonial_fader/tmpl/css/fader.css');
if($tfont!='user'){
$document->addStyleSheet('http://fonts.googleapis.com/css?family='.$tfont.'');
}
if($jsfiles==1)
{
	if($load1==1)
	{
	$document->addScript("modules/mod_testimonial_fader/tmpl/js/jquery.js");
	} 
	$document->addScript("modules/mod_testimonial_fader/tmpl/js/jquery.innerfade.js");
	$document->addCustomTag("<script type='text/javascript'> var jax = jQuery.noConflict();
	jax(document).ready( function()	{jax('#ftestimonial$module->id').innerfade({ animationtype: '$animation', speed: $speed, timeout: $timeout, type: '$show_type',containerheight:'$height' });} ); 
</script>");
}
else
{
	if($load1==1)
	{
	echo '<script src="'.$base_url.'modules/mod_testimonial_fader/tmpl/js/jquery.js" type="text/javascript"></script>';
	}
	echo<<<MYSCRIPT
	<script type='text/javascript'> var jax = jQuery.noConflict();
	jax(document).ready( function()	{jax('#ftestimonial$module->id').innerfade({ animationtype: '$animation', speed: $speed, timeout: $timeout, type: '$show_type',containerheight:'$height' });} ); 
</script>
MYSCRIPT;
}
?>
<style type='text/css'>
<?php if($quote!='none'){?>
#fquote-<?php echo $module->id;?>{
background: url("<?php echo $base_url;?>modules/mod_testimonial_fader/tmpl/images/<?php echo $quote_style;?>/left-<?php echo $quote;?>.png") no-repeat scroll left top transparent!important;
padding: <?php if($quote_style=='style1') { ?>5px 0 0 35px !important;<?php } else { ?>2px 0 0 25px !important;<?php } ?>
}
<?php } ?>
#fader-<?php echo $module->id;?> span{
<?php if($quote!='none'){?>
background: url("<?php echo $base_url;?>modules/mod_testimonial_fader/tmpl/images/<?php echo $quote_style;?>/right-<?php echo $quote;?>.png") no-repeat scroll right bottom transparent; 
padding: <?php if($quote_style=='style1') { ?>5px 40px !important;<?php } else { ?>2px 25px !important;<?php } ?>
<?php } ?>
font-size:<?php echo $asize;?>px;
color:<?php echo $acolor;?>;
font-weight:<?php echo $aweight;?>;
float:right; 
}
</style>

<div id="fader-<?php echo $module->id;?>">
<?php if($quote!='none'){?>
<div id="fquote-<?php echo $module->id;?>">
<?php } ?>


	<ul id="ftestimonial<?php echo $module->id;?>">
<?php 
	if($source=='component')
	{	
		foreach ($list as $row) 
		{
		?>
		<li><p><?php echo $row->testimonial;?><br/><span><?php echo $row->name;?></span></p></li>
		<?php 
		}
	}
	else
	{
		$testimonial=explode('/',$testimonials);
		$author=explode('/',$authors);
		for($i=0;$i<count($testimonial);$i++)
		{
		?>
			<li><p><?php echo $testimonial[$i];?><br><span><?php echo $author[$i];?></span></p></li>
		<?php
		}
	}
?>
	</ul>
	<?php if($quote!='none'){?>
</div>
<?php } ?>
</div>