<?php
/*
*
* This is a class Log
* @version 0.01
* @author Raju Gautam  <raju@devraju.com>
* @Date 10 Aug, 2007
* @modified 10 Aug, 2007 by Raju Gautam
*
**/
class Log extends Database{
	/*
	* This is the constructor of the class Log
	* @author Raju Gautam  <raju@devraju.com>
	* @Date 10 Aug, 2007
	* @modified 10 Aug, 2007 by Raju Gautam
	*/
	public function __construct(){
		parent::__construct();
	}

	/*
	* This method is used to list the menus
	* @author Raju Gautam
	* @Date 14 Dec, 2007
	* @modified 14 Dec, 2007 by Raju Gautam
	*/
	function lstLog(){
		$Sql = "SELECT
					log_cd,
					log_module,
					log_title,
					log_desc,
					log_date,
					log_ip,
					user_cd
				FROM
					rs_tbl_log
				WHERE
					1=1";
		if($this->isPropertySet("log_cd", "V"))
			$Sql .= " AND log_cd=" . $this->getProperty("log_cd");
		if($this->isPropertySet("log_module", "V"))
			$Sql .= " AND log_module='" . $this->getProperty("log_module") . "'";
		if($this->isPropertySet("log_title", "V"))
			$Sql .= " AND log_title='" . $this->getProperty("log_title") . "'";
		if($this->isPropertySet("log_ip", "V"))
			$Sql .= " AND log_ip='" . $this->getProperty("log_ip") . "'";
		if($this->isPropertySet("from_dt", "V") && $this->isPropertySet("to_dt", "V"))
			$Sql .= " AND log_date BETWEEN '" . $this->getProperty("from_dt") . "' AND '" . $this->getProperty("to_dt") . "'";
		
		return $this->dbQuery($Sql);
	}
	
	/*
	* This method is used to insert the log rows
	* @author Raju Gautam
	* @Date 24 Dec, 2007
	* @modified 24 Dec, 2007 by Raju Gautam
	*/
	function actLog($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO mis_tbl_log(
							log_cd,
							log_module,
							log_title,
							log_desc,
							log_date,
							log_ip,
							user_cd)
						VALUES(";
				$Sql .= $this->isPropertySet("log_cd", "V") ? $this->getProperty("log_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("log_module", "V") ? "'" . $this->getProperty("log_module") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("log_title", "V") ? "'" . $this->getProperty("log_title") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("log_desc", "V") ? "'" . $this->getProperty("log_desc") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("log_date", "V") ? "'" . $this->getProperty("log_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("log_ip", "V") ? "'" . $this->getProperty("log_ip") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_cd", "V") ? $this->getProperty("user_cd") : "NULL";
				$Sql .= ")";
				break;
			case "D":
				$Sql = "DELETE FROM mis_tbl_log WHERE 1=1 AND log_cd=" . $this->getProperty("log_cd");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
}
?>