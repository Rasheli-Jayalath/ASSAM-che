<?php 
require_once("config/config.php");
/*require_once("requires/Database.php");
$obj= new Database();*/
$objCommon 		= new Common;
$objMenu 		= new Menu;
$objNews 		= new News;
$objContent 	= new Content;
$objTemplate 	= new Template;
$objMail 		= new Mail;
$objCustomer 	= new Customer;
$objCart 	= new Cart;
$objAdminUser 	= new AdminUser;
$objProduct 	= new Product;
$objValidate 	= new Validate;
$objOrder 		= new Order;
$objLog 		= new Log;
//This is the default language. We will use it 2 places, so i am put it 
//into a varaible.
$defaultLang = 'en';

//Checking, if the $_GET["language"] has any value
//if the $_GET["language"] is not empty
if (!empty($_GET["language"])) { //<!-- see this line. checks 
    //Based on the lowecase $_GET['language'] value, we will decide,
    //what lanuage do we use
    switch (strtolower($_GET["language"])) {
        case "en":
            //If the string is en or EN
            $_SESSION['lang'] = 'en';
            break;
        case "rus":
            //If the string is tr or TR
            $_SESSION['lang'] = 'rus';
            break;
        default:
            //IN ALL OTHER CASES your default langauge code will set
            //Invalid languages
            $_SESSION['lang'] = $defaultLang;
            break;
    }
}

//If there was no language initialized, (empty $_SESSION['lang']) then
if (empty($_SESSION["lang"])) {
    //Set default lang if there was no language
    $_SESSION["lang"] = $defaultLang;
}
if($_SESSION["lang"]=='en')
{
require_once('rs_lang.admin.php');
require_once('rs_lang.website.php');
}
else
{
	require_once('rs_lang.admin_rus.php');

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo ADMIN_SITE_TITLE;?></title>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="menu/chromestyle.css"/>
<?php 
# JS file
importJs("Menu");
importJs("Common");
importJs("Ajax");
importJs("Calendar");
importJs("Lang-EN");
importJs("ShowCalendar");?>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<?php importCss("Login");?>
<?php importCss("Messages");
if($objAdminUser->ne_is_login == true){
	importCss("PjStyles");
}?>
<?php

echo '<link rel="stylesheet" type="text/css" media="all" href="'.SITE_URL.'cal-skins/aqua/theme.css" title="Aqua" />' . "\n";
//echo '<link rel="shortcut icon" href="favicon.ico">' . "\n";

echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/genral_new.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/jquery_tooltip.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/main_tooltip.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/multifile_compressed.js"></script>';

echo '<script type="text/javascript" src="' . $_CONFIG['editor_path'] . 'ckeditor/ckeditor.js"></script>';
echo '<script type="text/javascript" src="' . $_CONFIG['editor_path'] . 'ckeditor/config.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/popbox.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/jqueryMain.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/leftmenu.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/jquery.min.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/jquery.colorbox.js"></script>';
/*echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/jquery-1.9.1.js"></script>';*/
/*echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/jquery-ui.js"></script>';
echo '<link rel="stylesheet" type="text/css" media="all" href="'.SITE_URL.'css/jquery-ui.css" />' . "\n";*/
?>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  
  <script>
  $(function() {
	  var pickerOpts = {
		dateFormat:"yy-mm-dd"
	};
    $( "#start_date" ).datepicker(pickerOpts);
	$( "#end_date" ).datepicker(pickerOpts);
	$( "#pdate" ).datepicker(pickerOpts);
  });
 
  $(function() {
    $( "#activity_start_date" ).datepicker();
  });
  $(function() {
    $( "#activity_end_date" ).datepicker();
  });
  
   $(function() {
    $( "#activity_act_start_date" ).datepicker();
  });
  $(function() {
    $( "#activity_act_end_date" ).datepicker();
  });

  </script>

</head>
<body>
<div id="wrap">
   <?php
     include 'includes/headerMain.php';
	 if($objAdminUser->ne_is_login == true){?>
     <?php include("includes/menu.php");?>
     <?php
	 }
   ?>
   <div id="content" >
  
  <?php  if($_GET['p'] == "logout"){
	require_once("./pages/logout.php");
}

if(isset($_GET['forgot']) && $_GET['forgot'] == "forgot"){
	require_once("pages/forgot.passwd.php");
}
else{
	if($objAdminUser->ne_is_login == true){
		
		require_once("pages/default.php");	
	}
	else{
		$refurl = $_SERVER['QUERY_STRING'];
		require_once("pages/login-form.php");
	}
}


?>

 </div>
<?php //include ("includes/footer.php"); ?>
</div>
</body>
</html>