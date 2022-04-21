<?php
/**
*
* This is a class AdminUser
* @version 0.01
* @author
* @Date 10 Aug, 2007
* @modified 10 Aug, 2007 by 
*
**/
class AdminUser extends Database{
	public $ne_is_login;
	public $ne_user_cd;
	public $ne_user_name;
	public $ne_fullname_name;
	public $ne_logged_in_time;
	public $ne_user_type;
	public $ne_member_cd;
	public $ne_designation;
	public $ne_sadmin;
	public $ne_news;
	public $ne_newsadm;
	public $ne_newsentry;
	
	public $ne_res;
	public $ne_resadm;
	public $ne_resentry;
	
	public $ne_mdata;
	public $ne_mdataadm;
	public $ne_mdataentry;
	public $ne_mile;
	public $ne_mileadm;
	public $ne_mileentry;
	
	public $ne_spg;
	public $ne_spgadm;
	public $ne_spgentry;
	
	public $ne_kpi;
	public $ne_kpiadm;
	public $ne_kpientry;
	
	public $ne_cam;
	public $ne_camadm;
	public $ne_camentry;
	
	public $ne_boq;
	public $ne_boqadm;
	public $ne_boqentry;
	
	public $ne_ipc;
	public $ne_ipcadm;
	public $ne_ipcentry;
	
	public $ne_eva;
	public $ne_evaadm;
	public $ne_evaentry;
	
	public $ne_padm;
	
	public $ne_actd;
	
	public $ne_miled;
	
	public $ne_kpid;
	
	public $ne_camd;
	
	public $ne_kfid;
	
	public $ne_evad;
	
	public $ne_pic;
	public $ne_picadm;
	public $ne_picentry;
	
	public $ne_process;
	

	/*
	* This is the constructor of the class AdminUser
	* @author
	* @Date 10 Aug, 2007
	* @modified 10 Aug, 2007 by 
	*/
	public function __construct(){
		parent::__construct();
		if($_SESSION['ne_is_login'] == true){
			$this->ne_is_login 		= $_SESSION['ne_is_login'];
			$this->ne_user_cd 		= $_SESSION['ne_user_cd'];
			$this->ne_username 		= $_SESSION['ne_username'];
			$this->ne_user_type 	= $_SESSION['ne_user_type'];
			$this->ne_fullname_name = $_SESSION['ne_fullname_name'];
			$this->ne_logged_in_time = $_SESSION['ne_logged_in_time'];
			$this->ne_member_cd 	= $_SESSION['ne_member_cd'];
			$this->ne_designation 	= $_SESSION['ne_designation'];
			$this->ne_sadmin 		= $_SESSION['ne_sadmin'];
			$this->ne_news 			= $_SESSION['ne_news'];
			$this->ne_newsadm 		= $_SESSION['ne_newsadm'];
			$this->ne_newsentry 	= $_SESSION['ne_newsentry'];
			
			$this->ne_res 			= $_SESSION['ne_res'];
			$this->ne_resadm 		= $_SESSION['ne_resadm'];
			$this->ne_resentry 		= $_SESSION['ne_resentry'];
			
			$this->ne_mdata 		= $_SESSION['ne_mdata'];
			$this->ne_mdataadm 		= $_SESSION['ne_mdataadm'];
			$this->ne_mdataentry 	= $_SESSION['ne_mdataentry'];
			$this->ne_mile 			= $_SESSION['ne_mile'];
			$this->ne_mileadm 		= $_SESSION['ne_mileadm'];
			$this->ne_mileentry 	= $_SESSION['ne_mileentry'];
			
			$this->ne_spg 			= $_SESSION['ne_spg'];
			$this->ne_spgadm 		= $_SESSION['ne_spgadm'];
			$this->ne_spgentry 		= $_SESSION['ne_spgentry'];
			
			$this->ne_kpi 			= $_SESSION['ne_kpi'];
			$this->ne_kpiadm 		= $_SESSION['ne_kpiadm'];
			$this->ne_kpientry 		= $_SESSION['ne_kpientry'];
			
			$this->ne_cam 			= $_SESSION['ne_cam'];
			$this->ne_camadm 		= $_SESSION['ne_camadm'];
			$this->ne_camentry 		= $_SESSION['ne_camentry'];
			
			$this->ne_boq 			= $_SESSION['ne_boq'];
			$this->ne_boqadm 		= $_SESSION['ne_boqadm'];
			$this->ne_boqentry 		= $_SESSION['ne_boqentry'];
			
			$this->ne_ipc 			= $_SESSION['ne_ipc'];
			$this->ne_ipcadm 		= $_SESSION['ne_ipcadm'];
			$this->ne_ipcentry 		= $_SESSION['ne_ipcentry'];
			
			$this->ne_eva 			= $_SESSION['ne_eva'];
			$this->ne_evaadm 		= $_SESSION['ne_evaadm'];
			$this->ne_evaentry 		= $_SESSION['ne_evaentry'];
			
			$this->ne_padm 			= $_SESSION['ne_padm'];
			$this->ne_actd 			= $_SESSION['ne_actd'];
			$this->ne_miled 		= $_SESSION['ne_miled'];
			
			$this->ne_kpid 			= $_SESSION['ne_kpid'];
			$this->ne_camd 			= $_SESSION['ne_camd'];
			$this->ne_kfid 			= $_SESSION['ne_kfid'];
			$this->ne_evad 			= $_SESSION['ne_evad'];
			
			$this->ne_pic 			= $_SESSION['ne_pic'];
			$this->ne_picadm 		= $_SESSION['ne_picadm'];
			$this->ne_picentry 		= $_SESSION['ne_picentry'];
			
			$this->ne_process 			= $_SESSION['ne_process'];
			
			
			
			
		}
	}

	/*
	* This is the function to set the admin user logged in
	* @author 
	* @Date 13 Dec, 2007
	* @modified 13 Dec, 2007 by 
	*/
	public function setAdminLogin(){
		$_SESSION['ne_is_login'] 	= true;
		if($this->isPropertySet("user_cd", "V"))
			$_SESSION['ne_user_cd'] 		= $this->getProperty("user_cd");
		if($this->isPropertySet("username", "V"))
			$_SESSION['ne_username'] 		= $this->getProperty("username");
		if($this->isPropertySet("logged_in_time", "V"))
			$_SESSION['ne_logged_in_time'] 	= $this->getProperty("logged_in_time");
		if($this->isPropertySet("user_type", "V"))
			$_SESSION['ne_user_type'] 		= $this->getProperty("user_type");
		if($this->isPropertySet("member_cd", "V"))
			$_SESSION['ne_member_cd'] 		= $this->getProperty("member_cd");
			if($this->isPropertySet("designation", "V"))
			$_SESSION['ne_designation'] 		= $this->getProperty("designation");
		if($this->isPropertySet("fullname_name", "V"))
			$_SESSION['ne_fullname_name'] 		= $this->getProperty("fullname_name");
			if($this->isPropertySet("sadmin", "V"))
			$_SESSION['ne_sadmin'] 		= $this->getProperty("sadmin");
		if($this->isPropertySet("news", "V"))
			$_SESSION['ne_news'] 		= $this->getProperty("news");
		if($this->isPropertySet("newsadm", "V"))
			$_SESSION['ne_newsadm'] 		= $this->getProperty("newsadm");
		if($this->isPropertySet("newsentry", "V"))
			$_SESSION['ne_newsentry'] 		= $this->getProperty("newsentry");
		
		if($this->isPropertySet("res", "V"))
			$_SESSION['ne_res'] 		= $this->getProperty("res");
		if($this->isPropertySet("resadm", "V"))
			$_SESSION['ne_resadm'] 		= $this->getProperty("resadm");
		if($this->isPropertySet("resentry", "V"))
			$_SESSION['ne_resentry'] 		= $this->getProperty("resentry");
			
		if($this->isPropertySet("mdata", "V"))
			$_SESSION['ne_mdata'] 		= $this->getProperty("mdata");
		if($this->isPropertySet("mdataadm", "V"))
			$_SESSION['ne_mdataadm'] 		= $this->getProperty("mdataadm");
		if($this->isPropertySet("mdataentry", "V"))
			$_SESSION['ne_mdataentry'] 		= $this->getProperty("mdataentry");
		if($this->isPropertySet("mile", "V"))
			$_SESSION['ne_mile'] 		= $this->getProperty("mile");
		if($this->isPropertySet("mileadm", "V"))
			$_SESSION['ne_mileadm'] 		= $this->getProperty("mileadm");
		if($this->isPropertySet("mileentry", "V"))
			$_SESSION['ne_mileentry'] 		= $this->getProperty("mileentry");
			
			if($this->isPropertySet("spg", "V"))
			$_SESSION['ne_spg'] 		= $this->getProperty("spg");
		if($this->isPropertySet("spgadm", "V"))
			$_SESSION['ne_spgadm'] 		= $this->getProperty("spgadm");
		if($this->isPropertySet("spgentry", "V"))
			$_SESSION['ne_spgentry'] 		= $this->getProperty("spgentry");
			
			if($this->isPropertySet("kpi", "V"))
			$_SESSION['ne_kpi'] 		= $this->getProperty("kpi");
		if($this->isPropertySet("kpiadm", "V"))
			$_SESSION['ne_kpiadm'] 		= $this->getProperty("kpiadm");
		if($this->isPropertySet("kpientry", "V"))
			$_SESSION['ne_kpientry'] 		= $this->getProperty("kpientry");
			
		if($this->isPropertySet("cam", "V"))
			$_SESSION['ne_cam'] 		= $this->getProperty("cam");
		if($this->isPropertySet("camadm", "V"))
			$_SESSION['ne_camadm'] 		= $this->getProperty("camadm");
		if($this->isPropertySet("camentry", "V"))
			$_SESSION['ne_camentry'] 		= $this->getProperty("camentry");
			
		if($this->isPropertySet("boq", "V"))
			$_SESSION['ne_boq'] 		= $this->getProperty("boq");
		if($this->isPropertySet("boqadm", "V"))
			$_SESSION['ne_boqadm'] 		= $this->getProperty("boqadm");
		if($this->isPropertySet("boqentry", "V"))
			$_SESSION['ne_boqentry'] 		= $this->getProperty("boqentry");
			
		if($this->isPropertySet("ipc", "V"))
			$_SESSION['ne_ipc'] 		= $this->getProperty("ipc");
		if($this->isPropertySet("ipcadm", "V"))
			$_SESSION['ne_ipcadm'] 		= $this->getProperty("ipcadm");
		if($this->isPropertySet("ipcentry", "V"))
			$_SESSION['ne_ipcentry'] 		= $this->getProperty("ipcentry");
			
			if($this->isPropertySet("eva", "V"))
			$_SESSION['ne_eva'] 		= $this->getProperty("eva");
		if($this->isPropertySet("evaadm", "V"))
			$_SESSION['ne_evaadm'] 		= $this->getProperty("evaadm");
		if($this->isPropertySet("evaentry", "V"))
			$_SESSION['ne_evaentry'] 		= $this->getProperty("evaentry");			
			
		if($this->isPropertySet("padm", "V"))
			$_SESSION['ne_padm'] 		= $this->getProperty("padm");
			
		if($this->isPropertySet("actd", "V"))
			$_SESSION['ne_actd'] 		= $this->getProperty("actd");
			
		if($this->isPropertySet("miled", "V"))
			$_SESSION['ne_miled'] 		= $this->getProperty("miled");
			
		if($this->isPropertySet("kpid", "V"))
			$_SESSION['ne_kpid'] 		= $this->getProperty("kpid");
			
		if($this->isPropertySet("camd", "V"))
			$_SESSION['ne_camd'] 		= $this->getProperty("camd");
			
		if($this->isPropertySet("kfid", "V"))
			$_SESSION['ne_kfid'] 		= $this->getProperty("kfid");
		
		if($this->isPropertySet("evad", "V"))
			$_SESSION['ne_evad'] 		= $this->getProperty("evad");
			
		if($this->isPropertySet("pic", "V"))
			$_SESSION['ne_pic'] 		= $this->getProperty("pic");
		if($this->isPropertySet("picadm", "V"))
			$_SESSION['ne_picadm'] 		= $this->getProperty("picadm");
		if($this->isPropertySet("picentry", "V"))
			$_SESSION['ne_picentry'] 		= $this->getProperty("picentry");
			
		if($this->isPropertySet("process", "V"))
			$_SESSION['ne_process'] 		= $this->getProperty("process");
			
			
			

	}
	
	/*
	* This is the function to unset the session variables
	* @author 
	* @Date 13 Dec, 2007
	* @modified 13 Dec, 2007 by 
	*/
	public function setLogout(){
		unset(
				$_SESSION['ne_is_login'], 
				$_SESSION['ne_user_cd'], 
				$_SESSION['ne_username'], 
				$_SESSION['ne_logged_in_time'], 
				$_SESSION['ne_user_type'], 
				$_SESSION['ne_fullname_name'],
				$_SESSION['ne_member_cd'],
				$_SESSION['ne_designation'],
				$_SESSION['ne_sadmin'],
				$_SESSION['ne_news'],
				$_SESSION['ne_newsadm'],
				$_SESSION['ne_newsentry'],
				
				$_SESSION['ne_res'],
				$_SESSION['ne_resadm'],
				$_SESSION['ne_resentry'],
				
				$_SESSION['ne_mdata'],
				$_SESSION['ne_mdataadm'],
				$_SESSION['ne_mdataentry'],
				$_SESSION['ne_mile'],
				$_SESSION['ne_mileadm'],
				$_SESSION['ne_mileentry'],
				$_SESSION['ne_spg'],
				$_SESSION['ne_spgadm'],
				$_SESSION['ne_spgentry'],
				$_SESSION['ne_kpi'],
				$_SESSION['ne_kpiadm'],
				$_SESSION['ne_kpientry'],
				$_SESSION['ne_cam'],
				$_SESSION['ne_camadm'],
				$_SESSION['ne_camentry'],
				
				$_SESSION['ne_boq'],
				$_SESSION['ne_boqadm'],
				$_SESSION['ne_boqentry'],
				
				$_SESSION['ne_ipc'],
				$_SESSION['ne_ipcadm'],
				$_SESSION['ne_ipcentry'],
				
				$_SESSION['ne_eva'],
				$_SESSION['ne_evaadm'],
				$_SESSION['ne_evaentry'],
				
				$_SESSION['ne_padm'],
				$_SESSION['ne_actd'],
				$_SESSION['ne_miled'],
				
				$_SESSION['ne_kpid'],
				$_SESSION['ne_camd'],
				$_SESSION['ne_kfid'],
				$_SESSION['ne_evad'],
				
				$_SESSION['ne_pic'],
				$_SESSION['ne_picadm'],
				$_SESSION['ne_picentry'],
				
				$_SESSION['ne_process']
				
			);
	}
	
	/*
	* This function is used to list the admin users
	* @author 
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by 
	*/
	public function lstAdminUser(){
		 $Sql = "SELECT 
					user_cd,
					username,
					passwd,
					first_name,
					last_name,
					CONCAT(first_name,' ',last_name) AS fullname,
					email,
					designation,
					phone,
					user_type,
					last_login_date,
					is_active,
					member_cd,
					sadmin,
					news,
					newsadm,
					newsentry,
					res,
					resadm,
					resentry,
					mdata,
					mdataadm,
					mdataentry,
					mile,
					mileadm,
					mileentry,
					spg,
					spgadm,
					spgentry,					
					kpi,
					kpiadm,
					kpientry,					
					cam,
					camadm,
					camentry,					
					boq,
					boqadm,
					boqentry,					
					ipc,
					ipcadm,
					ipcentry,					
					eva,
					evaadm,
					evaentry,
					padm,
					actd,
					miled,					
					kpid,
					camd,
					kfid,
					evad,
					pic,
					picadm,
					picentry,
					process
					
					
				FROM
					mis_tbl_users
				WHERE 
					1=1";
		if($this->isPropertySet("user_cd", "V"))
			$Sql .= " AND user_cd=" . $this->getProperty("user_cd");
		if($this->isPropertySet("username", "V"))
			$Sql .= " AND username='" . $this->getProperty("username") . "'";
		if($this->isPropertySet("passwd", "V"))
			$Sql .= " AND passwd='" . $this->getProperty("passwd") . "'";
			if($this->isPropertySet("user_type", "V"))
			$Sql .= " AND user_type='" . $this->getProperty("user_type") . "'";
			if($this->isPropertySet("user_name", "V")){
			$Sql .= " AND (LOWER(first_name) LIKE '%" . $this->getProperty("user_name") . "%' OR LOWER(last_name) LIKE '%" . $this->getProperty("user_name") . "%' OR LOWER(username) LIKE '%" . $this->getProperty("user_name") . "%')";
		}
		if($this->isPropertySet("limit", "V"))
			 $Sql .= $this->appendLimit($this->getProperty("limit"));
			 echo $sql;
		$this->dbQuery($Sql);
		
	}
	
	/*
	* This function is used to perform DML (Delete/Update/Add)
	* @author 
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by 
	*/
	public function actAdminUser($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO mis_tbl_users(
						user_cd,
						username,
						passwd,
						first_name,
						last_name,
						email,
						phone,
						designation,
						user_type,
						last_login_date,
						is_active,
						sadmin,
						news,
						newsadm,
						newsentry,
						res,
						resadm,
						resentry,
						mdata,
						mdataadm,
						mdataentry,
						mile,
						mileadm,
						mileentry,
						spg,
						spgadm,
						spgentry,						
						kpi,
						kpiadm,
						kpientry,						
						cam,
						camadm,
						camentry,						
						boq,
						boqadm,
						boqentry,						
						ipc,
						ipcadm,
						ipcentry,						
						eva,
						evaadm,
						evaentry,
						padm,
						actd,
						miled,					
						kpid,
						camd,
						kfid,
						evad,
						pic,
						picadm,
						picentry,
						process
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("user_cd", "V") ? $this->getProperty("user_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("username", "V") ? "'" . $this->getProperty("username") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("passwd", "V") ? "'" . $this->getProperty("passwd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("first_name", "V") ? "'" . $this->getProperty("first_name") . "'" : "NULL";
				$Sql .= ",";				
				$Sql .= $this->isPropertySet("last_name", "V") ? "'" . $this->getProperty("last_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("email", "V") ? "'" . $this->getProperty("email") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("phone", "V") ? "'" . $this->getProperty("phone") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("designation", "V") ? "'" . $this->getProperty("designation") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("user_type", "V") ? "'" . $this->getProperty("user_type") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("last_login_date", "V") ? "'" . $this->getProperty("last_login_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("is_active", "V") ? "'" . $this->getProperty("is_active") . "'" : "1";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("sadmin", "V") ?$this->getProperty("sadmin") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("news", "V") ?$this->getProperty("news") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("newsadm", "V") ?$this->getProperty("newsadm") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("newsentry", "V") ? $this->getProperty("newsentry") : "0";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("res", "V") ?$this->getProperty("res") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("resadm", "V") ?$this->getProperty("resadm") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("resentry", "V") ? $this->getProperty("resentry") : "0";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("mdata", "V") ?$this->getProperty("mdata") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("mdataadm", "V") ?$this->getProperty("mdataadm") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("mdataentry", "V") ? $this->getProperty("mdataentry") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("mile", "V") ?$this->getProperty("mile") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("mileadm", "V") ?$this->getProperty("mileadm") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("mileentry", "V") ? $this->getProperty("mileentry") : "0";				
				$Sql .= ",";
				$Sql .= $this->isPropertySet("spg", "V") ?$this->getProperty("spg") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("spgadm", "V") ?$this->getProperty("spgadm") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("spgentry", "V") ? $this->getProperty("spgentry") : "0";				
				$Sql .= ",";
				$Sql .= $this->isPropertySet("kpi", "V") ?$this->getProperty("kpi") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("kpiadm", "V") ?$this->getProperty("kpiadm") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("kpientry", "V") ? $this->getProperty("kpientry") : "0";				
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cam", "V") ?$this->getProperty("cam") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("camadm", "V") ?$this->getProperty("camadm") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("camentry", "V") ? $this->getProperty("camentry") : "0";				
				$Sql .= ",";
				$Sql .= $this->isPropertySet("boq", "V") ?$this->getProperty("boq") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("boqadm", "V") ?$this->getProperty("boqadm") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("boqentry", "V") ? $this->getProperty("boqentry") : "0";				
				$Sql .= ",";
				$Sql .= $this->isPropertySet("ipc", "V") ?$this->getProperty("ipc") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("ipcadm", "V") ?$this->getProperty("ipcadm") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("ipcentry", "V") ? $this->getProperty("ipcentry") : "0";				
				$Sql .= ",";
				$Sql .= $this->isPropertySet("eva", "V") ?$this->getProperty("eva") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("evaadm", "V") ?$this->getProperty("evaadm") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("evaentry", "V") ? $this->getProperty("evaentry") : "0";
				
				$Sql .= ",";
				$Sql .= $this->isPropertySet("padm", "V") ?$this->getProperty("padm") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("actd", "V") ?$this->getProperty("actd") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("miled", "V") ? $this->getProperty("miled") : "0";				
				$Sql .= ",";
				$Sql .= $this->isPropertySet("kpid", "V") ?$this->getProperty("kpid") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("camd", "V") ?$this->getProperty("camd") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("kfid", "V") ? $this->getProperty("kfid") : "0";				
				$Sql .= ",";
				$Sql .= $this->isPropertySet("evad", "V") ? $this->getProperty("evad") : "0";				
				$Sql .= ",";
				$Sql .= $this->isPropertySet("pic", "V") ?$this->getProperty("pic") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("picadm", "V") ?$this->getProperty("picadm") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("picentry", "V") ? $this->getProperty("picentry") : "0";	
				
				$Sql .= ",";
				$Sql .= $this->isPropertySet("process", "V") ? $this->getProperty("process") : "0";			
				
				 $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE mis_tbl_users SET ";
				if($this->isPropertySet("username", "K")){
					$Sql .= "username='" . $this->getProperty("username") . "'";
					$con = ",";
				}
				if($this->isPropertySet("email", "K")){
					$Sql .= "$con email='" . $this->getProperty("email") . "'";
					$con = ",";
				}
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
				if($this->isPropertySet("phone", "K")){
					$Sql .= "$con phone='" . $this->getProperty("phone") . "'";
					$con = ",";
				}
				if($this->isPropertySet("designation", "K")){
					$Sql .= "$con designation='" . $this->getProperty("designation") . "'";
					$con = ",";
				}
				if($this->isPropertySet("user_type", "K")){
					$Sql .= "$con user_type='" . $this->getProperty("user_type") . "'";
					$con = ",";
				}
				if($this->isPropertySet("is_active", "K")){
					$Sql .= "$con is_active='" . $this->getProperty("is_active") . "'";
					
				}
				if($this->isPropertySet("sadmin", "K")){
					$Sql .= "$con sadmin='" . $this->getProperty("sadmin") . "'";
					
				}
				
				if($this->isPropertySet("news", "K")){
					$Sql .= "$con news='" . $this->getProperty("news") . "'";
					
				}if($this->isPropertySet("newsadm", "K")){
					$Sql .= "$con newsadm='" . $this->getProperty("newsadm") . "'";
					
				}if($this->isPropertySet("newsentry", "K")){
					$Sql .= "$con newsentry='" . $this->getProperty("newsentry") . "'";
					
				}
				if($this->isPropertySet("res", "K")){
					$Sql .= "$con res='" . $this->getProperty("res") . "'";
					
				}if($this->isPropertySet("resadm", "K")){
					$Sql .= "$con resadm='" . $this->getProperty("resadm") . "'";
					
				}if($this->isPropertySet("resentry", "K")){
					$Sql .= "$con resentry='" . $this->getProperty("resentry") . "'";
					
				}


				if($this->isPropertySet("mdata", "K")){
					$Sql .= "$con mdata='" . $this->getProperty("mdata") . "'";
					
				}if($this->isPropertySet("mdataadm", "K")){
					$Sql .= "$con mdataadm='" . $this->getProperty("mdataadm") . "'";
					
				}if($this->isPropertySet("mdataentry", "K")){
					$Sql .= "$con mdataentry='" . $this->getProperty("mdataentry") . "'";
					
				}
				if($this->isPropertySet("mile", "K")){
					$Sql .= "$con mile='" . $this->getProperty("mile") . "'";
					
				}if($this->isPropertySet("mileadm", "K")){
					$Sql .= "$con mileadm='" . $this->getProperty("mileadm") . "'";
					
				}if($this->isPropertySet("mileentry", "K")){
					$Sql .= "$con mileentry='" . $this->getProperty("mileentry") . "'";
					
				}
				
				if($this->isPropertySet("spg", "K")){
					$Sql .= "$con spg='" . $this->getProperty("spg") . "'";
					
				}if($this->isPropertySet("spgadm", "K")){
					$Sql .= "$con spgadm='" . $this->getProperty("spgadm") . "'";
					
				}if($this->isPropertySet("spgentry", "K")){
					$Sql .= "$con spgentry='" . $this->getProperty("spgentry") . "'";
					
				}
				
				if($this->isPropertySet("kpi", "K")){
					$Sql .= "$con kpi='" . $this->getProperty("kpi") . "'";
					
				}if($this->isPropertySet("kpiadm", "K")){
					$Sql .= "$con kpiadm='" . $this->getProperty("kpiadm") . "'";
					
				}if($this->isPropertySet("kpientry", "K")){
					$Sql .= "$con kpientry='" . $this->getProperty("kpientry") . "'";
					
				}
				
				if($this->isPropertySet("cam", "K")){
					$Sql .= "$con cam='" . $this->getProperty("cam") . "'";
					
				}if($this->isPropertySet("camadm", "K")){
					$Sql .= "$con camadm='" . $this->getProperty("camadm") . "'";
					
				}if($this->isPropertySet("camentry", "K")){
					$Sql .= "$con camentry='" . $this->getProperty("camentry") . "'";
					
				}
				
				if($this->isPropertySet("boq", "K")){
					$Sql .= "$con boq='" . $this->getProperty("boq") . "'";
					
				}if($this->isPropertySet("boqadm", "K")){
					$Sql .= "$con boqadm='" . $this->getProperty("boqadm") . "'";
					
				}if($this->isPropertySet("boqentry", "K")){
					$Sql .= "$con boqentry='" . $this->getProperty("boqentry") . "'";
					
				}
				
				if($this->isPropertySet("ipc", "K")){
					$Sql .= "$con ipc='" . $this->getProperty("ipc") . "'";
					
				}if($this->isPropertySet("ipcadm", "K")){
					$Sql .= "$con ipcadm='" . $this->getProperty("ipcadm") . "'";
					
				}if($this->isPropertySet("ipcentry", "K")){
					$Sql .= "$con ipcentry='" . $this->getProperty("ipcentry") . "'";
					
				}
				
				if($this->isPropertySet("eva", "K")){
					$Sql .= "$con eva='" . $this->getProperty("eva") . "'";
					
				}if($this->isPropertySet("evaadm", "K")){
					$Sql .= "$con evaadm='" . $this->getProperty("evaadm") . "'";
					
				}if($this->isPropertySet("evaentry", "K")){
					$Sql .= "$con evaentry='" . $this->getProperty("evaentry") . "'";
					
				}
				
				if($this->isPropertySet("padm", "K")){
					$Sql .= "$con padm='" . $this->getProperty("padm") . "'";
					
				}if($this->isPropertySet("actd", "K")){
					$Sql .= "$con actd='" . $this->getProperty("actd") . "'";
					
				}if($this->isPropertySet("miled", "K")){
					$Sql .= "$con miled='" . $this->getProperty("miled") . "'";
					
				}
				
				if($this->isPropertySet("kpid", "K")){
					$Sql .= "$con kpid='" . $this->getProperty("kpid") . "'";
					
				}if($this->isPropertySet("camd", "K")){
					$Sql .= "$con camd='" . $this->getProperty("camd") . "'";
					
				}if($this->isPropertySet("kfid", "K")){
					$Sql .= "$con kfid='" . $this->getProperty("kfid") . "'";
					
				}
				if($this->isPropertySet("evad", "K")){
					$Sql .= "$con evad='" . $this->getProperty("evad") . "'";
					
				}
				if($this->isPropertySet("pic", "K")){
					$Sql .= "$con pic='" . $this->getProperty("pic") . "'";
					
				}if($this->isPropertySet("picadm", "K")){
					$Sql .= "$con picadm='" . $this->getProperty("picadm") . "'";
					
				}if($this->isPropertySet("picentry", "K")){
					$Sql .= "$con picentry='" . $this->getProperty("picentry") . "'";
					
				}
				if($this->isPropertySet("process", "K")){
					$Sql .= "$con process='" . $this->getProperty("process") . "'";
					
				}
				
				$Sql .= " WHERE 1=1";
			 	$Sql .= " AND user_cd=" . $this->getProperty("user_cd");
				break;
			case "D":
				$Sql = "Delete from mis_tbl_users 
						WHERE
							1=1";
				$Sql .= " AND user_cd=" . $this->getProperty("user_cd");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}

	/*
	* This function is used to check the username already exists or not.
	* @author 
	* @Date Dec 05, 2007
	* @modified Dec 05, 2007 by 
	*/
	public function checkAdminUsername(){
		$Sql = "SELECT 
					username
				FROM
					mis_tbl_users
				WHERE 
					1=1";
		if($this->isPropertySet("username", "V"))
			$Sql .= " AND username='" . $this->getProperty("username") . "'";
		if($this->isPropertySet("user_cd", "V"))
			$Sql .= " AND user_cd!=" . $this->getProperty("user_cd");
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to check the email address already exists or not.
	* @author 
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by 
	*/
	public function checkAdminEmailAddress(){
		$Sql = "SELECT 
					user_cd,
					username,
					email,
					CONCAT(first_name,' ', middle_name , ' ',last_name) AS fullname
				FROM
					mis_tbl_users
				WHERE 
					1=1";
		if($this->isPropertySet("email", "V"))
			$Sql .= " AND email='" . $this->getProperty("email") . "'";
		if($this->isPropertySet("user_cd", "V"))
			$Sql .= " AND user_cd!=" . $this->getProperty("user_cd");
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to change the password
	* @author 
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by 
	*/
	public function changePassword(){
		$Sql = "UPDATE mis_tbl_users SET
					passwd='" . $this->getProperty("passwd") . "' 
				WHERE 
					1=1 
					AND user_cd=" . $this->getProperty("user_cd") . " 
					AND username='" . $this->getProperty("username") . "'";
		return $this->dbQuery($Sql);
	}
	
	public function actMenuUser($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO mis_tbl_user_rights(
				        right_id,
						user_cd,
						menu_cd
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("right_id", "V") ? $this->getProperty("right_id") : 
					"";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_cd", "V") ? $this->getProperty("user_cd") : 
				"NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("menu_cd", "V") ?  $this->getProperty("menu_cd") : 
				"NULL";
				
				echo $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE mis_tbl_user_rights SET ";
				if($this->isPropertySet("user_cd", "K")){
					$Sql .= "user_cd='" . $this->getProperty("user_cd") . "'";
					$con = ",";
				}
				if($this->isPropertySet("menu_cd", "K")){
					$Sql .= "$con menu_cd='" . $this->getProperty("menu_cd") . "'";
					$con = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND right_id=" . $this->getProperty("right_id");
				break;
			case "D":
				$Sql = "Delete from mis_tbl_user_rights
						WHERE
							1=1";
				$Sql .= " AND menu_cd=" . $this->getProperty("menu_cd");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
	public function actCMSUser($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_cms_rights(
				        cms_right_id,
						user_cd,
						cms_id
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("cms_right_id", "V") ? $this->getProperty("cms_right_id") : 
					"";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_cd", "V") ? $this->getProperty("user_cd") : 
				"NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cms_id", "V") ?  $this->getProperty("cms_id") : 
				"NULL";
				
				echo $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_cms_rights SET ";
				if($this->isPropertySet("user_cd", "K")){
					$Sql .= "user_cd='" . $this->getProperty("user_cd") . "'";
					$con = ",";
				}
				if($this->isPropertySet("cms_id", "K")){
					$Sql .= "$con cms_id='" . $this->getProperty("cms_id") . "'";
					$con = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND cms_right_id=" . $this->getProperty("cms_right_id");
				break;
			case "D":
				$Sql = "Delete from rs_tbl_cms_rights
						WHERE
							1=1";
				$Sql .= " AND cms_id=" . $this->getProperty("cms_id");
				if($this->isPropertySet("user_cd", "K")){
					$Sql .= " AND user_cd=" . $this->getProperty("user_cd") ;
					
				}
				//echo $Sql;
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
}
?>