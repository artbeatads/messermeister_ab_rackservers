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
        jQuery('#jform_params_testimonials').parent().hide();
        jQuery('#jform_params_authors').parent().hide();
    }
    function showModule(){
		jQuery('#jform_params_testimonials').parent().show();
        jQuery('#jform_params_authors').parent().show();
    }

    switch(jQuery('#jform_params_source').val()){
        case 'component':
            showComponent();
            break;
        case 'module':
            showModule();
            break;
    }

    jQuery('#jform_params_source').change(function(){
        switch(jQuery('#jform_params_source').val()){
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
        jQuery('#jform_params_user_defined').parent().show();
    }
    function hideUserDef(){
		jQuery('#jform_params_user_defined').parent().hide();
    }
	
	if(jQuery('#jform_params_tfont').val()=='user'){
            showUserDef();
    }
		else{
			hideUserDef();
	}
	
	jQuery('#jform_params_tfont').change(function(){
        if(jQuery('#jform_params_tfont').val()=='user'){
            showUserDef();
    }
		else{
			hideUserDef();
	}
    });
	
    jQuery('#element-box div.m').css('display','block');
});