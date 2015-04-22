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
/*** File      :  system/model.php                 ***/
/*** Version   :  1.0                              ***/
/***                                               ***/
/*****************************************************/
/*****************************************************/




/*****************************************************/
/***                  INPUT CLASS                  ***/
/*****************************************************/

class iInput
{
	public static function xss_clean($data)
	{
		if(is_array($data))
		{
			foreach($data as $k => $v)
			{
				$data[$k] = filter_var($v, FILTER_SANITIZE_STRING);		
			} 
		}
		else
		{
			$data = filter_var($data, FILTER_SANITIZE_STRING);
		}
		return $data;
	}
	
	function _search_in_input_pool(&$array, $index = '', $xss_clean = FALSE)
	{
		if ( ! isset($array[$index]))
		{
			return FALSE;
		}

		if ($xss_clean === TRUE)
		{
			return $this->xss_clean($array[$index]);
		}

		return $array[$index];
	}

	// --------------------------------------------------------------------

	function get($index = '', $xss_clean = FALSE)
	{
		return $this->_search_in_input_pool($_GET, $index, $xss_clean);
	}

	// --------------------------------------------------------------------


	function post($index = '', $xss_clean = FALSE)
	{
		return $this->_search_in_input_pool($_POST, $index, $xss_clean);
	}

	// --------------------------------------------------------------------

	function cookie($index = '', $xss_clean = FALSE)
	{
		return $this->_search_in_input_pool($_COOKIE, $index, $xss_clean);
	}

	// --------------------------------------------------------------------
}

?>