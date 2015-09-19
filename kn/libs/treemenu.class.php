<?php
	class clsTreeMenu{

		var	$menuName =''; //must be include level parameter(|), expand(+) and disable (#) character
		var	$menuLink ='';
		//array('parameter name'=>array('field'=>'field name'),'hidAction'=>array('value'=>'stringvalue'));
		var	$menuLinkParameter = array(); 
		var	$menuIcon =array(); //first - normal, second - roolon
		var	$menuTooltip ='';
		var	$menuTarget ='_self';
		var	$menuStyle ='';
		var	$menuXPstyle ='';

		var $menuType = ''; //link, dialog
		var $menuReturnField = '';
		
		function createTreeMenu($result){
			$name = $this->menuName;
			$link =$this->menuLink;
			$linkParameter = $this->menuLinkParameter;
			$icon =$this->menuIcon;
			$tooltip =$this->menuTooltip;
			$target =$this->menuTarget;
			$style =$this->menuStyle;
			$XPstyle =$this->menuXPstyle;
			
			$treeMenuArray = '<script type="text/javascript" language="javascript">';
			for($iCount=0; $iCount < count($result); $iCount++){
				$tempLink = '';
				switch($this->menuType){
				case 'link':
					$tempParameter = '';

					reset($linkParameter); 
					if(isset($linkParameter)){
						while (list($parameter, $condition) = each($linkParameter)){
							while (list($menuType, $value) = each($condition)){
								switch($menuType){
								case 'field':
									$tempParameter .= $parameter . "=" . $result[$iCount]->$value . "&";
								break;
								case 'value':
									$tempParameter .= $parameter . "=" . $value . "&";
								break;
								}
							}
						}
					}
					$tempParameter = substr($tempParameter,0,(strlen($tempParameter)-1));
					$tempLink = $link ."?". $tempParameter;
				break;
				case 'dialog':
					if($this->menuReturnField==''){
						$tempLink = 'javascript: window.returnValue=""';
					}else{
						$returnField = $this->menuReturnField;
						$tempLink = 'javascript: window.returnValue="' . $result[$iCount]->$returnField . '"; window.close();';
					}
				break;
				case 'assign':
					$returnField = $this->menuReturnField;
					$tempLink = 'javascript:'. $link . '="' . $result[$iCount]->$returnField . '"';
				break;
				case 'javascript':
					$tempLink = 'javascript:' . $link ;
				break;
				}

				//start create tree menu
				$treeMenuArray .= "var myMenus = [";
				$treeMenuArray .= "'" . $result[$iCount]->$name . "'";// display name
				$treeMenuArray .= ",'" . $tempLink . "'";	//link or javascript
				if(count($icon) >0)
				{
					$treeMenuArray .= ",'" .$result[$iCount]->$icon[0] . "','" . 
											$result[$iCount]->$icon[1] . "','" .
											$result[$iCount]->$icon[2] . "'";
				}
//				else{
//					$treeMenuArray .= ",'',''";
//				}
				if($tooltip != ''){ $treeMenuArray .= ",'" . $result[$iCount]->$tooltip . "'"; }
				if($target != '_self'){ $treeMenuArray .= ",'" . $result[$iCount]->$target . "'"; }
				if($style != ''){ $treeMenuArray .= ",'" . $result[$iCount]->$style . "'"; }
				if($XPstyle != ''){ $treeMenuArray .= ",'" . $result[$iCount]->$XPstyle . "'"; }
				$treeMenuArray .= "];";
				$treeMenuArray .= "tmenuItems.push(myMenus);";
				
			}
//			print_r($treeMenuArray);
			$treeMenuArray .= "apy_tmenuInit();";		
			$treeMenuArray .= '</script>';
			echo $treeMenuArray;
		}
	}
?>
