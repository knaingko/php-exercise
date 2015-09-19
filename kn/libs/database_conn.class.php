<?php

	require_once "exceptions.class.php";
	class cpsiConnection{
		private $DBServer = "localhost";
		private $DBPort = "3306";
		private $DBUser = "root";
		private $DBPassword = "sa";
		private $DBName= "maf";
		
		private $mysqli = null;
		private static $instance=null;
	
		public static function getInstance() {
			if (self::$instance==null) {
				self::$instance =& new cpsiConnection();
			}
			return self::$instance;
		}

		function open_connection(&$mysqli = null)
		{
			$mysqli= @new mysqli($this->DBServer,$this->DBUser,$this->DBPassword,$this->DBName);
			if (mysqli_connect_errno()!=0)
			{
				throw new CustomException(mysqli_connect_error(), mysqli_connect_errno());
			}
		}

	}
?>