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

/**
 * Testimonial_fader helper.
 */
class Testimonial_faderHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{
	JSubMenuHelper::addEntry(
		JText::_('Testimonial'),
		'index.php?option=com_testimonial_fader&view=testimonial_fader',
		$vName == 'testimonial_fader'
		);
		JSubMenuHelper::addEntry(
		JText::_('Css'),
		'index.php?option=com_testimonial_fader&view=css',
		$vName == 'css'
		);
	}
	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_testimonial_fader';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
}