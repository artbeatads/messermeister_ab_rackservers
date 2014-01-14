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

jimport('joomla.form.formfield');
class JFormFieldHeader extends JFormField {

	var	$type = 'header';

	function getInput(){
		return JElementHeader::fetchElement($this->name, $this->value, $this->element, $this->options['control']);
	}

	function getLabel(){
		return '';
	}

}

jimport('joomla.html.parameter.element');

class JElementHeader extends JElement {

	var	$_name = 'header';
	function fetchElement($name, $value, &$node, $control_name){
		return '<div id="paramHeader">'.JText::_($value).'</div>';
	}
}
