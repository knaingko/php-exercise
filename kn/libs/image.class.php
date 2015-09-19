<?php
require_once ("exceptions.class.php");
require_once ("alert.class.php");

class clsImage{
	var $imageType = 'image/pjpeg';
	var $imageSize = 90;
	var $fileName = 'output.jpg';



	function imageCreateFromData($imgData){
		try{
//				error_reporting(E_ERROR);
//				if(!($source = imagecreatefromstring($imgData))){
//					throw new CustomException("Your picture can't recoverable!", error_reporting(E_ERROR));
//				}
			$source = imagecreatefromstring($imgData);
			$width = imagesx($source);
			$height = imagesy($source);
			$aspect_ratio = $height/$width;
			if ($width <= $this->imageSize) {
				$new_width = $width;
				$new_height = $height;
			} else {
				$new_width = $this->imageSize;
				$new_height = abs($new_width * $aspect_ratio);
			}
			$image = imagecreatetruecolor($new_width,$new_height); 
			imagecopyresized($image,$source,0,0,0,0,$new_width,$new_height,$width,$height);
			// determine image type and send it to the client 
			if (!headers_sent()) {
				header( "Content-type: $this->imageType"); 
			}
			switch($this->imageType){
			case "image/pjpeg": imagejpeg($image, $this->fileName);break;
			case "image/gif":	imagegif($image, $this->fileName); break;
			case "image/x-png": imagepng($image, $this->fileName); break;
			}
			imagedestroy($image); 
		}catch(Exception $err){
			$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
			echo $msg->msgOutPut();
		}
	}
}
?>

		
