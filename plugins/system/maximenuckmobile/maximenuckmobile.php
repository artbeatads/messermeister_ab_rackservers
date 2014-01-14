<?php

/**
 * @copyright	Copyright (C) 2012 Cédric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * @license		GNU/GPL
 * */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.event.plugin');

class plgSystemMaximenuckmobile extends JPlugin {

    function plgSystemMaximenuckmobile(&$subject, $params) {
        parent::__construct($subject, $params);
    }
    
    /**
     * @param       JForm   The form to be altered.
     * @param       array   The associated data for the form.
     * @return      boolean
     * @since       1.6
     */
    function onContentPrepareForm($form, $data) {
        if ($form->getName() != 'com_modules.module'
                && $form->getName() != 'com_menus.item'
                && $form->getName() != 'com_advancedmodules.module'
                || ($form->getName() == 'com_modules.module' && $data && $data->module != 'mod_maximenuck')
                || ($form->getName() == 'com_advancedmodules.module' && $data && $data->module != 'mod_maximenuck'))
            return;

        JForm::addFormPath(JPATH_SITE . '/plugins/system/maximenuckmobile/params');
        // JForm::addFieldPath(JPATH_SITE . '/modules/mod_maximenuck/elements');

        // get the language
        $lang = JFactory::getLanguage();
        $langtag = $lang->getTag(); // returns fr-FR or en-GB
        $this->loadLanguage();

        // module options
        $app = JFactory::getApplication();
        $plugin = JPluginHelper::getPlugin('system', 'maximenuckmobile');
        $pluginParams = new JRegistry($plugin->params);

        foreach ($pluginParams->get('maximenu_modulemobile') as $moduleid) {
            if ($app->input->get('id') == $moduleid)
                $form->loadFile('mobile_menuparams_maximenuck', false);
        }
    }

    function onAfterDispatch() {
    
        $app = JFactory::getApplication();
        $document = JFactory::getDocument();
        $doctype = $document->getType();
        JHTML::_('behavior.framework',true);

        // si pas en frontend, on sort
        if ($app->isAdmin()) {
            return false;
        }

        // si pas HTML, on sort
        if ($doctype !== 'html') {
            return;
        }

        // get the language
        $lang = JFactory::getLanguage();
        $this->loadLanguage();

        JText::script('PLG_MAXIMENUCK_MENU');
        
        $document->addScript( 'plugins/system/maximenuckmobile/assets/maximenuckmobile.js' );

        foreach ($this->params->get('maximenu_modulemobile') as $moduleid) {
        // vérifies qu'on a paramétré le plugin
//        if (!$maximenu_modulemobile = $this->params->get('maximenu_modulemobile', '0')) return;
            $moduleParams = new JRegistry($this->getModuleParams($moduleid)->params);

            $menuID = $moduleParams->get('menuid', 'maximenuck');
            $resolution = $moduleParams->get('maximenumobile_resolution','640');
            $useimages = $moduleParams->get('maximenumobile_useimage','0');
            $usemodules = $moduleParams->get('maximenumobile_usemodule','0');
            $theme = $moduleParams->get('maximenumobile_theme', 'default');
            $document->addStyleSheet( 'plugins/system/maximenuckmobile/themes/'.$theme.'/maximenuckmobile.css' );

            $css = $this->getMediaQueries($resolution, $menuID);
            $document->addStyleDeclaration($css);

            $js = "window.addEvent('domready', function() {new MobileMaxiMenu(document.getElement('div#" . $menuID . "'),{"
                            . "usemodules : " . $usemodules . ","
                            . "useimages : " . $useimages . ","
                            . "resolution : " . $resolution . "});"
                            . "});";
            $document->addScriptDeclaration($js);
        // var_dump($moduleParams->get('maximenumobile_resolution'));
        }
    }

    private function getModuleParams($moduleid) {		
        $db = JFactory::getDBO();
        $query = "
			SELECT id, module, title
			FROM #__modules
			WHERE published=1
            AND module='mod_maximenuck'
			;";
        $db->setQuery($query);
        $modules = $db->loadObjectList('id');//var_dump($modulesList);die();
        foreach ($modules as $module) {
            if ($module->id == $moduleid)
                return JModuleHelper::getModule($module->module, $module->title);
        }
    }
    
    private function getMediaQueries($resolution, $menuID) {
        $css = "@media only screen and (max-width:".str_replace('px','',$resolution)."px){    
    #".$menuID." { display: none !important; }
    #mobilebarmenuck { display: block !important; }
    body { padding-top: 40px !important; }
}";
    return $css;
    }

    // end of the class
}