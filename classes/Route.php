<?php
/**
*
* The class Route
* @version 0.01
* @author Raju Gautam  <raju@devraju.com>
* @Date 06 July 2009
* @modified 06 July 2009 by Raju Gautam
*
**/
class Route extends Database{
	/**
	* This is the constructor of the class Route
	* @author Raju Gautam
	* @Date 06 July 2009
	* @modified 06 July 2009 by Raju Gautam
	*/
	public function __construct(){
		parent::__construct();
	}

	/**
	* This function is used to prepare the url
	* @author Raju Gautam
	* @Date 06 July 2009
	* @modified 06 July 2009 by Raju Gautam
	*/
	public static function _($url = ''){
		$ret = SITE_URL;
		if(MOD_REWRITE == 'false'){
			if(!empty($url)):
				$ret .= '?' . $url;
			endif;
		}
		else{
			$qs = split('&', $url);
			$total = count($qs);
			list($page, $show) = split('=', $qs[0]);
			unset($qs[0]);
			$qstring = $show;
			
			if($qs[1]){
				list($k, $v) = split('=', $qs[1]);
				if($show == 'products' && $k == 'category_cd')
				{
					unset($qs[1]);
					$objProduct = new Product;
					$objProduct->setProperty('category_cd', $v);
					$objProduct->lstSubCategories();
					$row_cat = $objProduct->dbFetchArray(1);
					$qstring .= '/' . $row_cat['url_key'];
				}
				else if($show == 'product' && $k == 'product_id'){
					unset($qs[1]);
					$objProduct = new Product;
					$objProduct->setProperty('product_id', $v);
					$objProduct->lstProducts();
					$row_prd = $objProduct->dbFetchArray(1);
					$qstring .= '/' . $row_prd['url_key'];
				}
				else if($show == 'category' && $k == 'category_cd'){
					unset($qs[1]);
					$objProduct = new Product;
					$objProduct->setProperty('category_cd', $v);
					$objProduct->lstCategories();
					$row_prd = $objProduct->dbFetchArray(1);
					$qstring .= '/' . $row_prd['url_key'];
				}
				else if($show == 'cms' && $k == 'content'){
					unset($qs[1]);
					$qstring .= '/' . $v;
				}
			}
			
			if(!empty($url))
				$qstring .= '/';
			if(isset($qs[1]))
				$start = 1;
			else if(isset($qs[2]))
				$start = 2;
			if($qs[$start]){
				$qstring .= '?';
				for($i = $start; $i < $total; $i++):
					list($k1, $v1) = split('=', $qs[$i]);
					$qstring .= $k1 . '=' . $v1 . '&';
				endfor;
			}
			if($show == 'products' && $v == 16){
				//echo $qstring;
			}
			$qstring = preg_replace('/\&$/', '', $qstring);
			$ret .= $qstring;
		}
		return $ret;
	}
	
	/**
	* This function is used to prepare the category url key
	* @author Raju Gautam
	* @Date 06 July 2009
	* @modified 06 July 2009 by Raju Gautam
	*/
	public function getCategoryKey($name, $category_cd = 0){
		$find 		= array(' ', '_', '&', '%', "'", '"', '(', ')', '[', ']', '.', ',', '/', '\\', '=', '+', '*');
		$replace 	= '-';
		$key 		= str_replace($find, $replace, strtolower($name));
		$key		= str_replace('--', $replace, $key);
		$key		= str_replace('--', $replace, $key);
		$key		= preg_replace('/\-$/', '', $key);
		
		// check if already 
		$Sql = "SELECT url_key FROM rs_tbl_category WHERE url_key LIKE '" . $key . "%'";
		if(!empty($category_cd)){
			$Sql .= " AND category_cd!=" . $category_cd;
		}
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			$key = $key . '-' . $this->totalRecords();
		}
		return $key;
	}
	
	/**
	* This function is used to prepare the partner url key
	* @author Numan Tahir
	* @Date 15 July 2010
	* @modified 15 July 2010 by Numan Tahir
	*/
	public function getPartnerKey($name, $category_cd = 0){
		$find 		= array(' ', '_', '&', '%', "'", '"', '(', ')', '[', ']', '.', ',', '/', '\\', '=', '+', '*');
		$replace 	= '-';
		$key 		= str_replace($find, $replace, strtolower($name));
		$key		= str_replace('--', $replace, $key);
		$key		= str_replace('--', $replace, $key);
		$key		= preg_replace('/\-$/', '', $key);
		
		// check if already 
		$Sql = "SELECT url_key FROM rs_tbl_partners WHERE url_key LIKE '" . $key . "%'";
		if(!empty($category_cd)){
			$Sql .= " AND partner_cd!=" . $category_cd;
		}
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			$key = $key . '-' . $this->totalRecords();
		}
		return $key;
	}
	/**
	* This function is used to prepare the category url key
	* @author Raju Gautam
	* @Date 06 July 2009
	* @modified 06 July 2009 by Raju Gautam
	*/
	public function getSubCategoryKey($name, $SubCatId = 0){
		$find 		= array(' ', '_', '&', '%', "'", '"', '(', ')', '[', ']', '.', ',', '/', '\\', '=', '*');
		$replace 	= '-';
		$key 		= str_replace($find, $replace, strtolower($name));
		$key		= str_replace('--', $replace, $key);
		$key		= str_replace('--', $replace, $key);
		$key		= preg_replace('/\-$/', '', $key);
		
		// check if already 
		$Sql = "SELECT url_key FROM rs_tbl_sub_category WHERE url_key LIKE '" . $key . "%'";
		if(!empty($category_cd)){
			$Sql .= " AND sub_cat_id!=" . $SubCatId;
		}
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			$key = $key . '-' . $this->totalRecords();
		}
		return $key;
	}
	
	/**
	* This function is used to prepare the category url key
	* @author Raju Gautam
	* @Date 06 July 2009
	* @modified 06 July 2009 by Raju Gautam
	*/
	public function getProductKey($name, $product_cd = 0){
		$find 		= array(' ', '_', '&', '%', "'", '"', '(', ')', '[', ']', '.', ',', '/', '\\', '=', '+', '*');
		$replace 	= '-';
		$key 		= str_replace($find, $replace, strtolower($name));
		$key		= str_replace('--', $replace, $key);
		$key		= str_replace('--', $replace, $key);
		$key		= preg_replace('/\-$/', '', $key);
		
		// check if already 
		$Sql = "SELECT url_key FROM rs_tbl_products WHERE url_key LIKE '" . $key . "%'";
		if(!empty($product_cd)){
			$Sql .= " AND product_cd!='" . $product_cd . "'";
		}
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			$key = $key . '-' . $this->totalRecords();
		}
		return $key;
	}

}
