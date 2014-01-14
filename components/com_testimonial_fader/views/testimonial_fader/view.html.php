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

class Testimonial_faderViewTestimonial_fader extends JView {
	function display($tpl = null) {
			global $mainframe, $option;
			$state		= $this->get('State');
			$item		= $this->get('Item');
			$this->state = $state;
			$this->assignRef( "preforence", $preforence);		
		    parent::display($tpl);
    }
		
}
?>