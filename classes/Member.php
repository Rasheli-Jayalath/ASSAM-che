<?php
/**
*
* This is a class Member
* @version 0.01
* @author Raju Gautam <raju@devraju.com>
* @Date 10 Aug, 2007
* @modified 10 Aug, 2007 by Raju Gautam
*
**/
class Member extends Database{
	public $member_login;
	public $member_cd;
	public $member_name;
	public $fullname_name;
	public $first_name;
	public $member_login_time;
	public $member_type;

	/*
	* This is the constructor of the class Member
	* @author Raju Gautam <raju@devraju.com>
	* @Date 10 Aug, 2007
	* @modified 10 Aug, 2007 by Raju Gautam
	*/
	public function __construct(){
		parent::__construct();
		if($_SESSION['member_login']){
			$this->member_login 	= $_SESSION['member_login'];
			$this->member_cd 		= $_SESSION['member_cd'];
			$this->member_username 	= $_SESSION['member_username'];
			$this->member_fullname 	= $_SESSION['member_fullname'];
			$this->member_login_time= $_SESSION['member_login_time'];
			$this->first_name		= $_SESSION['first_name']; 
		}
	}

	/*
	* This is the function to set the member logged in
	* @author Raju Gautam
	* @Date 13 Dec, 2007
	* @modified 13 Dec, 2007 by Raju Gautam
	*/
	public function setLogin(){
		$_SESSION['member_login'] 	= true;
		
		# Logged in member's member code
		if($this->isPropertySet("member_cd", "V"))
			$_SESSION['member_cd'] 		= $this->getProperty("member_cd");
		
		# Logged in member's username
		if($this->isPropertySet("member_username", "V"))
			$_SESSION['member_username'] = $this->getProperty("member_username");
		
		# Logged in member's logged in time
		if($this->isPropertySet("member_login_time", "V"))
			$_SESSION['member_login_time'] 	= $this->getProperty("member_login_time");
		
		# Logged in member's fullname
		if($this->isPropertySet("member_fullname", "V"))
			$_SESSION['member_fullname'] = $this->getProperty("member_fullname");
		
		# Logged in member's first name
		if($this->isPropertySet("first_name", "V"))
			$_SESSION['first_name'] = $this->getProperty("first_name");
	}
	
	/*
	* This function is used to check the member login
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function formatHeight($height){
		if($height != ""){
			list($ft,$inch) = split("-", $height);	
			return $ft . " Ft. " . $inch . " In.";
		}
		return NULL;
	}
	
	/*
	* This function is used to check whether the member has been logged in or not.
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function checkLogin(){
		if($this->member_login){
			return true;
		}
		else{
			return false;
		}
	}
	
	/*
	* This function is used to check the member login
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function checkMemberLogin(){
		$Sql = "SELECT 
					member_cd,
					username,
					passwd,
					email,
					first_name,
					middle_name,
					last_name,
					(SELECT CASE WHEN TRIM(middle_name) IS NOT NULL THEN CONCAT(first_name,' ', middle_name,' ',last_name) ELSE CONCAT(first_name,' ',last_name) END) AS fullname,
					member_status
				FROM
					rs_tbl_members
				WHERE 
					1=1";
		if($this->isPropertySet("email", "V"))
			$Sql .= " AND email='" . $this->getProperty("email") . "'";
		if($this->isPropertySet("username", "V"))
			$Sql .= " AND username='" . $this->getProperty("username") . "'";
		if($this->isPropertySet("passwd", "V"))
			$Sql .= " AND passwd='" . $this->getProperty("passwd") . "'";
		
		return $this->dbQuery($Sql);
	}

	/*
	* This function is used to check the member login
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function memberActivate(){
		$Sql = "UPDATE rs_tbl_members SET
					member_status=1
				WHERE 
					1=1";
		if($this->isPropertySet("confirmation_cd", "V"))
			$Sql .= " AND confirmation_cd='" . $this->getProperty("confirmation_cd") . "'";
		
		return $this->dbQuery($Sql);
	}
		
	/*
	* This function is used to list the users
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function lstMember(){
		$Sql = "SELECT 
					member_cd,
					username,
					passwd,
					email,
					first_name,
					middle_name,
					last_name,
					(SELECT CASE WHEN TRIM(middle_name) IS NOT NULL THEN CONCAT(first_name,' ', middle_name,' ',last_name) ELSE CONCAT(first_name,' ',last_name) END) AS fullname,
					sex,
					marrital_status,
					birth_date,
					body_type,
					hair_color,
					eye_color,
					height,
					address,
					city,
					hometown,
					country,
					(SELECT country_name FROM rs_tbl_countries WHERE country_id=a.country) as country_name,
					CONCAT(address,' ', city) as full_address,
					phone,
					mobile,
					time_zone,
					(SELECT timezone_name FROM rs_tbl_timezone WHERE timezone_cd=a.time_zone) as timezone_name,
					drinker,
					smoker,
					about,
					like_to_meet,
					join_date,
					member_status,
					confirmation_cd,
					profile_view
				FROM
					rs_tbl_members as a
				WHERE 
					1=1";
		if($this->isPropertySet("member_cd", "V"))
			$Sql .= " AND member_cd=" . $this->getProperty("member_cd");
		if($this->isPropertySet("email", "V"))
			$Sql .= " AND email='" . $this->getProperty("email") . "'";
		if($this->isPropertySet("username", "V"))
			$Sql .= " AND username='" . $this->getProperty("username") . "'";
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		$this->dbQuery($Sql);
	}
	
	/*
	* This function is used to perform DML (Delete/Update/Add)
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function actMember($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_members(
						member_cd,
						username,
						passwd,
						email,
						first_name,
						middle_name,
						last_name,
						sex,
						marrital_status,
						birth_date,
						body_type,
						hair_color,
						eye_color,
						height,
						address,
						city,
						hometown,
						country,
						phone,
						mobile,
						time_zone,
						drinker,
						smoker,
						about,
						like_to_meet,
						join_date,
						member_status,
						confirmation_cd) 
						VALUES(";
				$Sql .= $this->isPropertySet("member_cd", "V") ? $this->getProperty("member_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("username", "V") ? "'" . $this->getProperty("username") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("passwd", "V") ? "'" . $this->getProperty("passwd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("email", "V") ? "'" . $this->getProperty("email") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("first_name", "V") ? "'" . $this->getProperty("first_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("middle_name", "V") ? "'" . $this->getProperty("middle_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("last_name", "V") ? "'" . $this->getProperty("last_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("sex", "V") ? "'" . $this->getProperty("sex") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("marrital_status", "V") ? "'" . $this->getProperty("marrital_status") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("birth_date", "V") ? "'" . $this->getProperty("birth_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("body_type", "V") ? "'" . $this->getProperty("body_type") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("hair_color", "V") ? "'" . $this->getProperty("hair_color") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("eye_color", "V") ? "'" . $this->getProperty("eye_color") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("height", "V") ? "'" . $this->getProperty("height") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("address", "V") ? $this->getProperty("address") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("city", "V") ? "'" . $this->getProperty("city") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("hometown", "V") ? "'" . $this->getProperty("hometown") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("country", "V") ? "'" . $this->getProperty("country") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("phone", "V") ? "'" . $this->getProperty("phone") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("mobile", "V") ? "'" . $this->getProperty("mobile") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("time_zone", "V") ? "'" . $this->getProperty("time_zone") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("drinker", "V") ? "'" . $this->getProperty("drinker") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("smoker", "V") ? "'" . $this->getProperty("smoker") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("about", "V") ? "'" . $this->getProperty("about") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("like_to_meet", "V") ? "'" . $this->getProperty("like_to_meet") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("join_date", "V") ? "'" . $this->getProperty("join_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("member_status", "V") ? $this->getProperty("member_status") : "1";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("confirmation_cd", "V") ? "'" . $this->getProperty("confirmation_cd") . "'" : "NULL";

				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_members SET ";
				if($this->isPropertySet("first_name", "K")){
					$Sql .= "$con first_name='" . $this->getProperty("first_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("middle_name", "K")){
					$Sql .= "$con middle_name='" . $this->getProperty("middle_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("last_name", "K")){
					$Sql .= "$con last_name='" . $this->getProperty("last_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("sex", "K")){
					$Sql .= "$con sex='" . $this->getProperty("sex") . "'";
					$con = ",";
				}
				if($this->isPropertySet("marrital_status", "K")){
					$Sql .= "$con marrital_status='" . $this->getProperty("marrital_status") . "'";
					$con = ",";
				}
				if($this->isPropertySet("birth_date", "K")){
					$Sql .= "$con birth_date='" . $this->getProperty("birth_date") . "'";
					$con = ",";
				}
				if($this->isPropertySet("body_type", "K")){
					$Sql .= "$con body_type='" . $this->getProperty("body_type") . "'";
					$con = ",";
				}
				if($this->isPropertySet("hair_color", "K")){
					$Sql .= "$con hair_color='" . $this->getProperty("hair_color") . "'";
					$con = ",";
				}
				if($this->isPropertySet("eye_color", "K")){
					$Sql .= "$con eye_color='" . $this->getProperty("eye_color") . "'";
					$con = ",";
				}
				if($this->isPropertySet("height", "K")){
					$Sql .= "$con height='" . $this->getProperty("height") . "'";
					$con = ",";
				}
				if($this->isPropertySet("address", "K")){
					$Sql .= "$con address='" . $this->getProperty("address") . "'";
					$con = ",";
				}
				if($this->isPropertySet("city", "K")){
					$Sql .= "$con city='" . $this->getProperty("city") . "'";
					$con = ",";
				}
				if($this->isPropertySet("hometown", "K")){
					$Sql .= "$con hometown='" . $this->getProperty("hometown") . "'";
					$con = ",";
				}
				if($this->isPropertySet("country", "K")){
					$Sql .= "$con country=" . $this->getProperty("country");
					$con = ",";
				}
				if($this->isPropertySet("phone", "K")){
					$Sql .= "$con phone='" . $this->getProperty("phone") . "'";
					$con = ",";
				}
				if($this->isPropertySet("mobile", "K")){
					$Sql .= "$con mobile='" . $this->getProperty("mobile") . "'";
					$con = ",";
				}
				if($this->isPropertySet("time_zone", "K")){
					$Sql .= "$con time_zone='" . $this->getProperty("time_zone") . "'";
					$con = ",";
				}
				if($this->isPropertySet("drinker", "K")){
					$Sql .= "$con drinker='" . $this->getProperty("drinker") . "'";
					$con = ",";
				}
				if($this->isPropertySet("smoker", "K")){
					$Sql .= "$con smoker='" . $this->getProperty("smoker") . "'";
					$con = ",";
				}
				if($this->isPropertySet("about", "K")){
					$Sql .= "$con about='" . $this->getProperty("about") . "'";
					$con = ",";
				}
				if($this->isPropertySet("like_to_meet", "K")){
					$Sql .= "$con like_to_meet='" . $this->getProperty("like_to_meet") . "'";
					$con = ",";
				}
				if($this->isPropertySet("member_status", "K")){
					$Sql .= "$con member_status=" . $this->getProperty("member_status");
					$con = ",";
				}
				if($this->isPropertySet("passwod_cd", "K")){
					$Sql .= "$con passwod_cd='" . $this->getProperty("passwod_cd") . "'";
					$con = ",";
				}
				if($this->isPropertySet("profile_view", "K")){
					$Sql .= "$con profile_view=" . $this->getProperty("profile_view");
					$con = ",";
				}

				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("email_pwd", "V"))
					$Sql .= " AND email='" . $this->getProperty("email_pwd") . "'";
				else
					$Sql .= " AND member_cd=" . $this->getProperty("member_cd");
				break;
			case "D":
				$Sql = "UPDATE rs_tbl_members SET 
							member_status=0
						WHERE
							1=1";
				$Sql .= " AND member_cd=" . $this->getProperty("member_cd");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}

	/*
	* This function is used to list the user's education
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function lstEducation(){
		$Sql = "SELECT 
					a.education_cd,
					a.member_cd,
					a.institution_name,
					a.institution_address,
					a.course_name,
					a.year_start,
					a.major_subjects,
					a.duration
				FROM
					rs_tbl_education a
					INNER JOIN rs_tbl_members b ON a.member_cd=b.member_cd
				WHERE 
					1=1";
		if($this->isPropertySet("member_cd", "V"))
			$Sql .= " AND a.member_cd=" . $this->getProperty("member_cd");
		
		if($this->isPropertySet("education_cd", "V"))
			$Sql .= " AND a.education_cd=" . $this->getProperty("education_cd");

		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	/*
	* This function is used to perform DML (Delete/Update/Add) on user's education table
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function actEducation($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_education(
						education_cd,
						member_cd,
						institution_name,
						institution_address,
						course_name,
						year_start,
						major_subjects,
						duration) 
						VALUES(";
				$Sql .= $this->isPropertySet("education_cd", "V") ? $this->getProperty("education_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("member_cd", "V") ? $this->getProperty("member_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("institution_name", "V") ? "'" . $this->getProperty("institution_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("institution_address", "V") ? "'" . $this->getProperty("institution_address") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("course_name", "V") ? "'" . $this->getProperty("course_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("year_start", "V") ? "'" . $this->getProperty("year_start") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("major_subjects", "V") ? "'" . $this->getProperty("major_subjects") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("duration", "V") ? "'" . $this->getProperty("duration") . "'" : "NULL";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_education SET ";
				if($this->isPropertySet("institution_name", "K")){
					$Sql .= "$con institution_name='" . $this->getProperty("institution_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("institution_address", "K")){
					$Sql .= "$con institution_address='" . $this->getProperty("institution_address") . "'";
					$con = ",";
				}
				if($this->isPropertySet("course_name", "K")){
					$Sql .= "$con course_name='" . $this->getProperty("course_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("year_start", "K")){
					$Sql .= "$con year_start='" . $this->getProperty("year_start") . "'";
					$con = ",";
				}
				if($this->isPropertySet("major_subjects", "K")){
					$Sql .= "$con major_subjects='" . $this->getProperty("major_subjects") . "'";
					$con = ",";
				}
				if($this->isPropertySet("duration", "K")){
					$Sql .= "$con duration='" . $this->getProperty("duration") . "'";
					$con = ",";
				}

				$Sql .= " WHERE 1=1";
				$Sql .= " AND education_cd=" . $this->getProperty("education_cd");
				
				if($this->isPropertySet("member_cd", "K"))
					$Sql .= " AND member_cd=" . $this->getProperty("member_cd");

				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_education 
						WHERE
							1=1";
				
				if($this->isPropertySet("education_cd", "K"))
					$Sql .= " AND education_cd=" . $this->getProperty("education_cd");
				
				if($this->isPropertySet("member_cd", "K"))
					$Sql .= " AND member_cd=" . $this->getProperty("member_cd");

				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}

	/*
	* This function is used to list the user's work
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function lstWork(){
		$Sql = "SELECT 
					a.work_cd,
					a.member_cd,
					a.company_name,
					a.position,
					a.work_start,
					a.work_duration,
					a.contact_person,
					a.company_email,
					a.address,
					a.website
				FROM
					rs_tbl_work a
					INNER JOIN rs_tbl_members b ON a.member_cd=b.member_cd
				WHERE 
					1=1";
		if($this->isPropertySet("member_cd", "V"))
			$Sql .= " AND a.member_cd=" . $this->getProperty("member_cd");
		if($this->isPropertySet("work_cd", "V"))
			$Sql .= " AND a.work_cd=" . $this->getProperty("work_cd");

		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		$this->dbQuery($Sql);
	}
	
	/*
	* This function is used to perform DML (Delete/Update/Add) on user's work table
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function actWork($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_work(
							work_cd,
							member_cd,
							company_name,
							position,
							work_start,
							work_duration,
							contact_person,
							company_email,
							address,
							website
						) VALUES(";
				$Sql .= $this->isPropertySet("work_cd", "V") ? $this->getProperty("work_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("member_cd", "V") ? $this->getProperty("member_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("company_name", "V") ? "'" . $this->getProperty("company_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("position", "V") ? "'" . $this->getProperty("position") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("work_start", "V") ? "'" . $this->getProperty("work_start") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("work_duration", "V") ? "'" . $this->getProperty("work_duration") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("contact_person", "V") ? "'" . $this->getProperty("contact_person") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("company_email", "V") ? "'" . $this->getProperty("company_email") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("address", "V") ? "'" . $this->getProperty("address") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("website", "V") ? "'" . $this->getProperty("website") . "'" : "NULL";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_work SET ";
				if($this->isPropertySet("company_name", "K")){
					$Sql .= "$con company_name='" . $this->getProperty("company_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("position", "K")){
					$Sql .= "$con position='" . $this->getProperty("position") . "'";
					$con = ",";
				}
				if($this->isPropertySet("work_start", "K")){
					$Sql .= "$con work_start='" . $this->getProperty("work_start") . "'";
					$con = ",";
				}
				if($this->isPropertySet("work_duration", "K")){
					$Sql .= "$con work_duration='" . $this->getProperty("work_duration") . "'";
					$con = ",";
				}
				if($this->isPropertySet("contact_person", "K")){
					$Sql .= "$con contact_person='" . $this->getProperty("contact_person") . "'";
					$con = ",";
				}
				if($this->isPropertySet("company_email", "K")){
					$Sql .= "$con company_email='" . $this->getProperty("company_email") . "'";
					$con = ",";
				}
				if($this->isPropertySet("address", "K")){
					$Sql .= "$con address='" . $this->getProperty("address") . "'";
					$con = ",";
				}
				if($this->isPropertySet("website", "K")){
					$Sql .= "$con website='" . $this->getProperty("website") . "'";
					$con = ",";
				}

				$Sql .= " WHERE 1=1";
				$Sql .= " AND work_cd=" . $this->getProperty("work_cd");
				
				if($this->isPropertySet("member_cd", "K"))
					$Sql .= " AND member_cd=" . $this->getProperty("member_cd");

				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_work 
						WHERE
							1=1";

				if($this->isPropertySet("work_cd", "K"))
					$Sql .= " AND work_cd=" . $this->getProperty("work_cd");
				
				if($this->isPropertySet("member_cd", "K"))
					$Sql .= " AND member_cd=" . $this->getProperty("member_cd");

				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}

	/*
	* This function is used to list the user's Background
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function lstBackground(){
		$Sql = "SELECT 
					a.background_cd,
					a.member_cd,
					a.ethnicity,
					a.lang,
					a.income,
					a.education
				FROM
					rs_tbl_background a
					INNER JOIN rs_tbl_members b ON a.member_cd=b.member_cd
				WHERE 
					1=1";
		if($this->isPropertySet("member_cd", "V"))
			$Sql .= " AND a.member_cd=" . $this->getProperty("member_cd");
		if($this->isPropertySet("background_cd", "V"))
			$Sql .= " AND a.background_cd=" . $this->getProperty("background_cd");

		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		$this->dbQuery($Sql);
	}
	
	/*
	* This function is used to perform DML (Delete/Update/Add) on user's Background table
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function actBackground($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_background(
							background_cd,
							member_cd,
							ethnicity,
							lang,
							income,
							education
						) VALUES(";
				$Sql .= $this->isPropertySet("background_cd", "V") ? $this->getProperty("background_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("member_cd", "V") ? $this->getProperty("member_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("ethnicity", "V") ? "'" . $this->getProperty("ethnicity") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("lang", "V") ? "'" . $this->getProperty("lang") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("income", "V") ? "'" . $this->getProperty("income") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("education", "V") ? "'" . $this->getProperty("education") . "'" : "NULL";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_background SET ";
				if($this->isPropertySet("ethnicity", "K")){
					$Sql .= "$con ethnicity='" . $this->getProperty("ethnicity") . "'";
					$con = ",";
				}
				if($this->isPropertySet("lang", "K")){
					$Sql .= "$con lang='" . $this->getProperty("lang") . "'";
					$con = ",";
				}
				if($this->isPropertySet("income", "K")){
					$Sql .= "$con income='" . $this->getProperty("income") . "'";
					$con = ",";
				}
				if($this->isPropertySet("education", "K")){
					$Sql .= "$con education='" . $this->getProperty("education") . "'";
					$con = ",";
				}

				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("background_cd", "K"))
					$Sql .= " AND background_cd=" . $this->getProperty("background_cd");
				
				if($this->isPropertySet("member_cd", "K"))
					$Sql .= " AND member_cd=" . $this->getProperty("member_cd");

				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_background 
						WHERE
							1=1";

				if($this->isPropertySet("background_cd", "K"))
					$Sql .= " AND background_cd=" . $this->getProperty("background_cd");
				
				if($this->isPropertySet("member_cd", "K"))
					$Sql .= " AND member_cd=" . $this->getProperty("member_cd");

				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}

	/*
	* This function is used to list the user's interest
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function lstInterest(){
		$Sql = "SELECT 
					a.interest_cd,
					a.member_cd,
					a.fav_music,
					a.fav_book,
					a.fav_movie,
					a.fav_quote,
					a.fav_tv_show,
					a.fav_actor,
					a.fav_game,
					a.i_like,
					a.i_dislike
				FROM
					rs_tbl_interest a
					INNER JOIN rs_tbl_members b ON a.member_cd=b.member_cd
				WHERE 
					1=1";
		if($this->isPropertySet("member_cd", "V"))
			$Sql .= " AND a.member_cd=" . $this->getProperty("member_cd");
		if($this->isPropertySet("interest_cd", "V"))
			$Sql .= " AND a.interest_cd=" . $this->getProperty("interest_cd");

		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		$this->dbQuery($Sql);
	}
	
	/*
	* This function is used to perform DML (Delete/Update/Add) on user's Interest table
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function actInterest($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_interest(
							interest_cd,
							member_cd,
							fav_music,
							fav_book,
							fav_movie,
							fav_quote,
							fav_tv_show,
							fav_actor,
							fav_game,
							i_like,
							i_dislike
						) VALUES(";
				$Sql .= $this->isPropertySet("interest_cd", "V") ? $this->getProperty("interest_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("member_cd", "V") ? $this->getProperty("member_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("fav_music", "V") ? "'" . $this->getProperty("fav_music") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("fav_book", "V") ? "'" . $this->getProperty("fav_book") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("fav_movie", "V") ? "'" . $this->getProperty("fav_movie") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("fav_quote", "V") ? "'" . $this->getProperty("fav_quote") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("fav_tv_show", "V") ? "'" . $this->getProperty("fav_tv_show") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("fav_actor", "V") ? "'" . $this->getProperty("fav_actor") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("fav_game", "V") ? "'" . $this->getProperty("fav_game") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("i_like", "V") ? "'" . $this->getProperty("i_like") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("i_dislike", "V") ? "'" . $this->getProperty("i_dislike") . "'" : "NULL";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_interest SET ";
				if($this->isPropertySet("fav_music", "K")){
					$Sql .= "$con fav_music='" . $this->getProperty("fav_music") . "'";
					$con = ",";
				}
				if($this->isPropertySet("fav_book", "K")){
					$Sql .= "$con fav_book='" . $this->getProperty("fav_book") . "'";
					$con = ",";
				}
				if($this->isPropertySet("fav_movie", "K")){
					$Sql .= "$con fav_movie='" . $this->getProperty("fav_movie") . "'";
					$con = ",";
				}
				if($this->isPropertySet("fav_quote", "K")){
					$Sql .= "$con fav_quote='" . $this->getProperty("fav_quote") . "'";
					$con = ",";
				}
				if($this->isPropertySet("fav_tv_show", "K")){
					$Sql .= "$con fav_tv_show='" . $this->getProperty("fav_tv_show") . "'";
					$con = ",";
				}
				if($this->isPropertySet("fav_actor", "K")){
					$Sql .= "$con fav_actor='" . $this->getProperty("fav_actor") . "'";
					$con = ",";
				}
				if($this->isPropertySet("fav_game", "K")){
					$Sql .= "$con fav_game='" . $this->getProperty("fav_game") . "'";
					$con = ",";
				}
				if($this->isPropertySet("i_like", "K")){
					$Sql .= "$con i_like='" . $this->getProperty("i_like") . "'";
					$con = ",";
				}
				if($this->isPropertySet("i_dislike", "K")){
					$Sql .= "$con i_dislike='" . $this->getProperty("i_dislike") . "'";
					$con = ",";
				}

				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("interest_cd", "K"))
					$Sql .= " AND interest_cd=" . $this->getProperty("interest_cd");
				
				if($this->isPropertySet("member_cd", "K"))
					$Sql .= " AND member_cd=" . $this->getProperty("member_cd");

				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_interest 
						WHERE
							1=1";

				if($this->isPropertySet("interest_cd", "K"))
					$Sql .= " AND interest_cd=" . $this->getProperty("interest_cd");
				
				if($this->isPropertySet("member_cd", "K"))
					$Sql .= " AND member_cd=" . $this->getProperty("member_cd");

				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}

	/*
	* This function is used to list the user's profile comments
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function lstComments(){
		$Sql = "SELECT 
					a.member_cd,
					a.first_name,
					a.last_name,
					a.sex,
					(SELECT 
						c.photo_name 
					FROM 
						rs_tbl_album d
						INNER JOIN rs_tbl_photos c ON b.album_cd=b.album_cd
					WHERE
						d.member_cd=b.commenter_member_cd
						AND d.is_primary='Y'
						AND d.cover_photo_cd=c.photo_cd) AS photo_name
				FROM
					rs_tbl_profile_comments b
					INNER JOIN rs_tbl_members a ON b.prf_member_cd=a.member_cd
				WHERE 
					1=1";
		if($this->isPropertySet("member_cd", "V"))
			$Sql .= " AND a.prf_member_cd=" . $this->getProperty("member_cd");

		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}


	/*
	* This function is used to check the email address already exists or not.
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function emailExists(){
		$Sql = "SELECT 
					email,
					first_name
				FROM
					rs_tbl_members
				WHERE 
					1=1";
		if($this->isPropertySet("email", "V"))
			$Sql .= " AND email='" . $this->getProperty("email") . "'";
		if($this->isPropertySet("member_cd", "V"))
			$Sql .= " AND member_cd!=" . $this->getProperty("member_cd");
		return $this->dbQuery($Sql);
	}
	
	/*
	* This function is used to change the password
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function changePassword(){
		$Sql = "UPDATE rs_tbl_members SET
					passwd='" . $this->getProperty("passwd") . "' 
				WHERE 
					1=1";
		
		if($this->isPropertySet("passwod_cd", "V"))
			$Sql .= " AND passwod_cd='" . $this->getProperty("passwod_cd") . "'";
		else{
			$Sql .= " AND email='" . $this->getProperty("email") . "'";
			$Sql .= " AND member_cd='" . $this->getProperty("member_cd") . "'";
		}	

		return $this->dbQuery($Sql);
	}
	
	/*
	* This function is used to list the user's interest
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function lstFriend(){
		$Sql = "SELECT
					a.friend_cd,
					a.member_cd,
					a.member_friend_cd,
					(SELECT CASE WHEN TRIM(middle_name) IS NOT NULL THEN CONCAT(first_name,' ', middle_name,' ',last_name) ELSE CONCAT(first_name,' ',last_name) END AS fullname FROM rs_tbl_members WHERE member_cd=a.member_friend_cd) AS friend_name,
					a.inviter_cd,
					a.invitetype,
					a.invite_date,
					a.invite_status,
					CASE WHEN a.invite_status=1 THEN 'Accepted' WHEN a.invite_status=2 THEN 'Rejected' ELSE 'Pending' END as invite_status_str,
					a.accepted_date,
					a.is_top
					(SELECT 
						c.photo_name 
					FROM 
						rs_tbl_album d
						INNER JOIN rs_tbl_photos c ON b.album_cd=b.album_cd
					WHERE
						d.member_cd=a.member_friend_cd
						AND d.is_primary='Y'
						AND d.cover_photo_cd=c.photo_cd) AS photo_name
				FROM
					rs_tbl_friends a
					INNER JOIN rs_tbl_members b ON a.member_cd=b.member_cd";
		
		if($this->isPropertySet("member_cd", "V"))
			$Sql .= " AND a.member_cd=" . $this->getProperty("member_cd");

		if($this->isPropertySet("inviter_cd", "V"))
			$Sql .= " AND a.inviter_cd=" . $this->getProperty("inviter_cd");
		
		if($this->isPropertySet("is_top", "V"))
			$Sql .= " AND a.is_top=" . $this->getProperty("is_top");

		if($this->isPropertySet("invite_status", "V"))
			$Sql .= " AND a.invite_status=" . $this->getProperty("invite_status");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}

	/*
	* This function is used to perform DML (Delete/Update/Add) on member's friend
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function actFriend($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_friends(
							friend_cd,
							member_cd,
							member_friend_cd,
							inviter_cd,
							invitetype,
							invite_date,
							invite_status,
							accepted_date,
							is_top
						) VALUES(";
				$Sql .= $this->isPropertySet("friend_cd", "V") ? $this->getProperty("friend_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("member_cd", "V") ? $this->getProperty("member_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("member_friend_cd", "V") ? $this->getProperty("member_friend_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("inviter_cd", "V") ? $this->getProperty("inviter_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("invitetype", "V") ? "'" . $this->getProperty("invitetype") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("invite_date", "V") ? "'" . $this->getProperty("invite_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("invite_status", "V") ? $this->getProperty("invite_status") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("accepted_date", "V") ? "'" . $this->getProperty("accepted_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("is_top", "V") ? $this->getProperty("is_top") : "NULL";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_friends SET ";
				if($this->isPropertySet("invite_status", "K")){
					$Sql .= "$con invite_status=" . $this->getProperty("invite_status");
					$con = ",";
				}
				if($this->isPropertySet("accepted_date", "K")){
					$Sql .= "$con accepted_date='" . $this->getProperty("accepted_date") . "'";
					$con = ",";
				}
				if($this->isPropertySet("is_top", "K")){
					$Sql .= "$con is_top=" . $this->getProperty("is_top");
					$con = ",";
				}

				$Sql .= " WHERE 1=1";
				$Sql .= " AND friend_cd=" . $this->getProperty("friend_cd");
				
				if($this->isPropertySet("member_cd", "K") && $this->isPropertySet("member_friend_cd", "K")){
					$Sql .= " AND member_cd=" . $this->getProperty("member_cd");
					$Sql .= " AND member_friend_cd=" . $this->getProperty("member_friend_cd");
				}
				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_friends 
						WHERE
							1=1";
				if($this->isPropertySet("friend_cd", "K"))
					$Sql .= " AND friend_cd=" . $this->getProperty("friend_cd");
				
				if($this->isPropertySet("member_cd", "K") && $this->isPropertySet("member_friend_cd", "K")){
					$Sql .= " AND member_cd=" . $this->getProperty("member_cd");
					$Sql .= " AND member_friend_cd=" . $this->getProperty("member_friend_cd");
				}

				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
	/*
	* This function is used to list the user's interest
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function lstBrowseMember(){
		$Sql = "SELECT
					a.member_cd,
					(SELECT CASE WHEN TRIM(a.middle_name) IS NOT NULL THEN CONCAT(a.first_name,' ', a.middle_name,' ',a.last_name) ELSE CONCAT(a.first_name,' ',a.last_name) END) AS fullname,
					(SELECT COUNT(prf_comment_cd) FROM rs_tbl_profile_comments WHERE prf_member_cd=a.member_cd) as total_comments,
					a.first_name,
					a.last_name,
					a.sex,
					(SELECT 
						c.photo_name 
					FROM 
						rs_tbl_album b
						INNER JOIN rs_tbl_photos c ON b.album_cd=b.album_cd
					WHERE
						b.member_cd=a.member_cd
						AND b.is_primary='Y'
						AND b.cover_photo_cd=c.photo_cd) AS photo_name
				FROM
					rs_tbl_members a";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	/*
	* This function is used to list most commented members
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function lstMostCommented(){
		$Sql = "SELECT
					a.member_cd,
					(SELECT CASE WHEN TRIM(a.middle_name) IS NOT NULL THEN CONCAT(a.first_name,' ', a.middle_name,' ',a.last_name) ELSE CONCAT(a.first_name,' ',a.last_name) END) AS fullname,
					(SELECT COUNT(prf_comment_cd) FROM rs_tbl_profile_comments WHERE prf_member_cd=a.member_cd) as total_comments,
					a.first_name,
					a.last_name,
					a.sex,
					(SELECT 
						c.photo_name 
					FROM 
						rs_tbl_album b
						INNER JOIN rs_tbl_photos c ON b.album_cd=b.album_cd
					WHERE
						b.member_cd=a.member_cd
						AND b.is_primary='Y'
						AND b.cover_photo_cd=c.photo_cd) AS photo_name
				FROM
					rs_tbl_members a";
		
		$Sql .= " ORDER BY total_comments DESC";

		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}

	/*
	* This function is used to list latest registered members
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function lstLatestMembers(){
		$Sql = "SELECT
					a.member_cd,
					(SELECT CASE WHEN TRIM(a.middle_name) IS NOT NULL THEN CONCAT(a.first_name,' ', a.middle_name,' ',a.last_name) ELSE CONCAT(a.first_name,' ',a.last_name) END) AS fullname,
					a.first_name,
					a.last_name,
					a.sex,
					a.join_date,
					(SELECT 
						c.photo_name 
					FROM 
						rs_tbl_album b
						INNER JOIN rs_tbl_photos c ON b.album_cd=b.album_cd
					WHERE
						b.member_cd=a.member_cd
						AND b.is_primary='Y'
						AND b.cover_photo_cd=c.photo_cd) AS photo_name
				FROM
					rs_tbl_members a";
		
		$Sql .= " ORDER BY join_date DESC";

		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}

	/*
	* This function is used to list the user's interest
	* @author Raju Gautam
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by Raju Gautam
	*/
	public function lstMostedViewed(){
		$Sql = "SELECT
					a.member_cd,
					(SELECT CASE WHEN TRIM(a.middle_name) IS NOT NULL THEN CONCAT(a.first_name,' ', a.middle_name,' ',a.last_name) ELSE CONCAT(a.first_name,' ',a.last_name) END) AS fullname,
					a.first_name,
					a.last_name,
					a.sex,
					a.profile_view,
					(SELECT 
						c.photo_name 
					FROM 
						rs_tbl_album b
						INNER JOIN rs_tbl_photos c ON b.album_cd=b.album_cd
					WHERE
						b.member_cd=a.member_cd
						AND b.is_primary='Y'
						AND b.cover_photo_cd=c.photo_cd) AS photo_name
				FROM
					rs_tbl_members a";
		
		$Sql .= " ORDER BY profile_view DESC";

		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
}
?>