<?php
/**
* Smarty function to get the generic css-classes
*
* $Id$
*
* available parameters:
*  - assign      if set, the language will be assigned to this variable
*
* @author   Carsten Volmer
* @since    01. Apr. 09
* @param    array    $params     All attributes passed to this function from the template
* @param    object   $smarty     Reference to the Smarty object
* @return   string   the version string
*/

function smarty_function_cssversion($params, &$smarty)
{
    $assign = isset($params['assign']) ? $params['assign'] : null;

    if (version_compare(PN_VERSION_NUM, '1.2.0-dev', '>=')) {
        // PageUtil::addVar('stylesheet', 'javascript/style.css');
        $return = 'z-form';
    } else {
        // get the type parameter so we can decide what template to use
        $type = FormUtil::getPassedValue('type', 'user', 'REQUEST');

        if ($type == 'user') {
            // load special admin.css for administrator backend
            PageUtil::addVar('stylesheet', ThemeUtil::getModuleStylesheet('Admin', 'admin.css'));
        }

        $return = 'pn-adminform';
    }

    if ($assign) {
        $smarty->assign($assign, $return);
    } else {
        return $return;
    }
}
