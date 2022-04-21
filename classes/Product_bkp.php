<?php
/**
*
* This is a class Product
* @version 0.01
* @author Raju Gautam <raju@devraju.com>
* @Date 04 April, 2008
* @modified 04 April, 2008 by Raju Gautam
*
**/
class Product extends Database{
	private $_totalSql;
	/**
	* This is the constructor of the class Product
	* @author Raju Gautam  <raju@devraju.com>
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	*/
	
	public function __construct(){
		parent::__construct();
	}
	
	
	
	/*
	* This method is used to get image extension
	* @author Raju Gautam
	* @Date : 30 Dec, 2007
	* @modified : 30 Dec, 2007 by Raju Gautam
	* @return : bool
	*/
	function getFileExtention($type){
		if($type == "application/vnd.ms-excel")
			return "xls";
		elseif($type == "vnd.ms-excel")
			return "xls";
	}
	
	/**
 	* Product::getExcelFilename()	
	* This method is used to get Excel File name
	* @author Numan Tahir
	* @Date : 30 Dec, 2009
	* @modified : 30 Dec, 2009 by Raju Gautam
	* @return : bool
	*/
	public function getExcelFilename($type, $ExcelNo = ''){
		$md5 		= md5(time());
		$filename 	=  substr($md5, rand(5, 25), 5);
		if($ExcelNo != ''){
			$filename = $filename . '-' . $ExcelNo . "." . $this->getFileExtention($type);
		}
		else{
			$filename = $filename . "." . $this->getFileExtention($type);
		}
		return $filename;
	}
	
	/** 
 	* Product::lstCategory()
	* This function is used to list the product categories
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
 	* @return
	*/
	
	public function CategoryOrder(){
		$Sql = "SELECT 
					category_order_id,
					order_by
				FROM
					rs_tbl_category_order";
					
		return $this->dbQuery($Sql);
	}
	
	/** 
 	* Product::lstCategory()
	* This function is used to list the product categories
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
 	* @return
	*/
	
	/*public function lstCategory(){
		$Sql = "SELECT 
					a.category_cd,
					a.parent_cd,
					(SELECT category_name FROM rs_tbl_category WHERE category_cd=a.parent_cd) as parent_cat,
					a.category_name,
					a.url_key,
					a.show_top,
					a.category_status
				FROM
					rs_tbl_category a
				WHERE 
					1=1";
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND a.category_cd=" . $this->getProperty("category_cd");
		
		if($this->isPropertySet("category_name", "V"))
			$Sql .= " AND a.category_name='" . $this->getProperty("category_name") . "'";
		
		if($this->isPropertySet("parent_cd", "K")){
			if($this->getProperty("parent_cd") == "N"){
				$Sql .= " AND a.parent_cd=0";
			}
			else{
				$Sql .= " AND a.parent_cd=" . $this->getProperty("parent_cd");
			}
		}
		if($this->isPropertySet("category_name", "V"))
			$Sql .= " AND a.category_name='" . $this->getProperty("category_name") . "'";
		
		if($this->isPropertySet("url_key", "V"))
			$Sql .= " AND a.url_key='" . $this->getProperty("url_key") . "'";
		
		$Sql .= " ORDER BY category_order ASC, category_name ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}*/
	
	public function lstCategory(){
		$Sql = "SELECT 
					a.category_cd,
					a.parent_cd,
					(SELECT category_name FROM rs_tbl_category WHERE category_cd=a.parent_cd) as parent_cat,
					a.category_name,
					a.category_status
				FROM
					rs_tbl_category a
				WHERE 
					1=1";
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND a.category_cd=" . $this->getProperty("category_cd");
		
		if($this->isPropertySet("category_name", "V"))
			$Sql .= " AND a.category_name='" . $this->getProperty("category_name") . "'";
		
		if($this->isPropertySet("parent_cd", "K")){
			if($this->getProperty("parent_cd") == "N"){
				$Sql .= " AND a.parent_cd=0";
			}
			else{
				$Sql .= " AND a.parent_cd=" . $this->getProperty("parent_cd");
			}
		}
		if($this->isPropertySet("category_name", "V"))
			$Sql .= " AND a.category_name='" . $this->getProperty("category_name") . "'";
		
		if($this->isPropertySet("url_key", "V"))
			$Sql .= " AND a.url_key='" . $this->getProperty("url_key") . "'";
		
		 $Sql .= " ORDER BY category_cd ASC";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	/** 
 	* Product::lstCategory()
	* This function is used to list the product categories
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
 	* @return
	*/
	
	public function lstCategories(){
		$Sql = "SELECT 
					a.category_cd,
					a.parent_cd,
					(SELECT category_name FROM rs_tbl_category WHERE category_cd=a.parent_cd) as parent_cat,
					b.category_name,
					a.category_status,
					a.url_key,
					b.details
				FROM
					rs_tbl_category a 
					INNER JOIN rs_tbl_category_lang as b ON a.category_cd=b.category_cd
				WHERE 
					1=1 
					AND b.language_cd='" . SITE_LANG . "'";
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND a.category_cd=" . $this->getProperty("category_cd");
		
		if($this->isPropertySet("category_name", "V"))
			$Sql .= " AND a.category_name='" . $this->getProperty("category_name") . "'";
		
		if($this->isPropertySet("parent_cd", "K")){
			if($this->getProperty("parent_cd") == "N"){
				$Sql .= " AND a.parent_cd=0";
			}
			else{
				$Sql .= " AND a.parent_cd=" . $this->getProperty("parent_cd");
			}
		}
		
		if($this->isPropertySet("url_key", "V"))
			$Sql .= " AND a.url_key='" . $this->getProperty("url_key") . "'";
		
		if($this->isPropertySet("category_name", "V"))
			$Sql .= " AND a.category_name='" . $this->getProperty("category_name") . "'";

		if($this->isPropertySet("OrderBY", "V")){
		$Sql .= " ORDER BY " . $this->getProperty("OrderBY");
		}
		
		if($this->isPropertySet("ftlimit", "V")){
		$Sql .= " LIMIT " . $this->getProperty("ftlimit");
		}

		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
		}
	
	/** 
 	* Product::lstCategory()
	* This function is used to list the product categories
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
 	* @return
	*/
	
	public function lstTopCategories(){
		$Sql = "SELECT 
					a.category_cd,
					a.parent_cd,
					(SELECT category_name FROM rs_tbl_category WHERE category_cd=a.parent_cd) as parent_cat,
					b.category_name,
					a.category_status,
					a.url_key,
					b.details
				FROM
					rs_tbl_category a 
					INNER JOIN rs_tbl_category_lang as b ON a.category_cd=b.category_cd
				WHERE 
					1=1 
					AND b.language_cd='" . SITE_LANG . "'";
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND a.category_cd=" . $this->getProperty("category_cd");
		
		if($this->isPropertySet("category_name", "V"))
			$Sql .= " AND a.category_name='" . $this->getProperty("category_name") . "'";
		
		if($this->isPropertySet("show_top", "V"))
			$Sql .= " AND a.show_top='" . $this->getProperty("show_top") . "'";	
		
		if($this->isPropertySet("parent_cd", "K")){
			if($this->getProperty("parent_cd") == "N"){
				$Sql .= " AND a.parent_cd=0";
			}
			else{
				$Sql .= " AND a.parent_cd=" . $this->getProperty("parent_cd");
			}
		}
		
		if($this->isPropertySet("url_key", "V"))
			$Sql .= " AND a.url_key='" . $this->getProperty("url_key") . "'";
		
		if($this->isPropertySet("category_name", "V"))
			$Sql .= " AND a.category_name='" . $this->getProperty("category_name") . "'";

		if($this->isPropertySet("OrderBY", "V")){
		$Sql .= " ORDER BY " . $this->getProperty("OrderBY");
		}
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= " limit 0,12";
		if($this->isPropertySet("limit_footer1", "V"))
			$Sql .= " limit 0,6";	
		if($this->isPropertySet("limit_footer2", "V"))
			$Sql .= " limit 6,11";		
			
		//echo $Sql;
		return $this->dbQuery($Sql);
		//return $Sql;
	}
	/** 
 	* Product::lstSubCategory()
	* This function is used to list the product categories
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
 	* @return
	*/
	
	public function lstSubCategories(){
		$Sql = "SELECT
					rs_tbl_sub_category.cat_id
					, rs_tbl_sub_category.status
					, rs_tbl_sub_category.url_key
					, rs_tbl_sub_category_lang.sub_cat_name
					, rs_tbl_sub_category_lang.detail
					, rs_tbl_sub_category_lang.landuage
					, rs_tbl_sub_category.sub_cat_id
				FROM
					rs_tbl_sub_category
					INNER JOIN rs_tbl_sub_category_lang 
        			ON (rs_tbl_sub_category.sub_cat_id = rs_tbl_sub_category_lang.sub_cat_id) 
					AND rs_tbl_sub_category_lang.landuage='" . SITE_LANG . "'";
					
		if($this->isPropertySet("sub_category_id", "V"))
			$Sql .= " AND rs_tbl_sub_category.sub_cat_id=" . $this->getProperty("sub_category_id");
		
		if($this->isPropertySet("sub_category_name", "V"))
			$Sql .= " AND rs_tbl_sub_category_lang.sub_cat_name='" . $this->getProperty("sub_category_name") . "'";

		if($this->isPropertySet("cat_id", "V"))
			$Sql .= " AND rs_tbl_sub_category.cat_id='" . $this->getProperty("cat_id") . "'";
		
		if($this->isPropertySet("url_key", "V"))
			$Sql .= " AND rs_tbl_sub_category.url_key='" . $this->getProperty("url_key") . "'";
		
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND rs_tbl_sub_category.sub_cat_id='" . $this->getProperty("category_cd") . "'";
		
		if($this->isPropertySet("sub_category_name", "V"))
			$Sql .= " ANDrs_tbl_sub_category_lang.sub_cat_name='" . $this->getProperty("sub_category_name") . "'";
		
		if($this->isPropertySet("SubCat_id", "V"))
			$Sql .= " AND rs_tbl_sub_category.sub_cat_id=" . $this->getProperty("SubCat_id");
		
		$Sql .= " ORDER BY rs_tbl_sub_category_lang.sub_cat_name ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		//printPre($Sql);
		return $this->dbQuery($Sql);
	}
	
	/** 
 	* Product::lstSubCategory()
	* This function is used to list the product categories
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
 	* @return
	*/
	
	public function lstMainCategory(){
		$Sql = "select 
							rs_tbl_category_lang.category_name,
							rs_tbl_products.product_id,
							rs_tbl_product_lang.product_name,
							rs_tbl_product_lang.product_desc,
							rs_tbl_products.product_price,
							rs_tbl_products.is_active,
							rs_tbl_products.url_key,
							rs_tbl_products.image_name,
							rs_tbl_products.product_sale_price,
							rs_tbl_sub_category.sub_cat_id
						from 
						rs_tbl_category, 
						rs_tbl_category_lang,
						rs_tbl_sub_category, 
						rs_tbl_sub_category_lang,
						rs_tbl_products,
						rs_tbl_product_lang
						where 1=1
						AND rs_tbl_category.category_cd=rs_tbl_sub_category.cat_id 
						AND rs_tbl_sub_category.sub_cat_id=rs_tbl_products.category_cd
						AND rs_tbl_category.category_cd=rs_tbl_category_lang.category_cd
						AND rs_tbl_sub_category.sub_cat_id=rs_tbl_sub_category_lang.sub_cat_id
						AND rs_tbl_products.product_id=rs_tbl_product_lang.product_id
						AND rs_tbl_category_lang.language_cd='" . SITE_LANG . "'
						AND rs_tbl_sub_category_lang.landuage='" . SITE_LANG . "'
						AND rs_tbl_product_lang.language_cd='" . SITE_LANG . "'";
					
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND rs_tbl_category.category_cd=" . $this->getProperty("category_cd");
			
		if($this->isPropertySet("is_active", "V"))
			$Sql .= " AND rs_tbl_products.is_active=" . $this->getProperty("is_active");
		
//		$Sql .= " ORDER BY rs_tbl_sub_category_lang.sub_cat_name ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		//printPre($Sql);
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::getTotalProducts()	
	* This function is used to get the total records
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean 	
	*/
	function getTotalCatProducts(){
		$Sql = "select 
							COUNT(rs_tbl_products.product_id) As total_records 
						from 
						rs_tbl_category, 
						rs_tbl_category_lang,
						rs_tbl_sub_category, 
						rs_tbl_sub_category_lang,
						rs_tbl_products,
						rs_tbl_product_lang
						where 1=1
						AND rs_tbl_category.category_cd=rs_tbl_sub_category.cat_id 
						AND rs_tbl_sub_category.sub_cat_id=rs_tbl_products.category_cd
						AND rs_tbl_category.category_cd=rs_tbl_category_lang.category_cd
						AND rs_tbl_sub_category.sub_cat_id=rs_tbl_sub_category_lang.sub_cat_id
						AND rs_tbl_products.product_id=rs_tbl_product_lang.product_id
						AND rs_tbl_category_lang.language_cd='" . SITE_LANG . "'
						AND rs_tbl_sub_category_lang.landuage='" . SITE_LANG . "'
						AND rs_tbl_product_lang.language_cd='" . SITE_LANG . "'";
					
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND (a.category_cd=" . $this->getProperty("category_cd") . " OR a.category_cd IN(SELECT category_cd FROM rs_tbl_category WHERE parent_cd=" . $this->getProperty("category_cd") . "))";
	
		if($this->isPropertySet("search", "V"))
			$Sql .= " AND a.product_name LIKE '%" . $this->getProperty("search") . "%'";
		
		if($this->isPropertySet("is_front", "V"))
			$Sql .= " AND a.is_front=" . $this->getProperty("is_front");
		
		if($this->isPropertySet("is_promo", "V"))
			$Sql .= " AND a.is_promo='" . $this->getProperty("is_promo") . "'";
		
		return $this->getTotal($Sql);
	}
	
	/** 
 	* Product::lstCategory()
	* This function is used to list the product categories
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
 	* @return
	*/
	
	public function lstSubCategory(){
		$Sql = "SELECT 
					*
				FROM
					rs_tbl_sub_category 
				WHERE 
					1=1";
		if($this->isPropertySet("sub_cat_id", "V"))
			$Sql .= " AND sub_cat_id=" . $this->getProperty("sub_cat_id");
		
		if($this->isPropertySet("sub_cat_name", "V"))
			$Sql .= " AND sub_cat_name='" . $this->getProperty("sub_cat_name") . "'";
		
		if($this->isPropertySet("cat_id", "V"))
			$Sql .= " AND cat_id='" . $this->getProperty("cat_id") . "'";
		
		if($this->isPropertySet("url_key", "V"))
			$Sql .= " AND url_key='" . $this->getProperty("url_key") . "'";
		
		$Sql .= " ORDER BY sub_cat_name ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	
	
	/*
		public function lstComponent(){
		$Sql = "SELECT 
					*
				FROM
					components
				WHERE 
					1=1";
		if($this->isPropertySet("cid", "V"))
			$Sql .= " AND cid=" . $this->getProperty("cid");
		
		
		
		$Sql .= " ORDER BY cid ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}*/
	
	/** 
 	* Product::checkCategory()
	* This function is used to check category name
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
 	* @return
	*/
	
	public function checkCategory(){
		$Sql = "SELECT 
					category_cd
				FROM
					rs_tbl_category
				WHERE 
					1=1";
		if($this->isPropertySet("category_name", "V"))
			$Sql .= " AND category_name='" . $this->getProperty("category_name") . "'";
		if($this->isPropertySet("parent_cd", "V"))
			$Sql .= " AND parent_cd='" . $this->getProperty("parent_cd") . "'";
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND category_cd!=" . $this->getProperty("category_cd");		
		
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	
	
	public function AccountCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					a.cat_id,
					a.category_title
				FROM
					rs_tbl_account_type a
				WHERE 
					1=1 
				ORDER BY 
					a.category_title ASC";
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($sel == $rows['cat_id']) ? " selected" : "";
				$opt .= "<option value=\"" . $rows['cat_id'] . "\" " . $sele . ">" . $rows['category_title'] . "</option>\n";
			}
		}
		return $opt;
	}
	/**
	* Product::catCombo()
	* This function is used to list the product categories combo
	* @author Raju Gautam
	* @Date 06 April, 2008
	* @modified 06 April, 2008 by Raju Gautam
  	* @return string 	
	*/
	public function catCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					a.category_cd,
					a.category_name
				FROM
					rs_tbl_category a
				WHERE 
					1=1 
				ORDER BY 
					a.category_name ASC";
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($sel == $rows['category_cd']) ? " selected" : "";
				$opt .= "<option value=\"" . $rows['category_cd'] . "\" " . $sele . ">" . $rows['category_name'] . "</option>\n";
			}
		}
		return $opt;
	}
	
	/**
  	* Product::actCategoryOrder()
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_category the basis of property set
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @param mixed $mode
	* @modified 04 April, 2008 by Raju Gautam
 	* @return boolean
	*/
	public function actCategoryOrder($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "U":
				$Sql = "UPDATE rs_tbl_category_order SET ";

				if($this->isPropertySet("order_by", "K")){
					$Sql .= "$cat order_by='" . $this->getProperty("order_by") . "'";
					$cat = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND category_order_id=" . $this->getProperty("category_order_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
  	* Product::actCategory()
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_category the basis of property set
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @param mixed $mode
	* @modified 04 April, 2008 by Raju Gautam
 	* @return boolean
	*/
	public function actCategory($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_category(
						category_cd,
						parent_cd,
						category_name,
						
						category_status) 
						VALUES(";
				$Sql .= $this->isPropertySet("category_cd", "V") ? $this->getProperty("category_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("parent_cd", "V") ? $this->getProperty("parent_cd") : 0;
				$Sql .= ",";
				$Sql .= $this->isPropertySet("category_name", "V") ? "'" . $this->getProperty("category_name") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("category_status", "V") ? "'" . $this->getProperty("category_status") . "'" : "1";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_category SET ";
			//	if($this->isPropertySet("parent_cd", "K")){
			//		$Sql .= "$cat parent_cd=" . $this->getProperty("parent_cd");
			//		$cat = ",";
			//	}
				if($this->isPropertySet("category_name", "K")){
					$Sql .= "$cat category_name='" . $this->getProperty("category_name") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("url_key", "K")){
					$Sql .= "$cat url_key='" . $this->getProperty("url_key") . "'";
					$cat = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND category_cd=" . $this->getProperty("category_cd");
				break;
			case "D":
				$Sql .= "DELETE FROM rs_tbl_category WHERE 1=1 ";
				$Sql .= " AND category_cd=" . $this->getProperty("category_cd");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	
	/**
  	* Product::actCategory()
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_category the basis of property set
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @param mixed $mode
	* @modified 04 April, 2008 by Raju Gautam
 	* @return boolean
	*/
	public function actSubCategory($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_sub_category(
						sub_cat_id,
						sub_cat_name,
						cat_id,
						url_key,
						status) 
						VALUES(";
				$Sql .= $this->isPropertySet("sub_cat_id", "V") ? $this->getProperty("sub_cat_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("sub_cat_name", "V") ? "'" . $this->getProperty("sub_cat_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cat_id", "V") ? "'" . $this->getProperty("cat_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("url_key", "V") ? "'" . $this->getProperty("url_key") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("status", "V") ? "'" . $this->getProperty("status") . "'" : "1";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_sub_category SET ";

				if($this->isPropertySet("sub_cat_name", "K")){
					$Sql .= "$cat sub_cat_name='" . $this->getProperty("sub_cat_name") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("url_key", "K")){
					$Sql .= "$cat url_key='" . $this->getProperty("url_key") . "'";
					$cat = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND sub_cat_id=" . $this->getProperty("sub_cat_id");
				break;
			case "D":
				$Sql .= "DELETE FROM rs_tbl_sub_category WHERE 1=1 ";
				$Sql .= " AND sub_cat_id=" . $this->getProperty("scat_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	/**
	* Product::lstProducts()	
	* This function is used to list the products
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean 	
	*/
	public function lstProducts(){
		$Sql = "SELECT 
					a.product_id,
					a.product_cd,
					a.category_cd,
					(SELECT category_name FROM rs_tbl_category WHERE category_cd=a.category_cd) as category_name,
					a.window_cd,
					(SELECT window_title FROM rs_tbl_windows WHERE window_id=a.window_cd) as 
					window_name,
					a.product_name,
					a.product_code,
					a.product_weight,
					a.prodct_descritpion,
					a.product_date,
					a.product_cost_price ,
					a.product_sale_price,
					a.is_sold,
					a.is_active,
					a.image_name
				FROM
					rs_tbl_products a 
				WHERE 
					1=1";
		
		if($this->isPropertySet("product_id", "V"))
			$Sql .= " AND a.product_id='" . $this->getProperty("product_id") . "'";
			
			if($this->isPropertySet("product_name", "V"))
			$Sql .= " AND a.product_name='" . $this->getProperty("product_name") . "'";
		
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND (a.category_cd=" . $this->getProperty("category_cd") . " OR a.category_cd IN(SELECT category_cd FROM rs_tbl_category WHERE parent_cd=" . $this->getProperty("category_cd") . "))";
		
		if($this->isPropertySet("is_active", "V"))
			$Sql .= " AND a.is_active=" . $this->getProperty("is_active");
			
		if($this->isPropertySet("is_sold", "V"))
			$Sql .= " AND a.is_sold='" . $this->getProperty("is_sold"). "'";
			
			if($this->isPropertySet("from_dt", "V") && $this->isPropertySet("to_dt", "V")){
			$Sql .= " AND LEFT(a.product_date, 10) BETWEEN '" . $this->getProperty("from_dt") . "' 
			AND '" . $this->getProperty("to_dt") . "'";
		}
		
		if($this->isPropertySet("search", "V")){
			$Sql .= " AND a.product_name LIKE '%" . $this->getProperty("search") . "%' OR a.product_code LIKE '%".$this->getProperty("search")."%'";
		}
		if($this->isPropertySet("window_cd", "V")){
			$Sql .= " AND a.window_cd LIKE " . $this->getProperty("window_cd") ;
		}
		if($this->isPropertySet("title", "V")){
			$Sql .= " ORDER BY a.product_name " . $this->getProperty("title");
			
		}  elseif($this->isPropertySet("priceasc", "V")){
					$Sql .= " ORDER BY a.product_sale_price " . $this->getProperty("priceasc");
					
		} elseif($this->isPropertySet("pricedesc", "V")){
					$Sql .= " ORDER BY a.product_sale_price " . $this->getProperty("pricedesc");					

		} elseif($this->isPropertySet("dateasc", "V")){
					$Sql .= " ORDER BY a.product_date " . $this->getProperty("dateasc");
		} elseif($this->isPropertySet("datedesc", "V")){
					$Sql .= " ORDER BY a.product_date " . $this->getProperty("datedesc");
		} 
		elseif($this->isPropertySet("weightasc", "V")){
					$Sql .= " ORDER BY a.product_weight " . $this->getProperty("weightasc");
		}
		elseif($this->isPropertySet("weightdesc", "V")){
					$Sql .= " ORDER BY a.product_weight " . $this->getProperty("weightdesc");
		} 
		elseif($this->isPropertySet("category_title", "V")){
					$Sql .= " ORDER BY category_name " . $this->getProperty("category_title");
		}
		elseif($this->isPropertySet("location", "V")){
					$Sql .= " ORDER BY window_name " . $this->getProperty("location");
		}
		elseif($this->isPropertySet("weight", "V")){
					$Sql .= " ORDER BY a.product_weight " . $this->getProperty("weight");
		}
		 else {
					$Sql .= " ORDER BY a.product_date DESC";
		}
		$this->_totalSql = $Sql;
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	public function lstDiamonds(){
		$Sql = "SELECT 
					a.di_id,
					a.window_cd,
					(SELECT window_title FROM rs_tbl_windows WHERE window_id=a.window_cd) as 
					window_name,
					a.di_name,
					a.di_code,
					a.di_cc,
					a.di_weight,
					a.di_gold_weight,
					a.di_date,
					a.di_cost_price ,
					a.di_sale_price,
					a.is_sold
					
				FROM
					rs_tbl_diamonds a 
				WHERE 
					1=1";
		
		if($this->isPropertySet("di_id", "V"))
			$Sql .= " AND a.di_id='" . $this->getProperty("di_id") . "'";
			
			if($this->isPropertySet("di_name", "V"))
			$Sql .= " AND a.di_name='" . $this->getProperty("di_name") . "'";
		
		
		if($this->isPropertySet("is_sold", "V"))
			$Sql .= " AND a.is_sold='" . $this->getProperty("is_sold"). "'";
			
			if($this->isPropertySet("from_dt", "V") && $this->isPropertySet("to_dt", "V")){
			$Sql .= " AND LEFT(a.di_date, 10) BETWEEN '" . $this->getProperty("from_dt") . "' 
			AND '" . $this->getProperty("to_dt") . "'";
		}
		
		if($this->isPropertySet("search", "V")){
			$Sql .= " AND a.di_name LIKE '%" . $this->getProperty("search") . "%' OR a.di_code LIKE '%".$this->getProperty("search") ."%'";
		}
		if($this->isPropertySet("window_cd", "V")){
			$Sql .= " AND a.window_cd LIKE " . $this->getProperty("window_cd") ;
		}
		if($this->isPropertySet("title", "V")){
			$Sql .= " ORDER BY a.di_name " . $this->getProperty("title");
			
		}  elseif($this->isPropertySet("priceasc", "V")){
					$Sql .= " ORDER BY a.di_sale_price " . $this->getProperty("priceasc");
					
		} elseif($this->isPropertySet("pricedesc", "V")){
					$Sql .= " ORDER BY a.di_sale_price " . $this->getProperty("pricedesc");					

		} elseif($this->isPropertySet("dateasc", "V")){
					$Sql .= " ORDER BY a.di_date " . $this->getProperty("dateasc");
		} elseif($this->isPropertySet("datedesc", "V")){
					$Sql .= " ORDER BY a.di_date " . $this->getProperty("datedesc");
		} 
		elseif($this->isPropertySet("weightasc", "V")){
					$Sql .= " ORDER BY a.di_weight " . $this->getProperty("weightasc");
		}
		elseif($this->isPropertySet("weightdesc", "V")){
					$Sql .= " ORDER BY a.di_weight " . $this->getProperty("weightdesc");
		}  
		elseif($this->isPropertySet("location", "V")){
					$Sql .= " ORDER BY window_name " . $this->getProperty("location");
		}
		elseif($this->isPropertySet("weight", "V")){
					$Sql .= " ORDER BY a.di_weight " . $this->getProperty("weight");
		}
		elseif($this->isPropertySet("gweight", "V")){
					$Sql .= " ORDER BY a.di_gold_weight " . $this->getProperty("gweight");
		}
		elseif($this->isPropertySet("code", "V")){
					$Sql .= " ORDER BY a.di_code " . $this->getProperty("code");
		}
		elseif($this->isPropertySet("cc", "V")){
					$Sql .= " ORDER BY a.di_cc " . $this->getProperty("cc");
		}
		elseif($this->isPropertySet("cost", "V")){
					$Sql .= " ORDER BY a.di_cost_price " . $this->getProperty("cost");
		}
		elseif($this->isPropertySet("sale", "V")){
					$Sql .= " ORDER BY a.di_sale_price " . $this->getProperty("sale");
		}
		else {
					$Sql .= " ORDER BY a.di_date DESC";
		}
		$this->_totalSql = $Sql;
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::lstPartners()	
	* This function is used to list the products
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean 	
	*/
	public function lstPartners(){
		$Sql = "SELECT 
					a.partner_cd,
					a.title,
					a.description,
					(SELECT link FROM rs_tbl_partners_lang WHERE partner_cd=a.partner_cd AND language_cd='EN') as link,
					a.logo,
					a.date,
					a.status,
					a.url_key
				FROM
					rs_tbl_partners a
				WHERE 
					1=1";
		
		if($this->isPropertySet("partner_cd", "V"))
			$Sql .= " AND a.partner_cd='" . $this->getProperty("partner_cd") . "'";
		
		if($this->isPropertySet("title", "V"))
			$Sql .= " AND a.title=" . $this->getProperty("title");
		
		if($this->isPropertySet("status", "V"))
			$Sql .= " AND a.status=" . $this->getProperty("status");
		
		$this->_totalSql = $Sql;
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	/**
	* Product::actPartnerImage()	
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_partners the basis of property set
	* @author Numan Tahir
	* @Date 15 April, 2010
 	* @param string $mode	
	* @modified 15 April, 2010 by Numan Tahir
 	* @return boolean
	*/
	public function actPartnerImage($mode){
		$mode = strtoupper($mode);
		switch($mode){
			
			case "U":
				$Sql = "UPDATE rs_tbl_partners SET ";
				if($this->isPropertySet("image_name", "K")){
					$Sql .= "logo='" . $this->getProperty("image_name")."'";
				}
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("partner_cd", "V")){
					$Sql .= " AND partner_cd='" . $this->getProperty("partner_cd") . "'";
				}
				break;
			case "D":
				$Sql = "UPDATE rs_tbl_partners SET ";
				$Sql .= "logo='' WHERE 1=1";
				if($this->isPropertySet("partner_cd", "V")){
					$Sql .= " AND partner_cd='" . $this->getProperty("partner_cd") . "'";
				}
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	
	
	public function actProductImage($mode){
		$mode = strtoupper($mode);
		switch($mode){
			
			case "U":
				$Sql = "UPDATE rs_tbl_partners SET ";

				if($this->isPropertySet("image_name", "K")){
					$Sql .= "logo='" . $this->getProperty("image_name")."'";
				}
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("partner_cd", "V")){
					$Sql .= " AND partner_cd='" . $this->getProperty("partner_cd") . "'";
				}
				break;
			case "D":
				$Sql = "UPDATE rs_tbl_partners SET ";
				$Sql .= "image_name='' WHERE 1=1";
				if($this->isPropertySet("partner_cd", "V")){
					$Sql .= " AND partner_cd='" . $this->getProperty("partner_cd") . "'";
				}
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	
	
	/**
	* Product::lstPartnerImages()		
	* This function is used to list the products images
	* @author Numan Tahir
	* @Date 15 April, 2010
	* @modified 15 April, 2010 by Numan Tahir
 	* @return boolean	
	*/
	public function lstPartnerImages(){
		$Sql = "SELECT 
					partner_cd, 
					logo 
					FROM
					rs_tbl_partners 
					WHERE 1=1";
					
		if($this->isPropertySet("partner_cd", "V"))
			$Sql .= " AND partner_cd='" . $this->getProperty("partner_cd") . "'";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::lstPartnerLangs()	
	* This function is used to list the Partner
	* @author Numan Tahir
	* @Date 15 April, 2010
	* @modified 15 April, 2010 by Numan Tahir
	* @return boolean 	
	*/
	public function lstPartnerLangs(){
		$Sql = "SELECT 
					b.partner_cd,
					b.language_cd,
					(SELECT lang_name FROM rs_tbl_langs WHERE lang_short=b.language_cd) as language_name,
					b.title,
					b.description,
					b.link
				FROM
					rs_tbl_partners a 
					INNER JOIN rs_tbl_partners_lang AS b ON a.partner_cd=b.partner_cd
				WHERE 
					1=1";
		
		if($this->isPropertySet("partner_cd", "V"))
			$Sql .= " AND b.partner_cd='" . $this->getProperty("partner_cd") . "'";
		
		if($this->isPropertySet("language_cd", "V"))
			$Sql .= " AND b.language_cd='" . $this->getProperty("language_cd") . "'";
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::getTotalPartners()	
	* This function is used to get the total records
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean 	
	*/
	function getTotalPartners(){
		$Sql = "SELECT 
					COUNT(partner_cd) As total_records 
				FROM 
					rs_tbl_partners as a
				WHERE 
					1=1";

		if($this->isPropertySet("search", "V"))
			$Sql .= " AND a.title LIKE '%" . $this->getProperty("search") . "%'";
		
		return $this->getTotal($Sql);
	}
	/**
	* Product::actPartner()	
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_products the basis of property set
	* @author Numan Tahir
 	* @param mixed $mode
	* @Date 15 April, 2010
	* @modified 15 April, 2010 by Numan Tahir
 	* @return boolean	
	*/
	public function actPartner($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_partners(
						partner_cd,
						title,
						description,
						date,
						status,
						url_key) 
						VALUES( ";
				$Sql .= $this->isPropertySet("partner_cd", "V") ? $this->getProperty("partner_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("title", "V") ? "'" . $this->getProperty("title") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("description", "V") ? "'" . $this->getProperty("description") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("date", "V") ? "'" . $this->getProperty("date") . "'" : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("status", "V") ? $this->getProperty("status") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("url_key", "V") ? "'" . $this->getProperty("url_key") . "'" : "";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_partners SET ";
				if($this->isPropertySet("title", "K")){
					$Sql .= "$cat title='" . $this->getProperty("title") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("description", "K")){
					$Sql .= "$cat description='" . $this->getProperty("description") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("link", "K")){
					$Sql .= "$cat link='" . $this->getProperty("link") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("date", "K")){
					$Sql .= "$cat date='" . $this->getProperty("date") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("status", "K")){
					$Sql .= "$cat status='" . $this->getProperty("status") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("url_key", "K")){
					$Sql .= "$cat url_key='" . $this->getProperty("url_key") . "'";
					$cat = ",";
				}
				
				$Sql .= " WHERE 1=1";
				if($this->isPropertySet("partner_cd", "K")){
					$Sql .= " AND partner_cd=" . $this->getProperty("partner_cd");
				}
				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_partners 
						WHERE
							1=1";
				$Sql .= " AND partner_cd='" . $this->getProperty("partner_cd") . "'";
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::actPartnerLang()	
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_partners_lang the basis of property set
	* @author Numan Tahir
	* @Date 15 April, 2010
 	* @param string $mode	
	* @modified 15 April, 2010 by Numan Tahir
 	* @return boolean
	*/
	public function actPartnerLang($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_partners_lang(
						partner_cd,
						title,
						description,
						language_cd,
						link) 
						VALUES(";
				$Sql .= $this->isPropertySet("partner_cd", "V") ? "'" . $this->getProperty("partner_cd") . "'" : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("title", "V") ? "'" . $this->getProperty("title") . "'" : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("description", "V") ? "'" . $this->getProperty("description") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("language_cd", "V") ? "'" . $this->getProperty("language_cd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("link", "V") ? "'" . $this->getProperty("link") . "'" : "NULL";
				$Sql .= ")";
				break;
			case "U":
				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_partners_lang 
						WHERE
							1=1";
				$Sql .= " AND partner_cd='" . $this->getProperty("partner_cd") . "'";
				break;
			default:
				break;
		}
		echo $Sql;
		return $this->dbQuery($Sql);
	}
	/**
	* Product::lstProducts()	
	* This function is used to list the products
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean 	
	*/
	public function lstProducts_SubCat(){
		$Sql = "SELECT 
					a.product_id,
					a.product_cd,
					a.category_cd,
					(SELECT sub_cat_name FROM rs_tbl_sub_category WHERE sub_cat_id=a.category_cd) as category_name,
					a.brand_cd,
					(SELECT brand_name FROM rs_tbl_brands WHERE brand_cd=a.brand_cd) as brand_name,
					a.color_cd,
					(SELECT color_name FROM rs_tbl_colors WHERE color_cd=a.color_cd) as color_name,
					a.series_cd,
					(SELECT brand_name FROM rs_tbl_brands WHERE brand_cd=a.series_cd) as series_name,
					a.delivery_cd,
					(SELECT delivery_name FROM rs_tbl_deliveries WHERE delivery_cd=a.delivery_cd) as delivery_name,
					a.discount_group,
					a.product_name,
					a.prodct_descritpion,
					a.product_date,
					a.product_price,
					a.product_sale_price,
					a.is_sale,
					a.is_promo,
					a.is_front,
					a.flash,
					a.is_active,
					a.excel_pro,
					a.url_key,
					a.topten,
					a.flash,
					(SELECT image_name FROM rs_tbl_product_images WHERE product_cd=a.product_cd AND is_primary=1) as image_name
				FROM
					rs_tbl_products a 
				WHERE 
					1=1 ";
		
		if($this->isPropertySet("product_id", "V"))
			$Sql .= " AND a.product_id='" . $this->getProperty("product_id") . "'";
		
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND (a.category_cd=" . $this->getProperty("category_cd") . " OR a.category_cd IN(SELECT category_cd FROM rs_tbl_category WHERE parent_cd=" . $this->getProperty("category_cd") . "))";
		
		if($this->isPropertySet("brand_cd", "V"))
			$Sql .= " AND a.brand_cd=" . $this->getProperty("brand_cd");
		
		if($this->isPropertySet("series_cd", "V"))
			$Sql .= " AND a.series_cd=" . $this->getProperty("series_cd");
		
		if($this->isPropertySet("delivery_cd", "V"))
			$Sql .= " AND a.delivery_cd=" . $this->getProperty("delivery_cd");
		
		if($this->isPropertySet("is_front", "V"))
			$Sql .= " AND a.is_front=" . $this->getProperty("is_front");
		
		if($this->isPropertySet("is_sale", "V"))
			$Sql .= " AND a.is_sale='" . $this->getProperty("is_sale") . "'";
		
		if($this->isPropertySet("is_promo", "V"))
			$Sql .= " AND a.is_promo='" . $this->getProperty("is_promo") . "'";
		
		if($this->isPropertySet("is_active", "V"))
			$Sql .= " AND a.is_active=" . $this->getProperty("is_active");
		
		if($this->isPropertySet("excel_pro", "V"))
			$Sql .= " AND a.excel_pro=" . $this->getProperty("excel_pro");
		
		if($this->isPropertySet("search", "V")){
			$Sql .= " AND a.product_name LIKE '%" . $this->getProperty("search") . "%'";
		}
		
		if($this->isPropertySet("topten", "V"))
			$Sql .= " AND a.topten=" . $this->getProperty("topten");

		if($this->isPropertySet("flash", "V"))
			$Sql .= " AND a.flash=" . $this->getProperty("flash");

		$this->_totalSql = $Sql;
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::getTotalProducts()	
	* This function is used to get the total records
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean 	
	*/
	function getTotalProducts(){
		$Sql = "SELECT 
					COUNT(product_id) As total_records 
				FROM 
					rs_tbl_products as a
				WHERE 
					1=1";
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND (a.category_cd=" . $this->getProperty("category_cd") . " OR a.category_cd IN(SELECT category_cd FROM rs_tbl_category WHERE parent_cd=" . $this->getProperty("category_cd") . "))";
	
		if($this->isPropertySet("search", "V"))
			$Sql .= " AND a.product_name LIKE '%" . $this->getProperty("search") . "%'";
		
		if($this->isPropertySet("is_front", "V"))
			$Sql .= " AND a.is_front=" . $this->getProperty("is_front");
		
		if($this->isPropertySet("is_promo", "V"))
			$Sql .= " AND a.is_promo='" . $this->getProperty("is_promo") . "'";
		
		
		
		return $this->getTotal($Sql);
	}
	
	/**
	* Product::lstProduct()	
	* This function is used to list the products
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean 	
	*/
	public function lstProduct(){
	
		/*$Sql = "SELECT 
					a.product_id,
					a.product_cd,
					a.category_cd,
					(SELECT 
						rs_tbl_category_lang.category_name 
					FROM 
						rs_tbl_category 
						INNER JOIN rs_tbl_category_lang ON rs_tbl_category.category_cd=rs_tbl_category_lang.category_cd
					WHERE 
						rs_tbl_category_lang.category_cd=a.category_cd 
						AND rs_tbl_category_lang.language_cd='EN'
					) AS category_name,
					a.brand_cd,
					a.color_cd,
					(SELECT 
						rs_tbl_color_lang.color_name 
					FROM 
						rs_tbl_colors 
						INNER JOIN rs_tbl_color_lang ON rs_tbl_color_lang.color_cd=rs_tbl_colors.color_cd
					WHERE 
						rs_tbl_color_lang.color_cd=a.color_cd 
						AND rs_tbl_color_lang.language_cd='" . SITE_LANG . "'
					) AS color_name,
					a.series_cd,
					(SELECT brand_name FROM rs_tbl_brands WHERE brand_cd=a.series_cd) as series_name,
					a.delivery_cd,
					(SELECT delivery_name FROM rs_tbl_deliveries WHERE delivery_cd=a.delivery_cd) as delivery_name,
					a.discount_group,
					b.product_name,
					b.product_desc AS prodct_descritpion,
					a.product_date,
					a.product_price,
					a.product_sale_price,
					a.is_sale,
					a.is_promo,
					a.is_front,
					a.is_active,
					a.image_name
				FROM
					rs_tbl_products a 
					INNER JOIN rs_tbl_product_lang b ON a.product_cd=b.product_cd
				WHERE 
					1=1 
					AND b.language_cd='" . SITE_LANG . "'";*/
					
		$Sql = "SELECT
				rs_tbl_category_lang.language_cd
				, rs_tbl_products.product_name    
				, rs_tbl_products.product_price
				, rs_tbl_products.product_id
				, rs_tbl_products.brand_cd
				, rs_tbl_products.color_cd
				, rs_tbl_products.delivery_cd
				, rs_tbl_products.series_cd
				
				, rs_tbl_products.product_sale_price
				, rs_tbl_products.prodct_descritpion
				, rs_tbl_products.product_date
				, rs_tbl_products.is_promo
				, rs_tbl_products.is_front
				, rs_tbl_products.is_sale
				, rs_tbl_products.product_cd
				, rs_tbl_products.url_key
				, rs_tbl_products.old_product_id
				, rs_tbl_products.image_name				
				, rs_tbl_products.old_image_id
				, rs_tbl_products.old_image_ext
				, rs_tbl_category_lang.category_cd
				, rs_tbl_category_lang.category_name
				, rs_tbl_category_lang.details
				
				FROM
					rs_tbl_category_lang
					INNER JOIN rs_tbl_category 
						ON (rs_tbl_category_lang.category_cd = rs_tbl_category.category_cd) 
						AND (rs_tbl_category_lang.language_cd = '". SITE_LANG ."')
					INNER JOIN rs_tbl_products 
						ON (rs_tbl_products.category_cd = rs_tbl_category.category_cd) WHERE 1=1"; 
					
					/*if($this->isPropertySet("product_cd", "V"))
			$Sql .= " AND a.product_cd='" . $this->getProperty("product_cd") . "'";
		
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND (a.category_cd=" . $this->getProperty("category_cd") . " OR a.category_cd IN(SELECT category_cd FROM rs_tbl_category WHERE parent_cd=" . $this->getProperty("category_cd") . "))";
		
		if($this->isPropertySet("brand_cd", "V"))
			$Sql .= " AND a.brand_cd=" . $this->getProperty("brand_cd");
		
		if($this->isPropertySet("series_cd", "V"))
			$Sql .= " AND a.series_cd=" . $this->getProperty("series_cd");
		
		if($this->isPropertySet("delivery_cd", "V"))
			$Sql .= " AND a.delivery_cd=" . $this->getProperty("delivery_cd");
		
		if($this->isPropertySet("is_front", "V"))
			$Sql .= " AND a.is_front=" . $this->getProperty("is_front");
		
		if($this->isPropertySet("is_sale", "V"))
			$Sql .= " AND a.is_sale='" . $this->getProperty("is_sale") . "'";
		
		if($this->isPropertySet("url_key", "V"))
			$Sql .= " AND a.url_key='" . $this->getProperty("url_key") . "'";
		
		if($this->isPropertySet("is_promo", "V"))
			$Sql .= " AND a.is_promo='" . $this->getProperty("is_promo") . "'";
		
		if($this->isPropertySet("is_active", "V"))
			$Sql .= " AND a.is_active=" . $this->getProperty("is_active");
		
		if($this->isPropertySet("search", "V")){
			$Sql .= " AND (b.product_name LIKE '%" . $this->getProperty("search") . "%' OR a.product_cd='" . $this->getProperty("search") . "')";
		}
		
		if($this->isPropertySet("price", "V")){
			$Sql .= " ORDER BY a.product_price " . $this->getProperty("price");
		}*/
		
	//	$Sql = "SELECT * FROM rs_tbl_products WHERE 1=1";
		
		if($this->isPropertySet("product_id", "V"))
			$Sql .= " AND rs_tbl_products.product_id='" . $this->getProperty("product_id") . "'";
		
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND rs_tbl_category_lang.category_cd='" . $this->getProperty("category_cd"). "'";
		
		if($this->isPropertySet("brand_cd", "V"))
			$Sql .= " AND rs_tbl_products.brand_cd=" . $this->getProperty("brand_cd");
		
		if($this->isPropertySet("series_cd", "V"))
			$Sql .= " AND rs_tbl_products.series_cd=" . $this->getProperty("series_cd");
		
		if($this->isPropertySet("delivery_cd", "V"))
			$Sql .= " AND rs_tbl_products.delivery_cd=" . $this->getProperty("delivery_cd");
		
		if($this->isPropertySet("is_front", "V"))
			$Sql .= " AND rs_tbl_products.is_front=" . $this->getProperty("is_front");
		
		if($this->isPropertySet("is_sale", "V"))
			$Sql .= " AND rs_tbl_products.is_sale='" . $this->getProperty("is_sale") . "'";
		
		if($this->isPropertySet("url_key", "V"))
			$Sql .= " AND rs_tbl_products.url_key='" . $this->getProperty("url_key") . "'";
		
		if($this->isPropertySet("is_promo", "V"))
			$Sql .= " AND rs_tbl_products.is_promo='" . $this->getProperty("is_promo") . "'";
		
		if($this->isPropertySet("is_active", "V"))
			$Sql .= " AND rs_tbl_products.is_active=" . $this->getProperty("is_active");
		
		if($this->isPropertySet("search", "V")){
			$Sql .= " AND (product_name LIKE '%" . $this->getProperty("search") . "%' OR product_cd='" . $this->getProperty("search") . "')";
		}
		
		if($this->isPropertySet("Name", "V")){
			$Sql .= " ORDER BY product_name " . $this->getProperty("Name");
			
		} elseif($this->isPropertySet("price", "V")){
					$Sql .= " ORDER BY product_price " . $this->getProperty("price");
					
		} elseif($this->isPropertySet("Date", "V")){
					$Sql .= " ORDER BY product_date " . $this->getProperty("Date");
		} else {
					$Sql .= " ORDER BY product_id DESC";
		}
		
		//if(C_PAGE=='index.php'){
		//$Sql .= " LIMIT 0,12";
		//} else 
		if($this->isPropertySet("limit", "V")){
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		}
		//return $Sql;
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::lstProduct()	
	* This function is used to list the products
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean 	
	*/
	public function lstProduct_test(){
	
		$Sql = "SELECT 
						a.product_id,
						a.product_cd,
						a.category_cd,
						(SELECT 
							rs_tbl_sub_category_lang.sub_cat_name 
						FROM 
							rs_tbl_sub_category 
							INNER JOIN rs_tbl_sub_category_lang ON rs_tbl_sub_category.sub_cat_id=rs_tbl_sub_category_lang.sub_cat_id
						WHERE 
							rs_tbl_sub_category_lang.sub_cat_id=a.category_cd 
							AND rs_tbl_sub_category_lang.landuage='" . SITE_LANG . "'
						) AS sub_cat_name,
						a.brand_cd,
						a.color_cd,
						a.series_cd,
						a.delivery_cd,
						a.discount_group,
						b.product_name,
						b.product_desc AS prodct_descritpion,
						a.product_date,
						a.product_price,
						a.product_sale_price,
						a.is_sale,
						a.is_promo,
						a.is_front,
						a.is_active,
						a.image_name
					FROM
						rs_tbl_products a 
						INNER JOIN rs_tbl_product_lang b ON a.product_cd=b.product_cd
					WHERE 
						1=1 
						AND b.language_cd='" . SITE_LANG . "'";
					
					
		if($this->isPropertySet("product_cd", "V"))
			$Sql .= " AND a.product_cd='" . $this->getProperty("product_cd") . "'";
		
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND (a.category_cd=" . $this->getProperty("category_cd");
		
		if($this->isPropertySet("brand_cd", "V"))
			$Sql .= " AND a.brand_cd=" . $this->getProperty("brand_cd");
		
		if($this->isPropertySet("series_cd", "V"))
			$Sql .= " AND a.series_cd=" . $this->getProperty("series_cd");
		
		if($this->isPropertySet("delivery_cd", "V"))
			$Sql .= " AND a.delivery_cd=" . $this->getProperty("delivery_cd");
		
		if($this->isPropertySet("is_front", "V"))
			$Sql .= " AND a.is_front=" . $this->getProperty("is_front");
		
		if($this->isPropertySet("is_sale", "V"))
			$Sql .= " AND a.is_sale='" . $this->getProperty("is_sale") . "'";
		
		if($this->isPropertySet("url_key", "V"))
			$Sql .= " AND a.url_key='" . $this->getProperty("url_key") . "'";
		
		if($this->isPropertySet("is_promo", "V"))
			$Sql .= " AND a.is_promo='" . $this->getProperty("is_promo") . "'";
		
		if($this->isPropertySet("is_active", "V"))
			$Sql .= " AND a.is_active=" . $this->getProperty("is_active");
		
		if($this->isPropertySet("search", "V")){
			$Sql .= " AND (b.product_name LIKE '%" . $this->getProperty("search") . "%' OR a.product_cd='" . $this->getProperty("search") . "')";
		}
		
		if($this->isPropertySet("price", "V")){
			$Sql .= " ORDER BY a.product_price " . $this->getProperty("price");
		}
		
		
		if($this->isPropertySet("limit", "V")){
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		}

		return $this->dbQuery($Sql);
	}
	/**
	* Product::lstProductSubCat()	
	* This function is used to list the products
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean 	
	*/
	
	
	public function lstflashproducts1()
	{
		$sql = "SELECT * FROM rs_tbl_products ";
		if($this->isPropertySet("category_cd", "V"))
		{	
			$Sql .= " AND rs_tbl_products.category_cd='" . $this->getProperty("category_cd"). "'";
		}
		if($this->isPropertySet("pro_image", "V"))
		{	
			$Sql .= " AND rs_tbl_products.image_name!=''";	
		}	
		if($this->isPropertySet("limit", "V"))
		{
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		}
		print $Sql;
		return $this->dbQuery($Sql);
	}
	public function lstProductSubCat_list(){
		$Sql = "SELECT 
						rs_tbl_products.product_id,
						rs_tbl_products.product_cd,
						rs_tbl_products.category_cd as sub_cat_id,
						(SELECT 
							rs_tbl_sub_category.sub_cat_name 
						FROM 
							rs_tbl_sub_category 
							INNER JOIN rs_tbl_sub_category_lang ON rs_tbl_sub_category.sub_cat_id=rs_tbl_sub_category_lang.sub_cat_id
						WHERE 
							rs_tbl_sub_category_lang .sub_cat_id=rs_tbl_products.category_cd 
							AND rs_tbl_sub_category_lang.landuage='". SITE_LANG ."'
						) AS sub_cat_name,
						rs_tbl_products.brand_cd,
						rs_tbl_products.color_cd,
						(SELECT 
							rs_tbl_color_lang.color_name 
						FROM 
							rs_tbl_colors 
							INNER JOIN rs_tbl_color_lang ON rs_tbl_color_lang.color_cd=rs_tbl_colors.color_cd
						WHERE 
							rs_tbl_color_lang.color_cd=rs_tbl_products.color_cd 
							AND rs_tbl_color_lang.language_cd='". SITE_LANG ."'
						) AS color_name,
						rs_tbl_products.series_cd,
						(SELECT brand_name FROM rs_tbl_brands WHERE brand_cd=rs_tbl_products.series_cd) as series_name,
						rs_tbl_products.delivery_cd,
						(SELECT delivery_name FROM rs_tbl_deliveries WHERE delivery_cd=rs_tbl_products.delivery_cd) as delivery_name,
						
						rs_tbl_product_lang.product_name,
						rs_tbl_product_lang.product_desc AS prodct_descritpion,
						rs_tbl_products.product_date,
						rs_tbl_products.product_price,
						rs_tbl_products.product_sale_price,
						rs_tbl_products.is_sale,
						rs_tbl_products.is_promo,
						rs_tbl_products.is_front,
						rs_tbl_products.is_active,
						rs_tbl_products.image_name,
						rs_tbl_products.url_key,
						rs_tbl_products.topten,
						rs_tbl_products.flash
					FROM
						rs_tbl_products
						INNER JOIN rs_tbl_product_lang ON rs_tbl_products.product_cd=rs_tbl_product_lang.product_cd
					WHERE 
						1=1 
						AND rs_tbl_product_lang.language_cd='". SITE_LANG ."'"; 
						
					
		
		if($this->isPropertySet("product_id", "V"))
			$Sql .= " AND rs_tbl_products.product_id='" . $this->getProperty("product_id") . "'";
		
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND rs_tbl_products.category_cd='" . $this->getProperty("category_cd"). "'";
		
		if($this->isPropertySet("brand_cd", "V"))
			$Sql .= " AND rs_tbl_products.brand_cd=" . $this->getProperty("brand_cd");
		
		if($this->isPropertySet("series_cd", "V"))
			$Sql .= " AND rs_tbl_products.series_cd=" . $this->getProperty("series_cd");
		
		if($this->isPropertySet("delivery_cd", "V"))
			$Sql .= " AND rs_tbl_products.delivery_cd=" . $this->getProperty("delivery_cd");
		
		if($this->isPropertySet("is_front", "V"))
			$Sql .= " AND rs_tbl_products.is_front=" . $this->getProperty("is_front");
		
		if($this->isPropertySet("is_sale", "V"))
			$Sql .= " AND rs_tbl_products.is_sale='" . $this->getProperty("is_sale") . "'";
		
		if($this->isPropertySet("url_key", "V"))
			$Sql .= " AND rs_tbl_products.url_key='" . $this->getProperty("url_key") . "'";
		
		if($this->isPropertySet("is_promo", "V"))
			$Sql .= " AND rs_tbl_products.is_promo='" . $this->getProperty("is_promo") . "'";
		
		if($this->isPropertySet("is_active", "V"))
			$Sql .= " AND rs_tbl_products.is_active=" . $this->getProperty("is_active");

		if($this->isPropertySet("pro_image", "V"))
			$Sql .= " AND rs_tbl_products.image_name!=''";

		if($this->isPropertySet("search", "V")){
			$Sql .= " AND (rs_tbl_product_lang.product_name LIKE '%" . $this->getProperty("search") . "%' OR rs_tbl_products.product_cd='" . $this->getProperty("search") . "')";
		}
		if($this->isPropertySet("topten", "V"))
			$Sql .= " AND rs_tbl_products.topten='" . $this->getProperty("topten") . "'";
		if($this->isPropertySet("flash", "V"))
			$Sql .= " AND rs_tbl_products.flash='" . $this->getProperty("flash") . "'";
		if($this->isPropertySet("Name", "V")){
			$Sql .= " ORDER BY rs_tbl_product_lang.product_name " . $this->getProperty("Name");
		} 
		elseif($this->isPropertySet("price", "V")){
					$Sql .= " ORDER BY rs_tbl_products.product_price " . $this->getProperty("price");
		} elseif($this->isPropertySet("Date", "V")){
					$Sql .= " ORDER BY rs_tbl_products.product_date " . $this->getProperty("Date");
		} else {
					$Sql .= " ORDER BY rs_tbl_products.product_id DESC";
		}
		
		//$Sql .= " GROUP BY rs_tbl_products.product_id ";
		//if(C_PAGE=='index.php'){
		//$Sql .= " LIMIT 0,12";
		//} else {
		if($this->isPropertySet("limit", "V")){
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		}
		return $this->dbQuery($Sql);
	}
	function lstflashproducts()
	{
			
			$Sql = "SELECT * FROM rs_tbl_products WHERE flash='1'";
			return $this->dbQuery($Sql);
	}
	
	function replaceSpecialCharacters($string)
	{
	$find 		= array(' ', '_', '&', '%', "'", '"', '(', ')', '[', ']', '.', ',', '/', '\\', '=', '+');
	$replace 	= '';
	$key 		= str_replace($find, $replace, strtolower($string));
	return $key;
	}
	
	/**
	* Product::LstProImgXML()	
	* This function is used to list the products
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean 	
	*/
	public function LstProImgXML(){
		
			 $Sql = "SELECT 
						rs_tbl_products.product_id,
						rs_tbl_products.product_cd,
						rs_tbl_products.category_cd as sub_cat_id,
						(SELECT 
							rs_tbl_sub_category.sub_cat_name 
						FROM 
							rs_tbl_sub_category 
							INNER JOIN rs_tbl_sub_category_lang ON rs_tbl_sub_category.sub_cat_id=rs_tbl_sub_category_lang.sub_cat_id
						WHERE 
							rs_tbl_sub_category_lang .sub_cat_id=rs_tbl_products.category_cd 
							AND rs_tbl_sub_category_lang.landuage='". SITE_LANG ."'
						) AS sub_cat_name,
						rs_tbl_products.brand_cd,
						rs_tbl_products.color_cd,
						(SELECT 
							rs_tbl_color_lang.color_name 
						FROM 
							rs_tbl_colors 
							INNER JOIN rs_tbl_color_lang ON rs_tbl_color_lang.color_cd=rs_tbl_colors.color_cd
						WHERE 
							rs_tbl_color_lang.color_cd=rs_tbl_products.color_cd 
							AND rs_tbl_color_lang.language_cd='". SITE_LANG ."'
						) AS color_name,
						rs_tbl_products.series_cd,
						(SELECT brand_name FROM rs_tbl_brands WHERE brand_cd=rs_tbl_products.series_cd) as series_name,
						rs_tbl_products.delivery_cd,
						(SELECT delivery_name FROM rs_tbl_deliveries WHERE delivery_cd=rs_tbl_products.delivery_cd) as delivery_name,
						
						rs_tbl_product_lang.product_name,
						rs_tbl_product_lang.product_desc AS prodct_descritpion,
						rs_tbl_products.product_date,
						rs_tbl_products.product_price,
						rs_tbl_products.product_sale_price,
						rs_tbl_products.is_sale,
						rs_tbl_products.is_promo,
						rs_tbl_products.is_front,
						rs_tbl_products.is_active,
						rs_tbl_products.image_name,
						rs_tbl_products.url_key,
						rs_tbl_products.topten,
						rs_tbl_products.flash
					FROM
						rs_tbl_products
						INNER JOIN rs_tbl_product_lang ON rs_tbl_products.product_cd=rs_tbl_product_lang.product_cd
					WHERE 
						1=1 
						AND rs_tbl_product_lang.language_cd='". SITE_LANG ."'"; 
		
		if($this->isPropertySet("product_id", "V"))
			$Sql .= " AND rs_tbl_products.product_id='" . $this->getProperty("product_id") . "'";
		
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND rs_tbl_products.category_cd='" . $this->getProperty("category_cd"). "'";
		
		if($this->isPropertySet("brand_cd", "V"))
			$Sql .= " AND rs_tbl_products.brand_cd=" . $this->getProperty("brand_cd");
		
		if($this->isPropertySet("series_cd", "V"))
			$Sql .= " AND rs_tbl_products.series_cd=" . $this->getProperty("series_cd");
		
		if($this->isPropertySet("delivery_cd", "V"))
			$Sql .= " AND rs_tbl_products.delivery_cd=" . $this->getProperty("delivery_cd");
		
		if($this->isPropertySet("is_front", "V"))
			$Sql .= " AND rs_tbl_products.is_front=" . $this->getProperty("is_front");
		
		if($this->isPropertySet("is_sale", "V"))
			$Sql .= " AND rs_tbl_products.is_sale='" . $this->getProperty("is_sale") . "'";
		
		if($this->isPropertySet("url_key", "V"))
			$Sql .= " AND rs_tbl_products.url_key='" . $this->getProperty("url_key") . "'";
		
		if($this->isPropertySet("is_promo", "V"))
			$Sql .= " AND rs_tbl_products.is_promo='" . $this->getProperty("is_promo") . "'";
		
		if($this->isPropertySet("is_active", "V"))
			$Sql .= " AND rs_tbl_products.is_active=" . $this->getProperty("is_active");
		
		if($this->isPropertySet("pro_image", "V"))
			$Sql .= " AND rs_tbl_products.image_name!=''";
			
		if($this->isPropertySet("Name", "V")){
			$Sql .= " ORDER BY rs_tbl_product_lang.product_name " . $this->getProperty("Name");
		
		if($this->isPropertySet("topten", "V"))
			$Sql .= " AND rs_tbl_products.topten=" . $this->getProperty("topten");
		
		if($this->isPropertySet("flash", "V"))
			$Sql .= " AND rs_tbl_products.flash=" . $this->getProperty("flash");

		} elseif($this->isPropertySet("price", "V")){
					$Sql .= " ORDER BY rs_tbl_products.product_price " . $this->getProperty("price");
					
		} elseif($this->isPropertySet("Date", "V")){
					$Sql .= " ORDER BY rs_tbl_products.product_date " . $this->getProperty("Date");
		} else {
					$Sql .= " ORDER BY rs_tbl_products.product_id DESC";
		}
		
		if($this->isPropertySet("limit", "V")){
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::lstSalesProduct()	
	* This function is used to list the products
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean 	
	*/
	public function lstSalesProduct(){
	
		$Sql = "SELECT 
					a.product_id,
					a.product_cd,
					a.category_cd,
					(SELECT 
						rs_tbl_category_lang.category_name 
					FROM 
						rs_tbl_category 
						INNER JOIN rs_tbl_category_lang ON rs_tbl_category.category_cd=rs_tbl_category_lang.category_cd
					WHERE 
						rs_tbl_category_lang.category_cd=a.category_cd 
						AND rs_tbl_category_lang.language_cd='" . SITE_LANG . "'
					) AS category_name,
					a.brand_cd,
					a.color_cd,
					(SELECT 
						rs_tbl_color_lang.color_name 
					FROM 
						rs_tbl_colors 
						INNER JOIN rs_tbl_color_lang ON rs_tbl_color_lang.color_cd=rs_tbl_colors.color_cd
					WHERE 
						rs_tbl_color_lang.color_cd=a.color_cd 
						AND rs_tbl_color_lang.language_cd='" . SITE_LANG . "'
					) AS color_name,
					a.series_cd,
					(SELECT brand_name FROM rs_tbl_brands WHERE brand_cd=a.series_cd) as series_name,
					a.delivery_cd,
					(SELECT delivery_name FROM rs_tbl_deliveries WHERE delivery_cd=a.delivery_cd) as delivery_name,
					a.discount_group,
					b.product_name,
					b.product_desc AS prodct_descritpion,
					a.product_date,
					a.product_price,
					a.product_sale_price,
					a.is_sale,
					a.is_promo,
					a.is_front,
					a.is_active,
					a.image_name,
					a.topten,
					a.flash
				FROM
					rs_tbl_products a 
					INNER JOIN rs_tbl_product_lang b ON a.product_cd=b.product_cd
				WHERE 
					1=1 
					AND b.language_cd='" . SITE_LANG . "'";
					
		/*$Sql = "SELECT * FROM rs_tbl_products WHERE 1=1";*/
		if($this->isPropertySet("is_sale", "V"))
			$Sql .= " AND is_sale='" . $this->getProperty("is_sale") . "'";
		if($this->isPropertySet("is_active", "V"))
			$Sql .= " AND is_active='" . $this->getProperty("is_active") . "'";

		if($this->isPropertySet("topten", "V"))
			$Sql .= " AND topten='" . $this->getProperty("topten") . "'";
		
		if($this->isPropertySet("flash", "V"))
			$Sql .= " AND flash='" . $this->getProperty("flash") . "'";
			
		//$Sql .= " ORDER BY RAND()";
			$Sql .= " GROUP BY a.product_id";
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::getTotalProducts()	
	* This function is used to get the total records
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean 	
	*/
	function getTotalProduct(){
		$Sql = "SELECT 
					COUNT(product_id) As total_records 
				FROM 
					rs_tbl_products as a
				WHERE 
					1=1";
		/*if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND (a.category_cd=" . $this->getProperty("category_cd") . " OR a.category_cd IN(SELECT category_cd FROM rs_tbl_category WHERE parent_cd=" . $this->getProperty("category_cd") . "))";*/
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND a.category_cd=" . $this->getProperty("category_cd");
	
		if($this->isPropertySet("search", "V")){
			$Sql .= " AND (a.product_name LIKE '%" . $this->getProperty("search") . "%' OR a.product_cd='" . $this->getProperty("search") . "')";
		}
		
		if($this->isPropertySet("brand_cd", "V"))
			$Sql .= " AND a.brand_cd=" . $this->getProperty("brand_cd");
		
		if($this->isPropertySet("series_cd", "V"))
			$Sql .= " AND a.series_cd=" . $this->getProperty("series_cd");
		
		if($this->isPropertySet("delivery_cd", "V"))
			$Sql .= " AND a.delivery_cd=" . $this->getProperty("delivery_cd");
		
		if($this->isPropertySet("is_active", "V"))
			$Sql .= " AND a.is_active=" . $this->getProperty("is_active");
		
		if($this->isPropertySet("is_sale", "V"))
			$Sql .= " AND a.is_sale='" . $this->getProperty("is_sale") . "'";
		
		if($this->isPropertySet("is_promo", "V"))
			$Sql .= " AND a.is_promo='" . $this->getProperty("is_promo") . "'";

		if($this->isPropertySet("topten", "V"))
			$Sql .= " AND a.topten='" . $this->getProperty("topten") . "'";
			
		if($this->isPropertySet("flash", "V"))
			$Sql .= " AND a.flash='" . $this->getProperty("flash") . "'";
		
		return $this->getTotal($Sql);
	}
	
	/**
	* Product::actProduct()	
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_products the basis of property set
	* @author Raju Gautam
 	* @param mixed $mode
	* @Date 07 April, 2008
	* @modified 07 April, 2008 by Raju Gautam
 	* @return boolean	
	*/
	public function actProduct($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_products(
						product_id,
						product_cd,
						category_cd,
						product_name,
						product_code,
						product_weight,
						prodct_descritpion,
						product_date,
						is_active,
						is_sold,
						window_cd,
						image_name
						) 
						VALUES( ";
				$Sql .= $this->isPropertySet("product_id", "V") ? $this->getProperty("product_id") : 
				"NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_cd", "V") ? "'" . $this->getProperty(
				"product_cd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("category_cd", "V") ? $this->getProperty("category_cd") 
				: "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_name", "V") ? "'" . $this->getProperty(
				"product_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_code", "V") ? "'" .$this->getProperty(
				"product_code") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_weight", "V") ? "'" . $this->getProperty(
				"product_weight") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("prodct_descritpion", "V") ? "'" . $this->getProperty(
				"prodct_descritpion") . "'" : 
				"NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_date", "V") ? "'" . $this->getProperty(
				"product_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("is_active", "V") ? "'" . $this->getProperty("is_active"
				) . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("is_sold", "V") ? "'" . $this->getProperty("is_sold") . 
				"'" : "'N'";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("window_cd", "V") ? $this->getProperty("window_cd") : 
				"NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("image_name", "V") ? "'" .$this->getProperty("image_name") ."'" : 
				"NULL";
				echo $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_products SET ";
				if($this->isPropertySet("category_cd", "K")){
					$Sql .= "$cat category_cd=" . $this->getProperty("category_cd");
					$cat = ",";
				}
				
				if($this->isPropertySet("product_name", "K")){
					$Sql .= "$cat product_name='" . $this->getProperty("product_name") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("product_code", "K")){
					$Sql .= "$cat product_code='" . $this->getProperty("product_code") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("product_weight", "K")){
					$Sql .= "$cat product_weight='" . $this->getProperty("product_weight") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("prodct_descritpion", "K")){
					$Sql .= "$cat prodct_descritpion='" . $this->getProperty("prodct_descritpion") . 
					"'";
					$cat = ",";
				}
				if($this->isPropertySet("product_date", "K")){
					$Sql .= "$cat product_date='" . $this->getProperty("product_date") . "'";
					$cat = ",";
				}
			
				if($this->isPropertySet("is_active", "K")){
					$Sql .= "$cat is_active=" . $this->getProperty("is_active");
					$cat = ",";
				}
				if($this->isPropertySet("is_sold", "K")){
					$Sql .= "$cat is_sold='" . $this->getProperty("is_sold") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("window_cd", "K")){
					$Sql .= "$cat window_cd='" . $this->getProperty("window_cd"). "'";
					$cat = ",";
				}
				if($this->isPropertySet("product_sale_price", "K")){
				$Sql .= "$cat product_sale_price='" . $this->getProperty("product_sale_price"). "'";
					$cat = ",";
				}
				if($this->isPropertySet("product_cost_price", "K")){
				$Sql .= "$cat product_cost_price='" . $this->getProperty("product_cost_price"). "'";
				
				}
                if($this->isPropertySet("image_name", "K")){
				$Sql .= "$cat image_name='" . $this->getProperty("image_name"). "'";
				
				}
				$Sql .= " WHERE 1=1";
				if($this->isPropertySet("product_cds", "V")){
					$Sql .= " AND product_cd IN(" . $this->getProperty("product_cds") . ")";
				}
				else{
					echo $Sql .= " AND product_id='" . $this->getProperty("product_id") . "'";
				}
				break;
			case "P":
				$Sql = "UPDATE rs_tbl_products SET 
							is_promo='" . $this->getProperty("is_promo") . "' 
						WHERE
							1=1";
				if($this->isPropertySet("product_cds", "V")){
					$Sql .= " AND product_cd IN(" . $this->getProperty("product_cds") . ")";
				}
				else{
					$Sql .= " AND product_cd='" . $this->getProperty("product_cd") . "'";
				}
				
				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_products 
						WHERE
							1=1";
				$Sql .= " AND product_id='" . $this->getProperty("product_id") . "'";
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::actDiamond()	
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_products the basis of property set
	* @author Mobina Zafar
 	* @param mixed $mode
	* @Date 01 Feb, 2012
	* @modified 01 Feb, 2012 by Mobina Zafar
 	* @return boolean	
	*/
	public function actDiamond($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_diamonds(
						di_id,
						di_name,
						di_code,
						di_cc,
						di_weight,
						di_gold_weight,
						di_date,
						di_cost_price,
						di_sale_price,
						is_sold,
						window_cd
						) 
						VALUES( ";
			   $Sql .= $this->isPropertySet("di_id", "V") ? $this->getProperty("di_id") : 
				"NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("di_name", "V") ? "'" . $this->getProperty(
				"di_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("di_code", "V") ? "'" .$this->getProperty(
				"di_code") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("di_cc", "V") ? "'" .$this->getProperty(
				"di_cc") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("di_weight", "V") ? "'" . $this->getProperty(
				"di_weight") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("di_gold_weight", "V") ? "'" . $this->getProperty(
				"di_gold_weight") . "'" : 
				"NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("di_date", "V") ? "'" . $this->getProperty(
				"di_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("di_cost_price", "V") ? "'" . $this->getProperty(
				"di_cost_price") . "'" : 
				"NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("di_sale_price", "V") ? "'" . $this->getProperty(
				"di_sale_price") . "'" : 
				"NULL";
				$Sql .= ",";
				
			   $Sql .= $this->isPropertySet("is_sold", "V") ? "'" . $this->getProperty("is_sold") . 
				"'" : "'N'";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("window_cd", "V") ? $this->getProperty("window_cd") : 
				"NULL";
				echo $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_diamonds SET ";
				
				if($this->isPropertySet("di_name", "K")){
					$Sql .= "$cat di_name='" . $this->getProperty("di_name") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("di_code", "K")){
					$Sql .= "$cat di_code='" . $this->getProperty("di_code") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("di_cc", "K")){
					$Sql .= "$cat di_cc='" . $this->getProperty("di_cc") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("di_weight", "K")){
					$Sql .= "$cat di_weight='" . $this->getProperty("di_weight") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("di_gold_weight", "K")){
					$Sql .= "$cat di_gold_weight='" . $this->getProperty("di_gold_weight") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("di_date", "K")){
					$Sql .= "$cat di_date='" . $this->getProperty("di_date") . 
					"'";
					$cat = ",";
				}
				if($this->isPropertySet("is_sold", "K")){
					$Sql .= "$cat is_sold='" . $this->getProperty("is_sold") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("window_cd", "K")){
					$Sql .= "$cat window_cd='" . $this->getProperty("window_cd"). "'";
					$cat = ",";
				}
				

				$Sql .= " WHERE 1=1";
				if($this->isPropertySet("di_id", "V")){
					
				 $Sql .= " AND di_id='" . $this->getProperty("di_id") . "'";
				}
				break;
			case "P":
				$Sql = "UPDATE rs_tbl_products SET 
							is_promo='" . $this->getProperty("is_promo") . "' 
						WHERE
							1=1";
				if($this->isPropertySet("product_cds", "V")){
					$Sql .= " AND product_cd IN(" . $this->getProperty("product_cds") . ")";
				}
				else{
					$Sql .= " AND product_cd='" . $this->getProperty("product_cd") . "'";
				}
				
				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_diamonds
						WHERE
							1=1";
				$Sql .= " AND di_id='" . $this->getProperty("di_id") . "'";
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::actProduct()	
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_products the basis of property set
	* @author Raju Gautam
 	* @param mixed $mode
	* @Date 07 April, 2008
	* @modified 07 April, 2008 by Raju Gautam
 	* @return boolean	
	*/
	public function actImportProduct(){
				$Sql = "INSERT INTO rs_tbl_products(
						product_id,
						product_cd,
						category_cd,
						brand_cd,
						color_cd,
						series_cd,
						delivery_cd,
						discount_group,
						product_name,
						product_price,
						product_sale_price,
						prodct_descritpion,
						product_date,
						is_promo,
						is_front,
						is_active,
						is_sale,
						url_key,
						excel_pro,
						topten,
						flash) 
						VALUES( ";
				$Sql .= $this->isPropertySet("product_id", "V") ? $this->getProperty("product_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_cd", "V") ? "'" . $this->getProperty("product_cd") . "'" : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("category_cd", "V") ? $this->getProperty("category_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("brand_cd", "V") ? $this->getProperty("brand_cd") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("color_cd", "V") ? $this->getProperty("color_cd") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("series_cd", "V") ? $this->getProperty("series_cd") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("delivery_cd", "V") ? $this->getProperty("delivery_cd") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("discount_group", "V") ? "'" . $this->getProperty("discount_group") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_name", "V") ? "'" . $this->getProperty("product_name") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_price", "V") ? $this->getProperty("product_price") : "0.0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_sale_price", "V") ? $this->getProperty("product_sale_price") : "0.0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("prodct_descritpion", "V") ? "'" . $this->getProperty("prodct_descritpion") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_date", "V") ? "'" . $this->getProperty("product_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("is_promo", "V") ? "'" . $this->getProperty("is_promo") . "'" : "'N'";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("is_front", "V") ? $this->getProperty("is_front") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("is_active", "V") ? $this->getProperty("is_active") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("is_sale", "V") ? "'" . $this->getProperty("is_sale") . "'" : "'N'";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("url_key", "V") ? "'" . $this->getProperty("url_key") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("excel_pro", "V") ? $this->getProperty("excel_pro") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("topten", "V") ? $this->getProperty("topten") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("flash", "V") ? $this->getProperty("flash") : "0";
				$Sql .= ")";
				mysql_query($Sql) or die(mysql_error());
		
//		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::lstImages()		
	* This function is used to list the products images
	* @author Raju Gautam
	* @Date 08 April, 2008
	* @modified 08 April, 2008 by Raju Gautam
 	* @return boolean	
	*/
	public function lstImages(){
		$Sql = "SELECT 
					product_id, 
					image_name 
					FROM
					rs_tbl_products 
					WHERE 1=1";
					
		if($this->isPropertySet("product_id", "V"))
			$Sql .= " AND product_id='" . $this->getProperty("product_id") . "'";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::actImage()	
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_products the basis of property set
	* @author Raju Gautam
	* @Date 08 April, 2008
 	* @param string $mode	
	* @modified 08 April, 2008 by Raju Gautam
 	* @return boolean
	*/
	public function actImage($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":

				$Sql = "UPDATE rs_tbl_products SET ";
				if($this->isPropertySet("image_name", "K")){
					$Sql .= "image_name='" . $this->getProperty("image_name")."'";
				}
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("product_id", "V"))
					$Sql .= " AND product_id='" . $this->getProperty("product_id") . "'";
				else
					$Sql .= " AND image_cd=" . $this->getProperty("image_cd");



				break;
			case "U":
				$Sql = "UPDATE rs_tbl_products SET ";
				if($this->isPropertySet("is_primary", "K")){
					$Sql .= "$cat is_primary=" . $this->getProperty("is_primary");
					$cat = ",";
				}
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("product_cd", "V"))
					$Sql .= " AND product_cd='" . $this->getProperty("product_cd") . "'";
				else
					$Sql .= " AND image_cd=" . $this->getProperty("image_cd");
				break;
			case "D":
				$Sql = "UPDATE rs_tbl_products SET ";
				$Sql .= "image_name='' WHERE 1=1";
				if($this->isPropertySet("product_id", "V"))
					$Sql .= " AND product_id='" . $this->getProperty("product_id") . "'";

				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	
	public function getGlobal(){
		$Sql = "SELECT * FROM rs_tbl_config WHERE config_key='meta_title'";
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::actExcelFile()	
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_products the basis of property set
	* @author Raju Gautam
	* @Date 08 April, 2008
 	* @param string $mode	
	* @modified 08 April, 2008 by Raju Gautam
 	* @return boolean
	*/
	public function actExcelFile($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":

				$Sql = "INSERT INTO rs_tbl_excel_file (
						excel_id,
						filename,
						excel_date) 
						VALUES ( ";
						
				$Sql .= $this->isPropertySet("excel_id", "V") ? $this->getProperty("excel_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("filename", "V") ? "'" . $this->getProperty("filename") . "'" : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("excel_date", "V") ? "'" . $this->getProperty("excel_date") . "'" : "NULL";
				$Sql .= ")";		
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_products SET ";
				if($this->isPropertySet("is_primary", "K")){
					$Sql .= "$cat is_primary=" . $this->getProperty("is_primary");
					$cat = ",";
				}
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("product_cd", "V"))
					$Sql .= " AND product_cd='" . $this->getProperty("product_cd") . "'";
				else
					$Sql .= " AND image_cd=" . $this->getProperty("image_cd");
				break;
			case "D":
				$Sql = "UPDATE rs_tbl_products SET ";
				$Sql .= "image_name='' WHERE 1=1";
				if($this->isPropertySet("product_id", "V"))
					$Sql .= " AND product_id='" . $this->getProperty("product_id") . "'";

				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::printPrice()
	* This function is used to print the price
	* @author Raju Gautam
	* @Date 09 April, 2008
 	* @param float $peice	
	* @modified 09 April, 2008 by Raju Gautam
	* @return string
	*/
	public function printPrice($price, $flag = true){
		if($flag)
			return CURRENCY_SYMBOL . " " . number_format($price, 2, '.', '');
		else
			return number_format($price, 2, '.', '');
	}
	public function printPriceWithoutSign($price)
	{
		return  number_format($price, 2, ',', '');
	}
	
	/**
	* Product::getPrice()
	* This function is used to get the product price
	* @author Raju Gautam
	* @Date 09 April, 2008
 	* @param float $peice	
	* @modified 09 April, 2008 by Raju Gautam
	* @return string
	*/
	public function getPrice($product_id){
		if(empty($product_cd))
			return 0;
		$returns = array();
		$Sql = "SELECT discount_group,product_price,product_sale_price FROM rs_tbl_products WHERE product_id='" . $product_id . "'";
		$this->dbQuery($Sql);
		$data = $this->dbFetchArray(1);
		extract($data);
		
		$Sql = "SELECT first_discount,second_discount FROM rs_tbl_discount_groups WHERE discount_group='" . $discount_group . "'";
		$this->dbQuery($Sql);
		$data = $this->dbFetchArray(1);
		//extract($data);
		
		$discounted_price = $product_price * ($second_discount / 100);
		
		$returns['product_price'] = $product_price;
		$returns['discount_percent'] = $second_discount;
		$returns['discounted_price'] = $product_price - $discounted_price;
		$returns['sale_price'] = $product_sale_price;
		
		return $returns;
	}
	
	public function getOrderQuantity($order_cd)
	{
		$Sql = "SELECT SUM(quantity) FROM rs_tbl_order_details WHERE order_cd='$order_cd'";
		$this->dbQuery($Sql);
		$data = $this->dbFetchArray(1);
		print  $data['SUM(quantity)'];
	}
	
	
	/**
	* Product::GetProId()
	* This function is used to get the product price
	* @author Raju Gautam
	* @Date 09 April, 2008
 	* @param float $peice	
	* @modified 09 April, 2008 by Raju Gautam
	* @return string
	*/
	public function GetProId(){
		$Sql = "SELECT 
					product_id
				FROM
					rs_tbl_products 
				WHERE 
					1=1";
		if($this->isPropertySet("url_key", "V"))
			$Sql .= " AND url_key='" . $this->getProperty("url_key") . "'";
				
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::getCurrency()
	* This function is used to get the currency symbole
	* @author Raju Gautam
	* @Date 09 April, 2008
 	* @param boolean $flag	
	* @modified 09 April, 2008 by Raju Gautam
	* @return string
	*/
	public function getCurrency($flag = false){
		if($flag){
			return CURRENCY_SYMBOL . " [" . SITE_CURRENCY . "]";
		}
		else{
			return CURRENCY_SYMBOL;
		}
	}
	public function getCurrencyL($flag = false){
		if($flag){
			return CURRENCY_SYMBOL ;
		}
		else{
			return CURRENCY_SYMBOL;
		}
	}
	
	/**
	* Product::getProductCode()	
	* This function is used to get 10 degit unique product code
	* @author Raju Gautam
	* @Date 09 April, 2008
 	* @param int $product_id	
	* @modified 09 April, 2008 by Raju Gautam
	* @return string
	*/
	public function getProductCode($product_id){
		$product_id = str_pad($product_id, 4, "0", STR_PAD_RIGHT);
		$time 		= md5(time());
		$product_cd = substr($time, rand(5, 15), CODE_LENGTH);
		return $product_cd . $product_id;
	}
	
	/**
	* Product::lstImages()	
	* This function is used to list the products sizes
	* @author Raju Gautam
	* @Date 08 April, 2008
	* @modified 08 April, 2008 by Raju Gautam
 	* @return boolean	
	*/
	public function lstSizes(){
		$Sql = "SELECT 
					b.product_cd,
					b.size_cd,
					b.country_cd,
					b.product_size,
					b.product_length,
					b.product_waist,
					b.product_hip,
					b.size_price,
					b.product_availability
				FROM
					rs_tbl_products a 
					INNER JOIN rs_tbl_product_sizes b ON a.product_cd=b.product_cd
				WHERE 
					1=1";
		if($this->isPropertySet("product_cd", "V"))
			$Sql .= " AND b.product_cd='" . $this->getProperty("product_cd") . "'";
		
		if($this->isPropertySet("size_cd", "V"))
			$Sql .= " AND b.size_cd=" . $this->getProperty("size_cd");
		
		if($this->isPropertySet("product_availability", "V"))
			$Sql .= " AND b.product_availability='" . $this->getProperty("product_availability") . "'";		
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::sizeCombo()
	* This function is used to list the product size combo
	* @author Raju Gautam
	* @Date 15 April, 2008
 	* @param string $sel 	
	* @modified 15 April, 2008 by Raju Gautam
 	* @return string 	
	*/
	public function sizeCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					a.size_cd,
					a.product_cd,
					a.product_size,
					a.product_length,
					a.size_price,
					a.product_availability
				FROM
					rs_tbl_product_sizes a
				WHERE 
					1=1 
					AND a.product_cd='" . $this->getProperty("product_cd") . "'
				ORDER BY
					a.size_cd ASC";
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($sel == $rows['size_cd']) ? " selected" : "";
				if($rows['product_availability'] == "Sold Out"){
					$showValue = $rows['product_size'] . " - " . CURRENCY_SYMBOL . " " . $rows['size_price'];
					$showValue .= " (" . $rows['product_availability'] . ")";
					$opt .= "<option value=\"" . $rows['product_availability'] . "\" " . $sele . ">" . $showValue . "</option>\n";
				}
				else{
					$showValue = $rows['product_size'] . " - " . CURRENCY_SYMBOL . " " . $rows['size_price'];
					$opt .= "<option value=\"" . $rows['size_cd'] . "\" " . $sele . ">" . $showValue . "</option>\n";
				}
			}
		}
		return $opt;
	}
	
	/**
	* Product::actSize()	
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_product_sizes the basis of property set
	* @author Raju Gautam
 	* @param mixed $mode
	* @Date 09 April, 2008
	* @modified 09 April, 2008 by Raju Gautam
 	* @return boolean	
	*/
	public function actSize($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_product_sizes(
							size_cd,
							product_cd,
							country_cd,
							product_size,
							product_length,
							product_waist,
							product_hip,
							size_price,
							product_availability) 
						VALUES(";
				$Sql .= $this->isPropertySet("size_cd", "V") ? $this->getProperty("size_cd") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_cd", "V") ? "'" . $this->getProperty("product_cd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("country_cd", "V") ? "'" . $this->getProperty("country_cd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_size", "V") ? "'" . $this->getProperty("product_size") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_length", "V") ? "'" . $this->getProperty("product_length") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_waist", "V") ? "'" . $this->getProperty("product_waist") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_hip", "V") ? "'" . $this->getProperty("product_hip") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("size_price", "V") ? $this->getProperty("size_price") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_availability", "V") ? "'" . $this->getProperty("product_availability") . "'" : "NULL";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_product_sizes SET ";
				if($this->isPropertySet("product_size", "K")){
					$Sql .= "$cat product_size='" . $this->getProperty("product_size") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("product_length", "K")){
					$Sql .= "$cat product_length='" . $this->getProperty("product_length") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("product_waist", "K")){
					$Sql .= "$cat product_waist='" . $this->getProperty("product_waist") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("product_hip", "K")){
					$Sql .= "$cat product_hip='" . $this->getProperty("product_hip") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("size_price", "K")){
					$Sql .= "$cat size_price=" . $this->getProperty("size_price");
					$cat = ",";
				}
				if($this->isPropertySet("product_availability", "K")){
					$Sql .= "$cat product_availability='" . $this->getProperty("product_availability") . "'";
					$cat = ",";
				}
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND size_cd=" . $this->getProperty("size_cd");
				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_product_sizes 
						WHERE
							1=1";
				if($this->isPropertySet("product_cd", "V"))
					$Sql .= " AND a.product_cd='" . $this->getProperty("product_cd") . "'";
				else if($this->isPropertySet("size_cds", "V"))
					$Sql .= " AND size_cd IN(" . $this->getProperty("size_cds") . ")";
				else
					$Sql .= " AND size_cd=" . $this->getProperty("size_cd");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::lstProductLangs()	
	* This function is used to list the products
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean 	
	*/
	public function lstProductLangs(){
		$Sql = "SELECT 
					b.product_cd,
					b.language_cd,
					(SELECT lang_name FROM rs_tbl_langs WHERE lang_short=b.language_cd) as language_name,
					b.product_name,
					b.product_desc
				FROM
					rs_tbl_products a 
					INNER JOIN rs_tbl_product_lang AS b ON a.product_cd=b.product_cd
				WHERE 
					1=1";
		
		if($this->isPropertySet("product_id", "V"))
			$Sql .= " AND b.product_id='" . $this->getProperty("product_id") . "'";
		
		if($this->isPropertySet("language_cd", "V"))
			$Sql .= " AND b.language_cd='" . $this->getProperty("language_cd") . "'";
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::actProductLang()	
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_product_lang the basis of property set
	* @author Raju Gautam
	* @Date 08 April, 2008
 	* @param string $mode	
	* @modified 08 April, 2008 by Raju Gautam
 	* @return boolean
	*/
	public function actProductLang($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_product_lang(
						product_cd,
						product_id,
						language_cd,
						product_name,
						product_desc) 
						VALUES(";
				$Sql .= $this->isPropertySet("product_cd", "V") ? "'" . $this->getProperty("product_cd") . "'" : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_id", "V") ? "'" . $this->getProperty("product_id") . "'" : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("language_cd", "V") ? "'" . $this->getProperty("language_cd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_name", "V") ? "'" . $this->getProperty("product_name") . "'" : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_desc", "V") ? "'" . $this->getProperty("product_desc") . "'" : "NULL";
				$Sql .= ")";
				break;
			case "U":
				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_product_lang 
						WHERE
							1=1";
				$Sql .= " AND product_id='" . $this->getProperty("product_id") . "'";
				break;
			default:
				break;
		}
		echo $Sql;
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::lstCatLangs()	
	* This function is used to list the category language
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean
	*/
	public function lstCatLangs(){
		$Sql = "SELECT 
					b.category_cd,
					b.language_cd,
					(SELECT lang_name FROM rs_tbl_langs WHERE lang_short=b.language_cd) as language_name,
					b.category_name,
					b.details
				FROM
					rs_tbl_category AS a 
					INNER JOIN rs_tbl_category_lang AS b ON a.category_cd=b.category_cd
				WHERE 
					1=1";
		
		if($this->isPropertySet("category_cd", "V"))
			$Sql .= " AND b.category_cd=" . $this->getProperty("category_cd");
		
		if($this->isPropertySet("language_cd", "V"))
			$Sql .= " AND b.language_cd='" . $this->getProperty("language_cd") . "'";
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::lstSubCatLangs()	
	* This function is used to list the category language
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean
	*/
	public function lstSubCatLangs(){
		$Sql = "SELECT 
					b.sub_cat_id,
					b.landuage,
					(SELECT lang_name FROM rs_tbl_langs WHERE lang_short=b.landuage) as language_name,
					b.sub_cat_name,
					b.detail
				FROM
					rs_tbl_sub_category AS a 
					INNER JOIN rs_tbl_sub_category_lang AS b ON a.sub_cat_id=b.sub_cat_id
				WHERE 
					1=1";
		
		//if($this->isPropertySet("category_cd", "V"))
		//	$Sql .= " AND b.sub_cat_id=" . $this->getProperty("category_cd");
			
		if($this->isPropertySet("SubCat_id", "V"))
			$Sql .= " AND b.sub_cat_id=" . $this->getProperty("SubCat_id");
		
		if($this->isPropertySet("language_cd", "V"))
			$Sql .= " AND b.landuage='" . $this->getProperty("language_cd") . "'";
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::actCatLang()	
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_category_lang the basis of property set
	* @author Raju Gautam
	* @Date 08 April, 2008
 	* @param string $mode	
	* @modified 08 April, 2008 by Raju Gautam
 	* @return boolean
	*/
	public function actCatLang($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_category_lang(
						category_cd,
						language_cd,
						category_name,
						details) 
						VALUES(";
				$Sql .= $this->isPropertySet("category_cd", "V") ? $this->getProperty("category_cd") : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("language_cd", "V") ? "'" . $this->getProperty("language_cd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("category_name", "V") ? "'" . $this->getProperty("category_name") . "'" : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("details", "V") ? "'" . $this->getProperty("details") . "'" : " ";
				$Sql .= ")";
				break;
			case "U":
				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_category_lang 
						WHERE
							1=1";
				if($this->isPropertySet("category_cd", "V")){
					$Sql .= " AND category_cd=" . $this->getProperty("category_cd");
				}
				
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::actSubCatLang()	
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_category_lang the basis of property set
	* @author Raju Gautam
	* @Date 08 April, 2008
 	* @param string $mode	
	* @modified 08 April, 2008 by Raju Gautam
 	* @return boolean
	*/
	public function actSubCatLang($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_sub_category_lang(
						sub_cat_id,
						sub_cat_name,
						landuage,
						detail) 
						VALUES( ";
				$Sql .= $this->isPropertySet("sub_cat_id", "V") ? $this->getProperty("sub_cat_id") : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("sub_cat_name", "V") ? "'" . $this->getProperty("sub_cat_name") . "'" : " ";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("landuage", "V") ? "'" . $this->getProperty("landuage") . "'" : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("detail", "V") ? "'" . $this->getProperty("detail") . "'" : "";
				$Sql .= ")";
				break;
			case "U":
				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_sub_category_lang 
						WHERE
							1=1";
				if($this->isPropertySet("scat_id", "V")){
					$Sql .= " AND sub_cat_id=" . $this->getProperty("scat_id");
				}
				
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::lstColorLangs()	
	* This function is used to list the color language
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean
	*/
	public function lstColorLangs(){
		$Sql = "SELECT 
					b.color_lang_cd,
					b.color_cd,
					b.language_cd,
					(SELECT lang_name FROM rs_tbl_langs WHERE lang_short=b.language_cd) as language_name,
					b.color_name
				FROM
					rs_tbl_colors AS a 
					INNER JOIN rs_tbl_color_lang AS b ON a.color_cd=b.color_cd
				WHERE 
					1=1";
		
		if($this->isPropertySet("color_cd", "V"))
			$Sql .= " AND b.color_cd=" . $this->getProperty("color_cd");
		
		if($this->isPropertySet("language_cd", "V"))
			$Sql .= " AND b.language_cd='" . $this->getProperty("language_cd") . "'";
		
		if($this->isPropertySet("color_lang_cd", "V"))
			$Sql .= " AND b.color_lang_cd=" . $this->getProperty("color_lang_cd");
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::actColorLang()	
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_category_lang the basis of property set
	* @author Raju Gautam
	* @Date 08 April, 2008
 	* @param string $mode	
	* @modified 08 April, 2008 by Raju Gautam
 	* @return boolean
	*/
	public function actColorLang($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_color_lang(
						color_lang_cd,
						color_cd,
						language_cd,
						color_name) 
						VALUES(";
				$Sql .= $this->isPropertySet("color_lang_cd", "V") ? $this->getProperty("color_lang_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("color_cd", "V") ? $this->getProperty("color_cd") : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("language_cd", "V") ? "'" . $this->getProperty("language_cd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("color_name", "V") ? "'" . $this->getProperty("color_name") . "'" : "";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_color_lang SET ";
				if($this->isPropertySet("language_cd", "K")){
					$Sql .= "$cat language_cd='" . $this->getProperty("language_cd") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("color_name", "K")){
					$Sql .= "$cat color_name='" . $this->getProperty("color_name") . "'";
					$cat = ",";
				}
				
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("color_cd", "V") && $this->isPropertySet("language_cd", "V")){
					$Sql .= " AND color_cd=" . $this->getProperty("color_cd");
					$Sql .= " AND language_cd='" . $this->getProperty("language_cd") . "'";
				}
				else{
					$Sql .= " AND color_lang_cd=" . $this->getProperty("color_lang_cd");
				}
				
				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_color_lang 
						WHERE
							1=1";
				if($this->isPropertySet("color_cd", "V")){
					$Sql .= " AND color_cd=" . $this->getProperty("color_cd");
				}
				else{
					$Sql .= " AND color_lang_cd=" . $this->getProperty("color_lang_cd");
				}
				
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::lstBrand()	
	* This function is used to list the brands
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
 	* @return boolean 	
	*/
	public function lstBrand(){
		$Sql = "SELECT 
					a.brand_cd,
					a.brand_name,
					a.parent_brand,
					a.brand_image,
					a.brand_desc,
					a.brand_status,
					(SELECT COUNT(product_cd) as total_products FROM rs_tbl_products WHERE brand_cd=a.brand_cd) as total_products
				FROM
					rs_tbl_brands a
				WHERE 
					1=1 
					AND a.parent_brand=0";
		if($this->isPropertySet("brand_cd", "V"))
			$Sql .= " AND a.brand_cd=" . $this->getProperty("brand_cd");
		
		if($this->isPropertySet("brand_name", "V"))
			$Sql .= " AND a.brand_name='" . $this->getProperty("brand_name") . "'";
		
		if($this->isPropertySet("brand_image", "V"))
			$Sql .= " AND a.brand_image='" . $this->getProperty("brand_image") . "'";
		
		if($this->isPropertySet("brand_status", "V"))
			$Sql .= " AND a.brand_status=" . $this->getProperty("brand_status");
		
		$Sql .= " ORDER BY brand_name ASC";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	
	public function lstAccount(){
		$Sql = "SELECT 
					a.account_id,
					a.account_name,
					a.account_code,
					a.account_type,
					b.category_title
					FROM
						rs_tbl_accounts a
						inner join rs_tbl_account_type b on (a.account_type=b.cat_id)
					WHERE 
						1=1 
						";
		if($this->isPropertySet("account_id", "V"))
		$Sql .= " AND a.account_id=" . $this->getProperty("account_id");
		
		if($this->isPropertySet("account_name", "V"))
		$Sql .= " AND a.account_name='" . $this->getProperty("account_name") . "'";
		
		$Sql .= " ORDER BY account_name ASC";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	/** 
 	* Product::checkBrand()
	* This function is used to check brand name
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
 	* @return
	*/
	
	public function checkBrand(){
		$Sql = "SELECT 
					brand_cd
				FROM
					rs_tbl_brands
				WHERE 
					1=1 
					AND parent_brand=0";
		if($this->isPropertySet("brand_name", "V"))
			$Sql .= " AND brand_name='" . $this->getProperty("brand_name") . "'";
		
		if($this->isPropertySet("brand_cd", "V"))
			$Sql .= " AND brand_cd!=" . $this->getProperty("brand_cd");	
		
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	/**
	* Product::chkBrandProducts()	
	* This function is used to check whether the selected brand has products or not.
	* @author Raju Gautam
	* @Date 16 May, 2008
	* @modified 16 May, 2008 by Raju Gautam
 	* @return boolean 	
	*/
	public function chkBrandProducts(){
		$Sql = "SELECT 
					product_cd
				FROM
					rs_tbl_products
				WHERE 
					1=1";
		$Sql .= " AND parent_brand=0 AND brand_cd=" . $this->getProperty("brand_cd");
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	/**
	* Product::actBrand()		
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_brands the basis of property set
	* @author Raju Gautam
 	* @param $mixed $mode
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean	
	*/
	public function actBrand($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_brands(
						brand_cd,
						brand_name,
						brand_image,
						brand_desc,
						brand_status) 
						VALUES(";
				$Sql .= $this->isPropertySet("brand_cd", "V") ? $this->getProperty("brand_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("brand_name", "V") ? "'" . $this->getProperty("brand_name") . "'" : 0;
				$Sql .= ",";
				$Sql .= $this->isPropertySet("brand_image", "V") ? "'" . $this->getProperty("brand_image") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("brand_desc", "V") ? "'" . $this->getProperty("brand_desc") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("brand_status", "V") ? $this->getProperty("brand_status") : "1";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_brands SET ";
				if($this->isPropertySet("brand_name", "K")){
					$Sql .= "$cat brand_name='" . $this->getProperty("brand_name") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("brand_image", "K")){
					$Sql .= "$cat brand_image='" . $this->getProperty("brand_image") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("brand_desc", "K")){
					$Sql .= "$cat brand_desc='" . $this->getProperty("brand_desc") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("brand_status", "K")){
					$Sql .= "$cat brand_status=" . $this->getProperty("brand_status");
					$cat = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND brand_cd=" . $this->getProperty("brand_cd");
				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_brands 
						WHERE
							1=1";
				$Sql .= " AND brand_cd=" . $this->getProperty("brand_cd");
				break;
			case "ID":
				$Sql = "UPDATE rs_tbl_brands SET
							brand_image=NULL 
						WHERE
							1=1";
				$Sql .= " AND brand_cd=" . $this->getProperty("brand_cd");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
		public function actAccount($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_accounts(
						account_id,
						account_name,
						account_code,
						account_type) 
						VALUES(";
				$Sql .= $this->isPropertySet("account_id", "V") ? $this->getProperty("account_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("account_name", "V") ? "'" . $this->getProperty("account_name") . "'" : 0;
				$Sql .= ",";
				$Sql .= $this->isPropertySet("account_code", "V") ? "'" . $this->getProperty("account_code") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("account_type", "V") ? "'" . $this->getProperty("account_type") . "'" : "''";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_accounts SET ";
				if($this->isPropertySet("account_name", "K")){
					$Sql .= "$cat account_name='" . $this->getProperty("account_name") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("account_code", "K")){
					$Sql .= "$cat account_code='" . $this->getProperty("account_code") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("account_type", "K")){
					$Sql .= "$cat account_type='" . $this->getProperty("account_type") . "'";
					$cat = ",";
				}
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND account_id=" . $this->getProperty("account_id");
				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_accounts
						WHERE
							1=1";
				$Sql .= " AND account_id=" . $this->getProperty("account_id");
				break;
			case "ID":
				$Sql = "UPDATE rs_tbl_accounts SET
							brand_image=NULL 
						WHERE
							1=1";
				$Sql .= " AND account_id=" . $this->getProperty("account_id");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::brandCombo()
	* This function is used to list the product brands combo
	* @author Raju Gautam
	* @Date 07 April, 2008
 	* @param string $sel 	
	* @modified 07 April, 2008 by Raju Gautam
 	* @return string 	
	*/
	public function brandCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					a.brand_cd,
					a.brand_name
				FROM
					rs_tbl_brands a
				WHERE 
					1=1 
					AND parent_brand=0";
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($sel == $rows['brand_cd']) ? " selected" : "";
				$opt .= "<option value=\"" . $rows['brand_cd'] . "\" " . $sele . ">" . $rows['brand_name'] . "</option>\n";
			}
		}
		return $opt;
	}
	
	/**
	* Product::lstSeries()	
	* This function is used to list the brand series
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
 	* @return boolean 	
	*/
	public function lstSeries($brand_cd = ''){
		$Sql = "SELECT 
					a.brand_cd,
					a.brand_name as series_name,
					a.parent_brand,
					(SELECT brand_name FROM rs_tbl_brands WHERE brand_cd=a.parent_brand) AS brand_name,
					a.brand_status
				FROM
					rs_tbl_brands a
				WHERE 
					1=1 
					AND a.parent_brand!=0";
		
		if(!empty($brand_cd))
			$Sql .= " AND a.brand_cd=" . $brand_cd;
		
		if($this->isPropertySet("brand_cd", "V"))
			$Sql .= " AND a.brand_cd=" . $this->getProperty("brand_cd");
		
		if($this->isPropertySet("brand_status", "V"))
			$Sql .= " AND a.brand_status=" . $this->getProperty("brand_status");
		
		$Sql .= " ORDER BY brand_name ASC";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::lstSubCat()	
	* This function is used to list the brand series
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
 	* @return boolean 	
	*/
	public function lstCat($Cat_cd = ''){
	/*
		$Sql = "SELECT 
					category_cd,
					category_name
				FROM
					rs_tbl_category
				WHERE 
					1=1 AND category_status=1 ";
		
		if(!empty($Cat_cd))
			$Sql .= " AND category_cd=" . $Cat_cd;
		
		if($this->isPropertySet("sub_cat_id", "V"))
			$Sql .= " AND sub_cat_id=" . $this->getProperty("sub_cat_id");
		
		if($this->isPropertySet("status", "V"))
			$Sql .= " AND status=" . $this->getProperty("status");
		
		$Sql .= " ORDER BY category_name ASC";
		*/
		
		
		$Sql = "SELECT 
					sub_cat_id,
					sub_cat_name
				FROM
					rs_tbl_sub_category
				WHERE 
					1=1 AND status=1 ";
		
		if(!empty($Cat_cd))
			$Sql .= " AND cat_id=" . $Cat_cd;
		
		/*if($this->isPropertySet("sub_cat_id", "V"))
			$Sql .= " AND sub_cat_id=" . $this->getProperty("sub_cat_id");
		
		if($this->isPropertySet("status", "V"))
			$Sql .= " AND status=" . $this->getProperty("status");
		*/
		$Sql .= " ORDER BY sub_cat_name ASC";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::actSeries()		
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_brands the basis of property set
	* @author Raju Gautam
 	* @param $mixed $mode
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean	
	*/
	public function actSeries($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_brands(
						brand_cd,
						brand_name,
						parent_brand,
						brand_image,
						brand_desc,
						brand_status) 
						VALUES(";
				$Sql .= $this->isPropertySet("brand_cd", "V") ? $this->getProperty("brand_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("brand_name", "V") ? "'" . $this->getProperty("brand_name") . "'" : 0;
				$Sql .= ",";
				$Sql .= $this->isPropertySet("parent_brand", "V") ? $this->getProperty("parent_brand") : 0;
				$Sql .= ",";
				$Sql .= $this->isPropertySet("brand_image", "V") ? "'" . $this->getProperty("brand_image") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("brand_desc", "V") ? "'" . $this->getProperty("brand_desc") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("brand_status", "V") ? $this->getProperty("brand_status") : "1";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_brands SET ";
				if($this->isPropertySet("brand_name", "K")){
					$Sql .= "$cat brand_name='" . $this->getProperty("brand_name") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("parent_brand", "K")){
					$Sql .= "$cat parent_brand=" . $this->getProperty("parent_brand");
					$cat = ",";
				}
				if($this->isPropertySet("brand_image", "K")){
					$Sql .= "$cat brand_image='" . $this->getProperty("brand_image") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("brand_desc", "K")){
					$Sql .= "$cat brand_desc='" . $this->getProperty("brand_desc") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("brand_status", "K")){
					$Sql .= "$cat brand_status=" . $this->getProperty("brand_status");
					$cat = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND brand_cd=" . $this->getProperty("brand_cd");
				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_brands 
						WHERE
							1=1";
				$Sql .= " AND brand_cd=" . $this->getProperty("brand_cd");
				break;
			case "ID":
				$Sql = "UPDATE rs_tbl_brands SET
							brand_image=NULL 
						WHERE
							1=1";
				$Sql .= " AND brand_cd=" . $this->getProperty("brand_cd");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::seriesCombo()
	* This function is used to list the product series combo
	* @author Raju Gautam
	* @Date 07 April, 2008
 	* @param string $sel 	
	* @modified 07 April, 2008 by Raju Gautam
 	* @return string 	
	*/
	public function seriesCombo($parent_brand = "", $sel = ""){
		$opt = "";
		$Sql = "SELECT 
					a.brand_cd,
					a.brand_name
				FROM
					rs_tbl_brands a
				WHERE 
					1=1 
					AND parent_brand!=0";
		if(!empty($parent_brand)){
			$Sql .= " AND parent_brand=" . $parent_brand;
		}
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1 && !empty($parent_brand)){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($sel == $rows['brand_cd']) ? " selected" : "";
				$opt .= "<option value=\"" . $rows['brand_cd'] . "\" " . $sele . ">" . $rows['brand_name'] . "</option>\n";
			}
		}
		return $opt;
	}
	
	/**
	* Product::SubCatCombo()
	* This function is used to list the product series combo
	* @author Raju Gautam
	* @Date 07 April, 2008
 	* @param string $sel 	
	* @modified 07 April, 2008 by Raju Gautam
 	* @return string 	
	*/
	public function SubCatCombo($caty_cd = "", $SelCaty_cd = ""){
		$opt = "";
		$Sql = "SELECT 
					sub_cat_id,
					sub_cat_name
				FROM
					rs_tbl_sub_category
				WHERE 
					1=1";
		if(!empty($parent_brand)){
			$Sql .= " AND sub_cat_id='" . $caty_cd . "'";
		} else {
			$Sql .= " AND sub_cat_id=1";
		}
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1 && !empty($caty_cd)){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($SelCaty_cd == $rows['sub_cat_id']) ? " selected" : "";
				$opt .= "<option value=\"" . $rows['sub_cat_id'] . "\" " . $sele . ">" . $rows['sub_cat_name'] . "</option>\n";
			}
		}
		return $opt;
	}
	
	/**
	* Product::SubCatCombo()
	* This function is used to list the product series combo
	* @author Raju Gautam
	* @Date 07 April, 2008
 	* @param string $sel 	
	* @modified 07 April, 2008 by Raju Gautam
 	* @return string 	
	*/
	public function SubCategoryCombo($category_cd){
		$Sql = "SELECT 
					sub_cat_id,
					sub_cat_name
				FROM
					rs_tbl_sub_category
				WHERE 
					1=1";
	//	if(!empty($category_cd))
			$Sql .= " AND sub_cat_id='" . $category_cd . "'";
			
		$this->dbQuery($Sql);
			while($rows = $this->dbFetchArray()){
				$sele = ($rows['sub_cat_id']!='') ? " selected" : "";
				$opt .= "<option value=\"" . $rows['sub_cat_id'] . "\" " . $sele . ">" . $rows['sub_cat_name'] . "</option>\n";
		}
		return $opt;
	}
	
	/**
	* Product::SubCatCombo()
	* This function is used to list the product series combo
	* @author Raju Gautam
	* @Date 07 April, 2008
 	* @param string $sel 	
	* @modified 07 April, 2008 by Raju Gautam
 	* @return string 	
	*/
	public function GetCategory_cd(){
		$Sql = "SELECT 
					sub_cat_id,
					cat_id
				FROM
					rs_tbl_sub_category
				WHERE 
					1=1";
		if($this->isPropertySet("sub_cat_id", "V"))
			$Sql .= " AND sub_cat_id=" . $this->getProperty("sub_cat_id");
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::lstDeliveries()	
	* This function is used to list the deliveries
	* @author Raju Gautam
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
 	* @return boolean 	
	*/
	public function lstDeliveries($brand_cd = ''){
		$Sql = "SELECT 
					a.delivery_cd,
					a.delivery_name,
					a.status
				FROM
					rs_tbl_deliveries a
				WHERE 
					1=1";
		
		if($this->isPropertySet("delivery_cd", "V"))
			$Sql .= " AND a.delivery_cd=" . $this->getProperty("delivery_cd");
		
		if($this->isPropertySet("status", "V"))
			$Sql .= " AND a.status='" . $this->getProperty("status") . "'";
		
		$Sql .= " ORDER BY delivery_name ASC";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	
	/**
	* Product::actDeliveries()		
	* Add/edit/delete deliveries
	* @author Raju Gautam
 	* @param $mixed $mode
	* @Date 04 April, 2008
	* @modified 04 April, 2008 by Raju Gautam
	* @return boolean	
	*/
	public function actDeliveries($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_deliveries(
						delivery_cd,
						delivery_name,
						status) 
						VALUES(";
				$Sql .= $this->isPropertySet("delivery_cd", "V") ? $this->getProperty("delivery_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("delivery_name", "V") ? "'" . $this->getProperty("delivery_name") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("status", "V") ? "'" . $this->getProperty("status") . "'" : "''";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_deliveries SET ";
				if($this->isPropertySet("delivery_name", "K")){
					$Sql .= "$cat delivery_name='" . $this->getProperty("delivery_name") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("status", "K")){
					$Sql .= "$cat status='" . $this->getProperty("status") . "'";
					$cat = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND delivery_cd=" . $this->getProperty("delivery_cd");
				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_deliveries 
						WHERE
							1=1";
				$Sql .= " AND delivery_cd=" . $this->getProperty("delivery_cd");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::deliveryCombo()
	* This function is used to list the delivery combo
	* @author Raju Gautam
	* @Date 07 April, 2008
 	* @param string $sel 	
	* @modified 07 April, 2008 by Raju Gautam
 	* @return string
	*/
	public function deliveryCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					delivery_cd,
					delivery_name
				FROM
					rs_tbl_deliveries
				WHERE 
					1=1 
					AND status='Y' 
				ORDER BY 
					delivery_name ASC";
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($sel == $rows['delivery_cd']) ? " selected" : "";
				$opt .= "<option value=\"" . $rows['delivery_cd'] . "\" " . $sele . ">" . $rows['delivery_name'] . "</option>\n";
			}
		}
		return $opt;
	}
	
	
	/**
  	* Product::actRates()
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_rates the basis of property set
	* @author Mobina zafar
	* @Date 26 January, 2012
	* @param mixed $mode
	* @modified 26 January, 2012 by Mobina Zafar
 	* @return boolean
	*/
		public function actRates($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_rates(
						rate_id,
						gold_rate,
						premium_value,
						tax_value,
						dtax_value,
						buy_labour_cost,
						first_price_margin,
						second_price_margin,
						third_price_margin) 
						VALUES(";
				$Sql .= $this->isPropertySet("rate_id", "V") ? $this->getProperty("rate_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("gold_rate", "V") ? "'" .$this->getProperty("gold_rate"). "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("premium_value", "V") ? "'" . $this->getProperty("premium_value") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("tax_value", "V") ? "'" . $this->getProperty("tax_value") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("dtax_value", "V") ? "'" . $this->getProperty("dtax_value") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("buy_labour_cost", "V") ? "'" . $this->getProperty("buy_labour_cost") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("first_price_margin", "V") ? "'" . $this->getProperty("first_price_margin") . "'" : 
				"NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("second_price_margin", "V") ? "'" . $this->getProperty("second_price_margin") . "'" : 
				"NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("third_price_margin", "V") ? "'" . $this->getProperty("third_price_margin") . "'" : 
				"NULL";
				
				echo $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_rates SET ";
			
				if($this->isPropertySet("gold_rate", "K")){
					$Sql .= "$cat gold_rate='" . $this->getProperty("gold_rate") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("premium_value", "K")){
					$Sql .= "$cat premium_value='" . $this->getProperty("premium_value") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("tax_value", "K")){
					$Sql .= "$cat tax_value='" . $this->getProperty("tax_value") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("dtax_value", "K")){
					$Sql .= "$cat dtax_value='" . $this->getProperty("dtax_value") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("buy_labour_cost", "K")){
					$Sql .= "$cat buy_labour_cost='" . $this->getProperty("buy_labour_cost") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("first_price_margin", "K")){
					$Sql .= "$cat first_price_margin='" . $this->getProperty("first_price_margin") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("second_price_margin", "K")){
					$Sql .= "$cat second_price_margin='" . $this->getProperty("second_price_margin") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("third_price_margin", "K")){
					$Sql .= "$cat third_price_margin='" . $this->getProperty("third_price_margin") . "'";
					$cat = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND rate_id=" . $this->getProperty("rate_id");
				break;
			case "D":
				$Sql .= "DELETE FROM rs_tbl_rates WHERE 1=1 ";
				$Sql .= " AND rate_id=" . $this->getProperty("rate_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
		/** 
 	* Product::lstRates()
	* This function is used to list the rates
	* @author Mobina zafar
	* @Date 26 January, 2012
	* @modified 26 January, 2012 by Mobina Zafar
 	* @return null
	*/
	
	public function lstRates(){
		$Sql = "SELECT 
					a.rate_id,
					a.gold_rate,
					a.premium_value,
					a.tax_value,
					a.dtax_value,
					a.buy_labour_cost,
					a.first_price_margin,
					a.second_price_margin,
					a.third_price_margin
				FROM
					rs_tbl_rates a
				WHERE 
					1=1";
		if($this->isPropertySet("rate_id", "V"))
			$Sql .= " AND a.rate_id=" . $this->getProperty("rate_id");
		
		
		$Sql .= " ORDER BY rate_id ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	/**
  	* Product::actSellingLabourCost()
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_selling_labour_cost the basis of property set
	* @author Mobina zafar
	* @Date 26 January, 2012
	* @param mixed $mode
	* @modified 26 January, 2012 by Mobina Zafar
 	* @return boolean
	*/
		public function actSellingLabourCost($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_selling_labour_cost(
						cost_id,
						weight,
						weight2,
						cost_value
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("cost_id", "V") ? $this->getProperty("cost_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("weight", "V") ? "'" .$this->getProperty("weight"). "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("weight2", "V") ? "'" .$this->getProperty("weight2"). "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cost_value", "V") ? "'" . $this->getProperty("cost_value") . "'" : "NULL";
			    $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_selling_labour_cost SET ";
			
				if($this->isPropertySet("weight", "K")){
					$Sql .= "$cat weight='" . $this->getProperty("weight") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("weight2", "K")){
					$Sql .= "$cat weight2='" . $this->getProperty("weight2") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("cost_value", "K")){
					$Sql .= "$cat cost_value='" . $this->getProperty("cost_value") . "'";
					$cat = ",";
				}
			
				$Sql .= " WHERE 1=1";
				$Sql .= " AND cost_id=" . $this->getProperty("cost_id");
				break;
			case "D":
				$Sql .= "DELETE FROM rs_tbl_selling_labour_cost WHERE 1=1 ";
				$Sql .= " AND cost_id=" . $this->getProperty("cost_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	public function lstSellingLabourCost(){
		$Sql = "SELECT 
					    a.cost_id,
						a.weight,
						a.weight2,
						a.cost_value
				FROM
					rs_tbl_selling_labour_cost a
				WHERE 
					1=1";
		if($this->isPropertySet("cost_id", "V"))
			$Sql .= " AND a.cost_id=" . $this->getProperty("cost_id");
		
		if($this->isPropertySet("weight", "V")){
			$Sql .= " AND a.weight <= '" . $this->getProperty("weight") . "' AND a.weight2 >='" . $this->getProperty("weight") . "'";
		}
		
		$Sql .= " ORDER BY a.cost_id DESC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
		public function actAccountType($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_account_type(
						cat_id,
						category_title
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("cat_id", "V") ? $this->getProperty("cat_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("category_title", "V") ? "'" .$this->getProperty("category_title"). "'" : "NULL";
				
			  echo  $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_account_type SET ";
			
				if($this->isPropertySet("category_title", "K")){
					$Sql .= "$cat category_title='" . $this->getProperty("category_title") . "'";
					$cat = ",";
				}
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND cat_id=" . $this->getProperty("cat_id");
				break;
			case "D":
				$Sql .= "DELETE FROM rs_tbl_account_type WHERE 1=1 ";
				$Sql .= " AND cat_id=" . $this->getProperty("cat_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	
		public function lstAccountType(){
		$Sql = "SELECT 
					    a.cat_id,
						a.category_title
				FROM
					rs_tbl_account_type a
				WHERE 
					1=1";
		if($this->isPropertySet("cat_id", "V"))
			$Sql .= " AND a.cat_id=" . $this->getProperty("cat_id");
		
		
		$Sql .= " ORDER BY cat_id ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::WindowCombo()
	* This function is used to list the windows combo
	* @author Mobina zafar
	* @Date 30 January, 2012
	* @param mixed $mode
	* @modified 30 January, 2012 by Mobina Zafar
 	* @return String
	*/
	public function WindowCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					a.window_id,
					a.window_title
				FROM
					rs_tbl_windows a
				WHERE 
					1=1 
				ORDER BY 
					a.window_title ASC";
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($sel == $rows['window_id']) ? " selected" : "";
				$opt .= "<option value=\"" . $rows['window_id'] . "\" " . $sele . ">" . $rows['window_title'] . "</option>\n";
			}
		}
		return $opt;
	}
	public function AccountTypeCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					a.cat_id,
					a.category_title
				FROM
					rs_tbl_account_type a
				WHERE 
					1=1 
				ORDER BY 
					a.category_title ASC";
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($sel == $rows['cat_id']) ? " selected" : "";
				$opt .= "<option value=\"" . $rows['cat_id'] . "\" " . $sele . ">" . $rows['category_title'] . "</option>\n";
			}
		}
		return $opt;
	}
	
	
	
	
	public function actProject($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				 $Sql = "INSERT INTO project(
						pid,
						code,
						detail,
						pstartdate,
						penddate,
						pamount) 
						VALUES(";
				$Sql .= $this->isPropertySet("pid", "V") ? $this->getProperty("pid") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("code", "V") ? "'" . $this->getProperty("code") . "'" : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("detail", "V") ? "'" . $this->getProperty("detail") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("pstartdate", "V") ? "'" . $this->getProperty("pstartdate") . "'" : "'NULL'";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("penddate", "V") ? "'" . $this->getProperty("penddate") . "'" : "'NULL'";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("pamount", "V") ? "'" . $this->getProperty("pamount") . "'" : "'NULL'";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE project SET ";
				if($this->isPropertySet("code", "K")){
					$Sql .= "$cat code='" . $this->getProperty("code") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("detail", "K")){
					$Sql .= "$cat detail='" . $this->getProperty("detail") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("pstartdate", "K")){
					$Sql .= "$cat pstartdate='" . $this->getProperty("pstartdate") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("penddate", "K")){
					$Sql .= "$cat penddate='" . $this->getProperty("penddate") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("pamount", "K")){
					$Sql .= "$cat pamount='" . $this->getProperty("pamount") . "'";
					$cat = ",";
				}
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND pid=" . $this->getProperty("pid");
				break;
			case "D":
				$Sql = "DELETE FROM 
							project
						WHERE
							1=1";
				$Sql .= " AND pid=" . $this->getProperty("pid");
				break;
			
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	public function lstProject(){
		$Sql = "SELECT 
					    a.pid,
						a.code,
						a.detail,
						a.pstartdate,
						a.penddate,
						a.pamount
				FROM
					mis_tbl_1_projects a
				WHERE 
					1=1";
		if($this->isPropertySet("pid", "V"))
			$Sql .= " AND a.pid=" . $this->getProperty("pid");
		
		
		$Sql .= " ORDER BY pid ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	public function ProjectCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					a.pid,
					a.code,
					a.project_title,
					a.detail
				FROM
					mis_tbl_1_projects a
				WHERE 
					1=1 
				ORDER BY 
					a.pid ASC";
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($sel == $rows['pid']) ? " selected" : "";
				$opt .= "<option value=\"" . $rows['pid'] . "\" " . $sele . ">" .$rows['code']."-". $rows['project_title'] . "</option>\n";
			}
		}
		return $opt;
	}
	
	
	public function actComponent($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				 $Sql = "INSERT INTO components(
						cid,
						pid,
						code,
						detail,
						assig,
						type
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("cid", "V") ? $this->getProperty("cid") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("pid", "V") ? $this->getProperty("pid") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("code", "V") ? "'" . $this->getProperty("code") . "'" : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("detail", "V") ? "'" . $this->getProperty("detail") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("assig", "V") ? "'" . $this->getProperty("assig") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("type", "V") ? "'" . $this->getProperty("type") . "'" : "NULL";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE components SET ";
				
				if($this->isPropertySet("pid", "K")){
					$Sql .= "$cat pid='" . $this->getProperty("pid") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("code", "K")){
					$Sql .= "$cat code='" . $this->getProperty("code") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("detail", "K")){
					$Sql .= "$cat detail='" . $this->getProperty("detail") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("assig", "K")){
					$Sql .= "$cat assig='" . $this->getProperty("assig") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("type", "K")){
					$Sql .= "$cat type='" . $this->getProperty("type") . "'";
					$cat = ",";
				}
				
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND cid=" . $this->getProperty("cid");
				break;
			case "D":
				$Sql = "DELETE FROM 
							components
						WHERE
							1=1";
				$Sql .= " AND cid=" . $this->getProperty("cid");
				break;
			
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	public function lstComponent(){
		$Sql = "SELECT 
					    
						a.cid,
						a.pid,
						a.code,
						a.detail,
						a.assig
						
				FROM
					mis_tbl_2_components a
				WHERE 
					1=1";
		if($this->isPropertySet("pid", "V"))
			$Sql .= " AND a.pid=" . $this->getProperty("pid");
		
		if($this->isPropertySet("cid", "V"))
			$Sql .= " AND a.cid=" . $this->getProperty("cid");
			
		$Sql .= " ORDER BY cid ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	public function ComponentCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					a.cid,
					a.pid,
					a.code,
					a.detail
				FROM
					mis_tbl_2_components a
				WHERE 
					1=1 
				ORDER BY 
					a.pid ASC";
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($sel == $rows['cid']) ? " selected" : "";
				$opt .= "<option value=\"" . $rows['cid'] . "\" " . $sele . ">" .$rows['code']."-". $rows['detail'] . "</option>\n";
			}
		}
		return $opt;
	}
	
	public function ActivityTypeCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					a.sid,
					a.code,
					a.detail
				FROM
					activitytype a
				WHERE 
					1=1 
				ORDER BY 
					a.sid ASC";
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($sel == $rows['sid']) ? " selected" : "";
				$opt .= "<option value=\"" . $rows['sid'] . "\" " . $sele . ">" .$rows['code']."-". $rows['detail'] . "</option>\n";
			}
		}
		return $opt;
	}
	
	public function actSubComponent($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				 $Sql = "INSERT INTO mis_tbl_3_subcomponents(
						s_id,
						cid,
						code,
						detail,
						assig
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("s_id", "V") ? $this->getProperty("s_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cid", "V") ? $this->getProperty("cid") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("code", "V") ? "'" . $this->getProperty("code") . "'" : "";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("detail", "V") ? "'" . $this->getProperty("detail") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("assig", "V") ? "'" . $this->getProperty("assig") . "'" : "NULL";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE mis_tbl_3_subcomponents SET ";
				
				if($this->isPropertySet("s_id", "K")){
					$Sql .= "$cat s_id='" . $this->getProperty("s_id") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("cid", "K")){
					$Sql .= "$cat cid='" . $this->getProperty("cid") . "'";
					$cat = ",";
				}
				
				if($this->isPropertySet("code", "K")){
					$Sql .= "$cat code='" . $this->getProperty("code") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("detail", "K")){
					$Sql .= "$cat detail='" . $this->getProperty("detail") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("assig", "K")){
					$Sql .= "$cat assig='" . $this->getProperty("assig") . "'";
					$cat = ",";
				}
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND s_id=" . $this->getProperty("s_id");
				break;
			case "D":
				$Sql = "DELETE FROM 
							mis_tbl_3_subcomponents
						WHERE
							1=1";
				$Sql .= " AND s_id=" . $this->getProperty("s_id");
				break;
			
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	public function lstSubComponent(){
		$Sql = "SELECT 
					    
						a.cid,
						(SELECT pid from mis_tbl_2_components where cid=a.cid) as pid,
						(SELECT detail from mis_tbl_2_components where cid=a.cid) as component,
						(SELECT code from mis_tbl_2_components where cid=a.cid) as c_code,
						a.s_id,
						a.code,
						a.detail,
						a.Sassig
				FROM
					mis_tbl_3_subcomponents a
				WHERE 
					1=1";
		if($this->isPropertySet("s_id", "V"))
			$Sql .= " AND a.s_id=" . $this->getProperty("s_id");
		
		if($this->isPropertySet("cid", "V"))
			$Sql .= " AND a.cid=" . $this->getProperty("cid");
			
		$Sql .= " ORDER BY code, s_id ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	public function SubComponentCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					a.s_id,
					a.cid,
					a.code,
					a.detail
				FROM
					mis_tbl_3_subcomponents a
				WHERE 
					1=1 
				ORDER BY 
					a.s_id ASC";
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($sel == $rows['s_id']) ? " selected" : "";
				$opt .= "<option value=\"" . $rows['s_id'] . "\" " . $sele . ">" .$rows['code']."-". $rows['detail'] . "</option>\n";
			}
		}
		return $opt;
	}
	
	public function actActivity($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				 $Sql = "INSERT INTO mis_tbl_4_milstones(
						aid,
						s_id,
						code,
						detail,
						startdate,	
						enddate,	
						actual_stardate,
						actual_enddate,
						assig,
						baseline
						) 
						VALUES(";
						
				$Sql .= $this->isPropertySet("aid", "V") ? $this->getProperty("aid") : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("s_id", "V") ? $this->getProperty("s_id") : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("code", "V") ? "'" . $this->getProperty("code") . "'" : "";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("detail", "V") ? "'" . $this->getProperty("detail") . "'" : "''";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("startdate", "V") ? $this->getProperty("startdate") : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("enddate", "V") ? $this->getProperty("enddate") : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("actual_stardate", "V") ? $this->getProperty("actual_stardate") : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("actual_enddate", "V") ? $this->getProperty("actual_enddate") : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("assig", "V") ? "'" . $this->getProperty("assig") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("baseline", "V") ? "'" . $this->getProperty("baseline"). "'" :  "NULL";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE mis_tbl_4_milstones SET ";
				
				if($this->isPropertySet("aid", "K")){
					$Sql .= "$cat aid='" . $this->getProperty("aid") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("s_id", "K")){
					$Sql .= "$cat s_id='" . $this->getProperty("s_id") . "'";
					$cat = ",";
				}
				
				if($this->isPropertySet("code", "K")){
					$Sql .= "$cat code='" . $this->getProperty("code") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("detail", "K")){
					$Sql .= "$cat detail='" . $this->getProperty("detail") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("startdate", "K")){
					$Sql .= "$cat startdate='" . $this->getProperty("startdate") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("enddate", "K")){
					$Sql .= "$cat enddate='" . $this->getProperty("enddate") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("actual_stardate", "K")){
					$Sql .= "$cat actual_stardate='" . $this->getProperty("actual_stardate") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("actual_enddate", "K")){
					$Sql .= "$cat actual_enddate='" . $this->getProperty("actual_enddate") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("assig", "K")){
					$Sql .= "$cat assig='" . $this->getProperty("assig") . "'";
					
				}
				if($this->isPropertySet("baseline", "K")){
					$Sql .= "$cat baseline='" . $this->getProperty("baseline") . "'";
					
				}
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND aid=" . $this->getProperty("aid");
				break;
			case "D":
				$Sql = "DELETE FROM 
							mis_tbl_4_milstones
						WHERE
							1=1";
				$Sql .= " AND aid=" . $this->getProperty("aid");
				break;
			
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	public function lstActivities(){
		$Sql = "SELECT 
					    
						a.aid,
						a.s_id,
						(SELECT detail from mis_tbl_3_subcomponents where s_id=a.s_id) as subcomponent,
						(SELECT code from mis_tbl_3_subcomponents where s_id=a.s_id) as scode,
						a.code,
						a.detail,
						a.startdate,
						a.enddate,
						a.actual_stardate,
						a.actual_enddate,
						a.assig,
						a.baseline
				FROM
					mis_tbl_4_milstones a
				WHERE 
					1=1";
		if($this->isPropertySet("aid", "V"))
			$Sql .= " AND a.aid=" . $this->getProperty("aid");
		
		if($this->isPropertySet("s_id", "V"))
			$Sql .= " AND a.s_id=" . $this->getProperty("s_id");
			
		$Sql .= " Group by aid ORDER BY  code ASC ";
		
		if($this->isPropertySet("limit", "V"))
		$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	
	public function actActivityDPM($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				 $Sql = "INSERT INTO dpm_activity(
						aid,
						pid,
						acode,
						detail,
						weight
						) 
						VALUES(";
						
				$Sql .= $this->isPropertySet("aid", "V") ? $this->getProperty("aid") : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("pid", "V") ? $this->getProperty("pid") : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("acode", "V") ? "'" . $this->getProperty("acode") . "'" : "";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("detail", "V") ? "'" . $this->getProperty("detail") . "'" : "''";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("weight", "V") ? "'" . $this->getProperty("weight") . "'" : "NULL";
				
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE dpm_activity SET ";
				
				if($this->isPropertySet("aid", "K")){
					$Sql .= "$cat aid='" . $this->getProperty("aid") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("pid", "K")){
					$Sql .= "$cat pid='" . $this->getProperty("pid") . "'";
					$cat = ",";
				}
				
				if($this->isPropertySet("acode", "K")){
					$Sql .= "$cat acode='" . $this->getProperty("acode") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("detail", "K")){
					$Sql .= "$cat detail='" . $this->getProperty("detail") . "'";
					$cat = ",";
				}
			
				if($this->isPropertySet("weight", "K")){
					$Sql .= "$cat weight='" . $this->getProperty("weight") . "'";
					
				}
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND aid=" . $this->getProperty("aid");
				break;
			case "D":
				$Sql = "DELETE FROM 
							dpm_activity
						WHERE
							1=1";
				$Sql .= " AND aid=" . $this->getProperty("aid");
				break;
			
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	public function lstActivitiesDPM(){
		$Sql = "SELECT 
					    
						a.aid,
						a.pid,
						(SELECT project_title from mis_tbl_1_projects where pid=a.pid) as project,
						a.acode,
						a.detail,
						a.weight
				FROM
					dpm_activity a
				WHERE 
					1=1";
		if($this->isPropertySet("aid", "V"))
			$Sql .= " AND a.aid=" . $this->getProperty("aid");
		
		
		$Sql .= " Group by aid ORDER BY  aid ASC ";
		
		if($this->isPropertySet("limit", "V"))
		$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	
	public function ActivityComboDPM($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					a.aid,
					a.pid,
					a.acode,
					a.detail
				FROM
					dpm_activity a
				WHERE 
					1=1 
				ORDER BY 
					a.aid ASC";
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($sel == $rows['aid']) ? " selected" : "";
				$opt .= "<option value=\"" . $rows['aid'] . "\" " . $sele . ">" .$rows['acode']."-". $rows['detail'] . "</option>\n";
			}
		}
		return $opt;
	}
	
	
	public function ActivityCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					a.aid,
					a.s_id,
					a.code,
					a.detail
				FROM
					mis_tbl_4_milstones a
				WHERE 
					1=1 
				ORDER BY 
					a.aid ASC";
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			while($rows = $this->dbFetchArray(1)){
				$sele = ($sel == $rows['aid']) ? " selected" : "";
				$opt .= "<option value=\"" . $rows['aid'] . "\" " . $sele . ">" .$rows['code']."-". $rows['detail'] . "</option>\n";
			}
		}
		return $opt;
	}
	
	public function actSubActivity($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				 $Sql = "INSERT INTO mis_tbl_5_milstone_units(
						sa_id,
						aid,
						code,
						detail,
						unit,	
						uom	
						
						) 
						VALUES(";
						
				$Sql .= $this->isPropertySet("sa_id", "V") ? $this->getProperty("sa_id") : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("aid", "V") ?  "'" . $this->getProperty("aid") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("code", "V") ? "'" . $this->getProperty("code") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("detail", "V") ? "'" . $this->getProperty("detail") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("unit", "V") ?  "'" . $this->getProperty("unit"). "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("uom", "V") ?  "'" . $this->getProperty("uom") . "'" : "NULL";
				
				
			echo	$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE mis_tbl_5_milstone_units SET ";
				
				if($this->isPropertySet("sa_id", "K")){
					$Sql .= "$cat sa_id='" . $this->getProperty("sa_id") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("aid", "K")){
					$Sql .= "$cat aid='" . $this->getProperty("aid") . "'";
					$cat = ",";
				}
				
				if($this->isPropertySet("code", "K")){
					$Sql .= "$cat code='" . $this->getProperty("code") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("detail", "K")){
					$Sql .= "$cat detail='" . $this->getProperty("detail") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("unit", "K")){
					$Sql .= "$cat unit='" . $this->getProperty("unit") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("uom", "K")){
					$Sql .= "$cat uom='" . $this->getProperty("uom") . "'";
					$cat = ",";
				}
				
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND sa_id=" . $this->getProperty("sa_id");
				break;
			case "D":
				$Sql = "DELETE FROM 
							mis_tbl_5_milstone_units
						WHERE
							1=1";
				$Sql .= " AND sa_id=" . $this->getProperty("sa_id");
				break;
			
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	public function lstSubActivities(){
		$Sql = "SELECT 
					    
						a.sa_id,
						a.aid,
						(SELECT detail from mis_tbl_4_milstones where aid=a.aid) as activity_detail,
						a.code,
						a.detail,
						a.unit,
						a.uom,
						a.qty,
						a.rs,
						a.es_qty,
						a.es_rate,
						b.btid,
						b.bid,
						b.sa_id,
						b.targets,
						b.achieved
				FROM
					mis_tbl_5_milstone_units a 
					join mis_tbl_5_units_targets b on(a.sa_id=b.sa_id)
				WHERE 
					1=1";
		if($this->isPropertySet("aid", "V"))
			$Sql .= " AND a.aid=" . $this->getProperty("aid");
		
		if($this->isPropertySet("sa_id", "V"))
			$Sql .= " AND a.sa_id=" . $this->getProperty("sa_id");
			
		$Sql .= " ORDER BY a.sa_id ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	
		public function actSubActivityDPM($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				 $Sql = "INSERT INTO dpm_subactivity(
						sa_id,
						aid,
						code,
						detail,
						unit,	
						qty,
						start_date,
					    end_date	
						
						) 
						VALUES(";
						
				$Sql .= $this->isPropertySet("sa_id", "V") ? $this->getProperty("sa_id") : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("aid", "V") ?  "'" . $this->getProperty("aid") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("code", "V") ? "'" . $this->getProperty("code") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("detail", "V") ? "'" . $this->getProperty("detail") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("unit", "V") ?  "'" . $this->getProperty("unit"). "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("qty", "V") ?  "'" . $this->getProperty("qty") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("start_date", "V") ? "'" . $this->getProperty("start_date") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("end_date", "V") ?  "'" . $this->getProperty("end_date"). "'" : "NULL";
				
				
			    $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE dpm_subactivity SET ";
				
				if($this->isPropertySet("sa_id", "K")){
					$Sql .= "$cat sa_id='" . $this->getProperty("sa_id") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("aid", "K")){
					$Sql .= "$cat aid='" . $this->getProperty("aid") . "'";
					$cat = ",";
				}
				
				if($this->isPropertySet("code", "K")){
					$Sql .= "$cat code='" . $this->getProperty("code") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("detail", "K")){
					$Sql .= "$cat detail='" . $this->getProperty("detail") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("unit", "K")){
					$Sql .= "$cat unit='" . $this->getProperty("unit") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("qty", "K")){
					$Sql .= "$cat qty='" . $this->getProperty("qty") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("start_date", "K")){
					$Sql .= "$cat start_date='" . $this->getProperty("start_date") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("end_date", "K")){
					$Sql .= "$cat end_date='" . $this->getProperty("end_date") . "'";
					
				}
				
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND sa_id=" . $this->getProperty("sa_id");
				break;
			case "D":
				$Sql = "DELETE FROM 
							dpm_subactivity
						WHERE
							1=1";
				$Sql .= " AND sa_id=" . $this->getProperty("sa_id");
				break;
			
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	public function lstSubActivitiesDPM(){
		$Sql = "SELECT 
					    
						a.sa_id,
						a.aid,
						(SELECT detail from dpm_activity where aid=a.aid) as activity_detail,
						a.code,
						a.detail,
						a.unit,
						a.qty,
						a.start_date,
						a.end_date						
				FROM
					dpm_subactivity a 
					
				WHERE 
					1=1";
		if($this->isPropertySet("aid", "V"))
			$Sql .= " AND a.aid=" . $this->getProperty("aid");
		
		if($this->isPropertySet("sa_id", "V"))
			$Sql .= " AND a.sa_id=" . $this->getProperty("sa_id");
			
		$Sql .= " ORDER BY a.sa_id ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	
	public function actProgressDPM($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				 $Sql = "INSERT INTO dpm_progress(
						prog_id,
						sa_id,
						pdate,
					    pqty	
						
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("prog_id", "V") ? $this->getProperty("prog_id") : "NULL";
				$Sql .= ",";		
						
				$Sql .= $this->isPropertySet("sa_id", "V") ? $this->getProperty("sa_id") : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("pdate", "V") ?  "'" . $this->getProperty("pdate") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("pqty", "V") ? "'" . $this->getProperty("pqty") . "'" : "0";
				
				
			    $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE dpm_progress SET ";
				
				if($this->isPropertySet("prog_id", "K")){
					$Sql .= "$cat prog_id='" . $this->getProperty("prog_id") . "'";
					$cat = ",";
				}
				
				if($this->isPropertySet("sa_id", "K")){
					$Sql .= "$cat sa_id='" . $this->getProperty("sa_id") . "'";
					$cat = ",";
				}
				
				if($this->isPropertySet("pdate", "K")){
					$Sql .= "$cat pdate='" . $this->getProperty("pdate") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("pqty", "K")){
					$Sql .= "$cat pqty='" . $this->getProperty("pqty") . "'";
					
				}
				
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND prog_id=" . $this->getProperty("prog_id");
				break;
			case "D":
				$Sql = "DELETE FROM 
							dpm_progress
						WHERE
							1=1";
				$Sql .= " AND prog_id=" . $this->getProperty("prog_id");
				break;
			
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	public function ProgressExists(){
		$Sql = "SELECT 
					sa_id,
					pdate
				FROM
					dpm_progress
				WHERE 
					1=1";
					
		if($this->isPropertySet("pdate", "V"))
			$Sql .= " AND pdate='" . $this->getProperty("pdate") . "'";
		
			if($this->isPropertySet("sa_id", "V"))
			$Sql .= " AND sa_id='" . $this->getProperty("sa_id") . "'";
		
		
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function lstProgressDPM(){
		$Sql = "SELECT 
					    a.prog_id,
						a.sa_id,
						(SELECT detail from dpm_subactivity where sa_id=a.sa_id) as subactivity_detail,
						a.pqty,
						a.pdate						
				FROM
					dpm_progress a 
					
				WHERE 
					1=1";
		if($this->isPropertySet("prog_id", "V"))
			$Sql .= " AND a.prog_id=" . $this->getProperty("prog_id");
		
		if($this->isPropertySet("sa_id", "V"))
			$Sql .= " AND a.sa_id=" . $this->getProperty("sa_id");
			
			if($this->isPropertySet("pdate", "V"))
			$Sql .= " AND a.pdate='" . $this->getProperty("pdate")."'";
			
		$Sql .= " ORDER BY a.prog_id ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	public function actMilestoneUnitTarget($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				 $Sql = "INSERT INTO mis_tbl_5_units_targets(
							btid,
							bid,
							sa_id,
							targets,
							achieved)
						VALUES(";
						
				$Sql .= $this->isPropertySet("btid", "V") ? $this->getProperty("btid") : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("bid", "V") ?  "'" . $this->getProperty("bid") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("sa_id", "V") ?  "'" . $this->getProperty("sa_id") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("targets", "V") ? "'" . $this->getProperty("targets") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("achieved", "V") ? "'" . $this->getProperty("achieved") . "'" : "NULL";
			
			echo	$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE mis_tbl_5_units_targets SET ";
				
				if($this->isPropertySet("btid", "K")){
					$Sql .= "$cat btid='" . $this->getProperty("btid") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("bid", "K")){
					$Sql .= "$cat bid='" . $this->getProperty("bid") . "'";
					$cat = ",";
				}
				
				if($this->isPropertySet("sa_id", "K")){
					$Sql .= "$cat sa_id='" . $this->getProperty("sa_id") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("targets", "K")){
					$Sql .= "$cat targets='" . $this->getProperty("targets") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("achieved", "K")){
					$Sql .= "$cat achieved='" . $this->getProperty("achieved") . "'";
					$cat = ",";
				}
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND btid=" . $this->getProperty("btid");
				break;
			case "D":
				$Sql = "DELETE FROM 
							mis_tbl_5_milstone_units
						WHERE
							1=1";
				$Sql .= " AND sa_id=" . $this->getProperty("sa_id");
				break;
			
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	public function lstSubActivitiesData(){
		$Sql = "SELECT 
					    
						*
				FROM
					test1 a
				WHERE 
					1=1";
		if($this->isPropertySet("aid", "V"))
			$Sql .= " AND a.aid=" . $this->getProperty("aid");
		
		if($this->isPropertySet("sa_id", "V"))
			$Sql .= " AND a.sa_id=" . $this->getProperty("sa_id");
			
		$Sql .= " ORDER BY sa_id ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	public function lstCMS(){
		$Sql = "SELECT  
						a.cms_id,
						a.detail
				FROM
					rs_tbl_cms a
				WHERE 
					1=1";
		if($this->isPropertySet("cms_id", "V"))
			$Sql .= " AND a.cms_id=" . $this->getProperty("cms_id");
		
			
		$Sql .= " ORDER BY cms_id ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	public function lstCMSMenu(){
		$Sql = "SELECT
			  a.cms_id
  		 	, a.detail
			, a.link
			, b.user_cd
			, b.cms_right_id
			FROM
			rs_tbl_cms a
			INNER JOIN rs_tbl_cms_rights b
				ON (a.cms_id = b.cms_id)
			WHERE 1=1";
		if($this->isPropertySet("user_cd", "V"))
			$Sql .= " AND b.user_cd=" . $this->getProperty("user_cd");
			
		if($this->isPropertySet("cms_id", "V"))
			$Sql .= " AND a.cms_id=" . $this->getProperty("cms_id");
		
			
		$Sql .= " ORDER BY a.cms_id ASC ";
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	public function actReport($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
			$Sql = "INSERT INTO rs_tbl_documents(
						report_category,
						report_subcategory,
						report_title,
						report_file,						
						doc_issue_date,
						report_status,
						period,
						doc_upload_date,
						revision,
						doc_closing_date,
						document_no,
						user_access,
						user_ids
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("report_category", "V") ? $this->getProperty("report_category") : 0;
				$Sql .= ",";
				$Sql .= $this->isPropertySet("report_subcategory", "V") ? $this->getProperty("report_subcategory") : 0;
				$Sql .= ",";
				$Sql .= $this->isPropertySet("report_title", "V") ? "'" . $this->getProperty("report_title") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("report_file", "V") ? "'" . $this->getProperty("report_file") . "'" : "NULL";
				$Sql .= ",";				
				$Sql .= $this->isPropertySet("doc_issue_date", "V") ? "'" . $this->getProperty("doc_issue_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("report_status", "V") ? "'" . $this->getProperty("report_status") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("period", "V") ? "'" . $this->getProperty("period") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("doc_upload_date", "V") ? "'" . $this->getProperty("doc_upload_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("revision", "V") ? "'" . $this->getProperty("revision") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("doc_closing_date", "V") ? "'" . $this->getProperty("doc_closing_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("document_no", "V") ? "'" . $this->getProperty("document_no") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_access", "V") ? "'" . $this->getProperty("user_access") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_ids", "V") ? "'" . $this->getProperty("user_ids") . "'" : "NULL";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_documents SET ";
			//	if($this->isPropertySet("parent_cd", "K")){
			//		$Sql .= "$cat parent_cd=" . $this->getProperty("parent_cd");
			//		$cat = ",";
			//	}
				if($this->isPropertySet("report_category", "K")){
					$Sql .= "$cat report_category='" . $this->getProperty("report_category") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("report_subcategory", "K")){
					$Sql .= "$cat report_subcategory='" . $this->getProperty("report_subcategory") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("report_title", "K")){
					$Sql .= "$cat report_title='" . $this->getProperty("report_title") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("report_file", "K")){
					$Sql .= "$cat report_file='" . $this->getProperty("report_file") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("doc_issue_date", "K")){
					$Sql .= "$cat doc_issue_date='" . $this->getProperty("doc_issue_date") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("report_status", "K")){
					$Sql .= "$cat report_status='" . $this->getProperty("report_status") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("period", "K")){
					$Sql .= "$cat period='" . $this->getProperty("period") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("doc_upload_date", "K")){
					$Sql .= "$cat doc_upload_date='" . $this->getProperty("doc_upload_date") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("revision", "K")){
					$Sql .= "$cat revision='" . $this->getProperty("revision") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("doc_closing_date", "K")){
					$Sql .= "$cat doc_closing_date='" . $this->getProperty("doc_closing_date") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("document_no", "K")){
					$Sql .= "$cat document_no='" . $this->getProperty("document_no") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("user_access", "K")){
					$Sql .= "$cat user_access='" . $this->getProperty("user_access") . "'";
					$cat = ",";
				}
				if($this->isPropertySet("user_ids", "K")){
					$Sql .= "$cat user_ids='" . $this->getProperty("user_ids") . "'";
					$cat = ",";
				}
				
				$Sql .= " WHERE 1=1";
				 $Sql .= " AND report_id=" . $this->getProperty("report_id");
				break;
			case "D":
				$Sql .= "DELETE FROM rs_tbl_documents WHERE 1=1 ";
				$Sql .= " AND report_id=" . $this->getProperty("report_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	
		public function lstReport()
		{
		$Sql = "SELECT 
						report_id,
						report_category,
						report_subcategory,
						report_title,
						report_file,						
						doc_issue_date,
						report_status,
						period,
						doc_upload_date,
						revision,
						doc_closing_date,
						document_no,
						user_access,
						user_ids
				FROM
					rs_tbl_documents
				WHERE 
					1=1";
		

		if($this->isPropertySet("report_category", "V"))
			$Sql .= " AND report_category=" . $this->getProperty("report_category");
			
		if($this->isPropertySet("report_subcategory", "V"))
			$Sql .= " AND report_subcategory=" . $this->getProperty("report_subcategory");
			
		if($this->isPropertySet("doc_issue_date", "V"))
			$Sql .= " AND doc_issue_date='" . $this->getProperty("doc_issue_date")."'";
			
		if($this->isPropertySet("report_status", "V"))
			$Sql .= " AND report_status=" . $this->getProperty("report_status");
					
		$Sql .= " ORDER BY report_id ASC ";
		
		return $this->dbQuery($Sql);
		}
		
		public function LatestReport()
		{
		$Sql = "SELECT 
												
						max(doc_issue_date)	as max_date			
				FROM
					rs_tbl_documents
				WHERE 
					1=1";
		

		if($this->isPropertySet("report_category", "V"))
			$Sql .= " AND report_category=" . $this->getProperty("report_category");
			
		
			if($this->isPropertySet("report_status", "V"))
			$Sql .= " AND report_status=" . $this->getProperty("report_status");
					
		 $Sql .= " ORDER BY report_id ASC ";
		
		return $this->dbQuery($Sql);
		}
}
