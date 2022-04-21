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
mysql_query("Delete from t0211eva_progress_graph where ppg_id=".$_REQUEST['ppg_id']);
}

//===============================================

$pdSQL = "SELECT ppg_id, pid, planned, actual, ppg_date, earned, cpi,spi,tcpi from t0211eva_progress_graph where pid = ".$pid;
$pdSQLResult = mysql_query($pdSQL);
} else {
	header("Location: index.php?msg=0");
}
$pcrSQL = "SELECT  proj_cur FROM t002project where pid = ".$pid;
$pcrSQLResult = mysql_query($pcrSQL);
$pcrData = mysql_fetch_array($pcrSQLResult);
$proj_cur=$pcrData["proj_cur"];
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
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Earned Value Analysis (Graphical Data) </span><span style="float:right"><form action="sp_deva.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
 
  <tr style="height:100%"><td align="center">
  <?php if($adminflag==1)
								  {
								   ?>
  <span style="text-align:right; "><form action="sp_evaprogress_graph_input.php" method="post"><input type="submit" name="add_new " id="add_new" value="Add New Record" /></form></span>
  <?php
  }
  ?>
 <div style="overflow-y: scroll; height:400px;">
  <table width="100%" class="table table-bordered">
                              <thead>
                                <tr>
								 <th width="5%" style="text-align:center; vertical-align:middle">#</th>
                                  <th width="15%" style="text-align:center; vertical-align:middle">Month</th>
                                  <th width="10%" style="text-align:center">Planned (<?php echo $proj_cur;?>)</th>
                                  <th width="10%" style="text-align:center">Actual (<?php echo $proj_cur;?>)</th>
								  <th width="10%" style="text-align:center">Earned (<?php echo $proj_cur;?>)</th>
                                   <th width="10%" style="text-align:center">CPI </th>
                                    <th width="10%" style="text-align:center">SPI </th>
                                    <th width="10%" style="text-align:center">TCP-1 </th>
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
							  
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							   $i=0;
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  {
							   $i= $i+1;
							    $ppg_date_arr1=explode("-",$pdData['ppg_date']);
								$y1=$ppg_date_arr1[0];
								$m1=$ppg_date_arr1[1];
								$ppg_date_f=$y1."-".$m1;
							   ?>
                        <tr>
						<td align="center"><?php echo $i;?></td>
                          <td align="center"><?php echo $ppg_date_f; ?></td>
                          <td align="right"><?php echo $pdData['planned']; ?></td>
                          <td align="right"><?php echo $pdData['actual']; ?></td>
                          <td align="right"><?php echo $pdData['earned']; ?></td>
                          <td align="right"><?php echo $pdData['cpi']; ?></td>
                          <td align="right"><?php echo $pdData['spi']; ?></td>
                          <td align="right"><?php echo $pdData['tcpi']; ?></td>
						  <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_evaprogress_graph_input.php?ppg_id=<?php echo $pdData['ppg_id'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="sp_evaprogress_graph.php?ppg_id=<?php echo $pdData['ppg_id'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
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
                          <td colspan="9" >No Record Found</td>
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
