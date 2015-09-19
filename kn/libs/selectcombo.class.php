<?php
require_once ("database_exec.class.php");

class clsCombo{

	function createSelectCombo($id, $sqlstmt, $valueField, $displayField, $chkValue, $alt){

		$dbexec = cpsidbexec::getInstance();
		$result = $dbexec->execBySQL($sqlstmt, true);
		$strSelect = "\n<select id='".$id."' name='".$id."' class='selectCombo' alt='$alt'>\n";
		$strSelect .= "<option value=''>&nbsp;</option>\n";
		for($i=0; $i < count($result); $i++){
			$strSelect .= "<option value='" . $result[$i]->$valueField ."'"; 
			$strSelect .= ($chkValue == $result[$i]->$valueField)?" selected ":"";
			$strSelect .= ">" . $result[$i]->$displayField . "</option>\n";
		}  			
		$strSelect .= "</select>";
		return $strSelect;
	}//end createSelect

	function createCombo($id, $sqlstmt, $valueField, $displayField, $chkValue, $style, $alt){

		$dbexec = cpsidbexec::getInstance();
		$result = $dbexec->execBySQL($sqlstmt, true);
		$strSelect = "\n<select id='".$id."' name='".$id."' " . $style . " alt='$alt'>\n";
		$strSelect .= "<option value=''>&nbsp;</option>\n";
		for($i=0; $i < count($result); $i++){
			$strSelect .= "<option value='" . $result[$i]->$valueField ."'"; 
			$strSelect .= ($chkValue == $result[$i]->$valueField)?" selected ":"";
			$strSelect .= ">" . $result[$i]->$displayField . "</option>\n";
		}  			
		$strSelect .= "</select>";
		return $strSelect;
	}//end createSelect

	function createDayCombo($id,$value,$style){
		$strSelect = "\n<select id='".$id."' name='".$id."' " . $style . " alt='Day'>\n";
		$strSelect .= "<option value=''>&nbsp;</option>\n";
		for($i=1; $i <= 31; $i++){
			$strSelect .= "<option value='" . $i ."'"; 
			$strSelect .= ($value == $i)?" selected ":"";
			$strSelect .= ">" . $i . "</option>\n";
		}  			
		$strSelect .= "</select>";
		return $strSelect;
	}
	function createMonthCombo($id,$value,$style){
		$strSelect = "\n<select id='".$id."' name='".$id."' " . $style . " alt='Month'>\n";
		$strSelect .= "<option value=''>&nbsp;</option>\n";
		for($i=1; $i <= 12; $i++){
			$strSelect .= "<option value='" . $i ."'"; 
			$strSelect .= ($value == $i)?" selected ":"";
			$strSelect .= ">" . $i . "</option>\n";
		}  			
		$strSelect .= "</select>";
		return $strSelect;
	}
	function createYearCombo($id,$start,$end,$value,$style){
		$strSelect = "\n<select id='".$id."' name='".$id."' " . $style . " alt='Year'>\n";
		$strSelect .= "<option value=''>&nbsp;</option>\n";
		for($i=$start; $i <= $end; $i++){
			$strSelect .= "<option value='" . $i ."'"; 
			$strSelect .= ($value == $i)?" selected ":"";
			$strSelect .= ">" . $i . "</option>\n";
		}  			
		$strSelect .= "</select>";
		return $strSelect;
	}

}
?>