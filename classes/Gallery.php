<?php
/**
*
* This is a class Gallery
* @version 0.01
* @author Raju Gautam  <raju@devraju.com>
* @Date 10 Aug, 2007
* @modified 10 Aug, 2007 by Raju Gautam
*
**/
class Gallery extends Database{
	
	/**
	* This is the constructor of the class Gallery
	* @author Raju Gautam
	* @Date 10 Aug, 2007
	* @modified 10 Aug, 2007 by Raju Gautam
	*/
	public function __construct(){
		parent::__construct();
	}
	
	/**
	* This method is used to get image extension
	* @author Raju Gautam
	* @Date : 30 Dec, 2007
	* @modified : 30 Dec, 2007 by Raju Gautam
	* @return : bool
	*/
	function getExtention($type){
		if($type == "image/jpeg" || $type == "image/jpg" || $type == "image/pjpeg")
			return "jpg";
		elseif($type == "image/png")
			return "png";
		elseif($type == "image/gif")
			return "gif";
	}
	
	/**
 	* Product::getImagename()	
	* This method is used to get image name
	* @author Raju Gautam
	* @Date : 30 Dec, 2007
	* @modified : 30 Dec, 2007 by Raju Gautam
	* @return : string (filename)
	*/
	public function getImagename($type){
		$md5 		= md5(time());
		$filename 	= substr($md5, rand(0, 22), 10);
		$filename 	= $filename . "." . $this->getExtention($type);
		return $filename;
	}
	
	/**
	* This method is used to list the albums
	* @author Raju Gautam
	* @Date 11 Aug, 2007
	* @modified 11 Aug, 2007 by Raju Gautam
	*/
	public function lstAlbums(){
		$Sql = "SELECT
					a.album_cd,
					a.album_name,
					a.album_status,
					(SELECT photo_name FROM rs_tbl_photos WHERE album_cd=a.album_cd AND is_album_cover='Y') AS primary_photo
				FROM
					rs_tbl_albums AS a
				WHERE
					1=1";
		if($this->isPropertySet("album_cd", "V"))
			$Sql .= " AND a.album_cd=" . $this->getProperty("album_cd");
		
		if($this->isPropertySet("album_status", "V"))
			$Sql .= " AND a.album_status='" . $this->getProperty("album_status") . "'";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Gallary::albumCombo()
	* This function is used to list the albums combo
	* @author Raju Gautam
	* @Date 06 April, 2008
	* @modified 06 April, 2008 by Raju Gautam
  	* @return string 	
	*/
	public function albumCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					album_cd,
					album_name
				FROM
					rs_tbl_albums
				WHERE 
					1=1 
				ORDER BY 
					album_name ASC";
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($sel == $rows['album_cd']) ? " selected" : "";
				$opt .= "<option value=\"" . $rows['album_cd'] . "\" " . $sele . ">" . $rows['album_name'] . "</option>\n";
			}
		}
		return $opt;
	}
	
	/**
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_albums the basis of property set
	* @author Raju Gautam
	* @Date 25 Dec, 2007
	* @modified 25 Dec, 2007 by Raju Gautam
	*/
	public function actAlbum($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_albums(
						album_cd,
						album_name,
						album_status)
						VALUES(";
				$Sql .= $this->isPropertySet("album_cd", "V") ? $this->getProperty("album_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("album_name", "V") ? "'" . $this->getProperty("album_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("album_status", "V") ? "'" . $this->getProperty("album_status") . "'" : "NULL";

				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_albums SET ";
				if($this->isPropertySet("album_name", "K")){
					$Sql .= "$con album_name='" . $this->getProperty("album_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("album_status", "K")){
					$Sql .= "$con album_status='" . $this->getProperty("album_status") . "'";
					$con = ",";
				}
				$Sql .= " WHERE 1=1";
				
				$Sql .= " AND album_cd=" . $this->getProperty("album_cd");
				break;
			case "D":
				$Sql = "DELETE FROM
							rs_tbl_albums
						WHERE
							1=1";
				$Sql .= " AND album_cd=" . $this->getProperty("album_cd");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}

	/**
	* This method is used to list the photos
	* @author Raju Gautam
	* @Date 11 Aug, 2007
	* @modified 11 Aug, 2007 by Raju Gautam
	*/
	public function lstPhotos(){
		$Sql = "SELECT
					b.photo_cd,
					b.album_cd,
					a.album_name,
					b.photo_name,
					b.photo_caption,
					b.photo_date,
					b.photo_status,
					b.is_album_cover
				FROM 
					rs_tbl_albums AS a
					INNER JOIN rs_tbl_photos AS b ON a.album_cd=b.album_cd
				WHERE
					1=1";
		if($this->isPropertySet("photo_cd", "V"))
			$Sql .= " AND b.photo_cd=" . $this->getProperty("photo_cd");
		
		if($this->isPropertySet("album_cd", "V"))
			$Sql .= " AND b.album_cd=" . $this->getProperty("album_cd");
		
		if($this->isPropertySet("photo_status", "V"))
			$Sql .= " AND b.photo_status='" . $this->getProperty("photo_status") . "'";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		#echo $Sql;
		return $this->dbQuery($Sql);
	}

	/**
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_albums the basis of property set
	* @author Raju Gautam
	* @Date 25 Dec, 2007
	* @modified 25 Dec, 2007 by Raju Gautam
	*/
	public function actPhoto($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_photos(
						photo_cd,
						album_cd,
						photo_name,
						photo_caption,
						photo_date,
						photo_status,
						is_album_cover)
						VALUES(";
				$Sql .= $this->isPropertySet("photo_cd", "V") ? $this->getProperty("photo_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("album_cd", "V") ? $this->getProperty("album_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("photo_name", "V") ? "'" . $this->getProperty("photo_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("photo_caption", "V") ? "'" . $this->getProperty("photo_caption") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("photo_date", "V") ? "'" . $this->getProperty("photo_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("photo_status", "V") ? "'" . $this->getProperty("photo_status") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("is_album_cover", "V") ? "'" . $this->getProperty("is_album_cover") . "'" : "NULL";

				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_photos SET ";
				if($this->isPropertySet("album_cd", "K")){
					$Sql .= "$con album_cd=" . $this->getProperty("album_cd");
					$con = ",";
				}
				if($this->isPropertySet("photo_name", "K")){
					$Sql .= "$con photo_name='" . $this->getProperty("photo_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("photo_caption", "K")){
					$Sql .= "$con photo_caption='" . $this->getProperty("photo_caption") . "'";
					$con = ",";
				}
				if($this->isPropertySet("photo_date", "K")){
					$Sql .= "$con photo_date='" . $this->getProperty("photo_date") . "'";
					$con = ",";
				}
				if($this->isPropertySet("photo_status", "K")){
					$Sql .= "$con photo_status='" . $this->getProperty("photo_status") . "'";
					$con = ",";
				}
				if($this->isPropertySet("is_album_cover", "K")){
					$Sql .= "$con is_album_cover='" . $this->getProperty("is_album_cover") . "'";
					$con = ",";
				}
				$Sql .= " WHERE 1=1";
				
				$Sql .= " AND photo_cd=" . $this->getProperty("photo_cd");
				break;
			case "D":
				$Sql = "DELETE FROM
							rs_tbl_photos
						WHERE
							1=1";
				$Sql .= " AND photo_cd=" . $this->getProperty("photo_cd");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
}
?>