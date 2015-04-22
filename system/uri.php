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
/*** File      :  system/uri.php                   ***/
/*** Version   :  1.0                              ***/
/***                                               ***/
/*****************************************************/
/*****************************************************/




/*****************************************************/
/***                   URI CLASS                   ***/
/*****************************************************/

class uri {

	var $path = null;

	/**
	* Description of __construct
	*/
	function __construct()
	{
		if(!empty($_SERVER['PATH_INFO']))
		{
			$this->path = explode('/',$_SERVER['PATH_INFO']);
			$this->path = array_slice($this->path,2);
		}
	}

	/**
	* Description of segment
	*
	*
	* @param   $index array
	*/
	function segment($index)
	{
		if(!empty($this->path[$index-1]))
			return $this->path[$index-1];
		else 
			return false;
	}
	
	/**
	* Description of segment
	*
	*
	* @param $index array
	*/
	function uri_to_assoc($index)
	{
		$assoc = array();
		for($x = count($this->path), $y=$index-1; $y<$x; $y+=2)
		{
			$assoc_idx = $this->path[$y];
			$assoc[$assoc_idx] = isset($this->path[$y+1]) ? $this->path[$y+1] : null;
		}
		return $assoc;
	}
	
	/**
	* Description of uri_to_array
	*
	*
	* @param $index array
	*/
	function uri_to_array($index=0)
	{
		if(is_array($this->path))
			return array_slice($this->path,$index);
		else
			return false;
	}


}

?>
