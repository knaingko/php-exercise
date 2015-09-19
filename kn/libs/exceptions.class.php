<?php
	class CustomException extends Exception
	{
	   // Redefine the exception so message isn't optional
	   public function __construct($message, $code = 0) {
		   // some code
		   switch ($code)
		   {

			case 90001: //Duplicate Message
				$message = 'Already exists in '. $message .'!';
				break;
			case 90002:
				$message = 'No records in '. $message . ' file !';
				break;
			case 90003:
				$message = 'Records ['. $message . '] not found in file !';
				break;
			case 10000: //assign upload function message start 11000 - 12000
				$message = 'File ('. $message .') upload fail! Please Try Again!';
				break;
			case 11000: //assign file system error message start 11000 - 12000
				$message = 'invalid file path!';
				break;
			case 11001:
				$message = 'File ( '. $message  .' ) not found!';
				break;
			case 11002:
				$message = "Invalid file type! <br/> Image file type must be ( $message ) !";
				break;
			case 11004:
				$message = 'File Size is Over! <br/> Maximun Size = (' . $message .')!';
				break;
			case 11010:
				$message = 'Cannot Copy File (' . $message .')!';
				break;
			case 11011:
				$message = 'Cannot Move File (' . $message .')!';
				break;
			case 11012:
				$message = 'Cannot Delete File (' . $message .')!';
				break;
			case 12000:// directory system error message assign
				$message = 'Directory [ '. $message .' ] not found!';
				break;
			case 12001:
				$message = 'Directory [ '. $message .' ] already exists!';
				break;
			case 12002:
				$message = 'Directory [ '. $message .' ] cannot delete!';
				break;
			case 15001: //session data error message
				$message = 'Session data not found!';
				break;
			case 20000: //user authentication message
				$message = 'User not found ! \n Please contact your system administrator!';
				break;
			case 20001:
				$message = 'Your logon name and password are incorrect!';
				break;
			case 20002:
				$message = 'Your user account is disabled! \n Please contact your system administrator!';
				break;
			case 20003:
				$message = "This user already logon ! \n ( or ) \n Your session is expired!";
				break;
			case 20004:
				$message = "Please complete the logon name and password!";
				break;
			case 20005:
				$message = "Your session is expired! \n Please Logon again!";
				break;
			case 30000: //user permission message
				$message = 'Please select program ! \n Please cannot run direct!';
				break;
			case 30001: //user permission message
				$message = 'Your have not access [' . $message .'] program ! \n Please contact your system administrator!';
				break;
			case 1054: //database error number standard
				$message = $message . '<br /> Please contact your WEB Administrator!';
				break;
			case 1451:
				$message = 'Cannot delete this data. <br /> This data is already use in another file!';
				break;
			case 1062:
				$message = 'This data is already exists file!';
				break;
			case 1064:
				$message = 'You have error in SQL syntax. <br /> Please contact your WEB Administrator!';
				break;
			case 2047:
				$message = $message;
				break;
			default:
				break;
		   }
		   // make sure everything is assigned properly
		   parent::__construct($message, $code);
	   }
	
	   // custom string representation of object
	   public function __toString() {
		   return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	   }
	}
?>
