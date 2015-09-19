<?
require_once("main.config.php");
class cpsiReport
{
	private static $instance=null;

	public static function getInstance () {
		if (self::$instance==null) {
			self::$instance =& new cpsiReport();
		}
		return self::$instance;
	}
	
	public function getReportData($reportName){
		switch($reportName){
		case "base_list":
			$title="Base List";
			$page = 'baseList.report.php';
			break;
		case "squadron_list":
			$where = " where ";
			$where .= "base_code like '" . $_POST['cboBase'] . "%' ";
			$where .= "and squadron_type_code like '" . $_POST['cboSquadronType'] ."%' ";
			
			$title = "Squadron List";
			$page = "squadronList.report.php";
			break;
		case "actype_list_detail":
			$where = " where ";
			$where .= "aircraft_type_code like '" . $_POST['cboACType'] . "%' ";
			$where .= "and squadron_type_code like '" . $_POST['cboSquadronType'] ."%' ";
			$where .= "and squadron_code like '" . $_POST['cboSquadron'] ."%' ";
			$where .= "and base_code like '" . $_POST['cboBase'] . "%' ";
			if(isset($_POST['chkser']) && !isset($_POST['chkunser'])){
				$where .= "and serviceable=1 ";
			}else if(!isset($_POST['chkser']) && isset($_POST['chkunser'])){
				$where .= "and serviceable=0 ";
			}
			$title = 'AirCraft Type List';
			$page = 'airCraftTypeListDetail.report.php';
			break;
		case "actype_list_summary":
			$where = " where ";
			$where .= "aircraft_type_code like '" . $_POST['cboACType'] . "%' ";
			$where .= "and squadron_type_code like '" . $_POST['cboSquadronType'] ."%' ";
			$where .= "and squadron_code like '" . $_POST['cboSquadron'] ."%' ";
			$where .= "and base_code like '" . $_POST['cboBase'] . "%' ";
			if(isset($_POST['chkser']) && !isset($_POST['chkunser'])){
				$where .= "and serviceable=1 ";
			}else if(!isset($_POST['chkser']) && isset($_POST['chkunser'])){
				$where .= "and serviceable=0 ";
			}
			$title = " AirCraft Type List";
			$page = 'airCraftTypeListSummary.report.php';
			break;
		case "dailyFlyingList":
			$where = " where ";
			$where .= "aircraft_base_code like '" . $_POST['cboBase'] . "%' ";
			$where .= "and aircraft_squadron_code like '" . $_POST['cboSquadron'] ."%' ";
			$where .= "and flying_type_code like '" . $_POST['cboFlyingType'] ."%' ";
			$where .= "and exercise_code like '" . $_POST['cboExercise'] ."%' ";
			$where .= "and year(flying_date) like '" . $_POST['cboYear'] ."%' ";	
			if ((int)$_POST['cboMonth']>0){
				$month = (int)$_POST['cboMonth'];
			}else{
				$month = "";
			}
			$where .= "and month(flying_date) like '" . $month ."%' ";
			$where .= "and Day(flying_date) like '" . $_POST['cboDay'] ."%' ";
			$where .= "and ( first_pilot_maf_no like '" . $_POST['cboMAFNo'] ."%' 
								  or second_pilot_maf_no like '" . $_POST['cboMAFNo'] ."%' 
								  or third_pilot_maf_no like '" . $_POST['cboMAFNo'] ."%')";
								  
			if(isset($_POST['chkday']) && !isset($_POST['chknight'])){
				$where .= "and night_status=0 ";
			}else if(!isset($_POST['chkday']) && isset($_POST['chknight'])){
				$where .= "and night_status=1 ";
			}

			$title = "Daily Flying List";
			$page = 'dailyFlyingList.report.php';
			break;
		case "acflyingByBaseAndACType":
			$title = "AirCraft Flying Hour By Base And AirCraft Type";
			$page = 'aircraftFlyingHourByACType.report.php';
			break;
		case "acFlyingByMonth":
			$where = " where ";
			$where .= " year(flying_date) = '" . $_POST['cboYear'] ."'";			
			$where .= " and base_code like '" . $_POST['cboBase'] . "%' ";
			$title = "AirCraft Flying Hour By Month [ ". $_POST['cboYear'] ." ] ";
			$page = 'aircraftFlyingHourByMonth.report.php';
			break;
		case "acFlyingBy1stFourMonth":
			$where = " where month(flying_date) < 5 ";
			$where .= " and year(flying_date) = '" . $_POST['cboYear'] ."'";			
			$where .= " and base_code like '" . $_POST['cboBase'] . "%' ";
			$title = "AirCraft Flying Hour By 1<sup>st</sup> Four Month [ ". $_POST['cboYear'] ." ] ";
			$page = 'aircraftFlyingHourBy1stFourMonth.report.php';
			break;
		case "acFlyingBy2ndFourMonth":
			$where = " where (month(flying_date) between  5 and 8 ) ";
			$where .= " and year(flying_date) = '" . $_POST['cboYear'] ."'";			
			$where .= " and base_code like '" . $_POST['cboBase'] . "%' ";
			$title = "AirCraft Flying Hour By 2<sup>nd</sup> Four Month [ ". $_POST['cboYear'] ." ] ";
			$page = 'aircraftFlyingHourBy2ndFourMonth.report.php';
			break;
		case "acFlyingBy3rdFourMonth":
			$where = " where (month(flying_date) between  9 and 12 ) ";
			$where .= " and year(flying_date) = '" . $_POST['cboYear'] ."'";			
			$where .= " and base_code like '" . $_POST['cboBase'] . "%' ";
			$title = "AirCraft Flying Hour By 3<sup>rd</sup> Four Month [ ". $_POST['cboYear'] ." ] ";
			$page = 'aircraftFlyingHourBy3rdFourMonth.report.php';
			break;
		case "acFlyingByQuarter":
			$where = " where ";
			$where .= " year(flying_date) = '" . $_POST['cboYear'] ."'";			
			$where .= " and base_code like '" . $_POST['cboBase'] . "%' ";
			$title = "AirCraft Flying Hour List Quarterly [ ". $_POST['cboYear'] ." ] ";
			$page = 'aircraftFlyingHourByQuarter.report.php';
			break;
		case "acFlyingByPlan":
			$where = " where ";
			$where .= "base_code like '" . $_POST['cboBase'] . "%' ";
			$where .= "and squadron_code like '" . $_POST['cboSquadron'] . "%' ";
			$where .= "and aircraft_type_code like '" . $_POST['cboACType'] ."%' ";
			$where .= "and flying_type_code like '" . $_POST['cboFlyingType'] ."%' ";
			$where .= "and year(concat(assign_month,'-01')) like '" . $_POST['cboYear'] . "%' ";
			$where .= "and month(concat(assign_month,'-01')) like '" . $_POST['cboMonth'] . "%' ";
			$title = "Plan Flying Hour";
			$page = 'planFlyingHour.report.php';
			break;
		case "fuelUsedByMonth":
			$where = " where ";
			$where .= "base_code like '" . $_POST['cboBase'] ."%' ";
			$where .= " and squadron_code like '" . $_POST['cboSquadron'] ."%' ";
			$where .= " and month(used_date) like '". $_POST['cboMonth'] ."%' ";
			$where .= " and year(used_date) = '". $_POST['cboYear'] ."' ";
			$title = "Fuel Used List [ ". $_POST['cboYear'] ." ]";
			$page = 'fuelUsedByMonth.report.php';
			break;
		case "fuelUsedByBase":
			$where = " where ";
			$where .= "base_code = '" . $_POST['cboBase'] ."' ";
			$where .= " and month(used_date) like '". $_POST['cboMonth'] ."%' ";
			$where .= " and year(used_date) = '". $_POST['cboYear'] ."' ";
//			$where .= " and date_format(used_date,'%m - %Y') = '". $_POST['cboMonth'] ."-" . $_POST['cboYear'] ."' ";
			$title = "Fuel Used By Base [ " . $_POST['cboBase'] ." - ". $_POST['cboYear'] ." ]";
			$page = 'fuelUsedByBase.report.php';
			break;
		case "weaponUseDetail":
			$where = " where ";
			$where .= "base_code like '" . $_POST['cboBase'] ."%' ";
			$where .= " and month(flying_date) like '". $_POST['cboMonth'] ."%' ";
			$where .= " and year(flying_date) like '". $_POST['cboYear'] ."%' ";
			$title = "Weapon Used List";
			$page = 'weaponUseDetail.report.php';
			break;
		case "weaponUseSummary":
			$where = "('". $_POST['cboMonth'] ."%','". $_POST['cboYear'] ."%','". $_POST['cboBase'] ."%')";
			$title = "Weapon Used Summary";
			$page = 'weaponUseSummary.report.php';
			break;
		case "transportDetail":
			$where = " where ";
			$where .= "base_code like '" . $_POST['cboBase'] ."%' ";
			$where .= " and month(flying_date) like '". $_POST['cboMonth'] ."%' ";
			$where .= " and year(flying_date) like '". $_POST['cboYear'] ."%' ";
			$title = "Transport List";
			$page = 'transportDetail.report.php';
			break;
		case "transportSummary":
			$where = " where ";
			$where .= "base_code like '" . $_POST['cboBase'] ."%' ";
			$where .= " and month(flying_date) like '". $_POST['cboMonth'] ."%' ";
			$where .= " and year(flying_date) like '". $_POST['cboYear'] ."%' ";
			$title = "Transport Summary";
			$page = 'transportSummary.report.php';
			break;
		case "pilotFlyingByMonth":
			$where = " where ";
			$where .= "aircraft_type_code like '" . $_POST['cboACType'] ."%' ";
			$where .= " and month(flying_date) = '". $_POST['cboMonth'] ."' ";
			$where .= " and year(flying_date) = '". $_POST['cboYear'] ."' ";
			$title = "Pilot Flying Hour List By Month [ ". $_POST['cboMonth'] ."-". $_POST['cboYear'] ." ]";
			$page = 'pilotFlyingHourListByMonth.report.php';
			break;
		case "pilotFlyingByACType":
			$where = " where ";
			$where .= "base_code like '" . $_POST['cboBase'] . "%' ";
			$where .= "and squadron_code like '" . $_POST['cboSquadron'] . "%' ";
			$where .= "and aircraft_type_code like '" . $_POST['cboACType'] ."%' ";
			$title = "Pilot Total Flying Hour List By A/C Type";
			$page = 'pilotTotalFlyingHourListByACType.report.php';
			break;
		case "crewList":
			$where = " where ";
			$where .= "base_code like '" . $_POST['cboBase'] . "%' ";
			$where .= "and squadron_code like '" . $_POST['cboSquadron'] . "%' ";
			$where .= "and crew_type_code like '" . $_POST['cboCrewType'] . "%' ";
			$where .= "and trade_code like '" . $_POST['cboTrade'] . "%' ";
			$where .= "and rank_code like '" . $_POST['cboRank'] . "%' ";
			$title = "Crew List";
			$page = 'crewList.report.php';
			break;
		case "crewListByBirthDate":
			$where = " where ";
			$where .= "base_code like '" . $_POST['cboBase'] . "%' ";
			$where .= "and squadron_code like '" . $_POST['cboSquadron'] . "%' ";
			$where .= "and year(date_of_birth) like '" . $_POST['cboYear'] . "%' ";
			$where .= "and month(date_of_birth) like '" . $_POST['cboMonth'] . "%' ";
			$title = "Crew List By Birth Date";
			$page = 'crewListByDOB.report.php';
			break;
		case "crewListByAbilityAward":
			$where = " where ";
			$where .= "ability_award_code like '" . $_POST['cboAbilityAward'] ."%' ";
			$title = "Crew List By Ability Award";
			$page = 'crewListByAbilityAward.report.php';
			break;
		case "crewListByCriminal":
			$where = " where ";
			$where .= "maf_no like '" . $_POST['cboMAFNo'] ."%' ";
			$where .= "and crime_code like '" . $_POST['cboCrime'] ."%' ";
			$title = "Crew List By Crime";
			$page = 'crewListByCrime.report.php';
			break;
		case "crewListByLeave":
			$where = " where ";
			$where .= "maf_no like '" . $_POST['cboMAFNo'] ."%' ";
			$where .= "and leave_type like '" . $_POST['cboLeaveType'] ."%' ";
			$title = "Crew List By Leave Type";
			$page = 'crewListByLeaveType.report.php';
			break;
		case "crewListByPromotion":
			$where = " where ";
			$where .= "maf_no like '" . $_POST['cboMAFNo'] ."%' ";
			$where .= "and assign_rank_code like '" . $_POST['cboRank'] ."%'";
			$title = "Crew List By Promotion";
			$page = 'crewListByPromotion.report.php';
			break;
		case "crewListByAttendedCourse":
			$where = " where ";
			$where .= "maf_no like '" . $_POST['cboMAFNo'] ."%' ";
			$where .= "and training_type_code like '" . $_POST['cboTrainingType'] ."%' ";
			$where .= "and course_code like '" . $_POST['cboCourse'] ."%'";
			$title = "Crew List By Attendence Course";
			$page = 'crewListByCourse.report.php';
			break;
		case "crewListByTransfer":
			$where = " where ";
			$where .= "maf_no like '" . $_POST['cboMAFNo'] ."%' ";
			$where .= "and transfer_post_code like '" . $_POST['cboPost'] ."%' ";
			$where .= "and transfer_squadron_code like '" . $_POST['cboSquadron'] ."%'";
			$where .= "and transfer_base_code like '" . $_POST['cboBase'] ."%'";
			$title = "Crew List By Transfer";
			$page = 'crewListByTransfer.report.php';
			break;
		case "crewListByDisease":
			$where = " where ";
			$where .= "maf_no like '" . $_POST['cboMAFNo'] ."%' ";
			$where .= "and disease_code like '" . $_POST['cboDisease'] ."%'";
			$title = "Crew List By Disease";
			$page = 'crewListByDisease.report.php';
			break;
		case "retireCrewList":
			$where = " where ";
			$where .= "year(retire_date) like '" . $_POST['cboYear'] . "%' ";
			$where .= "and month(retire_date) like '" . $_POST['cboMonth'] . "%' ";
			$title = "Retired Crew List";
			$page = 'retireCrewList.report.php';
			break;
		case "deadCrewList":
			$where = " where ";
			$where .= "year(dead_date) like '" . $_POST['cboYear'] . "%' ";
			$where .= "and month(dead_date) like '" . $_POST['cboMonth'] . "%' ";
			$title = "Dead Crew List";
			$page = 'deadCrewList.report.php';
			break;
		}
	
	}
}
?>