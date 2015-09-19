	<?php
	class cpsiGeneral{

		private static $instance=null;
	
		public static function getInstance() {
			if (self::$instance==null) {
				self::$instance =& new cpsiGeneral();
			}
			return self::$instance;
		}
		
		function strReplaceQuote($value){
			return preg_replace("/\\\'/","'",$value);
		}

		function stringTopath($strPath){
			return preg_replace('/\\\\/','\\\\\\',$strPath);
		}
		
		function currentDate($format="DMY"){
			$rtnDate =  null;
			switch($format){
			case "DMY":
				$rtnDate=date("j-n-Y",(time() + (6.5 * 3600)));
				break;			
			case "MDY":
				$rtnDate=date("n-j-Y",(time() + (6.5 * 3600)));
				break;
			case "YMD":
				$rtnDate=date("Y-m-d",(time() + (6.5 * 3600)));
				break;
			}
			return $rtnDate;
		}

		function currentTime(){
			return date("h:i:s",(time() + (6.5 * 3600)));
		}


		function array_invert_two($multiArray)
		{
			$result = Array();
			foreach($multiArray as $keymaster => $value ) 
				foreach($value as $key => $keyTovalue  ) 
					 $result[$key][$keymaster] = $keyTovalue;
			return $result;
		}

		function phpArrayToJsObject($array, $objName)
		{
			return 'var ' . $objName . ' = ' . $this->PhpArrayToJsObjectRecurse($array) . ";\n";
		}

		function PhpArrayToJsObjectRecurse($array)
		{
			if(!is_array($array))
			{
				if ($array == null) return 'null';	
				return '"' . $array . '"';
			}
			
			$retVal = "{";
			$first = true;
			foreach($array as $key => $value)
			{
				if(! $first ){$retVal .= ', ';};
				$first = false;
//				if (is_string($key)){$key = '"' . $key . '"';}
				if (is_string($key)){$key = $key ;}
				$retVal .= $key . ' : ' . $this->PhpArrayToJsObjectRecurse($value);
			}
			return $retVal .= "}";
		}

		function phpArrayToJsArray($name,$array,$prePend='var ')
		{
			if (is_array($array)) { // Array recursion
				 $result = $name.' = new Array();'."\n";
				 foreach ($array as $key => $value) {
					 $result .= $this->phpArrayToJsArray($name.'["'.$key.'"]',$value,'');
				 }
			} else {  // Base case of recursion
				 $result = $name.' = "'.$array.'";'."\n";
			}
			return $prePend.$result;
		}
	}
?>