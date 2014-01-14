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
$version=(float)JVERSION;
$version=(int)($version*10);
if($version==15)
{
	class JElementColorpicker extends JElement
	{
		var	$_name = 'Colorpicker';

		function fetchElement($name, $value, &$node, $control_name){
			
			//try to find script
			$baseurl = JURI::base();
			$baseurl = str_replace('administrator/','',$baseurl);
					
			$size = $node->attributes('size') ? 'size="'.$node->attributes('size').'"' : '';
			$class = $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="text_area"';
			$scriptname = $node->attributes('scriptpath') ? $node->attributes('scriptpath') : $baseurl.'modules/mod_testimonial_fader/admin/elements/color-picker.js';	
			
			if($scriptname == 'self')
			{
			   $filedir = str_replace(JPATH_SITE . '/','',dirname(__FILE__));
			   $filedir = str_replace('\\','/',$filedir);
			   $scriptname = $baseurl . $filedir . '/color-picker.js';
			}
			
			$doc =& JFactory::getDocument();
			$doc->addScript($scriptname);
			
			$options = array();
			if( $node->attributes('cellwidth')){ $options[] = "cellWidth:". (int)$node->attributes('cellwidth');}
			if( $node->attributes('cellheight')){ $options[] = "cellHeight:".(int)$node->attributes('cellheight');}
			if( $node->attributes('top')){ $options[] = "top:". (int)$node->attributes('top');}
			if( $node->attributes('left')){ $options[] = "left:". (int)$node->attributes('left');}
																				  
			$optionString = implode(',',$options);

			$js = 'window.addEvent(\'domready\', function(){
			var colorInput = $(\''.$control_name.$name.'\');
			var cpicker = new ColorPicker(colorInput,{'.$optionString.'});
	});
	';

			$doc->addScriptDeclaration($js);
			$value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES), ENT_QUOTES);

			$output = '<input type="text" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" '.$class.' '.$size.' />';
			
			return $output;
		}
	}
}
else
{
	jimport('joomla.form.formfield');
	class JFormFieldColorpicker extends JFormField
	{
		protected $type = 'Colorpicker';
		protected function getInput()
		{
			$baseurl = JURI::base();
			$baseurl = str_replace('administrator/','',$baseurl);	
			$size		= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
			$maxLength	= $this->element['maxlength'] ? ' maxlength="'.(int) $this->element['maxlength'].'"' : '';
			$class		= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
			$readonly	= ((string) $this->element['readonly'] == 'true') ? ' readonly="readonly"' : '';
			$disabled	= ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';
			$scriptname	 = $this->element['scriptpath'] ?(string) $this->element['scriptpath'] : $baseurl.'modules/mod_testimonial_fader/admin/elements/color-picker.js';
			if($scriptname == 'self')
			{
			   $filedir = str_replace(JPATH_SITE . '/','',dirname(__FILE__));
			   $filedir = str_replace('\\','/',$filedir);
			   $scriptname = $baseurl . $filedir . '/color-picker.js';
			}
			$doc =& JFactory::getDocument();
			$doc->addScript($scriptname);
			$options = array();
			if( $this->element['cellwidth']){ $options[] = "cellWidth:". (int) $this->element['cellwidth'];}
			if( $this->element['cellheight']){ $options[] = "cellHeight:".(int) $this->element['cellheight'];}
			if( $this->element['top']){ $options[] = "top:". (int) $this->element['top'];}
			if( $this->element['left']){ $options[] = "left:". (int) $this->element['left'];}
																				  
			$optionString = implode(',',$options);

			$js = 'window.addEvent(\'domready\', function(){
			var colorInput = $(\''.$this->id.'\');
			var cpicker = new ColorPicker(colorInput,{'.$optionString.'});
	});
	';
			$doc->addScriptDeclaration($js);
			$onchange	= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';

			return '<input type="text" name="'.$this->name.'" id="'.$this->id.'"' .
					' value="'.htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8').'"' .
					$class.$size.$disabled.$readonly.$onchange.$maxLength.'/>';
		}
	}
}
