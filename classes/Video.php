<?php
/**
*
* This is a class Video
* @version 0.01
* @author Raju Gautam  <raju@devraju.com>
* @Date 10 Aug, 2007
* @modified 10 Aug, 2007 by Raju Gautam
*
**/
class Video extends Database{
	/**
	* This is the constructor of the class Video
	* @author Raju Gautam
	* @Date 10 Aug, 2007
	* @modified 10 Aug, 2007 by Raju Gautam
	*/
	public function __construct(){
		parent::__construct();
	}

	/**
	* This method is used to list the vedios
	* @author Raju Gautam
	* @Date 26 Dec, 2007
	* @modified 26 Dec, 2007 by Raju Gautam
	*/
	public function lstVideos(){
		$Sql = "SELECT
					video_cd,
					video_name,
					video_description,
					video_date,
					video_status
				FROM
					rs_tbl_videos 
				WHERE
					1=1";
		if($this->isPropertySet("video_cd", "V"))
			$Sql .= " AND video_cd=" . $this->getProperty("video_cd");
		
		if($this->isPropertySet("video_status", "V"))
			$Sql .= " AND video_status='" . $this->getProperty("video_status") . "'";
		
		$Sql .= " ORDER BY video_date DESC";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}

	/**
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_videos the basis of property set
	* @author Raju Gautam
	* @Date 25 Dec, 2007
	* @modified 25 Dec, 2007 by Raju Gautam
	*/
	public function actVideo($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_videos(
						video_cd,
						video_name,
						video_description,
						video_date,
						video_status)
						VALUES(";
				$Sql .= $this->isPropertySet("video_cd", "V") ? $this->getProperty("video_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("video_name", "V") ? "'" . $this->getProperty("video_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("video_description", "V") ? "'" . $this->getProperty("video_description") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("video_date", "V") ? "'" . $this->getProperty("video_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("video_status", "V") ? "'" . $this->getProperty("video_status") . "'" : "NULL";

				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_videos SET ";
				if($this->isPropertySet("video_name", "K")){
					$Sql .= "$con video_name='" . $this->getProperty("video_name") . "'";
					$con = ',';
				}
				if($this->isPropertySet("video_description", "K")){
					$Sql .= "$con video_description='" . $this->getProperty("video_description") . "'";
					$con = ',';
				}
				if($this->isPropertySet("video_date", "K")){
					$Sql .= "$con video_date='" . $this->getProperty("video_date") . "'";
					$con = ',';
				}
				if($this->isPropertySet("video_status", "K")){
					$Sql .= "$con video_status='" . $this->getProperty("video_status") . "'";
					$con = ',';
				}
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND video_cd=" . $this->getProperty("video_cd");
				break;
			case "D":
				$Sql = "DELETE FROM rs_tbl_videos";
				$Sql .= " WHERE 1=1";
				$Sql .= " AND video_cd=" . $this->getProperty("video_cd");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
}
