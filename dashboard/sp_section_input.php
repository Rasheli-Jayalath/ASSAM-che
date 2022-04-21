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
	
					$sec_name=$_REQUEST['sec_name'];
					$sql_sec=mysql_query("INSERT INTO t004sections(pid, sec_name) 
					VALUES (".$pid.", '".$sec_name."' )");
					if($sql_sec==TRUE)
					{
						echo $sid = mysql_insert_id();
					}
					$message="";
					$pgid=1;
					$pdSQLaa="SELECT act_id, act_name, act_weight, act_order FROM t011activities  ";
					$pdSQLResultaa = mysql_query($pdSQLaa) or die(mysql_error());
					while($act_datae=mysql_fetch_array($pdSQLResultaa))
					{


$sql_pro=mysql_query("INSERT INTO t025project_section_progress_table(pid, sid, act_id, pspt_planned, pspt_actual) 
VALUES (".$pid.",".$sid.", '". $act_datae["act_id"]."',".$_POST['pspt_planned_'.$act_datae['act_id']].",".$_POST['pspt_actual_'.$act_datae['act_id']].")");
				if ($sql_pro == TRUE) 
				{
    			$message=  "New record added successfully";
					
				header("Location: sp_section_progress.php");
				} 
				else 
				{
    			$message= mysql_error($db);
				}
	
					}
	
}

if(isset($_REQUEST['update']))
{
   $sec_name=$_REQUEST['sec_name'];
	$sid=$_REQUEST["sid"];
	
					$sql_sec=mysql_query("Update t004sections SET sec_name='$sec_name' where sid=$sid");
					
				$message="";
				
				$pdSQLaa="SELECT act_id, act_name, act_weight, act_order FROM t011activities  ";
					$pdSQLResultaa = mysql_query($pdSQLaa) or die(mysql_error());
					while($act_datae=mysql_fetch_array($pdSQLResultaa))
					{
 $sql_pro="UPDATE t025project_section_progress_table SET pid=$pid,sid=$sid,act_id=".$act_datae["act_id"]." ,pspt_planned=".$_POST['pspt_planned_'.$act_datae['act_id']]." , pspt_actual=".$_POST['pspt_actual_'.$act_datae['act_id']]."  where sid=$sid AND act_id=".$act_datae["act_id"];
	
		             $sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
						if ($sql_proresult == TRUE) {
						$message=  "Record updated successfully";
					} else {
						$message= mysql_error($db);
					}
					}

	
header("Location: sp_section_progress.php");
}
if(isset($_REQUEST['pspt_id']))
{
$pspt_id=$_REQUEST['pspt_id'];

/*$pdSQL1="SELECT pspt_id, pid, sid, act_id, pspt_planned, pspt_actual, pspt_date FROM t025project_section_progress_table  where pid = ".$pid." and  pspt_id = ".$pspt_id;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);*/

}
if(isset($_REQUEST['sid']))
{
$sid=$_REQUEST['sid'];

$pdSQL1="SELECT  sid, pid, sec_name, sec_no, sec_chainage, sec_length, sec_weight FROM t004sections where sid = ".$sid;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

	$sec_name=$pdData1['sec_name'];
	
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
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Add New Section</span><span style="float:right"><form action="sp_section_progress.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_section_input.php?sid=<?php echo $_REQUEST["sid"];?>" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <tr><td><label>Section Name:</label></td><td><input  type="text" name="sec_name" id="sec_name" value="<?php echo $sec_name; ?>" /></td></tr>
  <?php /*?>
    <tr><td><label>Month</label></td><td><input  type="text" name="pspt_date" id="pspt_date" value="<?php echo $pspt_date; ?>" />(yyyy-mm-dd)</td></tr><?php */?>
    <tr>
    <td colspan="2">
    <table width="100%"  align="center" cellpadding="0" cellspacing="0" border="0" style="border-left:1px #CCCCCC solid;border-top:1px #CCCCCC solid;">
				    <tr>
					  <td ><strong><?php echo "Activity";?></strong></td>
				
					  <td align="center"><strong><?php echo "Planned %";?></strong></td>
					  <td align="center"><strong><?php echo "Actual %";?></strong></td>
	    			</tr>
                     <?php 
					 if(isset($_REQUEST['sid']) && !empty($_REQUEST['sid']))
					 {
					
					$act_id=$_REQUEST['sid'];
					$pdSQLa="SELECT act_id, act_name, act_weight, act_order FROM t011activities";
					$pdSQLResulta = mysql_query($pdSQLa) or die(mysql_error());
					while($act_datae=mysql_fetch_array($pdSQLResulta))
					{
					$pdSQL2="SELECT pspt_id, pid, sid, act_id, pspt_planned, pspt_actual, pspt_date FROM t025project_section_progress_table  						
					where act_id= ".$act_datae["act_id"]." and  sid = ".$sid;
					$pdSQLResult2 = mysql_query($pdSQL2) or die(mysql_error());
					$pdData2 = mysql_fetch_array($pdSQLResult2);
						?>
                     <input type="hidden" id="pspt_id" name="pspt_id" value="<?php echo $pspt_id;?>" />
                     <input type="hidden" id="act_id" name="act_id" value="<?php echo $act_id;?>" />
                     <tr>
					  <td ><strong><?php echo $act_datae["act_name"];?></strong>
                      </td>
					  <td ><input type="text" id="pspt_planned_<?php echo $act_datae["act_id"];?>" 
                      name="pspt_planned_<?php echo $act_datae["act_id"];?>" value="<?php echo $pdData2["pspt_planned"] ;?>"  /></td>
					  <td ><input type="text" id="pspt_actual_<?php echo $act_datae["act_id"];?>" 
                      name="pspt_actual_<?php echo $act_datae["act_id"];?>" value="<?php echo $pdData2["pspt_actual"] ;?>"  /></td>
	    			</tr>
                    <?php }?>
					 <?php 
					 }
					 else
					 {
					
					$pdSQLa="SELECT act_id, act_name, act_weight, act_order FROM t011activities";
					$pdSQLResulta = mysql_query($pdSQLa) or die(mysql_error());
					while($act_data=mysql_fetch_array($pdSQLResulta))
					{?>
                     <tr>
					  <td ><strong><?php echo $act_data["act_name"];?></strong>
                      <input type="hidden" id="act_id[]" name="act_id[]" value="<?php echo $act_data["act_id"];?>" /></td>
					  <td ><input type="text" id="pspt_planned_<?php echo $act_data["act_id"];?>" 
                      name="pspt_planned_<?php echo $act_data["act_id"];?>" value="<?php echo $pspt_planned ;?>"  /></td>
					  <td ><input type="text" id="pspt_actual_<?php echo $act_data["act_id"];?>" 
                      name="pspt_actual_<?php echo $act_data["act_id"];?>" value="<?php echo $pspt_actual ;?>"  /></td>
	    			</tr>
                    <?php }?>
                    <?php }?>
                     </table>
    </td>
    </tr>
	 <tr><td colspan="2"> 
	 <?php if(isset($_REQUEST['sid']))
	 {
	 ?>
     <input type="hidden" name="pspt_id" id="pspt_id" value="<?php echo $_REQUEST['pspt_id']; ?>" />
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
