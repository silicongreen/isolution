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
/*** File      :  system/invis.php                 ***/
/*** Version   :  1.0                              ***/
/***                                               ***/
/*****************************************************/
/*****************************************************/


/*****************************************************/
/***                  MAIN CLASS                   ***/
/*****************************************************/

class invis
{
	var $controller = null;
	var $action = null;
	var $path_info = null;
	var $url_segments = null;
	var $config = null;

	/**
	* class __construct
	*
	* @access	public
	*/    
	public function __construct($id='default')
	{
	/* set instance */
	self::instance($this,$id);

	}

	/**
	* instance
	*
	* get/set the invis object instance(s)
	*
	* @access	public
	* @param   object $new_instance 
	* @param   string $id
	* @return  object $instance
	*/    
	public static function &instance($new_instance=null,$id='default')
	{
		static $instance = array();
		if(isset($new_instance) && is_object($new_instance))
			$instance[$id] = $new_instance;
			return $instance[$id];
	}
	
	
	function load($classname,$directory='system',$params=null) 
	{
		if($directory!='system')
		{
			$directory = "application/" . $directory;
		}
		
		if(!class_exists($classname))
			require($directory . "/" . strtolower($classname) . ".php");
		if(!isset($this->{$classname}))
		{
			if($params==null)
				$this->{$classname} = new $classname;
			else
				$this->{$classname} = new $classname($params);
		}	
	}	
	/**
	* main
	*
	* @access	public
	*/

	public function main()
	{
		///for query url
		if($GLOBALS[ 'config' ]['url_query'])
		{
			$this->set_url_query();
			//var_dump($this );
		}
		//for segment url
		else
		{
			$this->path_info = !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';			
			$this->set_routes();
			$this->set_segments();
			$this->set_controller();
			$this->set_action();
			
		}
	//	echo $GLOBALS['config']['mt_permission']['admin']['admin'];
	//	echo $GLOBALS['config']['mt_permission'];
	//	echo $GLOBALS['config']['enable_query_strings'];
		
		$this->controller->{$this->action}();

	}


	/**
	* set_routes
	*
	* @access	public
	*/    
	public function set_url_query()
	{
		if(!empty($_GET['c']))
		{
			$controller_name = $_GET['c'];
			//echo $controller_name;
			$controller_file = INVIS_MYAPPDIR . DS . 'controllers' . DS . "{$controller_name}.php";
			
			if(!file_exists($controller_file))
			{
				$controller_name = $GLOBALS[ 'config' ]['default_controller'];
				$controller_file = INVIS_MYAPPDIR . DS . 'controllers' . DS . "{$controller_name}.php";
			}
			
			include($controller_file);
			$controller_class = $controller_name.'_Controller';
			$this->controller = new $controller_class(true);
		}
		else
		{
			$this->path_info = !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
			$this->set_routes();
			$this->set_segments();
			$this->set_controller();
		}
		
		
		
		if(!empty($_GET['a']))
		{
			if(!empty($GLOBALS[ 'config' ]['root_action'])) 
			{  
				$this->action = $GLOBALS[ 'config' ]['root_action'];
			} 
			else 
			{
				$this->action = !empty($_GET['a']) ? $_GET['a'] :
				(!empty($GLOBALS[ 'config' ]['default_action']) ? $GLOBALS[ 'config' ]['default_action'] : 'index');
				if(substr($this->action,0,1)=='_')
					throw new Exception("Action name not allowed '{$this->action}'");    
			}			
		}
		else
		{
			if(!empty($GLOBALS[ 'config' ]['root_action'])) {  
				$this->action = $GLOBALS[ 'config' ]['root_action'];
			} else {
				$this->action = !empty($GLOBALS[ 'config' ]['default_action']) ? $GLOBALS[ 'config' ]['default_action'] : 'index';
				if(substr($this->action,0,1)=='_')
					throw new Exception("Action name not allowed '{$this->action}'");    
			}
		}
		
		
	}
/**
	* set_routes
	*
	* @access	public
	*/    
	public function set_routes()
	{
		if(!empty($GLOBALS[ 'config' ]['routing']['search'])&&!empty($GLOBALS[ 'config' ]['routing']['replace']))
		$this->path_info = preg_replace(
		$GLOBALS[ 'config' ]['routing']['search'],
		$GLOBALS[ 'config' ]['routing']['replace'],
		$this->path_info);
	}

	/**
	* set_segments
	*
	* @access	public
	*/    
	public function set_segments()
	{
		$this->url_segments = !empty($this->path_info) ? (explode('/',$this->path_info)) : null;/////array_filter
		$GLOBALS[ 'url_segments' ] = $this->url_segments;
	}

	/**
	* set_controller
	*
	* @access	public
	*/    
	public function set_controller()
	{
		if(!empty($GLOBALS[ 'config' ]['root_controller'])) {
			$controller_name = $GLOBALS[ 'config' ]['root_controller'];
			$controller_file = INVIS_MYAPPDIR . DS . 'controllers' . DS . "{$controller_name}.php";}
		else {
			$controller_name = !empty($this->url_segments[1]) ? preg_replace('!\W!','',$this->url_segments[1]) : $GLOBALS[ 'config' ]['default_controller'];
			$controller_file = INVIS_MYAPPDIR . DS . 'controllers' . DS . "{$controller_name}.php";
			
			if(!file_exists($controller_file))
			{
				$controller_name = $GLOBALS[ 'config' ]['default_controller'];
				$controller_file = INVIS_MYAPPDIR . DS . 'controllers' . DS . "{$controller_name}.php";
			}
		}
		
		include($controller_file);
		$controller_class = $controller_name.'_Controller';
		$this->controller = new $controller_class(true);
	}  

	/**
	* set_action
	*
	* @access	public
	*/    
	public function set_action()
	{
		if(!empty($GLOBALS[ 'config' ]['root_action'])) {  
			$this->action = $GLOBALS[ 'config' ]['root_action'];
		} else {
			$this->action = !empty($this->url_segments[2]) ? $this->url_segments[2] :
			(!empty($GLOBALS[ 'config' ]['default_action']) ? $GLOBALS[ 'config' ]['default_action'] : 'index');
			if(substr($this->action,0,1)=='_')
				throw new Exception("Action name not allowed '{$this->action}'");    
		}
	}  


}

?>