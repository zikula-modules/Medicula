<?php
// File: $Id$
// ----------------------------------------------------------------------

// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------
// Original Author of file: Polites
// Purpose of file: module initialization
// ----------------------------------------------------------------------
// Last changes by Polites, http://www.polites.net
// ----------------------------------------------------------------------

function pnMedic_init_interactiveinit()
{

    if (!pnSecAuthAction(0, '::', '::', ACCESS_ADMIN))
        return pnVarPrepHTMLDisplay(_MODULENOAUTH);

    $pnRender =& new pnRender('pnMedic');
    $pnRender->caching = false;
	$pnRender->assign('authid', pnSecGenAuthKey('Modules'));
    return $pnRender->fetch('pnMedic_init_1.html');
	
}
function pnMedic_init(){

	return true;
}
function pnMedic_upgrade($oldversion){

    return true;
	
}

function pnMedic_init_interactivedelete()
{

    if (!pnSecAuthAction(0, '::', '::', ACCESS_ADMIN))
        return pnVarPrepHTMLDisplay(_MODULENOAUTH);
 
    $pnRender =& new pnRender('pnMedic');
    $pnRender->caching = false;
    $pnRender->assign('authid', pnSecGenAuthKey('Modules'));
	
    return $pnRender->fetch('pnMedic_init_delete.html');
}

function pnMedic_delete()
{
	
    return true;
}

?>
