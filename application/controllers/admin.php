<?php

/**
 * default.php
 *
 * default application controller
 *
 * @package		InvisMVC
 * @author		iSolution
 */

class Admin_Controller extends iController
{	
	function __construct()
	{
		parent::__construct();
	}

	function pre_insert_cat()
	{
		$this->load("RainTPL");
		$this->load('Json_helper','libraries');
		$cat=$this->Json_helper->get_cat_list();
		$this->RainTPL->assign('cat',$cat);
		$this->RainTPL->draw("add_new_cat");	
	}

	function insert_new_cat()
	{
		$this->load('Json_helper','libraries');
		$rt=$this->Json_helper->add_new_cat($_POST['ncategory']);
		if($rt)
		echo 'Entry Succesful';
		else
		echo 'Already exist';
		$this->pre_insert_cat();
	}
	
	function get_cat()
	{
		$this->load('Json_helper','libraries');
		$cat=$this->Json_helper->get_cat_list();
		$this->load("RainTPL");
		$this->RainTPL->assign('cat',$cat);
		$this->RainTPL->draw("get_cat");
	}
	
	function del_cat()
	{
		$this->load('Json_helper','libraries');
		$this->Json_helper->del_cat_list($_POST['ncategory']);
		$this->pre_insert_cat();
	}

	
}
