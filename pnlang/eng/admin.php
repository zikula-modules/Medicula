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

// Main Admin Menu Items

define('_MEDIC_TITLE','Medicula');

//menu titles
define('_MEDIC_HOME','Home');
define('_MEDIC_VARS','Module Variables');
define('_MEDIC_TABLES','Database Tables');
define('_MEDIC_HOOKS','Module Hooks');
define('_MEDIC_SESSIONS','User Sessions');
define('_MEDIC_MODS','Modules');
define('_MEDIC_TESTDATA','Test Data');

//messages
define('_MEDIC_M_DELSESS','Deleted selected sessions');
define('_MEDIC_M_REMHOOK','Removed selected hooks');
define('_MEDIC_M_REMTABLES','Removed selected tables');
define('_MEDIC_M_REMVARS','Removed selected module variables');
define('_MEDIC_M_DELMODS','Removed selected modules');
define('_MEDIC_M_MADETESTDATA','Created test data');

//warnings
define('_MEDIC_UNABLETESTDATA','Unable to create test data. Some data may already exist.');
define('_MEDIC_NOTHINGSEL','Nothing was selected for removal');
define('_MEDIC_UNABLETOGETSESS','Unable to get session information');
define('_MEDIC_UNABLETOGETHOOKS','Unable to get hooks');
define('_MEDIC_UNABLETOGETMODS','Unable to get module list');
define('_MEDIC_UNABLETOGETTABS','Unable to get table list');
define('_MEDIC_UNABLETOGETVARS','Unable to get module variables');
define('_MEDIC_UNABLETOGETMODINFO','Unable to get module information');

//ERRORS
define('_MEDIC_UNABLETOGETHOOKS','Unable to get hook list.');
define('_MEDIC_UNABLETOGETVARS','Unable to get module variables.');
define('_MEDIC_UNABLETOGETMODS','Unable to get list of modules.');

//notifications
define('_MEDIC_IN_PICKTOOL','Welcome to Medicula. Medicula has several tools to help you clean up your database.  Please choose a tool from the menu above.');
define('_MEDIC_ABOUTTESTDATA','If your database is already in good shape, you can still test the operation of Medicula by using the built-in junk data generation feature. This will create extra data that Medicula will detect such as an orphaned module variable.  This junk data will have no detrimental effect on your database. Click [Go] to continue.');
define('_MEDIC_TABSREMWARNING','Be very aware of the implications of your actions before continuing! After you click [Remove Selected]. there will be no confirmation before the selected tables are dropped forever.');

define('_MEDIC_VARSFOUND','The list below shows all module variables that were found with no parent module.  Check the box next to the variables that you want to remove and click [Remove Selected].');
define('_MEDIC_MODSFOUND','The list below shows all modules in the system regardless of state.  Check the box next to the module that you want to remove and click [Remove Selected].');
define('_MEDIC_MODSREMWARNING','Be very aware of the implications of your actions before continuing! After you click [Remove Selected]. there will be no confirmation before the selected modules are removed without regard to hooks, variables, and other modules which may rely on the selected ones.');
define('_MEDIC_MODSSTATEWARNING','Be very aware of the implications of your actions before continuing! After submitting this form the module state will be changed without any demand.');

define('_MEDIC_NOTABS','No database tables without an associated module were found.');
define('_MEDIC_TABSFOUND','The list below shows all undefined database tables .  Check the box next to the tables that you want to permanently delete and click [Remove Selected].');
define('_MEDIC_HOOKSFOUND','The list below shows hooks without a target module .  Check the box next to the hooks that you want to permanently delete and click [Remove Selected].');
define('_MEDIC_SESSFOUND','This list shows all active user sessions.  Check the box next to the sessions that you want to delete and click [Delete Selected].');
define('_MEDIC_NOHOOKS','No orphaned hooks were found.');
define('_MEDIC_NOVARS','No orphaned module variables were found.');
define('_MEDIC_NOSESSIONS','No user sessions were found.');
define('_MEDIC_NOMODS','No modules were found.');
define('_MEDIC_IN_ABOUTTSESS','User names marked in bold are your own.  Your exact session can be identified by the lack of a check box and as such, cannot be deleted.');

//column headers
define('_MEDIC_MODULE','Module');
define('_MEDIC_VERSION','Version');
define('_MEDIC_DISPNAME', 'Displayname');
define('_MEDIC_DIRECTORY', 'Directory');
define('_MEDIC_STATE', 'State');
define('_MEDIC_DESCRIPTION','Description');
define('_MEDIC_VARNAME','Variable name');
define('_MEDIC_UNAME','User name');
define('_MEDIC_IPADDRESS','IP address');
define('_MEDIC_LASTUSED','Last used');
define('_MEDIC_TARGMOD','Target Module');
define('_MEDIC_SOURCEMOD','Source Module');
define('_MEDIC_ACTION','Action');

//buttons
define('_MEDIC_REMSEL','Remove Selected');
define('_MEDIC_DELSEL','Delete Selected');

//states
define('_MEDIC_MODULES', 'Modules');
define('_MEDIC_INVALID', 'Invalid');
define('_MEDIC_UNINIT', 'Not installed');
define('_MEDIC_FILESMISSING', 'Files missing');
define('_MEDIC_UPGRADED', 'New version installed');
define('_MEDIC_CHANGESTATE', 'Change state');
define('_MEDIC_STATECHANGED', 'State changed');
