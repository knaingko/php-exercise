<?php
/*
generateFormat Constant
P - Prefix
S - Suffix
V - Value
D - day ( 01 - 31 )
M - month ( 01 - 12 )
y - year  ( 00 - 06 ) not include century
Y - year (1900  - 9999 )
T - Time ( HH:MM:SS )
H - Hour ( 01 - 24 )

check Key ( chKey ) Constant
D = by day
M = by month
Y = by year

require_once("../classes/autogenerate.class.php");
$auto = new autogenerate();
$auto->item = 'test_day'; 
$auto->prefix = 'TD';
$auto->valueWidth = 3;
$auto->reuseable = 0;
$auto->chKey = 'D';
$auto->generateFormat = 'PYMDV';
$gen = $auto->generate();
*/
require_once("database_exec.class.php");

class autogenerate{

	private $value;
	private $dateValue;
	var $generateFormat;
	var $valueWidth;
	var $suffix;
	var $prefix;
	var $item;
	var $reuseable = 1;
	var $chKey = 'M';
	
	protected function find_record($arrayValue, $findField, $findValue)
	{
		$recNo = -1;
		foreach($arrayValue as $recordNo=>$value){
			if($value->$findField == $findValue){
				$recNo = $recordNo;
			}
		}
		return $recNo;
	}

	protected function calValue()
	{
		$this->dateValue = getdate(time() + (6.5 * 3600));
		$genStr = '';
		for($start=0; $start < strlen($this->generateFormat) ; $start++)
		{
			switch(substr($this->generateFormat,$start,1)){
				case 'P':
					$genStr .= $this->prefix;
					break;
				case 'S':
					$genStr .= $this->suffix;
					break;
				case 'V':
					$this->value  = $this->value+1;
					$genStr .= str_repeat('0', $this->valueWidth - strlen($this->value) ) . $this->value;
					break;
				case 'D':
					$genStr .= $this->dateValue['mday'];
					break;
				case 'M':
					$genStr .= $this->dateValue['mon'] + 1;
					break;
				case 'y':
					$genStr .= substr($this->dateValue['year'],2,2);
					break;
				case 'Y':
					$genStr .= $this->dateValue['year'];
					break;
				case 'T':
				$genStr .= $this->dateValue['hours'] . $this->dateValue['minutes'] . $this->dateValue['seconds'];
					break;
				case 'H':
					$genStr .= $this->dateValue['hours'];
				break;
			}
		}	
		return $genStr;
	}

	function generate()
	{
		$genValue = '';
		$recNo = -1;
		$dbexec = cpsidbexec::getInstance(); //load class

		//database execute and retrive data
		$toSelect = "item, generate_value, last_date, reuseable";
		$toCheck =array('item'=>$this->item);
		$result= $dbexec->selectDataFromDB("autogenerate", $toSelect, $toCheck, NULL, 0);
		
		if(count($result)<=0){
			$this->value = 0;
			$genValue = $this->calValue();
			
		}else{
			if($this->reuseable == 1){
				$this->value = $result[count($result)-1]->generate_value;;
				$recNo = 0;
				$genValue = $this->calValue();
			}else{
				$recNo = $this->find_record($result, 'last_date', date('Y-m-d',time() + (6.5 * 3600)));

				switch($this->chKey){
				case 'D':
					if($result[$recNo]->last_date != date('Y-m-d',time() + (6.5 * 3600))){
						$this->value = 0;
					}else{
						$this->value = $result[$recNo]->generate_value;
					}
					break;
				case 'M':
					$ym = $result[$recNo]->last_date;
					if(date('Y-m','$ym') != date('Y-m-d',time() + (6.5 * 3600))){
						$this->value = 0;					
					}else{
						$this->value = $result[$recNo]->generate_value;
					}
					break;
				case 'Y':
					$y = $result[$recNo]->last_date;
					if(date('Y-m','$y') != date('Y-m-d',time() + (6.5 * 3600))){
						$this->value = 0;					
					}else{
						$this->value = $result[$recNo]->generate_value;
					}
					break;
				default:
					$this->value = $result[$recNo]->generate_value;
					break;
				}			
				$genValue = $this->calValue();
			}
		}
		
		if($this->value <= 1){
			//insert data to DB
			$toAdd = array(	'item'=>$this->item, 
							'generate_value'=>$this->value, 
							'last_date'=>date('Y-m-d',time() + (6.5 * 3600)),
							'reuseable'=>$this->reuseable);
			$dbexec->insertDataToDB('autogenerate', $toAdd);
		}else{
			//update data to DB
			$toUpdate = array('generate_value'=>$this->value, 
							'last_date'=>date('Y-m-d',time() + (6.5 * 3600)),
							'reuseable'=>$this->reuseable);
			$ToCheck =array('item'=>$this->item, 'last_date'=>$result[$recNo]->last_date);
			$dbexec->updateDataToDB('autogenerate', $toUpdate, $ToCheck);
		}		
		return $genValue;
	}		


}
?>
