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

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
$version=(float)JVERSION;
$version=(int)($version*10);
if($version==15)
{
	jimport('joomla.html.parameter.element');
	class JElementUtility extends JElement {
	function fetchElement($name, $value, &$node, $control_name){
			$doc = JFactory::getDocument();
			  $doc->addScript(JURI::root()."modules/mod_testimonial_fader/admin/".'jquery.min.js');
			 $doc->addScript(JURI::root()."modules/mod_testimonial_fader/admin/".'admin_script15.js');        
			return null;
		}
	}
}
else
{
	jimport('joomla.form.formfield');
	class JFormFieldUtility extends JFormField
	{
		protected  $type = 'Utility';
		protected function getInput()
		{
			$doc =& JFactory::getDocument();
			$doc->addScript(JURI::root(true).'/modules/mod_testimonial_fader/admin/jquery.min.js');
			$doc->addScript(JURI::root(true).'/modules/mod_testimonial_fader/admin/admin_script25.js');
		}
		protected function getLabel()
		{
			return '';
		}
	}
}


