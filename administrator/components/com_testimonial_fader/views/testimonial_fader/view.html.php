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
jimport( 'joomla.application.component.view');

class Testimonial_faderViewtestimonial_fader extends JView {
    function display($tpl = null) {
	
			$searchtext=$_REQUEST['search'];
			$app = JFactory::getApplication();
			$db		=& JFactory::getDBO();
			$user	=& JFactory::getUser();
			$path=JURI::root();
			jimport('joomla.html.pagination');
			
			$option=JRequest::getCmd('option');
			$limit = $app->getUserStateFromRequest($option.'.limit', 'limit', 5, 'int');
			$limitstart = $app->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
			jimport('joomla.html.pagination');
			$query = "select count(*) from #__testimonial";
			$db->setQuery( $query );
			$total = $db->loadResult();
			$pageNav = new JPagination( $total, $limitstart, $limit );
			$id=$_REQUEST['id'];
			$query="select * from #__testimonial";
			//echo $sql;
			$search=$_REQUEST['search'];	
			if(!empty($_REQUEST['search']))
			{
			$limitstart=0;
			$whr=" where name like '%$search%'";
			}
			$sql="select * from #__testimonial".$whr;
			//echo $sql;
			if($limit!=0)
			{
			$sql=$query.' LIMIT  ' . $limitstart . ', '.$limit;
			//echo $sql;
			}
			
			$db->setQuery( $sql );
			$rows = $db->loadObjectList();
			// for edit'
			$edit_sql="select * from #__testimonial where id='".$id."'";
			//echo $edit_sql;
			$db->setQuery( $edit_sql );
			$edit = $db->loadObjectList();
			
		$this->assignRef('items',$rows);
		$this->assignRef('edit',$edit);
		$this->assignRef('limitstart',$limitstart);
		$this->assignRef('pageNav',$pageNav);
		$this->assignRef('limitstart',$limitstart);
        parent::display($tpl);
    }
	
 }

?>