<?php
session_start();
$adminflag=$_SESSION['adminflag'];
if ($adminflag == 1 || $adminflag == 2) {
$pid = $_SESSION['pid'];
$_SESSION['mode'] = 0;
include_once("connect.php");
include_once("functions.php");
$data_url="dashboard_data/";
//===============================================
 $pdSQL = "SELECT xsid, pid, xs_file FROM t013xsection WHERE pid = ".$pid." order by xsid";
$pdSQLResult = mysql_query($pdSQL);
$sql_num=mysql_num_rows($pdSQLResult);
 $pdData = mysql_fetch_array($pdSQLResult);
  $pdData["xs_file"];
   $pdSQL = "SELECT brid, pgid, pid, serial, description, total, inprogress, completed FROM t0171bridges where pid = ".$pid." order by serial";
$pdSQLResult = mysql_query($pdSQL);
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
	<style>
		/* styles unrelated to zoom */
		* { border:0; margin:0; padding:0; }
		p { position:absolute; top:3px; right:28px; color:#555; font:bold 13px/1 sans-serif;}

		/* these styles are for the demo, but are not required for the plugin */
		.zoom {
			display:inline-block;
			position: relative;
		}
		
		/* magnifying glass icon */
		.zoom:after {
			content:'';
			display:block; 
			width:33px; 
			height:33px; 
			position:absolute; 
			top:0;
			right:0;
			background:url(icon.png);
		}

		.zoom img {
			display: block;
		}

		.zoom img::selection { background-color: transparent; }

		#ex2 img:hover { cursor: url(grab.cur), default; }
		#ex2 img:active { cursor: url(grabbed.cur), default; }
	</style>
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
	<script src='jquery.zoom.js'></script>
	<script>
		$(document).ready(function(){
			$('#ex1').zoom();
			$('#ex2').zoom({ on:'grab' });
			$('#ex3').zoom({ on:'click' });			 
			$('#ex4').zoom({ on:'toggle' });
		});
	</script>
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
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Line Balance Diagram</span><span style="float:right"><form action="chart1.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:100%"><td align="center">
   <?php if($adminflag==1 && $sql_num==0)
								  {
								   ?>
  <span style="text-align:right; "><form action="sp_typx_input.php" method="post"><input type="submit" name="add_new " id="add_new" value="Add New Record" /></form></span>
  <?php
  }
  else if($adminflag==1 && $sql_num>=1)
  {?>
   <span style="text-align:right; "><form action="sp_typx_input.php?xsid=<?php echo $pdData["xsid"]; ?>" method="post"><input type="submit" name="edit_new " id="edit_new" value="Update " /></form></span>
  <?php }
  ?>
  
                    <div class="product-image">
                    <?php 
					 if($sql_num>=1)
							  {
							 
							  if($pdData["xs_file"]!="")
							{?>
                          <span class='zoom' id='ex3'>
                        <img src="<?php echo $data_url.$pdData["xs_file"];?>" alt="..."
                        height="450px" style="border: 3px #CCC solid"/>
                        </span>
                         <?php }
							  }?>
                      </div></td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
