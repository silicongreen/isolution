<?php

/**
 * default.php
 *
 * default application controller
 *
 * @package		InvisMVC
 * @author		SG
 */

class Json_helper extends iLibrary
{
	
	function Json_helper()
	{
		parent::__construct();
	}	
	
	function json_file_writer($url,$data)
	{	
		$fp = fopen($url, 'w');
		fwrite($fp, json_encode($data));
		fclose($fp);
		chmod($url, 0750);
		//echo filesize($url)."W:".(json_encode($data));	
	}
	
	function json_file_reader($url)
	{		
		//if(filesize($url)==0) return null;
		
		//$fp = fopen($url, 'r');
		$data = file_get_contents($url, true);//fread($fp, 99999999);
		//fclose($fp);
		//echo filesize($url)."R:".$data;
		return json_decode($data);
	}

	function add_new_cat($cat)
	{
		$data = (array)$this->json_file_reader("data/cat.json");
		if(array_search($cat,$data)===false)
		{
		$data[] = $cat;
		$this->json_file_writer("data/cat.json",$data);
		return true;
		}
		else
		return false;
	}	
	
	function get_cat_list()
	{
		return $this->json_file_reader("data/cat.json");
	}
	
	function del_cat_list($val)
	{
		$cat_lst =(array) $this->json_file_reader("data/cat.json");
		$pos = array_search($val,$cat_lst);
		if($pos!==false)
		{
			array_splice($cat_lst, $pos,1);
			$this->json_file_writer("data/cat.json",$cat_lst);
			echo "Succesfully Deleted";
		}
	}
	
	
}

?>
