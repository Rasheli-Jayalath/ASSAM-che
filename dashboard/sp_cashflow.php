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
mysql_query("Delete from t016project_monthwisecashflow where pm_cf=".$_REQUEST['pm_cf']);
}
 } else {
	header("Location: index.php?msg=0");
}

//===============================================

$pdSQL = "SELECT pm_cf,  pid, year, pm_month, pm_value, pm_percent FROM t016project_monthwisecashflow where pid = ".$pid." and year='2016' order by pm_month asc";
$pdSQLResult = mysql_query($pdSQL);
 

$pdSQL1 = "SELECT pm_cf,  pid, year, pm_month, pm_value, pm_percent FROM t016project_monthwisecashflow where pid = ".$pid." and year='2017' order by pm_month asc";
$pdSQLResult1 = mysql_query($pdSQL1);

$pdSQL2 = "SELECT pm_cf,  pid, year, pm_month, pm_value, pm_percent FROM t016project_monthwisecashflow where pid = ".$pid." and year='2018' order by pm_month asc";
$pdSQLResult2 = mysql_query($pdSQL2);

$pdSQL3 = "SELECT pm_cf,  pid, year, pm_month, pm_value, pm_percent FROM t016project_monthwisecashflow where pid = ".$pid." and year='2019' order by pm_month asc";
$pdSQLResult3 = mysql_query($pdSQL3);

 /*$pdSQL2 = "SELECT compid, comp1, comp2 FROM t0261qaqc_comp where pid = ".$pid;
$pdSQLResult2 = mysql_query($pdSQL2);
$compdata = mysql_fetch_array($pdSQLResult2);
$comp1 = "".$compdata['comp1'];
$comp2 = "".$compdata['comp2'];*/
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
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Cash Flow Requirement</span><span style="float:right"><form action="chart1.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  

  <tr style="height:100%"><td align="center">
   <?php if($adminflag==1)
								  {
								   ?>
  <span style="text-align:right; "><form action="sp_cashflow_input.php" method="post"><input type="submit" name="add_new " id="add_new" value="Add New Record" /></form></span>
  <?php
  }
  ?>
  <div style="width:100%">
  <div style="overflow-y: scroll; height:400px; width:25%; float:left">
  <table  class="table table-bordered"  width="100%">
                              <thead>
                                <tr>
                                  <th width="7%" rowspan="3">Time from Commencement date (Month) <br/> 2016</th>
                                  <th width="30%" colspan="2">Contractor's Schedule Estimate <br/> 2016</th>
								   <?php if($adminflag==1)
								  {
								   ?>
								  <th width="30%" rowspan="3">Action</th>
								  <?php
								  }
								  ?>
                                </tr>
                                <tr>
                                  <th width="30%" colspan="2">Grand Total</th>
                                </tr>
                                <tr>
                                  <th width="10%">Amount (<?php echo $proj_cur;?>)</th>
                                  <th width="10%">(%)</th>
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { ?>
                              
                              <tr>
                          		 <td width="72"><?php echo date('M, Y',strtotime($pdData["pm_month"]));?> </td>
                                  <td align="right" valign="top"><?php echo number_format($pdData["pm_value"],0);?></td>
                                  <td align="right" valign="top">
								  <?php echo number_format($pdData["pm_percent"],2);?></td>
						    <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_cashflow_input.php?pm_cf=<?php echo $pdData['pm_cf'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="sp_cashflow.php?pm_cf=<?php echo $pdData['pm_cf'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
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
                          <td colspan="4" >No Record Found</td>
                        </tr>
						<?php
						}
						?>                       </tbody>
                        </table>
						</div>
						
						 <div style="overflow-y: scroll; height:400px;width:25%; float:left">
   
  <table  class="table table-bordered" width="100%">
                              <thead>
                                <tr>
                                  <th width="7%" rowspan="3">Time from Commencement date (Month) <br/> 2017</th>
                                  <th width="30%" colspan="2">Contractor's Schedule Estimate <br/> 2017</th>
								    <?php if($adminflag==1)
								  {
								   ?>
								  <th width="30%" rowspan="3">Action</th>
								  <?php
								  }
								  ?>
                                </tr>
                                <tr>
                                  <th width="30%" colspan="2">Grand Total</th>
                                </tr>
                                <tr>
                                  <th width="10%">Amount (<?php echo $proj_cur;?>)</th>
                                  <th width="10%">(%)</th>
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
							  if(mysql_num_rows($pdSQLResult1)>=1)
							  {
							  while($pdData1 = mysql_fetch_array($pdSQLResult1))
							  { ?>
                              
                              <tr>
                          		 <td width="72"><?php echo date('d M, Y',strtotime($pdData1["pm_month"]));?> </td>
                                  <td align="right" valign="top"><?php echo number_format($pdData1["pm_value"],0);?></td>
                                  <td align="right" valign="top">
								  <?php echo number_format($pdData1["pm_percent"],2);?></td>
						    <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_cashflow_input.php?pm_cf=<?php echo $pdData1['pm_cf'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="sp_cashflow.php?pm_cf=<?php echo $pdData1['pm_cf'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
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
                          <td colspan="4" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
        						 
                                
                                                      </tbody>
                        </table>
						
						</div>
 <div style="overflow-y: scroll; height:400px;width:25%; float:left">  
  <table  class="table table-bordered" width="100%">
                              <thead>
                                <tr>
                                  <th width="7%" rowspan="3">Time from Commencement date (Month) <br/> 2018</th>
                                  <th width="30%" colspan="2">Contractor's Schedule Estimate <br/> 2018</th>
								    <?php if($adminflag==1)
								  {
								   ?>
								  <th width="30%" rowspan="3">Action</th>
								  <?php
								  }
								  ?>
                                </tr>
                                <tr>
                                  <th width="30%" colspan="2">Grand Total</th>
                                </tr>
                                <tr>
                                  <th width="10%">Amount (<?php echo $proj_cur;?>)</th>
                                  <th width="10%">(%)</th>
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
							  if(mysql_num_rows($pdSQLResult2)>=1)
							  {
							  while($pdData2 = mysql_fetch_array($pdSQLResult2))
							  { ?>
                              
                              <tr>
                          		 <td width="72"><?php echo date('d M, Y',strtotime($pdData2["pm_month"]));?> </td>
                                  <td align="right" valign="top"><?php echo number_format($pdData2["pm_value"],0);?></td>
                                  <td align="right" valign="top">
								  <?php echo number_format($pdData2["pm_percent"],2);?></td>
						    <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_cashflow_input.php?pm_cf=<?php echo $pdData2['pm_cf'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="sp_cashflow.php?pm_cf=<?php echo $pdData2['pm_cf'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
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
                          <td colspan="4" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
        						 
                                
                                                      </tbody>
                        </table>
						</div>
<div style="overflow-y: scroll; height:400px;width:25%; float:right">  
  <table  class="table table-bordered" width="100%">
                              <thead>
                                <tr>
                                  <th width="7%" rowspan="3">Time from Commencement date (Month) <br/> 2019</th>
                                  <th width="30%" colspan="2">Contractor's Schedule Estimate <br/> 2019</th>
								    <?php if($adminflag==1)
								  {
								   ?>
								  <th width="30%" rowspan="3">Action</th>
								  <?php
								  }
								  ?>
                                </tr>
                                <tr>
                                  <th width="30%" colspan="2">Grand Total</th>
                                </tr>
                                <tr>
                                  <th width="10%">Amount (<?php echo $proj_cur;?>)</th>
                                  <th width="10%">(%)</th>
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
							  if(mysql_num_rows($pdSQLResult3)>=1)
							  {
							  while($pdData3 = mysql_fetch_array($pdSQLResult3))
							  { ?>
                              
                              <tr>
                          		 <td width="72"><?php echo date('d M, Y',strtotime($pdData3["pm_month"]));?> </td>
                                  <td align="right" valign="top"><?php echo number_format($pdData3["pm_value"],0);?></td>
                                  <td align="right" valign="top">
								  <?php echo number_format($pdData3["pm_percent"],2);?></td>
						    <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_cashflow_input.php?pm_cf=<?php echo $pdData3['pm_cf'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="sp_cashflow.php?pm_cf=<?php echo $pdData3['pm_cf'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
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
                          <td colspan="4" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
        						 
                                
                                                      </tbody>
                        </table>
						</div>                        
						</div>
						</td>
						
						
						</tr>
						</table>
						
						
  </figure>
</div>
</body>
</html>
