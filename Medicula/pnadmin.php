<?php
/**
* Medicula
*
* @copyright (c) 2009-now, Carsten Volmer
* @link http://code.zikula.org/medicula
* @version $Id$
* @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
* @package Medicula
*/

//MODULES
function Medicula_admin_main()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    //$mediclasttool = SessionUtil::getVar('mediclasttool');

    //if(!empty($mediclasttool)) {
    //  return pnRedirect(pnModURL('Medicula', 'admin', 'main'));
    //}

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    return $pnRender->fetch('Medicula_admin_main.html');
}

function Medicula_admin_modules()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    SessionUtil::setVar('mediclasttool', 'modules');

    $mods = pnModAPIFunc('modules', 'admin', 'list');

    if(!$mods) {
        LogUtil::registerError(_MEDIC_UNABLETOGETMODS);
    }

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    $pnRender->assign('modules',$mods);
    $pnRender->assign('module_count', count($mods));
    $pnRender->assign('authid',SecurityUtil::generateAuthKey('Medicula'));

    return $pnRender->fetch('Medicula_admin_mods.html');
}

function Medicula_admin_modsremove()
{
    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('Medicula', 'admin', 'modsremove'));
    }

    $delmods = FormUtil::getPassedValue('delmods');

    if(!is_array($delmods)) {
        LogUtil::registerError(_MEDIC_NOTHINGSEL);
        return pnRedirect(pnModURL('Medicula', 'admin', 'modules'));
    }

    $cnt_removed = pnModAPIFunc( 'Medicula', 'admin', 'modsremove', array('delmods'=>$delmods));

    if($cnt_removed) {
        LogUtil::registerStatus(_MEDIC_M_DELMODS);
    }

    return pnRedirect(pnModURL('Medicula', 'admin', 'modules'));
}

//USERSESSIONS
function Medicula_admin_sessions()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    SessionUtil::setVar('mediclasttool', 'sessions');

    $user_sessions = pnModAPIFunc( 'Medicula', 'admin', 'usersessions');

    if(!$user_sessions) {
        LogUtil::registerError(_MEDIC_UNABLETOGETSESS);
    }

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    $pnRender->assign('user_sessions',$user_sessions);
    $pnRender->assign('session_count', count($user_sessions));
    $pnRender->assign('mysessid',  session_id() );
    $pnRender->assign('myuid', pnUserGetVar('uid') );
    $pnRender->assign('authid',SecurityUtil::generateAuthKey('Medicula'));

    return $pnRender->fetch('Medicula_admin_sessions.html');
}

function Medicula_admin_sessionsremove()
{
    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('Medicula', 'admin', 'sessionsremove'));
    }

    $delsessions = FormUtil::getPassedValue('delsessions');

    if(!is_array($delsessions)) {
        LogUtil::registerError(_MEDIC_NOTHINGSEL);
        return pnRedirect(pnModURL('Medicula', 'admin', 'sessions'));
    }

    $cnt_removed = pnModAPIFunc( 'Medicula', 'admin', 'sessionsremove', array('delsessions'=>$delsessions));

    if($cnt_removed) {
        LogUtil::registerStatus(_MEDIC_M_DELSESS);
    }

    return pnRedirect(pnModURL('Medicula', 'admin', 'sessions'));
}

//HOOKS
function Medicula_admin_hooks()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    SessionUtil::setVar('mediclasttool', 'hooks');

    $orp_hooks = pnModAPIFunc( 'Medicula', 'admin', 'orphanedhooks');

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    $pnRender->assign('hook_list', $orp_hooks);
    $pnRender->assign('hook_count', count($orp_hooks));
    $pnRender->assign('authid',SecurityUtil::generateAuthKey('Medicula'));

    return $pnRender->fetch('Medicula_admin_hooks.html');
}

function Medicula_admin_hooksremove()
{
    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('Medicula', 'admin', 'hooksremove'));
    }

    $delhooks = FormUtil::getPassedValue('delhooks');

    if(!is_array($delhooks)) {
        LogUtil::registerError(_MEDIC_NOTHINGSEL);
        return pnRedirect(pnModURL('Medicula', 'admin', 'hooks'));
    }

    $cnt_removed = pnModAPIFunc( 'Medicula', 'admin', 'hooksremove', array('delhooks'=>$delhooks));

    if($cnt_removed) {
        LogUtil::registerError(_MEDIC_M_REMHOOK);
    }

    return pnRedirect(pnModURL('Medicula', 'admin', 'hooks'));
}

//TABLES

function Medicula_admin_tables()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    SessionUtil::setVar('mediclasttool', 'tables');

    $mod_list = pnModAPIFunc('Medicula', 'admin', 'getallmods');

    if(!$mod_list) {
        LogUtil::registerError(_MEDIC_UNABLETOGETMODS);
        $orp_tables = array() ;
    } else {
        $orp_tables = pnModAPIFunc( 'Medicula', 'admin', 'orphanedtables', array('mod_list'=>$mod_list));
    }

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    $pnRender->assign('table_list', $orp_tables);
    $pnRender->assign('table_count', count($orp_tables));
    $pnRender->assign('authid',SecurityUtil::generateAuthKey('Medicula'));
    return $pnRender->fetch('Medicula_admin_tables.html');
}

function Medicula_admin_tablesremove()
{
    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('Medicula', 'admin', 'tablesremove'));
    }

    $deltabs = FormUtil::getPassedValue('deltabs');

    if(!is_array($deltabs)) {
        LogUtil::registerError(_MEDIC_NOTHINGSEL);
        return pnRedirect(pnModURL('Medicula', 'admin', 'tables'));
    }

    $cnt_removed = pnModAPIFunc( 'Medicula', 'admin', 'tablesremove', array('deltabs'=>$deltabs));

    if($cnt_removed) {
        LogUtil::registerStatus(_MEDIC_M_REMTABLES);
    }

    return pnRedirect(pnModURL('Medicula', 'admin', 'tables'));
}

//VARS
function Medicula_admin_vars()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    SessionUtil::setVar('mediclasttool', 'vars');

    $var_list = pnModAPIFunc('Medicula', 'admin', 'orphanedvars');

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    $pnRender->assign('var_list', $var_list);
    $pnRender->assign('var_count', count($var_list));
    $pnRender->assign('authid',SecurityUtil::generateAuthKey('Medicula'));
    return $pnRender->fetch('Medicula_admin_vars.html');
}

function Medicula_admin_varsremove()
{

    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('Medicula', 'admin', 'varsremove'));
    }

    $delvars = FormUtil::getPassedValue('delvars');

    if(!is_array($delvars)) {
        LogUtil::registerError(_MEDIC_NOTHINGSEL);
        return pnRedirect(pnModURL('Medicula', 'admin', 'vars'));
    }

    $cnt_removed = pnModAPIFunc( 'Medicula', 'admin', 'varsremove', array('delvars'=>$delvars));

    if($cnt_removed) {
        LogUtil::registerStatus(_MEDIC_M_REMVARS);
    }

    return pnRedirect(pnModURL('Medicula', 'admin', 'vars'));
}

function Medicula_admin_testdata()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    SessionUtil::setVar('mediclasttool', 'testdata');

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    $pnRender->assign('authid',SecurityUtil::generateAuthKey('Medicula'));
    return $pnRender->fetch('Medicula_admin_testdata.html');

}

function Medicula_admin_testdatado()
{
    if (!SecurityUtil::confirmAuthKey()) {
        LogUtil::registerError(_BADAUTHKEY);
        return pnRedirect(pnModURL('Medicula', 'admin', 'testdatado'));
    }

    $suc = 	pnModAPIFunc( 'Medicula', 'admin', 'gentestdata');

    if(!$suc) {
        LogUtil::registerError(_MEDIC_UNABLETESTDATA);
    } else {
        LogUtil::registerStatus(_MEDIC_M_MADETESTDATA);
    }

    return pnRedirect(pnModURL('Medicula', 'admin', 'testdata'));

}
