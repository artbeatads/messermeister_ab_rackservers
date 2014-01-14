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
$version=(float)JVERSION;
$version=(int)($version*10);
if($version==15)
{
	jimport('joomla.html.parameter.element');
	class JElementAsset extends JElement {
	function fetchElement($name, $value, &$node, $control_name){
			$doc = JFactory::getDocument();
			  $doc->addScript(JURI::root()."modules/mod_testimonial_fader/admin/".'script.js');
			 $doc->addStyleSheet(JURI::root()."modules/mod_testimonial_fader/admin/".'style.css');        
			return null;
		}
	}
}
else
{
	jimport('joomla.form.formfield');
	class JFormFieldAsset extends JFormField {
		protected $type = 'Asset';
		protected function getInput() {
			$doc = JFactory::getDocument();
			  $doc->addScript(JURI::root().$this->element['path'].'script.js');
			 $doc->addStyleSheet(JURI::root().$this->element['path'].'style.css');        
			return null;
		}
	}
}
