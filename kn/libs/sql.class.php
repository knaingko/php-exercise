<?php
	class cpsiSQL{
		private static $instance=null;
	
		public static function getInstance() {
			if (self::$instance==null) {
				self::$instance =& new cpsiSQL();
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

		function getInsertSQL($table, $toAdd)
		{
			$insert = $this->compile_insert_string($toAdd);
			$sqlstmt = "INSERT INTO {$table} (".$insert['FIELD_NAMES'].") VALUES (" .$insert['FIELD_VALUES'].")";
			return $sqlstmt;
		}

		function getDeleteSQL($table, $toCheck){
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
			return $sqlstmt;
		}

		function getUpdateSQL($table, $toUpdate, $toCheck)
		{
			$strUpdate ='';
			foreach($toUpdate as $field => $value) {
				$strUpdate .= "$field = '" . preg_replace( "/'/", "\\'", $value ) ."', ";
				// .preg_replace( "/'/", "\\'", $value ). "', ";
			}
			$strUpdate = substr($strUpdate, 0, strlen($strUpdate)-2);
		
			if(isset($toCheck)){
				$strCheck = ' where ';
				foreach($toCheck as $field => $value) {
					$strCheck .= "$field = '" . preg_replace( "/'/", "\\'", $value ) ."' and ";
					// .preg_replace( "/'/", "\\'", $value ). "' and ";
				}
			}else{
				$strCheck ='';
			}
			
			$strCheck = substr($strCheck, 0, strlen($strCheck)-4);
			$sqlstmt = "update ".$table ." set ". $strUpdate  . $strCheck;
			return $sqlstmt;
		}
		

		function getSelectSQL($table, $toSelect, $checkOperator, $toCheck, $toOrder, $toLimit){
			//Prepare for where statement
			$strCheck = '';
			if(!empty($toCheck)){
				foreach($toCheck as $field => $value) {
					$strCheck .= "$field ". $checkOperator . " '" .preg_replace( "/'/", "\\'", $value ). "' AND ";
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

			$sqlstmt = "SELECT " . $toSelect . " FROM " .$table . $strCheck . $strOrder ." ". $toLimit;
			return $sqlstmt;
		}
	}
?>