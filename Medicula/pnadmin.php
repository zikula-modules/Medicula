<?php
// File: $Id$
// ----------------------------------------------------------------------

// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------
// Original Author of file: Polites
// Purpose of file: Admin function calls
// ----------------------------------------------------------------------
// Last changes by Polites, http://www.polites.net
// ----------------------------------------------------------------------


//MODULES
function pnMedic_admin_main()
{

	if (!pnSecAuthAction(0, 'pnMedic::', '::', ACCESS_ADMIN))
		return pnVarPrepForDisplay(_MODULENOAUTH);
	$mediclasttool = pnSessionGetVar('mediclasttool') ;
	if(!empty($mediclasttool))
		return pnRedirect(pnModURL('pnMedic', 'admin', pnSessionGetVar('mediclasttool')));
	
	$pnRender =& new pnRender('pnMedic');	
    $pnRender->caching = false;			

    return $pnRender->fetch('pnMedic_admin_main.html');	    
	

}	

function pnMedic_admin_modules()
{

	if (!pnSecAuthAction(0, 'pnMedic::', '::', ACCESS_ADMIN))
		return pnVarPrepForDisplay(_MODULENOAUTH);
		
	pnSessionSetVar('mediclasttool', 'modules');	
	
    $mods = pnModAPIFunc(	'modules',
                   			'admin',
                   			'list');	
							
	if(!$mods)
		pnSessionSetVar('errormsg', _MEDIC_UNABLETOGETMODS );

	$pnRender =& new pnRender('pnMedic');	
    $pnRender->caching = false;		
	$pnRender->assign('modules',$mods);	
	$pnRender->assign('module_count', count($mods));	
	$pnRender->assign('authid',pnSecGenAuthKey());	
		
    return $pnRender->fetch('pnMedic_admin_mods.html');	    
	

}

function pnMedic_admin_modsremove()
{

    if (!pnSecConfirmAuthKey()) {
	
        pnSessionSetVar('errormsg', _BADAUTHKEY);
        return pnRedirect(pnModURL('pnMedic', 'admin', 'modules'));
		
    } 
	
	$delmods = pnVarCleanFromInput('delmods');
	
	if(!is_array($delmods)) {
		
		pnSessionSetVar('errormsg', pnVarPrepForDisplay( _MEDIC_NOTHINGSEL) );
		return pnRedirect(pnModURL('pnMedic', 'admin', 'modules'));
		
	}
	
    $cnt_removed = pnModAPIFunc(	'pnMedic',
                        			'admin',
                        			'modsremove',
									array('delmods'=>$delmods));		
	if($cnt_removed)
		pnSessionSetVar('statusmsg', pnVarPrepHTMLDisplay(_MEDIC_M_DELMODS));
									
	return pnRedirect(pnModURL('pnMedic', 'admin', 'modules'));

}

//USERSESSIONS
function pnMedic_admin_sessions()
{

	if (!pnSecAuthAction(0, 'pnMedic::', '::', ACCESS_ADMIN))
		return pnVarPrepForDisplay(_MODULENOAUTH);
	pnSessionSetVar('mediclasttool', 'sessions');	
	
    $user_sessions = pnModAPIFunc(	'pnMedic',
                        			'admin',
                        			'usersessions');	
	if(!$user_sessions)
		pnSessionSetVar('errormsg', _MEDIC_UNABLETOGETSESS );

	$pnRender =& new pnRender('pnMedic');	
    $pnRender->caching = false;		
	$pnRender->assign('user_sessions',$user_sessions);	
	$pnRender->assign('session_count', count($user_sessions));	
	$pnRender->assign('mysessid',  session_id() );
	$pnRender->assign('myuid', pnUserGetVar('uid') );	
	$pnRender->assign('authid',pnSecGenAuthKey());	
		
    return $pnRender->fetch('pnMedic_admin_sessions.html');	    
	

}

function pnMedic_admin_sessionsremove()
{

    if (!pnSecConfirmAuthKey()) {
	
        pnSessionSetVar('errormsg', _BADAUTHKEY);
        return pnRedirect(pnModURL('pnMedic', 'admin', 'sessions'));
		
    } 

	$delsessions = pnVarCleanFromInput('delsessions');
	
	if(!is_array($delsessions)) {
		
		pnSessionSetVar('errormsg', pnVarPrepForDisplay( _MEDIC_NOTHINGSEL) );
		return pnRedirect(pnModURL('pnMedic', 'admin', 'sessions'));
		
	}
	
    $cnt_removed = pnModAPIFunc(	'pnMedic',
                        			'admin',
                        			'sessionsremove',
									array('delsessions'=>$delsessions));		
	if($cnt_removed)
		pnSessionSetVar('statusmsg', pnVarPrepHTMLDisplay(_MEDIC_M_DELSESS));
									
	return pnRedirect(pnModURL('pnMedic', 'admin', 'sessions'));

}

//HOOKS
function pnMedic_admin_hooks()
{

	if (!pnSecAuthAction(0, 'pnMedic::', '::', ACCESS_ADMIN))
		return pnVarPrepForDisplay(_MODULENOAUTH);
	pnSessionSetVar('mediclasttool', 'hooks');	

    $orp_hooks = pnModAPIFunc(	'pnMedic',
                        		'admin',
                        		'orphanedhooks');	
		
	$pnRender =& new pnRender('pnMedic');	
    $pnRender->caching = false;		
	$pnRender->assign('hook_list', $orp_hooks);	
	$pnRender->assign('hook_count', count($orp_hooks));		
	$pnRender->assign('authid',pnSecGenAuthKey());	
		
    return $pnRender->fetch('pnMedic_admin_hooks.html');	    
	

}

function pnMedic_admin_hooksremove()
{

    if (!pnSecConfirmAuthKey()) {
	
        pnSessionSetVar('errormsg', _BADAUTHKEY);
        return pnRedirect(pnModURL('pnMedic', 'admin', 'hooks'));
		
    } 

	$delhooks = pnVarCleanFromInput('delhooks');
	
	if(!is_array($delhooks)) {
		
		pnSessionSetVar('errormsg', pnVarPrepForDisplay( _MEDIC_NOTHINGSEL) );
		return pnRedirect(pnModURL('pnMedic', 'admin', 'hooks'));
		
	}
	
    $cnt_removed = pnModAPIFunc(	'pnMedic',
                        			'admin',
                        			'hooksremove',
									array('delhooks'=>$delhooks));		
	if($cnt_removed)
		pnSessionSetVar('statusmsg', pnVarPrepHTMLDisplay(_MEDIC_M_REMHOOK));
												
	return pnRedirect(pnModURL('pnMedic', 'admin', 'hooks'));

}

//TABLES

function pnMedic_admin_tables()
{

	if (!pnSecAuthAction(0, 'pnMedic::', '::', ACCESS_ADMIN))
		return pnVarPrepForDisplay(_MODULENOAUTH);
	pnSessionSetVar('mediclasttool', 'tables');

    $mod_list = pnModAPIFunc(	'pnMedic',
                        		'admin',
                        		'getallmods');	
	if(!$mod_list) {
	
		pnSessionSetVar('errormsg', _MEDIC_UNABLETOGETMODS );
		$orp_tables = array() ;
		
	} else {
	
		$orp_tables = pnModAPIFunc(	'pnMedic',
									'admin',
									'orphanedtables',
									array('mod_list'=>$mod_list));		
	
	}
									
	$pnRender =& new pnRender('pnMedic');	
    $pnRender->caching = false;			
	$pnRender->assign('table_list', $orp_tables);	
	$pnRender->assign('table_count', count($orp_tables));		
	$pnRender->assign('authid',pnSecGenAuthKey());	
    return $pnRender->fetch('pnMedic_admin_tables.html');	    
	

}

function pnMedic_admin_tablesremove()
{

    if (!pnSecConfirmAuthKey()) {
	
        pnSessionSetVar('errormsg', _BADAUTHKEY);
        return pnRedirect(pnModURL('pnMedic', 'admin', 'tables'));
		
    } 

	$deltabs = pnVarCleanFromInput('deltabs');
	
	if(!is_array($deltabs)) {
		
		pnSessionSetVar('errormsg', pnVarPrepForDisplay( _MEDIC_NOTHINGSEL) );
		return pnRedirect(pnModURL('pnMedic', 'admin', 'tables'));
		
	}
	
    $cnt_removed = pnModAPIFunc(	'pnMedic',
                        			'admin',
                        			'tablesremove',
									array('deltabs'=>$deltabs));		
	if($cnt_removed)
		pnSessionSetVar('statusmsg', pnVarPrepHTMLDisplay(_MEDIC_M_REMTABLES));
											
	return pnRedirect(pnModURL('pnMedic', 'admin', 'tables'));

}

//VARS
function pnMedic_admin_vars()
{

	if (!pnSecAuthAction(0, 'pnMedic::', '::', ACCESS_ADMIN))
		return pnVarPrepForDisplay(_MODULENOAUTH);
	pnSessionSetVar('mediclasttool', 'vars');

    $var_list = pnModAPIFunc(	'pnMedic',
                        		'admin',
                        		'orphanedvars');	
	
	$pnRender =& new pnRender('pnMedic');	
    $pnRender->caching = false;		
	$pnRender->assign('var_list', $var_list);	
	$pnRender->assign('var_count', count($var_list));		
	$pnRender->assign('authid',pnSecGenAuthKey());		
    return $pnRender->fetch('pnMedic_admin_vars.html');	    

}


function pnMedic_admin_varsremove()
{

    if (!pnSecConfirmAuthKey()) {
	
        pnSessionSetVar('errormsg', _BADAUTHKEY);
        return pnRedirect(pnModURL('pnMedic', 'admin', 'vars'));
		
    } 

	$delvars = pnVarCleanFromInput('delvars');

	if(!is_array($delvars)) {
		
		pnSessionSetVar('errormsg', pnVarPrepForDisplay( _MEDIC_NOTHINGSEL) );
		return pnRedirect(pnModURL('pnMedic', 'admin', 'vars'));
		
	}
	
    $cnt_removed = pnModAPIFunc(	'pnMedic',
                        			'admin',
                        			'varsremove',
									array('delvars'=>$delvars));		
	if($cnt_removed)
		pnSessionSetVar('statusmsg', pnVarPrepHTMLDisplay(_MEDIC_M_REMVARS));
		
	return pnRedirect(pnModURL('pnMedic', 'admin', 'vars'));

}
function pnMedic_admin_testdata()
{

	if (!pnSecAuthAction(0, 'pnMedic::', '::', ACCESS_ADMIN))
		return pnVarPrepForDisplay(_MODULENOAUTH);
		
	pnSessionSetVar('mediclasttool', 'testdata');
	
	$pnRender =& new pnRender('pnMedic');	
    $pnRender->caching = false;		
	$pnRender->assign('authid',pnSecGenAuthKey());		
    return $pnRender->fetch('pnMedic_admin_testdata.html');	

}
function pnMedic_admin_testdatado()
{

    if (!pnSecConfirmAuthKey()) {
	
        pnSessionSetVar('errormsg', _BADAUTHKEY);
        return pnRedirect(pnModURL('pnMedic', 'admin', 'testdata'));
		
    } 

    $suc = 	pnModAPIFunc(	'pnMedic',
							'admin',
							'gentestdata');	

	if(!$suc) {
	
		pnSessionSetVar('errormsg', pnVarPrepForDisplay( _MEDIC_UNABLETESTDATA) );
	
	} else {
	
		pnSessionSetVar('statusmsg', pnVarPrepHTMLDisplay(_MEDIC_M_MADETESTDATA));
		
	}

    return pnRedirect(pnModURL('pnMedic', 'admin', 'testdata'));    

}
?>