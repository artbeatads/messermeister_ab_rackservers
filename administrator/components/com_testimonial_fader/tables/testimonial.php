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
 * item Table class
 */
class testimonial extends JTable
{
	
	var $id=null;
	var $name=null;
	var $email=null;
	var $testimonial=null;
	var $publish=null;
	public function __construct(&$db)
	{
	parent::__construct('#__testimonial', 'id', $db);
	}
}