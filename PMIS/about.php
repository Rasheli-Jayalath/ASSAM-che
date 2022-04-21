<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module=PROJECT;
if ($uname==null  ) {
header("Location: requires/logout.php");
} 

$edit			= $_GET['edit'];
$objDb  		= new Database( );
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

}
else
{
	require_once('rs_lang.admin_rus.php');

}
if($_SESSION['login_count']==1)
{
$_SESSION['codelength']		=6;
		if (!empty($_SERVER["HTTP_CLIENT_IP"]))
			{
			 //check for ip from share internet
			 $ip = $_SERVER["HTTP_CLIENT_IP"];
			}
			elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
			{
			 // Check for the Proxy User
			 $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			}
			else
			{
			 $ip = $_SERVER["REMOTE_ADDR"];
			}
			
			if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
		   $browser ='Internet explorer';
		 		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
			$browser = 'Internet explorer';
		 		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
		   $browser = 'Mozilla Firefox';
		 		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
		   $browser = 'Google Chrome';
		 		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
		   $browser = "Opera Mini";
		 		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
		   $browser = "Opera";
				 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
		   $browser = "Safari";
		 else
		   $browser = 'Something else';
			$request_uri = $_SERVER['REQUEST_URI'];
			$password=$_SESSION['user_pasword'];
			
		
		$uSQL = ("INSERT INTO users_log (user_id,user_name,password,ip_address, req_url, browser) VALUES ('$uid','$uname','$password','$ip', '$request_uri', '$browser')");
			$objDb->execute($uSQL);
			$log_id=mysql_insert_id();
			$_SESSION['log_id']=$log_id;
	}
$_SESSION['login_count']=2;
@require_once("get_url.php");
$msg						= "";
$objDb  		= new Database( );
$eSql = "Select * from project";
$objDb -> query($eSql);
$eCount = $objDb->getCount();
if($eCount == 0)
{
header("location: project_calender.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>

<!--<link rel="stylesheet" type="text/css" href="css/style.css">-->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  
 <?php /*?> <link rel="stylesheet" type="text/css" media="all" href="calender/calendar-win2k-cold-1.css" title="win2k-cold-1" />
  <script type="text/javascript" src="calender/calendar.js"></script>
  <script type="text/javascript" src="calender/lang/calendar-en.js"></script>
  <script type="text/javascript" src="calender/calendar-setup.js"></script><?php */?>
  <script type="text/javascript" src="scripts/JsCommon.js"></script>

<style type="text/css">
<!--
.style1 {color: #3C804D;
font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:18px;
	font-weight:bold;
	text-align:center;}
-->
</style>
<style type="text/css"> 
.imgA1 { position:absolute;  z-index: 3; } 
.imgB1 { position:relative;  z-index: 3;
float:right;
padding:10px 10px 0 0; } 
</style> 


<style type="text/css"> 
.msg_list {
	margin: 0px;
	padding: 0px;
	width: 100%;
}
.msg_head {
	position: relative;
    display: inline-block;
	cursor:pointer;
   /* border-bottom: 1px dotted black;*/

}
.msg_head .tooltiptext {
	cursor:pointer;
    visibility: hidden;
    width: 80px;
    background-color: gray;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}

.msg_head:hover .tooltiptext {
    visibility: visible;
}
.msg_body{
	padding: 5px 10px 15px;
	background-color:#F4F4F8;
}
</style>

</head>
<body>
<div id="wrap">
  <?php 
		include 'includes/header.php'; 
	?>
<div id="content">
<div style="margin-top:60px; text-align:left">
<table width="100%"  align="center" border="0" >
   <tr>
     <td height="20" colspan="5" align="left" style="color:#0E0989; font-size:21px" >Introduction</td>
   </tr>
   <tr>
     <td    style="line-height:18px; text-align:justify"><p>Project Monitoring and Management Information System (PMIS) provides unified platform and tools to SMEC Project Management Team, SMEC Country Management, Client and other stakeholders for effective and efficient Project Monitoring and Management for best services delivery. 
PMIS is Web based, online, real-time, 24/7 available from anywhere with secure access. Following are major features: 
<ul>
<li>Project Key Performance Indicators (KPIs) - Monitoring Dashboard</li>
<li>Project Key Financial Indicators (KFIs) - Monitoring Dashboard</li>
<li>Project Bill of Quantities - Monitoring against overbilling and overuses</li>
<li>Project Milestones - Monitoring Dashboard</li>
<li>Project Pictorial Analysis (Store and compare pictures on specific dates side by side)</li>
<li>News and Events Website</li>
<li>Document Management System</li>
<li>Task Management and Communication Tracking</li>
<li>SMEC Internal Management Monitoring Dashboard (like HR Man-months, Project Billings, Project Invoicing etc. monitoring at Country Office level etc.)</li>
<li>Auto-generated emails for progress reports like daily, weekly and monthly</li>
</ul>
   </td>
   <td  colspan="4"  style="line-height:18px; text-align:justify"><img src="../images/pmis.png"  width="400px" /></td>
   </tr>
   <tr><td colspan="5" align="center"><iframe width="560" height="315" src="https://www.youtube.com/embed/GcDkd3hGADI?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></td></tr>
    <tr><td colspan="5" align="center"> <a href="PMIS_DOCS/PMIS_DMS.pptx" target="_blank" style="text-decoration:none;color:#000"><strong>PMIS Power Point Presentation<img src="images/pwr.png"  width="75px" height="75px"/></strong></a> &nbsp;&nbsp;&nbsp;&nbsp;
 <a href="PMIS_DOCS/user_guide.pdf" target="_blank" style="text-decoration:none; margin: 0px auto;
    padding: 0px 35px 0px 50px; color:#000"><strong>PDF of User Guide<img src="images/pdf.png"  width="75px"  height="75px"/></strong></a></td></tr>
  

     
</table>
</div>
</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
