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

class Testimonial_faderViewShow extends JView {
	 function display($tpl = null) {
			$app = JFactory::getApplication();
			$db		=& JFactory::getDBO();
			$session =& JFactory::getSession();
			$document = &JFactory::getDocument();
			$document->addStyleSheet('components/com_testimonial_fader/css/style.css' );
			$path=JURI::root();
			$menus = &JSite::getMenu();
			$menu  = $menus->getActive();
			$count=$menu->query[count];
			$limitstart=$_REQUEST['limitstart'];
			$itemid=$_REQUEST['Itemid'];
			if(!$limitstart)
			{
			$limitstart=0;
			}
			
			$session->set( 'testimonial_count', $count );
			$limit=$session->get( 'testimonial_count');	
			$query = "select count(*) from #__testimonial where publish=1";
			//echo $query;
			$db->setQuery( $query );
			$total = $db->loadResult();
			$query="select * from #__testimonial where  publish=1";
			$sql=$query.' LIMIT  ' . $limitstart . ', '.$limit;
			$db->setQuery( $sql );
			$rows = $db->loadObjectList();
			$this->assignRef('items',$rows);
			$this->assignRef('category',$category);
			$this->assignRef('count',$count);
			$this->assignRef('limit',$limit);
			$this->assignRef('total',$total);
			$this->assignRef('itemid',$itemid);
			$this->assignRef('limitstart',$limitstart);
			parent::display($tpl);
    }
}
?>