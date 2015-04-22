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

class G
{
	var $firephp=null;
	var $base_url="http://localhost/iSolution/";
	
	/**
	* constructor
	*
	* @access	public
	*/
	function __construct()
	{
		invis::instance($this,'core');
		
		if(DMODE){$this->iFire();}
	
	}

	
	
	/**
	* iFire
	*init firePHP
	* @access	public
	*/    
	function var_table($table_name,$data)
	{
		$table   = array();
		$table[] = array('Parpose','Name','Type','Value');
		foreach($data as  $key=>$values)
		{
			foreach($values as  $name=>$value)
			{
				$table[] = array($key,$name,gettype($value),$value);
			}
		}
		
		$this->firephp->table($table_name, $table);
	}
	
	/**
	* logSGPC
	* log SESSION GET POST COOKIE variables 
	* @access	public
	*/    
	function logSGPC()
	{//echo "SGPC";var_dump($this->firephp);
		$data['session']=$_SESSION;
		$data['get']=$_GET;
		$data['post']=$_POST;
		$data['cookie']=$_COOKIE;
//var_dump($this->firephp);
		$this->var_table('SGPC',$data);
		
		//$this->firephp->log("asd","ASd");
	}
		
	/**
	* log_time
	* log SESSION GET POST COOKIE variables 
	* @access	public
	*/    
	function log_time($id)
	{
		$curr_time = microtime(true);
		$this->firephp->log(($curr_time-$GLOBALS['time_base']),'Execution time for '.$id.' : ');
		$GLOBALS['time_base']=microtime(true);		
	}
	
	function iFire()
	{
		/************************************************************/
		/*********************	FirePHPCore		 ********************/
		/************************************************************/
		if($this->firephp == null)
		{
			require_once('system/extend/firePHPCore/firePHP.class.php');
			ob_start();		
			//var_dump($this->firephp);
			$this->firephp = FirePHP::getInstance(true); 
			//var_dump($this->firephp);
			//$this->firephp->log("asd","ASd");
		}
			
		//$this->firephp->log($value, $name);
		
		/************************************************************/
		/************************************************************/
	}

	/**
	* __call
	*
	* @access	public
	*/    
	function __call($function, $args) {
		throw new Exception("There is no method like this '{$function}'");
	}
	
	/**
	* load
	*
	* @access	public
	*/    
	function load($classname,$directory='system',$params=null) 
	{
		if($directory=='controllers')
		{
			$full_classname=$classname."_Controller";
		}
		else
		{
			$full_classname=$classname;
		}
		
		if($directory!='system')
		{
			$directory = "application/" . $directory;
		}
		
		if(!class_exists($classname))
			require($directory . "/" . mb_strtolower($classname) . ".php");
		if(!isset($this->{$classname}))
		{
			if($params==null)
				$this->{$classname} = new $full_classname;
			else
				$this->{$classname} = new $full_classname($params);
		}	
	}	
		
	
}
?>
