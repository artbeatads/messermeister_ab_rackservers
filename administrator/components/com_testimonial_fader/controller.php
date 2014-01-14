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

require_once(JPATH_COMPONENT.DS.'tables'.DS.'testimonial.php');
class Testimonial_faderController extends JController
{
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			$cachable	If true, the view output will be cached
	 * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/testimonial_fader.php';
		
		// Load the submenu.
		Testimonial_faderHelper::addSubmenu(JRequest::getCmd('view', ''));

		  if(JRequest::getCmd('view') == '') {
            JRequest::setVar('view', 'testimonial_fader');
        }
		$this->item_type = 'Testimonial_fader';
        parent::__construct();
		//$this->registerTask( 'unpublish',	'publish' );
		//$this->registerTask( 'publish',	'publish' );
		
		parent::display();

		return $this;
	}
	function addNew()
	{
	$this->setRedirect( 'index.php?option=com_testimonial_fader&view=testimonial_fader&layout=edit');
	}
	function save_tf()
	{
			$db		=& JFactory::getDBO();
			$row = new testimonial($db);
			$post	= JRequest::get( 'post' );
			if (!$row->bind( $post )) {
				return JError::raiseWarning( 500, $row->getError() );
			}
			/* check duplcaties*******************/
			/*
			$extraction="";
			if($row->id)
			{
			$extraction="and id!=".$row->id;
			}
			$sql="select * from #__testimonial where name='".$row->name."' or email='".$row->email."'".$extraction;
		//	echo $sql;
			//exit;
			$db->setQuery($sql);
			$rows = $db->loadObjectList();
			if(count($rows)>0)
			{
			$this->setMessage(' Found Duplicities' );
			$this->setRedirect( 'index.php?option=com_testimonial_fader&view=default&layout=edit&id='.$row->id);
			return;
			}*/
			if (!$row->store()) {
			return JError::raiseWarning( 500, $row->getError() );
			}
						
			$this->setMessage('Testimonial Saved' );
			$this->setRedirect('index.php?option=com_testimonial_fader&view=testimonial_fader');
		}
	function publish()
	{
		global $option;
		$mainframe=JFactory::getApplication();
		$db		=& JFactory::getDBO();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		if (empty( $cid )) {
		return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		$task		= JRequest::getCmd( 'task' );
		$publish	= ($task == 'publish');
		$n			= count( $cid );
		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );
		$query = 'UPDATE #__testimonial'
		. ' SET publish = ' . (int) $publish
		. ' WHERE id IN ( '. $cids.'  )'
		;
	//	echo $query;
		//exit;
		$db->setQuery( $query );
		if (!$db->query()) {
		return JError::raiseWarning( 500, $db->getError() );
		}
		$this->setMessage( JText::sprintf( $publish ? 'Items published' : 'Items unpublished', $n ) );
		$this->setRedirect( 'index.php?option=com_testimonial_fader');
	}
	function unpublish()
	{
		global $option;
		$mainframe=JFactory::getApplication();
		$db		=& JFactory::getDBO();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		if (empty( $cid )) {
		return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		$task		= JRequest::getCmd( 'task' );
		$publish	= ($task == 'publish');
		$n			= count( $cid );
		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );
		$query = 'UPDATE #__testimonial'
		. ' SET publish = ' . (int) $publish
		. ' WHERE id IN ( '. $cids.'  )'
		;
	//	echo $query;
		//exit;
		$db->setQuery( $query );
		if (!$db->query()) {
		return JError::raiseWarning( 500, $db->getError() );
		}
		$this->setMessage( JText::sprintf( $publish ? 'Items published' : 'Items unpublished', $n ) );
		$this->setRedirect( 'index.php?option=com_testimonial_fader');
	}
	function delete()
	{
		global $option;
		$mainframe=JFactory::getApplication();
		$db		=& JFactory::getDBO();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		if (empty( $cid )) {
		return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
			foreach ($cid as $id)
			{
				$db		=& JFactory::getDBO();
				$sql='delete from #__testimonial where id='.$id;
				$db->setQuery( $sql );
				$db->Query();
			}
		$this->setMessage( JText::_('Items Delete'));
		$this->setRedirect( 'index.php?option=com_testimonial_fader');
	
	}
	function save_css()
	{
		$template_path = JPATH_SITE.DS.'components'.DS.'com_testimonial_fader'.DS.'css'.DS.'style.css';
		$csscontent	 	= JRequest::getVar('csscontent', '', 'post', 'string', JREQUEST_ALLOWRAW);

		if( $fp = @fopen( $template_path, 'w' )) {
			fputs( $fp, stripslashes( $csscontent ) );
			fclose( $fp );
			//return true;
			 $this->setMessage( JText::_('CSS Saved'));
		}else{
			//return false;
			$this->setMessage( JText::_('Error Saving CSS'));
		}
		$this->setRedirect( 'index.php?option=com_testimonial_fader');
	}
	function apply_css()
	{
		$template_path = JPATH_SITE.DS.'components'.DS.'com_testimonial_fader'.DS.'css'.DS.'style.css';
		$csscontent	 	= JRequest::getVar('csscontent', '', 'post', 'string', JREQUEST_ALLOWRAW);

		
		if( $fp = @fopen( $template_path, 'w' )) {
			fputs( $fp, stripslashes( $csscontent ) );
			fclose( $fp );
			//return true;
			 $this->setMessage( JText::_('CSS Saved'));
		}else{
			//return false;
			$this->setMessage( JText::_('Error Saving CSS'));
		}
		
		
		$this->setRedirect( 'index.php?option=com_testimonial_fader&view=css');
	}
	function cancel()
    {
        // Check for request forgeries
         $this->setRedirect('index.php?option=com_testimonial_fader');
    }
	
	
}
