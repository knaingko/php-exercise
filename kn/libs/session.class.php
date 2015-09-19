<?php
require_once("main.config.php");
require_once("database_exec.class.php");
class cpsiSession
{
	private static $instance=null;
	
	var $logontime;
	var $sessionid;
	var $logonname;
	var $username;
	var $usertype;
	var $squadron;
						
	private function __construct(){
		ini_set('session.auto_start',session_auto_start);
		ini_set('session.gc_divisor',session_gc_divisor);
		ini_set('session.gc_maxlifetime',session_gc_maxlifetime);
		ini_set('session.use_trans_sid', session_use_trans_sid);
		ini_set('session.use_cookies', session_use_cookies);
		ini_set('session.use_only_cookies', session_use_only_cookies);

		session_name(md5(sitename.$_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']));
		session_start();
	}

	public static function getInstance () {
		if (self::$instance==null) {
			self::$instance =& new cpsiSession();
		}
		return self::$instance;
	}
	
	private function getCurrentSession(){
		if(!isset($_SESSION['user_data']['sessionid'])){
			return false;
		}else{
			$this->sessionid = $_SESSION['user_data']['sessionid'];
			$this->logontime = $_SESSION['user_data']['logontime'];
			$this->logonname = $_SESSION['user_data']['logonname'];
			$this->username = $_SESSION['user_data']['username'];
			$this->usertype = $_SESSION['user_data']['usertype'];
			$this->squadron = $_SESSION['user_data']['squadron'];
		}
		return true;
	}

	function checkSession(){
		try{
			if(!$this->getCurrentSession()){
				throw new CustomException('check session expired',20005);
			} // read from current session object $_SESSION
			
			$dbexec = cpsidbexec::getInstance();
			$result = $dbexec->execBySQL("select * from user_session where sessionID = '$this->sessionid' limit 1");
			if(count($result) <= 0){
				throw new CustomException('check hijacking from another location and same user name',20003);
			}
			return true;
		}
		catch (Exception $err)
		{
			return false;
		}
	}

	function getNewSession($objData){
		try{
			$logontime = date('his',time() + timezone);
			$sessionid = md5($objData[0]->logon_name.$objData[0]->user_type.$logontime);

			$this->session_id_generate($sessionid);

			$_SESSION['user_data'] = array("sessionid"=>$sessionid, 
													 "logontime"=>$logontime,
													 "logonname"=>$objData[0]->logon_name,
													 "username"=>$objData[0]->user_name,
													 "usertype"=>$objData[0]->user_type,
													 "squadron"=>$objData[0]->squadron_code);
			$_SESSION['report_data'] = array();
			
/*			$_SESSION['sessionid'] = $sessionid;
			$_SESSION['logontime'] = $logontime;
			$_SESSION['logonname'] = $objData[0]->logon_name;
			$_SESSION['username'] =  $objData[0]->user_name;
			$_SESSION['usertype'] =  $objData[0]->user_type;
			$_SESSION['squadron'] =  $objData[0]->squadron_code;
*/			
	
			require_once("database_exec.class.php");
			$dbexec = cpsidbexec::getInstance();
			$toAdd = array('sessionID'=>$sessionid, 
							'logon_time'=>$logontime,
							'user_type'=>$objData[0]->user_type,
							'logon_name'=>$objData[0]->logon_name,
							'user_name'=>$objData[0]->user_name,
							'squadron_code'=>$objData[0]->squadron_code,
							'remote_address'=>$_SERVER['REMOTE_ADDR'],
							'user_agent'=>$_SERVER['HTTP_USER_AGENT']);
			$dbexec = cpsidbexec::getInstance();
			$dbexec->insertDataToDB('user_session', $toAdd);
			return true;
		}catch(Exception $err){
			return false;
		}
	}

	function sessionDestroy()
	{
		$this->getCurrentSession(); // read from current session object $_SESSION
		$dbexec = cpsidbexec::getInstance();
		$dbexec->execBySQL("delete from user_session where sessionid = '$this->sessionid'",false);
		@session_unset();
		@session_destroy();
	}
	
	function session_timeout(){
		try{
			$filepath = ini_get('session.save_path').'/sess_'.session_id();
			if(file_exists($filepath)) 
			{
				$filetime = filemtime ($filepath);
				$timediff = mktime() - $filetime;
				if($timediff>=session_time_out){
					throw new CustomException('check hijacking from another location and same user name',20003);
				}
			}else{
				throw new CustomException('check hijacking from another location and same user name',20003);
			}
			return true;
		}catch (Exception $err){
			return false;
		}
	}
	
	private function session_id_generate($sessionid){
		$old_sessid = session_id();
		session_regenerate_id(true);
		session_id($old_sessid);
		session_unset();
		session_destroy();
		session_id($sessionid);
		session_start();
	}

	function session_force_destroy($sessionid){
		$filepath = ini_get('session.save_path').'/sess_'.$sessionid;
		if(file_exists($filepath)) 
		{
			require_once("filesystem.class.php");
			$file = cpsiFileSystem::getInstance();
			$file->deleteFile($filepath);
		}
		$dbexec = cpsidbexec::getInstance();
		$dbexec->execBySQL("delete from user_session where sessionid = '$sessionid'",false);
	}

}
?>