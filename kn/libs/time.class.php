<?php
class cpsiTime
{

	private static $instance=null;

	public static function getInstance() {
		if (self::$instance==null) {
			self::$instance =& new cpsiTime();
		}
		return self::$instance;
	}

	function toSeconds($time)
	{
		$t = split(':',$time);
		$hour = isset($t[0])?$t[0]:0;
		$minutes = isset($t[1])?$t[1]:0;
		$seconds = isset($t[2])?$t[2]:0;
		return ($hour * (3600)) + ($minutes * 60) + ($seconds) ;
	}

	function toHMS($tsecond)
	{
		$hour = intval($tsecond /3600);
		$remain = ($tsecond%3600);
		$minutes = intval($remain/60);
		$seconds = $remain%60;
		return $hour.':'. str_pad($minutes,2,'0',STR_PAD_LEFT) .':' . str_pad($seconds,2,'0',STR_PAD_LEFT);
	}

	function toHM($tsecond)
	{
		$hour = intval($tsecond /(60*60));
		$remain = ($tsecond%(60*60));
		$minutes = intval($remain/60);
		return $hour.':'. str_pad($minutes,2,'0',STR_PAD_LEFT);
	}

	function toHour($tsecond)
	{
		$hour = intval($tsecond /(60*60));
		if(($tsecond%(60*60) >30)) $hour += 1;
		return $hour;
	}

}
?>