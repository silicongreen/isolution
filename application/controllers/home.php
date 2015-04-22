<?php

/**
 * default.php
 *
 * default application controller
 *
 * @package		InvisMVC
 * @author		iSolution
 */

class Home_Controller extends iController
{	
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load('RainTPL');		
		$this->RainTPL->assign('urls_base',$this->base_url);
		$this->RainTPL->assign('port','Portfolio');
		$this->RainTPL->draw('index');
	}
	
}