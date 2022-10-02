<?php
class DB {
	var $hostname 	= '127.0.0.1';
	var $username 	= 'root';
	var $password 	= '';
	var $db_name	= '';
	var $connection;
	var $errors		= array();
	var $queries	= array();
	var $query		= '';
	var $insert_id	= 0;
	var $debug		= 1;
	
	
	function __construct($params=array()) {
		if(!empty($params)) {
			foreach($params as $k=>$v) {
				if(isset($this->{$k})) {
					$this->{$k} = $v;
				}
			}
		}
		
		if($this->hostname != '' && $this->username != ''  && $this->db_name != '') {
			//$this->connection = mysqli_connect($this->hostname,$this->username,$this->password);
			
			$this->connection = new mysqli($this->hostname , $this->username, $this->password, $this->db_name);
			
			// Internal UTF-8
			mysqli_query($this->connection, "SET NAMES 'utf8'");
			mysqli_query($this->connection, 'SET character_set_connection=utf8');
			mysqli_query($this->connection, 'SET character_set_client=utf8');
			mysqli_query($this->connection, 'SET character_set_results=utf8');
			
			if(!$this->connection) {
				$this->errors[] = 'Could not connect: '.mysqli_error($this->connection);
				return FALSE;
			}
			/*if(!mysql_select_db($this->db_name,$this->connection)) {
				$this->errors[] = 'Database error: '.mysql_error();
				return FALSE;
			}*/
		} else {
			$this->errors[] = 'Wrong database information';
			return FALSE;
		}
		
		if($this->debug && !empty($this->errors)) {
			$this->print_debug($this->errors);
		}
		
	return TRUE;
	}
	
	
	function query($sql) {
		$this->queries[] = $sql;
		$result = mysqli_query($this->connection,$sql);
		if(!$result) {
			$this->errors[] = 'Invalid query: '.mysqli_error($this->connection);
		}
		if($result===TRUE) {
			$this->insert_id = mysqli_insert_id($this->connection);
		}
		
		if($this->debug && !empty($this->errors)) {
			$this->print_debug($this->errors);
			$this->print_debug($sql);
		}
		
	return $result;
	}
	
	
	function get_rows($sql) {
		$result = $this->query($sql);
		$rows = array();
		if($result !== FALSE) {
			while($row = mysqli_fetch_array($result)) {
				$rows[] = $row;
			}
		}
	return $rows;
	}
	
	
	function get_row($sql) {
		$result = $this->query($sql);
		$row = array();
		if($result !== FALSE) {
			$row = mysqli_fetch_array($result);
		}
	return $row;
	}


	function escape($str) {
		return ($str);
		//return $this->connection->escape_string($str);
	}
	
	
	function insert($table, $data,$tracing=FALSE) {

		foreach($data as $k=>$v) {
			$data[$k] = $this->escape($v);
		}

		if(!isset($data['created'])) {
			$data['created'] = date("Y-m-d H:i:s");
		}
		

		$fields = $this->get_sql_field_names($table);
		foreach($data as $k=>$v) {
			if(!in_array($k,$fields)) {
				unset($data[$k]);
			}
		}

		$keys 	= array_keys($data);
		$values = array_values($data);

		$sql = "INSERT INTO ".$this->escape($table)." (".implode(',',$keys).") VALUES('".implode("','",$values)."')";
		$return=$this->query($sql);
		/**
		*tracing
		*/
		if($tracing)$this->query("INSERT INTO tracing (`id_tracing` ,`id_user` ,`id_object` ,`type` ,`object` ,`sql_execute` ,`created`) VALUES(DEFAULT,".$_SESSION['User']['id'].",".$this->get_insert_id().",'INSERT','".$this->escape($table)."','".$this->escape($sql)."','".date("Y-m-d H:i:s")."')");
		/**/
	return $return;
	}
	
	
	function update($table, $data, $id,$tracing=FALSE) {

		if(!isset($data['modified'])) {
			$data['modified'] = date("Y-m-d H:i:s");
		}

		$fields = $this->get_sql_field_names($table);
		$update = '';
		foreach($data as $k=>$v) {
			if(in_array($k,$fields)) {
				$update .= "`$k`='".$this->escape($v)."', ";
			}
		}

		$update = substr($update, 0, strrpos($update, ','));
		

		$sql = "UPDATE ".$this->escape($table)." SET ".$update." WHERE id=".$this->escape($id);
	/*tracing*/	
		if($tracing)
        $this->query("INSERT INTO tracing (`id_tracing` ,`id_user` ,`id_object` ,`type` ,`object` ,`sql_execute` ,`created`) VALUES(DEFAULT,".$_SESSION['User']['id'].",".$this->escape($id).",'UPDATE','".$this->escape($table)."','".$this->escape($sql)."','".date("Y-m-d H:i:s")."')");
  
    /*Fintracing*/
	return $this->query($sql);
	}
	function update2($table, $data, $field, $id,$delete=false) {

		if(!isset($data['modified'])) {
			$data['modified'] = date("Y-m-d H:i:s");
		}

		$fields = $this->get_sql_field_names($table);
		$update = '';
		foreach($data as $k=>$v) {
			if(in_array($k,$fields)) {
				$update .= "`$k`='".$this->escape($v)."', ";
			}
		}

		$update = substr($update, 0, strrpos($update, ','));
		

		$sql = "UPDATE ".$this->escape($table)." SET ".$update." WHERE ".$this->escape($field)."=".$this->escape($id);
       /*tracing*/
	   if($tracing)		
        $this->query("INSERT INTO tracing (`id_tracing` ,`id_user` ,`id_object` ,`type` ,`object` ,`sql_execute` ,`created`) VALUES(DEFAULT,".$_SESSION['User']['id'].",".$this->escape($id).",'UPDATE','".$this->escape($table)."','".$this->escape($sql)."','".date("Y-m-d H:i:s")."')");
 /*Fintracing*/
	return $this->query($sql);
	}
	function update3($table, $data, $field1, $id1 , $field2, $id2 ,$delete=false) 
		{
			if(!isset($data['modified']))
			{
				$data['modified'] = date("Y-m-d H:i:s");
			}
			
			$fields = $this->get_sql_field_names($table);
			$update = '';
			foreach($data as $k=>$v) {
				if(in_array($k,$fields)) {
					$update .= "`$k`='".$this->escape($v)."', ";
				}
			}
			
			$update = substr($update, 0, strrpos($update, ','));
			
			$sql = "UPDATE ".$this->escape($table)." SET ".$update." WHERE ".$this->escape($field1)."=".$this->escape($id1)." AND ".$this->escape($field2)."=".$this->escape($id2);
			
			return $this->query($sql);
		}
	function updateposition($table, $data, $id) {

		if(!isset($data['modified'])) {
			$data['modified'] = date("Y-m-d H:i:s");
		}

		$fields = $this->get_sql_field_names($table);
		$update = '';
		foreach($data as $k=>$v) {
			if(in_array($k,$fields)) {
				$update .= "`$k`='".$this->escape($v)."', ";
			}
		}

		$update = substr($update, 0, strrpos($update, ','));
		

		$sql = "UPDATE ".$this->escape($table)." SET ".$update." WHERE position=".$this->escape($id);

	return $this->query($sql);
	}

	
	function delete($table, $id, $tracing=FALSE) {
		

		$sql = "DELETE FROM ".$this->escape($table)." WHERE id=".$this->escape($id);
	   /*tracing*/	
	   if($tracing)	
$this->query("INSERT INTO tracing (`id_tracing` ,`id_user` ,`id_object` ,`type` ,`object` ,`sql_execute` ,`created`) VALUES(DEFAULT,".$_SESSION['User']['id'].",".$this->escape($id).",'DELETE','".$this->escape($table)."','".$this->escape($sql)."','".date("Y-m-d H:i:s")."')");
     /*Fintracing*/	
	return $this->query($sql);
	}
/*different name id
====================*/
function delete2($table, $field, $id, $tracing=FALSE) {
		

		$sql = "DELETE FROM ".$this->escape($table)." WHERE ".$this->escape($field)."=".$this->escape($id);
		
	/*tracing*/	
	if($tracing)	
$this->query("INSERT INTO tracing (`id_tracing` ,`id_user` ,`id_object` ,`type` ,`object` ,`sql_execute` ,`created`) VALUES(DEFAULT,".$_SESSION['User']['id'].",".$this->escape($id).",'DELETE','".$this->escape($table)."','".$this->escape($sql)."','".date("Y-m-d H:i:s")."')");
/**/			

	return $this->query($sql);
	}
/**/	
	function delete3($table, $field, $id,$field_1,$id_1) {
		

		$sql = "DELETE FROM ".$this->escape($table)." WHERE ".$this->escape($field)."=".$this->escape($id)." AND ".$this->escape($field_1)."=".$this->escape($id_1);
		
		

	return $this->query($sql);
	}
/***/
	function get_insert_id() {
		return $this->insert_id;
	}


	function get_sql_field_names($table) {
		$columns = array();
		$rows = $this->get_rows("SHOW COLUMNS FROM ".$table);
		foreach($rows as $k=>$v) {
			if(!in_array($v['Field'], $columns)) {
				$columns[] = $v['Field'];
			}
		}
	return $columns;
	}


	function print_debug($debug) {
		echo '<pre>';
		if(is_string($debug)) {
			echo $debug;
		} else {
			print_r($debug);
		}
		echo '</pre>';
	}
}