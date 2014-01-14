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
abstract class Testimonial_faderHelper
{
	
		public static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('Testimonial_fader'),
			'index.php?option=testimonial_fader',
			$vName == 'Testimonial_fader'
		);
	}

}
