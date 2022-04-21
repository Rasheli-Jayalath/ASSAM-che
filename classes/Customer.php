<?php
/**
*
* This is a class Customer
* @version 0.01
* @author Raju Gautam <raju@devraju.com>
* @Date 14 April, 2008
* @modified 14 April, 2008 by Raju Gautam
*
**/
class Customer extends Database{
	public $customer_login;
	public $customer_cd;
	public $email;
	public $fullname;
	public $first_name;
	public $login_time;
	public $eucountries;
	public $ProTmpID;
	/**
	* This is the constructor of the class Customer
	* @author Raju Gautam <raju@devraju.com>
	* @Date 14 April, 2008
	* @modified 14 April, 2008 by Raju Gautam
	*/
	public function __construct(){
		parent::__construct();
		$this->eucountries = array(
									'Austria', 'Belgium', 'Bulgaria', 'Cyprus',
									'Czech Republic', 'Denmark', 'Estonia', 'Finland', 
									'France', 'Germany', 'Greece', 'Hungary', 
									'Ireland', 'Italy', 'Latvia', 'Lithuania', 
									'Luxembourg', 'Malta', 'Netherlands', 'Poland', 'Portugal', 
									'Romania', 'Slovakia', 'Slovenia', 'Spain', 
									'Sweden', 'United Kingdom'
								);
		if($_SESSION['customer_login']){
			$this->customer_login 	= $_SESSION['customer_login'];
			$this->customer_cd 		= $_SESSION['customer_cd'];
			$this->email 			= $_SESSION['email'];
			$this->fullname			= $_SESSION['fullname'];
			$this->login_time		= $_SESSION['login_time'];
			$this->first_name		= $_SESSION['first_name']; 
		}
		if($_SESSION['ProTmpID']){
			$this->ProTmpID			= $_SESSION['ProTmpID'];
		}
	}

	/**
	* This is the function to set the customer logged in
	* @author Raju Gautam
	* @Date 14 April, 2008
	* @modified 14 April, 2008 by Raju Gautam
	*/
	public function setLogin(){
		$_SESSION['customer_login'] 	= true;
		
		# Logged in customer's member code
		if($this->isPropertySet("customer_cd", "V"))
			$_SESSION['customer_cd'] 		= $this->getProperty("customer_cd");
		
		# Logged in customer's email
		if($this->isPropertySet("email", "V"))
			$_SESSION['email'] = $this->getProperty("email");
		
		# Logged in customer's logged in time
		if($this->isPropertySet("login_time", "V"))
			$_SESSION['login_time'] 	= $this->getProperty("login_time");
		
		# Logged in customer's fullname
		if($this->isPropertySet("fullname", "V"))
			$_SESSION['fullname'] = $this->getProperty("fullname");
		
		# Logged in customer's first name
		if($this->isPropertySet("first_name", "V"))
			$_SESSION['first_name'] = $this->getProperty("first_name");
	}
	
	/**
	* This function is used to check whether the customer has been logged in or not.
	* @author Raju Gautam
	* @Date 14 April, 2008
	* @modified 14 April, 2008 by Raju Gautam
	*/
	public function checkLogin(){
		if($this->customer_login){
			return true;
		}
		else{
			return false;
		}
	}
	
	/**
	* This function is used to check the customer login
	* @author Raju Gautam
	* @Date 14 April, 2008
	* @modified 14 April, 2008 by Raju Gautam
	*/
	public function checkCustomerLogin(){
		$Sql = "SELECT 
					customer_cd,
					email,
					password,
					email,
					title,
					first_name,
					last_name,
					CONCAT(first_name,' ',last_name) AS fullname,
					is_active
				FROM
					rs_tbl_customer
				WHERE 
					1=1";
		if($this->isPropertySet("email", "V"))
			$Sql .= " AND email='" . $this->getProperty("email") . "'";
		
		if($this->isPropertySet("password", "V"))
			$Sql .= " AND password='" . $this->getProperty("password") . "'";
		
		return $this->dbQuery($Sql);
	}

	/**
	* This function is used to check the member login
	* @author Raju Gautam
	* @Date 14 April, 2008
	* @modified 14 April, 2008 by Raju Gautam
	*/
	public function customerActivate(){
		$Sql = "UPDATE rs_tbl_customer SET
					is_active=1
				WHERE 
					1=1";
		if($this->isPropertySet("customer_cd", "V"))
			$Sql .= " AND customer_cd=" . $this->getProperty("customer_cd");
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This method is used to populate the customers combo
	* @author Raju Gautam
	* @Date 27 April, 2008
	* @modified 27 April, 2008 by Raju Gautam
	*/
	public function customerCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					customer_cd,
					CONCAT(first_name, ' ', last_name) as fullname
				FROM
					rs_tbl_customer
				WHERE
					1=1 
					AND is_active=1";
		$this->dbQuery($Sql);
		while($rows = $this->dbFetchArray(1)){
			if($rows['customer_cd'] == $sel)
				$opt .= "<option value=\"" . $rows['customer_cd'] . "\" selected>" . $rows['fullname'] . "</option>\n";
			else
				$opt .= "<option value=\"" . $rows['customer_cd'] . "\">" . $rows['fullname'] . "</option>\n";
		}
		return $opt;
	}	
	/**
	* This function is used to list the users
	* @author Raju Gautam
	* @Date 14 April, 2008
	* @modified 14 April, 2008 by Raju Gautam
	*/
	public function lstCustomer(){
		$Sql = "SELECT 
					a.customer_cd,
					a.email,
					a.password,
					a.title,
					a.first_name,
					a.last_name,
					CONCAT(a.first_name,' ',a.last_name) AS fullname,
					a.address_1,
					a.city,
					a.provience,
					a.postal_zip,
					a.day_phone,
					a.mobile,
					a.reg_date,
					a.is_active,
					a.CustomerType,
					a.kvk_number,
					a.tax_number,
					a.company_name,
					a.fax
				FROM
					rs_tbl_customer as a 
					
				WHERE 
					1=1
				";
		
		if($this->isPropertySet("customer_cd", "V"))
			$Sql .= " AND a.customer_cd=" . $this->getProperty("customer_cd");
		
		if($this->isPropertySet("customer_name", "V")){
			$Sql .= " AND (LOWER(a.first_name) LIKE '%" . $this->getProperty("customer_name") . "%' OR LOWER(a.last_name) LIKE '%" . $this->getProperty("customer_name") . "%')";
		}
		if($this->isPropertySet("email", "V"))
			$Sql .= " AND a.email='" . $this->getProperty("email") . "'";
			if($this->isPropertySet("mobile", "V"))
			$Sql .= " AND a.mobile='" . $this->getProperty("mobile") . "'";
		
		//if($this->isPropertySet("is_active", "V"))
		/*if($this->getProperty("is_active")!=''){
			$Sql .= " AND a.is_active='" . $this->getProperty("is_active") ."'";
		}*/
		
		if($this->isPropertySet("is_active", "V"))
			$Sql .= " AND a.is_active=" . $this->getProperty("is_active");
			
		if($this->isPropertySet("ORDER BY", "V"))
		$Sql .= "ORDER BY ". $this->getProperty("ORDER BY");	
		
		if($this->isPropertySet("GROUP BY", "V"))
		$Sql .= "GROUP BY ". $this->getProperty("GROUP BY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		$this->dbQuery($Sql);
		
	}
	
	/**
	* This function is used to perform DML (Delete/Update/Add)
	* @author Raju Gautam
	* @Date 14 April, 2008
	* @modified 14 April, 2008 by Raju Gautam
	*/
	public function delCustomer()
	{
		
		
		$Sql="DELETE FROM rs_tbl_customer WHERE 1=1";
		if($this->isPropertySet("customer_cd", "V"))
					$Sql .= " AND customer_cd='" . $this->getProperty("customer_cd"). "'";
					
		
		return $this->dbQuery($Sql);			
					
	}
	
	public function actCustomer($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_customer(
						customer_cd,
						email,
						password,
						title,
						first_name,
						last_name,
						address_1,
						address_2,
						city,
						provience,
						postal_zip,
						country,
						day_phone,
						mobile,
						reg_date,
						is_active,
						CustomerType,
						kvk_number,
						tax_number,
						company_name,
						fax) 
						VALUES(";
				$Sql .= $this->isPropertySet("customer_cd", "V") ? $this->getProperty("customer_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("email", "V") ? "'" . $this->getProperty("email") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("password", "V") ? "'" . $this->getProperty("password") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("title", "V") ? "'" . $this->getProperty("title") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("first_name", "V") ? "'" . $this->getProperty("first_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("last_name", "V") ? "'" . $this->getProperty("last_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("address_1", "V") ? "'" . $this->getProperty("address_1") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("address_2", "V") ? "'" . $this->getProperty("address_2") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("city", "V") ? "'" . $this->getProperty("city") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("provience", "V") ? "'" . $this->getProperty("provience") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("postal_zip", "V") ? "'" . $this->getProperty("postal_zip") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("country", "V") ? $this->getProperty("country") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("day_phone", "V") ? "'" . $this->getProperty("day_phone") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("mobile", "V") ? "'" . $this->getProperty("mobile") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("reg_date", "V") ? "'" . $this->getProperty("reg_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("is_active", "V") ? $this->getProperty("is_active") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("CustomerType", "V") ? "'" . $this->getProperty("CustomerType") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("kvk_number", "V") ? "'" . $this->getProperty("kvk_number") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("tax_number", "V") ? "'" . $this->getProperty("tax_number") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("company_name", "V") ? "'" . $this->getProperty("company_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("fax", "V") ? "'" . $this->getProperty("fax") . "'" : "NULL";

				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_customer SET ";
				if($this->isPropertySet("email", "K")){
					$Sql .= "$con email='" . $this->getProperty("email") . "'";
					$con = ",";
				}
				if($this->isPropertySet("title", "K")){
					$Sql .= "$con title='" . $this->getProperty("title") . "'";
					$con = ",";
				}
				if($this->isPropertySet("first_name", "K")){
					$Sql .= "$con first_name='" . $this->getProperty("first_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("password", "K")){
					$Sql .= "$con password='" . $this->getProperty("password") . "'";
					$con = ",";
				}
				if($this->isPropertySet("last_name", "K")){
					$Sql .= "$con last_name='" . $this->getProperty("last_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("address_1", "K")){
					$Sql .= "$con address_1='" . $this->getProperty("address_1") . "'";
					$con = ",";
				}
				if($this->isPropertySet("address_2", "K")){
					$Sql .= "$con address_2='" . $this->getProperty("address_2") . "'";
					$con = ",";
				}
				if($this->isPropertySet("city", "K")){
					$Sql .= "$con city='" . $this->getProperty("city") . "'";
					$con = ",";
				}
				if($this->isPropertySet("provience", "K")){
					$Sql .= "$con provience='" . $this->getProperty("provience") . "'";
					$con = ",";
				}
				if($this->isPropertySet("postal_zip", "K")){
					$Sql .= "$con postal_zip='" . $this->getProperty("postal_zip") . "'";
					$con = ",";
				}
				if($this->isPropertySet("country", "K")){
					$Sql .= "$con country=" . $this->getProperty("country");
					$con = ",";
				}
				if($this->isPropertySet("day_phone", "K")){
					$Sql .= "$con day_phone='" . $this->getProperty("day_phone") . "'";
					$con = ",";
				}
				if($this->isPropertySet("mobile", "K")){
					$Sql .= "$con mobile='" . $this->getProperty("mobile") . "'";
					$con = ",";
				}
				if($this->isPropertySet("reg_date", "K")){
					$Sql .= "$con reg_date='" . $this->getProperty("reg_date") . "'";
					$con = ",";
				}
				if($this->isPropertySet("is_active", "K")){
					$Sql .= "$con is_active=" . $this->getProperty("is_active");
					$con = ",";
				}
				if($this->isPropertySet("CustomerType", "K")){
					$Sql .= "$con CustomerType='" . $this->getProperty("CustomerType") . "'";
					$con = ",";
				}
				if($this->isPropertySet("kvk_number", "K")){
					$Sql .= "$con kvk_number='" . $this->getProperty("kvk_number") . "'";
					$con = ",";
				}
				if($this->isPropertySet("tax_number", "K")){
					$Sql .= "$con tax_number='" . $this->getProperty("tax_number") . "'";
					$con = ",";
				}
				if($this->isPropertySet("company_name", "K")){
					$Sql .= "$con company_name='" . $this->getProperty("company_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("fax", "K")){
					$Sql .= "$con fax='" . $this->getProperty("fax") . "'";
					$con = ",";
				}

				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("email", "V"))
					$Sql .= " AND email='" . $this->getProperty("email") . "'";
				else
					$Sql .= " AND customer_cd=" . $this->getProperty("customer_cd");
				break;
			case "D":
				$Sql = "UPDATE rs_tbl_customer SET 
							is_active=0
						WHERE
							1=1";
				$Sql .= " AND customer_cd=" . $this->getProperty("customer_cd");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to perform DML (Delete/Update/Add) on customers shipping info
	* @author Raju Gautam
	* @Date 14 April, 2008
	* @modified 14 April, 2008 by Raju Gautam
	*/
	public function actShippingInfo($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_shippinginfo(
						customer_cd,
						saddress_1,
						saddress_2,
						scity,
						sprovience,
						spostal_zip,
						scountry,
						scontact_phone
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("customer_cd", "V") ? $this->getProperty("customer_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("saddress_1", "V") ? "'" . $this->getProperty("saddress_1") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("saddress_2", "V") ? "'" . $this->getProperty("saddress_2") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("scity", "V") ? "'" . $this->getProperty("scity") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("sprovience", "V") ? "'" . $this->getProperty("sprovience") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("spostal_zip", "V") ? "'" . $this->getProperty("spostal_zip") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("scountry", "V") ? $this->getProperty("scountry") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("scontact_phone", "V") ? "'" . $this->getProperty("scontact_phone") . "'" : "NULL";

				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_shippinginfo SET ";
				if($this->isPropertySet("saddress_1", "K")){
					$Sql .= "$con saddress_1='" . $this->getProperty("saddress_1") . "'";
					$con = ",";
				}
				if($this->isPropertySet("saddress_2", "K")){
					$Sql .= "$con saddress_2='" . $this->getProperty("saddress_2") . "'";
					$con = ",";
				}
				if($this->isPropertySet("scity", "K")){
					$Sql .= "$con scity='" . $this->getProperty("scity") . "'";
					$con = ",";
				}
				if($this->isPropertySet("sprovience", "K")){
					$Sql .= "$con sprovience='" . $this->getProperty("sprovience") . "'";
					$con = ",";
				}
				if($this->isPropertySet("spostal_zip", "K")){
					$Sql .= "$con spostal_zip='" . $this->getProperty("spostal_zip") . "'";
					$con = ",";
				}
				if($this->isPropertySet("scountry", "K")){
					$Sql .= "$con scountry=" . $this->getProperty("scountry");
					$con = ",";
				}
				if($this->isPropertySet("scontact_phone", "K")){
					$Sql .= "$con scontact_phone='" . $this->getProperty("scontact_phone") . "'";
					$con = ",";
				}

				$Sql .= " WHERE 1=1";
				
				$Sql .= " AND customer_cd=" . $this->getProperty("customer_cd");
				break;
			case "D":
				$Sql = "DLETE FROM rs_tbl_shippinginfo 
						WHERE
							1=1";
				$Sql .= " AND customer_cd=" . $this->getProperty("customer_cd");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to check the email address already exists or not.
	* @author Raju Gautam
	* @Date 14 April, 2008
	* @modified 14 April, 2008 by Raju Gautam
	*/
	public function emailExists(){
		$Sql = "SELECT 
					customer_cd,
					email,
					first_name
				FROM
					rs_tbl_customer
				WHERE 
					1=1";
		if($this->isPropertySet("email", "V"))
			$Sql .= " AND email='" . $this->getProperty("email") . "'";
		
		if($this->isPropertySet("customer_cd", "V"))
			$Sql .= " AND customer_cd!=" . $this->getProperty("customer_cd");
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to check current password in change password
	* @author Raju Gautam
	* @Date 24 April, 2008
	* @modified 24 April, 2008 by Raju Gautam
	*/
	public function checkPassword(){
		$Sql = "SELECT
					customer_cd
				FROM
					rs_tbl_customer 
				WHERE 
					1=1";
		$Sql .= " AND email='" . $this->email . "'";
		$Sql .= " AND password='" . $this->getProperty("cpassword") . "'";
		
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1)
			return true;
		else
			return false;
	}
	
	/**
	* This function is used to change the password
	* @author Raju Gautam
	* @Date 24 April, 2008
	* @modified 24 April, 2008 by Raju Gautam
	*/
	public function changePassword(){
		$Sql = "UPDATE rs_tbl_customer SET
					password='" . $this->getProperty("npassword") . "' 
				WHERE 
					1=1";
		$Sql .= " AND email='" . $this->getProperty("email") . "'";
		$Sql .= " AND customer_cd=" . $this->getProperty("customer_cd");
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to prepare the billing address
	* @author Raju Gautam
	* @Date 24 April, 2008
	* @modified 24 April, 2008 by Raju Gautam
	*/
	public function billingAddress($rows, $name = false){
		$str = '';
		if($name)
			$str .= $rows['fullname'] . '<br />';
		$str .= $rows['address_1'] . ' ' . $rows['city'] .  '<br />' . 
				'Phone: ' . $rows['day_phone'] . '<br />' . 
				'E-mail: <a href="mailto:' . $rows['email'] . '">' . $rows['email'] . '</a>';
		
		return $str;
	}
	
	/**
	* This function is used to prepare the shipping address
	* @author Raju Gautam
	* @Date 24 April, 2008
	* @modified 24 April, 2008 by Raju Gautam
	*/
	public function shippingAddress($rows, $flag = false){
		$str = '';
		if($flag)
			$str .= $rows['fullname'] . '<br />';
		$str .= $rows['saddress_1'] . ' ' . $rows['spostal_zip'] .  '<br />' . 
				$rows['scity'] . ', ' . $rows['sprovience'] . '<br />' . 
				$rows['scountry_name'];
		
		return $str;
	}
	
	/**
	* This function is used to prepare the shipping address
	* @author Raju Gautam
	* @Date 24 April, 2008
	* @modified 24 April, 2008 by Raju Gautam
	*/
	public function getShipppingInfo($cust, $cash = false){
		$price = 0;
		$delivery = '';
		if($cust['scountry_name'] == 'Netherlands' && $cash === true){
			$price = 13.50;
			$delivery = ' [2-3 days]';
		}
		else if($cust['scountry_name'] == 'Netherlands' && $cash === false){
			$price = 6.50;
			$delivery = ' [2-3 days]';
		}
		else if(($cust['scountry_name'] == 'Belgium' || $cust['scountry_name'] == 'Luxembourg') && $cash === true){
			$price = 23.00;
			$delivery = ' [3-5 days]';
		}
		else if(in_array($cust['scountry_name'], $this->eucountries)){
			$price = 15.00;
			$delivery = ' [3-5 days]';
		}
		else{
			$price = 22.50;
			$delivery = ' [5-10 days]';
		}
		return array('price'=>$price, 'delivery'=>$delivery);
	}
	
	/**
	* This is the function to set the Temp Request Register
	* @author Numan Tahir
	* @Date 14 April, 2008
	* @modified 14 April, 2008 by Raju Gautam
	*/
	public function settmpReg(){
		
		# Register Product ID
		if($this->isPropertySet("ProTmpID", "V"))
			$_SESSION['ProTmpID'] 		= $this->getProperty("ProTmpID");
	}
	
	/**
	* This is the function to set the Temp Request Un-Register
	* @author Numan Tahir
	* @Date 14 April, 2008
	* @modified 14 April, 2008 by Raju Gautam
	*/
	public function UnRegTmp(){
			
		unset($_SESSION['ProTmpID']);
	
	}
}
?>