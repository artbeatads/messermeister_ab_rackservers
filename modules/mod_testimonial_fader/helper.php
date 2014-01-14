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

defined('_JEXEC') or die;
	abstract class modTestiHelper
	{
		public static function getTesti()
		{
			$app	= JFactory::getApplication();
			$db		= JFactory::getDbo();
			$user	=JFactory::getUser();

			$query = "select * from #__testimonial where publish=1";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return $rows;
		}
	}
