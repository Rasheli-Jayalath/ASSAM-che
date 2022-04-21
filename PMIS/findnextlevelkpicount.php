<?php //include('kfi-top-cache.php');?>
<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$objDb  = new Database( );
$parentgroup		= $_REQUEST['parentgroup'];
$div_id		= $_REQUEST['div_id'];
if($div_id==0) $level="Component";
elseif($div_id==1) $level="Sub Component ";
elseif($div_id==2) $level="Activity ";
else $level=" Sub-Activity ";
  $tempquery = "select kpiid from kpidata where parentgroup='$parentgroup' ";
				$tempresult = mysql_query($tempquery);
				 $tempcount = mysql_num_rows($tempresult);
				if($tempcount>0)
				{   $tempdata = mysql_fetch_array($tempresult);
					$parentcd=$tempdata["kpiid"];
				}
				if($parentcd!=""&&$parentcd!=0)
				{
				 $str_g_query = "select * from kpidata WHERE activitylevel=".$div_id." AND parentcd=$parentcd";
				$str_g_result = mysql_query($str_g_query);
				  $levlcount = mysql_num_rows($str_g_result);
				 if($levlcount>0)
				{   $tempdata2 = mysql_fetch_array($str_g_result);
					$parentcd2=$tempdata2["kpiid"];
				}
				if($parentcd2!=0&&$parentcd2!="")
				{
				 $str_g_query2 = "select * from kpidata WHERE  parentcd=$parentcd2";
				$str_g_result2= mysql_query($str_g_query2);
				 echo $levlcount2 = mysql_num_rows($str_g_result2);
				}
				}
?>