<?php
session_start();
if (isset($_REQUEST['logout'])) {
	unset($_SESSION['adminflag']);
	unset($_SESSION['pid']);
	unset($_SESSION['max_pid']);
	unset($_SESSION['srid']);
	unset($_SESSION['sr_max']);
	unset($_SESSION['sridlist']);
	unset($_SESSION['mode']);
	session_destroy();
	header("Location: index.php?msg=3");
	}
if (isset($_SESSION['adminflag'])) {header("Location: chart1.php");}

if (isset($_REQUEST['msg'])) {
	if ($_REQUEST['msg'] == 0) {
	$msg = "<span style='color:red;'>Your PIN is invalid...</span><br />For PIN issuance contact  IT Section...";
	} elseif ($_REQUEST['msg'] == 3) {
	$msg = "<span style='color:green;'>You are Loged Out Successfully...</span><br />Thanks for using Dashboard...";
	} else {
	$msg = "<span style='color:red;'>Problem with the system, Error reported to IT with your IP address...</span><br />Thanks for using Dashboard...";
	}
} else {
	$msg = "For PIN issuance contact  IT Section...";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SECOND IRRIGATION AND DRAINAGE IMPROVEMENT PROJECT (IDIP2)</title>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<div class="top-box-set" style="margin-top:10px">
<h1 align="center" style="background-color:#F90; text-transform:uppercase">SECOND IRRIGATION AND DRAINAGE IMPROVEMENT PROJECT (IDIP2)</h1>
<!-- 

 -->
   <!--<div id="countdown"> 
    <div id="download"><strong>Refreshing Now!!</strong> </div></div>--> </td>
</div>
<div class="box-set">
  <figure class="sub_box">
  <table style="width:100%; height:100%">
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>DASHBOARD LOGIN</span></td></tr>
 <tr style="height:100%"><td align="center" valign="top">
 <div style="width:100%; text-align:center; font-size:14px; padding:20px;">Provide PIN below and hit Login!!!!</div>
 <div style="background-color:#006; padding:20px; ">
 <form action="chart1.php" target="_self" method="post">
 <input type="password" name="pwpin" name="pwpin" autofocus size="5" />
 <input type="submit" id="pinlogin" name="pinligon" value="Login" />
 </form>
 </div>
 <div style="width:100%; text-align:center; font-size:14px; color:#00F;   padding:20px;"><?php echo $msg; ?></div>

</td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
