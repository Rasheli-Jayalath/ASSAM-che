<?php
/**
*
* This is a class Ads
* @version 0.01
* @author Numan Tahir  <numan_tahir1@yahoo.com>
* @Date 24 Dec, 2009
* @modified 24 Dec, 2009 by Numan Tahir
*
**/
class Ads extends Database{
	/**
	* This is the constructor of the class Ads
	* @author Numan Tahir
	* @Date 24 Dec, 2009
	* @modified 24 Dec, 2009 by Numan Tahir
	*/
	public function __construct(){
		parent::__construct();
	}

	/**
	* This method is used to list the news
	* @author Numan Tahir
	* @Date 24 Dec, 2009
	* @modified 24 Dec, 2009 by Numan Tahir
	*/
	public function lstads($type){
		$sql = "SELECT
					ad_title,
					ad_image,
					ad_page_name
				FROM
					rs_tbl_ads
				WHERE
					1=1
					AND ad_page_name='" . $type . "' 
					AND lang='" . SITE_LANG . "'";
		
		$this->dbQuery($sql);
		$rows = $this->dbFetchArray(1);
		return $rows;
	}

	/**
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_ads the basis of property set
	* @author Numan Tahir
	* @Date 24 Dec, 2009
	* @modified 24 Dec, 2009 by Numan Tahir
	*/
	public function actads($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_ads(
						ads_id,
						ad_title,
						ad_image,
						ad_page_name,
						status,
						lang,
						date)
						VALUES(";
				$Sql .= $this->isPropertySet("ads_id", "V") ? $this->getProperty("ads_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("ad_title", "V") ? "'" . $this->getProperty("ad_title") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("ad_image", "V") ? "'" . $this->getProperty("ad_image") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("ad_page_name", "V") ? "'" . $this->getProperty("ad_page_name") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("status", "V") ? "'" . $this->getProperty("status") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("lang", "V") ? $this->getProperty("lang") : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("date", "V") ? $this->getProperty("date") : "''";
				$Sql .= ")";
				break;
				
			case "U":
				$Sql = "UPDATE rs_tbl_ads SET ";
				if($this->isPropertySet("ad_title", "K")){
					$Sql .= "$con ad_title='" . $this->getProperty("ad_title") . "'";
					$con = ",";
				}
				if($this->isPropertySet("details", "K")){
					$Sql .= "$con details='" . $this->getProperty("details") . "'";
					$con = ",";
				}
				if($this->isPropertySet("ad_image", "K")){
					$Sql .= "$con ad_image='" . $this->getProperty("ad_image") . "'";
					$con = ",";
				}
				if($this->isPropertySet("ad_page_name", "K")){
					$Sql .= "$con ad_page_name='" . $this->getProperty("ad_page_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("status", "K")){
					$Sql .= "$con status=" . $this->getProperty("status");
					$con = ",";
				}
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND ads_id=" . $this->getProperty("ads_id");
				break;
				
			case "D":
				$Sql = "DELETE FROM rs_tbl_ads WHERE ads_id=" . $this->getProperty("ads_id");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
}
?>