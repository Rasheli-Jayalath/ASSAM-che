<?php
/**
*
* This is a class Order
* @version 0.01
* @author Raju Gautam <raju@devraju.com>
* @Date 23 April, 2008
* @modified 23 April, 2008 by Raju Gautam
*
**/
class Order extends Database{
	public $mOrderStatus = array();
	/**
	* This is the constructor of the class Order
	* @author Raju Gautam <raju@devraju.com>
	* @date 23 April, 2008
	* @modified 23 April, 2008 by Raju Gautam
	*/
	public function __construct(){
		parent::__construct();
		if($_COOKIE['OrderCode']){
			$this->mOrderCode = $_COOKIE['OrderCode'];
		}
		else if($_SESSION['OrderCode']){
			$this->mOrderCode = $_SESSION['OrderCode'];
		}
		$this->mOrderStatus = array('Pending', 'In Proccess', 'Delivered', 'Cancelled');
	}

	/**
	* Order::lstOrder()	
	* This function is used to list all the orders
	* @author Raju Gautam
	* @Date 23 April, 2008
	* @modified 23 April, 2008 by Raju Gautam
	* @return bool
	*/
	public function lstOrder(){
		$Sql = "SELECT 
					a.order_cd,
					a.customer_cd,
					b.first_name,
					b.last_name,
					CONCAT(b.first_name,' ',b.last_name) AS fullname,
					b.email,
					a.order_date,
					a.sub_total,
					(SELECT COUNT(order_detail_id) FROM rs_tbl_order_details WHERE order_cd=a.order_cd) as total_orders,
					a.tax,
					a.shipping_type,
					a.ship_charge,
					a.delivery_time,
					a.grand_total,
					a.order_status,
					a.payment_method,
					a.bank_name,
					a.account_name,
					a.account_number,
					a.product_type,
					a.admin_cd,
					a.grand_total_cost
				FROM
					rs_tbl_order a 
					INNER JOIN rs_tbl_customer b ON a.customer_cd=b.customer_cd
				WHERE
					1=1";
		
		if($this->isPropertySet("order_cd", "V")){
			$Sql .= " AND a.order_cd='" . $this->getProperty("order_cd") . "'";
		}
		
		if($this->isPropertySet("customer_cd", "V")){
			$Sql .= " AND a.customer_cd=" . $this->getProperty("customer_cd");
		}
		if($this->isPropertySet("product_type", "V")){
			$Sql .= " AND a.product_type=" . $this->getProperty("product_type");
		}
		
		if($this->isPropertySet("from_dt", "V") && $this->isPropertySet("to_dt", "V")){
			$Sql .= " AND LEFT(a.order_date, 10) BETWEEN '" . $this->getProperty("from_dt") . "' AND '" . $this->getProperty("to_dt") . "'";
		}
		
	/*	if($this->isPropertySet("order_archive", "V")){
			$Sql .= " AND (a.order_status='Delivered' OR a.order_status='Archived')";
		}
		else{
			if($this->isPropertySet("order_status", "V")){
				$Sql .= " AND a.order_status='" . $this->getProperty("order_status") . "'";
			}
			
			else{
				$Sql .= " AND (a.order_status!='Delivered' && a.order_status!='Archived')";
			}
			
		}*/
		
		if($this->isPropertySet("customer_name", "V")){
			$Sql .= " AND ((b.first_name LIKE '%" . $this->getProperty("customer_name") . "%' OR b.last_name LIKE '%" . $this->getProperty("customer_name") . "%')";
			$Sql .= " OR (b.email='" . $this->getProperty("customer_name") . "'))";
		}
		
		if($this->isPropertySet("from_date", "V") && $this->isPropertySet("to_date", "V")){
			$Sql .= " AND a.order_date BETWEEN '" . $this->getProperty("from_date") . "' AND '" . $this->getProperty("to_date") . "'";
		}
		if($this->isPropertySet("title", "V")){
			$Sql .= " ORDER BY b.first_name " . $this->getProperty("title");
			
		}  elseif($this->isPropertySet("priceasc", "V")){
					$Sql .= " ORDER BY a.grand_total " . $this->getProperty("priceasc");
					
		} elseif($this->isPropertySet("pricedesc", "V")){
					$Sql .= " ORDER BY a.grand_total " . $this->getProperty("pricedesc");					

		}
		 elseif($this->isPropertySet("costasc", "V")){
					$Sql .= " ORDER BY a.grand_total_cost " . $this->getProperty("costasc");
					
		} elseif($this->isPropertySet("costdesc", "V")){
					$Sql .= " ORDER BY a.grand_total_cost " . $this->getProperty("costdesc");					

		}  elseif($this->isPropertySet("dateasc", "V")){
					$Sql .= " ORDER BY a.order_date " . $this->getProperty("dateasc");
		} elseif($this->isPropertySet("datedesc", "V")){
					$Sql .= " ORDER BY a.order_date " . $this->getProperty("datedesc");
		} 
		
		else
		{
		$Sql .= " GROUP BY a.order_cd ORDER BY a.order_date DESC";
		}
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		//printPre($Sql);
		return $this->dbQuery($Sql);
	}
	
	/**
	* Order::actOrder()	
	* This function is used to Add/Edit/Delete the order
	* @author Raju Gautam
	* @Date 14 April, 2008
 	* @param int $mode	
	* @modified 14 April, 2008 by Raju Gautam
	* @return string
	*/
	public function actOrder($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case 'I':
				$Sql = "INSERT INTO rs_tbl_order(
						order_cd,
						customer_cd,
						order_date,
						sub_total,
						tax,
						shipping_type,
						ship_charge,
						delivery_time,
						grand_total,
						order_status,
						payment_method,
						bank_name,
						account_name,
						account_number,
						product_type,
						admin_cd,
						grand_total_cost) 
						VALUES(";
				$Sql .= $this->isPropertySet("order_cd", "V") ? "'" . $this->getProperty("order_cd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("customer_cd", "V") ? "'" . $this->getProperty("customer_cd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("order_date", "V") ? "'" . $this->getProperty("order_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("sub_total", "V") ? $this->getProperty("sub_total") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("tax", "V") ? $this->getProperty("tax") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("shipping_type", "V") ? "'" . $this->getProperty("shipping_type") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("ship_charge", "V") ? $this->getProperty("ship_charge") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("delivery_time", "V") ? "'" . $this->getProperty("delivery_time") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("grand_total", "V") ? $this->getProperty("grand_total") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("order_status", "V") ? "'" . $this->getProperty("order_status") . "'" : "NULL";
				
				$Sql .= ",";
				$Sql .= $this->isPropertySet("payment_method", "V") ? "'" . $this->getProperty("payment_method") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("bank_name", "V") ? "'" . $this->getProperty("bank_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("account_name", "V") ? "'" . $this->getProperty("account_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("account_number", "V") ? "'" . $this->getProperty("account_number") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_type", "V") ? "'" . $this->getProperty("product_type") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("admin_cd", "V") ? "'" . $this->getProperty("admin_cd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("grand_total_cost", "V") ? "'" . $this->getProperty(
				"grand_total_cost") . "'" : "NULL";
				$Sql .= ")";
				break;
			case 'U':
				$Sql = "UPDATE rs_tbl_order SET ";
				if($this->isPropertySet("order_status", "K")){
					$Sql .= "$con order_status='" . $this->getProperty("order_status") . "'";
					$con = ",";
				}
				
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("order_cd", "V"))
					$Sql .= " AND order_cd='" . $this->getProperty("order_cd") . "'";
				
				break;
			case 'D':
				$Sql = "DELETE FROM 
							rs_tbl_order  
						WHERE
							1=1";
				if($this->isPropertySet("order_cd", "V"))
					$Sql .= " AND order_cd='" . $this->getProperty("order_cd") . "'";
				
				break;
			case 'SA':
				$Sql = "UPDATE rs_tbl_order SET
							order_status='Archived'  
						WHERE
							1=1 
							AND order_cd='" . $this->getProperty("order_cd") . "'";
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
	/**
	* Order::lstOrderDetails()	
	* This function is used to list all the order details
	* @author Raju Gautam
	* @Date 23 April, 2008
	* @modified 23 April, 2008 by Raju Gautam
	* @return bool
	*/
	/*
	public function lstOrderDetails(){
		$Sql = "SELECT 
					a.order_detail_id,
					a.order_cd,
					a.product_cd,
					a.product_name,
					(SELECT image_name FROM rs_tbl_product_images WHERE product_cd=a.product_cd AND is_primary=1) as image_name,
					(SELECT image_cd FROM rs_tbl_product_images WHERE product_cd=a.product_cd AND is_primary=1) as image_cd,
					a.quantity,
					a.price,
					a.size_cd,
					(SELECT product_size FROM rs_tbl_product_sizes WHERE size_cd=a.size_cd) as product_size,
					b.customer_cd,
					(SELECT CONCAT(first_name, ' ', last_name) as fullname FROM rs_tbl_customer WHERE customer_cd=b.customer_cd) as fullname
				FROM
					rs_tbl_order_details a 
					INNER JOIN rs_tbl_order b ON a.order_cd=b.order_cd
				WHERE
					1=1";
		
		if($this->isPropertySet("order_cd", "V")){
			$Sql .= " AND a.order_cd='" . $this->getProperty("order_cd") . "'";
		}
		
		if($this->isPropertySet("customer_cd", "V")){
			$Sql .= " AND b.customer_cd='" . $this->getProperty("customer_cd") . "'";
		}
	
		$Sql .= " ORDER BY a.order_detail_id DESC";
		
		return $this->dbQuery($Sql);
	}
	*/
	
	public function lstOrderDetails(){
		$Sql = "SELECT 
	rs_tbl_order.customer_cd,
	rs_tbl_order.order_cd,	
	rs_tbl_order_details.order_detail_id,
	rs_tbl_order_details.quantity,
	rs_tbl_order_details.price,
	rs_tbl_order_details.size_cd as product_size,
	rs_tbl_order_details.product_id,
	rs_tbl_products.image_name,
	rs_tbl_products.product_name,
	CONCAT(rs_tbl_customer.first_name, ' ', rs_tbl_customer.last_name) as fullname,
	rs_tbl_products.product_sale_price,
	rs_tbl_products.product_cost_price
 FROM rs_tbl_order, rs_tbl_order_details, rs_tbl_products, rs_tbl_customer WHERE 1=1 
		AND 
	rs_tbl_order.order_cd=rs_tbl_order_details.order_cd 
		AND
	rs_tbl_order_details.product_id=rs_tbl_products.product_id
		AND
	rs_tbl_order_details.customer_cd=rs_tbl_customer.customer_cd";
		
		if($this->isPropertySet("order_cd", "V")){
			$Sql .= " AND rs_tbl_order.order_cd='" . $this->getProperty("order_cd") . "'";
		}
		
		if($this->isPropertySet("customer_cd", "V")){
			$Sql .= " AND rs_tbl_order_details.customer_cd='" . $this->getProperty("customer_cd") . "'";
		}
	
		$Sql .= " GROUP BY rs_tbl_order_details.product_id ORDER BY rs_tbl_order_details.order_detail_id DESC";
		
		return $this->dbQuery($Sql);
	}
    public function lstOrderDetailsD(){
		$Sql = "SELECT 
	rs_tbl_order.customer_cd,
	rs_tbl_order.order_cd,	
	rs_tbl_order_details.order_detail_id,
	rs_tbl_order_details.quantity,
	rs_tbl_order_details.price,
	rs_tbl_order_details.size_cd as product_size,
	rs_tbl_order_details.product_id,
	rs_tbl_diamonds.di_name,
	
	CONCAT(rs_tbl_customer.first_name, ' ', rs_tbl_customer.last_name) as fullname
	
 FROM rs_tbl_order, rs_tbl_order_details, rs_tbl_diamonds, rs_tbl_customer WHERE 1=1 
		AND 
	rs_tbl_order.order_cd=rs_tbl_order_details.order_cd 
		AND
	rs_tbl_order_details.product_id=rs_tbl_diamonds.di_id
		AND
	rs_tbl_order_details.customer_cd=rs_tbl_customer.customer_cd";
		
		if($this->isPropertySet("order_cd", "V")){
			$Sql .= " AND rs_tbl_order.order_cd='" . $this->getProperty("order_cd") . "'";
		}
		
		if($this->isPropertySet("customer_cd", "V")){
			$Sql .= " AND rs_tbl_order_details.customer_cd='" . $this->getProperty("customer_cd") . "'";
		}
	
		$Sql .= " GROUP BY rs_tbl_order_details.product_id ORDER BY rs_tbl_order_details.order_detail_id DESC";
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* Order::actOrderDetail()	
	* This function is used to Add/Edit/Delete the wishlist
	* @author Raju Gautam
	* @Date 23 April, 2008
 	* @param string $mode	
	* @modified 23 April, 2008 by Raju Gautam
	* @return string
	*/
	public function actOrderDetail($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case 'I':
				$Sql = "INSERT INTO rs_tbl_order_details(
						order_detail_id,
						order_cd,
						customer_cd,
						product_id,
						product_name,
						size_cd,
						quantity,
						price,
						product_type) 
						VALUES(";
				$Sql .= $this->isPropertySet("order_detail_id", "V") ? $this->getProperty("order_detail_id") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("order_cd", "V") ? "'" . $this->getProperty("order_cd") . "'" : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("customer_cd", "V") ? $this->getProperty("customer_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_id", "V") ? "'" . $this->getProperty("product_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_name", "V") ? "'" . $this->getProperty("product_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("size_cd", "V") ? $this->getProperty("size_cd") : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("quantity", "V") ? $this->getProperty("quantity") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("price", "V") ? $this->getProperty("price") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("product_type", "V") ? $this->getProperty("product_type") : "NULL";
				$Sql .= ")";
				break;
			case 'U':
				break;
			case 'D':
				$Sql = "DELETE FROM 
							rs_tbl_order_details 
						WHERE
							1=1";
				if($this->isPropertySet("order_cd", "V"))
					$Sql .= " AND order_cd='" . $this->getProperty("order_cd") . "'";
				else
					$Sql .= " AND order_detail_id=" . $this->getProperty("order_detail_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
}
?>