<?php
/**
*
* This is a class Cart
* @version 0.01
* @author Raju Gautam <raju@devraju.com>
* @Date 14 April, 2008
* @modified 14 April, 2008 by Raju Gautam
*
**/
class Cart extends Database{
	private $mOrderCode = ""; # The shopping order code
	/**
	* This is the constructor of the class Cart
	* @author Raju Gautam <raju@devraju.com>
	* @Date 14 April, 2008
	* @modified 15 April, 2008 by Raju Gautam
	*/
	public function __construct(){
		parent::__construct();
		if($_SESSION['OrderCode']){
			$this->mOrderCode = $_SESSION['OrderCode'];
		}
	}

	/**
	* Product::genOrderCode()	
	* This function is used to get 15 degit unique order code
	* @author Raju Gautam
	* @Date 14 April, 2008
 	* @param int $cart_cd	
	* @modified 14 April, 2008 by Raju Gautam
	* @return string
	*/
	public function genOrderCode($cart_cd){
		$cart_cd 	= str_pad($cart_cd, 5, "0", STR_PAD_LEFT);
		$time 		= md5(time());
		$order_cd 	= substr($time, rand(0, 22), 6);
		$order_cd	= $order_cd . $cart_cd;
		$_SESSION['OrderCode'] = $order_cd;
		setcookie("OrderCode", $order_cd, time() + 60 * 60 * 24 * 30);
		return $order_cd;
	}
	
	/**
	* Product::getOrderCode()	
	* This function is used to get 15 degit unique order code
	* @author Raju Gautam
	* @Date 14 April, 2008
	* @modified 14 April, 2008 by Raju Gautam
	* @return string
	*/
	public function getOrderCode(){
		if($this->mOrderCode){
			return $this->mOrderCode;
		}
		else{
			return false;
		}
	}
	
	/**
	* Product::showCart()	
	* This function is used to show the cart
	* @author Raju Gautam
	* @Date 14 April, 2008
 	* @param int $product_id	
	* @modified 14 April, 2008 by Raju Gautam
	* @return string
	*/
	//ALTER TABLE `rs_tbl_cart` ADD `color_cd` INT( 11 ) NOT NULL AFTER `size_cd` 
	/*
	public function showCart(){
		$Sql = "SELECT 
					a.cart_cd,
					a.order_cd,
					a.customer_cd,
					a.product_cd,
					a.size_cd,
					a.color_cd,
					a.quantity,
					a.price,
					a.add_date,
					(SELECT 
						rs_tbl_category_lang.category_name 
					FROM 
						rs_tbl_category 
						INNER JOIN rs_tbl_category_lang ON rs_tbl_category.category_cd=rs_tbl_category_lang.category_cd
					WHERE 
						rs_tbl_category_lang.category_cd=b.category_cd 
						AND rs_tbl_category_lang.language_cd='" . SITE_LANG . "'
					) AS category_name,
					c.product_name,
					c.product_desc AS prodct_descritpion,
					(SELECT image_name FROM rs_tbl_product_images WHERE product_cd=a.product_cd LIMIT 0, 1) as image_name
				FROM
					rs_tbl_cart a 
					INNER JOIN rs_tbl_products b ON a.product_cd=b.product_cd 
					INNER JOIN rs_tbl_product_lang c ON b.product_cd=c.product_cd
				WHERE
					1=1 
					AND a.order_cd='" . $this->getProperty("order_cd") . "' 
					AND c.language_cd='" . SITE_LANG . "'";
		
		if($this->isPropertySet("product_cd", "V")){
			$Sql .= " AND a.product_cd='" . $this->getProperty("product_cd") . "'";
		}
		
		if($this->isPropertySet("color_cd", "V")){
			$Sql .= " AND a.color_cd=" . $this->getProperty("color_cd");
		}
		
		if($this->isPropertySet("size_cd", "V")){
			$Sql .= " AND a.size_cd=" . $this->getProperty("size_cd");
		}
		
		$Sql .= " ORDER BY a.add_date ASC";
		
		return $this->dbQuery($Sql);
	}
	*/
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function showCart(){
		$Sql = "SELECT 
					rs_tbl_cart.cart_cd, 
					rs_tbl_cart.order_cd, 
					rs_tbl_cart.quantity, 
					rs_tbl_cart.price, 
					rs_tbl_cart.add_date,
					rs_tbl_cart.product_id, 
					rs_tbl_cart.cart_lng, 
					rs_tbl_cart.cost, 
					rs_tbl_products.category_cd, 
					rs_tbl_cart.product_type,
					rs_tbl_products.product_name
					FROM rs_tbl_cart, rs_tbl_products 
					WHERE 1=1
					AND rs_tbl_cart.order_cd='" . $this->getProperty("order_cd") . "' 
					AND rs_tbl_cart.cart_lng='" . SITE_LANG . "'
					AND rs_tbl_cart.product_id=rs_tbl_products.product_id";
		
		if($this->isPropertySet("product_id", "V")){
			$Sql .= " AND rs_tbl_cart.product_id='" . $this->getProperty("product_id") . "'";
		}
		
		if($this->isPropertySet("color_cd", "V")){
			$Sql .= " AND rs_tbl_cart.color_cd=" . $this->getProperty("color_cd");
		}
		
		if($this->isPropertySet("size_cd", "V")){
			$Sql .= " AND rs_tbl_cart.size_cd=" . $this->getProperty("size_cd");
		}
		
		$Sql .= " ORDER BY rs_tbl_cart.add_date ASC";
		
		return $this->dbQuery($Sql);
	}


   public function showCartD(){
		$Sql = "SELECT 
					rs_tbl_cart.cart_cd, 
					rs_tbl_cart.order_cd, 
					rs_tbl_cart.quantity, 
					rs_tbl_cart.price, 
					rs_tbl_cart.add_date,
					rs_tbl_cart.product_id, 
					rs_tbl_diamonds.di_id, 
					rs_tbl_cart.cart_lng, 
					rs_tbl_cart.cost, 
					rs_tbl_cart.product_type,
					rs_tbl_diamonds.di_name
					FROM rs_tbl_cart, rs_tbl_diamonds
					WHERE 1=1
					AND rs_tbl_cart.order_cd='" . $this->getProperty("order_cd") . "' 
					AND rs_tbl_cart.cart_lng='" . SITE_LANG . "'
					AND rs_tbl_cart.product_id=rs_tbl_diamonds.di_id";
		
		if($this->isPropertySet("product_id", "V")){
			$Sql .= " AND rs_tbl_cart.product_id='" . $this->getProperty("product_id") . "'";
		}
		
		if($this->isPropertySet("color_cd", "V")){
			$Sql .= " AND rs_tbl_cart.color_cd=" . $this->getProperty("color_cd");
		}
		
		if($this->isPropertySet("size_cd", "V")){
			$Sql .= " AND rs_tbl_cart.size_cd=" . $this->getProperty("size_cd");
		}
		
		$Sql .= " ORDER BY rs_tbl_cart.add_date ASC";
		
		return $this->dbQuery($Sql);
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
	/**
	* Product::actCart()	
	* This function is used to Add/Edit/Delete the cart
	* @author Raju Gautam
	* @Date 14 April, 2008
 	* @param int $mode	
	* @modified 14 April, 2008 by Raju Gautam
	* @return string
	*/
	public function actCart($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case 'I':
				$Sql = "INSERT INTO rs_tbl_cart(
						cart_cd,
						order_cd,
						customer_cd,
						product_id,
						quantity,
						price,
						add_date,
						cart_lng,
						cost,
						product_type) 
						VALUES(";
				$Sql .= $this->isPropertySet("cart_cd", "V") ? $this->getProperty("cart_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("order_cd", "V") ? "'" . $this->getProperty("order_cd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("customer_cd", "V") ? $this->getProperty("customer_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_id", "V") ? "'" . $this->getProperty("product_id") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("quantity", "V") ? $this->getProperty("quantity") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("price", "V") ? $this->getProperty("price") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("add_date", "V") ? "'" . $this->getProperty("add_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cart_lng", "V") ? "'" . $this->getProperty("cart_lng") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cost", "V") ? "'" . $this->getProperty("cost") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_type", "V") ? "'" . $this->getProperty("product_type") . "'" : "NULL";
				$Sql .= ")";
				break;
			case 'U':
				$Sql = "UPDATE rs_tbl_cart SET ";
				
				if($this->isPropertySet("quantity", "K")){
					$Sql .= "$cat quantity=" . $this->getProperty("quantity");
					$cat = ",";
				}
				if($this->isPropertySet("price", "K")){
					$Sql .= "$cat price=" . $this->getProperty("price");
					$cat = ",";
				}
				if($this->isPropertySet("cost", "K")){
					$Sql .= "$cat cost=" . $this->getProperty("cost");
					$cat = ",";
				}
			
				$Sql .= " WHERE 1=1";
				$Sql .= " AND cart_cd=" . $this->getProperty("cart_cd");	
				break;
			case 'D':
				$Sql = "DELETE FROM 
							rs_tbl_cart  
						WHERE
							1=1";
				// if($this->isPropertySet("product_id", "V"))
				// $Sql .= " AND product_id='" . $this->getProperty("product_id") . "'";
				// else 
				if($this->isPropertySet("order_cd", "V"))
				 $Sql .= " AND order_cd='" . $this->getProperty("order_cd") . "'";
				 else
					$Sql .= " AND cart_cd=" . $this->getProperty("cart_cd");
				break;
			default:
				break;
		}
		
		$this->dbQuery($Sql);
	}
	
	/**
	* Product::lstWishlist()	
	* This function is used to list the wishlisted products
	* @author Raju Gautam
	* @Date 14 April, 2008
 	* @param int $product_id	
	* @modified 14 April, 2008 by Raju Gautam
	* @return string
	*/
	public function lstWishlist(){
		$Sql = "SELECT 
					a.wishlist_cd,
					a.customer_cd,
					a.product_cd,
					a.add_date,
					(SELECT 
						rs_tbl_category_lang.category_name 
					FROM 
						rs_tbl_category 
						INNER JOIN rs_tbl_category_lang ON rs_tbl_category.category_cd=rs_tbl_category_lang.category_cd
					WHERE 
						rs_tbl_category_lang.category_cd=b.category_cd 
						AND rs_tbl_category_lang.language_cd='" . SITE_LANG . "'
					) AS category_name,
					b.product_name,
					b.prodct_descritpion,
					b.image_name
				FROM
					rs_tbl_wishlist a 
					INNER JOIN rs_tbl_products b ON a.product_cd=b.product_cd 
					INNER JOIN rs_tbl_product_lang c ON b.product_cd=c.product_cd
				WHERE
					1=1 
					AND a.customer_cd=" . $this->getProperty("customer_cd") . "
					AND c.language_cd='" . SITE_LANG . "'";
		
		if($this->isPropertySet("product_cd", "V"))
			$Sql .= " AND a.product_cd='" . $this->getProperty("product_cd") . "'";
		
		$Sql .= " 
				ORDER BY a.add_date ASC";
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Product::actWishList()	
	* This function is used to Add/Edit/Delete the wishlist
	* @author Raju Gautam
	* @Date 14 April, 2008
 	* @param int $mode	
	* @modified 14 April, 2008 by Raju Gautam
	* @return string
	*/
	public function actWishList($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case 'I':
				$Sql = "INSERT INTO rs_tbl_wishlist(
						wishlist_cd,
						customer_cd,
						product_cd,
						size_cd,
						add_date) 
						VALUES(";
				$Sql .= $this->isPropertySet("wishlist_cd", "V") ? $this->getProperty("wishlist_cd") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("customer_cd", "V") ? $this->getProperty("customer_cd") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_cd", "V") ? "'" . $this->getProperty("product_cd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("size_cd", "V") ? $this->getProperty("size_cd") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("add_date", "V") ? "'" . $this->getProperty("add_date") . "'" : "NULL";
				$Sql .= ")";
				break;
			case 'U':
				break;
			case 'D':
				$Sql = "DELETE FROM 
							rs_tbl_wishlist 
						WHERE
							1=1";
				if($this->isPropertySet("customer_cd", "V"))
					$Sql .= " AND customer_cd='" . $this->getProperty("customer_cd") . "'";
				else
					$Sql .= " AND wishlist_cd=" . $this->getProperty("wishlist_cd");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
}
?>