<?php
require_once("session.class.php");
require_once("exceptions.class.php");

class cpsiAuthentication{
	private static $instance=null;

	public static function getInstance() {
		if (self::$instance==null) {
			self::$instance =& new cpsiAuthentication();
		}
		return self::$instance;
	}

	function authenticator(){
		$session = cpsiSession::getInstance();
		if(!$session->checkSession()){
			return false;
		}
		if(!$session->session_timeout()){
			$this->logoff_transaction();
			$session->sessionDestroy();
			return false;
		}
		return true;
	}

	function checkUserPermission (){
		try{
			
			if($_SESSION['user_data']['usertype'] != 'Administrator'){
				$dbexec = cpsidbexec::getInstance();
				$results = $dbexec->execBySQL("select * from permission_info 
														where program_name = '". basename($_SERVER['PHP_SELF']) ."' and 
																user_type = '". $_SESSION['user_data']['usertype'] ."' and 
																allow = 1 limit 1",true);
				if(count($results)<=0){
					throw new CustomException(basename($_SERVER['PHP_SELF']),30001);
				}
			}
		}catch (Exception $err){
//			$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
//			echo $msg->alertOutPut();
			return false;
		}
		return true;
	}

	function &checkUser ($logon=null, $pwd=null){
		try{
			//read from session data from Database objects
			$dbexec = cpsidbexec::getInstance();
			if (!$logon OR !$pwd){
				throw new CustomException('check blank',20004);
				exit();
			}else{
				$pwd = md5($pwd); // password encrypt
				$results = $dbexec->execBySQL("select * from user_info where logon_name = '$logon' and user_password = '$pwd'",true);
				if(count($results)<=0){
					throw new CustomException('logon name and password incorrect!',20001);
				}
				if($results[0]->enable==0){
					throw new CustomException('Your user account is disabled!',20002);
				}
				return $results;
			}
		}catch (Exception $err){
			$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
			echo $msg->alertOutPut();
			return null;
		}
	}

	function logon_transaction()
	{
		try{
			$toAdd = array(
							'sessionID'=>$_SESSION['user_data']['sessionid'],
							'logon_time'=>$_SESSION['user_data']['logontime'],
							'remote_location'=>$_SERVER['REMOTE_ADDR'],
							'user_name'=>$_SESSION['user_data']['username'], 
							'logon_date'=>date("Y-n-d"), 
							'user_type'=>$_SESSION['user_data']['usertype'],
							'squadron_code'=>$_SESSION['user_data']['squadron'],
							'user_agent'=>$_SERVER['HTTP_USER_AGENT']
							);
			$dbexec = cpsidbexec::getInstance();
			$dbexec->insertDataToDB('logon_transaction', $toAdd);
			return true;
		}catch(Exception $err){
			$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
			echo $msg->alertOutPut();
			return false;
		}
	}

	function logoff_transaction()
	{
		try{
			$toUpdate =  array('logoff_time'=>$logontime = date('h:i:s',time() + timezone));
			$toCheck =array('sessionID'=>$_SESSION['user_data']['sessionid']);
			$dbexec = cpsidbexec::getInstance();
			$dbexec->updateDataToDB('logon_transaction', $toUpdate, $toCheck);
			return true;
		}catch(Exception $err){
			$msg = new alert("Error : [ ".$err->getCode()." ] - ".$err->getMessage());
			echo $msg->alertOutPut();
			return false;
		}
	}
}
?>