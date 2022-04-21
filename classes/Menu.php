<?php
/**
*
* This is a class Menu
* @version 0.01
* @author Raju Gautam  <raju@devraju.com>
* @Date 10 Aug, 2007
* @modified 10 Aug, 2007 by Raju Gautam
*
**/
class Menu extends Database{
	/*
	* This is the constructor of the class Menu
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
	function lstMenu(){
		$Sql = "SELECT
					menu_cd,
					parent_cd,
					menu_title,
					menu_link,
					menu_icon,
					icon_title,
					menu_type
				FROM
					rs_tbl_adminmenu
				WHERE
					1=1";
		if($this->isPropertySet("menu_cd", "V"))
			$Sql .= " AND menu_cd=" . $this->getProperty("menu_cd");
			
		if($this->isPropertySet("menu_type", "V"))
			$Sql .= " AND menu_type=" . $this->getProperty("menu_type");
			
		if($this->isPropertySet("parent_cd", "V"))
			$Sql .= " AND parent_cd=" . $this->getProperty("parent_cd");
		else
			$Sql .= " AND parent_cd=0";
		
		
		if($this->isPropertySet("menu_title", "V"))
			$Sql .= " AND menu_title='" . $this->getProperty("menu_title") . "'";
	$Sql .= "  ORDER BY 
					menu_order ASC ";
		$this->dbQuery($Sql);
	}
	function lstUserMenu()
	{
	$Sql = "SELECT
					a.menu_cd,
					a.parent_cd,
					a.menu_title,
					a.menu_link,
					a.menu_icon,
					a.icon_title,
					b.menu_cd,
					a.menu_type
				FROM
					rs_tbl_adminmenu a inner join mis_tbl_user_rights b on a.menu_cd=b.menu_cd
				WHERE
					1=1";
					if($this->isPropertySet("user_cd", "V"))
			      		$Sql .= " AND user_cd=" . $this->getProperty("user_cd");
				  if($this->isPropertySet("menu_type", "V"))
					$Sql .= " AND menu_type=" . $this->getProperty("menu_type");
					
					$Sql .= "  ORDER BY 
					menu_order ASC ";
				
		return $this->dbQuery($Sql);	
			
	}
	
}
?>