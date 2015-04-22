<?php
/*****************************************************/
/***   _____             _                    ___  ***/
/***   \_   \_ ____   __(_)___    /\/\/\   /\/ __\ ***/
/***    / /\/ '_ \ \ / /| / __|  /    \ \ / / /    ***/
/*** /\/ /_ | | | \ V / | \__ \ / /\/\ \ V / /___  ***/
/*** \____/ |_| |_|\_/  |_|___/ \/    \/\_/\____/  ***/
/***                                               ***/
/*****************************************************/
/***                                               ***/
/*** Name      :  Invis MVC                        ***/
/*** Copyright :  (c) 2011, Invis MVC Team         ***/
/*** License   :  http://www.invismvc.com/license  ***/
/*** Contact   :  mail@invismvc.com                ***/
/***                                               ***/
/*** File      :  index.php                        ***/
/*** Version   :  1.0                              ***/
/***                                               ***/
/*****************************************************/
/*****************************************************/


/*****************************************************/
/***                  MAIN CONF                    ***/
/*****************************************************/

set_time_limit(0);
session_start();
error_reporting(E_ALL);

$baseurl = 'http://localhost/iSolution/';
if(!defined('DS')) define('DS',DIRECTORY_SEPARATOR);

/* set the base directory */
if(!defined('INVIS_BASEDIR')) define('INVIS_BASEDIR',dirname(__FILE__) . DS );



/* define myapp directory */
if(!defined('INVIS_MYAPPDIR'))
define('INVIS_MYAPPDIR', INVIS_BASEDIR . 'application' . DS);

/* define Debug mode setting directory */
if(!defined('D_MODE'))
define('DMODE', true);

/* define recaptcha PRIVATEKEY setting directory */
if(!defined('PRIVATEKEY'))
define('PRIVATEKEY', "6Lf44MUSAAAAAB-qqziEUmAEBXFRLuJJ6nSXC3B4");

/* define recaptcha PUBLICKEY setting directory */
if(!defined('PUBLICKEY'))
define('PUBLICKEY', "6Lf44MUSAAAAAD8SFrXBpa5YxzPPD4RQurhIJNQa");

/* define time period */
if(!defined('PERIOD'))
define('PERIOD', 60);

$GLOBALS['time_base']=microtime(true);


/*****************************************************/
/***              BASECLASSLOADING                 ***/
/*****************************************************/

include "system/g.php";
include "system/raintpl.php";
include "system/icontroller.php";
include "system/imodel.php";
include "system/ilibrary.php";
include 'system/extend/XMPPHP/XMPP.php';
/*****************************************************/
/***                  ROUTING                      ***/
/*****************************************************/
$url_segments = null;
/* URL style: use true to enable query string in url */
$config['url_query'] =  true;

/* URL routing, use preg_replace() compatible syntax */
$config['routing']['search'] =  array();
$config['routing']['replace'] = array();

/* set this to force controller and method instead of using URL params */
$config['root_controller'] = null;
$config['root_action'] = null;


/* name of default controller/method when none is given in the URL */
$config['default_controller'] = 'default';
$config['default_action'] = 'index';


/*****************************************************/
/***              DATABASE CONF                    ***/
/*****************************************************/

$config['default']['host'] = 'localhost';//'beta.unitedempires.com';//'localhost';//'unitedempires.db.4280817.hostedresource.com';  // db hostname
$config['default']['name'] = 'isolution';//'beta-ue';     // db name
$config['default']['user'] = 'root';//'beta-ue';//;     // db username
$config['default']['pass'] = '';//'7T0mfzKj';//'reviveGS411';     // db password


/*****************************************************/
/***              CHAT SERVER CONF                    ***/
/*****************************************************/

$config['chatserver']['host'] = 'localhost';//'metehan7';//'unitedempires.db.4280817.hostedresource.com';  // db hostname
$config['chatserver']['port'] = 9090;//'localhost';//'unitedempires.db.4280817.hostedresource.com';  // db hostname
$config['chatserver']['skey'] = 'bDhyr65';     // db name 
$config['chatserver']['domain'] = 'rana';     // db name 


/*****************************************************/
/***                RAINTPL CONF                   ***/
/*****************************************************/

raintpl::configure("base_url", $baseurl );
raintpl::configure("tpl_dir", "application/views/" );
raintpl::configure("cache_dir", "application/cache/" );
raintpl::configure("check_template_update", true );
raintpl::configure("language","tr_TR");

/*****************************************************/
/***                GETTEXT CONF                   ***/
/*****************************************************/


//$locale = "tr_TR";
$locale = "en_US";

putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain("messages", "./locale");
textdomain("messages");

/*****************************************************/
/***              *end of configurations*          ***/
/*****************************************************/



include "system/invis.php";

$invis = new invis();
$invis->main();
