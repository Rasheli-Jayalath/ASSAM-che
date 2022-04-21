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
mysql_query("Delete from t0261qaqc where qaqcid=".$_REQUEST['qaqcid']);
}

//===============================================

 $pdSQL = "SELECT qaqcid, pgid, pid, serial, description, type, test, comp1, comp2, total FROM t0261qaqc where pid = ".$pid." and type = 'QC' order by serial";
$pdSQLResult = mysql_query($pdSQL);

 $pdSQL1 = "SELECT qaqcid, pgid, pid, serial, description, type, test, comp1, comp2, total FROM t0261qaqc where pid = ".$pid." and type = 'QA' order by serial";
$pdSQLResult1 = mysql_query($pdSQL1);
 
/* $pdSQL2 = "SELECT compid, comp1, comp2 FROM t0261qaqc_comp where pid = ".$pid;
$pdSQLResult2 = mysql_query($pdSQL2);
$compdata = mysql_fetch_array($pdSQLResult2);
$comp1 = "".$compdata['comp1'];
$comp2 = "".$compdata['comp2'];*/

$pdSQL2 = "SELECT pid, comp1, comp2 FROM t002project where pid = ".$pid;
$pdSQLResult2 = mysql_query($pdSQL2);
$compdata = mysql_fetch_array($pdSQLResult2);
$comp1 = "".$compdata['comp1'];
$comp2 = "".$compdata['comp2'];
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
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>QA/QC Tests</span><span style="float:right"><form action="chart1.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
 
  <tr style="height:100%"><td align="center">
  <?php if($adminflag==1)
								  {
								   ?>
  <span style="text-align:right; "><form action="sp_qaqc_input.php" method="post"><input type="submit" name="add_new " id="add_new" value="Add New Record" /></form></span>
  <?php
  }
  ?>
 <div style="overflow-y: scroll; height:400px;">
  <table width="100%" class="table table-bordered">
                              <thead>
                                <tr>
                                  <th width="5%" rowspan="2" style="text-align:center; vertical-align:middle">S#</th>
                                  <th width="65%" rowspan="2" style="text-align:center">Description</th>
                                  <th width="5%" rowspan="2" style="text-align:center">Test</th>
                                  <th colspan="2" style="text-align:center">Nos.</th>
                                  <th width="5%" rowspan="2" style="text-align:center">Total</th>
								  <?php if($adminflag==1)
								  {
								   ?>
                                  <th width="10%" rowspan="2" style="text-align:center">Action</th>
								  <?php
								  }
								  ?>
                                </tr>
                                <tr>
                                  <th width="5%" style="text-align:center"><?php echo $comp1; ?></th>
								  <th width="5%" style="text-align:center"><?php echo $comp2; ?></th>
								  </tr>
                              </thead>
                              <tbody>
<tr>
                                <td colspan="7" align="left">Quality Control (QC)</td>
                                </tr>							  <?php
								
								$qccomp1tot = 0;
								$qccomp2tot = 0;
								$qctotaltot = 0;							  
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { ?>
                              
                              <tr>
                          <td align="center"><?php echo $pdData['serial'];?></td>
                          <td align="left"><?php echo $pdData['description'];?></td>
                          <td align="right"><?php echo $pdData['test'];?></td>
                          <td align="right"><?php echo number_format($pdData['comp1'],2); $qccomp1tot = $qccomp1tot + $pdData['comp1']; ?></td>
                          <td align="right"><?php echo number_format($pdData['comp2'],2); $qccomp2tot = $qccomp2tot + $pdData['comp2'];?></td>
                          <td align="right"><?php echo number_format($pdData['total'],2); $qctotaltot = $qctotaltot + $pdData['total'];?></td>
						   <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_qaqc_input.php?qaqcid=<?php echo $pdData['qaqcid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="sp_qaqc.php?qaqcid=<?php echo $pdData['qaqcid'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
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
                          <td colspan="7" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
                            
<tr>
                                <td colspan="3" align="right">Total;</td>
                                <td align="right"><?php echo number_format($qccomp1tot,2); ?></td>
                                <td align="right"><?php echo number_format($qccomp2tot,2); ?></td>
                                <td align="right"><?php echo number_format($qctotaltot,2); ?></td>
								 <?php if($adminflag==1)
								  {
								   ?>
                                <td align="right">&nbsp;</td>
								<?php
								}
								?>
                              </tr>
<tr>
                                <td colspan="7" align="left">Quality Assurance (QA)</td>
                                </tr>							  <?php
								$qacomp1tot = 0;
								$qacomp2tot = 0;
								$qatotaltot = 0;							  
							  if(mysql_num_rows($pdSQLResult1)>=1)
							  {
							  while($pdData1 = mysql_fetch_array($pdSQLResult1))
							  { ?>
                              
                              <tr>
                          <td align="center"><?php echo $pdData1['serial'];?></td>
                          <td align="left"><?php echo $pdData1['description'];?></td>
                          <td align="right"><?php echo $pdData1['test'];?></td>
                          <td align="right"><?php echo number_format($pdData1['comp1'],2); $qacomp1tot = $qacomp1tot + $pdData1['comp1'];?></td>
                          <td align="right"><?php echo number_format($pdData1['comp2'],2); $qacomp2tot = $qacomp2tot + $pdData1['comp2'];?></td>
                          <td align="right"><?php echo number_format($pdData1['total'],2); $qatotaltot = $qatotaltot + $pdData1['total'];?></td>
						  
						  <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_qaqc_input.php?qaqcid=<?php echo $pdData1['qaqcid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="sp_qaqc.php?qaqcid=<?php echo $pdData1['qaqcid'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
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
                          <td colspan="7" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
<tr>
                                <td colspan="3" align="right">Total;</td>
                                <td align="right"><?php echo number_format($qacomp1tot,2); ?></td>
                                <td align="right"><?php echo number_format($qacomp2tot,2); ?></td>
                                <td align="right"><?php echo number_format($qatotaltot,2); ?></td>
								<?php if($adminflag==1)
								  {
								   ?>
                                <td align="right">&nbsp;</td>
								<?php
								}
								?>
                              </tr>



                              </tbody>
                        </table>
						</div>
					
						</td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
