<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= MAINDATA;

if ($uname==null  ) {
header("Location: index.php?init=3");
} 
else if ($process_flag==0 ) {
header("Location: index.php?init=3");
}
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
$q="TRUNCATE t023project_progress_graph";
$objDb->execute($q);
$psql = "select max(pmonth) as lastProgressMonth from progressmonth";
$presult = mysql_query($psql);
$prows = mysql_fetch_array($presult);
$lastProgressMonth=$prows['lastProgressMonth'];
$pdates=$lastProgressMonth;
$count=3;
$i=0;
$planned_perc=0;
$actual_perc=0;
while($i<$count)
{
	$i++;
		$planned_perc=0;
		$actual_perc=0;
		$pdates= date('Y-m-d',strtotime("-1 MONTH", strtotime($pdates)));
		$pdates_m=date('m',strtotime($pdates));
		$pdates_y=date('Y',strtotime($pdates));
		$pdates_d=cal_days_in_month(CAL_GREGORIAN, $pdates_m, $pdates_y);
		$progress_dates=$pdates_y."-".$pdates_m."-".$pdates_d;
		///////////// Planned/////
		$tpsql = "select sum(budgetqty) as total_planned from planned";
		$tpresult = mysql_query($tpsql);
		$tprows = mysql_fetch_array($tpresult);
		$total_planned=$tprows['total_planned'];
		///////////////////////////////////////
		$mpsql = "select sum(budgetqty) as monthly_planned from planned where budgetdate='$progress_dates'";
		$mpresult = mysql_query($mpsql);
		$mprows = mysql_fetch_array($mpresult);
		$monthly_planned=$mprows['monthly_planned'];
		///////////////////////////////////////
		$apsql = "select sum(progressqty) as monthly_actual from progress where progressdate='$progress_dates'";
		$apresult = mysql_query($apsql);
		$aprows = mysql_fetch_array($apresult);
		$monthly_actual=$aprows['monthly_actual'];
		if($total_planned!=0)
		{
		$planned_perc=number_format(($monthly_planned/$total_planned*100),2);
		$actual_perc=number_format(($monthly_actual/$total_planned*100),2);
		}
		else
		{
			$planned_perc=0;
			$actual_perc=0;
			
		}
		 $qq="INSERT INTO t023project_progress_graph(pid,planned,actual,ppg_date) VALUES ('1','$planned_perc', '$actual_perc','$progress_dates')";
		$objDb->execute($qq);
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>

<!--<link rel="stylesheet" type="text/css" href="css/style.css">-->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  
 <?php /*?> <link rel="stylesheet" type="text/css" media="all" href="calender/calendar-win2k-cold-1.css" title="win2k-cold-1" />
  <script type="text/javascript" src="calender/calendar.js"></script>
  <script type="text/javascript" src="calender/lang/calendar-en.js"></script>
  <script type="text/javascript" src="calender/calendar-setup.js"></script><?php */?>
  <script type="text/javascript" src="scripts/JsCommon.js"></script>


<style type="text/css">
<!--
.style1 {color: #3C804D;
font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:18px;
	font-weight:bold;
	text-align:center;}
-->
</style>
<style type="text/css"> 
.imgA1 { position:absolute;  z-index: 3; } 
.imgB1 { position:relative;  z-index: 3;
float:right;
padding:10px 10px 0 0; } 
</style> 


<style type="text/css"> 
.msg_list {
	margin: 0px;
	padding: 0px;
	width: 100%;
}
.msg_head {
	position: relative;
    display: inline-block;
	cursor:pointer;
   /* border-bottom: 1px dotted black;*/

}
.msg_head .tooltiptext {
	cursor:pointer;
    visibility: hidden;
    width: 80px;
    background-color: gray;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}

.msg_head:hover .tooltiptext {
    visibility: visible;
}
.msg_body{
	padding: 5px 10px 15px;
	background-color:#F4F4F8;
}
</style>

</head>
<body>
<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
<h1> Process Panel</h1>

		<div style="margin-bottom:12px;">
		<!--<a class="button" href="javascript:void(null);" onclick="window.open('calculate_factor.php','Calculate Factor','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Calculate Factor</a>-->
		 <a class="button" href="javascript:void(null);" onclick="window.open('basetable.php', 'Planned Data','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Base Data</a>
          <a class="button" href="javascript:void(null);" onclick="window.open('loadplanned.php', 'Planned Data','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Planned Data</a>
		  <a class="button" href="javascript:void(null);" onclick="window.open('mildatamakerdc.php', 'Data Making','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >Data Making</a>
           <a class="button" href="javascript:void(null);" onclick="window.open('pmis.php', 'Data Making','width=670px,height=550px,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');" >KPI Data Process</a>		
          </div>
		


</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
