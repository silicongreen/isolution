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
/** File      :  system/iformvalidator.php         ***/
/*** Version   :  1.0                              ***/
/***                                               ***/
/*****************************************************/
/*****************************************************/




/*****************************************************/
/***             FORM VALIDATOR CLASS              ***/
/*****************************************************/

class iFormValidator
{
	var $errors;
	var $datas;


	/**
	 * Perform data validation against the provided ruleset
	 * 
	 * @static
	 * @access public
	 * @param  mixed $input
	 * @param  array $ruleset
	 * @return mixed
	 */
	public static function validate(&$input, array $ruleset)
	{
		$errors = array();
		
		foreach($ruleset as $field => $rules)
		{
			$rules = explode('|', $rules);

			foreach($rules as $rule)
			{
				$method = NULL;
				$param  = NULL;
				
				// @TODO: Improve the param parser
				
				if(strstr($rule, ',') !== FALSE) // has params
				{
					$rule   = explode(',', $rule);
					$method = $rule[0];
					$param  = $rule[1];
				}
				else
				{
					$method = $rule;
				}

				if(method_exists('iFormValidator', $method))
				{
					if($method == 'captcha')
					{
						$result = iFormValidator::$method();
					}
					else
					{
						$result = iFormValidator::$method($input[$field], $param);
					}
					
					if(!($result === true))
					{
						if(is_array($result))
						{
							$input = $result;
						}
						else
						{											
							$errors[ "'".$field."'" ] = $method;
						}
					}
				}
			}
		}

		return (count($errors) > 0)? $errors : TRUE;
	}
	
	
	///********************************************************************************///
    // ** ------------------------- Validation Helpers ---------------------------- ** //	
	
	/**
	 * Perform XSS clean to prevent cross site scripting
	 * 
	 * @static
	 * @access public
	 * @param  array $data
	 * @return array
	 */
	public static function xss_clean(&$data, $param=null)
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
		return true;
	}
	
	/**
	 * Sanitize the input data
	 * 
	 * @static
	 * @access public
	 * @param  array $data
	 * @return array
	 */
	public static function sanitize(&$input, $fields = NULL)
	{
		$magic_quotes = (bool)get_magic_quotes_gpc();
		
		if(is_null($fields))
		{
			$fields = array_keys($input);
		}

		foreach($fields as $field)
		{
			if(!isset($input[$field]))
			{
				continue;
			}
			else
			{
				$value = $input[$field]; 
				
				if(is_string($value))
				{
					if($magic_quotes === TRUE)
					{
						$value = stripslashes($value);
					}
					
					if(strpos($value, "\r") !== FALSE)
					{
						$value = str_replace(array("\r\n", "\r"), "\n", $value);
					}
					
					/*if(function_exists('iconv'))
					{
						$value = iconv('ISO-8859-1', 'UTF-8', $value);
					}
					*/
					$value = filter_var($value, FILTER_SANITIZE_STRING);		
				}
				
				$input[$field] = $value;
			}
		}
		
		return $input;		
	}
	
	//required 	No 	Returns FALSE if the form element is empty. 
	public static function captcha()
	{
		require_once('system/extend/recaptchalib.php');
		$privatekey = PRIVATEKEY;
		$resp = recaptcha_check_answer ($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);

		
		return $resp->is_valid;
		
	}	
	
	//required 	No 	Returns FALSE if the form element is empty. 
	public static function required($str, $param=null)
	{
		if ( ! is_array($str))
		{
			return (trim($str) == '') ? FALSE : TRUE;
		}
		else
		{
			return ( ! empty($str));
		}
	}
	
	
	
	public static function regex_match($str, $regex)
	{
		if ( ! preg_match($regex, $str))
		{
			return FALSE;
		}

		return  TRUE;
	}
	
	//matches 	Yes 	Returns FALSE if the form element does not match the one in the parameter. 	matches[form_item]
	public static function matches($str, $field)
	{
		if ( ! isset($_POST[$field]))
		{
			return FALSE;
		}

		$field = $_POST[$field];

		return ($str !== $field) ? FALSE : TRUE;
	}
	
	//min_length 	Yes 	Returns FALSE if the form element is shorter then the parameter value. 	min_length[6]
	public static function min_length($str, $val)
	{
		if (preg_match("/[^0-9]/", $val))
		{
			return FALSE;
		}

		if (function_exists('mb_strlen'))
		{
			return (mb_strlen($str) < $val) ? FALSE : TRUE;
		}

		return (strlen($str) < $val) ? FALSE : TRUE;
	}
	
	//max_length 	Yes 	Returns FALSE if the form element is longer then the parameter value. 	max_length[12]
	public static function max_length($str, $val)
	{
		if (preg_match("/[^0-9]/", $val))
		{
			return FALSE;
		}

		if (function_exists('mb_strlen'))
		{
			return (mb_strlen($str) > $val) ? FALSE : TRUE;
		}

		return (strlen($str) > $val) ? FALSE : TRUE;
	}
	
	//exact_length 	Yes 	Returns FALSE if the form element is not exactly the parameter value. 	exact_length[8]
	public static function exact_length($str, $val)
	{
		

		return (strlen($str) != $val) ? FALSE : TRUE;
	}
	
	//greater_than 	Yes 	Returns FALSE if the form element is less than the parameter value or not numeric. 	greater_than[8]
	public static function greater_than($str, $min)
	{
		if ( ! is_numeric($str))
		{
			return FALSE;
		}
		return $str > $min;
	}
	
	//less_than 	Yes 	Returns FALSE if the form element is greater than the parameter value or not numeric. 	less_than[8]
	public static function less_than($str, $max)
	{
		if ( ! is_numeric($str))
		{
			return FALSE;
		}
		return $str < $max;
	}
	
	//alpha 	No 	Returns FALSE if the form element contains anything other than alphabetical characters.	 
	public static function alpha($str, $param=null)
	{
		return ( ! preg_match("/^([a-z])+$/i", $str)) ? FALSE : TRUE;
	}
	
	//alpha_numeric 	No 	Returns FALSE if the form element contains anything other than alpha-numeric. 	 
	public static function alpha_numeric($str, $param=null)
	{
		return ( ! preg_match("/^([a-z0-9])+$/i", $str)) ? FALSE : TRUE;
	}
	
	//alpha_dash 	No 	Returns FALSE if the form element contains anything other than alpha-numeric characters, 
	public static function alpha_dash($str, $param=null)
	{
		return ( ! preg_match("/^([-a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;
	}
	
	//numeric 	No 	Returns FALSE if the form element contains anything other than numeric characters. 	 
	public static function numeric($str, $param=null)
	{
		return (bool)preg_match( '/^[\-+]?[0-9]*\.?[0-9]+$/', $str);

	}

	//integer 	No 	Returns FALSE if the form element contains anything other than an integer. 	 ************
	public static function valid_integer($value, $param=null)
	{
		return (bool) filter_var($value, FILTER_VALIDATE_INT);
	} 
	
	//decimal 	Yes 	Returns FALSE if the form element is not exactly the parameter value.**********
	public static function valid_decimal($value, $param=null)
	{
		return (bool) filter_var($value, FILTER_VALIDATE_FLOAT);
	} 
	
	//is_natural 	No 	Returns FALSE if the form element contains anything other than a natural number: 0, 1, 2, 3, etc. 
	public static function is_natural($value, $param=null)
	{
		return (bool) preg_match( '/^[0-9]+$/', $str);
	} 	
	
	//is_natural_no_zero 	No 	Returns FALSE if the form element contains anything other than a natural number, but not zero: 1, 2, 3, etc.
	public static function is_natural_no_zero($value, $param=null)
	{
		if ( ! preg_match( '/^[0-9]+$/', $str))
		{
			return FALSE;
		}

		if ($str == 0)
		{
			return FALSE;
		}

		return TRUE;
	} 

	//valid_email 	No 	Returns FALSE if the form element does not contain a valid email address. 	************* 	
	public static function valid_email($email, $param=null)
	{
		//return true;
		return (bool)filter_var($email, FILTER_VALIDATE_EMAIL)?true:false;
	}
	
	//valid_emails 	No 	Returns FALSE if any value provided in a comma separated list is not a valid email. 
	public static function valid_emails($str, $param=null)
	{
		if (strpos($str, ',') === FALSE)
		{
			return $this->valid_email(trim($str));
		}

		foreach (explode(',', $str) as $email)
		{
			if (trim($email) != '' && $this->valid_email(trim($email)) === FALSE)
			{
				return FALSE;
			}
		}

		return TRUE;
	}
	
	//valid_ip 	No 	Returns FALSE if the supplied IP is not valid.************
	public static function valid_ip($ip, $param=null)
	{
		return (bool) filter_var($ip, FILTER_VALIDATE_IP);
	}
	
	//valid_base64 	No 	Returns FALSE if the supplied string contains anything other than valid Base64 characters.
	public static function valid_base64($str, $param=null)
	{
		return (bool) preg_match('/[^a-zA-Z0-9\/\+=]/', $str);
	}

	
//*************************************************************************//

	
}