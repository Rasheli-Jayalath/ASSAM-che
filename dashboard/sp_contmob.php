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
	mysql_query("Delete from t0081contmob where contid=".$_REQUEST['contid']);
	}
} else {
	header("Location: index.php?msg=0");
}


//===============================================

 $pdSQL = "SELECT contid, pgid, pid, serial, type, description, comp1_foreign, comp1_local, comp2_foreign, comp2_local FROM t0081contmob where pid = ".$pid." and type in ('D', 'C') order by serial, type";
$pdSQLResult = mysql_query($pdSQL);
 

 $pdSQL1 = "SELECT contid, pgid, pid, serial, type, description, comp1_foreign, comp1_local, comp2_foreign, comp2_local FROM t0081contmob where pid = ".$pid." and type = 'E' order by serial, type";
$pdSQLResult1 = mysql_query($pdSQL1);


$pdSQL2 = "SELECT pid, comp1, comp2 FROM t002project where pid = ".$pid;
$pdSQLResult2 = mysql_query($pdSQL2);
$compdata = mysql_fetch_array($pdSQLResult2);
$comp1 = "".$compdata['comp1'];
$comp2 = "".$compdata['comp2'];



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
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Contractor's Mobilization</span><span style="float:right"><form action="chart1.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
 
  <tr style="height:100%"><td align="center">
   <?php if($adminflag==1)
								  {
								   ?>
  <span style="text-align:right; "><form action="sp_contmob_input.php" method="post"><input type="submit" name="add_new " id="add_new" value="Add New Record" /></form></span>
  <?php
  }
  ?>
 <div style="overflow-y: scroll; height:400px;">
  <table width="100%" class="table table-bordered">
                              <thead>
                                <tr>
                                  <th width="5%" rowspan="2" style="text-align:center; vertical-align:middle">S#</th>
                                  <th width="57%" rowspan="2" style="text-align:center">Description</th>
                                  <th colspan="2" style="text-align:center"><?php echo $comp1; ?></th>
                                  <th colspan="2" style="text-align:center"><?php echo $comp2; ?></th>
								  <?php if($adminflag==1)
								  {
								   ?>
                                  <th style="text-align:center">&nbsp;</th>
								  <?php
								  }
								  ?>
                                </tr>
                                <tr>
                                  <th width="7%" style="text-align:center">Foreign</th>
								  <th width="7%" style="text-align:center">Local</th>
								  <th width="7%" style="text-align:center">Foreign</th>
								  <th width="7%" style="text-align:center">Local</th>
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
<tr>
                                <td colspan="7" align="left">Personnel</td>
                                </tr>							  <?php
							  
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { ?>
                              
                              <tr>
                          <td align="center"><?php echo $pdData['serial'];?></td>
                          <td align="left"><?php echo $pdData['description'];?></td>
                          <td align="right"><?php echo number_format($pdData['comp1_foreign'],0);?></td>
                          <td align="right"><?php echo number_format($pdData['comp1_local'],0);?></td>
                          <td align="right"><?php echo number_format($pdData['comp2_foreign'],0);?></td>
                          <td align="right"><?php echo number_format($pdData['comp2_local'],0);?></td>
						    <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:left"><form action="sp_contmob_input.php?contid=<?php echo $pdData['contid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="sp_contmob.php?contid=<?php echo $pdData['contid'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
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
                                <td colspan="7" align="left">Equipment</td>
                                </tr>        						  <?php
							  
							  if(mysql_num_rows($pdSQLResult1)>=1)
							  {
							  while($pdData1 = mysql_fetch_array($pdSQLResult1))
							  { ?>
                              
                              <tr>
                          <td align="center"><?php echo $pdData1['serial'];?></td>
                          <td align="left"><?php echo $pdData1['description'];?></td>
                          <td colspan="2" align="right"><?php echo number_format($pdData1['comp1_foreign'],0);?></td>
<?php /*?>                          <td align="right"><?php echo number_format($pdData1['comp1_local'],0);?></td>
<?php */?>                          <td colspan="2" align="right"><?php echo number_format($pdData1['comp2_foreign'],0);?></td>
<?php /*?>                          <td align="right"><?php echo number_format($pdData1['comp2_local'],0);?></td>
<?php */?>	
								 <?php if($adminflag==1)
								  {
								   ?>					   
<td align="right"><span style="float:left"><form action="sp_contmob_input.php?contid=<?php echo $pdData1['contid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><span style="float:right"><form action="sp_contmob.php?contid=<?php echo $pdData1['contid'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
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
                                
                                                      </tbody>
                        </table>
						</div>
						</td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
