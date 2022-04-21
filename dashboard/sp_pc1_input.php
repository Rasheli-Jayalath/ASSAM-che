<?php
session_start();
$pid = $_SESSION['pid'];
$_SESSION['mode'] = 0;
if($_SESSION['adminflag']!=1)
{
header("Location: chart1.php");
}
include_once("connect.php");
include_once("functions.php");
//===============================================

if(isset($_REQUEST['save']))
{
	
	$item_id=$_REQUEST['item_id'];
	$description=$_REQUEST['description'];
	$price=$_REQUEST['price'];
	$f1=$_REQUEST['f1'];
	$f2=$_REQUEST['f2'];
	$f3=$_REQUEST['f3'];
	$display_order=$_REQUEST['display_order'];
	$message="";
	$pgid=1;
$sql_pro=mysql_query("INSERT INTO t0071pc1summary (pid,item_id,description, price,f1,f2,f3,display_order) Values(".$pid.",'".$item_id."', '".$description."','".$price."', '".$f1."' , '".$f2."' , '".$f3."' , '".$display_order."' )");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
} else {
    $message= mysql_error($db);
}
	
	$item_id='';
	$description='';
	$price='';
	$f1='';
	$f2='';
	$f3='';
	$display_order='';
}

if(isset($_REQUEST['update']))
{
	$pc1_id=$_REQUEST['pc1_id'];
	$item_id=$_REQUEST['item_id'];
	$description=$_REQUEST['description'];
	$price=$_REQUEST['price'];
	$f1=$_REQUEST['f1'];
	$f2=$_REQUEST['f2'];
	$f3=$_REQUEST['f3'];
	$display_order=$_REQUEST['display_order'];
	$message="";
	$pgid=1;
	
$sql_pro="UPDATE t0071pc1summary SET item_id='$item_id', description='$description', price='$price', f1='$f1', f2='$f2', f3='$f3', display_order=$display_order where pc1_id=$pc1_id";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
	if ($sql_proresult == TRUE) {
    $message=  "Record updated successfully";
} else {
    $message= mysql_error($db);
}
	
//	$item_id='';
//	$description='';
//	$price='';
//	$display_order='';
	
header("Location: sp_pc1.php");
}
if(isset($_REQUEST['pc1_id']))
{
$pc1_id=$_REQUEST['pc1_id'];

$pdSQL1="SELECT pc1_id, pid, item_id, description, price, f1, f2, f3 ,display_order FROM t0071pc1summary  where pid = ".$pid." and  pc1_id = ".$pc1_id;

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$item_id = $pdData1['item_id'];
	$description = $pdData1['description'];
	$price = $pdData1['price'];
	$f1 = $pdData1['f1'];
	$f2 = $pdData1['f2'];
	$f3 = $pdData1['f3'];
	$display_order = $pdData1['display_order'];
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
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>PC1 Summary</span><span style="float:right"><form action="sp_pc1.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_pc1_input.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <tr><td><label>Item ID:</label></td><td><input  type="text" name="item_id" id="item_id" value="<?php echo $item_id; ?>" /></td></tr>
  
    <tr><td><label>Description:</label></td><td><input  type="text" name="description" id="description" value="<?php echo $description; ?>" /></td></tr>
      <tr><td><label>IBRD: (<?php echo $proj_cur;?>)</label></td><td><input  type="text" name="f1" id="f1" value="<?php echo $f1; ?>" /></td></tr>
        <tr><td><label>IDA: (<?php echo $proj_cur;?>)</label></td><td><input  type="text" name="f2" id="f2" value="<?php echo $f2; ?>" /></td></tr>
          <tr><td><label>WAPDA/GOP: (<?php echo $proj_cur;?>)</label></td><td><input  type="text" name="f3" id="f3" value="<?php echo $f3; ?>" /></td></tr>
   
     <tr><td><label>Price: (<?php echo $proj_cur;?>)</label></td><td><input  type="text" name="price" id="price" value="<?php echo $price; ?>" /></td></tr>
	
	  <tr><td><label>Display Order:</label></td><td><input  type="text" name="display_order" id="display_order" value="<?php echo $display_order; ?>" /></td></tr>
	 
	  
	 <tr><td colspan="2"> <?php if(isset($_REQUEST['pc1_id']))
	 {
		 
	 ?>
     <input type="hidden" name="pc1_id" id="pc1_id" value="<?php echo $_REQUEST['pc1_id']; ?>" />
     <input  type="submit" name="update" id="update" value="Update" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="Save" />
	 <?php
	 }
	 ?> <input  type="submit" name="cancel" id="cancel" value="Cancel" /></td></tr>
	 </table>
	  
	  
  
  
  </form> 
  </td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
