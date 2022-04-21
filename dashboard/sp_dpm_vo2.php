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
mysql_query("Delete from t028dpm_vo2progress where ppt_id=".$_REQUEST['ppt_id']);
}

//===============================================
$gap=0;
 $pdSQL = "SELECT contid, pgid, pid, serial, code, description, weight, start, finish, astart, afinish, tamount, pamount, actamount FROM t028dpm_vo2progress where  pid=$pid  order by contid";
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
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>VO2 Progresss</span><span style="float:right">
    <form action="chart1.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
 
  <tr style="height:100%"><td align="center">
  <?php if($adminflag==1)
								  {
								   ?>
  <span style="text-align:right; "><form action="sp_dpm_vo2_input.php" method="post"><input type="submit" name="add_new " id="add_new" value="Add New Record" /></form></span>
  <?php
  }
  ?>
 <div style="overflow-y: scroll; height:400px;">
  <table width="100%" class="table table-bordered">
                              <thead>
                                <tr>
                                  <th width="5%" style="text-align:center; vertical-align:middle">S#</th>
                                  <th width="5%" style="text-align:center">Code</th>
                                  <th width="15%" style="text-align:center">Milestone</th>
                                  <th width="5%" style="text-align:center">Weight</th>
                                  <th width="10%" style="text-align:center">Total Amount</th>
                                  <th width="10%" style="text-align:center">Start Date</th>
                                  <th width="10%" style="text-align:center">End Date</th>
                                  <th width="10%" style="text-align:center">Actual Start Date</th>
                                  <th width="10%" style="text-align:center">Actual End Date</th>
                                  <th width="10%" style="text-align:center">Days Elapsed w.r.t Actual Start Date</th>
                                  <th width="5%" style="text-align:center">Planned Amount</th>
								  <th width="10%" style="text-align:center">Actual Amount</th>
								  <th width="5%" style="text-align:center">Gap</th>
								  <th width="10%" style="text-align:center">Current Rate</th>
								  <th width="10%" style="text-align:center">Projected Date</th>
								  <th width="5%" style="text-align:center">Planned %</th>
								  <th width="5%" style="text-align:center">Actual %</th>
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
							  <?php
							  $average_rate=0;
							  $projected_days=0;
							  
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  $i=0;
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  {
							  $i=$i+1;
							   $startTimeStamp=strtotime($pdData['astart']);
							   $afinishTimeStamp=strtotime($pdData['afinish']);
							   $current_date=date('Y-m-d');
							   $currentTimeStamp=strtotime($current_date);
							   $timeElapsedDiff= abs($currentTimeStamp - $startTimeStamp);
							   $numberDaysElapsed = ceil($timeElapsedDiff/86400);
							   $numberDaysElapsed = intval($numberDaysElapsed);
							   $gap=$pdData['pamount']-$pdData['actamount'];
							   $ActualtimeElapsedDiff= abs($afinishTimeStamp - $startTimeStamp);
							   $ActualnumberDays=ceil($ActualtimeElapsedDiff/86400);
							   $ActualnumberDays= intval($ActualnumberDays);
							   	if($ActualnumberDays!=0&&$ActualnumberDays!="")
							   	{
							   	$current_daily_rate=$pdData['actamount']/$ActualnumberDays;
							   	}
							   	else
							   	{
							  	$current_daily_rate=0;
							 	}
								$remaining=$pdData['tamount']-$pdData['actamount'];
								if($numberDaysElapsed!=0)
								{
								$average_rate=$pdData['actamount']/($numberDaysElapsed-1);
								}
								if($average_rate!=0)
								{
									 $projected_days=$remaining/$average_rate;
								}
								 $projected_days=intval($projected_days);
								
								if($projected_days!=0)
								{
								 $projected_date=date("Y-m-d", strtotime( "+".$projected_days." days" ));
								}
								else
								{
								$projected_date="";
								}
								if($pdData['tamount']!=0&&$pdData['tamount']!="")
								{
								$palanned_per=$pdData['pamount']/$pdData['tamount']*100;
								}
								else
								{
								$palanned_per=0;
								}
								
								if($pdData['tamount']!=0&&$pdData['tamount']!="")
								{
								$actual_per=$pdData['actamount']/$pdData['tamount']*100;
								}
								else
								{
								$actual_per=0;
								}
				
							   ?>
                        <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="left"><?php echo $pdData['code'];?></td>
                          <td align="left"><?php echo $pdData['description'];?></td>
                          <td align="left"><?php echo $pdData['weight'];?></td>
                          <td align="left"><?php echo $pdData['tamount'];?></td>
                          <td align="left"><?php echo $pdData['start'];?></td>
                          <td align="left" ><?php echo $pdData['finish'];?></td>
                          <td align="left"><?php echo $pdData['astart'];?></td>
                          <td align="left"><?php echo $pdData['afinish'];?></td>
                          <td align="left"><?php echo $numberDaysElapsed;?></td>
                          <td align="right"><?php echo number_format($pdData['pamount'],2);?></td>
                          <td align="right"><?php echo number_format($pdData['actamount'],2);?></td>
                          <td align="right"><?php echo number_format($gap,2);?></td>
                          <td align="right"><?php echo  number_format($current_daily_rate,2);?></td>
                          <td align="right"><?php echo $projected_date;?></td>
                          <td align="right"><?php echo number_format($palanned_per,2);?></td>
                          <td align="right"><?php echo number_format($actual_per,2);?></td>
                          <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:right"><form action="sp_dpm_vo2_input.php?contid=<?php echo $pdData['contid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><!--<span style="float:right"><form action="sp_major_items.php?ppt_id=<?php //echo $pdData['ppt_id'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span>--></td>
						   <?php
						   }
						   ?>
                        </tr>
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="19" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
                        </table></div></td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
