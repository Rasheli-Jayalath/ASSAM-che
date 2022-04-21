<?php
/**
*
* This is a class Content
* @version 0.01
* @author Raju Gautam  <raju@devraju.com>
* @Date 10 Aug, 2007
* @modified 10 Aug, 2007 by Raju Gautam
*
**/
class Content extends Database{
	/**
	* This is the constructor of the class Content
	* @author Raju Gautam
	* @Date 10 Aug, 2007
	* @modified 10 Aug, 2007 by Raju Gautam
	*/
	public function __construct(){
		parent::__construct();
	}

	/**
	* This method is used to get the content of site cms
	* @author Raju Gautam
	* @Date 11 Aug, 2007
	* @modified 11 Aug, 2007 by Raju Gautam
	*/
	public function getContent($type){
		$sql = "SELECT
					cms_title,
					cms_short,
					domain_cd,
					cms_details
				FROM
					rs_tbl_contents
				WHERE
					1=1
					AND cms_type='" . $type . "' 
					AND domain_cd='" . DOMAIN_CODE . "'
					AND language_cd='" . SITE_LANG . "'";
		
		$this->dbQuery($sql);
		$rows = $this->dbFetchArray(1);
		return $rows;
	}

	/**
	* This method is used to get the content of site cms
	* @author Raju Gautam
	* @Date 11 Aug, 2007
	* @modified 11 Aug, 2007 by Raju Gautam
	*/
	public function lstContent(){
		$Sql = "SELECT
					a.cms_cd,
					a.language_cd,
					a.domain_cd,
					(CASE WHEN domain_cd=0 THEN
						'Main Site'
					ELSE
						(SELECT domain FROM rs_tbl_domains WHERE domain_cd=a.domain_cd)
					END) as domain_name,
					a.cms_type,
					a.cms_title,
					a.cms_short,
					a.cms_details,
					a.cms_date
				FROM
					rs_tbl_contents AS a
				WHERE
					1=1";
		if($this->isPropertySet("cms_cd", "V"))
			$Sql .= " AND a.cms_cd=" . $this->getProperty("cms_cd");
		
		if($this->isPropertySet("cms_type", "V"))
			$Sql .= " AND a.cms_type='" . $this->getProperty("cms_type") . "'";
		
		if($this->isPropertySet("domain_cd", "V"))
			$Sql .= " AND a.domain_cd='" . $this->getProperty("domain_cd") . "'";
		
		if($this->isPropertySet("cms_title", "V"))
			$Sql .= " AND a.cms_title='" . $this->getProperty("cms_title") . "'";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}

	/**
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rr_tbl_contents the basis of property set
	* @author Raju Gautam
	* @Date 25 Dec, 2007
	* @modified 25 Dec, 2007 by Raju Gautam
	*/
	public function actContent($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_contents(
							cms_cd,
							language_cd,
							domain_cd,
							cms_type,
							cms_title,
							cms_short,
							cms_details,
							cms_date)
						VALUES(";
				$Sql .= $this->isPropertySet("cms_cd", "V") ? $this->getProperty("cms_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("language_cd", "V") ? "'" . $this->getProperty("language_cd") . "'" : "'EN'";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("domain_cd", "V") ? "'" . $this->getProperty("domain_cd") . "'" : "'0'";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cms_type", "V") ? "'" . $this->getProperty("cms_type") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cms_title", "V") ? "'" . $this->getProperty("cms_title") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cms_short", "V") ? "'" . $this->getProperty("cms_short") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cms_details", "V") ? "'" . $this->getProperty("cms_details") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cms_date", "V") ? "'" . $this->getProperty("cms_date") . "'" : "NULL";

				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_contents SET ";
				if($this->isPropertySet("language_cd", "K")){
					$Sql .= "$cat language_cd='" . $this->getProperty("language_cd") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("domain_cd", "K")){
					$Sql .= "$cat domain_cd='" . $this->getProperty("domain_cd") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("cms_title", "K")){
					$Sql .= "$cat cms_title='" . $this->getProperty("cms_title") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("cms_short", "K")){
					$Sql .= "$cat cms_short='" . $this->getProperty("cms_short") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("cms_details", "K")){
					$Sql .= "$cat cms_details='" . $this->getProperty("cms_details") . "'";
					$cat = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND cms_cd=" . $this->getProperty("cms_cd");
				break;
			case "D":
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
}
?>