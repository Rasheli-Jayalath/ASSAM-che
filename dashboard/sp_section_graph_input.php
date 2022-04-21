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

if(isset($_REQUEST['update']))
{
  
			
					
				$message="";
				
				$pdSQLaa="SELECT sid, pid, sec_name, sec_no, sec_chainage, sec_length, sec_weight FROM t004sections  where pid=".$pid;
					$pdSQLResultaa = mysql_query($pdSQLaa) or die(mysql_error());
					while($sec_datae=mysql_fetch_array($pdSQLResultaa))
					{
echo $sql_pro="UPDATE t028project_section_progress_graph SET pid=$pid, sid=".$sec_datae["sid"]." ,pspg_planned=".$_POST['pspg_planned_'.$sec_datae['sid']]." , pspg_actual=".$_POST['pspg_actual_'.$sec_datae['sid']]."  where  sid=".$sec_datae["sid"];
	
		             $sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
						if ($sql_proresult == TRUE) {
						$message=  "Record updated successfully";
					} else {
						$message= mysql_error($db);
					}
					}	
header("Location: sp_section_progress.php");
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
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>
  
     Manage Section Graph

     </span><span style="float:right"><form action="sp_section_progress.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
  <?php echo $message; ?>
  <form action="sp_section_graph_input.php" target="_self" method="post" >
  <table border="1" width="100%" height="100%">
  <tr>
    <td colspan="2">
    <table width="100%"  align="center" cellpadding="0" cellspacing="0" border="0" style="border-left:1px #CCCCCC solid;border-top:1px #CCCCCC solid;">
				    <tr>
					  <td ><strong><?php echo "Section";?></strong></td>
				
					  <td align="center"><strong><?php echo "Planned %";?></strong></td>
					  <td align="center"><strong><?php echo "Actual %";?></strong></td>
	    			</tr>
                     <?php 
					
					$pdSQLa="SELECT sid, pid, sec_name, sec_no, sec_chainage, sec_length, sec_weight FROM t004sections  where pid=".$pid;
					$pdSQLResulta = mysql_query($pdSQLa) or die(mysql_error());
					while($sec_data=mysql_fetch_array($pdSQLResulta))
					{
						$pdSQL1="SELECT pspg_id, pid, sid, pspg_planned, pspg_actual, pspg_date FROM t028project_section_progress_graph  where pid = ".$pid." and  sid = ".$sec_data["sid"];
						//echo "<br/>";
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
while ($pdData1 = mysql_fetch_array($pdSQLResult1))
{?>
                     <tr>
					  <td ><strong><?php echo $sec_data["sec_name"];?></strong>
                      <input type="hidden" id="sid[]" name="sid[]" value="<?php echo $sec_data["sid"];?>" /></td>
					  <td ><input type="text" id="pspg_planned_<?php echo $sec_data["sid"];?>" 
                      name="pspg_planned_<?php echo $sec_data["sid"];?>" value="<?php echo $pdData1["pspg_planned"];?>"  /></td>
					  <td ><input type="text" id="pspg_actual_<?php echo $sec_data["sid"];?>" 
                      name="pspg_actual_<?php echo $sec_data["sid"];?>" value="<?php echo $pdData1["pspg_actual"];?>"  /></td>
	    			</tr>
                    <?php } }?>
                    
                     </table>
    </td>
    </tr>
	 <tr><td colspan="2"> 
	
     <input  type="submit" name="update" id="update" value="Update" />
	 <input  type="submit" name="cancel" id="cancel" value="Cancel" /></td></tr>
	 </table>
	  
	  
  
  
  </form> 
  </td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
