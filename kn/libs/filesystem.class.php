<?php
require_once("general.class.php");
require_once("exceptions.class.php");
require_once("alert.class.php");

class cpsiFileSystem{

	private static $instance=null;

	public static function getInstance () {
		if (self::$instance==null) {
			self::$instance =& new cpsiFileSystem();
		}
		return self::$instance;
	}

	function sizeFormat($size){
	/* 	Returns a human readable size 	*/
	 $i=0;
	 $iec = array("B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
	 while (($size/1024)>1) {
	   $size=$size/1024;
	   $i++;
	 }
	 return substr($size,0,strpos($size,'.')+4).$iec[$i];
	}

	function diskTotalSpace($drive){
		return $this->sizeFormat(disk_total_space("$drive:")); 
	}

	function diskFreeSpace($drive){
		return $this->sizeFormat(disk_free_space("$drive:")); 
	}

	function diskUsedSpace($drive){
		$total = round(disk_total_space("$drive:")/1024/1024,2);
		$free =  round(disk_free_space("$drive:")/1024/1024,2); 
		return $this->sizeFormat($total - $free);
	}
	
	function fileSize($fileName){
		if(!file_exists($fileName)){
			throw new CustomException($fileName,11010);
		}
		return $this->sizeFormat(filesize($fileName));
	}

	function fileType($fileName){
		if(!file_exists($fileName)){
			throw new CustomException($fileName,11010);
		}
		return filetype($fileName);
	}

	function copyFile($source, $destination){
		try{
			//check destination path
			$destination = ($destination == '')?'./':$destination;

			//find source path
			if($source =='') throw new CustomException($source,11000);

			if(!file_exists($source)){
				throw new CustomException($source,11010);
			}
			
			$gen = cpsiGeneral::getInstance();
			if(! @copy($gen->stringTopath($source), $gen->stringTopath($destination))){
				throw new CustomException($destination,11010);
			}
			
		}catch (Exception $err){
			$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
			echo $msg->msgOutPut();
			return false;
		}
		return true;
	}
	//end copy file function end

	function moveFile($source, $destination){
		try{
			//check destination path
			$destination = ($destination == '')?'./':$destination;

			//find source path
			if($source =='') throw new CustomException($source,11000);

			if(!file_exists($source)){
				throw new CustomException($source,11010);
			}
			
			$gen = cpsiGeneral::getInstance();
			if(copy($gen->stringTopath($source), $gen->stringTopath($destination))){
				$copy = true;
			}else{
				throw new CustomException($destination,11011);
			}
			if(!unlink($gen->stringTopath($source))){
				if($copy){
					unlink($gen->stringTopath($destination));
				}
				throw new CustomException($source,11011);
			}
			
		}catch (Exception $err){
			$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
			echo $msg->msgOutPut();
			return false;
		}
		return true;
	}
	//end move file function
	
	function deleteFile($source){
		try{
			//find source path
			if($source =='') throw new CustomException($source,11000);
			if(!file_exists($source)){
				throw new CustomException($source,11001);
			}
			
			$gen = cpsiGeneral::getInstance();
			if(!unlink($gen->stringTopath($source))){
				throw new CustomException($source,11012);
			}
			
		}catch (Exception $err){
			$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
			echo $msg->msgOutPut();
			return false;
		}
		return true;
	}
	//end delete file function end
	function deleteAllFile($path, $extension){
		foreach (glob($path."*.".$extension) as $filename) {
			@unlink($filename);
		}
	}
}
?>