<?php if (!defined('INVIS_BASEDIR')) exit('No direct script access allowed');
/**********************************************************************************
* This file is part of MT BACKEND                                                 *
* =============================================================================== *
* Copyright 2010 by:           Metehan Arslan (http://www.metehanarslan.com)      *
* Contact:                     hello@metehanarslan.com                            *
* Support, News, Updates at:   http://www.mtbackend.com                           *
***********************************************************************************
* This program is free software; you may redistribute it and/or modify it under   *
* the terms of the provided license as published by Metehan Arslan.               *
*                                                                                 *
* This program is distributed in the hope that it is and will be useful, but      *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY    *
* or FITNESS FOR A PARTICULAR PURPOSE.                                            *
*                                                                                 *
* See the "mt-backend-license.txt" file for details of the lincense               * 
* The latest version can always be found at http://www.mtbackend.com.             *
**********************************************************************************/

class iAuth{

   
    var $permission;
    var $option;
	var $db;
	
    function iAuth()//
    {
		$I =& invis::instance();		
		
		$I->load('iConfig');
		$I->iConfig->load('auth');
		$this->permission = $I->iConfig->item('mt_permission'); //makes configuration array local array
        $this->option = $I->iConfig->item('mt_option'); // makes configuration local array
        
		$I->load("iModel");
		$this->db = $I->iModel;
		$this->db->set_opt($this->option['table'],'username');			
    }

    function control($areas)
    {
        $area_arr = explode('|', $areas);
        $auth=FALSE;
        
        foreach($area_arr as $value){
            if(isset($this->permission[$value][$_SESSION['usertype']]) && $auth==FALSE)
            {
				$auth = $this->permission[$value][$_SESSION['usertype']];
			}
            
        }
        
        return $auth;
    }

    function register($user = '', $email = '', $pass = '',$user_data = NULL)
    {
        /*Control datas*/
        if($email == '' OR $pass == '' OR $user== '') {return FALSE;}
        
        
        /*Control if the user exits*/
        if(!$this->db->check_unique('username',$user)) {return FALSE;}
        if(!$this->db->check_unique('email',$email)) {return FALSE;}
        
        /*Everything is ok.*/
            $data = array(
                'username' => $user,
                'email' => $email,
                'password' => md5($pass.$this->option['unique_key']),
                'chat_password' => $pass,/////for chat system's password
				'created' => date('Y-m-d H:i:s', (time()))
				);
				
            if(isset($user_data)){
                $data = array_merge($data, $user_data);
            }
            
        $this->db->add_row($data);
         
        if($this->option['auto_login_after_register'])$this->login($user, $pass);
        return TRUE;
    }

    function login($user = '', $pass = '',$parent=null) {
        
        /*Control datas*/
        if($user == '' OR $pass == '') return FALSE;
        
        /*Control if userdata true*/
		$filters[] = array('where','username','=',$user);
		$filters[] = array('where','password','=',md5($pass.$this->option['unique_key']));
		$filters[] = array('limit',1);
        $user_data = $this->db->list_rows($filters);

		if (isset($user_data[0]['username'])){
			/*Everything is ok.*/

			$_SESSION['userid'] = $user_data[0]['id'];
			$_SESSION['username'] = $user_data[0]['username'];
			$_SESSION['usertype']  = $user_data[0]['usertype'];
			$_SESSION['logged_in']  = TRUE;
			
			
			//////////////////////////////////////////////////////////////////////
			if($parent!=null)
			{
				$parent->_login_jobs();
			}
			//Set last login
			$lastlogin = array(
				'lastlogin' => date('c')
			);
			//$this->CI->mt_auth_model->update_user($user, $lastlogin);
			$this->db->update_row($user,$lastlogin);
			
			return TRUE;
		}
        return FALSE;
        
	}	
	
		

	
	
	function change_password($username, $new_password, $passhash){

		$filters[] = array('where','username','=',$username);		
		$filters[] = array('limit',1);
        $user_data = $this->db->list_rows($filters);
		//var_dump($user_data);
		//echo $passhash."!!!!------";
		//echo  md5($user_data[0]['password'] . $user_data[0]['id'] . $user_data[0]['lastlogin'] . $this->option['unique_key']);
		//echo "=====".$passhash;
		if (isset($user_data[0]['username']) && ($passhash == md5($user_data[0]['password'] . $user_data[0]['id'] . $user_data[0]['lastlogin'] . $this->option['unique_key']))){
            /*Everything is ok.*/
			$this->db->update_row($username,array('password'=>md5($new_password.$this->option['unique_key'])));
			return true;
	
        }
		return false;
			//save new password to db md5($pass.$this->option['unique_key'])
	}
	
	function passhash($username){
		$filters[] = array('where','username','=',$username);		
		$filters[] = array('limit',1);
		//echo "--------------------------------------------------";
        $user_data = $this->db->list_rows($filters);
		//var_dump($user_data);
		if (isset($user_data[0]['username'])){
            /*Everything is ok.*/
			$data['email'] = $user_data[0]['email'];
			$data['hash'] = md5($user_data[0]['password'] . $user_data[0]['id'] . $user_data[0]['lastlogin'] . $this->option['unique_key']);
            return $data;
	
        }
		return false;
	}

    function logout()
    {    
        //$this->CI->session->sess_destroy();
        session_destroy();
    }

    function delete($username)
    {
        $this->db->delete_row($username);
    }
	
	function folderaccess($folderslug)
    {
        if(isset($_SESSION['username']))
		{		
			$this->db->set_opt('board_accesslist');
			$filters[] = array("where","folderslug","=",$folderslug);
			$filters[] = array("where","username","=",$_SESSION['username']);
			//echo $this->db->count_rows($filters);
			if($this->db->count_rows($filters)>0)
			{
				return true;
			}
			return false;
		}
		else
		{
			return false;
		}
    }
}
?>