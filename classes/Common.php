<?php
/**
*
* This is a class Common
* @version 0.01
* @author Raju Gautam <raju@devraju.com>
* @Date 17 April, 2008
* @modified 17 April, 2008 by Raju Gautam
*
**/
class Common extends Database{
	public $mTextbox = array();
	public $mTextarea = array();
	public $mRadioYesNo = array();
	public $mSelect = array();
	
	/**
	* This is the constructor of the class Common
	* @author Raju Gautam <raju@devraju.com>
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
	*/
	public function __construct(){
		parent::__construct();
		$this->mTextbox = array('max_amount_for_shipping', 'tax_charge','shipping_charge','site_email','email_from', 'delivery_time');
		$this->mTextarea = array('site_name','meta_title','meta_keywords','meta_desc', 'shipping_types');
		$this->mRadioYesNo = array('seo_url', 'front_image_click');
	}
	
	/**
	* This function is used to list the shipping types
	* @author Raju Gautam <raju@devraju.com>
	* @Date 22 April, 2008
	* @modified 22 April, 2008 by Raju Gautam
	*/
	public function lstShipping(){
		$Sql = "SELECT 
					shipping_cd,
					shipping_name,
					delivery_time,
					shipping_charge
				FROM
					rs_tbl_shipping
				WHERE
					1=1 ";
					
		if($this->isPropertySet("shipping_cd", "V"))
			$Sql .= " AND shipping_cd=" . $this->getProperty("shipping_cd");
		
		$Sql .= " ORDER BY
					shipping_name ASC";
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_shipping the basis of property set
	* @author Raju Gautam
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
	*/
	public function actShipping($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_shipping(
						shipping_cd,
						shipping_name,
						delivery_time,
						shipping_charge)
						VALUES(";
				$Sql .= $this->isPropertySet("shipping_cd", "V") ? $this->getProperty("shipping_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("shipping_name", "V") ? "'" . $this->getProperty("shipping_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("delivery_time", "V") ? "'" . $this->getProperty("delivery_time") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("shipping_charge", "V") ? $this->getProperty("shipping_charge") : "0";
				
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_shipping SET ";
				if($this->isPropertySet("shipping_name", "K")){
					$Sql .= "$con shipping_name='" . $this->getProperty("shipping_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("delivery_time", "K")){
					$Sql .= "$con delivery_time='" . $this->getProperty("delivery_time") . "'";
					$con = ",";
				}
				if($this->isPropertySet("shipping_charge", "K")){
					$Sql .= "$con shipping_charge=" . $this->getProperty("shipping_charge");
					$con = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND shipping_cd=" . $this->getProperty("shipping_cd");
				break;
			case "D":
				$Sql = "DELETE FROM 
							rs_tbl_shipping 
						WHERE
							1=1 
							AND shipping_cd=" . $this->getProperty("shipping_cd");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
	/**
	* This method is used to populate the shipping combo
	* @author Raju Gautam
	* @Date 22 April, 2008
	* @modified 22 April, 2008 by Raju Gautam
	*/
	public function shippingCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					shipping_cd,
					shipping_name,
					delivery_time,
					shipping_charge
				FROM
					rs_tbl_shipping
				WHERE
					1=1";
					
		
		$this->dbQuery($Sql);
		while($rows = $this->dbFetchArray(1)){
			if($rows['shipping_cd'] == $sel)
				$opt .= "<option value=\"" . $rows['shipping_cd'] . "\" selected>" . $rows['shipping_name'] . " - " . CURRENCY_SYMBOL . ' ' . $rows['shipping_charge'] . "</option>\n";
			else
				$opt .= "<option value=\"" . $rows['shipping_cd'] . "\">" . $rows['shipping_name'] . " - " . CURRENCY_SYMBOL . ' ' . $rows['shipping_charge'] . "</option>\n";
		}
		return $opt;
	}
	
	/**
	* This method is used to populate the language combo
	* @author Raju Gautam
	* @Date 22 April, 2008
	* @modified 22 April, 2008 by Raju Gautam
	*/
	public function langCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					lang_short,
					lang_name
				FROM
					rs_tbl_langs
				WHERE
					1=1 
					AND status='Y'";
		$this->dbQuery($Sql);
		while($rows = $this->dbFetchArray(1)){
			if($rows['lang_short'] == $sel)
				$opt .= "<option value=\"" . $rows['lang_short'] . "\" selected=\"selected\">" . $rows['lang_name'] . "</option>\n";
			else
				$opt .= "<option value=\"" . $rows['lang_short'] . "\">" . $rows['lang_name'] . "</option>\n";
		}
		return $opt;
	}
	
	/**
	* This method is used to populate the language combo
	* @author Raju Gautam
	* @Date 22 April, 2008
	* @modified 22 April, 2008 by Raju Gautam
	*/
	public function langFlag(){
		$opt = "";
		$opt .= '<span><a href="'.SITE_URL.'?C=LNG&lang=EN"><img src="'. SITE_URL .'images/lan_eng.gif" alt="English" title="English" /></a></span>';
		$opt .= '<span><a href="'.SITE_URL.'?C=LNG&lang=NL"><img src="'. SITE_URL .'images/lan_dutch.gif" alt="Dutch" title="Dutch" /></a></span>';

		return $opt;
	}
	
	/**
    * This function is used to list the newsletter groups
    * @author Raju Gautam <raju@devraju.com>
    * @Date 22 April, 2008
    * @modified 22 April, 2008 by Raju Gautam
    */
    public function lstLanguages(){
        $Sql = "SELECT 
                    lang_cd,
                    lang_name,
                    lang_short,
                    status
                FROM
                    rs_tbl_langs
                WHERE
                    1=1 ";
                    
        if($this->isPropertySet("lang_cd", "V"))
            $Sql .= " AND lang_cd=" . $this->getProperty("lang_cd");
        
		if($this->isPropertySet("lang_short", "V"))
            $Sql .= " AND lang_short='" . $this->getProperty("lang_short") . "'";
        
        if($this->isPropertySet("status", "V"))
            $Sql .= " AND status='" . $this->getProperty("status") . "'";
        
        $Sql .= " ORDER BY
                    lang_name ASC";
        return $this->dbQuery($Sql);
    }
    
    /**
    * This function is used to perform DML (Delete/Update/Add)
    * on the table rs_tbl_langs the basis of property set
    * @author Raju Gautam
    * @Date 17 April, 2008
    * @modified 17 April, 2008 by Raju Gautam
    */
    public function actLanguage($mode){
        $mode = strtoupper($mode);
        switch($mode){
            case "I":
                $Sql = "INSERT INTO rs_tbl_langs(
                        lang_cd,
                        lang_name,
						lang_short,
						status)
                        VALUES(";
                $Sql .= $this->isPropertySet("lang_cd", "V") ? $this->getProperty("lang_cd") : "NULL";
                $Sql .= ",";
                $Sql .= $this->isPropertySet("lang_name", "V") ? "'" . $this->getProperty("lang_name") . "'" : "NULL";
                $Sql .= ",";
                $Sql .= $this->isPropertySet("lang_short", "V") ? "'" . $this->getProperty("lang_short") . "'" : "NULL";
                $Sql .= ",";
                $Sql .= $this->isPropertySet("status", "V") ? "'" . $this->getProperty("status") . "'" : "NULL";
                
                $Sql .= ")";
                break;
            case "U":
                $Sql = "UPDATE rs_tbl_langs SET ";
                if($this->isPropertySet("lang_name", "K")){
                    $Sql .= "$con lang_name='" . $this->getProperty("lang_name") . "'";
                    $con = ",";
                }
                if($this->isPropertySet("status", "K")){
                    $Sql .= "$con status='" . $this->getProperty("status") . "'";
                    $con = ",";
                }
                
                $Sql .= " WHERE 1=1";
                $Sql .= " AND lang_cd=" . $this->getProperty("lang_cd");
                break;
            case "D":
                $Sql = "DELETE FROM 
                            rs_tbl_langs 
                        WHERE
                            1=1 
                            AND lang_cd=" . $this->getProperty("lang_cd");
                break;
            default:
                break;
        }
        return $this->dbQuery($Sql);
    }
    
	/**
	* This function is used to get the page to be included
	* @author Raju Gautam <raju@devraju.com>
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
	*/
	public function getPage($page){
		if(isset($page) && !empty($page)){
			$filename = HTML_PATH . ($page) . '.default' . '.php';
			if(file_exists($filename))
				require_once(HTML_PATH . ($page) . '.default' . '.php');
			else
				require_once(HTML_PATH . '404' . '.php');
		}
		else{
			require_once(HTML_PATH . 'default.php');
		}
	}
	
	/**
	* This method is used to get a particular configuration value
	* @author Raju Gautam
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
	*/
	public function getConfigValue($key){
		if($key){
			$sql = "SELECT
						config_value
					FROM
						rs_tbl_config
					WHERE
						config_key='" . $key . "'";
			$this->dbQuery($sql);
			$rows = $this->dbFetchArray(1);
			return $rows['config_value'];
		}
		else{
			return false;
		}
	}
	
	/**
	* This method is used to list the configurations
	* @author Raju Gautam
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
	*/
	public function lstConfig(){
		$Sql = "SELECT
					config_cd,
					config_category,
					config_caption,
					config_key,
					config_value,
					config_order
				FROM
					rs_tbl_config
				WHERE
					1=1";
		if($this->isPropertySet("config_cd", "V"))
			$Sql .= " AND config_cd=" . $this->getProperty("config_cd");
		
		if($this->isPropertySet("config_category", "V"))
			$Sql .= " AND config_category='" . $this->getProperty("config_category") . "'";
		
		if($this->isPropertySet("config_key", "V"))
			$Sql .= " AND config_key='" . $this->getProperty("config_key") . "'";
		
		$Sql .= " ORDER BY config_order ASC";
		return $this->dbQuery($Sql);
	}

	/**
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rs_tbl_config the basis of property set
	* @author Raju Gautam
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
	*/
	public function actConfig($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_config(
						config_cd,
						config_category,
						config_caption,
						config_key,
						config_value,
						config_order)
						VALUES(";
				$Sql .= $this->isPropertySet("config_cd", "V") ? $this->getProperty("config_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("config_category", "V") ? "'" . $this->getProperty("config_category") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("config_caption", "V") ? "'" . $this->getProperty("config_caption") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("config_key", "V") ? "'" . $this->getProperty("config_key") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("config_value", "V") ? "'" . $this->getProperty("config_value") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("config_order", "V") ? $this->getProperty("config_order") : "NULL";

				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_config SET ";
				if($this->isPropertySet("config_value", "K")){
					$Sql .= "config_value='" . $this->getProperty("config_value") . "'";
				}
				$Sql .= " WHERE 1=1";
				if($this->isPropertySet("config_key", "V"))
					$Sql .= " AND config_key='" . $this->getProperty("config_key") . "'";
				else
					$Sql .= " AND config_cd=" . $this->getProperty("config_cd");
				break;
			case "D":
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
	/**
	* This method is used to populate the country combo
	* @author Raju Gautam
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
	*/
	public function countryCombo($sel){
		$opt = "";
		$Sql = "SELECT 
					country_id,
					country_name,
					iso_code_2,
					iso_code_3,
					format_id 
				FROM
					rs_tbl_countries
				WHERE
					1=1";
		$this->dbQuery($Sql);
		while($rows = $this->dbFetchArray(1)){
			if($rows['country_id'] == $sel)
				$opt .= "<option value=\"" . $rows['country_id'] . "\" selected>" . $rows['country_name'] . "</option>\n";
			else
				$opt .= "<option value=\"" . $rows['country_id'] . "\">" . $rows['country_name'] . "</option>\n";
		}
		return $opt;
	}
	
	/**
	* This method is used to get the country name
	* @author Raju Gautam
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
	*/
	public function getCountryName($id){
		$opt = "";
		$Sql = "SELECT 
					country_name
				FROM
					rs_tbl_countries
				WHERE
					1=1 
					AND country_id=" . $id;
		$this->dbQuery($Sql);
		$rows = $this->dbFetchArray(1);

		return $rows['country_name'];
	}
	
	/**
	* This method is used to populate the timezone combo
	* @author Raju Gautam
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
	*/
	public function lstTimezone($sel){
		$opt = "";
		$Sql = "SELECT 
					timezone_cd,
					timezone_name
				FROM
					rs_tbl_timezone
				WHERE
					1=1";
		$this->dbQuery($Sql);
		while($rows = $this->dbFetchArray(1)){
			if($rows['timezone_cd'] == $sel)
				$opt .= "<option value=\"" . $rows['timezone_cd'] . "\" selected>" . $rows['timezone_name'] . "</option>\n";
			else
				$opt .= "<option value=\"" . $rows['timezone_cd'] . "\">" . $rows['timezone_name'] . "</option>\n";
		}
		return $opt;
	}

	/**
	* This method is used to get the admin including page
	* @author Raju Gautam
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
	*/
		public function getAdminPage($page){
		if($page && $page != ""){
			$this->pageName = $page;
			$page = preg_replace("/\./", "\/", $page);
			$page = "pages/" . $page . ".php";
			if(!file_exists($page)){
				$page = "../html/404.php";
			}
		}
		else{
			$page = "pages/home.php";
		}
		return $page;
	}


	/**
	* This method is used to set the message
	* @author Raju Gautam
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
	*/
	public function setMessage($msg = NULL, $type = 'status'){
		if($msg){
			if(!isset($_SESSION['msg'])){
				$_SESSION['msg'] = array();
			}
			if(!isset($_SESSION['msg'][$type])){
				$_SESSION['msg'][$type] = array();
			}
			$_SESSION['msg'][$type][] = $msg;
		}
		return isset($_SESSION['msg']) ? $_SESSION['msg'] : NULL;
	}
	
	/**
	* This method is used to get the message
	* @author Raju Gautam
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
	*/
	public function getMassage(){
		if ($msg = $this->setMessage()){
			unset($_SESSION['msg']);
		}
		return $msg;
	}

	/**
	* This method is used to display the message
	* @author Raju Gautam
	* @Date 14 Dec, 2007
	* @modified 14 Dec, 2007 by Raju Gautam
	*/
	public function displayMessage($flag = true){
		if($data = $this->getMassage()){
			
			foreach($data as $type => $msg){
				if(count($msg) >= 1 && $type == 'Error'){
					foreach($msg as $msg){
					    $output .=	'<div id="message-red">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="red-left">';
						$output .=	$msg . '</td>
					<td class="red-right"><a class="close-red" href="javascript:'."toggleDiv('message-red');".'"><img src="images/icon_close_red.gif"   alt="" /></a></td>
				</tr>
				</table>
				</div>';
					}
				}
				else if(count($msg) >= 1 && $type == 'Valid'){
				$i=0;
					foreach($msg as $msg){
					
					    	$output .=	'<div id="message-blue'.$i.'">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="blue-left">';
						$output .=	$msg . '</td>
					<td class="blue-right"><a class="close-blue" href="javascript:'."toggleDiv('message-blue".$i."');".'"><img src="images/icon_close_blue.gif"   alt="" /></a></td>
				</tr>
				</table>
				</div>';
				$i++;
					}
				}
				else if(count($msg) >= 1 && $type == 'Update'){
					foreach($msg as $msg){
					    	$output .=	'<div id="message-yellow">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="yellow-left">';
						$output .=	$msg . '</td>
					<td class="blue-right"><a class="close-yellow" href="javascript:'."toggleDiv('message-yellow');".'"><img src="images/icon_close_yellow.gif"   alt="" /></a></td>
				</tr>
				</table>
				</div>';
					}
				}
				else if(count($msg) > 1 && $type == 'Info'){
					foreach($msg as $msg){
					$output .=	'<div id="message-blue">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="blue-left">';
						$output .=	$msg . '</td>
					<td class="blue-right"><a class="close-blue" href="javascript:'."toggleDiv('message-blue');".'"><img src="images/icon_close_blue.gif"   alt="" /></a></td>
				</tr>
				</table>
				</div>';
					}
				}
		  		else{
				$output .=	'<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="green-left">';
						$output .=	$msg[0] . '</td>
					<td class="red-right"><a class="close-green" href="javascript:'."toggleDiv('message-green');".'"><img src="images/icon_close_green.gif"   alt="" /></a></td>
				</tr>
				</table>
				</div>';
					
		  		}
			}
			
		}
		return $output;
	}

	/**
	* This method is used to get the new passowrd characters
	* @author Raju Gautam
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
	*/
	public function genPassword($char = 6){
		$md5 = md5(time());
		return substr($md5, rand(5, 25), $char);
	}
	
	/**
	* This method is used to print date
	* @author Raju Gautam
	* @Date 26 April, 2008
	* @modified 26 April, 2008 by Raju Gautam
	*/
	public function printDate($date){
		return date(DATE_FORMAT, strtotime($date));
	}
	
	/**
	* This method is used to return the tinyMCE header information
	* @author Raju Gautam
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
	*/
	public function tinyMCEHeader($objName){
		$content = '<script language="javascript" type="text/javascript">
			tinyMCE.init({
				mode : "exact",
				elements : "' . $objName . '",
				theme : "advanced",
				theme_advanced_buttons1 : "bold,italic,underline,fontselect,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,forecolor,backcolor,removeformat,cleanup,code",
				theme_advanced_buttons2 : "",
				theme_advanced_buttons3 : "",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
				theme_advanced_resizing : true,
				theme_advanced_resize_horizontal : true
			});
		</script>
		';
		return $content;
	}
	
	/**
	* This method is used to check single-line inputs
	* @author Raju Gautam
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
 	* @return true if text contains newline character
	*/
	public function hasNewLines($text) {
		return preg_match("/(%0A|%0D|\n+|\r+)/i", $text);
	}
	 
	/**
	* This method is used to Check multi-line inputs
	* @author Raju Gautam
	* @Date 17 April, 2008
	* @modified 17 April, 2008 by Raju Gautam
 	* @return true if text contains newline followed by email-header specific string
	*/
	public function hasEmailHeaders($text) {
		return preg_match("/(%0A|%0D|\n+|\r+)(content-type:|to:|cc:|bcc:)/i", $text);
	}
}
?>