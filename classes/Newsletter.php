<?php
/**
*
* This is a class Newsletter
* @version 0.01
* @author Raju Gautam <raju@devraju.com>
* @Date 10 Aug, 2007
* @modified 10 Aug, 2007 by Raju Gautam
*
**/
class Newsletter extends Database{
	/**
	* This is the constructor of the class Newsletter
	* @author Raju Gautam <raju@devraju.com>
	* @Date 10 Aug, 2007
	* @modified 10 Aug, 2007 by Raju Gautam
	*/
	public function __construct(){
		parent::__construct();
	}
    
	/**
	* This function is used to check if the email address already registered/subscribed
	* @author Raju Gautam
	* @Date 14 April, 2008
	* @modified 14 April, 2008 by Raju Gautam
	*/
	public function emailExists(){
		$Sql = "SELECT 
					subcriber_cd,
                    gender,
                    initials,
                    fullname,
                    CONCAT(initials, ' ', fullname) AS full_name,
                    email,
                    subscriber_date,
                    city
				FROM
					rs_tbl_subscribers
				WHERE 
					1=1";
		if($this->isPropertySet("email", "V"))
			$Sql .= " AND email='" . $this->getProperty("email") . "'";
		
		$this->dbQuery($Sql);
        if($this->totalRecords() >= 1){
            $rows = $this->dbFetchArray(1);
            return $rows;
        }
        else{
            return false;
        }
	}
	
	/**
	* This function is used to get the max customer code
	* @author Raju Gautam
	* @Date 20th December, 2008
	* @modified 20th December, 2008 by Raju Gautam
	*/
	public function getMaxCode(){
		return $this->genCode('rs_tbl_subscribers', 'subcriber_cd');
	}
	
    /**
    * This function is used to list the Subscribers
    * @author Raju Gautam
    * @Date 20 Dec, 2007
    * @modified 20 Dec, 2007 by Raju Gautam
    */
    public function lstSubscribers(){
        $Sql = "SELECT 
                    subcriber_cd,
                    gender,
                    initials,
                    CONCAT(initials, ' ', fullname) AS full_name,
                    email,
                    subscriber_date,
                    city,
                    confirm_cd,
                    status
                FROM
                    rs_tbl_subscribers 
                WHERE 
                    1=1";
        if($this->isPropertySet("subcriber_cd", "V"))
            $Sql .= " AND subcriber_cd=" . $this->getProperty("subcriber_cd");
        
        if($this->isPropertySet("search", "V"))
            $Sql .= " AND (
                            fullname LIKE '%" . $this->getProperty("search") . "%'
                            OR email='" . $this->getProperty("search") . "'
                            )";
        
        if($this->isPropertySet("status", "V"))
            $Sql .= " AND status='" . $this->getProperty("status") . "'";
        
        if($this->isPropertySet("confirm_cd", "V"))
            $Sql .= " AND confirm_cd='" . $this->getProperty("confirm_cd") . "'";
            
        if($this->isPropertySet("limit", "V"))
            $Sql .= $this->appendLimit($this->getProperty("limit"));
        
        $this->dbQuery($Sql);
    }
    
    /**
    * This function is used to perform DML (Delete/Update/Add)
    * @author Raju Gautam
    * @Date 20 Dec, 2007
    * @modified 20 Dec, 2007 by Raju Gautam
    */
    public function actSubscriber($mode = "I"){
        $mode = strtoupper($mode);
        switch($mode){
            case "I":
                $Sql = "INSERT INTO rs_tbl_subscribers(
                        subcriber_cd,
                        gender,
                        initials,
                        fullname,
                        email,
                        subscriber_date,
						city,
						confirm_cd,
						status) 
                        VALUES(";
                $Sql .= $this->isPropertySet("subcriber_cd", "V") ? $this->getProperty("subcriber_cd") : "NULL";
                $Sql .= ",";
                $Sql .= $this->isPropertySet("gender", "V") ? "'" . $this->getProperty("gender") . "'" : "NULL";
                $Sql .= ",";
                $Sql .= $this->isPropertySet("initials", "V") ? "'" . $this->getProperty("initials") . "'" : "NULL";
                $Sql .= ",";
                $Sql .= $this->isPropertySet("fullname", "V") ? "'" . $this->getProperty("fullname") . "'" : "NULL";
                $Sql .= ",";
                $Sql .= $this->isPropertySet("email", "V") ? "'" . $this->getProperty("email") . "'" : "NULL";
                
                $Sql .= ",";
                $Sql .= $this->isPropertySet("subscriber_date", "V") ? "'" . $this->getProperty("subscriber_date") . "'" : "NULL";
                $Sql .= ",";
                $Sql .= $this->isPropertySet("city", "V") ? "'" . $this->getProperty("city") . "'" : "NULL";
                $Sql .= ",";
                $Sql .= $this->isPropertySet("confirm_cd", "V") ? "'" . $this->getProperty("confirm_cd") . "'" : "NULL";
                $Sql .= ",";
                $Sql .= $this->isPropertySet("status", "V") ? "'" . $this->getProperty("status") . "'" : "NULL";
                
                $Sql .= ")";
                break;
            case "U":
                $Sql = "UPDATE rs_tbl_subscribers SET ";
                if($this->isPropertySet("gender", "K")){
                    $Sql .= "$con gender='" . $this->getProperty("gender") . "'";
                    $con = ",";
                }
                if($this->isPropertySet("initials", "K")){
                    $Sql .= "$con initials='" . $this->getProperty("initials") . "'";
                    $con = ",";
                }
                if($this->isPropertySet("fullname", "K")){
                    $Sql .= "$con fullname='" . $this->getProperty("fullname") . "'";
                    $con = ",";
                }
                if($this->isPropertySet("email", "K")){
                    $Sql .= "$con email='" . $this->getProperty("email") . "'";
                    $con = ",";
                }
                if($this->isPropertySet("city", "K")){
                    $Sql .= "$con city='" . $this->getProperty("city") . "'";
                    $con = ",";
                }
                if($this->isPropertySet("confirm_cd", "K")){
                    $Sql .= "$con confirm_cd='" . $this->getProperty("confirm_cd") . "'";
                    $con = ",";
                }
                if($this->isPropertySet("status", "K")){
                    $Sql .= "$con status='" . $this->getProperty("status") . "'";
                    $con = ",";
                }
                
                $Sql .= " WHERE 1=1";
                
                if($this->isPropertySet("email", "V"))
            		$Sql .= " AND email='" . $this->getProperty("email") . "'";
				else
					$Sql .= " AND subcriber_cd=" . $this->getProperty("subcriber_cd");
				
                break;
            case "D":
                $Sql = "DELETE  
                        FROM 
                            rs_tbl_subscribers 
                        WHERE
                            1=1";
                
				if($this->isPropertySet("confirm_cd", "V"))
            		$Sql .= " AND confirm_cd='" . $this->getProperty("confirm_cd") . "'";
				else if($this->isPropertySet("email", "V"))
            		$Sql .= " AND email='" . $this->getProperty("email") . "'";
                else if($this->isPropertySet("cds", "V"))
            		$Sql .= " AND subcriber_cd IN(" . $this->getProperty("cds") . ")";
				else
					$Sql .= " AND subcriber_cd=" . $this->getProperty("subcriber_cd");
                break;
            default:
                break;
        }
        return $this->dbQuery($Sql);
    }
    
	/**
    * This function is used to list the Subscribers
    * @author Raju Gautam
    * @Date 20 Dec, 2007
    * @modified 20 Dec, 2007 by Raju Gautam
    */
    public function lstNewsletter(){
        $Sql = "SELECT 
                    newsletter_cd,
                    newsletter_title,
                    newsletter_description,
                    newsletter_file,
                    date
                FROM
                    rs_tbl_newsletter 
                WHERE 
                    1=1";
        if($this->isPropertySet("newsletter_cd", "V"))
            $Sql .= " AND newsletter_cd=" . $this->getProperty("newsletter_cd");
        
        if($this->isPropertySet("limit", "V"))
            $Sql .= $this->appendLimit($this->getProperty("limit"));
        
        $this->dbQuery($Sql);
    }
	
	/**
    * This function is used to perform DML (Delete/Update/Add)
    * @author Numan Tahir
    * @Date 20 Dec, 2007
    * @modified 29 Oct, 2010 by Numan Tahir
    */
    public function actNewsletter($mode = "I"){
        $mode = strtoupper($mode);
        switch($mode){
            case "I":
                $Sql = "INSERT INTO rs_tbl_newsletter(
						newsletter_cd,
                        newsletter_title,
                        newsletter_description,
                        newsletter_file,
                        date) 
                        VALUES(";
                $Sql .= $this->isPropertySet("newsletter_cd", "V") ? "'" . $this->getProperty("newsletter_cd") . "'" : "NULL";
                $Sql .= ",";
				$Sql .= $this->isPropertySet("newsletter_title", "V") ? "'" . $this->getProperty("newsletter_title") . "'" : "NULL";
                $Sql .= ",";
                $Sql .= $this->isPropertySet("newsletter_description", "V") ? "'" . $this->getProperty("newsletter_description") . "'" : "NULL";
                $Sql .= ",";
                $Sql .= $this->isPropertySet("newsletter_file", "V") ? "'" . $this->getProperty("newsletter_file") . "'" : "NULL";
                $Sql .= ",";
                $Sql .= $this->isPropertySet("date", "V") ? "'" . $this->getProperty("date") . "'" : "NULL";                
                $Sql .= ")";
              
//			  echo $Sql;
			    break;
            case "U":
                $Sql = "UPDATE rs_tbl_newsletter SET ";
                if($this->isPropertySet("newsletter_title", "K")){
                    $Sql .= "$con newsletter_title='" . $this->getProperty("newsletter_title") . "'";
                    $con = ",";
                }
                if($this->isPropertySet("newsletter_description", "K")){
                    $Sql .= "$con newsletter_description='" . $this->getProperty("newsletter_description") . "'";
                    $con = ",";
                }
                if($this->isPropertySet("newsletter_file", "K")){
                    $Sql .= "$con newsletter_file='" . $this->getProperty("newsletter_file") . "'";
                    $con = ",";
                }
                $Sql .= " WHERE 1=1";
                if($this->isPropertySet("newsletter_cd", "V")){
            		$Sql .= " AND newsletter_cd='" . $this->getProperty("newsletter_cd") . "'";
				}
				
                break;
            case "D":
                $Sql = "DELETE  
                        FROM 
                            rs_tbl_newsletter 
                        WHERE
                            1=1";
                
				if($this->isPropertySet("newsletter_cd", "V")){
            		$Sql .= " AND newsletter_cd='" . $this->getProperty("newsletter_cd") . "'";
				}
                break;
            default:
                break;
        }
        return $this->dbQuery($Sql);
    }
	
	
	/**
    * This function is used to perform DML (Delete/Update/Add)
    * @author Numan Tahir
    * @Date 20 Dec, 2007
    * @modified 29 Oct, 2010 by Numan Tahir
    */
    public function actNLSubscriberList($mode = "I"){
        $mode = strtoupper($mode);
        switch($mode){
            case "I":
                $Sql = "INSERT INTO rs_tbl_subscriber_list(
						subscriber_id,
                        newsletter_id,
                        date) 
                        VALUES(";
                $Sql .= $this->isPropertySet("subscriber_id", "V") ? "'" . $this->getProperty("subscriber_id") . "'" : "NULL";
                $Sql .= ",";
				$Sql .= $this->isPropertySet("newsletter_id", "V") ? "'" . $this->getProperty("newsletter_id") . "'" : "NULL";
                $Sql .= ",";
                $Sql .= $this->isPropertySet("date", "V") ? "'" . $this->getProperty("date") . "'" : "NULL";
                $Sql .= ")";
                break;
            case "U":
			 $Sql = "UPDATE rs_tbl_subscriber_list SET ";
                if($this->isPropertySet("status", "K")){
                    $Sql .= "$con status='" . $this->getProperty("status") . "'";
                    $con = ",";
                }
                $Sql .= " WHERE 1=1";
                if($this->isPropertySet("subscriber_list_cd", "V")){
            		$Sql .= " AND subscriber_list_cd='" . $this->getProperty("subscriber_list_cd") . "'";
				}
                break;
            case "D":
                $Sql = "DELETE  
                        FROM 
                            rs_tbl_subscriber_list 
                        WHERE
                            1=1";
                
				if($this->isPropertySet("subscriber_list_cd", "V")){
            		$Sql .= " AND subscriber_list_cd='" . $this->getProperty("subscriber_list_cd") . "'";
				}
                break;
            default:
                break;
        }
        return $this->dbQuery($Sql);
    }
	
	/**
    * This function is used to list the Subscribers List
    * @author Numan Tahir
    * @Date 29 Oct, 2010
    * @modified 29 Oct, 2010 by Numan Tahir
    */
    public function lstSubscriberList(){
        $Sql = "SELECT 
                    subscriber_list_cd,
                    subscriber_id,
                    newsletter_id,
                    date,
                    status
                FROM
                    rs_tbl_subscriber_list 
                WHERE 
                    1=1";
        if($this->isPropertySet("status", "V")){
            $Sql .= " AND status=" . $this->getProperty("status");
		}
		if($this->isPropertySet("newsletter_id", "V")){
            $Sql .= " AND newsletter_id=" . $this->getProperty("newsletter_id");
		}
		if($this->isPropertySet("UPTO", "V")){
            $Sql .= " AND subscriber_list_cd > " . $this->getProperty("UPTO");
		}
		
		$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
        if($this->isPropertySet("limit", "V"))
            $Sql .= $this->appendLimit($this->getProperty("limit"));
        
        $this->dbQuery($Sql);
    }
	
    /**
    * This function is used to perform DML (Delete/Update/Add)
    * @author Raju Gautam
    * @Date 20 Dec, 2007
    * @modified 20 Dec, 2007 by Raju Gautam
    */
    public function confirmSubcribe(){
    	$Sql = "UPDATE 
					rs_tbl_subscribers 
				SET 
					status='Y',
					confirm_cd=''
				WHERE 
					1=1 
					AND confirm_cd='" . $this->getProperty("confirm_cd") . "'";
		$this->dbQuery($Sql);
    }
}
?>