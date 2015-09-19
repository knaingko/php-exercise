<?php
require_once ("exceptions.class.php");
require_once ("alert.class.php");

class cpsiUpload
{
	public $uploadTemp = '';
	public $uploadFileName = '';
	public $uploadFileSize = '';
	public $uploadFileType = '';

	private static $instance=null;

	public static function getInstance() {
		if (self::$instance==null) {
			self::$instance =& new cpsiUpload();
		}
		return self::$instance;
	}
	
	function uploadFile($source){
		try{
			//upload data
			$this->uploadFileType = $_FILES[$source]["type"];
			$this->uploadFileName = $_FILES[$source]["name"];
			$this->uploadFileSize = $_FILES[$source]["size"];
			$this->uploadTemp = $_FILES[$source]["tmp_name"]; 

		}catch (Exception $err){
			$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
			echo $msg->msgOutPut();
			return false;
		}
		return true;
	}

	function checkFileType($fileType, $fileExtension){
		try{
			$ft = '';
			switch($fileType){
			case 'jpg':
				$ft = 'image/pjpeg';
			break;
			case 'jpeg':
				$ft = 'image/pjpeg';
			break;
			case 'gif':
				$ft = 'image/gif';
			break;
			case 'png':
				$ft = 'image/png';
			break;
			}
			if($this->uploadFileType==$ft){
				// Check extension
				$extArray = explode(".", $this->uploadFileName);
				$findExtPos = count($extArray);
				$extension = $extArray[$findExtPos-1];
				if(strtolower($extension)!=strtolower($fileExtension)){
					throw new CustomException($extension,11002);
				}
			}else{
				throw new CustomException($ft,11002);
			}
		}catch (Exception $err){
			$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
			echo $msg->msgOutPut();
			return false;
		}
		return true;
	}
	//end check file type

	function checkFileSize($maxSize){
		try{
			if($this->uploadFileSize>$maxSize){
				throw new CustomException($maxSize,11004);
			}
		}catch (Exception $err){
			$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
			echo $msg->msgOutPut();
			return false;
		}
		return true;
	}

}
?>