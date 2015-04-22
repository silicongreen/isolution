<?php  if ( ! defined('INVIS_BASEDIR')) exit('No direct script access allowed');

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
/*** File      :  system/icontroller.php           ***/
/*** Version   :  1.0                              ***/
/***                                               ***/
/*****************************************************/
/*****************************************************/




/*****************************************************/
/***              CONTROLLER CLASS                 ***/
/*****************************************************/

class iController extends G
{

	/**
	* constructor
	*
	* @access	public
	*/
	function __construct()
	{		
		parent::__construct();
		$this->logSGPC();
		invis::instance($this,'controller');
	}

	/**
	* index
	*
	* @access	public
	*/    
	function index() 
	{
	
	}

	/**
	* __call
	*
	* @access	public
	*/    
	function __call($function, $args) {
		throw new Exception("There is no method like this '{$function}'");
	}
	
	
		
	
}
?>
