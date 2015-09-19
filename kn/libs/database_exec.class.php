<?php
	require_once "exceptions.class.php";
	require_once "database_conn.class.php";
	require_once("alert.class.php");
		
	class cpsidbexec{
		private static $instance=null;
	
		public static function getInstance() {
			if (self::$instance==null) {
				self::$instance =& new cpsidbexec();
			}
			return self::$instance;
		}

		function compile_insert_string($data) 
		{    
			$field_names  = "";
			$field_values = "";
			
			foreach ($data as $field => $value) 
			{
//				$value = preg_replace("/'/", "'",$value);
				//$v = preg_replace( "/#/", "\\#", $v );
				$field_names  .= "$field,";
				$field_values .= "'$value',";
			}
			
			$field_names  = preg_replace( "/,$/" , "" , $field_names);
			$field_values = preg_replace( "/,$/" , "" , $field_values);
	
			return array('FIELD_NAMES'  => $field_names, 'FIELD_VALUES' => $field_values,);
		}
		
	
		function insertDataToDB($table, $toAdd)
		{
			$myconn=null;
			try{
				$clsMyconn = cpsiConnection::getInstance();
				$clsMyconn->open_connection($myconn); //Open Connection
				$insert = $this->compile_insert_string($toAdd);
				$sqlstmt = "INSERT INTO {$table} (".$insert['FIELD_NAMES'].") VALUES ("
												   .$insert['FIELD_VALUES'].")";
//				echo ($sqlstmt);
				if(!$myconn->query($sqlstmt)){
					throw new CustomException($myconn->error, $myconn->errno);
				}
				$myconn->close();
				
			}
			catch (Exception $err)
			{
				$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
				echo $msg->msgOutPut();
				return false;
			}
			return true;
		}
		
		
		function updateDataToDB($table, $toUpdate, $toCheck)
		{
			$myconn=null;
			try
			{
				$strUpdate ='';
				foreach($toUpdate as $field => $value) {
				   $strUpdate .= "$field = '" . preg_replace( "/'/", "\\'", $value ) ."', ";
				   // .preg_replace( "/'/", "\\'", $value ). "', ";
				}
				$strUpdate = substr($strUpdate, 0, strlen($strUpdate)-2);
			
				$strCheck ='';
				foreach($toCheck as $field => $value) {
				   $strCheck .= "$field = '" . preg_replace( "/'/", "\\'", $value ) ."' and ";
				   // .preg_replace( "/'/", "\\'", $value ). "' and ";
				}
				$strCheck = substr($strCheck, 0, strlen($strCheck)-4);
				$sqlstmt = "update ".$table ." set ". $strUpdate  . " where " . $strCheck;
				$clsMyconn = cpsiConnection::getInstance();
				$clsMyconn->open_connection($myconn); //Open Connection
				if(!$myconn->query($sqlstmt)) 
					throw new CustomException($myconn->error, $myconn->errno);
				$myconn->close();
			}
			catch(Exception $err)
			{
				$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
				echo $msg->msgOutPut();
				return false;
			}
			return true;
		}
	
		function deleteDataToDB($table, $toCheck){
			$myconn=null;
			try
			{
				$strCheck ='';
				foreach($toCheck as $field => $value) {
				   $strCheck .= "$field = '" .preg_replace( "/'/", "\\'", $value ). "' and ";
				}
				if($strCheck!=''){
					$strCheck = " where " . substr($strCheck, 0, strlen($strCheck)-4);
				}else{
					$strCheck ='';
				}
				
				$sqlstmt = "delete from ".$table . $strCheck;
				$clsMyconn = cpsiConnection::getInstance();
				$clsMyconn->open_connection($myconn); //Open Connection
//				echo $sqlstmt;
				if(!$myconn->query($sqlstmt)){
					throw new CustomException($myconn->error, $myconn->errno);
				}
				$myconn->close();
			}
			catch(Exception $err)
			{
				$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
				echo $msg->msgOutPut();
				return false;
			}
			return true;
		}
	
	
		function selectDataFromDB($table, $toSelect, $toCheck, $toOrder, $toLimit){
			$data = array();
			$myconn=null;
			try
			{
				//Prepare for where statement
				$strCheck = '';
				if(!empty($toCheck)){
					foreach($toCheck as $field => $value) {
					   $strCheck .= "$field ='" .preg_replace( "/'/", "\\'", $value ). "' AND ";
					}
					if($strCheck!=''){
						$strCheck = " WHERE " . substr($strCheck, 0, strlen($strCheck)-4);
					}else{
						$strCheck ='';
					}
				}else $strCheck = '';
				
				//prepare for order statement
				$strOrder ='';
				if(!empty($toOrder)){
					foreach($toOrder as $field => $value) {
					   $strOrder .= $field . " " . $value . ", ";
					}
					if($strOrder!=''){
						$strOrder  = " ORDER BY " . substr($strOrder , 0, strlen($strOrder)-2);
					}else{
						$strOrder ='';
					}
				}else $strOrder = '';

				//prepare for limit statement
				$strLimit = '';
				if(!empty($toLimit)){
					$strLimit = " LIMIT " . $toLimit;
				}else $strLimit = '';
				
				$sqlstmt = "SELECT " . $toSelect . " FROM " .$table . $strCheck . $strOrder . $strLimit;
//				echo $sqlstmt ;
				$clsMyconn = cpsiConnection::getInstance();
				$clsMyconn->open_Connection($myconn);
				if(!$result = $myconn->query($sqlstmt)){
					throw new CustomException($myconn->error, $myconn->errno);
				}
				while($records = $result->fetch_object()){
					$data[] = $records; 
				}
				$result->close();
				$myconn->close();
			}
			catch(Exception $err)
			{
				$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
				echo $msg->msgOutPut();
				return false;	
			}
			return $data;
		}
	
		function selectDataFromLikeDB($table, $toSelect, $toCheck){
			$data = array();
			$myconn=null;
			try
			{
				$strCheck ='';
				foreach($toCheck as $field => $value) {
				   $strCheck .= "$field like '" .preg_replace( "/'/", "\\'", $value ). "%' AND ";
				}
				if($strCheck!=''){
					$strCheck = " WHERE " . substr($strCheck, 0, strlen($strCheck)-4);
				}else{
					$strCheck ='';
				}
				
				$sqlstmt = "SELECT " . $toSelect . " FROM " .$table . $strCheck;
				$clsMyconn = cpsiConnection::getInstance();
				$clsMyconn->open_Connection($myconn);
				if(!$result = $myconn->query($sqlstmt)){
					throw new CustomException($myconn->error, $myconn->errno);
				}else
				{
					while($records = $result->fetch_object()){
						$data[] = $records; 
					}
				}
				$result->close();
				$myconn->close();
			}
			catch(Exception $err)
			{
				$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
				echo $msg->msgOutPut();
				return false;	
			}
			return $data;
		}

		function check_duplicate($table, $toCheck)
		{
			$myconn=null;
			$clsMyconn = cpsiConnection::getInstance();
			$clsMyconn->open_connection($myconn);
	
			$strCheck ='';
			foreach($toCheck as $field => $value) {
			   $strCheck .= "$field = '" .preg_replace( "/'/", "\\'", $value ). "' and ";
			}
			$strCheck = substr($strCheck, 0, strlen($strCheck)-4);
			$sqlstmt = "select * from " .$table . " where " . $strCheck . " LIMIT 1";
	
			$result = $myconn->query($sqlstmt);
			if($result && $result->num_rows>0)
			{
				$result->close();
				throw new CustomException($table ,90001);;
			}
			$myconn->close();
		}
		
		function strReplace($value){
			$value = preg_replace("/\\\'/","'",$value);
			return $value;
		}

		function execBySQL($sqlStmt, $select = true, $returnType = 'object', &$rowAffect=0){
			$data = array();
			$myconn=null;
			try
			{
				$clsMyconn = cpsiConnection::getInstance();
				$clsMyconn->open_Connection($myconn);
				
				if(!$result = $myconn->query($sqlStmt)){
					throw new CustomException($myconn->error, $myconn->errno);
				}else{
					$rowAffect = $myconn->affected_rows;
				}
				if($select == true){
					switch($returnType){
					case 'object':
						while($records = $result->fetch_object()){
							$data[] = $records; 
						}
					break;
					case 'array':
						while($records = $result->fetch_array(MYSQLI_ASSOC)){
							$data[] = $records; 
						}
					break;
					}
					$result->close();
				}
				$myconn->close();
			}
			catch(Exception $err)
			{
				$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
				echo $msg->msgOutPut();
				return false;	
			}
			return  ($select == true)?$data:true;
		}
	}
?>
