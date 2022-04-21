<?php
/**
*
* This is a class News
* @version 0.01
* @author Raju Gautam  <raju@devraju.com>
* @Date 10 Aug, 2007
* @modified 10 Aug, 2007 by Raju Gautam
*
**/
class News extends Database{
	/**
	* This is the constructor of the class News
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
	public function lstNews($lang = false){
		$Sql = "SELECT
					news_cd,
					title,
					details,
					newsdate,
					ordering,
					newsfile,
					newsfile1,
					newsfile2,
					newsfile3,
					newsfile4,
					status
				FROM
					rs_tbl_news
				WHERE
					1=1 ";
		
		
		
		if($this->isPropertySet("news_cd", "V")){
			$Sql .= " AND news_cd=" . $this->getProperty("news_cd");
		}
		if($this->isPropertySet("status", "V"))
			$Sql .= " AND status='" . $this->getProperty("status") . "'";
		if($this->isPropertySet("orderby", "V"))
			$Sql .= " order by " . $this->getProperty("orderby");
	
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		return $this->dbQuery($Sql);
	}

	/**
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rr_tbl_news the basis of property set
	* @author Raju Gautam
	* @Date 25 Dec, 2007
	* @modified 25 Dec, 2007 by Raju Gautam
	*/
	public function actNews($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_news(
						news_cd,						
						title,
						details,
						newsdate,
						ordering,
						newsfile,
						newsfile1,
						newsfile2,
						newsfile3,
						newsfile4,
						status)
						VALUES(";
				$Sql .= $this->isPropertySet("news_cd", "V") ? $this->getProperty("news_cd") : "NULL";
				$Sql .= ",";				
				$Sql .= $this->isPropertySet("title", "V") ? "'" . $this->getProperty("title") . "'" : "''";
				$Sql .= ",";			
				$Sql .= $this->isPropertySet("details", "V") ? "'" . $this->getProperty("details") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("newsdate", "V") ? "'" . $this->getProperty("newsdate") . "'" : "''";
				$Sql .= ",";				
				$Sql .= $this->isPropertySet("ordering", "V") ? $this->getProperty("ordering") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("newsfile", "V") ? "'" . $this->getProperty("newsfile") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("newsfile1", "V") ? "'" . $this->getProperty("newsfile1") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("newsfile2", "V") ? "'" . $this->getProperty("newsfile2") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("newsfile3", "V") ? "'" . $this->getProperty("newsfile3") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("newsfile4", "V") ? "'" . $this->getProperty("newsfile4") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("status", "V") ? "'" . $this->getProperty("status") . "'" : "'Y'";
				
				 $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_news SET ";
				if($this->isPropertySet("title", "K")){
					$Sql .= "$con title='" . $this->getProperty("title") . "'";
					$con = ",";
				}
			
				if($this->isPropertySet("details", "K")){
					$Sql .= "$con details='" . $this->getProperty("details") . "'";
					$con = ",";
				}
				if($this->isPropertySet("newsdate", "K")){
					$Sql .= "$con newsdate='" . $this->getProperty("newsdate") . "'";
					$con = ",";
				}
				if($this->isPropertySet("newsfile", "K")){
					$Sql .= "$con newsfile='" . $this->getProperty("newsfile") . "'";
					$con = ",";
				}
				if($this->isPropertySet("newsfile1", "K")){
					$Sql .= "$con newsfile1='" . $this->getProperty("newsfile1") . "'";
					$con = ",";
				}
				if($this->isPropertySet("newsfile2", "K")){
					$Sql .= "$con newsfile2='" . $this->getProperty("newsfile2") . "'";
					$con = ",";
				}if($this->isPropertySet("newsfile3", "K")){
					$Sql .= "$con newsfile3='" . $this->getProperty("newsfile3") . "'";
					$con = ",";
				}
				if($this->isPropertySet("newsfile4", "K")){
					$Sql .= "$con newsfile4='" . $this->getProperty("newsfile4") . "'";
					$con = ",";
				}
				
				if($this->isPropertySet("status", "K")){
					$Sql .= "$con status='" . $this->getProperty("status") . "'";
					$con = ",";
				}
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND news_cd=" . $this->getProperty("news_cd");
				break;
			case "D":
				$Sql = "DELETE FROM rs_tbl_news WHERE news_cd=" . $this->getProperty("news_cd");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
}
?>