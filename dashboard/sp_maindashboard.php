<?php
session_start();
$adminflag=$_SESSION['adminflag'];
if ($adminflag == 1 || $adminflag == 2) {
if (isset($_REQUEST['select'])) {
	$pid = $_REQUEST['pid'];
	$sridlist = $_SESSION['sridlist'];
	$srid = array_search($_REQUEST['srid'], $sridlist);
	$_SESSION['pid'] = $pid;
	$_SESSION['srid'] = $srid;
	$_SESSION['mode'] = 0;
	header("Location: chart1.php?back=1");
} else {
	$pid = $_SESSION['pid'];
	$_SESSION['mode'] = 0;
}
include_once("connect.php");
include_once("functions.php");
$nsrid_arra1y=array();

//===============================================
/*if(isset($_REQUEST['delete']))
{

mysql_query("Update t002project SET proj_status=2 where pid=".$_REQUEST['pid']);
}*/

if(isset($_REQUEST['reorder']))
{
	$reorder = 1;
}

if(isset($_REQUEST['saveorder']))
{
	$reorder = 0;	
	$message="";
	$count = count($_POST['pid_s']);
	$nsrid_array=$_POST['nsrid'];
	
	foreach($nsrid_array as $k => $v) {
    if ($v == 0) {
    	unset($nsrid_array[$k]);
    }
	}
		
	$nsrid_arra1y= array_unique( array_diff_assoc( $nsrid_array, array_unique( $nsrid_array ) ) );
	 print_r($nsrid_arra1y);
	$count_duplicate=count($nsrid_arra1y);
	
	if($count_duplicate>=1)
	{
	$reorder = 1;
	$message=  "Duplicate order number is not allowed";
	$reprint=1;
	}
	else
	{
	for($i=0;$i<$count;$i++)
	{	
	$nsrid_order=$_POST['nsrid'][$i];
	$pid=$_POST['pid_s'][$i];
	
	
	
	$sql = "update t002project set srid='$nsrid_order' where pid = '$pid'";
	$result = mysql_query($sql);
	
	
	}
	}
	
	

	
	
}


 $pdSQL = "SELECT a.pid, a.pgid, a.srid, a.proj_name FROM (SELECT pid, pgid, srid, proj_name FROM t002project where srid <> 0 order by srid ) a UNION SELECT pid, pgid, srid, proj_name FROM t002project where srid = 0";
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
<SCRIPT language=Javascript>
       <!--
       function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
       //-->
    </SCRIPT>
</head>

<body>
<div class="top-box-set" style="margin-top:10px">
<h1 align="center" style="background-color:<?php echo pcolor($pid); ?> "><?php echo proj_name($pid); ?></h1>
 
<?php if ($mode == 1) { ?>
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
  <figure class="sub_boxM">
  <table style="width:100%; height:100%">
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Projects List</span><span style="float:right">
  <form action="chart1.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
 
  <tr style="height:100%"><td align="left" style="padding:0; margin:0; background-color:#FFF">
   <?php if($adminflag==1)
								  {
								   ?>
<span style="text-align:right;">
  <form action="sp_maindashboard_input.php" method="post"><input type="submit" name="add_new " id="add_new" value="Add New Record" /></form> </span>
  
  <span style="text-align:right; ">
  <form action="sp_maindashboard.php" method="post" >
 <span style="text-align:left; color:red"> <?php echo $message; ?></span>
  <?php if ($reorder == 1) { ?><input type="submit" name="saveorder" id="saveorder" value="Save Order" /><?php } else {?><input type="submit" name="reorder" id="reorder" value="Re-Order" /><?php } ?>
 <?php } ?>
 
   <div class="MainDiv" >
  <div style="overflow-y: scroll; height:485px;">
  <table width="46%" class="table table-bordered" align="right">
                              <thead>
                                <tr>
                                  <th width="5%" style="text-align:center; vertical-align:middle">S#</th>
                                  <?php if ($reorder == 1) { ?> 
                                  <th width="5%" style="text-align:center; vertical-align:middle">Order</th>
                                  <?php } ?>
                                  <th width="70%" style="text-align:center">Project Name</th>
								  <th width="25%" colspan="2" style="text-align:center">Action</th>
								  
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  $j=0;
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  {
							
							   ?>
                        <tr style="color:<?php echo(array_key_exists($j, $nsrid_arra1y)== true ? "red" : "black");?>">
                          <td align="center"><?php echo $pdData['srid'];?></td>
                          <?php if ($reorder == 1) { ?> 
                          <td align="center"><input type="hidden" name="pid_s[]" id="pid_s[]" value="<?php echo $pdData['pid'] ?>" /><input type="text" name="nsrid[]" id="nsrid[]" value="<?php echo ($reprint==1 ? $nsrid_array[$j] : $pdData['srid']); $j=$j+1;  
						   ?>" style="width:30px;" onkeypress="return isNumberKey(event)"  /></td>
                          <?php } ?>
                          <td align="left"><?php echo $pdData['proj_name'];?></td>
						   <td align="right">
						   <form action="sp_maindashboard.php" method="post"><input type="hidden" name="pid" id="pid" value="<?php echo $pdData['pid'] ?>" /><input type="hidden" name="srid" id="srid" value="<?php echo $pdData['srid'] ?>" /><input type="submit" name="select" id="select" value="Select" <?php if ($pdData['srid'] == NULL || $pdData['srid'] == '' || $pdData['srid'] == 0) {echo 'disabled="disabled"';} ?> /></form>
						   </td>
						    <?php if($adminflag==1)
								  {
								   ?>
						   <td align="right"><span style="float:right"><form action="sp_maindashboard_input.php?pid=<?php echo $pdData['pid'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span><!--<span style="float:right"><form action="sp_maindashboard.php?pid=<?php //echo $pdData['pid'] ?>" method="post"><input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span>--></td>
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
                        </table></div>
                        </div>
						<?php if($adminflag==1)
								  {
								   ?>
						</form>
  </span>
<?php
}
?>
                        </td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
