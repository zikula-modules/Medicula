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

function Medicula_init_interactiveinit()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    $pnRender->assign('authid', pnSecGenAuthKey('Modules'));
    return $pnRender->fetch('Medicula_init_1.html');

}

function Medicula_init()
{
    return true;
}

function Medicula_upgrade($oldversion)
{
    return true;
}

function Medicula_init_interactivedelete()
{
    if (!SecurityUtil::checkPermission('Medicula::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    $pnRender = pnRender::getInstance('Medicula', false, null, true);
    $pnRender->assign('authid', pnSecGenAuthKey('Modules'));
    return $pnRender->fetch('Medicula_init_delete.html');
}

function Medicula_delete()
{
    return true;
}
