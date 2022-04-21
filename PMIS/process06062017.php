<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= MAINDATA;
/*$uname			= $_SESSION['uname'];
$admflag		= $_SESSION['admflag'];*/

if ($uname==null  ) {
header("Location: index.php?init=3");
} 
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");


if($updateBtn !=""){
	
 $uSql = "Update activity SET 
			
			 code         		= '$txtcode',
			 secheduleid  		= '$txtscheduleid',
			 startdate			= '$txtstartdate',
			 enddate        	= '$txtenddate',
			 actualstartdate  	= '$txtastartdate',
			 actualenddate		= '$txtaenddate',
			 aorder        		= $txtorder,
			 baseline  			= $txtbaseline,
			 remarks			= '$txtremarks'			
			where aid 			= $edit ";
		  
 	if($objDb->execute($uSql)){
	
	$msg="Updated!";
	$log_module  = $module." Module";
	$log_title   = "Update".$module ."Record";
	$log_ip      = $_SERVER['REMOTE_ADDR'];	
	
	$sSQL2 = ("INSERT INTO activity_log (log_module,log_title,log_ip, itemid, code,  secheduleid, startdate, enddate, actualstartdate, actualenddate, aorder,baseline, remarks,transaction_id) VALUES ('$log_module','$log_title','$log_ip',$itemid,'$txtcode', '$txtscheduleid','$txtstartdate', '$txtenddate','$txtastartdate','$txtaenddate',$txtorder,$txtbaseline,'$txtremarks',$edit)");
	$objDb->execute($sSQL2);
	

		
		
		$txtcode 					= '';
		$txtscheduleid 				= '';
		$txtstartdate				= '';
		$txtenddate 				= '';
		$txtastartdate 				= '';
		$txtaenddate				= '';
		$txtorder 					= '';
		$txtbaseline 				= '';
		$txtremarks					= '';
		
	}
	header("location: activityentry.php?subaid=".$itemid);

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
  <?php include 'includes/header.php'; ?>
<div id="content">
<h1> Process Panel</h1>

		<div style="margin-bottom:12px;">
		<a class="button" href="javascript:void(null);" onclick="window.open('calculate_factor.php','Calculate Factor','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Calculate Factor</a>
		 <a class="button" href="javascript:void(null);" onclick="window.open('basetable.php', 'Planned Data','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Base Data</a>
          <a class="button" href="javascript:void(null);" onclick="window.open('loadplanned.php', 'Planned Data','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Planned Data</a>
		  <a class="button" href="javascript:void(null);" onclick="window.open('mildatamaker.php', 'Data Making','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Data Making</a>		
          </div>
		


</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
