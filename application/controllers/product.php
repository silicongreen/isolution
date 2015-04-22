<?php

/**
 * default.php
 *
 * default application controller
 *
 * @package		InvisMVC
 * @author		iSolution
 */

class Product_Controller extends iController
{	
	function __construct()
	{
		parent::__construct();
	}

	function product_upload_pre()
	{
		$this->load('RainTPL');
		$this->load('Json_helper','libraries');
		$cat=$this->Json_helper->get_cat_list();
		$this->RainTPL->assign('category',$cat);
		var_dump($cat);	
		$this->RainTPL->draw('product_upload');
	}

	function product_upload_post()
	{
		$this->load('RainTPL');
		$this->load("Product","models");
		$this->load('Json_helper','libraries');
		$this->Product->product_input($_POST);
		$cat=$this->Json_helper->get_cat_list();
		$this->RainTPL->assign('category',$cat);		
		$this->RainTPL->draw('product_upload');
	}

}