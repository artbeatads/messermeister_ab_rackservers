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

jimport('joomla.application.component.controller');
class Testimonial_faderController extends JController

{
	var $font= "components/com_testimonial_fader/font/monofont.ttf";
function display($cachable = false, $urlparams = false) {
        // Make sure we have a default view
        if( !JRequest::getVar( 'view' )) {
		    JRequest::setVar('view', 'testimonial_fader' );
        }
		parent::display();
	}
	function save()
	{
		$params = &JComponentHelper::getParams('com_testimonial_fader' );
		$rec_email=	$params->get('email');
		$session =& JFactory::getSession();
		$code=$session->get(code);
		$session->clear(my_name);
		$session->clear(email);
		$session->clear(testimonial);
		$session->clear(ses_id);
		$Itemid=$_REQUEST['Itemid'];
		$hidden_code=$_REQUEST['hidden_code'];
		
		$mainframe=JFactory::getApplication();
		$user = JFactory::getUser();
		$db 			=& JFactory::getDBO();	
		//Replacing Single Quote
		$testimonial=$_REQUEST['testimonial'];
		$nam=$_REQUEST['my_name'];
		$name = str_replace("'","&#8217;", $nam);
		$newstr = str_replace("'","&#8217;", $testimonial);
		if($_REQUEST['security_code']==$hidden_code){
		$ins="INSERT INTO #__testimonial (name,email,testimonial) values ('".$name."','".$_REQUEST['email']."','".$newstr."')";
		$db->setQuery($ins);
		if (!$db->query()){
		return JError::raiseWarning( 500, $db->getError() );
		}
		if($rec_email)
		{
		$ip=$_SERVER['REMOTE_ADDR'];
		$to=$rec_email;
		$body='<p><b>Name: </b> '.$name.'</p>';
		$body.='<p><b>Email :</b> '.$_REQUEST['email'].'</p>';
		$body.='<p><b>Testimonial : </b> '.$newstr.'</p>';
		$body.='<hr/>';
		$body.="<b>IP Address:".$ip."</b><br/><small>You can manage the testimonial in the Joomla Administrator.</small>"; 
		$message=$body;
			$subject = "New Testimonial submitted by ".$name;
			$headers  = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
			$headers .= "From: ".$_REQUEST['email']. "\r\n";
			$headers .= "Reply-To: ".$_REQUEST['email']. "\r\n";
			$mailsent = mail($to,$subject,$message,$headers);
		}
		JFactory::getApplication()->enqueueMessage(JText::_( 'COM_TESTIMONIAL_FADER_THANKS'));
		$this->setRedirect(JRoute::_('index.php?option=com_testimonial_fader&Itemid='.$Itemid.'',false));
		}
		else
		{
		$session->set('ses_id',1);
		$session->set('name',$_REQUEST['my_name']);
		$session->set('email',$_REQUEST['email']);
		$session->set('testimonial',$newstr);
		JError::raiseWarning( 100, JText::_( 'COM_TESTIMONIAL_FADER_ERROR') );
		$this->setRedirect( JRoute::_('index.php?option=com_testimonial_fader&Itemid='.$Itemid,false));
		}

	}
	function save_addshow()
	{
		$params = &JComponentHelper::getParams('com_testimonial_fader' );
		$rec_email=	$params->get('email');
		$session =& JFactory::getSession();
		$code=$session->get(code);
		$session->clear(my_name);
		$session->clear(email);
		$session->clear(testimonial);
		$session->clear(ses_id);
		$Itemid=$_REQUEST['Itemid'];
		$hidden_code=$_REQUEST['hidden_code'];
		
		$mainframe=JFactory::getApplication();
		$user = JFactory::getUser();
		$db 			=& JFactory::getDBO();	
		//Replacing Single Quote
		$testimonial=$_REQUEST['testimonial'];
		$nam=$_REQUEST['my_name'];
		$name = str_replace("'","&#8217;", $nam);
		$newstr = str_replace("'","&#8217;", $testimonial);
		if($_REQUEST['security_code']==$hidden_code){
		$ins="INSERT INTO #__testimonial (name,email,testimonial) values ('".$name."','".$_REQUEST['email']."','".$newstr."')";
		$db->setQuery($ins);
		if (!$db->query()){
		return JError::raiseWarning( 500, $db->getError() );
		}
		if($rec_email)
		{
		$ip=$_SERVER['REMOTE_ADDR'];
		$to=$rec_email;
		$body='<p><b>Name: </b> '.$name.'</p>';
		$body.='<p><b>Email :</b> '.$_REQUEST['email'].'</p>';
		$body.='<p><b>Testimonial : </b> '.$newstr.'</p>';
		$body.='<hr/>';
		$body.="<b>IP Address:".$ip."</b><br/><small>You can manage the testimonial in the Joomla Administrator.</small>"; 
		$message=$body;
			$subject = "New Testimonial submitted by ".$name;
			$headers  = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
			$headers .= "From: ".$_REQUEST['email']. "\r\n";
			$headers .= "Reply-To: ".$_REQUEST['email']. "\r\n";
			$mailsent = mail($to,$subject,$message,$headers);
		}
		JFactory::getApplication()->enqueueMessage(JText::_( 'COM_TESTIMONIAL_FADER_THANKS'));
		$this->setRedirect( JRoute::_('index.php?option=com_testimonial_fader&view=addshow&Itemid='.$Itemid,false));
		}
		else
		{
		$session->set('ses_id',1);
		$session->set('name',$_REQUEST['my_name']);
		$session->set('email',$_REQUEST['email']);
		$session->set('testimonial',$newstr);
		JError::raiseWarning( 100, JText::_( 'COM_TESTIMONIAL_FADER_ERROR') );
		$this->setRedirect( JRoute::_('index.php?option=com_testimonial_fader&view=addshow&Itemid='.$Itemid,false));
		}

	}
	
	function captcha(){
	$image=$this->CaptchaSecurityImages($width='120',$height='40',$characters='5');
	exit();
	}
	
	function generateCode($characters) {
		/* list all possible characters, similar looking characters and vowels have been removed */
		$possible = '23456789bcdfghjkmnpqrstvwxyz';
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		$session =& JFactory::getSession();
		$session->set('code',$code);
		return $code;
	}
		function CaptchaSecurityImages($width='120',$height='40',$characters='6') {
		$session =& JFactory::getSession();
		$code=$session->get(code);
		//$code = $this->generateCode($characters);
		/* font size will be 75% of the image height */
		$font_size = $height * 0.75;
		$image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
		/* set the colours */
		$background_color = imagecolorallocate($image, 255, 255, 255);
		$text_color = imagecolorallocate($image, 20, 40, 100);
		$noise_color = imagecolorallocate($image, 100, 120, 180);
		/* generate random dots in background */
		for( $i=0; $i<($width*$height)/3; $i++ ) {
			imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
		}
		/* generate random lines in background */
		for( $i=0; $i<($width*$height)/150; $i++ ) {
			imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
		}
		/* create textbox and add text */
		$textbox = imagettfbbox($font_size, 0, $this->font, $code) or die('Error in imagettfbbox function');
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;
		imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font , $code) or die('Error in imagettftext function');
		/* output captcha image to browser */
		header('Content-Type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
	}
	
	
}