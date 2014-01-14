<?php
/**
 * @package SmartIcons Component for Joomla! 2.5
 * @version $Id: controller.php 12 2012-09-30 21:56:32Z Bobo $
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class SmartIconsController extends JController {
	
	function display($cachable = false, $urlparams = false)
	{
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'Icons'));

		// call parent behavior
		parent::display($cachable, $urlparams);
		
		//Add sub-menu
		SmartIconsHelper::addSubmenu('icons');
	}
}