<?php
	ob_start();
	session_cache_expire(30);
	session_start();
	//error_reporting(E_ALL);
	$dbCfg = array();
	include_once(dirname(__FILE__) . '/global_config.php');
	// database configuration
	if($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] =="192.168.4.2")
	{
		$dbCfg['host']			= "localhost";
		$dbCfg['db_user']		= "root";
		$dbCfg['db_passwd']		= "";
		$dbCfg['db_name']		= "etldb";
	}
	else
	{
		$dbCfg['host']			= "205.178.146.108";
		$dbCfg['db_user']		= "lbdcip";
		$dbCfg['db_passwd']		= "Lbdcip_786_pitb";
		$dbCfg['db_name']		= "lbdcip";
	}
	
	/************************/
	
	/**
	 * import()
	 *
	 * @param mixed $className
	 * @return
	 */
	function import($className){
		if($className && $className != ""){
			$className = "classes/class." . $className . ".php";
			if(file_exists(SITE_PATH . $className)){
				require_once(SITE_PATH . $className);
			}
		}
	}
	
	/**
	 * getImage()
	 *
	 * @param string $imagename
	 * @param string $ext
	 * @return
	 */
	function getimage($imagename, $ext){
		return $imagename . '_' . strtolower(SITE_LANG) . '.' . $ext;
	}
	
	/**
	 * importJs()
	 *
	 * @param mixed $jsFile
	 * @return
	 */
	function importJs($jsFile){
		if($jsFile && $jsFile != ""){
			$jsFile = "jscript/Js" . $jsFile . ".js";
			if(file_exists(SITE_PATH . $jsFile)){
				echo "<script language=\"javascript\" type=\"text/javascript\" src=\"" . SITE_URL . $jsFile . "\"></script>\n";
			}
		}
	}
	
	/**
	 * printArray()
	 *
	 * @param array $arr
	 * @return
	 */
	function printPre($str, $exit = false){
		echo '<pre style="text-align:left;">' . $str . '</pre>';
		if($exit){
			exit();
		}
	}
	
	/**
	 * printArray()
	 *
	 * @param array $arr
	 * @return
	 */
	function printArray($arr, $exit = false){
		echo '<pre style="text-align:left;">';
		print_r($arr);
		echo '</pre>';
		if($exit){
			exit();
		}
	}
	
	/**
	 * importCss()
	 *
	 * @param mixed $cssFile
	 * @return
	 */
	function importCss($cssFile){
		if($cssFile && $cssFile != ""){
			$cssFile = "css/Css" . $cssFile . ".css";
			if(file_exists(SITE_PATH . $cssFile)){
				echo "<link href=\"" . SITE_URL . $cssFile . "\" rel=\"stylesheet\" type=\"text/css\" />\n";
			}
		}
	}
	
	/**
	 * buildUrl()
	 *
	 * @param string $url
	 * @param integer $refSecond
	 * @return
	 */
	function buildUrl($url = ""){
		header("Location:" . $url);
		die();
	}
	
	/**
	 * redirect()
	 *
	 * @param string $url
	 * @param integer $refSecond
	 * @return
	 */
	function redirect($url = "", $refSecond = 0){
		header("Location:" . $url);
		die();
	}
	
	/**
	 * doDefine()
	 *
	 * @param mixed $configs
	 * @return
	 */
	function doDefine($configs){
		$str = "";
		if($configs){
			foreach($configs as $key=>$value){
				$str .= "define(\"" . strtoupper($key) . "\",\"" . $value . "\");\n";
			}
		}
		return $str;
	}
	
	/*********** Define the values *********/
	$defines = doDefine($_CONFIG);
	echo eval($defines);
	
	
	/**
	 * __autoload()
	 *
	 * @param string $class_name
	 * @return
	 */
	function __autoload($class_name){
		// class directories
		$dirs = array(
			'classes/',
			'classes/core/',
			'classes/utfexport/'
		);
		
		// for each directory
		foreach($dirs as $dir){
			// see if the file exsists
			if(file_exists(SITE_PATH . $dir . $class_name . '.php')){
				require_once(SITE_PATH . $dir . $class_name . '.php');
				// only require the class once, so quit after to save effort (if you got more, then name them something else
			return;
			}
		}
	}
	
	/**
	 * getPage()
	 *
	 * @param string $log_module
	 * @return
	 */
	function getPage($page){
		if(isset($page) && !empty($page)){
			$filename = HTML_PATH . ($page) . '.default' . '.php';
			if(file_exists($filename))
				return HTML_PATH . ($page) . '.default' . '.php';
			else
				return HTML_PATH . '404' . '.php';
		}
		else{
			return HTML_PATH . 'default.php';
		}
	}
	
	function getDomain(){
		$host = $_SERVER["HTTP_HOST"];
		$host = str_replace('www.', '', $host);
		return '.' . $host;
	}
	
	function getPageName(){
		//$PageName = end(explode('/', $_SERVER['SCRIPT_FILENAME']));
		//$PageName = $_SERVER['QUERY_STRING'];
		//$PageName = $_SERVER['REQUEST_URI'];
		$PageName = $_GET['category_cd'];
		return $PageName;
	}
	
	function GetEncptBKL(){
		$Back_Link = $_SERVER['HTTP_REFERER'];
		$En_BKLINK = base64_encode($Back_Link);
		return $En_BKLINK;
	}
	
	function GetDecptBKL($BLK){
		$De_BKLINK = base64_decode($BLK);
		return $De_BKLINK;
	}
	
	/**
	 * doLog()
	 *
	 * @param string $log_module
	 * @param string $log_title
	 * @param string $log_desc
	 * @param mixed $user_cd
	 * @return
	 */
	function doLog($log_module="", $log_title="", $log_desc="", $user_cd=""){
		$objLog 	= new Log;
		$objLogNew 	= new Log;
		$log_cd 	= $objLogNew->genCode("mis_tbl_log", "log_cd");
		$log_date	= date('Y-m-d H:i:s');
		$log_ip		= $_SERVER['REMOTE_ADDR'];
		
		$objLog->setProperty("log_cd", $log_cd);
		$objLog->setProperty("log_module", $log_module);
		$objLog->setProperty("log_title", $log_title);
		$objLog->setProperty("log_desc", $log_desc);
		$objLog->setProperty("log_date", $log_date);
		$objLog->setProperty("log_ip", $log_ip);
		$objLog->setProperty("user_cd", $user_cd);
		//$objLog->setProperty("emp_id", $emp_id);
		
		$objLog->actLog("I");
	}
	
	// see if language is changed.
	/*
	if($_REQUEST['C']=='LNG'){
		
	}
	*/
	/*
	if(isset($_POST['lang'])){
		$_CONFIG['lang'] = $_POST['lang'];
		$_SESSION['allsite_lang'] = $_POST['lang'];
		setcookie('allsite_lang', $_CONFIG['lang'], time() + 31536000); // store the language in cookie for 1 year (365 days)
		$link = $_SERVER["HTTP_REFERER"];
		redirect($link);
	}
	*/
	if($_SESSION['allsite_lang']==''){
		$_SESSION['allsite_lang'] = $_CONFIG['lang'];
		$_CONFIG['lang'] = 'NL';
		setcookie('allsite_lang', $_CONFIG['lang'], time() + 31536000); // store the language in cookie for 1 year (365 days)
	} elseif($_REQUEST['C']=='LNG'){
		$_CONFIG['lang'] = $_REQUEST['lang'];
		$_SESSION['allsite_lang'] = $_REQUEST['lang'];
		setcookie('allsite_lang', $_CONFIG['lang'], time() + 31536000); // store the language in cookie for 1 year (365 days)
		$link = $_SERVER["HTTP_REFERER"];
		redirect($link);
	}
	/*
	elseif(isset($_SESSION['allsite_lang'])){
		$_CONFIG['lang'] = $_SESSION['allsite_lang'];
		//setcookie('allsite_lang', $_CONFIG['lang'], time() + 31536000); // store the language in cookie for 1 year (365 days)
	}
	elseif(isset($_COOKIE['allsite_lang'])){
		$_CONFIG['lang'] = $_COOKIE['allsite_lang'];
		//setcookie('allsite_lang', $_CONFIG['lang'], time() + 31536000); // store the language in cookie for 1 year (365 days)
	}
	else{
		$_SESSION['allsite_lang'] = $_CONFIG['lang'];
		$_CONFIG['lang'] = 'NL';
		setcookie('allsite_lang', $_CONFIG['lang'], time() + 31536000); // store the language in cookie for 1 year (365 days)
	}
	*/
	define('SITE_LANG', $_SESSION['allsite_lang']);
	define("PERPAGE", 40);
	
	/*********** Define the values *********/
	define("HOST", $dbCfg['host']);
	define("DBUSER", $dbCfg['db_user']);
	define("DBPASSWD", $dbCfg['db_passwd']);
	define("DBNAME", $dbCfg['db_name']);
	
	define("SITE_URL", ROOT_HOST);


?>