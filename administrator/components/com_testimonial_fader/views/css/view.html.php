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

jimport('joomla.application.component.view');

class Testimonial_faderViewCss extends JView
{
    /**
     * Display the CSS file
     * @return void
     **/
    function display($tpl = null)
    {

        JToolBarHelper::title(JText::_('CSS').': <small><small>[ Edit ]</small></small>', 'testimonial');
		$document = &JFactory::getDocument();
		$document->addStyleSheet('components/com_testimonial_fader/assets/css/testimonial_fader.css' );
        JToolBarHelper::save('save_css');
        JToolBarHelper::apply(apply_css);
        if ( isset ($isNew) && $isNew)
        {
            JToolBarHelper::cancel();
        } else
        {
            // for existing items the button is renamed `close`
            JToolBarHelper::cancel('cancel', 'Close');
        }
	 parent::display($tpl);
    }
}


?>
