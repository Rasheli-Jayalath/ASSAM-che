<?php
/**
*
* This is a class Domain
* @version 0.01
* @author Raju Gautam  <raju@devraju.com>
* @Date 10 Aug, 2007
* @modified 10 Aug, 2007 by Raju Gautam
*
**/
class Domain extends Database{
	/**
	* This is the constructor of the class Domain
	* @author Raju Gautam
	* @Date 10 Aug, 2007
	* @modified 10 Aug, 2007 by Raju Gautam
	*/
	public function __construct(){
		parent::__construct();
	}

	/**
	* This method is used to list the news
	* @author Raju Gautam
	* @Date 11 Aug, 2007
	* @modified 11 Aug, 2007 by Raju Gautam
	*/
	public function lstDomains(){
		$Sql = "SELECT
					*
				FROM
					rs_tbl_domains
				WHERE
					1=1 ";
		
		if($this->isPropertySet("domain_cd", "V")){
			$Sql .= " AND domain_cd=" . $this->getProperty("domain_cd");
		}
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}

	/**
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_domains the basis of property set
	* @author Raju Gautam
	* @Date 25 Dec, 2007
	* @modified 25 Dec, 2007 by Raju Gautam
	*/
	public function actDomain($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_domains(
						domain_cd,
						domain,
						details,
						image_name,
						link,
						status)
						VALUES(";
				$Sql .= $this->isPropertySet("domain_cd", "V") ? $this->getProperty("domain_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("domain", "V") ? "'" . $this->getProperty("domain") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("details", "V") ? "'" . $this->getProperty("details") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("image_name", "V") ? "'" . $this->getProperty("image_name") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("link", "V") ? "'" . $this->getProperty("link") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("status", "V") ? $this->getProperty("status") : "''";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_domains SET ";
				if($this->isPropertySet("domain", "K")){
					$Sql .= "$con domain='" . $this->getProperty("domain") . "'";
					$con = ",";
				}
				if($this->isPropertySet("details", "K")){
					$Sql .= "$con details='" . $this->getProperty("details") . "'";
					$con = ",";
				}
				if($this->isPropertySet("image_name", "K")){
					