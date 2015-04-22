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
/*** File      :  system/controller.php            ***/
/*** Version   :  1.0                              ***/
/***                                               ***/
/*****************************************************/
/*****************************************************/




/*****************************************************/
/***              Configuration CLASS              ***/
/*****************************************************/

class iConfig
{
	var $configs=array();
	/**
	* constructor
	*
	* @access	public
	*/
	function __construct()
	{
		invis::instance($this,'configs');
		$this->configs = $GLOBALS['config'];
		
	}

	/**
	* load
	*
	* @access	public
	*/    
	function load($filepath,$params=false) 
	{
		include "application/configs/".$filepath.".php";
		$filename = basename($filepath);
		if($params==true)
		{
			if(!isset($this->configs[$filename]))
			{
				$this->configs[$filename] = array();
			}
			
			$this->configs[$filename] = array_merge( $this->configs[$filename] , $config );
		}
		else
		{
			$this->configs = array_merge( $this->configs , $config);
		}		
	}
		
	function item($indexname,$filename=null) 
	{		
		if($filename!=null)
		{
			return $this->configs[$filename][$indexname];
		}
		else
		{
			return $this->configs[$indexname];
		}
		
		
	}
	
}
?>
