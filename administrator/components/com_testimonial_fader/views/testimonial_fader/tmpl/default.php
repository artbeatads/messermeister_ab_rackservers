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
JToolBarHelper::title(JText::_('Testimonial Fader '), 'testimonial');
//JToolBarHelper::preferences('com_testimonial_fader');
	JToolBarHelper::addNew('addnew');
	JToolBarHelper::publishList();
	JToolBarHelper::unpublishList();
	JToolBarHelper::deleteList('Delete','delete','Delete');
	JToolBarHelper::preferences( 'com_testimonial_fader', 450 );
	$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_testimonial_fader/assets/css/testimonial_fader.css' );
	
?>

<form action="index.php?option=com_testimonial_fader" method="post" name="adminForm" id="adminForm">
<!-- Deafult administrator message -->
<table>
		<tr>
			<td width="100%">  <?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_type').value='0';this.form.getElementById('filter_logged').value='0';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
		  </td>
			<td nowrap="nowrap">
			</td>
		</tr>
</table>

<table class="adminlist" cellpadding="0" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th style="text-align:left" width="3%" class="title">
					<?php echo JText::_( '#' ); ?>
				</th>
				<th style="text-align:left" width="5%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
				</th>
				<th style="text-align:left" width="20%" class="title" nowrap="nowrap">
					<?php echo JText::_( 'Name'); ?>
				</th>
				<th style="text-align:left" width="25%" class="title" nowrap="nowrap">
					<?php echo JText::_( 'Email');?>
				</th>
					<th style="text-align:left" width="45%" class="title" nowrap="nowrap">
					<?php echo JText::_( 'Testimonial');?>
				</th>
				<th  class="title" width="4%" nowrap="nowrap">
					<?php echo JText::_( 'Published' );  ?>
				</th>
				
			</tr>
		</thead>
		
		<tbody>
		<?php
		
			$k = 0;
			$db				=& JFactory::getDBO();
			$n=$this->limitstart;
			for ($i = 0, $j = count($this->items); $i < $j; $i++)
			{
				$row 	=& $this->items[$i];
			
				if($row->published==0)
				$img 	= $row->published ? 'publish_x.png' : 'tick.png';
				$task 	= $row->published ? 'unpublish' : 'publish';
				$alt 	= $row->published ? JText::_( 'Enabled' ) : JText::_( 'Blocked' );
				$published 	= JHTML::_('grid.published', $row, $i );
			
			$link=JRoute::_('index.php?option=com_testimonial_fader&amp;view=testimonial_fader&amp;layout=edit&amp;id='. $row->id. '');	
					
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo  $n+1;?> 
				</td>
				
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->id ); ?>
				</td>
				
				<td>
					<a href="<?php echo $link; ?>">
						<?php echo stripcslashes($row->name ); ?></a>
				</td>
				<td>
					<a href="<?php echo $link; ?>">
						<?php echo stripcslashes($row->email ); ?></a>
				</td>
		
				<td>
						<a href="<?php echo $link; ?>">
					<?php echo(substr($row->testimonial,0,90)); ?></a>
				</td>
				<td>
				<?php
				if($row->publish)
				{
				echo '<a href="javascript:void(0);" onclick="return listItemTask(\'cb'.$i.'\',\'unpublish\')" title="publish Item"><img src="components/com_testimonial_fader/images/tick.png" alt="Published" border="0"></a>';
				}
				else
				{
				echo '<a href="javascript:void(0);" onclick="return listItemTask(\'cb'.$i.'\',\'publish\')" title="Unpublish Item">
		<img src="components/com_testimonial_fader/images/publish_x.png" alt="Unpublished" border="0"></a>';
				}
				
				 ?>
			</td>		
			</tr>
			<?php
				$k = 1 - $k;
				$n++;
				}
			?>
		</tbody>
      <tbody>
        <tr>
          <td width="100%" colspan="11"><?php echo $this->pageNav->getListFooter('pages'); ?> </td></tr>
      </tbody>
		
  </table>
	<input type="hidden" name="option" value="com_testimonial_fader" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="view" value="testimonial_fader" />
	<input type="hidden" name="id" value="<?php echo $row->id;?>" />
	<input type="hidden" name="Itemid" value="<?php echo $_REQUEST['Itemid'];?>" />
	<input type="hidden" name="boxchecked" value="0" />
</form>