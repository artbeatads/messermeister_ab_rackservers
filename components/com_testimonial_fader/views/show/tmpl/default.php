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
$menu = &Jsite::getMenu();
$menuname = $menu->getActive()->title;
$show_menu=$menu->getActive()->query[show_menu];
$show_pag=$menu->getActive()->query[show_pag];
$count=$menu->getActive()->query[count];
?>	
<style>
.testimonial:before, .testimonial:after {
    content: "\201C"!important;
}
.testimonial:after {
    content: "\201D"!important;
	}
	</style>	
	<div id="#showTestimonials">
	<?php
	if($show_menu){ ?>
	<h2><?php echo $menuname; ?></h2>
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
if($show_pag){ ?>
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
<a href="<?php echo JRoute::_('index.php?option=com_testimonial_fader&view=show&limitstart='.($i-1)*$limit.'&Itemid='.$itemid);?>"><?php echo $i;?></a>
</li>
<?php }
?>
</ul>
</div>
<?php } ?>
