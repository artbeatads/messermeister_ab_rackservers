/**
 * @package Testimonial Fader
 * @version 3.1
 * @author Infyways Solutions http://www.infyways.com
 * @copyright Copyright (C) 2011 - 2012 Infyways Solutions.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

jQuery.noConflict();
jQuery(document).ready(function(){

    function showComponent(){
        jQuery('#paramstestimonials').parent().hide();
        jQuery('#paramsauthors').parent().hide();
        jQuery('#paramstestimonials-lbl').parent().hide();
        jQuery('#paramsauthors-lbl').parent().hide();
    }
    function showModule(){
		jQuery('#paramstestimonials').parent().show();
        jQuery('#paramsauthors').parent().show();
        jQuery('#paramstestimonials-lbl').parent().show();
        jQuery('#paramsauthors-lbl').parent().show();
    }

    switch(jQuery('#paramssource').val()){
        case 'component':
            showComponent();
            break;
        case 'module':
            showModule();
            break;
    }

    jQuery('#paramssource').change(function(){
        switch(jQuery('#paramssource').val()){
        case 'component':
            showComponent();
            break;
        case 'module':
            showModule();
            break;
    }
    });

	////////////////////////////////////////////////////////
	 function showUserDef(){
        jQuery('#paramsuser_defined').parent().show();
        jQuery('#paramsuser_defined-lbl').parent().show();
    }
    function hideUserDef(){
		jQuery('#paramsuser_defined').parent().hide();
		jQuery('#paramsuser_defined-lbl').parent().hide();
    }
	
	if(jQuery('#paramstfont').val()=='user'){
            showUserDef();
    }
		else{
			hideUserDef();
	}
	
	jQuery('#paramstfont').change(function(){
        if(jQuery('#paramstfont').val()=='user'){
            showUserDef();
    }
		else{
			hideUserDef();
	}
    });
	
    jQuery('#element-box div.m').css('display','block');
});