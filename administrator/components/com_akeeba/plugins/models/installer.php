<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2009-2013 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 *
 * @since 3.3
 */

defined('_JEXEC') or die('');

JLoader::import('joomla.application.component.model');
JLoader::import('joomla.installer.installer');
JLoader::import('joomla.installer.helper');

require_once FOFTemplateUtils::parsePath('admin://components/com_installer/models/install.php', true);

/**
 * Class AkeebaModelInstaller extends the core com_installer InstallerModelInstall model,
 * adding the brains which decide how to perform the SRP backup in each case.
 */
class AkeebaModelInstaller extends InstallerModelInstall
{
	/**
	 * Fetches a package from the upload form and saves it to the temporary directory
	 *
	 * @return  boolean  True if the upload is successful
	 */
	public function upload()
	{
		// Get the uploaded file information
		$userfile = JRequest::getVar('install_package', null, 'files', 'array' );

		// Make sure that file uploads are enabled in php
		if (!(bool) ini_get('file_uploads')) {
			JError::raiseWarning('', JText::_('COM_INSTALLER_MSG_INSTALL_WARNINSTALLFILE'));
			return false;
		}

		// Make sure that zlib is loaded so that the package can be unpacked
		if (!extension_loaded('zlib')) {
			JError::raiseWarning('', JText::_('COM_INSTALLER_MSG_INSTALL_WARNINSTALLZLIB'));
			return false;
		}

		// If there is no uploaded file, we have a problem...
		if (!is_array($userfile) ) {
			JError::raiseWarning('', JText::_('COM_INSTALLER_MSG_INSTALL_NO_FILE_SELECTED'));
			return false;
		}

		// Check if there was a problem uploading the file.
		if ( $userfile['error'] || $userfile['size'] < 1 )
		{
			JError::raiseWarning('', JText::_('COM_INSTALLER_MSG_INSTALL_WARNINSTALLUPLOADERROR'));
			return false;
		}

		// Build the appropriate paths
		$config		= JFactory::getConfig();
		$tmp_dest 	= $config->get('tmp_path') . '/' . $userfile['name'];
		$tmp_src	= $userfile['tmp_name'];

		// Move uploaded file
		JLoader::import('joomla.filesystem.file');
		$uploaded = JFile::upload($tmp_src, $tmp_dest);

		if (!$uploaded)
		{
			JError::raiseWarning('', JText::_('COM_INSTALLER_MSG_INSTALL_WARNINSTALLUPLOADERROR'));
			return false;
		}

		// Store the uploaded package's location
		$session = JFactory::getSession();
		$session->set('compressed_package', $tmp_dest, 'akeeba');

		return true;
	}

	/**
	 * Downloads a package from a URL and saves it to the temporary directory
	 *
	 * @return  boolean  True is the download was successful
	 */
	public function download()
	{
		$input = JFactory::getApplication()->input;

		// Get the URL of the package to install
		$url = $input->getString('install_url');

		// Did you give us a URL?
		if (!$url)
		{
			JError::raiseWarning('', JText::_('COM_INSTALLER_MSG_INSTALL_ENTER_A_URL'));
			return false;
		}

		// Handle updater XML file case:
		if (preg_match('/\.xml\s*$/', $url))
		{
			jimport('joomla.updater.update');
			$update = new JUpdate;
			$update->loadFromXML($url);
			$package_url = trim($update->get('downloadurl', false)->_data);
			if ($package_url)
			{
				$url = $package_url;
			}
			unset($update);
		}

		// Download the package at the URL given
		$p_file = JInstallerHelper::downloadPackage($url);

		// Was the package downloaded?
		if (!$p_file)
		{
			JError::raiseWarning('', JText::_('COM_INSTALLER_MSG_INSTALL_INVALID_URL'));
			return false;
		}

		$config   = JFactory::getConfig();
		$tmp_dest = $config->get('tmp_path');

		// Store the uploaded package's location
		$session = JFactory::getSession();
		$session->set('compressed_package', $tmp_dest . '/' . $p_file, 'akeeba');

		return true;
	}

	/**
	 * Extracts a package archive to the temporary directory. The package information is
	 * saved in the session.
	 *
	 * @return  boolean  True if the extraction was successful
	 */
	function extract()
	{
		$session = JFactory::getSession();
		$compressed_package = $session->get('compressed_package', null, 'akeeba');

		// Do we have a compressed package?
		if(is_null($compressed_package))
		{
			JError::raiseWarning('', 'No package specified');
			return false;
		}

		// Extract the package
		$package = JInstallerHelper::unpack($compressed_package);
		$session->set('package', $package, 'akeeba');

		return true;
	}

	/**
	 * Gets the package information from an (already extracted) package in a directory,
	 * then saves the package information in the session.
	 *
	 * @param   string  $folder  (optional) Which directory to look into.
	 *
	 * @return  boolean  Always true
	 */
	public function fromDirectory($folder = null)
	{
		if (!empty($folder))
		{
			$input = JFactory::getApplication()->input;
			$input->set('install_directory', $folder);
		}

		$package = $this->_getPackageFromFolder();

		$session = JFactory::getSession();
		$session->set('package', $package, 'akeeba');

		return true;
	}

	/**
	 * Cleans up any remaining files after the installation is over (successful or not)
	 *
	 * @return  boolean  True on success
	 */
	function cleanUp()
	{
		$session = JFactory::getSession();
		$package = $session->get('package', '', 'akeeba');

		// Was the package unpacked?
		if (!$package || empty($package))
		{
			return false;
		}

		// Cleanup the install files
		if (!is_file($package['packagefile']))
		{
			$config = JFactory::getConfig();
			$package['packagefile'] = $config->get('tmp_path') . '/' . $package['packagefile'];
		}

		JInstallerHelper::cleanupInstall($package['packagefile'], $package['extractdir']);

		return true;
	}

	/**
	 * Identifies the extension whose package is extracted in $p_dir. It returns an array with
	 * the extension type, name and group (folder for plugins, admin/site section for modules,
	 * etc)
	 *
	 * @param   string  $p_dir  The directory containing the extracted package
	 *
	 * @return  array|bool  Hashed array on success, boolean false on failure
	 */
	public function getExtensionName($p_dir)
	{
		// Search the install dir for an XML file
		JLoader::import('joomla.filesystem.folder');
		$files = JFolder::files($p_dir, '\.xml$', 1, true);

		if ( ! count($files))
		{
			JError::raiseWarning(1, JText::_('JLIB_INSTALLER_ERROR_NOTFINDXMLSETUPFILE'));
			return false;
		}

		$cname = '';
		$group = '';

		foreach ($files as $file)
		{
			try
			{
				$xml = new SimpleXMLElement($file, LIBXML_NONET, true);
			}
			catch(Exception $e)
			{
				continue;
			}

			if (($xml->getName() != 'install') && ($xml->getName() != 'extension') && ($xml->getName() != 'akeebabackup'))
			{
				unset($xml);
				continue;
			}

			$type = (string)$xml->attributes()->type;

			// Get the name
			switch($type)
			{
				case 'component':
				case 'template':
					$name = (string)$xml->name;

					if (version_compare(JVERSION, '3.2.0', 'ge'))
					{
						$jfilter = new JFilterInput();
						$name = $jfilter->clean($name, 'cmd');
					}
					else
					{
						$name = JFilterInput::clean($name, 'cmd');
					}

					if($type == 'template')
					{
						$cname = (string)$xml->attributes()->client;
					}
					break;

				case 'module':
				case 'plugin':
					$cname = (string)$xml->attributes()->client;
					$group = (string)$xml->attributes()->group;
					$element = $xml->files;

					if ( ($element instanceof SimpleXMLElement) && $element->count())
					{
						foreach ($element->children() as $file)
						{
							if ($file->attributes()->$type)
							{
								$name = (string)$file->attributes()->$type;
								break;
							}
						}
					}
					break;
			}

			if (empty($name))
			{
				$name = false;
			}

			if ($name !== false)
			{
				// Make sure the extension is already installed - otherwise there is no point!
				JLoader::import('joomla.filesystem.file');
				JLoader::import('joomla.filesystem.folder');

				switch($type)
				{
					case 'component':
						$name = strtolower($name);
						$name = substr($name,0,4) == 'com_' ? substr($name,4) : $name;

						if(
							!JFolder::exists(JPATH_ROOT.'/components/com_'.$name)
							&& !JFolder::exists(JPATH_ROOT.'/administrator/components/com_'.$name)
						)
						{
							$name = false;
						}
						break;

					case 'template':
						$base = ($cname == 'site') ? JPATH_ROOT : JPATH_ADMINISTRATOR;
						$base .= '/templates/';
						if(
							!JFolder::exists($base.$name)
						)
						{
							$name = strtolower($name);

							if (!JFolder::exists($base . $name))
							{
								$name = false;
							}
						}
						break;

					case 'module':
						$base = ($cname == 'site') ? JPATH_ROOT : JPATH_ADMINISTRATOR;
						$base .= '/modules/';

						if(
							!JFolder::exists($base.'mod_'.$name)
						)
						{
							$name = strtolower($name);

							if (!JFolder::exists($base . 'mod_'.$name))
							{
								$name = false;
							}
						}

						break;

					case 'plugin':
						$base = JPATH_ROOT.'/plugins/'.$group.'/';
						if(
							!JFile::exists($base.'plg_'.$name.'.php')
							&& !JFile::exists($base.$name.'.php')
							&& !JFolder::exists($base.$name)
							&& !JFolder::exists($base.'plg_'.$name)
						)
						{
							$name = strtolower($name);

							if(
								!JFile::exists($base.'plg_'.$name.'.php')
								&& !JFile::exists($base.$name.'.php')
								&& !JFolder::exists($base.$name)
								&& !JFolder::exists($base.'plg_'.$name)
							)
							{
								$name = false;
							}
						}
						break;

					default:
						$name = false;
				}
			}
			else
			{
				return false;
			}

			// Free up memory from SimpleXML parser
			unset ($xml);

			if($name === false)
			{
				return false;
			}

			// Return the name
			return array(
				'name' => $name,
				'client' => $cname,
				'group' => $group
			);
		}

		return false;
	}

	/**
	 * Returns the URL used to take a System Restore Point backup for the current extension.
	 * If the extension is not already installed it will return boolean false.
	 *
	 * @return  bool|string  URL on success, false if the extension is not already installed
	 */
	public function getSrpUrl()
	{
		$session = JFactory::getSession();
		$package = $session->get('package', array(), 'akeeba');

		$name = $this->getExtensionName($package['dir']);

		if($name !== false)
		{
			// If SRPs are supported, get the SRP URL
			$type = $package['type'];
			$url = 'index.php?option=com_akeeba&view=backup&tag=restorepoint&type='.$type.'&name='.urlencode($name['name']);

			switch($type)
			{
				case 'module':
				case 'template':
					$url .= '&group='.$name['client'];
					break;
				case 'plugin':
					$url .= '&group='.$name['group'];
					break;

				default:
					return false;
					break;
			}

			$url .= '&returnurl='.urlencode('index.php?option=com_installer&view=install&task=install.akrealinstall');

			$token = JSession::getFormToken();
			$url .= '&' . $token . '=1';

			return $url;
		}
		else
		{
			// If SRPs are not supported, return false
			return false;
		}
	}

	/**
	 * Downloads an update package given an update record ID ($uid). The package is downloaded
	 * and its location recorded in the session.
	 *
	 * @param   integer  $uid  The update record ID
	 *
	 * @return  True on success
	 */
	public function downloadUpdate($uid)
	{
		// Unset the compressed_package session variable
		$session = JFactory::getSession();
		$session->set('compressed_package', null, 'akeeba');

		// Find the download location from the XML update stream
		jimport('joomla.updater.update');
		$update = new JUpdate;
		$instance = JTable::getInstance('update');
		$instance->load($uid);
		$update->loadFromXML($instance->detailsurl);

		if (isset($update->get('downloadurl')->_data))
		{
			$url = $update->downloadurl->_data;
		}
		else
		{
			JError::raiseWarning('', JText::_('COM_INSTALLER_INVALID_EXTENSION_UPDATE'));
			return false;
		}

		// Download the package
		$p_file = JInstallerHelper::downloadPackage($url);

		// Was the package downloaded?
		if (!$p_file)
		{
			JError::raiseWarning('', JText::sprintf('COM_INSTALLER_PACKAGE_DOWNLOAD_FAILED', $url));
			return false;
		}

		// Store the uploaded package's location
		$config   = JFactory::getConfig();
		$tmp_dest = $config->get('tmp_path');

		$session->set('compressed_package', $tmp_dest . '/' . $p_file, 'akeeba');

		return true;
	}
}