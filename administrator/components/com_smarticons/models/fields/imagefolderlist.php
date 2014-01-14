<?php
/**
 * @package SmartIcons Component for Joomla! 2.5
 * @version $Id: activemedia.php 9 2012-03-28 20:07:32Z Bobo $
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Based on the media field from the Joomla.Platform
 * Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 **/

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('groupedlist');

class JFormFieldImageFolderList extends JFormFieldGroupedList {
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'ImageFolderList';

	protected function getGroups() {
		// Initialize variables.
		$options = array();
		$groups	= array();
		$joomlaImageFolder = JComponentHelper::getParams('com_media')->get('image_path', 'images');

		$groups["SmartIcons"] = array();
		$groups["SmartIcons"][] = JHtml::_('select.option', JPATH_ROOT . '/media/com_smarticons', 'SmartIcons media folder');

		$groups["Images"] = array();
		$groups["Images"][] = JHtml::_('select.option', JPATH_ROOT . $joomlaImageFolder, 'Joomla image folder');
		$groups["Images"] = array_merge($groups["Images"], $this->getFolders('images', '', 3));

		$rootFolders = $this->getFolders('', 'administrator|cache|cli|components|images|includes|language|libraries|logs|media|modules|plugins|templates|tmp');

		if (is_array($rootFolders) && (0 < count($rootFolders))) {
			$groups["Root folder"] = array();
			$groups["Root folder"] = $rootFolders;
		}

		$groups = array_merge(parent::getGroups(), $groups);

		return $groups;
	}

	protected function getFolders($path, $exclude = "", $depth = false) {
		$options = array();

		if (!is_dir($path))
		{
			$path = JPATH_ROOT . DIRECTORY_SEPARATOR . $path;
		}
		
		$path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
		$base = str_replace(DIRECTORY_SEPARATOR, '/', JPATH_ROOT);

		// Get a list of folders in the search path with the given filter.
		$folders = JFolder::folders($path, '.', $depth, true);

		// Build the options list from the list of folders.
		if (is_array($folders))
		{
			foreach ($folders as $folder)
			{

				// Check to see if the file is in the exclude mask.
				if ($exclude)
				{
					if (preg_match(chr(1) . $exclude . chr(1), $folder))
					{
						continue;
					}
				}
				$value		= substr(str_replace($path, "", str_replace(DIRECTORY_SEPARATOR, '/', $folder)), 1);
				$text		= str_replace($base, "", str_replace(DIRECTORY_SEPARATOR, "/", $folder));
				$options[]	= JHtml::_('select.option', $value, $text);
			}
		}

		return $options;
	}

}