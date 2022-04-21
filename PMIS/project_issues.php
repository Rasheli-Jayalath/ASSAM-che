<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			="Issues";
if ($uname==null)
{
	header("Location:index.php?init=3");
}
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


$objDb  		= new Database( );
@require_once("get_url.php");
$iss_id=$_REQUEST['iss_id'];
$pid=1;


$issueSQL = "SELECT nos_id, iss_no, iss_title, iss_detail, iss_status, iss_action, iss_remarks FROM t012issues where pid=$pid and nos_id=".$iss_id;
$issueSQLResult = mysql_query($issueSQL);
$issueData1=mysql_fetch_array($issueSQLResult);
$iss_no=$issueData1['iss_no'];
$iss_title=$issueData1['iss_title'];
$iss_detail=$issueData1['iss_detail'];
$iss_status=$issueData1['iss_status'];
$iss_action=$issueData1['iss_action'];
$iss_remarks=$issueData1['iss_remarks'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>

<link rel="stylesheet" type="text/css" href="css/style.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script type="text/javascript" src="scripts/JsCommon.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>






</head>
<body>
<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
<table class="issues" width="100%" style="background-color:#FFF">
  <tr style="height:10%"><th>Issue Details<span style="float:right"><form action="home.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></th></tr>
 
  <tr style="height:100%"><td align="center">

  <table class="issues" width="100%" style="background-color:#FFF">
                                <tr><td width="15%" style="font-size:13px"><?php echo ISS_NO;?>:</td><td style="font-size:13px"><?= $iss_no; ?></td></tr>
								<tr><td width="15%" style="font-size:13px"><?php echo TITLE;?>:</td><td style="font-size:13px"><?= $iss_title; ?></td></tr>
								<tr><td  width="15%" style="font-size:13px"><?php echo DETAIL;?>:</td><td style="font-size:13px"><?= $iss_detail; ?></td></tr>
								<tr><td  width="15%" style="font-size:13px"><?php echo STATUS;?>:</td><td style="font-size:13px"><?php if($iss_status==1) 
						  { 
						  echo ACTIVE;
						   } else  { echo INACTIVE; } ?></td></tr>
								<tr><td  width="15%" style="font-size:13px"><?php echo ACTION;?>:</td><td style="font-size:13px"><?= $iss_action; ?></td></tr>
								<tr><td  width="15%" style="font-size:13px"><?php echo REMARKS;?>:</td><td style="font-size:13px"><?= $iss_remarks; ?></td></tr>
								
                        </table>
						
						</td></tr>
  
  </table>

	<br clear="all" />
</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
