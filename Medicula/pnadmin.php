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


function Medicula_admin_main()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    $pnRender->assign('mods_uninitialised', pnModAPIFunc('Modules', 'admin', 'list', array('state' => PNMODULE_STATE_UNINITIALISED)));
    $pnRender->assign('mods_missing',       pnModAPIFunc('Modules', 'admin', 'list', array('state' => PNMODULE_STATE_MISSING)));
    $pnRender->assign('mods_invalid',       pnModAPIFunc('Modules', 'admin', 'list', array('state' => PNMODULE_STATE_INVALID)));
    return $pnRender->fetch('Medicula_admin_main.html');
}

function Medicula_admin_modules()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $mods = pnModAPIFunc('modules', 'admin', 'list');
    if(!$mods) {
        LogUtil::registerError(_MEDIC_UNABLETOGETMODS);
    }

    $moduleinfo = array();
    if (!empty($mods)) {
        foreach($mods as $mod) {
            switch ($mod['state']) {
                case PNMODULE_STATE_INACTIVE:
                $status = _INACTIVE;
                break;
                case PNMODULE_STATE_ACTIVE:
                $status = _ACTIVE;
                break;
                case PNMODULE_STATE_MISSING:
                $status = _MEDIC_FILESMISSING;
                break;
                case PNMODULE_STATE_UPGRADED:
                $status = _MEDIC_UPGRADED;
                break;
                case PNMODULE_STATE_INVALID:
                $status = _MEDIC_INVALID;
                break;
                case PNMODULE_STATE_UNINITIALISED:
                default:
                $status = _MEDIC_UNINIT;
                break;
            }
            $moduleinfo[] = array('modinfo' => $mod, 'status' => $status);
        }
    }

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    $pnRender->assign('modules',$moduleinfo);
    return $pnRender->fetch('Medicula_admin_mods.html');
}

function Medicula_admin_changestate()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $id   = FormUtil::getPassedValue('id');
    $modinfo = pnModGetInfo($id);
    if(!is_array($modinfo)) {
        LogUtil::registerError(_MEDIC_UNABLETOGETMODINFO);
        return pnRedirect(pnModURL('Medicula', 'admin', 'modules'));
    }

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    $pnRender->assign('modinfo',$modinfo);
    return $pnRender->fetch('Medicula_admin_changestate.html');
}

function Medicula_admin_setstate()
{
    if (!SecurityUtil::confirmAuthKey()) {
        return LogUtil::registerAuthidError (pnModURL('Medicula','admin','main'));
    }

    $id     = FormUtil::getPassedValue('id');
    $new_state = FormUtil::getPassedValue('new_state');

    if (pnModAPIFunc('Modules', 'admin', 'setstate', array('id' => $id, 'state' => $new_state))) {
        LogUtil::registerStatus (_MEDIC_STATECHANGED);
    }

    return pnRedirect(pnModURL('Medicula', 'admin', 'modules'));
}

function Medicula_admin_modsremove()
{
    if (!SecurityUtil::confirmAuthKey()) {
        return LogUtil::registerAuthidError (pnModURL('Medicula','admin','main'));
    }

    $delmods = FormUtil::getPassedValue('delmods');
    if(!is_array($delmods)) {
        LogUtil::registerError(_MEDIC_NOTHINGSEL);
        return pnRedirect(pnModURL('Medicula', 'admin', 'modules'));
    }

    $cnt_removed = pnModAPIFunc( 'Medicula', 'admin', 'modsremove', array('delmods' => $delmods));
    if($cnt_removed) {
        LogUtil::registerStatus(_MEDIC_M_DELMODS);
    }

    return pnRedirect(pnModURL('Medicula', 'admin', 'modules'));
}

function Medicula_admin_sessions()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $user_sessions = pnModAPIFunc( 'Medicula', 'admin', 'usersessions');
    if(!$user_sessions) {
        LogUtil::registerError(_MEDIC_UNABLETOGETSESS);
    }

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    $pnRender->assign('user_sessions',$user_sessions);
    $pnRender->assign('mysessid',  session_id() );
    $pnRender->assign('myuid', pnUserGetVar('uid') );
    return $pnRender->fetch('Medicula_admin_sessions.html');
}

function Medicula_admin_sessionsremove()
{
    if (!SecurityUtil::confirmAuthKey()) {
        return LogUtil::registerAuthidError (pnModURL('Medicula','admin','main'));
    }

    $delsessions = FormUtil::getPassedValue('delsessions');
    if(!is_array($delsessions)) {
        LogUtil::registerError(_MEDIC_NOTHINGSEL);
        return pnRedirect(pnModURL('Medicula', 'admin', 'sessions'));
    }

    $cnt_removed = pnModAPIFunc( 'Medicula', 'admin', 'sessionsremove', array('delsessions' => $delsessions));
    if($cnt_removed) {
        LogUtil::registerStatus(_MEDIC_M_DELSESS);
    }

    return pnRedirect(pnModURL('Medicula', 'admin', 'sessions'));
}

function Medicula_admin_hooks()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $orp_hooks = pnModAPIFunc( 'Medicula', 'admin', 'orphanedhooks');

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    $pnRender->assign('hook_list', $orp_hooks);
    return $pnRender->fetch('Medicula_admin_hooks.html');
}

function Medicula_admin_hooksremove()
{
    if (!SecurityUtil::confirmAuthKey()) {
        return LogUtil::registerAuthidError (pnModURL('Medicula','admin','main'));
    }

    $delhooks = FormUtil::getPassedValue('delhooks');
    if(!is_array($delhooks)) {
        LogUtil::registerError(_MEDIC_NOTHINGSEL);
        return pnRedirect(pnModURL('Medicula', 'admin', 'hooks'));
    }

    $cnt_removed = pnModAPIFunc( 'Medicula', 'admin', 'hooksremove', array('delhooks' => $delhooks));
    if($cnt_removed) {
        LogUtil::registerError(_MEDIC_M_REMHOOK);
    }

    return pnRedirect(pnModURL('Medicula', 'admin', 'hooks'));
}

function Medicula_admin_tables()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $mod_list = pnModAPIFunc('Medicula', 'admin', 'getallmods');
    if(!$mod_list) {
        LogUtil::registerError(_MEDIC_UNABLETOGETMODS);
        $orp_tables = array();
    } else {
        $orp_tables = pnModAPIFunc( 'Medicula', 'admin', 'orphanedtables', array('mod_list' => $mod_list));
    }

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    $pnRender->assign('table_list', $orp_tables);
    return $pnRender->fetch('Medicula_admin_tables.html');
}

function Medicula_admin_tablesremove()
{
    if (!SecurityUtil::confirmAuthKey()) {
        return LogUtil::registerAuthidError (pnModURL('Medicula','admin','main'));
    }

    $deltabs = FormUtil::getPassedValue('deltabs');
    if(!is_array($deltabs)) {
        LogUtil::registerError(_MEDIC_NOTHINGSEL);
        return pnRedirect(pnModURL('Medicula', 'admin', 'tables'));
    }

    $cnt_removed = pnModAPIFunc( 'Medicula', 'admin', 'tablesremove', array('deltabs' => $deltabs));
    if($cnt_removed) {
        LogUtil::registerStatus(_MEDIC_M_REMTABLES);
    }

    return pnRedirect(pnModURL('Medicula', 'admin', 'tables'));
}

function Medicula_admin_vars()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $var_list = pnModAPIFunc('Medicula', 'admin', 'orphanedvars');

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    $pnRender->assign('var_list', $var_list);
    return $pnRender->fetch('Medicula_admin_vars.html');
}

function Medicula_admin_varsremove()
{
    if (!SecurityUtil::confirmAuthKey()) {
        return LogUtil::registerAuthidError (pnModURL('Medicula','admin','main'));
    }

    $delvars = FormUtil::getPassedValue('delvars');
    if(!is_array($delvars)) {
        LogUtil::registerError(_MEDIC_NOTHINGSEL);
        return pnRedirect(pnModURL('Medicula', 'admin', 'vars'));
    }

    $cnt_removed = pnModAPIFunc( 'Medicula', 'admin', 'varsremove', array('delvars' => $delvars));
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

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    return $pnRender->fetch('Medicula_admin_testdata.html');
}

function Medicula_admin_testdatado()
{
    if (!SecurityUtil::confirmAuthKey()) {
        return LogUtil::registerAuthidError (pnModURL('Medicula','admin','main'));
    }

    $suc = 	pnModAPIFunc( 'Medicula', 'admin', 'gentestdata');
    if(!$suc) {
        LogUtil::registerError(_MEDIC_UNABLETESTDATA);
    } else {
        LogUtil::registerStatus(_MEDIC_M_MADETESTDATA);
    }

    return pnRedirect(pnModURL('Medicula', 'admin', 'main'));

}
