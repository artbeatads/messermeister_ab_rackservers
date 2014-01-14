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
$edit=$this->edit[0];
if(!empty($edit))
{
JToolBarHelper::title(JText::_('Edit Testimonial '), 'testimonial');
JToolBarHelper::addNew('addnew');
}
else
{
JToolBarHelper::title(JText::_('Add Testimonials '), 'testimonial');
}
JToolBarHelper::apply('save_tf', 'JTOOLBAR_APPLY');
JToolBarHelper::cancel('cancel_tf', 'JTOOLBAR_CANCEL');
JToolBarHelper::preferences( 'com_testimonial_fader', 450 );
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$user=$this->user;

$msg=$_REQUEST['msg'];
$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_testimonial_fader/assets/css/testimonial_fader.css' );
?>
<script type="text/javascript">
Joomla.submitbutton = function(task) { 
 var form=document.adminForm;
 var name=form.name.value;
var email=form.email.value;
var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
		if (task == 'cancel_tf') 
			{
			Joomla.submitform('cancel_tf',document.adminForm);
			return;
			}
		else if(name=="")
		{
		alert("Name can't be blank");
		form.name.focus();
		return false;
		}
		else if(!(pattern.test(email))){
		alert("Please enter a correct email address");
		form.email.focus();
		}
	else if (task == 'addnew') 
			{
			Joomla.submitform('addnew',document.adminForm);
			return;
			}
	else
	{
		Joomla.submitform('save_tf',document.adminForm);
	}
}
</script>
<div id="testimonial_edit">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<form action="index.php?option=com_testimonial_fader" method="post" name="adminForm" enctype="multipart/form-data"><!-- Deafult message -->
<?php
echo $_REQUEST['msg'];
?>
  <tr>
  <td> Name</td>
    <td align="left" valign="top"><input type="text" name="name" value="<?php echo $edit->name ?>"/></td>
  </tr>
   <td> Email</td>
    <td align="left" valign="top"><input type="text" name="email" value="<?php echo $edit->email ?>"/></td>
  </tr>
  <tr>
    <td> Testimonial</td>
    <td align="left" valign="top">
	<textarea name="testimonial"><?php echo $edit->testimonial;?></textarea></td>
  </tr>
   <tr>
    <td>Status</td>
    <td align="left" valign="top">
	<select name="publish" id="publish">
	<option value="1" <?php if($edit->publish==1){echo 'selected="selected"';}?>>Published</option>
	<option value="0" <?php if($edit->publish==0){echo 'selected="selected"';}?>>Unpublished</option>
	</td>
  </tr>
   	<input type="hidden" name="option" value="com_testimonial_fader" />
	<input type="hidden" name="task" value="save_tf" />
	<input type="hidden" name="view" value="testimonial_fader" />
	<input type="hidden" name="id" value="<?php echo $edit->id ?>"/>
	<input type="hidden" name="boxchecked" value="0" />
  </form>
  </table>
  </div>
