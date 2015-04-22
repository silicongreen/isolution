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
/*** File      :  system/imodel.php                ***/
/*** Version   :  1.0                              ***/
/***                                               ***/
/*****************************************************/
/*****************************************************/




/*****************************************************/
/***                  MODEL CLASS                  ***/
/*****************************************************/

class iModel extends G
{
var $table,$unique,$column_selections;

/**
 * class constructor
 *
 * @access	public
 */

function iModel($database=null){
	parent::__construct();
	//print_r($GLOBALS[ 'config' ]);
	if($database==null)
	{
		$database = $GLOBALS[ 'config' ]['default']['name'];
	}
	$link = mysql_connect($GLOBALS[ 'config' ]['default']['host'], $GLOBALS[ 'config' ]['default']['user'], $GLOBALS[ 'config' ]['default']['pass']);
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_set_charset('utf8');
	
	mysql_select_db($database);
	
}

function sql($sql){
	$all_data = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_array($all_data))
	{
		 $results[] = $row;
	}
	if(isset($results))
	{
		return $results;
	}
	else
	{
		return "no row selected";
	}
	
}

function set_opt($table, $unique='id'){
	$this->table = $table;
	$this->unique = $unique;
	
}
/**
 * Description of get_column_list
 *
 * use to calculate the part(column list) of the sql
 *
 * @param   $userdata   array	[The keys of array must be column names in database]
 * @return  string
 */
function get_column_list($userdata)	{
	$return=" ";
	$strt_flag=true;
	
	foreach($userdata as $key => $title)
	{
		if($strt_flag==true)
		{
			$strt_flag=false;
			$return=$return.$key." ";
		}
		else
		{
			$return=$return.",".$key." ";
		}			
	}
	return $return;
}

 /**
 * Description of get_value_list
 *
 * use to calculate the part(value list) of the sql
 * 
 * @param   $userdata   array	[The keys of array must be column names in database]
 * @return  string
 */
 
function get_value_list($userdata)	{
	$return="";
	$strt_flag=true;
	
	foreach($userdata as $key => $value)
	{
		if($strt_flag==true)
		{
			$strt_flag=false;
			$return=$return."'".$value."'";
		}
		else
		{
			$return=$return.",'".$value."'";
		}
		
	}
	return $return;
}

 /**
 * Description of get_update_string
 *
 * use to calculate the part(update list) of the sql
 *
 * @param   $userdata   array	[The keys of array must be column names in database]
 * @return  string
 */
 
function get_update_string($userdata)	{
	//title = '{$title}', name = '{$name}', date = '{$date}'
	$return="";
	$strt_flag=true;
	
	foreach($userdata as $key => $value)
	{//$val == "NULL" ? $quefields .= "`$key` = $val" : $quefields .= "`$key` = '$val'"; 
		if($strt_flag==true)
		{
			$strt_flag=false;
			if($value!=null)
				$return=$return.$key." = '".$value."'";
			else
				$return=$return.$key." = NULL";
		}
		else
		{
			if($value!=null)
				$return=$return.",".$key." = '".$value."'";
			else
				$return=$return.",".$key." = NULL";
		}
		
	}
	return $return;
}


 /**
 * Description of get_filters_sql
 *
 * return sql query of defind filters
 * 
 *
 * @param   $filters   array	[its a 2D array]
 * @return  string
 */
function get_filters_sql($filters)	{
	 $Wv="";$Gv="";$Ov="";$Hv="";$Lv="";$Jv="";
	 $Wf=true;$Gf=true;$Of=true;$Hf=true;$Lf=true;$Jf=true;
	 $this->column_selections = "*";
	
	foreach($filters as $filter)
	{
		switch($filter[0])
		{
			case 'group':
			if($Wf)
			{
				$Wf=false;
				
				$Wv=" WHERE ".$filter[1]." ";
			}
			else
			{
				$Wv=$Wv." AND ".$filter[1]." ";
			}
			break;
			
			case 'or_group':
			if($Wf)
			{
				$Wf=false;
				$Wv=" WHERE ".$filter[1]." ";
			}
			else
			{
				$Wv=$Wv." OR ".$filter[1]." ";
			}
			break;
			
			case 'where':
			if($Wf)
			{
				$Wf=false;
				
				$Wv=" WHERE ".$filter[1]." ".$filter[2]." '".$filter[3]."' ";
			}
			else
			{
				$Wv=$Wv." AND ".$filter[1]." ".$filter[2]." '".$filter[3]."' ";
			}
			break;
			
			case 'or_where':
			if($Wf)
			{
				$Wf=false;
				$Wv=" WHERE ".$filter[1]." ".$filter[2]." '".$filter[3]."' ";
			}
			else
			{
				$Wv=$Wv." OR ".$filter[1]." ".$filter[2]."'".$filter[3]."' ";
			}
			break;
			
			case 'like':
			if($Wf)
			{
				$Wf=false;
				$Wv=" WHERE ".$filter[1]." LIKE '".$filter[2]."' ";
			}
			else
			{
				$Wv=$Wv." AND ".$filter[1]." LIKE '".$filter[2]."' ";
			}
			break;
			
			case 'or_like':
			if($Wf)
			{
				$Wf=false;
				$Wv=" WHERE ".$filter[1]." LIKE '".$filter[2]."' ";
			}
			else
			{
				$Wv=$Wv." OR ".$filter[1]." LIKE '".$filter[2]."' ";
			}
			break;
			
			case 'not_like':
			if($Wf)
			{
				$Wf=false;
				$Wv=" WHERE ".$filter[1]." NOT LIKE '".$filter[2]."' ";
			}
			else
			{
				$Wv=$Wv." AND ".$filter[1]." NOT LIKE '".$filter[2]."' ";
			}
			break;
			
			case 'group_by':
			if($Gf)
			{
				$Gf=false;
				$Gv=" GROUP BY ".$filter[1]." ";
			}
			else
			{
				$Gv=$Gv." ,".$filter[1]." ";
			}
			break;
			
			case 'order_by':
			if($Of)
			{
				$Of=false;
				$Ov=" ORDER BY ".$filter[1]." ";
			}
			else
			{
				$Ov=$Ov." ,".$filter[1]." ";
			}
			break;
			
			case 'having':
			if($Hf)
			{
				$Hf=false;
				$Hv=" HAVING ".$filter[1]." = ".$filter[2]." ";
			}
			else
			{
				
			}
			break;
			
			case 'limit':
			if($Lf)
			{
				$Lf=false;
				if(isset($filter[2]))
				{
					$Lv=" LIMIT ".$filter[1]." , ".$filter[2] ." ";
				}
				else
				{
					$Lv=" LIMIT ".$filter[1]." ";
				}
			}
			else
			{
				
			}
			break;
			
			case 'join':
			if($Jf)
			{
				$Jf=false;
				if(isset($filter[3]))
				{				
					$Jv=" ".$filter[3]." JOIN ".$filter[1]." ON ".$filter[2]." ";					
				}
				else
				{
				
					$Jv=" JOIN ".$filter[1]." ON ".$filter[2]." ";
				}
			}
			else
			{
				
			}
			break;
			
			case 'select':
			
				if($this->column_selections == "*")
				{
					$this->column_selections = $filter[1];
				}
				else
				{
					$this->column_selections = $this->column_selections.",".$filter[1];
				}
				
			break;
			
			case 'distinct':
			
				if($this->column_selections == "*")
				{
					$this->column_selections = " DISTINCT ".$filter[1];
				}
				else
				{
					$this->column_selections = " DISTINCT ".$filter[1].",".$this->column_selections;
				}
				
			break;
			
		}				
	}
	
	$return=$Jv.$Wv.$Gv.$Ov.$Hv.$Lv;
	return $return;
}
/**
 * Description of add_row
 *
 * add a new row to the table
 *
 *
 * @param   $userdata   array	[The keys of array must be column names in database]
 * @return  array
 */
function add_row($userdata){

	$sql = "INSERT INTO ".$this->table." (".$this->get_column_list($userdata).") VALUES (".$this->get_value_list($userdata).")";
	 if(DMODE)$this->firephp->log( $sql , 'sql:');
	$return['sql'] = $sql;
	$return['success'] = mysql_query($sql) or die(mysql_error());
	$return['insert_id'] = mysql_insert_id() or die(mysql_error());
	return $return;
}

function add_row_static($userdata){

	$sql = "INSERT INTO ".$this->table." (".$this->get_column_list($userdata).") VALUES (".$this->get_value_list($userdata).")";
	 if(DMODE)$this->firephp->log( $sql , 'sql:');
	$return['sql'] = $sql;
	$return['success'] = mysql_query($sql) or die(mysql_error());	
	return $return;
}

 /**
 * Description of update_row
 *
 * Update a row of the table based on $unique key
 *
 * @param   $unique string,value
 * @param   $userdata   array	[The keys of array must be column names in database]
 * @return  array
 */
function update_row($unique, $userdata){
	$sql = "UPDATE ".$this->table." SET ".$this->get_update_string($userdata)." WHERE ".$this->unique." = '".$unique."'";
    if(DMODE)$this->firephp->log( $sql , 'sql:');
    $return['sql'] = $sql;
	$return['success'] = mysql_query($sql) or die(mysql_error());
	return $return;
}
 
 /**
 * Description of mass_update
 *
 * Update multiple rows of the table based on $filters
 * 
 * @param   $userdata   array	[The keys of array must be column names in database]
 * @param   $filters    array	[its a 2D array]
 * @return  array
 */
function mass_update($userdata,$filters)	{
	$sql = "UPDATE ".$this->table." SET ".$this->get_update_string($userdata).$this->get_filters_sql($filters);
	if(DMODE)$this->firephp->log( $sql , 'sql:');
	$return['sql'] = $sql;
	$return['success'] = mysql_query($sql) or die(mysql_error());
	$return['msg'] = "mass update complete\n\n";
	return $return;
}

 /**
 * Description of count_rows
 *
 * returns the number of result based on $filters
 * 
 * @param   $filters    array	[its a 2D array]
 * @return  int
 */
function count_rows($filters = NULL){
	if (isset($filters)){
		$sql = "SELECT COUNT(*) FROM ".$this->table.$this->get_filters_sql($filters);
	}
	else
	{
		$sql = "SELECT COUNT(*) FROM ".$this->table;
	}
	 if(DMODE)$this->firephp->log( $sql , 'sql:');
	$total = mysql_query($sql) or die(mysql_error());
	if($row = mysql_fetch_array($total) or die(mysql_error()))
	{
		
		return $row[0];
		//return $this->db->count_all_results($this->table);
	}
}

/**
 * Description of list_rows
 *
 * returns the result as array based on $filters
 *
 * @param   $filters    array	[its a 2D array]
 * @return  array
 */
function list_rows($filters=NULL)    {
	if (isset($filters))
	{
		$filters_query = $this->get_filters_sql($filters);
		
		$sql = "SELECT ".$this->column_selections." FROM ".$this->table.$filters_query;
	}
	else
	{
			$sql = "SELECT * FROM ".$this->table;
	}
	//echo $sql."--------";
	 if(DMODE)$this->firephp->log( $sql , 'sql:');
	$total = mysql_query($sql)or die(mysql_error());
	
	
	while($row = mysql_fetch_array($total))
	{
		 $results[] = $row;
	}
	if(isset($results))
	{
		return $results;
	}
	else
	{
		return "no row selected";
	}
}

/**
 * Description of get_row
 *
 * returns a single row as array based on $unique value
 *
 * @param   $unique    string/value
 * @return  array
 */
function get_row($unique){
	
	$sql = "SELECT * FROM ".$this->table." WHERE ".$this->unique." = '".$unique."'";
	 if(DMODE)$this->firephp->log( $sql , 'sql:');
	$total = mysql_query($sql)or die(mysql_error());

	return mysql_fetch_array($total);
}
 

/**
 * Description of list_rows
 *
 * delete a single row based on $unique value
 *
 * @param   $unique    string/value
 * @return  bool
 */
function delete_row($unique){
	$sql = "DELETE FROM ".$this->table." WHERE ".$this->unique." = '".$unique."'";
	 if(DMODE)$this->firephp->log( $sql , 'sql:');
	$total = mysql_query($sql)or die(mysql_error());
	
	return $total;
}


/**
 * Description of delete_multi
 *
 * delete multiple rows based on $filters
 *
 * @param   $filters    array	[its a 2D array]
 * @return  bool
 */
function delete_multi($filters)    {
	$sql = "DELETE FROM ".$this->table.$this->get_filters_sql($filters);
	 if(DMODE)$this->firephp->log( $sql , 'sql:');
	$total = mysql_query($sql)or die(mysql_error());
	return $total;
}

/**
 * Description of check_unique
 *
 * check is the $value is already exist in $column
 *
 * @param   $column    string
 * @param $value  string
 * @return  bool
 */
function check_unique($column, $value){
	$sql = "SELECT ".$column." FROM ".$this->table." WHERE ".$column." = '".$value."' ";
	 if(DMODE)$this->firephp->log( $sql , 'sql:');
	$total = mysql_query($sql)or die(mysql_error());
	if(mysql_num_rows($total)>0)
	{
		return false;
	}
	else
	{
		return  true;
	}
   
}

}

?>