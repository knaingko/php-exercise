<?php
class clsNavigator
{

	/** @var int The record number to start dislpaying from */
	var $startRecord = null;
	/** @var int Number of rows to display per page */
	var $recordLimit = null;
	/** @var int recordTotal number of rows */
	var $recordTotal = null;
	var $endRecord = null;
	var $pageTotal = null;


	var $pageName	= null;
	var $argument	= null;
	var $combo	= null;
	var $thisPage = null;
	
	
	function __construct($pageName, $recordTotal, $comboName, $hidPageName)
	{
		
		$this->pageName = $pageName;
		$this->combo = $comboName;
		$this->hidPageName = $hidPageName;		
		
//		$this->thisPage = empty($_GET['page'])?1:$_GET['page'];
		$this->thisPage = empty($_POST[$hidPageName])?1:$_POST[$hidPageName];
		$this->recordTotal = intval($recordTotal); //find record total
		$limit = 20;
//		$limit = empty($_GET['limit'])?25:$_GET['limit'];
		$limit = empty($_POST[$comboName])?$limit:$_POST[$comboName];
		
      $this->recordLimit = max(intval($limit),1); // find record limit per page
		$this->pageTotal= ceil( $this->recordTotal / $this->recordLimit ); //total page calculate


		
		if(($this->thisPage * $this->recordLimit) - $this->recordLimit > $this->recordTotal)
		{
			$this->startRecord = 0;
		}else{
			$this->startRecord = ($this->thisPage * $this->recordLimit) - $this->recordLimit;
		}
		if ($this->recordLimit >= $this->recordTotal) {
			$this->startRecord = 0;
		}

		//calculate record display counter
		if ($this->startRecord + $this->recordLimit < $this->recordTotal) {
			$this->endRecord = $this->startRecord + $this->recordLimit;
		} else {
			$this->endRecord = $this->recordTotal;
		}
		//calculate current page
		$this->thisPage = ceil( ($this->startRecord+1) / $this->recordLimit );

	}
	/**
	* @return string The html for the pages counter, eg, Results 1-10 of x
	*/
	function getPagesCounter() {
	   $recCounter = "";
	   $recCounter = "<table>\n<tr>\n";
		$recCounter .= "<td nowrap='true' width='48%' align='right' class='text'> Display # </td>\n";
		$recCounter .= "<td class='text'><select id='$this->combo' name='$this->combo' class='numberCombo' onchange='submit();'>\n";
		for($io=5; $io<=40; $io+=5){
			$recCounter .= "<option	";
			if($this->recordLimit==$io){
				$recCounter .= "selected";
			}
			$recCounter .= " value=$io>$io</option>\n"; 
		}
		$recCounter .= "</select>\n</td>\n";
		$recCounter .= "<td nowrap='true' width='48%' align='left' class='text'>\n";
		if ($this->recordTotal > 0){
			$recCounter .= sprintf("Results %d to %d of %d", $this->startRecord+1, $this->endRecord, $this->recordTotal);
		} else {
			$recCounter .= "No records found.";
		}
		$recCounter .= "<input id='$this->hidPageName' name='$this->hidPageName' type='hidden' value='$this->thisPage'>\n";
		$recCounter .= "</td>\n</tr>\n</table>\n";
  		return $recCounter;
	}

	/**
	* @return string The html links for pages, eg, previous, next, 1 2 3 ... x
	*/
	function getPagesLinks(){
		$html = '';
		$displayPages = 10;
		
		$startLoop = (floor(($this->thisPage-1)/$displayPages))*$displayPages+1;
		if ($startLoop + $displayPages - 1 < $this->pageTotal) {
			$stopLoop = $startLoop + $displayPages - 1;
		} else {
			$stopLoop = $this->pageTotal;
		}
		
		if ($this->thisPage > 1){
			$page = $this->thisPage - 1;
			$html .= "<a href='$this->pageName?#1' class='pagenav' title='first page'
							onClick='javascript:document.forms[0].$this->hidPageName.value=1; submit(); return false;'
						><< Start </a>&nbsp;";
			
			$html .= "<a href='$this->pageName?#$page' class='pagenav' title='previous page'
							onClick='javascript:document.forms[0].$this->hidPageName.value=$page; submit(); return false;'
						>< Previous </a>&nbsp;";
						
		}else{
			$html .= "<span class='pagenav'><< Start </span>&nbsp;";
			$html .= "<span class='pagenav'>< Previous </span>&nbsp;";
		}

		for ($i=$startLoop; $i <= $stopLoop; $i++) {
			$page = ($i - 1) * $this->recordLimit;
			if ($i == $this->thisPage) {
				$html .= "<span class='pagenav'> $i </span>&nbsp;";
			} else {
				$html .= "<a href='$this->pageName?#$i' class='pagenav' 
									onClick='javascript:document.forms[0].$this->hidPageName.value=$i; submit(); return false;'
							>$i</a>&nbsp;";
			}
		}
		if ($this->thisPage < $this->pageTotal) {
			$page = $this->thisPage + 1;
			$html .= "<a href='$this->pageName?#$page' class='pagenav' title='next page' 
								onClick='javascript:document.forms[0].$this->hidPageName.value=$page; submit(); return false;' 
						> Next ></a>&nbsp;";
			$html .= "<a href='$this->pageName?#$this->pageTotal' class='pagenav' title='end page' 
								onClick='javascript:document.forms[0].$this->hidPageName.value=$this->pageTotal; submit(); return false;'
						> End >></a>&nbsp;";
		} else {
			$html .= "<span class='pagenav'> Next ></span>";
			$html .= "<span class='pagenav'> End >></span>";
		}
		return $html;
	}
}
?>

