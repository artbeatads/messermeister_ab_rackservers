<?php
/*------------------------------------------------------------------------
# mod_testimonial_fader - Testimonial Fader
# ------------------------------------------------------------------------
# author    Infyways Solutions
# copyright Copyright (C) 2012 Infyways Solutions. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.infyways.com
# Technical Support:  Forum - http://support.infyways/com
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$load1 = $params->get('load1');
$jsfiles = $params->get('jsfiles');
$width = $params->get('width');
$height= $params->get('height');
$tfont = $params->get('tfont');
$user_defined = $params->get('user_defined');
$tsize = $params->get('tsize');
$tcolor = $params->get('tcolor');
$tweight = $params->get('tweight');
$acolor = $params->get('acolor');
$asize = $params->get('asize');
$aweight = $params->get('aweight');
$quote_style = $params->get('quote_style');
$quote = $params->get('quote');
$speed = $params->get('speed');
$timeout = $params->get('timeout');
$animation = $params->get('animation');
$show_type = $params->get('show_type');
$source = $params->get('source');
$testimonials = $params->get('testimonials');
$authors = $params->get('authors');
if($source=='component')
{
	include_once dirname(__FILE__).'/helper.php';
	$list = modTestiHelper::getTesti();
}
//CSS file Creation
if($tfont!='user'){
$tsfont= "'".$tfont."', sans-serif " ;} else {$tsfont= $user_defined;}

$fp = fopen('modules/mod_testimonial_fader/tmpl/css/fader.css', 'w');
fwrite($fp,'/*This CSS is auto generated . If you want to do any modification to the css then you may either write it in your template css or change it at mod_testimonial_fader.php*/
#fader-'.$module->id.' ul{background: none!important;list-style-type:none!important;margin:0!important;padding:0!important;}
#fader-'.$module->id.' ul li{background: none!important;list-style-type:none!important;margin:0!important;padding:0!important;}
#fader-'.$module->id.' p{background: none!important;font-family:'.$tsfont.';font-size:'.$tsize.'px;font-weight:'.$tweight.';color:'.$tcolor.'; margin-left:5px !important; margin:0!important; padding:10 !important;}
#fader-'.$module->id.'{height:'.$height.'!important; width:'.$width.'!important; overflow: hidden;}
');
fclose($fp);

//End of CSS file

require(JModuleHelper::getLayoutPath('mod_testimonial_fader','default'));
?>