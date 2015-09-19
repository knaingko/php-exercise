<?php
require_once("exceptions.class.php");
require_once("alert.class.php");
class cpsiDirectory{

	private static $instance=null;

	public static function getInstance() {
		if (self::$instance==null) {
			self::$instance =& new cpsiDirectory();
		}
		return self::$instance;
	}

	function searchdir ( $path , $maxdepth = -1 , $mode = "FULL" , $d = 0 )
	{
		// $path : path to browse
		// $maxdepth : how deep to browse (-1=unlimited)
		// $mode : "FULL"|"DIRS"|"FILES"
		// $d : must not be defined
	
	  if ( substr ( $path , strlen ( $path ) - 1 ) != '/' ) { $path .= '/' ; }      
	  $dirlist = array () ;
	  if ( $mode != "FILES" ) { $dirlist[] = $path ; }
	  if ( $handle = opendir ( $path ) )
	  {
		  while ( false !== ( $file = readdir ( $handle ) ) )
		  {
			  if ( $file != '.' && $file != '..' )
			  {
				  $file = $path . $file ;
				  if ( ! is_dir ( $file ) ) { if ( $mode != "DIRS" ) { $dirlist[] = $file ; } }
				  elseif ( $d >=0 && ($d < $maxdepth || $maxdepth < 0) )
				  {
					  $result = $this->searchdir ( $file . '/' , $maxdepth , $mode , $d + 1 ) ;
					  $dirlist = array_merge ( $dirlist , $result ) ;
				  }
		  }
		  }
		  closedir ( $handle ) ;
	  }
	  if ( $d == 0 ) { natcasesort ( $dirlist ) ; }
	  return ( $dirlist ) ;
	}

	function dir_exists($dir_name = false, $path = './'){
//		echo "a";
		if(!$dir_name) return false;
		if(is_dir($path.$dir_name)) return true;
		$tree = glob($path.'*', GLOB_ONLYDIR);
		echo "<pre>";
		print_r($tree);
		echo "</pre>";
		if($tree && count($tree)>0) {
			foreach($tree as $dir) if($this->dir_exists($dir_name, $dir.'/')) return true;
		}
	}
	
	function createDirs($dir, $mode = 0644){
		try{
			$baseDir = array(basename($dir));
			$path = null;
			while (($d = dirname($dir))){
				if (!is_dir($d)){
					$baseDir[] = basename($d);
					$dir = $d;
				}else{
					$path = $d;
					break;
				}
			}
	
			if (($path = realpath($path)) === false) return false;
			
			$created = array();
			for ($n = count($baseDir) - 1; $n >= 0; $n-- ){
				$s = $path . '/'. $baseDir[$n];                                      
				if (!@mkdir($s, $mode)){
					for ($m = count($created) - 1; $m >= 0; $m--){ rmdir($created[$m]); }
					throw new CustomException($dir,12001);	
					return false;
				}
				$created[] = $s;
				$path = $s;
			}
		}catch (Exception $err){
			$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
			echo $msg->msgOutPut();
			return false;
		}
		return true;
	}

	function deleteDirs($dir){
		try{
			if($handle = @opendir("$dir")){
				while (false !== ($item = readdir($handle))){
					if ($item != "." && $item != ".."){
						if (is_dir("$dir/$item")){
							$this->deleteDirs("$dir/$item");
						}else{
							unlink("$dir/$item");
						}
					}
				}
				closedir($handle);
				rmdir($dir);
			}else{
				throw new CustomException($dir,12000);
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