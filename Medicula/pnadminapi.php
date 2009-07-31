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

function Medicula_adminapi_modsremove($args)
{

    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    extract($args);
    unset($args);

    if(!isset($delmods) || !is_array($delmods)) {
        LogUtil::registerError(_MODARGSERROR);
        return false;
    }

    $cnt_del = 0;

    $dbconn =& pnDBGetConn(true);
    $pntable =& pnDBGetTables();
    $modulestable = $pntable['modules'];
    $modulescolumn = &$pntable['modules_column'];

    foreach($delmods as $delmod) {

        $sql = 	"DELETE FROM $modulestable
        WHERE $modulescolumn[id] = '" . (int) DataUtil::formatForStore($delmod) . "'";
        if($dbconn->Execute($sql))
        $cnt_del++;

    }
    return $cnt_del;
}

function Medicula_adminapi_usersessions()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $dbconn =& pnDBGetConn(true);
    $pntable =& pnDBGetTables();
    $session_table = $pntable['session_info'];
    $session_column = &$pntable['session_info_column'];

    $sql = 	"SELECT
    $session_column[uid],
    $session_column[ipaddr],
    $session_column[sessid],
    $session_column[lastused]
    FROM
    $session_table
    ORDER BY $session_column[uid]
    ";

    if(!$result = $dbconn->Execute($sql)) {
        return false;
    }

    $user_sessions = array();

    while ($sess = $result->FetchRow()) {

        list($uid, $ipaddr,$sessid,$lastused ) = $sess;
        $uname = pnUserGetVar('uname',$uid);
        $user_sessions[] = array(	'uid'=>$uid,
        'uname'=>$uname,
        'ipaddr'=>$ipaddr,
        'sessid'=>$sessid,
        'lastused'=>$lastused);

    }
    $result->Close();
    return $user_sessions;

}

function Medicula_adminapi_sessionsremove($args)
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    extract($args);
    unset($args);

    if(!isset($delsessions) || !is_array($delsessions)) {
        LogUtil::registerError(_MODARGSERROR);
        return false;
    }

    $dbconn =& pnDBGetConn(true);
    $pntable =& pnDBGetTables();
    $session_table = $pntable['session_info'];
    $session_column = &$pntable['session_info_column'];

    $cnt_del = 0;
    foreach($delsessions as $delsession) {

        $delsession = DataUtil::formatForStore($delsession);

        $sql = 	"SELECT
        COUNT(1)
        FROM $session_table
        WHERE $session_column[sessid] = '$delsession'
        ";
        $mysessid = session_id();
        if($result = $dbconn->Execute($sql)) {

            list($numitems) = $result->fields;

            if ($numitems > 0) {

                $sql =	"DELETE
                FROM $session_table
                WHERE $session_column[sessid] = '$delsession'
                AND $session_column[sessid] != '$mysessid'
                ";
                if($dbconn->Execute($sql))
                $cnt_del++;

            }

        }

    }
    return $cnt_del;
}

function Medicula_adminapi_tablesremove($args)
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    extract($args);
    unset($args);

    if(!isset($deltabs) || !is_array($deltabs)) {
        LogUtil::registerError(_MODARGSERROR);
        return false;
    }

    $cnt_del = 0;
    $dbconn =& pnDBGetConn(true);
    $dict = &NewDataDictionary($dbconn);
    $pntables = $dbconn->MetaTables('TABLES');

    foreach($deltabs as $deltab) {

        //we're going to make sure that the table to drop
        //in actually a valid table name per the MetaTables array
        if(in_array($deltab,$pntables)) {

            $sqlarray = $dict->DropTableSQL($deltab);

            if (@$dict->ExecuteSQLArray($sqlarray) != 2) {

                $cnt_fail++;

            } else {

                $cnt_del++;

            }

        }

    }
    return $cnt_del;
}

function Medicula_adminapi_varsremove($args)
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }
    extract($args);
    unset($args);

    if(!isset($delvars) || !is_array($delvars)) {
        LogUtil::registerError(_MODARGSERROR);
        return false;
    }

    $cnt_del = 0;
    foreach($delvars as $delvar) {

        $temp = explode ( '-', $delvar );
        if(count($temp) == 2) {

            if(pnModDelVar($temp[0], $temp[1]))
            $cnt_del++;

        }

    }
    return $cnt_del;

}

function Medicula_adminapi_getallmods()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $pntable = pnDBGetTables();
    $modulescolumn = $pntable['modules_column'];
    $where = "WHERE $modulescolumn[state] = " . PNMODULE_STATE_INACTIVE . "
              OR $modulescolumn[state] = " . PNMODULE_STATE_ACTIVE . "
              OR $modulescolumn[state] = " . PNMODULE_STATE_UPGRADED . "";
    $orderBy = "ORDER BY $modulescolumn[displayname]";
    $modsarray = DBUtil::selectObjectArray('modules', $where, $orderBy);
    if ($modsarray === false) {
        return false;
    }

    $mod_list = array();
    foreach($modsarray as $mod) {
        $mod_list[] = array('name'=>$mod["name"],'directory'=>$mod["directory"]);
    }

    return $mod_list;

}

function Medicula_adminapi_orphanedtables($args)
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }
    extract($args);
    unset($args);

    if(!isset($mod_list) || !is_array($mod_list)) {
        LogUtil::registerError(_MODARGSERROR);
        return false;
    }

    $dbconn =& pnDBGetConn(true);
    $mod_tab_defs = array();

    foreach($mod_list as $mod) {
        pnModDBInfoLoad($mod["name"]);
    }
    $pntable = pnDBGetTables();

    foreach($pntable as $table_name) {
        if(!is_array($table_name))
        $mod_tab_defs[] = $table_name;
    }
    unset($pntable);
    $pntable = $dbconn->MetaTables('TABLES');
    return array_diff($pntable,$mod_tab_defs);
}

function Medicula_adminapi_orphanedvars()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }
    $dbconn =& pnDBGetConn(true);
    $pntable =& pnDBGetTables();
    $vars_table = $pntable['module_vars'];
    $vars_column = &$pntable['module_vars_column'];

    $sql = 	"SELECT
    $vars_column[modname],
    $vars_column[name]
    FROM
    $vars_table
    WHERE $vars_column[modname] != '/PNConfig'
    ";

    if(!$result = $dbconn->Execute($sql)) {
        return false;
    }

    $unmatched_vars = array();

    while ($var = $result->FetchRow()) {
        list($modname, $varname) = $var;
        if(!pnModAvailable($modname))
        $unmatched_vars[] = array('modname'=>$modname,'varname'=>$varname);
    }
    $result->Close();
    return $unmatched_vars;
}

function Medicula_adminapi_orphanedhooks()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $dbconn =& pnDBGetConn(true);
    $pntable =& pnDBGetTables();
    $hooks_table = $pntable['hooks'];
    $hooks_column = &$pntable['hooks_column'];

    $sql = 	"SELECT
    $hooks_column[id],
    $hooks_column[tmodule],
    $hooks_column[smodule],
    $hooks_column[action]
    FROM
    $hooks_table
    ";

    if(!$result = $dbconn->Execute($sql)) {
        return false;
    }

    $unmatched_hooks = array();

    while ($target_hook = $result->FetchRow()) {

        list($id, $tmodule,$smodule,$action) = $target_hook;

        if(!pnModAvailable($tmodule))
        $unmatched_hooks[] = array(	'id'=>$id,
        'tmodule'=>$tmodule,
        'smodule'=>$smodule,
        'action'=>$action);

    }

    $result->Close();
    return $unmatched_hooks;

}
function Medicula_adminapi_hooksremove($args)
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    extract($args);
    unset($args);

    if(!isset($delhooks) || !is_array($delhooks))  {
        LogUtil::registerError(_MODARGSERROR);
        return false;
    }

    $dbconn =& pnDBGetConn(true);
    $pntable =& pnDBGetTables();
    $hooks_table = $pntable['hooks'];
    $hooks_column = &$pntable['hooks_column'];

    $cnt_del = 0;
    foreach($delhooks as $delhook) {

        $sql = 	"SELECT
        COUNT(1)
        FROM $hooks_table
        WHERE $hooks_column[id] = $delhook
        ";

        if($result = $dbconn->Execute($sql)) {

            list($numitems) = $result->fields;

            if ($numitems > 0) {

                $sql =	"DELETE
                FROM $hooks_table
                WHERE $hooks_column[id] = $delhook
                ";
                if($dbconn->Execute($sql))
                $cnt_del++;

            }

        }

    }
    return $cnt_del;

}


function Medicula_adminapi_gentestdata()
{

    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $dbconn =& pnDBGetConn(true);
    $dict = &NewDataDictionary($dbconn);
    $taboptarray =& pnDBGetTableOptions();

    $test_table = pnConfigGetVar('prefix') . '_Medicula_test_ok_to_delete';
    $flds = "
    pn_zipadee    	I	AUTOINCREMENT PRIMARY,
    pn_doodah	   	I	NOTNULL DEFAULT 0
    ";
    $sqlarray = $dict->CreateTableSQL($test_table, $flds, $taboptarray);
    if (@$dict->ExecuteSQLArray($sqlarray) != 2)
    return false;

    SessionUtil::setVar('MediculaTest', 'ok_to_delete_1', 1);
    SessionUtil::setVar('MediculaTest', 'ok_to_delete_2', 2);
    SessionUtil::setVar('MediculaTest', 'ok_to_delete_3', 3);

    return true;
}

/**
 * get available admin panel links
 *
 * @return array array of admin links
 */
function Medicula_adminapi_getlinks()
{
    $links = array();
    if (SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        $links[] = array('url' => pnModURL('Medicula', 'admin', 'main'), 'text' => _MEDIC_HOME, 'title' => _MEDIC_HOME);
        $links[] = array('url' => pnModURL('Medicula', 'admin', 'vars'), 'text' => _MEDIC_VARS, 'title' => _MEDIC_VARS);
        $links[] = array('url' => pnModURL('Medicula', 'admin', 'tables'), 'text' => _MEDIC_TABLES, 'title' => _MEDIC_TABLES);
        $links[] = array('url' => pnModURL('Medicula', 'admin', 'hooks'), 'text' => _MEDIC_HOOKS, 'title' => _MEDIC_HOOKS);
        $links[] = array('url' => pnModURL('Medicula', 'admin', 'sessions'), 'text' => _MEDIC_SESSIONS, 'title' => _MEDIC_SESSIONS);
        $links[] = array('url' => pnModURL('Medicula', 'admin', 'modules'), 'text' => _MEDIC_MODS, 'title' => _MEDIC_MODS);
    }
    return $links;
}
