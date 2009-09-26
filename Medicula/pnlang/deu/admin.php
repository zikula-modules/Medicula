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
define('_MEDIC_HOME','Start');
define('_MEDIC_VARS','Modulvariablen');
define('_MEDIC_TABLES','Datenbanktabellen');
define('_MEDIC_HOOKS','Modul-Hooks');
define('_MEDIC_SESSIONS','Benutzersessions');
define('_MEDIC_MODS','Module');
define('_MEDIC_TESTDATA','Testdaten');

//messages
define('_MEDIC_M_DELSESS','Ausgew�hlte Session l�schen');
define('_MEDIC_M_REMHOOK','Ausgew�hlte Hooks l�schen');
define('_MEDIC_M_REMTABLES','Ausgew�hlte Tabellen l�schen');
define('_MEDIC_M_REMVARS','Ausgew�hlte Modulvariablen l�schen');
define('_MEDIC_M_DELMODS','Ausgew�hlte Module l�schen');
define('_MEDIC_M_MADETESTDATA','Testdaten anlegen');

//warnings
define('_MEDIC_UNABLETESTDATA','Konnte Testdaten nicht anlegen. M�glicherweise existieren diese Daten bereits.');
define('_MEDIC_NOTHINGSEL','Es wurde keine Auswahl getroffen.');
define('_MEDIC_UNABLETOGETSESS','Sessioninformationen konnten nicht ermittelt werden');
define('_MEDIC_UNABLETOGETHOOKS','Hooks konnten nicht ermittelt werden');
define('_MEDIC_UNABLETOGETMODS','Modulliste konnte nicht ermittelt werden');
define('_MEDIC_UNABLETOGETTABS','Tabelle konnte nicht ermittelt werden');
define('_MEDIC_UNABLETOGETVARS','Modulvariablen konnten nicht ermittelt werden');
define('_MEDIC_UNABLETOGETMODINFO','Modulinformationen konnten nicht ermittelt werden');

//ERRORS
define('_MEDIC_UNABLETOGETHOOKS','Hookliste konnte nicht ermittelt werden.');
define('_MEDIC_UNABLETOGETVARS','Modulvariablen konnten nicht ermittelt werden.');
define('_MEDIC_UNABLETOGETMODS','Modulliste konnte nicht ermittelt werden.');

//notifications
define('_MEDIC_IN_PICKTOOL','Willkommen bei Medicula. Das Modul stellt diverse Tools zur Verf�gung, um die Datenbank zu bereinigen oder zu ver�ndern. Bitte das Modul stets sorgf�ltig verwenden und vor der Nutzung unbedingt eine Datensicherung anlegen.');
define('_MEDIC_ABOUTTESTDATA','Falls die Datenbank bereits im guten Zustand ist kann Medicula dennoch getestet werden. �ber diese Aktion k�nnen Testdaten f�r jedes Medicula-Feature angelegt werden. Diese Testdaten haben �brigens keine negativen Konsequenten f�r die Datenbank. Das System wird auch mit diesen Daten einwandfrei funktionieren.');
define('_MEDIC_TABSREMWARNING','Bitte �ber die m�glichen Auswirkungen dieser Aktion im Klaren sein. Nach dieser Best�tigung wird keine weitere Abfrage durchgef�hrt und die markierten Tabellen werden entfernt.');

define('_MEDIC_VARSFOUND','Die folgenden Modulevariablen sind anscheinend ung�ltig und haben kein Bezug auf ein momentan installiertes Modul. Bitte die folgende Aktion best�tigen, um die Variablen zu l�schen.');
define('_MEDIC_MODSFOUND','Die folgende Module werden unabh�ngig des Status angezeigt. Die ausgew�hlten Module k�nnen �ber die Schaltfl�che unten aus der Modultabelle gel�scht werden.');
define('_MEDIC_MODSREMWARNING','Bitte �ber die m�glichen Auswirkungen dieser Aktion im Klaren sein. Nach dieser Best�tigung wird keine weitere Abfrage durchgef�hrt und die markierten Module werden direkt gel�scht. Auf m�gliche Modulvariablen, Hook und Modulabh�ngigkeiten wird keine R�cksicht genommen.');
define('_MEDIC_MODSSTATEWARNING','Bitte �ber die m�glichen Auswirkungen dieser Aktion im Klaren sein. Der Modulstatus wird ohne weitere Initialisierungsschritte unverz�glich ge�ndert.');

define('_MEDIC_NOTABS','Es k�nnten keine Datenbanktabellen gefunden werden, die mit diesem Modul verkn�pft sind.');
define('_MEDIC_TABSFOUND','Die folgende Liste beinhaltet alle undefinierten Datenbanktabellen. Die markierten Tabellen k�nnen �ber die Schaltfl�che entfernt werden..');
define('_MEDIC_HOOKSFOUND','Die folgende Liste beinhaltet alle Hooks, die keinem Zielmodul zugeordnet sind. Die markierten Hooks k�nnen �ber die Schaltfl�che gel�scht werden.');
define('_MEDIC_SESSFOUND','Diese Liste zeigt alle aktiven Benutzersitzungen. Die ausgew�hlten Sessions k�nnen �ber die Schaltfl�che entfernt werden.');
define('_MEDIC_NOHOOKS','Keine ungenutzten Hooks gefunden.');
define('_MEDIC_NOVARS','Keine ungenutzten Modulvariablen gefunden.');
define('_MEDIC_NOSESSIONS','Keine Benutzersessions gefunden.');
define('_MEDIC_NOMODS','Keine Module gefunden.');
define('_MEDIC_IN_ABOUTTSESS','Bei der fettgedruckten Benutzersession handelt es sich um die eigene Sitzung, die nicht gel�scht werden kann.');

//column headers
define('_MEDIC_MODULE','Modul');
define('_MEDIC_VERSION','Version');
define('_MEDIC_DISPNAME', 'Anzeigename');
define('_MEDIC_DIRECTORY', 'Verzeichnis');
define('_MEDIC_STATE', 'Status');
define('_MEDIC_DESCRIPTION','Beschreibung');
define('_MEDIC_VARNAME','Variable');
define('_MEDIC_UNAME','Benutzername');
define('_MEDIC_IPADDRESS','IP-Adresse');
define('_MEDIC_LASTUSED','Zuletzt genutzt');
define('_MEDIC_TARGMOD','Zielmodul');
define('_MEDIC_SOURCEMOD','Quellmodul');
define('_MEDIC_ACTION','Aktion');

//buttons
define('_MEDIC_REMSEL','Ausgew�hlte Eintr�ge entfernen');
define('_MEDIC_DELSEL','Ausgew�hlte Eintr�ge l�schen');

//states
define('_MEDIC_MODULES', 'Module');
define('_MEDIC_INVALID', 'Ung�ltig');
define('_MEDIC_UNINIT', 'Nicht installiert');
define('_MEDIC_FILESMISSING', 'Dateien fehlen');
define('_MEDIC_UPGRADED', 'Neue Version installiert');
define('_MEDIC_CHANGESTATE', 'Status �ndern');
define('_MEDIC_STATECHANGED', 'Status wurde ge�ndert');
