<?php
session_start();
$adminflag=$_SESSION['adminflag'];
if ($adminflag == 1 || $adminflag == 2) {
$pid = $_SESSION['pid'];
$_SESSION['mode'] = 0;
include_once("connect.php");	
include_once("functions.php");
$iss_id=$_REQUEST['iss_id'];


$issueSQL = "SELECT iss_id, iss_no, iss_title, iss_detail, iss_status, iss_action, iss_remarks FROM t012issues where pid = ".$pid. " and iss_id=".$iss_id;
$issueSQLResult = mysql_query($issueSQL);
$issueData1=mysql_fetch_array($issueSQLResult);
$iss_no=$issueData1['iss_no'];
$iss_title=$issueData1['iss_title'];
$iss_detail=$issueData1['iss_detail'];
$iss_status=$issueData1['iss_status'];
$iss_action=$issueData1['iss_action'];
$iss_remarks=$issueData1['iss_remarks'];
} else {
	header("Location: index.php?msg=0");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Second Irrigation and Drainage Improvement Project (IDIP-2)</title>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<div class="top-box-set" style="margin-top:10px">
<h1 align="center" style="background-color:<?php echo pcolor($pid); ?> "><?php echo proj_name($pid); ?></h1>
 
<?php if ($mode == 1) { ?>
<!--<span style="position:absolute; top: 21px; right: 150px;"><form action="chart1.php" target="_self" method="post"><button type="submit" name="stop" id="stop"><img src="stop.png" width="30px" /></button></form></span> -->
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="stop" name="stop"><img src="stop.png" width="35px" height="35px" /></button>
</form></span>
<?php } else {?>
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="resume" name="resume"><img src="start.png" width="35px" height="35px" /></button></form></span>
<?php }?>
<span style="position:absolute; top: 21px; right: 130px;"><form action="index.php?logout=1" method="post"><button type="submit" id="logout" name="logout"><img src="logout.png" width="35px" height="35px" /></button></form></span>
 
   <!--<div id="countdown"> 
    <div id="download"><strong>Refreshing Now!!</strong> </div></div>--> </td>
</div>
<div class="box-set">
  <figure class="sub_box">
  <table style="width:100%; height:100%">
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Issue Details</span><span style="float:right"><form action="chart1.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
 
  <tr style="height:100%"><td align="center">
  <div style="overflow-y: scroll; height:400px;">
  <table width="100%" height="100%" style="font-size:18px" class="table table-bordered" >
                                <tr><td bgcolor="#4CAF50" width="15%" style="font-size:13px">Issue No:</td><td style="font-size:13px"><?= $iss_no; ?></td></tr>
								<tr><td bgcolor="#4CAF50" width="15%" style="font-size:13px">Title:</td><td style="font-size:13px"><?= $iss_title; ?></td></tr>
								<tr><td bgcolor="#4CAF50" width="15%" style="font-size:13px">Detail:</td><td style="font-size:13px"><?= $iss_detail; ?></td></tr>
								<tr><td bgcolor="#4CAF50" width="15%" style="font-size:13px">Status:</td><td style="font-size:13px"><?= $iss_status; ?></td></tr>
								<tr><td bgcolor="#4CAF50" width="15%" style="font-size:13px">Action:</td><td style="font-size:13px"><?= $iss_action; ?></td></tr>
								<tr><td bgcolor="#4CAF50" width="15%" style="font-size:13px">Remarks:</td><td style="font-size:13px"><?= $iss_remarks; ?></td></tr>
								
                        </table>
						</div>
						</td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
