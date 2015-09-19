<?php
require_once ("time.class.php");
require_once ("general.class.php");

class clsCrossTab{

	public $rowData;
	public $colHeader;
	public $colData;
	public $rowTotal;
	public $colTotal;
	
	function toSecond(&$time, $key) 
	{
		$t = split(':',$time);
		$hour = isset($t[0])?$t[0]:0;
		$minutes = isset($t[1])?$t[1]:0;
		$seconds = isset($t[2])?$t[2]:0;
		$time = ($hour * (3600)) + ($minutes * 60) + ($seconds);
	}

	function crossTabMulti($result, $leftField, $topField, $dataField, $sumType = 'both', $sumDataType = 'number'){
		$datas = array();
		$left = array();
		$top = array();
		$multikey = '';
//		$totalText ='';

		$gen = cpsiGeneral::getInstance();
		$time = cpsiTime::getInstance();

		if(count($result)>0){
			foreach ($result as $key => $record ){
				array_push($top,$record[$topField]); //find top header
				
				//find data
				$isfirst = true;
				foreach($leftField as $val){
					if($isfirst){
						$multikey = $record[$val];
					}else{
						$multikey .= ";" . $record[$val] ;
					}
					$isfirst = false;
				}
				$isfirst = true;
				array_push($left,$multikey); //find left fields
				$multikey = "['" . $multikey . "']['".$record[$topField] ."']";
				//datatype ( datatype, format )
				$assignValue = '';
				switch($sumDataType[0]){
				case 'number': 
					$assignValue = round($record[$dataField],$sumDataType[1]);
				break;
				case 'time': 
					$assignValue= $time->toSeconds($record[$dataField]);
					switch($sumDataType[1]){
					case 'HMS':
						$assignValue = $time->toHMS($assignValue);
					break;
					case 'HM':
						$assignValue = $time->toHM($assignValue);
					break;
					case 'H':
						$assignValue = $time->toH($assignValue);
					break;
					default:
						$assignValue=$assignValue;
					}
				break;
				}
				eval("\$datas" . $multikey . " = '" . $assignValue . "';");
				$multikey = '';
			}

			switch($sumType){
			case 'both':
				//column total caption assign
				$totalText = 'Total' . str_repeat(';-',(count($leftField)-1));
				array_push($left,$totalText);
				//column total
				$idata = $gen->array_invert_two($datas);
				foreach ($idata as $key=>$record ){
					switch($sumDataType[0]){
					case 'number': 
						$total[$key]=round(array_sum($record),$sumDataType[1]);
					break;
					case 'time': 
						array_walk($record,array('clsCrossTab','toSecond'));
						switch($sumDataType[1]){
						case 'HMS':
							$total[$key]=$time->toHMS(array_sum($record));
						break;
						case 'HM':
							$total[$key]=$time->toHM(array_sum($record));
						break;
						case 'H':
							$total[$key]=$time->toH(array_sum($record));
						break;
						default:
							$total[$key]=$time->toHMS(array_sum($record));
						}
					break;
					}
					$idata[$key][$totalText] = $total[$key];
				}
				$datas = $gen->array_invert_two($idata);
	
				//row total caption assign
				array_push($top,'Total'); 
				//row total
				foreach ($datas as $key=>$record ){
					switch($sumDataType[0]){
					case 'number': 
						$total[$key]=round(array_sum($record),$sumDataType[1]);
					break;
					case 'time': 
						array_walk($record,array('clsCrossTab','toSecond'));
						switch($sumDataType[1]){
						case 'HMS':
							$total[$key]=$time->toHMS(array_sum($record));
						break;
						case 'HM':
							$total[$key]=$time->toHM(array_sum($record));
						break;
						case 'H':
							$total[$key]=$time->toH(array_sum($record));
						break;
						default:
							$total[$key]=$time->toHMS(array_sum($record));
						}
					break;
					}
					$datas[$key]['Total'] = $total[$key];
				}
			break;
			case 'column':
				//column total caption assign			
				$totalText = 'Total' . str_repeat(';-',(count($leftField)-1));
				array_push($left,$totalText);
				//column total
				$idata = $gen->array_invert_two($datas);
				foreach ($idata as $key=>$record ){
					switch($sumDataType[0]){
					case 'number': 
						$total[$key]=round(array_sum($record),$sumDataType[1]);
					break;
					case 'time': 
						array_walk($record,array('clsCrossTab','toSecond'));
						switch($sumDataType[1]){
						case 'HMS':
							$total[$key]=$time->toHMS(array_sum($record));
						break;
						case 'HM':
							$total[$key]=$time->toHM(array_sum($record));
						break;
						case 'H':
							$total[$key]=$time->toH(array_sum($record));
						break;
						default:
							$total[$key]=$time->toHMS(array_sum($record));
						}
					break;
					}
					$idata[$key][$totalText] = $total[$key];
				}
				$datas = $gen->array_invert_two($idata);

			break;
			case 'row':
				//row total caption assign
				array_push($top,'Total'); 
				//row total
				foreach ($datas as $key=>$record ){
					switch($sumDataType[0]){
					case 'number': 
						$total[$key]=round(array_sum($record),$sumDataType[1]);
					break;
					case 'time': 
						array_walk($record,array('clsCrossTab','toSecond'));
						switch($sumDataType[1]){
						case 'HMS':
							$total[$key]=$time->toHMS(array_sum($record));
						break;
						case 'HM':
							$total[$key]=$time->toHM(array_sum($record));
						break;
						case 'H':
							$total[$key]=$time->toH(array_sum($record));
						break;
						default:
							$total[$key]=$time->toHMS(array_sum($record));
						}
					break;
					}
					$datas[$key]['Total'] = $total[$key];
				}
			break;
			}
			
			//return data and header
			$this->rowData = array_unique($left);
			$this->colHeader = array_unique($top);
			$this->colData = $datas;

		}
	}
}
?>