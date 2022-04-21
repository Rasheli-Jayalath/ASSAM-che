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
					user_cd,
					language_cd,
					title,
					short,
					details,
					news_date,
					news_down_date,
					ordering,
					news_file,
					status
				FROM
					rs_tbl_news
				WHERE
					1=1 ";
		
		if($lang === true){
			$Sql .= " AND language_cd='" . SITE_LANG . "'";
		}
		
		if($this->isPropertySet("news_cd", "V")){
			$Sql .= " AND news_cd=" . $this->getProperty("news_cd");
		}
		
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
						user_cd,
						language_cd,
						title,
						short,
						details,
						news_date,
						news_down_date,
						ordering,
						news_file,
						status)
						VALUES(";
				$Sql .= $this->isPropertySet("news_cd", "V") ? $this->getProperty("news_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_cd", "V") ? $this->getProperty("user_cd") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("language_cd", "V") ? "'" . $this->getProperty("language_cd") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("title", "V") ? "'" . $this->getProperty("title") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("short", "V") ? "'" . $this->getProperty("short") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("details", "V") ? "'" . $this->getProperty("details") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("news_date", "V") ? "'" . $this->getProperty("news_date") . "'" : "CURRENT_TIMESTAMP";
				
				$Sql .= ",";
				$Sql .= $this->isPropertySet("news_down_date", "V") ? "'" . $this->getProperty("news_down_date") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("ordering", "V") ? $this->getProperty("ordering") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("news_file", "V") ? "'" . $this->getProperty("news_file") . "'" : "''";
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
				if($this->isPropertySet("short", "K")){
					$Sql .= "$con short='" . $this->getProperty("short") . "'";
					$con = ",";
				}
				if($this->isPropertySet("language_cd", "K")){
					$Sql .= "$con language_cd='" . $this->getProperty("language_cd") . "'";
					$con = ",";
				}
				if($this->isPropertySet("details", "K")){
					$Sql .= "$con details='" . $this->getProperty("details") . "'";
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