<?php
session_start();
$adminflag=$_SESSION['adminflag'];
if ($adminflag == 1 || $adminflag == 2) {
	$pid = $_SESSION['pid'];
	$_SESSION['mode'] = 0;
	include_once("connect.php");
	include_once("functions.php");
	
	if(isset($_REQUEST['delete']))
	{
	mysql_query("Delete from t028dpm where contid=".$_REQUEST['contid']);
	}
} else {
	header("Location: index.php?msg=0");
}
//===============================================
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
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>VO2 Critical Analysis</span><span style="float:right"><form action="chart1.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
 
  <tr style="height:100%"><td align="center">
   <?php if($adminflag==1)
								  {
								   ?>
  <span style="text-align:right; margin-right:400px "><form action="sp_dpm_input.php" method="post"><input type="submit" name="add_new " id="add_new" value="Add New Record" /></form></span>
  <span style="text-align:right; margin-right:400px "><form action="sp_dpm_vo2.php" method="post"><input type="submit" name="vo_new " id="vo_new" value="VO2 Critical Analysis Report" /></form></span>
  <?php /*?> <span style="text-align:right; "><form action="sp_component.php" method="post"><input type="submit" name="add_new " id="add_new" value="Add New Component" /></form></span><?php */?>
  <?php
  }
  ?>
 <div style="overflow-y: scroll; height:400px;">
  <table width="100%" class="table table-bordered">
                              <thead>
                                <tr>
                                  <th width="5%" style="text-align:center; vertical-align:middle">S#</th>
                                  <th width="25%" style="text-align:center">Activity</th>
                                  <th width="7%" style="text-align:center">Unit</th>
                                  <th width="12%" style="text-align:center">Start</th>
                                  <th width="12%" style="text-align:center">Finish</th>
                                  <th width="7%" style="text-align:center">Days</th>
                                  <th width="7%" style="text-align:center">Total Quantity</th>
                                  <th width="7%" style="text-align:center">Todate Quantity</th>
								  <th width="7%" style="text-align:center">Remaining Quantity</th>
								  <th width="7%" style="text-align:center">% Done</th>
								  <?php if($adminflag==1)
								  {
								   ?>
								  <th width="10%" style="text-align:center">Action</th>
								  <?php
								  }
								  ?>
								  
                                </tr>
                              </thead>
                              <tbody>
				 <?php $pcSQL1="SELECT * FROM  t028dpm_activity  where pid = ".$pid;
                
                $pcSQLResult1 = mysql_query( $pcSQL1) or die(mysql_error());
                while($pcData1 = mysql_fetch_array($pcSQLResult1))
                {?>
					<tr  style="color:#FFF; background-color:#000066">
                                <td colspan="11" align="left"><?php echo $pcData1["detail"]?></td>
                                </tr>							  <?php
								
								$pfSQL1="SELECT contid, pgid, pid, serial, type, description, unit, start, finish, days, tqty, tdqty, rqty, done FROM t028dpm where pid = ".$pid." and type='".$pcData1["aid"]."' order by serial, type";
                
                $pfSQLResult1 = mysql_query($pfSQL1) or die(mysql_error());
							  
							  if(mysql_num_rows($pfSQLResult1)>=1)
							  {
							  while($pdData = mysql_fetch_array($pfSQLResult1))
							  { ?>
                              
                              <tr>
                          <td align="center"><?php echo $pdData['serial'];?></td>
                          <td align="left"><?php echo $pdData['description'];?></td>
                          <td align="left"><?php echo $pdData['unit'];?></td>
                          <td align="right"><?php if($pdData['start']!=""&&$pdData['start']!="NULL")
						  echo date('Y-m',strtotime($pdData['start'])); ?></td>
                          <td align="right"><?php if($pdData['finish']!=""&&$pdData['finish']!="NULL")
						  echo date('Y-m',strtotime($pdData['finish'])); ?></td>
                          <td align="right"><?php echo $pdData['days'];?></td>
                          <td align="right"><?php echo number_format($pdData['tqty'],0);?></td>
                          <td align="right"><?php echo number_format($pdData['tdqty'],0);?></td>
                          <td align="right"><?php echo number_format($pdData['rqty'],0);?></td>
                          <td align="right"><?php echo number_format($pdData['done'],0);?></td>
                          <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_dpm_input.php?contid=<?php echo $pdData['contid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="sp_dpm.php?contid=<?php echo $pdData['contid'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
						   <?php
						   }
						   ?>
                        </tr>
						<?php
						}
						}else
						{
						?>
						<!--<tr>
                          <td colspan="6" >No Record Found</td>
                        </tr>-->
						<?php
						}
						?>
        						  <?php
						
						}  // end compoennt loop
						?>
                                
                                                      </tbody>
                        </table>
</div>
						</td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
